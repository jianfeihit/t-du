
var Login = function(dom) {
  this.dialog = dom;
  this.user_input_hint = "";
  this.verify_input_hint = "";
  this.callback = null;
};
Login.prototype = {
  user: function() {
    return this.dialog.find("input[name=user]");
  },
  focus_user: function() {
    this.user().addClass("currentIn");
    this.user_error("");
    if (this.user().val() == this.user_input_hint) {
      this.user().val("");
    }
  },
  blur_user: function() {
    this.user().removeClass("currentIn");
    this.check_user();
    if ($.trim(this.user().val()) == "") {
      this.user().val(this.user_input_hint);
    }
  },
  check_user: function() {
    var val = $.trim(this.user().val());
    if (val == "" || val == this.user_input_hint) {
      this.user_error("请输入用户名或邮箱");
      return false;
    }
    this.user_error("");
    return true;
  },
  user_error: function(error) {
    this.user().siblings("em").text(error);
  },
  pwd: function() {
    return this.dialog.find("input[name=pwd]");
  },
  focus_pwd: function() {
    this.pwd().addClass("currentIn");
    this.pwd_error("");
  },
  blur_pwd: function() {
    this.pwd().removeClass("currentIn");
    this.check_pwd();
  },
  check_pwd: function() {
    if (this.pwd().val() == "") {
      this.pwd_error("请输入登录密码");
      return false;
    }
    this.pwd_error("");
    return true;
  },
  pwd_error: function(error) {
    this.pwd().siblings("em").text(error);
  },
  verify: function() {
    return this.dialog.find("input[name=verify_code]");
  },
  focus_verify: function() {
    this.verify().addClass("currentIn");
    this.verify_error("");
    if (this.verify().val() == this.verify_input_hint) {
      this.verify().val("");
    }
  },
  blur_verify: function() {
    this.verify().removeClass("currentIn");
    this.check_verify();
    if ($.trim(this.verify().val()) == "") {
      this.verify().val(this.verify_input_hint);
    }
  },
  check_verify: function() {
    if (!this.verify().is(":visible")) return true;
    var val = $.trim(this.verify().val());
    if (val == "" || val == this.verify_input_hint) {
      this.verify_error("请输入验证码");
      return false;
    }
    this.verify_error("");
    return true;
  },
  verify_error: function(error) {
    this.verify().siblings("em").text(error);
  },
  commit_but: function() {
    return this.dialog.find(".loginb");
  },
  newverify_link: function() {
    return this.dialog.find("#newverify");
  },
  set_verify_code: function() {
    var url = "/commons/verify_image?date=" + (new Date()).valueOf();
    this.verify().siblings("img").attr("src", url);
    this.verify().parent().show();
    this.verify().parent().prev().show();
    this.verify().val(this.verify_input_hint);
  },
  autologin_checkbox: function() {
    return this.dialog.find("input[name=auto_login]");
  },
  forward_input: function() {
    return this.dialog.find("input[name=forward]");
  },
  forgotpwd_link: function() {
    return this.dialog.find("#forgotpwd");
  },
  set_login_callback: function(callback) {
    this.callback = callback;
  },
  init: function() {
    // default hint
    this.user_input_hint = this.user().val();
    this.verify_input_hint = this.verify().val();

    // bind event
    var _this = this;
    this.user().focus($.proxy(this, "focus_user"));
    this.user().blur($.proxy(this, "blur_user"));
    this.user().keydown(function(e) {
      if (e.which == 13) _this.commit()
    });
    this.pwd().focus($.proxy(this, "focus_pwd"));
    this.pwd().blur($.proxy(this, "blur_pwd"));
    this.pwd().keydown(function(e) {
      if (e.which == 13) _this.commit()
    });
    this.verify().focus($.proxy(this, "focus_verify"));
    this.verify().blur($.proxy(this, "blur_verify"));
    this.verify().keydown(function(e) {
      if (e.which == 13) _this.commit()
    });
    this.commit_but().click(function(e) {
      e.preventDefault();
      _this.commit();
    });
    this.newverify_link().click(function(e) {
      e.preventDefault();
      _this.set_verify_code();
    });
    this.forgotpwd_link().click(function(e) {
      e.preventDefault();
      _this.retrieve_password($(this).attr("href"));
    });
  },
  all_check: function() {
    var rt = this.check_user();
    rt = this.check_pwd() && rt;
    rt = this.check_verify() && rt;
    return rt;
  },
  commit: function() {
    var _this = this;
    if (!this.all_check()) return;
    var data = {
      "user": this.user().val(),
      "pwd": this.pwd().val(),
      "verify_code": this.verify().val()
    };
    if (this.autologin_checkbox().attr("checked")) {
      data['auto_login'] = this.autologin_checkbox().val();
    }
    if (this.forward_input().val() != undefined) {
      data['forward'] = this.forward_input().val();
    }
    var url = "/users/login_service";
    $.ajax({
      url: url,
      data: data,
      type: 'post',
      async: true,
      dataType: 'json',
      success: function(r) {
        if (r.rt) {
          if (_this.callback != null) {
            _this.callback(r);
          } else {
            if (typeof(r.forward) != "undefined") window.location = r.forward;
            else window.location = "/";
          }
        } else {
          if (typeof(r.show_verify) != "undefined" && r.show_verify) {
            _this.set_verify_code();
          }
          if (typeof(r.verify) != "undefined") _this.verify_error(r.verify);
          if (typeof(r.pwd) != "undefined") _this.pwd_error(r.pwd);
          if (typeof(r.user) != "undefined") _this.user_error(r.user);
        }
      }
    });
  },
  retrieve_password: function(link) {
    if (!this.check_user()) return;
    var url = "/users/check_exist/username_email";
    var data = {
      "item": this.user().val()
    };
    $.ajax({
      url: url,
      data: data,
      type: 'post',
      async: false,
      dataType: 'json',
      success: function(r) {
        if (r.rt) {
          window.location = link + data.item;
        } else {
        // TODO
        }
      }
    });
  }
};

var Register = function(dom) {
  this.wr = "/";
  this.dialog = dom;
  this.username_input_hint = "";
  this.pwd_input_hint = "";
  this.callback = null;
};
Register.prototype = {
  email: function() {
    return this.dialog.find("input[name=email]");
  },
  focus_email: function() {
    this.email().addClass("currentIn");
    this.email_error("");
  },
  blur_email: function() {
    this.email().removeClass("currentIn");
    this.check_email(true);
  },
  check_email: function(dup_check) {
    var val = $.trim(this.email().val());
    if (val == "") {
      this.email_error("请输入注册邮箱");
      return false;
    }
    var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i;
    if (!reg.test(val)) {
      this.email_error("请输入有效的邮箱地址");
      return false;
    }

    // dup
    if (dup_check) {
      var _this = this;
      $.ajax({
        url: this.wr + "users/check_exist/email/",
        data: {
          'email': val
        },
        dataType: 'json',
        type: 'post',
        async: true,
        success: function(r){
          if (r.rt) {
            _this.email_error("该邮箱地址已经被使用");
          }
        },
        error: function(jqXHR, textStatus) {
        }
      });
    } else {
      if (this.email_error() != "") {
        return false;
      }
    }
    this.email_error("");
    return true;
  },
  email_error: function(error) {
    if (arguments.length > 0) {
      this.email().siblings("em").text(error);
    }
    return this.email().siblings("em").text();
  },
  user: function() {
    return this.dialog.find("input[name=username]");
  },
  focus_user: function() {
    this.user().addClass("currentIn");
    this.user_error("");
    if (this.user().val() == this.username_input_hint) {
      this.user().val("");
    }
  },
  blur_user: function() {
    this.user().removeClass("currentIn");
    this.check_user(true);
    if ($.trim(this.user().val()) == "") {
      this.user().val(this.username_input_hint);
    }
  },
  check_user: function(dup_check) {
    var val = $.trim(this.user().val());
    if (val == "" || val == this.username_input_hint) {
      this.user_error("请输入用户名");
      return false;
    }
    var reg = /^[\(\)\.\ \_\-\'\"0-9a-zA-Z\u4e00-\u9fa5]{2,30}$/i;
    if (!reg.test(val)) {
      this.user_error(this.username_input_hint);
      return false;
    }

    // dup
    if (dup_check) {
      var _this = this;
      $.ajax({
        url: this.wr + "users/check_exist/username/",
        data: {
          'username': val
        },
        dataType: 'json',
        type: 'post',
        async: true,
        success: function(r){
          if (r.rt) {
            _this.user_error("该用户名已经被使用");
          }
        },
        error: function(jqXHR, textStatus) {
        }
      });
    } else {
      if (this.user_error() != "") {
        return false;
      }
    }
    this.user_error("");
    return true;
  },
  user_error: function(error) {
    if (arguments.length > 0) {
      this.user().siblings("em").text(error);
    }
    return this.user().siblings("em").text();
  },
  pwd: function() {
    return this.dialog.find("input[name=pwd]");
  },
  focus_pwd: function() {
    this.pwd().addClass("currentIn");
    this.pwd_error("");
    if (this.pwd().val() == this.pwd_input_hint) {
      this.pwd().val("");
    }
  },
  blur_pwd: function() {
    this.pwd().removeClass("currentIn");
    this.check_pwd();
  //    if ($.trim(this.pwd().val()) == "") {
  //      this.pwd().val(this.pwd_input_hint);
  //    }
  },
  check_pwd: function() {
    var val = this.pwd().val();
    if (val == "") {
      this.pwd_error("请输入登录密码");
      return false;
    }
    if (val.length < 6) {
      this.pwd_error(this.pwd_input_hint);
      return false;
    }
    this.pwd_error("");
    return true;
  },
  pwd_error: function(error) {
    this.pwd().siblings("em").text(error);
  },
  repwd: function() {
    return this.dialog.find("input[name=repwd]");
  },
  focus_repwd: function() {
    this.repwd().addClass("currentIn");
    this.repwd_error("");
  },
  blur_repwd: function() {
    this.repwd().removeClass("currentIn");
    this.check_repwd();
  },
  check_repwd: function() {
    var val = this.repwd().val();
    if (val == "") {
      this.repwd_error("请确认登录密码");
      return false;
    }
    if (val != this.pwd().val()) {
      this.repwd_error("两次输入的密码不一致");
      return false;
    }
    this.repwd_error("");
    return true;
  },
  repwd_error: function(error) {
    this.repwd().siblings("em").text(error);
  },
  invite: function() {
    return this.dialog.find("input[name=invite]");
  },
  focus_invite: function() {
    this.invite().addClass("currentIn");
    this.invite_error("");
  },
  blur_invite: function() {
    this.invite().removeClass("currentIn");
    this.check_invite();
  },
  check_invite: function() {
    var val = $.trim(this.invite().val());
    if (val == "") {
      this.invite_error("请输入邀请码");
      return false;
    }
    this.invite_error("");
    return true;
  },
  invite_error: function(error) {
    if (arguments.length > 0) {
      this.invite().siblings("em").text(error);
    }
    return this.invite().siblings("em").text();
  },
  verify: function() {
    return this.dialog.find("input[name=verify_code]");
  },
  focus_verify: function() {
    this.verify().addClass("currentIn");
    this.verify_error("");
  },
  blur_verify: function() {
    this.verify().removeClass("currentIn");
    this.check_verify();
  },
  check_verify: function() {
    if (!this.verify().is(":visible")) return true;
    var val = $.trim(this.verify().val());
    if (val == "") {
      this.verify_error("请输入验证码");
      return false;
    }
    this.verify_error("");
    return true;
  },
  verify_error: function(error) {
    this.verify().siblings("em").text(error);
  },
  commit_but: function() {
    return this.dialog.find(".registerb");
  },
  newverify_link: function() {
    return this.dialog.find("#newverify");
  },
  set_verify_code: function() {
    var url = "/commons/verify_image?date=" + (new Date()).valueOf();
    this.verify().siblings("img").attr("src", url);
    this.verify().parent().show();
    this.verify().parent().prev().show();
  },
  agreement_check: function() {
    return this.dialog.find("input[name=agreement]").attr("checked");
  },
  set_register_callback: function(callback) {
    this.callback = callback;
  },
  init: function() {
    // default hint
    this.username_input_hint = this.user().val();
    //this.pwd_input_hint = this.pwd().val();
    this.pwd_input_hint = "长度至少为6个字符";

    // bind event
    var _this = this;
    this.email().focus($.proxy(this, "focus_email"));
    this.email().blur($.proxy(this, "blur_email"));
    this.email().keydown(function(e) {
      if (e.which == 13) _this.commit()
    });
    this.user().focus($.proxy(this, "focus_user"));
    this.user().blur($.proxy(this, "blur_user"));
    this.user().keydown(function(e) {
      if (e.which == 13) _this.commit()
    });
    this.pwd().focus($.proxy(this, "focus_pwd"));
    this.pwd().blur($.proxy(this, "blur_pwd"));
    this.pwd().keydown(function(e) {
      if (e.which == 13) _this.commit()
    });
    this.repwd().focus($.proxy(this, "focus_repwd"));
    this.repwd().blur($.proxy(this, "blur_repwd"));
    this.repwd().keydown(function(e) {
      if (e.which == 13) _this.commit()
    });
    this.invite().focus($.proxy(this, "focus_invite"));
    this.invite().blur($.proxy(this, "blur_invite"));
    this.invite().keydown(function(e) {
      if (e.which == 13) _this.commit()
    });
    this.verify().focus($.proxy(this, "focus_verify"));
    this.verify().blur($.proxy(this, "blur_verify"));
    this.verify().keydown(function(e) {
      if (e.which == 13) _this.commit()
    });
    this.commit_but().click(function(e) {
      e.preventDefault();
      _this.commit();
    });
    this.newverify_link().click(function(e) {
      e.preventDefault();
      _this.set_verify_code();
    });
  },
  all_check: function() {
    var rt = this.check_email(false);
    rt = this.check_user(false) && rt;
    rt = this.check_pwd() && rt;
    rt = this.check_repwd() && rt;
    //rt = this.check_invite() && rt;
    rt = this.check_verify() && rt;
    return rt;
  },
  commit: function() {
    var _this = this;
    if (!this.all_check()) return;
    if (!this.agreement_check()) {
      alert("请阅读注册协议内容，并在注册前同意注册协议！");
      return;
    }
    var data = {
      "email": this.email().val(),
      "user": this.user().val(),
      "pwd": this.pwd().val(),
      "repwd": this.repwd().val(),
      //"invite": this.invite().val(),
      "verify_code": this.verify().val()
    };
    var url = "/users/register_service";
    $.ajax({
      url: url,
      data: data,
      type: 'post',
      async: true,
      dataType: 'json',
      success: function(r) {
        if (r.rt) {
          if (_this.callback != null) {
            _this.callback(r);
          } else {
            window.location = "/";
          }
        } else {
          if (typeof(r.show_verify) != "undefined" && r.show_verify) {
            _this.set_verify_code();
          }
          if (typeof(r.verify) != "undefined") _this.verify_error(r.verify);
          if (typeof(r.invite) != "undefined") _this.invite_error(r.invite);
          if (typeof(r.repwd) != "undefined") _this.repwd_error(r.repwd);
          if (typeof(r.password) != "undefined") _this.pwd_error(r.password);
          if (typeof(r.username) != "undefined") _this.user_error(r.username);
          if (typeof(r.email) != "undefined") _this.email_error(r.email);
        }
      }
    });
  }
};


var LoginDialog = function(dom, ent) {
  this.dialog = dom;
  this.entrance = ent;
  this.login_dameon = null;
  this.register_dameon = null;
  this.callback = null;
};
LoginDialog.hit = false;
LoginDialog.check = function() {
  return LoginDialog.hit;
};
LoginDialog.prototype = {
  close_button: function() {
    return this.dialog.find(".close");
  },
  login_area: function() {
    return this.dialog.find(".mylogin");
  },
  register_area: function() {
    return this.dialog.find(".myregister");
  },
  tabs: function() {
    return this.dialog.find(".tabs a");
  },
  not_login_but: function() {
    return this.dialog.find(".notLoginBut");
  },
  set_login_callback: function(callback){
    this.callback = callback;
  },
  init: function() {
    var _this = this;
    this.login_dameon = new Login(this.login_area());
    this.login_dameon.set_login_callback($.proxy(this, "login_success"));
    this.login_dameon.init();
    this.register_dameon = new Register(this.register_area());
    this.register_dameon.set_register_callback($.proxy(this, "login_success"));
    this.register_dameon.init();
    this.self_check();
    $(this.dialog).dialog({
      autoOpen: false,
      modal: true,
      show: "fade",
      hide:"fade",
      dialogClass: "dialogc",
      draggable: false,
      resizable: false,
      width: 935,
      position: ["center", "middle"]
    });

    this.tabs().click(function(e){
      e.preventDefault();
      $(this).parent().siblings().children().removeClass("current");
      $(this).addClass("current");
      _this.login_area().hide();
      _this.register_area().hide();
      _this.dialog.find("." + $(this).attr("href")).show();
    });
    this.tabs().first().click();
    this.close_button().click(function(e) {
      e.preventDefault();
      _this.close();
    });
    this.not_login_but().click(function(e) {
      e.preventDefault();
      if (_this.callback != null) _this.callback();
    });
    this.entrance.click(function(e) {
      e.preventDefault();
    });
  },
  open: function() {
    this.dialog.dialog("open");
    this.dialog.find("a").first().blur();
  },
  close: function() {
    this.dialog.dialog("close");
  },
  login_success: function(data) {
    this.render(data.username);
    this.close();
    if (this.callback != null) {
      this.callback();
    } else {
      location.reload();
    }
  },
  render: function(user) {
    var content = '欢迎您，<a class="blue" href="/users/home">' + user
    + '</a>&nbsp;[<a href="/users/logout">退出</a>]';
    this.entrance.parent().html(content);
  },
  self_check: function() {
    var _this = this;
    var timestamp = new Date().getTime();
    $.getJSON("/users/check_login?" + timestamp, function(data) {
      if (data.rt) {
        _this.render(data.user);
        LoginDialog.hit = true;
      } else {
        if (data.login_verify) {
          _this.login_dameon.set_verify_code()
        }
        if (data.register_verify) {
          _this.register_dameon.set_verify_code()
        }
        _this.entrance.click(function(e) {
          e.preventDefault();
          _this.open();
        });
      }
    });
  }
};

var Cart = {
  init: function(pic_path) {
    this.pic_path = pic_path;
    var _this = this;
    var b = $("#header .iconShop");
    this.qnt();
    $(b).children("a").mouseover(function(){
      _this.detail();
    });
  },
  show: function(qnt, detail) {
    var b = $("#header .iconShop");
    if (arguments.length == 0) {
      return;
    }
    if (arguments.length > 0) {
      $(b).find("a span").text(qnt);
    }
    if (arguments.length > 1) {
      $(b).find(".shop").remove();
      $(b).append($('<div class="shop">' + detail + '</div>'));
      $(b).find(".shop").show();
      $(b).children(".shop").hover(function(){
        }, function() {
          $(this).hide();
        });
      var _this = this;
      $(b).children(".shop").find("li .del").click(function(e){
        e.preventDefault();
        var sid = $(this).attr("sid"),
        aid = $(this).attr("aid"),
        piid = $(this).attr("piid");
        _this.del(sid, aid, piid);
      });
    }
  },
  qnt: function() {
    var _this = this;
    var timestamp = new Date().getTime();
    $.ajax({
      url: "/orders/view_cart?" + timestamp, // TODO cache?
      type: 'post',
      async: true,
      dataType: 'json',
      success: function(r) {
        if (r.status) {
          _this.show(r.qnt);
        } else {}
      }
    });
  },
  detail: function() {
    var _this = this;
    var timestamp = new Date().getTime();
    $.ajax({
      url: "/orders/view_cart/100?" + timestamp, // TODO cache?
      type: 'post',
      async: true,
      dataType: 'json',
      success: function(r) {
        if (r.status) {
          var c = "";
          c += '<h4>购物车中有' + r.total_qnt + '件商品</h4>';
          if (r.total_qnt == 0) {
            c += '<p class="empty">您的购物车中还没有商品，赶紧订购吧</p>';
          } else {
            var t = 0;
            for (var sid in r.detail) {
              c += '<h5>' + r.detail[sid].name + '</h5><ul>'; //TODO links
              for (var piid in r.detail[sid].products) {
                var p = r.detail[sid].products[piid];
                var img = _this.pic_path + p.image;
                c += '<li><img src="' + img + '" width="60" height="60"/>'
                + '<p>' + p.design_title + '</p><p>' + p.product_title
                + '</p><p>' + p.color_title + p.size_title
                + '</p><p class="margintopone"><span class="del" sid="' + sid
                + '" aid="' + p.aid + '" piid="' + piid + '">删除</span>'
                + '<span class="font12">' + p.price + '</span>元X' + p.qnt
                + '</p></li>';
                t += p.qnt;
              }
              c += "</ul>";
            }
            c += '<div class="total">';
            if (r.total_qnt > t) {
              c+= '<p><strong class="blue12"><a href="/orders/view_cart">更多&gt;&gt;</a></strong></p>';
            }
            c += '<p>共<span>' + r.total_qnt + '</span>件商品，总计<span>'
            + r.total_price + '</span>元</p>';
            c += '<p><strong class="but"><a href="/orders/view_cart">去购物车结算</a></strong></p>';
            c += '</div>';
          }
          _this.show(r.total_qnt, c);
        } else {}
      }
    });
  },
  del: function(sid, aid, piid) {
    var _this = this;
    $.ajax({
      url: "/orders/update_cart/" + sid + "/" + aid + "/" + piid + "/0",
      type: 'post',
      async: true,
      dataType: 'json',
      success: function(r) {
        if (r.status) {
          _this.detail();
          if (_this.update_callback != undefined) {
            _this.update_callback();
          }
        } else {}
      }
    });
  }

};

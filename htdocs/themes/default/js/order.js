var ViewCart = function() {
  this.login_check = null;
  this.stop_click = 0;
};
ViewCart.max_purch = 9999;
ViewCart.prototype = {
  table: function() {
    return $(".myShopTable");
  },
  del_links: function(rec_id) {
    if (arguments.length > 0) {
      return this.table().find(".del[rec_id=" + rec_id + "]");
    }
    return this.table().find(".del");
  },
  number_inputs: function() {
    return this.table().find(".number");
  },
  commit_link: function() {
    return $(".commits");
  },
  all_checkbox: function() {
    return $("input[name=all]");
  },
  store_checkbox: function(sid) {
    if (arguments.length > 0) {
      return this.table().find("input[name=s" + sid + "]");
    }
    return this.table().find("input[name*=s]");
  },
  product_checkbox: function(sid, pid) {
    if (arguments.length > 1) {
      return this.table().find("input[name=p" + sid + "_" + pid + "]");
    } else if (arguments.length > 0) {
      return this.table().find("input[name*=p" + sid + "_]");
    }
    return this.table().find("input[name*=p]");
  },
  product_price: function(prd_dom, price) {
    if (arguments.length > 1) {
      $(prd_dom).find(".price span").text(price);
    }
    return $(prd_dom).find(".price span").text();
  },
  product_total_price: function(prd_dom, total) {
    if (arguments.length > 1) {
      $(prd_dom).find(".toprice span").text(total);
    }
    return $(prd_dom).find(".toprice span").text();
  },
  product_total_qnt: function(prd_dom) {
    var total = 0;
    $(prd_dom).find(".number input").each(function() {
      var qnt = parseInt($(this).val());
      if (qnt != NaN) {
        total += qnt;
      }
    });
    return total;
  },
  total_price: function(total) {
    if (arguments.length > 0) {
      $("#total_price").text(total);
    }
    return $("#total_price").text();
  },
  total_qnt: function(total) {
    if (arguments.length > 0) {
      $("#total_qnt").text(total);
    }
    return $("#total_qnt").text();
  },
  set_login_check: function(f) {
    this.login_check = f;
  },
  init: function() {
    var _this = this;
    this.all_checkbox().click(function(e) {
      if ($(this).attr("checked")) {
        _this.store_checkbox().attr("checked", true);
        _this.product_checkbox().attr("checked", true);
      } else {
        _this.store_checkbox().attr("checked", false);
        _this.product_checkbox().attr("checked", false);
      }
      _this.refresh();
    });
    this.store_checkbox().click(function(e) {
      var sid = $(this).parents("tr").attr("sid");
      if ($(this).attr("checked")) {
        _this.product_checkbox(sid).attr("checked", true);
      } else {
        _this.product_checkbox(sid).attr("checked", false);
      }
      _this.refresh();
    });
    this.product_checkbox().click(function(e) {
      var sid = $(this).parents("tr").attr("sid");
      if ($(this).attr("checked")) {
        var product_all_tag = true;
        _this.product_checkbox(sid).each(function() {
          if (!$(this).attr("checked")) {
            product_all_tag = false;
          }
        });
        if (product_all_tag) {
          _this.store_checkbox(sid).attr("checked", true);
        }
      } else {
        _this.store_checkbox(sid).attr("checked", false);
      }
      _this.refresh();
    });
    // 从购物车中删除
    this.del_links().click(function(e) {
      e.preventDefault();
      if (_this.stop_click) {
        return;
      }
      if (!confirm("确定从购物车中删除该商品？")) {
        return;
      }
      var rec_id = $(this).attr("rec_id");
      var del_dom = this;
      var prd_dom = $(this).parents("tr");
      _this.update(rec_id, 0, function() {
        $(del_dom).remove();
        $(prd_dom).find(".number input").each(function() {
          if ($(this).attr("rec_id") == rec_id) {
            $(this).parents(".number").remove();
          }
        });
        if ($(prd_dom).find(".number input").length == 0) {
          $(prd_dom).remove();
        }
      });
    });

    this.number_inputs().find("a").click(function(e) {
      e.preventDefault();
    });
    this.number_inputs().find("span").click(function(e){
      e.preventDefault();
      if (_this.stop_click) {
        return;
      }
      var val = $(this).siblings("input").val();
      var newval = val;
      if ($(this).hasClass("minus")) {
        newval--;
      } else {
        newval++;
      }
      var max_purch = ViewCart.max_purch;
      newval = _this.limit_in_a_gap(newval, 0, max_purch); // TODO inventory
      $(this).siblings("input").val(newval);
      if (newval != val) {
        var rec_id = $(this).parents("tr").attr("rec_id");
        if (newval == 0) {
          _this.del_links(piid).click();
        } else {
          _this.update(rec_id, newval);
        }
      }
    });
    this.number_inputs().find("input").focus(function(e) {
      e.preventDefault();
      if ($(this).val() == 0) {
        $(this).val("");
      }
    });
    this.number_inputs().find("input").blur(function(e) {
      if ($(this).val() == "") {
        $(this).val("0");
      }
      var store_id = $(this).parents("tr").attr("sid");
      var aid = $(this).parents("tr").attr("aid");
      var piid = $(this).attr("piid");
      if ($(this).val() == 0) {
        _this.del_links(piid).click();
      } else {
        _this.update(store_id, aid, piid, $(this).val());
      }
    });
    this.number_inputs().find("input").keyup(function(e){
      var val = $(this).val();
      var newval = val.replace(/\D/g, '');
      var max_purch = Cart.max_purch;
      newval = _this.limit_in_a_gap(newval, 0, max_purch);// TODO inventory
      if (newval != val) {
        $(this).val(newval);
      }
    });
    this.commit_link().click(function(e) {
      e.preventDefault();
      if (_this.total_qnt() > 0) {
        if (_this.login_check != null) {
          var dom = this;
          _this.login_check(function(){
            $(dom).parents("form").submit();
          });
        } else {
          $(this).parents("form").submit();
        }
      }
    });
  },
  disable: function() {
    this.number_inputs().find("input").attr("disabled", true);
    this.stop_click = 1;
  },
  enable: function() {
    this.number_inputs().find("input").attr("disabled", false);
    this.stop_click = 0;
  },
  update: function(rec_id, qnt, callback) {
    var _this = this;
    this.disable();
    var url = "/flow.php?step=update_cart&rec_id=" + rec_id + "&goods_number=" + qnt;
    $.ajax({
      url: url,
      type: 'post',
      async: true,
      dataType: 'text',
      success: function(r) {
    	  if (callback != undefined) {
              callback();
          }
    	  location.reload();
          if (Cart != undefined) {
              Cart.qnt();
          }
           _this.enable();
      },
      error: function(jqXHR, textStatus, errorThrown){
    	  alert(errorThrown);
      }
    });
  },
  refresh: function() {
    var _this = this;
    // checkboxes
    var store_all_tag = true;
    this.store_checkbox().each(function() {
      if (!$(this).attr("checked")) {
        store_all_tag = false;
      }
    });
    if (store_all_tag) {
      this.all_checkbox().attr("checked", true);
    } else {
      this.all_checkbox().attr("checked", false);
    }

    // background colors and counts
    var total_qnt = 0, total_price = 0;
    this.product_checkbox().each(function() {
      var prd_dom = $(this).parents("tr");
      var price = _this.product_price($(prd_dom));
      var qnt = _this.product_total_qnt($(prd_dom));
      var product_total_price = qnt * price;
      _this.product_total_price($(prd_dom),
        qnt + "*" + price + "=" + product_total_price.toFixed(1));
      if ($(this).attr("checked")) {
        $(prd_dom).addClass("deepBlue");
        $(prd_dom).removeClass("lightBlue");
        total_qnt += qnt;
        total_price += product_total_price
      } else {
        $(prd_dom).addClass("lightBlue");
        $(prd_dom).removeClass("deepBlue");
      }
    });
    this.total_qnt(total_qnt);
    this.total_price(total_price.toFixed(1));
  },
  limit_in_a_gap: function(val, min, max) {
    if (val < min) return min;
    if (val > max) return max;
    return ~~val;
  }
};

var DeliveryInfo = function(base) {
  this.base = base;
  this.delivery_id = 0;
};
DeliveryInfo.prototype = {
  consignee: function() {
    return this.base.find("input[name=consignee]");
  },
  get_consignee: function() {
    return $.trim(this.consignee().val());
  },
  set_consignee: function(c) {
    this.consignee().val(c);
  },
  check_consignee: function() {
    var s = this.get_consignee();
    var h = this.consignee().siblings("em");
    $(h).hide();
    if (s === "") {
      $(h).show();
      return false;
    }
    return true;
  },
  province: function() {
    return this.base.find("select[name=province]");
  },
  get_province: function() {
    var id = this.province().val();
    var text = this.province().find("option:selected").text();
    return {
      "id": id,
      "text": text
    };
  },
  set_province: function(id) {
    var d = this.province();
    var old_id = $(d).val();
    $(d).val(id);
    if (id > 0 && id != old_id) {
      $(d).change();
    }
  },
  check_province: function() {
    return this.province().val() != 0;
  },
  city: function() {
    return this.base.find("select[name=city]");
  },
  get_city: function() {
    var d = this.city();
    var id = $(d).val();
    var text = $(d).find("option:selected").text();
    return {
      "id": id,
      "text": text
    };
  },
  set_city: function(id) {
    var d = this.city();
    var old_id = $(d).val();
    $(d).val(id);
    if (id > 0 && id != old_id) {
      $(d).change();
    } else if (id == 0) {
      $(d).children().each(function() {
        if ($(this).val() > 0) {
          $(this).remove();
        }
      });
    }
  },
  check_city: function() {
    return this.city().val() != 0;
  },
  district: function() {
    return this.base.find("select[name=district]");
  },

  get_district: function() {
    var d = this.district();
    var id = $(d).val();
    var text = $(d).find("option:selected").text();
    return {
      "id": id,
      "text": text
    };
  },
  set_district: function(id) {
    var d = this.district();
    var old_id = $(d).val();
    $(d).val(id);
    if (id > 0 && id != old_id) {
      $(d).change();
    } else if (id == 0) {
      $(d).children().each(function() {
        if ($(this).val() > 0) {
          $(this).remove();
        }
      });
    }
  },
  check_district: function() {
    var d = this.district();
    $(d).siblings("em").hide();
    if (!this.check_province() || !this.check_city()
      || $(d).val() == 0) {
      $(d).siblings("em").show();
      return false;
    }
    return true;
  },
  address: function() {
    return this.base.find("input[name=address]");
  },
  get_address: function() {
    return $.trim(this.address().val());
  },
  set_address: function(a) {
    this.address().val(a);
  },
  set_address_prefix: function(p) {
    this.address().prev().text(p + " ");
  },
  check_address: function() {
    var s = this.get_address();
    var h = this.address().siblings("em");
    $(h).hide();
    if (s === "") {
      $(h).show();
      return false;
    }
    return true;
  },
  zipcode: function() {
    return this.base.find("input[name=zipcode]");
  },
  get_zipcode: function() {
    return $.trim(this.zipcode().val());
  },
  set_zipcode: function(z) {
    this.zipcode().val(z);
  },
  check_zipcode: function() {
    var s = this.get_zipcode();
    var h = this.zipcode().siblings("em");
    $(h).hide();
    var reg = /^\d{6}$/i;
    if (s != "" && !reg.test(s)) {
      $(h).show();
      return false;
    }
    return true;
  },
  mobile: function() {
    return this.base.find("input[name=mobile]");
  },
  get_mobile: function() {
    return $.trim(this.mobile().val());
  },
  set_mobile: function(m) {
    this.mobile().val(m);
  },
  check_mobile: function() {
    var s = this.get_mobile();
    var h = this.mobile();
    $(h).siblings("em").hide();
    if (s === "") {
      $(h).siblings("em:eq(0)").show();
      return false;
    }
    var reg = /^\+*(86){0,1}1\d{10}$/i;
    if (!reg.test(s)) {
      $(h).siblings("em:eq(1)").show();
      return false;
    }
    return true;
  },
  phone: function() {
    return this.base.find("input[name=phone]");
  },
  get_phone: function() {
    return $.trim(this.phone().val());
  },
  set_phone: function(p) {
    this.phone().val(p);
  },
  check_phone: function() {
    var s = this.get_phone();
    var h = this.phone().siblings("em");
    $(h).hide();
    var reg = /(^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$)|(^((\(\d{3}\))|(\d{3}\-))?(1[358]\d{9})$)/i;
    if (s != "" && !reg.test(s)) {
      $(h).show();
      return false;
    }
    return true;
  },
  email: function() {
    return this.base.find("input[name=email]");
  },
  get_email: function() {
    return $.trim(this.email().val());
  },
  set_email: function(e) {
    this.email().val(e);
  },
  check_email: function() {
    var s = this.get_email();
    var h = this.email();
    $(h).siblings("em").hide();
    if (s === "") {
      $(h).siblings("em:eq(0)").show();
      return false;
    }
    var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i;
    if (!reg.test(s)) {
      $(h).siblings("em:eq(1)").show();
      return false;
    }
    return true;
  },
  clear_hint: function() {
    this.base.find("input em").hide();
  },
  check: function() {
    var r = true;
    r = this.check_consignee() && r;
    r = this.check_district() && r;
    r = this.check_address() && r;
    r = this.check_zipcode() && r;
    r = this.check_mobile() && r;
    r = this.check_phone() && r;
    r = this.check_email() && r;
    return r;
  },
  init: function() {
    var _this = this;
    var region = new Region();

    this.consignee().blur($.proxy(this, "check_consignee"));
    this.address().blur($.proxy(this, "check_address"));
    this.zipcode().blur($.proxy(this, "check_zipcode"));
    this.mobile().blur($.proxy(this, "check_mobile"));
    this.phone().blur($.proxy(this, "check_phone"));
    this.email().blur($.proxy(this, "check_email"));
    $("#provinces").change(function(){
      if ($(this).val() != 0) {
        var province = _this.get_province();
        _this.set_address_prefix(province.text);
      }
      region.loadCities($(this).val(), "cities", "districts");
    });
    $("#cities").change(function(){
      if ($(this).val() != 0) {
        var province = _this.get_province();
        var city = _this.get_city();
        _this.set_address_prefix(province.text + city.text);
      }
      region.loadDistricts($(this).val(), "districts", 0, {
        trigger: 'change',
        func: function(){
          if ($(this).val() != 0) {
            var province = _this.get_province();
            var city = _this.get_city();
            var district = _this.get_district();
            _this.set_address_prefix(province.text + city.text + district.text);
            _this.check_district();
          }
        }
      });
    });
  },
  load: function(delivery_id, callback) {
    var _this = this;
    this.delivery_id = delivery_id;
    $.ajax({
      url: "/orders/get_delivery_info/" + delivery_id,
      type: 'POST',
      dataType: 'json',
      async: false,
      success: function(rt){
        if (rt.status) {
          _this.fill(rt.data);
          if (callback != undefined) {
            callback();
          }
        } else {
        // TODO
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
      // TODO
      }
    });
  },
  fill: function(data) {
    if (arguments.length > 0) {
      this.set_consignee(data.consignee);
      this.set_province(data.address_1);
      this.set_city(data.address_2);
      this.set_district(data.address_3);
      this.set_address(data.address);
      this.set_zipcode(data.zipcode);
      this.set_mobile(data.mobile);
      this.set_phone(data.phone);
      this.set_email(data.email);
      this.check();
    } else {
      this.set_consignee("");
      this.set_province(0);
      this.set_city(0);
      this.set_district(0);
      this.set_address_prefix("");
      this.set_address("");
      this.set_zipcode("");
      this.set_mobile("");
      this.set_phone("");
      this.set_email("");
      this.delivery_id = 0;
    }
    this.clear_hint();
  },
  save: function(callback) {
    if (!this.check()) {
      return;
    }
    var di = {};
    di.consignee = this.get_consignee();
    di.province = this.get_province().text;
    di.city = this.get_city().text;
    di.district = this.get_district().text;
    di.address = this.get_address();
    di.zipcode = this.get_zipcode();
    di.tel = this.get_mobile();
    di.mobile = this.get_phone();
    di.email = this.get_email();
    di.address_id = this.delivery_id;
    $.ajax({
      url: "/flow.php?step=cart_deliver",
      data: di,
      type: 'POST',
      dataType: 'json',
      async: false,
      success: function(data){
        if (callback != undefined) {
//          di.address = data.address;
          callback(data, di);
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
    	  alert(textStatus);
      }
    });
  }
};

var DeliveryInfoDialog = function(dom_id) {
  this.dialog_id = dom_id;
  this.delivery_info_dameon = null;
  this.callback_after_commit = null;
};
DeliveryInfoDialog.prototype = {
  get_dialog: function() {
    return $("#" + this.dialog_id);
  },
  content_area: function() {
    return this.get_dialog().find(".newAddress");
  },
  close_button: function() {
    return this.get_dialog().find(".close");
  },
  commit_button: function() {
    return this.get_dialog().find(".commitb");
  },
  giveup_button: function() {
    return this.get_dialog().find(".giveupb");
  },
  init: function() {
    this.delivery_info_dameon = new DeliveryInfo(this.content_area());
    this.delivery_info_dameon.init();
    this.get_dialog().dialog({
      autoOpen: false,
      modal: true,
      show: "fade",
      hide:"fade",
      dialogClass: "dialogc",
      draggable: false,
      resizable: false,
      width: 803,
      position: ["center", "middle"]
    });

    var _this = this;
    this.close_button().click(function(e) {
      e.preventDefault();
      _this.close();
    });
    this.giveup_button().click(function(e) {
      e.preventDefault();
      _this.close();
    });
    this.commit_button().click(function(e) {
      e.preventDefault();
      _this.commit();
    });
  },
  open: function() {
    this.get_dialog().dialog("open");
  },
  close: function() {
    this.get_dialog().dialog("close");
  },
  edit: function(diid, callback) {
    this.callback_after_commit = callback;
    this.delivery_info_dameon.load(diid);
    this.open();
  },
  add: function(callback) {
    this.callback_after_commit = callback;
    this.delivery_info_dameon.fill();
    this.open();
  },
  commit: function() {
    var _this = this;
    this.delivery_info_dameon.save(function(data, di) {
      _this.close();
      _this.callback_after_commit(data, di);
    });
  }
};

var Group = function() {
  this.groups = {};
  this.wr = "/";
};
Group.prototype = {
  load_groups: function(aid, type, callback) {
    var _this = this;
    var url = this.wr + "orders/group/";
    $.getJSON(url + aid, function(data){
      _this.groups[aid] = data;
      var group_names = new Array(), group_names_1 = new Array(), level = 0;
      for (var k in data) {
        var group = data[k].Group;
        var name = group.name;
        group_names.push({
          "name": name,
          "id": group.id
        });
        if (group.name_1 == "") continue;
        name = group.name_1;
        var etag = false;
        for (var i = 0; i < group_names_1.length; i++) {
          if (group_names_1[i].name == name) {
            etag = true;
            break;
          }
        }
        if (!etag) {
          group_names_1.push({
            "name": name,
            "id": group.id
          });
        }
      }
      if (group_names_1.length > 0) {
        group_names = group_names_1;
        level = 1;
      }
      callback(type, group_names, level);
    });
  },
  load_groups_2: function(aid, group_type, dom, callback) {
    if (!aid) {
      return;
    }
    var _this = this;
    this.load_groups(aid, group_type, function(type, groups, level) {
      for (i = 0; i < groups.length; i++) {
        $(dom).children("select").append('<option value="'
          + groups[i].id + '">' + groups[i].name + '</option>');
      }
      $(dom).children("select").attr("level", level);
      $(dom).delegate("select", "change", function(e) {
        var level = $(this).attr("level");
        var select_item = $(this).find("option:selected").text();
        var groups = _this.get_children_groups(aid, select_item, level);
        if (level <= 0 || level >=3 || groups.length == 0) {
          var val = $(this).val();
          var target_group = _this.detail(aid, val, type);
          callback(target_group);
          return;
        }
        if (groups.length > 0) {
          level++;
          var content = '<select level="' + level + '">';
          for (var i = 0; i < groups.length; i++) {
            content += '<option value="' + groups[i].id + '">'
            + groups[i].name + '</option>';
          }
          content += '</select>';
          if ($(this).next().is("select")) {
            $(this).next().remove();
            $(this).next().remove();
          }
          $(this).after(content);
          $(this).next().change();
        }
      });
      $(dom).children("select").change();
    });
  },
  detail: function(aid, gid, type) {
    for (var k in this.groups[aid]) {
      var group = this.groups[aid][k].Group;
      if (group.id == gid) {
        if (arguments.length > 2 && type == "pay") {
          return {
            "id": gid,
            "name": group.pay_fullname,
            "mobile": group.pay_mobile
          }
        }
        return {
          "id": gid,
          "name": group.fullname,
          "mobile": group.mobile
        }
      }
    }
    return null;
  },
  get_children_groups: function(aid, parent, level) {
    var group_names = new Array();
    level++;
    for (var k in this.groups[aid]) {
      var group = this.groups[aid][k].Group;
      var name = group["name_" + level];
      if (parent != group["name_" + (level - 1)] || !name || name == "") continue;
      var etag = false;
      for (var i = 0; i < group_names.length; i++) {
        if (group_names[i].name == name) {
          etag = true;
          break;
        }
      }
      if (!etag) {
        group_names.push({
          "name": name,
          "id": group.id
        });
      }
    }
    return group_names;
  }
};

var AddOrder = function() {
  this.delivery_dialog = null;
  this.group = new Group();
  this.wr = "/";
};
AddOrder.prototype = {
  address_area: function() {
    return $("#address");
  },
  new_address_but: function() {
    return this.address_area().find(".usenew");
  },
  commit_but: function() {
    return $(".butLarge");
  },
  delivery_type_radios: function() {
    return $(".myOrderSure").find("input[name*=data\\[express\\]]");
  },
  remarks_ctrl: function() {
    return $(".oremarks");
  },
  change_address: function(dom, di) {
    $(dom).siblings("em").remove();
    var content = "<em>" + di.consignee + "</em><em>" + di.mobile
    + "</em><em>" + di.address + "</em>";
    $(dom).before($(content));
  },
  add_address: function(dom, id, di) {
    var content = '<li diid="' + id
    + '"><input name="data[delivery_info]" type="radio" value="' + id
    + '"/><em>' + di.consignee + '</em><em>' + di.mobile + '</em><em>'
    + di.address + '</em><a class="modify" href="#">[修改这个地址]</a></li>';
    $(dom).parents(".address").children("li:last").before($(content));
    $(dom).parents(".address").children("li:last").prev().children("input").click();
  },
  get_delivery_fee: function(diid) {
    var url = this.wr + "orders/delivery_fee/" + diid;
    this.delivery_type_radios().each(function(){
      if ($(this).val() != "mail") {
        return;
      }
      var weight = $(this).attr("weight");
      var aid = $(this).attr("aid");
      var qnt = $(this).attr("qnt");
      var dom = this;
      var this_url = url + "/" +  weight + "/" +  aid + "/" +  qnt;
      $.getJSON(this_url, function(data){
        var clone_dom = $(dom).clone(true);
        var parent = $(dom).parent();
        $(parent).empty();
        var msg = "";
        if (data.msg && data.msg != "") {
          msg = "(" + data.msg + ")";
        }
        $(parent).html("<em>快递</em>" + data.address + "，运费<span>" + data.fee
          + "</span><em>元</em><em class='fontred'>" + msg + "</em>");
        $(parent).prepend(clone_dom);
      });
    });
  },
  init_groups: function() {
    var _this = this;
    this.delivery_type_radios().each(function(){
      if ($(this).val() != "group") {
        return;
      }
      var aid = $(this).attr("aid");
      var group_type = $(this).attr("grouptype");
      var dom = $(this).parent().next();
      _this.group.load_groups(aid, group_type, function(type, groups, level) {
        for (i = 0; i < groups.length; i++) {
          $(dom).children("select").append('<option value="'
            + groups[i].id + '">' + groups[i].name + '</option>');
        }
        $(dom).children("select").attr("level", level);
        $(dom).delegate("select", "change", function(e) {
          var level = $(this).attr("level");
          var select_item = $(this).find("option:selected").text();
          var groups = _this.group.get_children_groups(aid, select_item, level);
          if (level <= 0 || level >=3 || groups.length == 0) {
            var val = $(this).val();
            var content = "";
            var display = $(this).parent().css("display");
            var target_group = _this.group.detail(aid, val, type);
            if (target_group != null) {
              content = '<li class="bg" style="display:' + display
              + '"><em>负责人姓名： ' + target_group.name
              + '</em>联系电话：' + target_group.mobile +'</li>';
              $(this).parent().next().remove();
              $(this).parent().after($(content));
              $(this).parents("ul").find(
                "input[name*=data\\[group_pickup\\]]").val(target_group.id);
            }
            return;
          }
          if (groups.length > 0) {
            level++;
            content = '<select level="' + level + '">';
            for (var i = 0; i < groups.length; i++) {
              content += '<option value="' + groups[i].id + '">'
              + groups[i].name + '</option>';
            }
            content += '</select>';
            if ($(this).next().is("select")) {
              $(this).next().remove();
              $(this).next().remove();
            }
            $(this).after(content);
            $(this).next().change();
          }
        });
        $(dom).children("select").change();
      });
    });
  },
  address_editor_error: function(errors) {
    var s = "";
    for (var i in errors) s += errors[i] + "\n";
    alert(s);
  },
  init: function() {
    var _this = this;
    this.delivery_dialog = new DeliveryInfoDialog("addressd");
    this.delivery_dialog.init();
    this.get_delivery_fee($("#address").find("li:eq(0)").attr("diid"));
    this.init_groups();

    this.address_area().delegate("li .modify", "click", function(e) {
      e.preventDefault();
      var diid = $(this).parent().attr("diid");
      var dom = this;
      _this.delivery_dialog.edit(diid, function(data, di){
        if (data.result == 'success') {
          if (data.id == diid) {
            _this.change_address(dom, di);
          } else {
            _this.add_address(dom, data.id, di);
          }
        } else {
          _this.address_editor_error(data.errors);
        }
      });
    });
    this.new_address_but().click(function(e) {
      e.preventDefault();
      var dom = this;
      _this.delivery_dialog.add(function(data, di){
        if (data.result == 'success') {
          _this.add_address(dom, data.id, di);
        } else {
          _this.address_editor_error(data.errors);
        }
      });
    });
    this.address_area().delegate("li input", "click", function() {
      $(this).parent().siblings().removeClass("bg");
      $(this).parent().siblings().children("input").attr("checked", false);
      $(this).parent().addClass("bg");
      _this.get_delivery_fee($(this).parent().attr("diid"));
    });
    this.delivery_type_radios().click(function(e) {
      $(this).parent().addClass("bg");
      if ($(this).val() == "mail") {
        $(this).parent().siblings().each(function(){
          $(this).removeClass("bg");
          if ($(this).find("input[type=radio]").length == 0) {
            $(this).hide();
          }
        });
      } else {
        $(this).parent().siblings().each(function(){
          if ($(this).find("input[type=radio]").length == 0) {
            $(this).addClass("bg");
            $(this).show();
          } else {
            $(this).removeClass("bg");
          }
        });
      }
    });
    this.remarks_ctrl().click(function(e) {
      e.preventDefault();
      if ($(this).next().is(":visible")) {
        $(this).text("订单备注");
        $(this).next().val("");
        $(this).next().hide();
      } else {
        $(this).text("取消订单备注");
        $(this).next().show();
      }
    });
    this.commit_but().click(function(e) {
      e.preventDefault();
      $(this).parents("form").submit();
    });
  }
};

var Pay = function(orders) {
  this.order_detail_dialog = null;
  this.waiting_payment_dialog = null;
  this.orders = orders;
  this.group = new Group();
  this.wr = "/";
};
Pay.prototype = {
  tabs: function() {
    return $(".tab a");
  },
  detail_link: function() {
    return $(".detail");
  },
  group_area: function() {
    return $(".grouppay");
  },
  cfoff_but: function() {
    return $(".cfoffline");
  },
  mulcfoff_but: function() {
    return $(".mulcfoffline");
  },
  pay_type_radios: function() {
    return $("input[name*=data\\[pay\\]]");
  },
  tangle_area: function() {
    return $(".tangle");
  },
  verdict_area: function() {
    return $(".verdict");
  },
  verdict_andOrder: function() {
    return this.verdict_area().children(".andOrder");
  },
  verdict_please: function() {
    return this.verdict_area().children(".please");
  },
  verdict_bank: function() {
    return this.verdict_area().children(".bank");
  },
  online_pay_items: function(items) {
    if (arguments.length > 0) {
      $("input[name=data\\[items\\]]").val(items);
    }
    return $("input[name=data\\[items\\]]").val();
  },
  bank_radio: function(d) {
    if (arguments.length > 0) {
      return $(d).find("input[type=radio]");
    }
    return $(".bank").find("input[type=radio]");
  },
  bank_img: function() {
    return $(".bank").find("img");
  },
  pay_but: function() {
    return $(".butLarge");
  },
  init_groups: function() {
    var _this = this;
    this.group_area().each(function(){
      var aid = $(this).attr("aid");
      var group_type = $(this).attr("grouptype");
      var dom = this;
      _this.group.load_groups(aid, group_type, function(type, groups, level) {
        for (i = 0; i < groups.length; i++) {
          $(dom).children("select").append('<option value="'
            + groups[i].id + '">' + groups[i].name + '</option>');
        }
        $(dom).children("select").attr("level", level);
        $(dom).delegate("select", "change", function(e) {
          var level = $(this).attr("level");
          var select_item = $(this).find("option:selected").text();
          var groups = _this.group.get_children_groups(aid, select_item, level);
          if (level <= 0 || level >=3 || groups.length == 0) {
            var val = $(this).val();
            var content = "";
            var display = $(this).parent().css("display");
            var target_group = _this.group.detail(aid, val, type);
            if (target_group != null) {
              content = '<li class="bg" style="display:' + display
              + '"><em>负责人姓名： ' + target_group.name
              + '</em>联系电话：' + target_group.mobile +'</li>';
              $(this).parent().next().remove();
              $(this).parent().after($(content));
              $(this).parent().prev().val(target_group.id);
            }
            return;
          }
          if (groups.length > 0) {
            level++;
            content = '<select level="' + level + '">';
            for (var i = 0; i < groups.length; i++) {
              content += '<option value="' + groups[i].id + '">'
              + groups[i].name + '</option>';
            }
            content += '</select>';
            if ($(this).next().is("select")) {
              $(this).next().remove();
              $(this).next().remove();
            }
            $(this).after(content);
            $(this).next().change();
          }
        });
        $(dom).children("select").change();
      });
    });
  },
  init: function() {
    var order_ids = [];
    for (var oid in this.orders) {
      order_ids.push(oid);
    }
    this.order_detail_dialog = new OrderDetailDialog("detailp_", order_ids);
    this.order_detail_dialog.init();
    this.waiting_payment_dialog = new WaitPaymentDialog("waitpayd", function(oids) {
      window.location = "/orders/show_orders?ids=" + encodeURIComponent(oids);
    });
    this.waiting_payment_dialog.init();
    this.init_groups();

    var _this = this;
    this.detail_link().click(function(e) {
      e.preventDefault();
      var oid = $(this).attr("oid");
      _this.order_detail_dialog.open(oid);
    });
    this.bank_radio().click(function(e) {
      _this.bank_radio().parents("li").removeClass("allBor");
      $(this).parents("li").addClass("allBor");
    });
    this.bank_img().click(function(e) {
      _this.bank_radio($(this).parent()).click();
    });
    this.tabs().click(function(e){
      e.preventDefault();
      $(this).parent().siblings().each(function(){
        $(this).children("a").removeClass("current");
        var target = $(this).children("a").attr("target");
        var targets = target.split(" ");
        for (var x in targets) {
          $(this).parent().siblings("." + targets[x]).hide();
        }
      });
      $(this).addClass("current");
      var target = $(this).attr("target");
      var targets = target.split(" ");
      for (var x in targets) {
        $(this).parent().parent().siblings("." + targets[x]).show();
      }
    });
    this.tabs().first().click();
    this.cfoff_but().click(function(e){
      e.preventDefault();
      var oid = $(this).attr("oid");
      var gid = $(this).parent().prev().find("input[name=data\\[group_pay\\]]").val();
      var pay = {};
      pay[oid] = {
        "pay":"group",
        "group":gid
      };
      _this.offline_confirm(pay, function(){
        window.location = _this.wr + "orders/show_orders?ids="
        + encodeURIComponent(oid);
      });
    });
    this.mulcfoff_but().click(function(e){
      e.preventDefault();
      var pay = {};
      _this.pay_type_radios().each(function(){
        if (!$(this).attr("checked")) return;
        var oid = $(this).attr("oid");
        if ($(this).val() == "online") {
          pay[oid] = {
            "pay":"online"
          };
          _this.orders[oid].pay = "online";
          return;
        } else {
          var gid = $(this).parent().next().val();
          pay[oid] = {
            "pay":"group",
            "group": gid
          };
          _this.orders[oid].pay = "group";
        }
      });
      _this.offline_confirm(pay, function(){
        _this.tangle_area().hide();
        _this.verdict_area().show();

        var on_cnt = 0, off_cnt = 0, on_total = 0;
        var on_content = "订单", off_content = "订单", on_ids = "", off_ids = "";
        for (var oid in _this.orders) {
          if (_this.orders[oid].pay == "online") {
            on_ids += (on_cnt > 0 ? ";" : "") + oid;
            on_content += (on_cnt++ > 0 ? "、" : "") + oid;
            on_total += parseFloat(_this.orders[oid].total);
          } else {
            off_ids += (off_cnt > 0 ? ";" : "") + oid;
            off_content += (off_cnt++ > 0 ? "、" : "") + oid;
          }
        }
        on_content += "选择了在线支付";
        var href = _this.wr + "orders/show_orders?ids=" + encodeURIComponent(off_ids);
        off_content += '选择了线下支付（请尽快联系负责人完成支付，<a class="blue"'
        + 'href="' + href + '"' + (on_cnt > 0 ? 'target="_blank"': '')
        + '>查看订单详情</a>）';
        _this.verdict_andOrder().empty();
        _this.online_pay_items(on_ids);
        if (on_cnt > 0) {
          _this.verdict_andOrder().append($("<p>" + on_content + "</p>"));
          var online_pay_content = on_cnt + "个订单需要在线支付，总金额<strong>"
          + on_total + "</strong>元，请选择在线付款方式：";
          _this.verdict_please().html(online_pay_content);
        } else {
          _this.verdict_please().hide();
          _this.verdict_bank().hide();
        }
        if (off_cnt > 0) {
          _this.verdict_andOrder().append($("<p>" + off_content + "</p>"));
        }
        _this.verdict_andOrder().append($('<p><a class="blue" href="#">重新选择</a><p>'));
        _this.verdict_andOrder().find("a").last().click(function(e){
          e.preventDefault();
          _this.tangle_area().show();
          _this.verdict_area().hide();
        })
      });
    });
    this.pay_type_radios().click(function(e) {
      $(this).parent().addClass("bg");
      if ($(this).val() == "online") {
        $(this).parent().siblings().each(function(){
          $(this).removeClass("bg");
          if ($(this).find("input[type=radio]").length == 0) {
            $(this).hide();
          }
        });
      } else {
        $(this).parent().siblings().each(function(){
          if ($(this).find("input[type=radio]").length == 0) {
            $(this).addClass("bg");
            $(this).show();
          } else {
            $(this).removeClass("bg");
          }
        });
      }
    });
    this.pay_but().click(function(e) {
      e.preventDefault();
      var bank = _this.bank_radio().parent().children(":checked");
      if (bank.length == 0) {
        alert("请选择在线付款方式！");
        return;
      }
      var ids = "";
      for (var oid in _this.orders) {
        if (_this.orders[oid].pay == "online") {
          ids += oid + ";";
        }
      }
      _this.waiting_payment_dialog.open(ids, bank.attr("bn"));
      $(this).parents("form").submit();
    });
  },
  offline_confirm: function(orders_pay, callback) {
    var url = this.wr + "orders/order_pay_method";
    $.ajax({
      url: url,
      data: {
        "orders": orders_pay
      },
      type: 'POST',
      dataType: 'json',
      async: false,
      success: function(r){
        if (r.rt) callback(orders_pay);
      },
      error: function(jqXHR, textStatus, errorThrown){
      // TODO
      }
    });
  }
};

var OrderDetailDialog = function(prefix, ids) {
  this.dialog_id_prefix = prefix;
  this.dialog_ids = ids;
  this.current_id = null;
};
OrderDetailDialog.prototype = {
  get_dialog: function(id) {
    return $("#" + this.dialog_id_prefix + id);
  },
  close_button: function(id) {
    return this.get_dialog(id).find(".close");
  },
  giveup_button: function(id) {
    return this.get_dialog(id).find(".but");
  },
  init: function() {
    var _this = this;
    for (var x in this.dialog_ids) {
      var id = this.dialog_ids[x];
      this.get_dialog(id).dialog({
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
      this.close_button(id).click(function(e) {
        e.preventDefault();
        _this.close();
      });
      this.giveup_button(id).click(function(e) {
        e.preventDefault();
        _this.close();
      });
    }
  },
  open: function(id) {
    this.current_id = id;
    this.get_dialog(id).dialog("open");
    this.get_dialog(id).find("a").first().blur();
  },
  close: function() {
    var id = this.current_id;
    this.get_dialog(id).dialog("close");
  }
};

var WaitPaymentDialog = function(dom_id, callback) {
  this.dialog_id = dom_id;
  this.oids = null;
  this.callback = callback;
};
WaitPaymentDialog.prototype = {
  get_dialog: function() {
    return $("#" + this.dialog_id);
  },
  set_bank_name: function(bank) {
    return this.get_dialog().find("em").text(bank);
  },
  commit_button: function() {
    return this.get_dialog().find(".commitb");
  },
  giveup_button: function() {
    return this.get_dialog().find(".giveupb");
  },
  init: function() {
    var _this = this;
    this.get_dialog().dialog({
      autoOpen: false,
      modal: true,
      show: "fade",
      hide:"fade",
      dialogClass: "dialogc",
      draggable: false,
      resizable: false,
      width: 598,
      position: ["center", "middle"]
    });
    this.giveup_button().click(function(e) {
      e.preventDefault();
      _this.close();
    });
    this.commit_button().click(function(e) {
      e.preventDefault();
      _this.commit();
    });
  },
  open: function(oids, bank) {
    this.oids = oids;
    this.set_bank_name(bank);
    this.get_dialog().dialog("open");
    this.get_dialog().find("input").first().blur();
  },
  close: function() {
    this.get_dialog().dialog("close");
  },
  commit: function() {
    this.close();
    if (this.callback) {
      this.callback(this.oids);
    }
  }
};
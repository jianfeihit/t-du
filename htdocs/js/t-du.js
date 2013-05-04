var UploadWrapper = function(upid, qid, succ_callback, start_callback) {
  this.uploader_id = upid;
  this.queue_id = qid; // TODO
  if (arguments.length > 2) {
    this.succ_callback = succ_callback;
  }
  if (arguments.length > 3) {
    this.start_callback = start_callback;
  }
};
UploadWrapper.ButtonImage1 = "/images/but_file.png";
UploadWrapper.ButtonImage2 = "/images/but_replace_file.gif";
UploadWrapper.prototype = {
  init: function(settings) {
    var _this = this;
    if (arguments.length <= 1) {
      settings = {};
    }

    $('#' + this.uploader_id).uploadify({
      'swf': '/js/uploadify/uploadify.swf',
      'fileTypeExts': '*.png;*.jpg;*.jpeg;*.gif;',
      'fileTypeDesc': '*.png;*.jpg;*.jpeg;*.gif;',
      'buttonImage': UploadWrapper.ButtonImage1,
      'width': 172,
      'height': 53,
      'queueID': this.queue_id,
      'fileObjName': 't-du-file',
      'uploader': '/js/uploadify/uploadify.php',
      'multi': false,
      'removeCompleted': true,
      'removeTimeout': 0,
      'overrideEvents' : ['onDialogClose'],
      'onFallback': function() {
        alert("您的浏览器没有安装flash，有些功能可能无法正常使用！");
      },
      'onSWFReady': function() {
        _this.change_settings(settings);
      },
      'onUploadError': function(file, errorCode, errorMsg, errorString) {
        alert(file.name + "上传失败，你可以重试或者联系客服！");
      },
      'onSelectError': function(file, errorCode, errorMsg) {
        if (errorCode == SWFUpload.QUEUE_ERROR.INVALID_FILETYPE) {
          alert("所选文件不是可支持的图片类型，请重新选择！");
        } else if (errorCode == SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE) {
          alert("所选文件大小为0，请重新选择！");
        } else {
        }
      },
      'onUploadStart': function(file) {
        _this.disable();
        if (_this.start_callback) {
          _this.start_callback(file);
        }
      },
      'onUploadSuccess': function(file, data, response) {
        _this.enable();
        if (data == "0") {
          // fail
          return;
        }
        var splits = data.split(":");
        if (splits.length >= 4 && splits[0] == "1") {
          var w = splits[1];
          var h = splits[2];
          var sf = splits[3];
          if (_this.succ_callback) {
            _this.succ_callback(file, sf, w, h);
          }
        }
      }
    });
  },

  change_settings: function(settings) {
    for (var key in settings) {
      $('#' + this.uploader_id).uploadify('settings', key, settings[key]);
    }
  },

  get_settings: function(key) {
    return $('#' + this.uploader_id).uploadify('settings', key);
  },
  enable: function() {
    $('#' + this.uploader_id).uploadify('disable', false);
  },

  disable: function() {
    $('#' + this.uploader_id).uploadify('disable', true);
  },
  change_button_image: function(img) {
    $('#' + this.uploader_id).find("#fup-button").css("background-image",
      "url(" + img + ")");
  }
};

var TeekerItConst = {
  default_shirt_width: 800,
  default_shirt_height: 800,
  default_design_width: 500,
  default_design_height: 500,
  start: "/teekerit",

  browser: function() {
    var sys = {};
    var ua = navigator.userAgent.toLowerCase();
    var s;
    var x = (s = ua.match(/msie ([\d.]+)/)) ? sys.ie = s[1] :
    (s = ua.match(/firefox\/([\d.]+)/)) ? sys.firefox = s[1] :
    (s = ua.match(/chrome\/([\d.]+)/)) ? sys.chrome = s[1] :
    (s = ua.match(/opera.([\d.]+)/)) ? sys.opera = s[1] :
    (s = ua.match(/version\/([\d.]+).*safari/)) ? sys.safari = s[1] : 0;
    return sys;
  },

  limit_in_a_gap: function(val, min, max) {
    if (val < min) return min;
    if (val > max) return max;
    return ~~val;
  },

  normal: function(n) {
    if (!isNaN(n)) {
      return Math.round(n);
    }
    return n;
  },

  suspension: function(outer, inner) {
    var outer_width = outer.width;
    var outer_height = outer.height;
    var inner_width = inner.width;
    var inner_height = inner.height;
    if (inner_width > outer_width || inner_height > outer_height) {
      if (inner_height * outer_width > inner_width * outer_height) {
        inner_width = inner_width * outer_height / inner_height;
        inner_height = outer_height;
      } else {
        inner_height = inner_height * outer_width / inner_width;
        inner_width = outer_width;
      }
    }
    inner_width = this.normal(inner_width);
    inner_height = this.normal(inner_height);

    var margin_left = 0;
    var margin_top = 0;
    if (inner_width > 0 && outer_width > inner_width) {
      margin_left = this.normal((outer_width - inner_width) / 2);
    }
    if (inner_height > 0 && outer_height > inner_height) {
      margin_top = this.normal((outer_height - inner_height) / 2);
    }

    return {
      "width" : inner_width,
      "height": inner_height,
      "left": margin_left,
      "top": margin_top
    };
  },

  frame: function(shirt) {
    var shirt_base_width = shirt.base_width;
    var shirt_base_height = shirt.base_height;
    var shirt_width = shirt.width;
    var shirt_height = shirt.height;

    // size
    var frame_width = shirt.frame_width;
    var frame_height = shirt.frame_height;
    frame_width = this.normal(frame_width * shirt_width / shirt_base_width);
    frame_height = this.normal(frame_height * shirt_height / shirt_base_height);

    // margin
    var frame_margin_left = shirt.frame_margin_left;
    var frame_margin_top = shirt.frame_margin_top;
    if (frame_margin_left == "center") {
      frame_margin_left = (shirt_width - frame_width) / 2;
    } else {
      frame_margin_left = this.normal(
        frame_margin_left * shirt_width / shirt_base_width);
    }
    frame_margin_top = this.normal(
      frame_margin_top * shirt_height / shirt_base_height);
    var shirt_margin_left = 0;
    var shirt_margin_top = 0;
    if (typeof(shirt['margin_left']) != "undefined") {
      shirt_margin_left = shirt.margin_left;
    }
    if (typeof(shirt['margin_top']) != "undefined") {
      shirt_margin_top = shirt.margin_top;
    }
    frame_margin_left += shirt_margin_left;
    frame_margin_top += shirt_margin_top;

    return {
      "width" : frame_width,
      "height": frame_height,
      "margin_left": frame_margin_left,
      "margin_top": frame_margin_top
    };
  },

  poly: function(shirt, frame, design) {
    var design_width = design.width * shirt.width / shirt.base_width;
    var design_height = design.height * shirt.height / shirt.base_height;
    var shrink_factor = 1;
    if (typeof(shirt['shrink_factor']) != "undefined") {
      shrink_factor = shirt['shrink_factor'] / 100;
    }
    design_width *= shrink_factor;
    design_height *= shrink_factor;
    var frame_width = frame.width;
    var frame_height = frame.height;
    if (design_width > frame_width || design_height > frame_height) {
      if (design_height * frame_width > design_width * frame_height) {
        design_width = design_width * frame_height / design_height;
        design_height = frame_height;
      } else {
        design_height = design_height * frame_width / design_width;
        design_width = frame_width;
      }
    }
    design_width = this.normal(design_width);
    design_height = this.normal(design_height);

    var design_left = design.left;
    var design_top = design.top;
    var design_border_width = 0;
    var design_border_height = 0;
    if (typeof(design['border_width']) != "undefined") {
      design_border_width = design.border_width;
    }
    if (typeof(design['border_height']) != "undefined") {
      design_border_height = design.border_height;
    }
    var design_margin_left = this.normal((frame_width - design_width
      - design_border_width) * design_left / 100);
    var design_margin_top = this.normal((frame_height - design_height
      - design_border_height) * design_top / 100);

    return {
      "width" : design_width,
      "height": design_height,
      "margin_left": design_margin_left,
      "margin_top": design_margin_top
    };
  },

  reverse: function(shirt, poly) {
    var base_width = shirt.base_width;
    var base_height = shirt.base_height;
    var shirt_width = shirt.width;
    var shirt_height = shirt.height;
    var frame_width = shirt.frame_width;
    var frame_height = shirt.frame_height;
    var poly_width = poly.width;
    var poly_height = poly.height;
    var poly_left = poly.margin_left;
    var poly_top = poly.margin_top;
    var shrink_factor = 1;
    if (typeof(shirt['shrink_factor']) != "undefined") {
      shrink_factor = shirt['shrink_factor'] / 100;
    }

    // design width
    var design_width = poly_width;
    design_width /= shrink_factor;
    if (shirt_width > 0) {
      design_width = design_width * base_width / shirt_width;
    }
    design_width = this.normal(design_width);

    // design height
    var design_height = poly_height;
    design_height /= shrink_factor;
    if (shirt_height > 0) {
      design_height = design_height * base_height / shirt_height;
    }
    design_height = this.normal(design_height);

    // design margin left
    var design_margin_left = 0;
    if (shirt_width > 0 && frame_width > 0 && frame_width > poly_width) {
      design_margin_left = poly_left * 100 / (frame_width - poly_width);
    }
    design_margin_left = this.normal(design_margin_left);

    // design margin top
    var design_margin_top = 0;
    if (shirt_height > 0 && frame_height > 0 && frame_height > poly_height) {
      design_margin_top = poly_top * 100 / (frame_height - poly_height);
    }
    design_margin_top = this.normal(design_margin_top);

    return {
      "width" : design_width,
      "height": design_height,
      "margin_left": design_margin_left,
      "margin_top": design_margin_top
    };
  }
};

var SampleShirts = {
  samples: {
    "短袖T恤": [{
      "color": {
        "name": "white",
        "rgb": "#FFF",
        "rev_rgb": "#000",
        "desc": "牙白"
      },
      "images": [{
        "type":"front",
        "img": "/v2/samples/6_front.jpg",
        "size":[319, 319],
        "shrink": 100,
        "frame":[380, 580, 210, 130]
      }, {
        "type":"back",
        "img": "/v2/samples/6_back.jpg",
        "size":[319, 319],
        "shrink": 100,
        "frame":[380, 620, 210, 100]
      }]
    }, {
      "color": {
        "name": "black",
        "rgb": "#000",
        "rev_rgb": "#e7e7e7",
        "desc": "纯黑"
      },
      "images": [{
        "type":"front",
        "img": "/v2/samples/1_front.jpg",
        "size":[319, 319],
        "shrink": 100,
        "frame":[380, 580, 210, 130]
      },{
        "type":"back",
        "img": "/v2/samples/1_back.jpg",
        "size":[319, 319],
        "shrink": 100,
        "frame":[380, 620, 210, 100]
      }]
    }, {
      "color": {
        "name": "gray",
        "rgb": "#D0D0D0",
        "rev_rgb": "#2F2F2F",
        "desc": "麻灰"
      },
      "images": [{
        "type":"front",
        "img": "/v2/samples/7_front.jpg",
        "size":[319, 319],
        "shrink": 100,
        "frame":[380, 580, 210, 130]
      }, {
        "type":"back",
        "img": "/v2/samples/7_back.jpg",
        "size":[319, 319],
        "shrink": 100,
        "frame":[380, 620, 210, 100]
      }]
    }]
  },

  get_shirt_types: function() {
    var types = [];
    for (var t in this.samples) {
      types.push(t);
    }
    return types;
  },

  get_shirt_colors: function(shirt_type) {
    var samples = this.samples;
    if (typeof(samples[shirt_type]) == "undefined") {
      return null;
    }
    var colors = [], color;
    for (var x in samples[shirt_type]) {
      color = samples[shirt_type][x].color;
      colors.push(color);
    }
    return colors;
  },

  get_shirt_color: function(shirt_type, color_type) {
    var samples = this.samples;
    if (typeof(samples[shirt_type]) == "undefined") {
      return null;
    }
    for (var x in samples[shirt_type]) {
      if (color_type == samples[shirt_type][x].color.name) {
        return samples[shirt_type][x].color;
      }
    }
    return null;
  },

  get_shirt_img: function(shirt_type, color_type, side_type) {
    var samples = this.samples;
    if (typeof(samples[shirt_type]) == "undefined") {
      return null;
    }
    for (var x in samples[shirt_type]) {
      if (color_type == samples[shirt_type][x].color.name) {
        for (var y in samples[shirt_type][x]['images']) {
          if (side_type == samples[shirt_type][x]['images'][y].type) {
            return samples[shirt_type][x]['images'][y].img;
          }
        }
      }
    }
    return null;
  },

  get_shirt_size: function(shirt_type, color_type, side_type) {
    var samples = this.samples;
    if (typeof(samples[shirt_type]) == "undefined") {
      return null;
    }
    for (var x in samples[shirt_type]) {
      if (color_type == samples[shirt_type][x].color.name) {
        for (var y in samples[shirt_type][x]['images']) {
          if (side_type == samples[shirt_type][x]['images'][y].type) {
            var size = samples[shirt_type][x]['images'][y].size;
            return {
              "width": size[0],
              "height": size[1]
            };
          }
        }
      }
    }
    return null;
  },

  get_shirt_frame: function(shirt_type, color_type, side_type) {
    var samples = this.samples;
    if (typeof(samples[shirt_type]) == "undefined") {
      return null;
    }
    for (var x in samples[shirt_type]) {
      if (color_type == samples[shirt_type][x].color.name) {
        for (var y in samples[shirt_type][x]['images']) {
          if (side_type == samples[shirt_type][x]['images'][y].type) {
            var frame = samples[shirt_type][x]['images'][y].frame;
            return {
              "width": frame[0],
              "height": frame[1],
              "left": frame[2],
              "top": frame[3]
            };
          }
        }
      }
    }
    return null;
  },

  get_shirt_shrink_factor: function(shirt_type, color_type, side_type) {
    var samples = this.samples;
    if (typeof(samples[shirt_type]) == "undefined") {
      return null;
    }
    for (var x in samples[shirt_type]) {
      if (color_type == samples[shirt_type][x].color.name) {
        for (var y in samples[shirt_type][x]['images']) {
          if (side_type == samples[shirt_type][x]['images'][y].type) {
            return samples[shirt_type][x]['images'][y].shrink;
          }
        }
      }
    }
    return 1;
  }
};

var SmartPosition = {
  normal: function(n) {
    if (!isNaN(n)) {
      return Math.round(n);
    }
    return n;
  },
  
  center: function(w, h, fw, fh) {
    var left = 0, top = 0;
    if (fw > w) {
      left = this.normal((fw - w) / 2);
    }
    if (fh > h) {
      top = this.normal((fh - h) / 2);
    }
    return {
      "left": left,
      "top": top
    }
  },

  chest: function(w, h, fw, fh) {
    var left = 0, top = 0;
    if (fw * 2 / 10 > w / 2) {
      left = this.normal(fw - w - (fw * 2 / 10 - w /2));
    } else if (fw > w) {
      left = this.normal(fw - w);
    }
    if (fh * 2 / 10 > h / 2) {
      top = this.normal(fh * 2 / 10 - h / 2);
    }
    return {
      "left": left,
      "top": top
    }
  },

  hmiddle: function(w, h, fw, fh) {
    var left = 0, top = -1;
    if (fw > w) {
      left = this.normal((fw - w) / 2);
    }
    return {
      "left": left,
      "top": top
    }
  },

  vmiddle: function(w, h, fw, fh) {
    var left = -1, top = 0;
    if (fh > h) {
      top = this.normal((fh - h) / 2);
    }
    return {
      "left": left,
      "top": top
    }
  },

  pos: function(pos, design, frame) {
    var fw = frame.width(), fh = frame.height();
    var dw = design.width(), dh = design.height();
    if ("center" == pos) {
      return this.center(dw, dh, fw, fh);
    }
    if ("chest" == pos) {
      return this.chest(dw, dh, fw, fh);
    }
    if ("hmiddle" == pos) {
      return this.hmiddle(dw, dh, fw, fh);
    }
    if ("vmiddle" == pos) {
      return this.vmiddle(dw, dh, fw, fh);
    }
    return {
      "left": 0,
      "top": 0
    };
  }
};

var TeekerItDesign = function(id) {
  this.id = id;
  this.images = {};
};
TeekerItDesign.default_img = "/v2/d.png";
TeekerItDesign.default_width = 500;
TeekerItDesign.default_height = 500;
TeekerItDesign.NOT_DETECT = "not_detect";
TeekerItDesign.DETECTING = "detecting";
TeekerItDesign.DETECTED = "detected";
TeekerItDesign.prototype = {
  init: function(id, images) {
    this.id = id;
    for (var type in images) {
      var image = images[type];
      this.add_image(type,
        image.local_file,
        image.server_file,
        image.width,
        image.height,
        image.left,
        image.top,
        image.colors,
        image.bg_color
        );
      this.set_color_detect_status(type, TeekerItDesign.DETECTED);
    }
  },
  add_image: function(type, lf, sf, w, h, left, top, colors, bgcolor) {
    this.images[type] = {
      'local': lf,
      'server': sf,
      'width': w,
      'height': h,
      'left': left,
      'top': top,
      'colors': colors,
      'bgcolor': ""
    }
    // color detect status: not_detect, detecting, detected
    this.images[type]['color_detect_status'] = TeekerItDesign.NOT_DETECT;
    if (arguments.length > 8) {
      this.images[type]['bgcolor'] = bgcolor;
    }
  },
  get_design_id: function() {
    return this.design_id;
  },
  exist: function(type) {
    if (typeof(this.images[type]) != "undefined") {
      return true;
    }
    return false;
  },
  get_image: function(type) {
    if (this.exist(type)) {
      return this.images[type];
    }
    return null;
  },
  get_color_detect_status: function(type) {
    if (this.exist(type)) {
      return this.images[type]['color_detect_status'];
    }
    return null;
  },
  set_color_detect_status: function(type, status) {
    if (!this.exist(type)) {
      return;
    }
    this.images[type]['color_detect_status'] = status;
  },
  get_image_colors: function(type) {
    if (this.exist(type)) {
      return this.images[type]['colors'];
    }
    return [];
  },
  set_image_colors: function(type, colors) {
    if (!this.exist(type)) {
      return;
    }
    this.images[type]['colors'] = colors;
  },
  get_image_bgcolor: function(type) {
    if (this.exist(type)) {
      return this.images[type]['bgcolor'];
    }
    return "";
  },
  set_image_bgcolor: function(type, bgcolor) {
    if (!this.exist(type)) {
      return;
    }
    this.images[type]['bgcolor'] = bgcolor;
  },
  get_image_local: function(type) {
    if (this.exist(type)) {
      return this.images[type]['local'];
    }
    return "";
  },
  set_image_local: function(type, local_file) {
    if (!this.exist(type)) {
      return;
    }
    this.images[type]['local'] = local_file;
  },
  get_image_server: function(type, path) {
    if (this.exist(type)) {
      return path + this.images[type]['server'];
    }
    return TeekerItDesign.default_img;
  },
  set_image_server: function(type, server_file) {
    if (!this.exist(type)) {
      return;
    }
    this.images[type]['server'] = server_file;
  },
  get_image_width: function(type) {
    if (this.exist(type)) {
      return this.images[type]['width'];
    }
    return TeekerItDesign.default_width;
  },
  set_image_width: function(type, width) {
    if (!this.exist(type)) {
      return;
    }
    this.images[type]['width'] = width;
  },
  get_image_height: function(type) {
    if (this.exist(type)) {
      return this.images[type]['height'];
    }
    return TeekerItDesign.default_height;
  },
  set_image_height: function(type, height) {
    if (!this.exist(type)) {
      return;
    }
    this.images[type]['height'] = height;
  },
  get_image_top: function(type) {
    if (this.exist(type)) {
      return this.images[type]['top'];
    }
    return 0;
  },
  set_image_top: function(type, top_margin) {
    if (!this.exist(type)) {
      return;
    }
    this.images[type]['top'] = top_margin;
  },
  get_image_left: function(type) {
    if (this.exist(type)) {
      return this.images[type]['left'];
    }
    return 0;
  },
  set_image_left: function(type, left_margin) {
    if (!this.exist(type)) {
      return;
    }
    this.images[type]['left'] = left_margin;
  },
  is_empty: function() {
    var c = 0, t;
    for (t in this.images) c++;
    return c == 0;
  },
  is_detecting: function() {
    for (var type in this.images) {
      if (this.images[type]['color_detect_status'] == TeekerItDesign.DETECTING) {
        return true;
      }
    }
    return false;
  }
};

var DesignEditorDialog = function(pic_path, dom_ids) {
  this.pic_path = pic_path;
  this.design = new TeekerItDesign();
  this.uploader = null;
  this.dom_ids = dom_ids;
  this.close_callback = null;
  this.current_shirt = null;
  this.current_color = null;
  this.current_side = "front";
};
DesignEditorDialog.prototype = {
  get_dialog_id: function() {
    return this.dom_ids.dialog_id;
  },
  get_dialog_dom: function() {
    return $("#" + this.dom_ids.dialog_id);
  },
  get_fup_id: function() {
    return this.dom_ids.fup_id;
  },
  get_fup_dom: function() {
    return $("#" + this.dom_ids.fup_id);
  },
  get_fqa_id: function() {
    return this.dom_ids.fqa_id;
  },
  get_fqa_dom: function() {
    return $("#" + this.dom_ids.fqa_id);
  },
  get_shirt_selector_dom: function() {
    return this.get_dialog_dom().find(".shirts");
  },
  get_tabs_dom: function() {
    return this.get_dialog_dom().find(".nav a");
  },
  get_shirt_dom: function() {
    return this.get_dialog_dom().find(".bgbox");
  },
  get_frame_dom: function() {
    return this.get_shirt_dom().children("div")
  },
  get_design_dom: function() {
    return this.get_frame_dom().find("img")
  },
  color_blocks: function() {
    return this.get_dialog_dom().find(".colors")
  },
  printint_price: function() {
    return this.get_dialog_dom().find(".price")
  },
  printint_method: function() {
    return this.get_dialog_dom().find(".printing")
  },
  clearbg_link: function() {
    return this.get_dialog_dom().find(".clearbg")
  },
  get_design_address_dom: function() {
    return this.get_dialog_dom().find(".address");
  },
  set_design_address: function(a) {
    return this.get_design_address_dom().text(a);
  },
  get_design_logo_dom: function() {
    return this.get_dialog_dom().find(".imgbox");
  },
  set_design_logo: function(img, w, h, ml, mt) {
    var d = this.get_design_logo_dom().children();
    $(d).attr("src", img);
    $(d).css("width", w);
    $(d).css("height", h);
    $(d).css("margin", mt + "px " + ml + "px");
  },
  get_smartpos_selector_dom: function() {
    return this.get_dialog_dom().find(".bit a");
  },
  get_close_dom: function() {
    return this.get_dialog_dom().find(".close");
  },
  get_confirm_dom: function() {
    return this.get_dialog_dom().find(".commitb");
  },
  get_left_side: function() {
    return this.get_dialog_dom().find(".picFile");
  },
  get_detect_loading_dom: function() {
    return this.get_dialog_dom().find(".loadingColor");
  },
  set_close_callback: function(callback) {
    this.close_callback = callback;
  },
  init: function() {
    var _this = this;
    // init dialog
    this.get_dialog_dom().dialog({
      autoOpen: false,
      modal: false,
      show: "fade",
      //hide:"fade",
      dialogClass: "dialogc",
      draggable: false,
      resizable: false,
      width: 935,
      position: ["center", "middle"],
      open: function(e, ui) {
        // add shadow layer
        var myid = _this.get_dialog_id();
        var zi = parseInt($("#" + myid).parent().css("z-index"));
        var dw = parseInt($("body").width())
        + parseInt($("body").css("padding-left"))
        + parseInt($("body").css("padding-right"));
        var dh = parseInt($("body").height())
        + parseInt($("body").css("padding-top"))
        + parseInt($("body").css("padding-bottom"));
        $('<div class="ui-widget-overlay" style="width:' + dw + 'px;height:'
          + dh + 'px;z-index:' + zi + ';"></div>').appendTo($("body"));
        $("#" + myid).parent().css("z-index", zi + 1);

        // init uploader
        _this.uploader = new UploadWrapper(_this.get_fup_id(), _this.get_fqa_id(),
          $.proxy(_this, "after_upload"), $.proxy(_this, "waiting_upload"));
        _this.uploader.init();
      },
      close: function(e, ui) {
        // remove shadow layer
        $(".ui-widget-overlay").remove();

        // destroy uploader
        _this.get_fup_dom().uploadify("destroy");
        _this.get_fup_dom().empty();
        if (_this.close_callback != null) {
          _this.close_callback(_this.design);
        }
      }
    });
    // bind KEY.ESC press event
    //    $(document).keypress(function(e) {
    //      if (e.which == 27) {
    //        if (_this.get_dialog_dom().dialog("isOpen")) {
    //          _this.close();
    //        }
    //      }
    //    });

    // init shirts
    for (var st in SampleShirts.samples) {
      this.get_shirt_selector_dom().append($("<option>" + st + "</option>"));
    }
    this.get_shirt_selector_dom().change(function() {
      var wrap = _this.get_shirt_selector_dom().parent();
      wrap.siblings("p").remove();
      var st = $(this).find("option:selected").text()
      _this.current_shirt = st;

      var colors = SampleShirts.get_shirt_colors(st);
      var p = $("<p></p>");
      for (var x in colors) {
        var rgb = colors[x].rgb, color = colors[x].name;
        $(p).append($( '<span color="' + color
          + '" class="blocks" style="background:' + rgb + '"></span>'));
      }
      wrap.before($(p));
      wrap.siblings("p").find(".blocks").click(function() {
        _this.current_color = $(this).attr("color");
        _this.refresh();
      });
      wrap.siblings("p").find(".blocks:eq(0)").click();
    });
    this.get_shirt_selector_dom().change();

    // init tab switch
    this.get_tabs_dom().click(function(e) {
      e.preventDefault();
      if ($(this).parent().hasClass("current")) return;
      $(this).parent().siblings().removeClass("current");
      $(this).parent().addClass("current");
      _this.current_side = $(this).parent().attr("side");
      _this.refresh();
    });
    this.get_tabs_dom().first().click();

    // smart pos
    this.get_smartpos_selector_dom().click(function(e) {
      e.preventDefault();
      var pos = $(this).attr("pos");
      _this.smart_pos(pos);
      _this.refresh();
    });

    //
    this.clearbg_link().click(function(e){
      e.preventDefault();
      _this.clear_bg();
      _this.refresh();
    })
    this.get_close_dom().click(function(e) {
      e.preventDefault();
      _this.close();
    });
    this.get_confirm_dom().click(function(e) {
      e.preventDefault();
      _this.close();
    });
  },
  close: function() {
    if (this.design.is_detecting()) {
      alert("颜色识别正在进行中，请稍等片刻..."); // TODO timeout...
      return;
    }
    this.get_dialog_dom().dialog("close");
  },
  waiting_upload: function() {
    var frame_dom = this.get_frame_dom();
    var frame_size = {
      "width": parseInt($(frame_dom).width()),
      "height": parseInt($(frame_dom).height())
    };
    var style = "border:0px;padding:0px;margin-left:" + ((frame_size.width-32)/2)
    + "px;margin-top:" + ((frame_size.height-32)/2) + "px;";
    $(frame_dom).empty();
    $(frame_dom).append($('<img style="' + style + '" src="/v2/loading_color.gif" />'));
  },
  after_upload: function(lf, sf, w, h) {
    var side = this.current_side;
    if (!this.design.exist(side)) {
      this.design.add_image(side, lf.name, sf, w, h, 50, 50, []);
    } else {
      this.design.set_image_local(side, lf.name);
      this.design.set_image_server(side, sf);
      this.design.set_image_width(side, w);
      this.design.set_image_height(side, h);
      this.design.set_image_colors(side, []);
    }
    this.detect_colors();
    this.refresh();
  },
  open: function(design) {
    if (design != null) {
      this.design = design;
    }
    this.get_dialog_dom().dialog("open");
    this.refresh();
  },
  refresh: function() {
    this.refresh_uploader();
    this.set_sample_shirt();
    this.set_design();
    this.set_design_colors();
    var browser = TeekerItConst.browser();
    if (browser.ie) {
      if (browser.ie == "6.0" && this.get_dialog_dom().dialog("isOpen")) {
        this.get_dialog_dom().css("height", "auto");
      }
    }
  },
  refresh_uploader: function() {
    if (this.uploader == null) {
      return;
    }

    var side = this.current_side;
    if (this.design.exist(side)) {
      this.uploader.change_button_image(UploadWrapper.ButtonImage2);
    } else {
      this.uploader.change_button_image(UploadWrapper.ButtonImage1);
    }
  },
  set_design_colors: function() {
    if (this.design.is_empty()) {
      return;
    }

    this.get_left_side().css("height", "500px");
    var side = this.current_side;
    if (!this.design.exist(side)
      || this.design.get_color_detect_status(side) == TeekerItDesign.NOT_DETECT) {
      this.color_blocks().html("&nbsp;");
      this.color_blocks().show();
      this.printint_price().parent().hide();
      //this.printint_price().parents(".cost").hide();
      this.clearbg_link().prev().empty();
      this.clearbg_link().hide();
      this.get_detect_loading_dom().hide();
      return;
    }

    var bgcolor = this.design.get_image_bgcolor(side);
    if (this.design.get_color_detect_status(side) == TeekerItDesign.DETECTING) {
      this.color_blocks().html("&nbsp;");
      this.color_blocks().show();
      this.printint_price().parent().show();
      this.printint_price().parents(".cost").show();
      if (bgcolor != "") {
        this.clearbg_link().prev().text("正在清除上传图的背景色，请稍等...");
      } else {
        this.clearbg_link().prev().text("正在识别上传图的颜色，请稍等...");
      }
      this.clearbg_link().prev().addClass("fontGreen");
      this.clearbg_link().hide();
      this.get_detect_loading_dom().show();
      return;
    }

    var colors = this.design.get_image_colors(side);
    var content = "", print_method = "热转印", print_price = 15;//TODO price?
    if (colors.length == 0) {
      content = "系统暂时无法识别您的图案颜色";
    } else {
      content = "系统检测到您的图案中共有" + colors.length + "个颜色，分别是";
      for (var x in colors) {
        content += '<span class="blocks" style="background-color:#' + colors[x]
        + '"></span>';
      }
      if (colors.length < 10) {
        print_method = "丝网印";
        print_price = colors.length
      }
    }
    this.color_blocks().html(content);
    this.color_blocks().show();
    this.printint_method().text(print_method);
    this.printint_price().text(print_price);
    this.printint_price().parent().show();
    this.printint_price().parents(".cost").show();
    if (bgcolor != "") {
      content = '系统检测到您的图案背景色是<span class="blocks"'
      + 'style="background-color:#' + bgcolor + '"></span>，需要清除吗？';
      this.clearbg_link().show();
    } else {
      content ="";
      this.clearbg_link().hide();
    }
    this.clearbg_link().prev().html(content)
    this.clearbg_link().prev().removeClass("fontGreen");
    this.get_detect_loading_dom().hide();
  },

  set_sample_shirt: function() {
    var shirt = this.current_shirt,
    color = this.current_color,
    side = this.current_side;

    // set shirt
    var shirt_dom = this.get_shirt_dom();
    var shirt_img = SampleShirts.get_shirt_img(shirt, color, side);
    $(shirt_dom).css("background", "url(" + shirt_img + ") no-repeat transparent");

    // set frame
    var shirt_size = SampleShirts.get_shirt_size(shirt, color, side);
    var frame = SampleShirts.get_shirt_frame(shirt, color, side);
    var params = {
      "base_width": TeekerItConst.default_shirt_width,
      "base_height": TeekerItConst.default_shirt_height,
      "width": shirt_size.width,
      "height": shirt_size.height,
      "frame_width": frame.width,
      "frame_height": frame.height,
      "frame_margin_left": frame.left,
      "frame_margin_top": frame.top
    };
    var frame_size = TeekerItConst.frame(params);
    var frame_dom = this.get_frame_dom();
    $(frame_dom).css("width", frame_size.width + "px");
    $(frame_dom).css("height", frame_size.height + "px");
    $(frame_dom).css("margin-left", frame_size.margin_left + "px");
    $(frame_dom).css("margin-top", frame_size.margin_top + "px");
    var rev_rgb = SampleShirts.get_shirt_color(shirt, color).rev_rgb;
    $(frame_dom).css("border", "1px dashed " + rev_rgb);
    $(frame_dom).css("position", "absolute");
  },

  set_design: function() {
    var shirt = this.current_shirt,
    color = this.current_color,
    side = this.current_side;

    var design_img = this.design.get_image_server(side, this.pic_path);
    var design_width = this.design.get_image_width(side);
    var design_height = this.design.get_image_height(side);
    var design_left_margin = this.design.get_image_left(side);
    var design_top_margin = this.design.get_image_top(side);
    var design_size = {
      "width": design_width,
      "height": design_height,
      "left": design_left_margin,
      "top": design_top_margin
    };

    // local file
    var local_file = this.design.get_image_local(side);
    this.set_design_address(local_file);

    // design logo
    var sus = TeekerItConst.suspension({
      "width": 120,
      "height":120
    }, design_size);
    this.set_design_logo(design_img, sus.width, sus.height, sus.left, sus.top);

    // design render
    var shirt_size = SampleShirts.get_shirt_size(shirt, color, side);
    var shrink = SampleShirts.get_shirt_shrink_factor(shirt, color, side);
    shirt_size["base_width"] = TeekerItConst.default_shirt_width;
    shirt_size["base_height"] = TeekerItConst.default_shirt_height;
    shirt_size["shrink_factor"] = shrink;
    var frame_dom = this.get_frame_dom();
    var frame_size = {
      "width": parseInt($(frame_dom).width()),
      "height": parseInt($(frame_dom).height())
    };

    var poly = TeekerItConst.poly(shirt_size, frame_size, design_size);
    var poly_style = "border:0px;margin:0px;padding:0px;width:" + poly.width
    + "px;height:" + poly.height + "px;";
    $(frame_dom).empty();
    $(frame_dom).append($('<img style="' + poly_style + '" src="' + design_img + '" />'));
    if (!this.design.exist(side)) return;

    // resizable
    var poly_dom = this.get_design_dom();
    $(poly_dom).resizable({
      "aspectRatio": true,
      "containment": "parent",
      "stop": $.proxy(this, "after_drag_resize")
    });
    $(poly_dom).css("margin", "0px");

    // draggable
    var rev_rgb = SampleShirts.get_shirt_color(shirt, color).rev_rgb;
    $(poly_dom).parent().css("cursor", "move");
    $(poly_dom).parent().css("border", "1px dotted " + rev_rgb);
    $(poly_dom).css("width", (poly.width - 2) + "px");
    $(poly_dom).css("height", (poly.height - 2) + "px");
    $(poly_dom).parent().css("width", (poly.width - 2) + "px");
    $(poly_dom).parent().css("height", (poly.height - 2) + "px");
    $(poly_dom).parent().css("left", poly.margin_left + "px");
    $(poly_dom).parent().css("top", poly.margin_top + "px");
    $(poly_dom).parent().draggable({
      "containment": "parent",
      "stop": $.proxy(this, "after_drag_resize")
    });

    // hover for hide boders
    $(frame_dom).unbind("hover");
    $(frame_dom).hover(function(e) {
      $(this).css("border-color", rev_rgb);
      $(this).children("div").css("border-color", rev_rgb);
      $(this).children("div").children("div").show();
    }, function(e) {
      $(this).css("border-color", "transparent");
      $(this).children("div").css("border-color", "transparent");
      $(this).children("div").children("div").hide();
    });
  },

  after_drag_resize: function() {
    var shirt = this.current_shirt,
    color = this.current_color,
    side = this.current_side;

    // poly
    var poly_dom = this.get_design_dom().parent();
    var poly_width = parseInt($(poly_dom).width());
    var poly_height = parseInt($(poly_dom).height());
    var poly_margin_left = parseInt($(poly_dom).css("left"));
    var poly_margin_top = parseInt($(poly_dom).css("top"));
    var horizonal_border = parseInt($(poly_dom).css("border-left-width")) +
    parseInt($(poly_dom).css("border-right-width"));
    var vertical_border = parseInt($(poly_dom).css("border-top-width")) +
    parseInt($(poly_dom).css("border-bottom-width"));
    var poly_size = {
      "width": poly_width + horizonal_border,
      "height": poly_height + vertical_border,
      "margin_left": poly_margin_left,
      "margin_top": poly_margin_top
    };

    // shirt
    var shirt_size = SampleShirts.get_shirt_size(shirt, color, side);
    var shrink = SampleShirts.get_shirt_shrink_factor(shirt, color, side);
    var frame_dom = this.get_frame_dom();
    shirt_size["base_width"] = TeekerItConst.default_shirt_width;
    shirt_size["base_height"] = TeekerItConst.default_shirt_height;
    shirt_size["frame_width"] = parseInt($(frame_dom).width());
    shirt_size["frame_height"] = parseInt($(frame_dom).height());
    shirt_size["shrink_factor"] = shrink;

    // reverse
    var reversed_size = TeekerItConst.reverse(shirt_size, poly_size);
    this.design.set_image_width(side, reversed_size.width);
    this.design.set_image_height(side, reversed_size.height);
    this.design.set_image_left(side, reversed_size.margin_left);
    this.design.set_image_top(side, reversed_size.margin_top);
  },

  smart_pos: function(pos) {
    var shirt = this.current_shirt,
    color = this.current_color,
    side = this.current_side;

    // shirt & frame
    var shirt_size = SampleShirts.get_shirt_size(shirt, color, side);
    var shrink = SampleShirts.get_shirt_shrink_factor(shirt, color, side);
    var frame_dom = this.get_frame_dom();
    var frame_size = {
      "width": parseInt($(frame_dom).width()),
      "height": parseInt($(frame_dom).height())
    };
    shirt_size["base_width"] = TeekerItConst.default_shirt_width;
    shirt_size["base_height"] = TeekerItConst.default_shirt_height;
    shirt_size["frame_width"] = frame_size.width;
    shirt_size["frame_height"] = frame_size.height;
    shirt_size["shrink_factor"] = shrink;

    // design
    var poly_dom = this.get_design_dom().parent();
    var poly_width = parseInt($(poly_dom).width());
    var poly_height = parseInt($(poly_dom).height());
    var horizonal_border = parseInt($(poly_dom).css("border-left-width")) +
    parseInt($(poly_dom).css("border-right-width"));
    var vertical_border = parseInt($(poly_dom).css("border-top-width")) +
    parseInt($(poly_dom).css("border-bottom-width"));
    var poly_size = {
      "width": poly_width + horizonal_border,
      "height": poly_height + vertical_border
    };

    // smart position
    var spos = SmartPosition.pos(pos, poly_size, frame_size);
    if (spos.left >= 0) {
      poly_size["margin_left"] = spos.left;
    } else {
      poly_size["margin_left"] = parseInt($(poly_dom).css("left"));
    }
    if (spos.top >= 0) {
      poly_size["margin_top"] = spos.top;
    } else {
      poly_size["margin_top"] = parseInt($(poly_dom).css("top"));
    }

    // reverse
    var reversed_size = TeekerItConst.reverse(shirt_size, poly_size);
    this.design.set_image_width(side, reversed_size.width);
    this.design.set_image_height(side, reversed_size.height);
    this.design.set_image_left(side, reversed_size.margin_left);
    this.design.set_image_top(side, reversed_size.margin_top);
  },
  detect_colors: function() {
    var _this = this;
    var side = this.current_side;
    this.design.set_color_detect_status(side, TeekerItDesign.DETECTING);
    var design_img = this.design.get_image_server(side, "");
    var data = {
      "type": side,
      "image": design_img
    };
    var url = "/designs/detect_colors";
    $.ajax({
      url: url,
      type: 'post',
      data: data,
      async: true,
      dataType: 'json',
      timeout: 30*1000,
      success: function(r) {
        _this.design.set_color_detect_status(r.type, TeekerItDesign.DETECTED);
        if (r.status) {
          _this.design.set_image_colors(r.type, r.colors);
          _this.design.set_image_bgcolor(r.type, r.bgcolor);
        } else {
          _this.design.set_image_colors(r.type, []);
          _this.design.set_image_bgcolor(r.type, "");
        }
        _this.refresh();
      },
      error: function(jqXHR, textStatus, errorThrown){
        if (textStatus == "timeout") {
          var splits = this.data.split("&");
          var type = "";
          for (var i in splits) {
            if (splits[i].indexOf("type") == 0) {
              type = splits[i].substring(5);
            }
          }
          if (type == "") return;
          _this.design.set_color_detect_status(type, TeekerItDesign.DETECTED);
          _this.design.set_image_colors(type, []);
          _this.design.set_image_bgcolor(type, "");
          _this.refresh();
        }
      }
    });
  },
  clear_bg: function() {
    var _this = this;
    var side = this.current_side;
    this.design.set_color_detect_status(side, TeekerItDesign.DETECTING);
    var design_img = this.design.get_image_server(side, ""),
    design_width = this.design.get_image_width(side),
    design_height = this.design.get_image_height(side);
    var data = {
      "type": side,
      "image": design_img,
      "width": design_width,
      "height": design_height
    };
    var url = "/designs/clear_background";
    $.ajax({
      url: url,
      type: 'post',
      data: data,
      async: true,
      dataType: 'json',
      timeout: 30*1000,
      success: function(r) {
        _this.design.set_color_detect_status(r.type, TeekerItDesign.DETECTED);
        if (r.status) {
          _this.design.set_image_server(side, r.f);
          _this.design.set_image_colors(r.type, r.colors);
        }
        _this.refresh();
      },
      error: function(jqXHR, textStatus, errorThrown){
        if (textStatus == "timeout") {
          var splits = this.data.split("&");
          var type = "";
          for (var i in splits) {
            if (splits[i].indexOf("type") == 0) {
              type = splits[i].substring(5);
            }
          }
          if (type == "") return;
          _this.design.set_color_detect_status(type, TeekerItDesign.DETECTED);
          _this.refresh();
        }
      }
    });
  }
};

var ShirtAppendDialog = function(pic_path, id) {
  this.pic_path = pic_path;
  this.dialog_id = id;
  this.clost_callback = null;
};
ShirtAppendDialog.prototype = {
  get_dialog: function() {
    return $("#" + this.dialog_id);
  },
  close_button: function() {
    return this.get_dialog().find(".close");
  },
  commit_button: function() {
    return this.get_dialog().find(".commitb");
  },
  selector_area: function() {
    return this.get_dialog().find(".selectors");
  },
  set_close_callback: function(callback) {
    this.close_callback = callback;
  },
  checkbox_selectors: function(d) {
    if (arguments.length > 0) {
      return $(d).find("input[type=checkbox]");
    }
    return this.selector_area().find("input[type=checkbox]");
  },
  init: function(render) {
    var _this = this;
    var browser = TeekerItConst.browser();
    var height = "auto";
    if (browser.ie) {
      height = "660";
    } else {
      this.selector_area().css("height", "600px");
      this.selector_area().css("overflow-y", "scroll");
    }
    this.get_dialog().dialog({
      autoOpen: false,
      modal: true,
      show: "fade",
      hide:"fade",
      dialogClass: "dialogc",
      draggable: false,
      resizable: false,
      width: 980,
      height: height,
      position: ["center", "middle"]
    });

    this.selector_area().delegate("ul .color", "hover", function() {
      var dom = $(this).parents("li").find("img").first();
      $(dom).attr("front", $(this).attr("front"));
      $(dom).attr("back", $(this).attr("back"));
      render($(this).parents("li"));
    });
    this.selector_area().delegate("ul div", "click", function(e) {
      $(this).parent().toggleClass("election");
      if (_this.checkbox_selectors($(this).parent()).attr("checked")) {
        _this.checkbox_selectors($(this).parent()).attr("checked", false);
      } else {
        _this.checkbox_selectors($(this).parent()).attr("checked", true);
      }
    });
    this.selector_area().delegate("ul input[type=checkbox]", "click", function() {
      $(this).parents("li").toggleClass("election");
    });
    this.close_button().click(function(e) {
      _this.get_dialog().dialog("close");
    });
    this.commit_button().click(function(e) {
      e.preventDefault();
      _this.commit();
    });
  },
  open: function(content) {
    this.selector_area().empty();
    this.selector_area().append($(content));
    this.get_dialog().dialog("open");
  },
  commit: function() {
    var selected_ids = [];
    this.checkbox_selectors().each(function(){
      if ($(this).attr("checked")) {
        selected_ids.push($(this).parents("li").attr("sid"));
      }
    });

    this.get_dialog().dialog("close");
    if (this.close_callback != null) {
      this.close_callback(selected_ids);
    }
  }
};

var ShirtChooseControl = function(pic_path, design) {
  this.pic_path = pic_path;
  if (arguments.length > 1) {
    this.design = design;
  } else {
    this.design = null;
  }
  this.editor = null;
  this.append_dialog = null;
  this.current_side = "front";
  this.myselect = {};
};
ShirtChooseControl.prototype = {
  get_editor_ids: function() {
    return {
      "dialog_id": "editord",
      "fup_id": "fup",
      "fqa_id": "fqa"
    };
  },
  get_append_dialog_id: function() {
    return "appendd";
  },
  main_area: function(ts) {
    if (arguments.length > 0) {
      return $("div[ts=" + ts + "]");
    }
    return $(".listbox");
  },
  color_boxes: function() {
    return this.main_area().find(".color");
  },
  shirt_lists: function(ts) {
    if (arguments.length > 0) {
      return this.main_area(ts).find("li");
    }
    return this.main_area().find("li");
  },
  shirt_image_dom: function(d) {
    return $(d).find("img").first();
  },
  checkbox_selectors: function(d) {
    if (arguments.length > 0) {
      return $(d).find("input[type=checkbox]");
    }
    return this.shirt_lists().find("input[type=checkbox]");
  },
  adjust_link: function() {
    return $("#adjust");
  },
  commit_button: function() {
    return $(".previewb");
  },
  side_tabs: function(side) {
    if (arguments.length > 0) {
      return $(".tabnav li[side=" + side + "]");
    }
    return $(".tabnav li");
  },
  style_tabs: function(c) {
    return $(".tabBoxL li");
  },
  get_current_ts: function() {
    var ts = 0;
    this.style_tabs().each(function(){
      if ($(this).hasClass("current")) {
        ts = $(this).attr("ts");
      }
    });
    return ts;
  },
  append_buttons: function() {
    return this.main_area().find(".addCom");
  },
  selcnt_area: function() {
    return $(".selcnt");
  },
  init: function() {
    var _this = this;
    this.editor = new DesignEditorDialog(this.pic_path, this.get_editor_ids());
    this.editor.init();
    this.editor.set_close_callback($.proxy(this, "after_editor"));
    this.append_dialog = new ShirtAppendDialog(this.pic_path,
      this.get_append_dialog_id());
    this.append_dialog.init($.proxy(this, "render_one"));
    this.append_dialog.set_close_callback($.proxy(_this, "append"));

    if (this.design == null) {
      this.editor.open();
    } else {
      this.render();
    }
    this.count();

    // bind events
    this.style_tabs().click(function(e){
      e.preventDefault();
      if ($(this).hasClass("current")) return;
      _this.style_tabs().removeClass("current");
      $(this).addClass("current");
      var ts = $(this).attr("ts");
      _this.main_area(ts).siblings().each(function(){
        if ($(this).attr("ts") != undefined && $(this).attr("ts") != ts) {
          var myselect = [];
          _this.checkbox_selectors($(this)).each(function() {
            if ($(this).attr("checked")) {
              myselect.push($(this).parents("li").attr("sid"));
              $(this).click();
            }
          });
          _this.myselect[$(this).attr("ts")] = myselect;
          $(this).hide();
        }
      });
      _this.main_area(ts).show();
      _this.render();
      if (_this.myselect[ts] != undefined) {
        _this.checkbox_selectors(_this.main_area(ts)).each(function() {
          for (var x in _this.myselect[ts]) {
            if ($(this).parents("li").attr("sid") == _this.myselect[ts][x]) {
              $(this).click();
            }
          }
        });
      }
      _this.count();
    });
    this.side_tabs().click(function(e) {
      e.preventDefault();
      if ($(this).hasClass("current")) return;
      _this.side_tabs().removeClass("current");
      $(this).addClass("current");
      _this.current_side = $(this).attr("side");
      _this.render();
    });
    this.append_buttons().click(function(e) {
      e.preventDefault();
      var ts = _this.get_current_ts(), style_ids = [];
      _this.shirt_lists(ts).each(function(){
        if ($(this).attr("sid") != undefined) {
          style_ids.push($(this).attr("sid"));
        }
      });
      var content = $("<div><div>"), cnt = 0,
      ul = $('<ul class="itMyStylel clearfix"></ul>');
      _this.shirt_lists("all").each(function(){
        var sid = $(this).attr("sid"), tag = true;
        if (sid == undefined) return;
        for (var x in style_ids) {
          if (style_ids[x] == sid) tag = false;
        }
        if (tag) {
          if (cnt > 0 && cnt % 4 ==0) {
            content.append($(ul));
            ul = $('<ul class="itMyStylel clearfix"></ul>');
          }
          ul.append($(this).clone(true));
          cnt++;
        }
      });
      content.append($(ul));
      _this.append_dialog.open($(content).html());
    });
    this.adjust_link().click(function(e) {
      e.preventDefault();
      _this.editor.open(_this.design);
    });
    this.color_boxes().hover(function() {
      var dom = _this.shirt_image_dom($(this).parents("li"));
      $(dom).attr("front", $(this).attr("front"));
      $(dom).attr("back", $(this).attr("back"));
      _this.render_one($(this).parents("li"));
    });
    this.shirt_lists().delegate("div", "click", function(e) {
      $(this).parent().toggleClass("election");
      if (_this.checkbox_selectors($(this).parent()).attr("checked")) {
        _this.checkbox_selectors($(this).parent()).attr("checked", false);
      } else {
        _this.checkbox_selectors($(this).parent()).attr("checked", true);
      }
      _this.count();
    });
    this.checkbox_selectors().click(function(e) {
      $(this).parents("li").toggleClass("election");
      _this.count();
    });
    this.commit_button().click(function(e) {
      e.preventDefault();
      _this.commit();
    });

    // TODO
    $("input[name=data\\[pick_colors\\]]").click(function() {
      if ($(this).attr("checked")) {
        _this.commit_button().text("选择颜色");
      } else {
        _this.commit_button().text("设置价格");
      }
    });

    // record myselects
    this.style_tabs().each(function(){
      if ($(this).hasClass("current")) return;
      var ts = $(this).attr("ts");
      var myselect = [];
      _this.checkbox_selectors(_this.main_area(ts)).each(function(){
        if ($(this).attr("checked")) {
          myselect.push($(this).parents("li").attr("sid"));
          $(this).click();
        }
      });
      _this.myselect[ts] = myselect;
    });
  },
  after_editor: function(design) {
    this.sync(design);
    this.render();
  },
  render: function() {
    var _this = this;
    this.shirt_lists().each(function() {
      _this.render_one($(this));
    });
  },
  render_one: function(d) {
    if (this.design == null) return;
    var side = this.current_side;
    var dom = this.shirt_image_dom(d);
    if ($(dom).attr(side) == undefined) return;
    var data = $(dom).attr(side).split(";");
    $(dom).attr("src", this.pic_path + data[0]);
    $(dom).siblings("img").remove();
    var design_image = this.design.get_image(side);
    if (design_image == null) return;
    var shirt = {
      "base_width": TeekerItConst.default_shirt_width,
      "base_height": TeekerItConst.default_shirt_height,
      "width": parseInt($(dom).width()),
      "height": parseInt($(dom).height()),
      "frame_width": data[1],
      "frame_height": data[2],
      "frame_margin_left": data[3],
      "frame_margin_top": data[4],
      "shrink_factor": data[5]
    };
    var frame = TeekerItConst.frame(shirt);
    var poly = TeekerItConst.poly(shirt, frame, design_image);
    var img = this.pic_path + design_image.server;
    var style = "width:" + poly.width + "px;height:" + poly.height
    + "px;left:" + (frame.margin_left + poly.margin_left)
    + "px;top:" + (frame.margin_top + poly.margin_top) + "px;";
    var content = '<img src="' + img + '" style="' + style + '"/>';
    $(dom).after($(content));
  },
  append: function(ids) {
    var _this = this;
    if (ids.length == 0) return;
    var ts = this.get_current_ts();
    var but = this.main_area(ts).children("ul:last").children("li:last").clone(true);
    this.main_area(ts).children("ul:last").children("li:last").remove();
    var cnt = this.main_area(ts).children("ul:last").children("li").length;
    var ul = this.main_area(ts).children("ul:last");
    this.shirt_lists("all").each(function(){
      var sid = $(this).attr("sid"), tag = false;
      if (sid == undefined) return;
      for (var x in ids) {
        if (ids[x] == sid) tag = true;
      }
      if (tag) {
        if (cnt > 0 && cnt % 4 == 0) {
          _this.main_area(ts).append($(ul));
          ul = $('<ul class="listbox clearfix"></ul>');
        }
        ul.append($(this).clone(true));
        cnt++;
      }
    });
    if (cnt % 4 != 0) {
      ul.append($(but));
    } else {
      this.main_area(ts).append($(ul));
      ul = $('<ul class="listbox clearfix"></ul>');
      ul.append($(but));
      cnt++;
    }
    if (cnt > 4) {
      this.main_area(ts).append($(ul));
    }
    this.render();
    this.shirt_lists(ts).each(function(){
      var sid = $(this).attr("sid");
      if (sid == undefined) return;
      for (var x in ids) {
        if (ids[x] == sid) _this.checkbox_selectors($(this)).click();
      }
    });
    _this.count();
  },
  sync: function(design) {
    this.design = design;
    var url = "/stores/mydesign";
    $.ajax({
      url: url,
      data: {
        "images": design.images
      },
      type: 'post',
      async: true,
      dataType: 'json',
      success: function(r) {
        if (r.status) {
        // TODO
        } else {
        // TOO
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
      // alert(textStatus); TODO
      }
    });
  },
  count: function() {
    var cnt = 0;
    var ts = this.get_current_ts();
    this.checkbox_selectors(this.main_area(ts)).each(function() {
      if ($(this).attr("checked")) {
        cnt ++;
      }
    });
    this.selcnt_area().text(cnt);
  },
  commit: function() {
    if (this.shirt_lists().find("input[type=checkbox]:checked").length == 0) {
      alert("请选择底衫！"); // TODO
      return false;
    }
    this.commit_button().parents("form").submit();
    return true;
  }
};

var ColorChooseControl = function(pic_path, design) {
  this.pic_path = pic_path;
  this.design = design;
};
ColorChooseControl.prototype = {
  tabs: function(side) {
    if (arguments.length > 0) {
      return $(".nav li[side=" + side + "]");
    }
    return $(".nav li");
  },
  product_lists: function() {
    return $(".listbox li");
  },
  reback_link: function() {
    return $(".reback");
  },
  commit_button: function() {
    return $(".previewb");
  },
  init: function() {
    var _this = this;
    this.tabs().click(function(e) {
      e.preventDefault();
      if ($(this).hasClass("current")) return;
      var side = $(this).attr("side");
      _this.tabs().removeClass("current");
      _this.tabs(side).addClass("current");
      _this.product_lists().each(function(){
        var dom = $(this).find("img:eq(0)");
        var data = $(dom).attr(side);
        if (data == undefined) return;
        data = data.split(",");
        var img = _this.pic_path + data[0];
        $(dom).attr("src", img);
        $(dom).siblings("img").remove();
        if (data.length > 0 && typeof(_this.design[side]) != "undefined") {
          img = _this.pic_path + _this.design[side]['image'];
          var style = "border:0px;margin:0px;" + data[1];
          var content = '<img src="' + img + '" style="' + style + '"/>';
          $(dom).after($(content));
        }
      });
    });
    this.tabs().first().click();

    this.product_lists().click(function(e) {
      e.preventDefault();
      if ($(this).hasClass("election")) {
        $(this).children("input[type=checkbox]").attr("checked", false);
      } else {
        $(this).children("input[type=checkbox]").attr("checked", true);
      }
      $(this).toggleClass("election");
    });
    this.reback_link().click(function(e) {
      e.preventDefault();
      window.location = "/stores/teekerit_choose_shirt"; // TODO
    });
    this.commit_button().click(function(e) {
      e.preventDefault();
      _this.commit();
    });
  },
  commit: function() {
    if (this.product_lists().find("input[type=checkbox]:checked").length == 0) {
      alert("您没有选择商品！"); // TODO
      return false;
    }
    this.commit_button().parents("form").submit();
    return true;
  }
};

var SettingControl = function(pic_path, design) {
  this.pic_path = pic_path;
  this.design = design;
  this.login_check = null;
};
SettingControl.prototype = {
  tabs: function(side) {
    if (arguments.length > 0) {
      return $(".nav li[side=" + side + "]");
    }
    return $(".nav li");
  },
  product_lists: function() {
    return $(".listbox li");
  },
  profit_input: function() {
    return $("input[name=data\\[profit\\]]");
  },
  reback_link: function() {
    return $(".reback");
  },
  commit_button: function() {
    return $(".previewb");
  },
  slider_area: function() {
    return $(".reach");
  },
  income_area: function() {
    return $(".itMyIncome");
  },
  price_area: function() {
    return $(".itMyPrice");
  },
  get_slider_val: function() {
    var val = this.slider_area().slider("value"), real_val = 0;
    if (val <= 5) real_val = 30 + Math.round(val * 4);
    if (val > 5 && val <= 15) real_val = 50 + Math.round((val - 5)/2) * 10;
    if (val > 15 && val <= 45) real_val = (val - 5) * 10;
    if (val > 45 && val <= 55) real_val = 400 + (val - 45) * 2 * 10;
    if (val > 55) real_val = 600 + (val - 55) * 4 * 10;
    return real_val;
  },
  anticipate: function() {
    var sold = this.get_slider_val();
    var profit = this.profit_input().val();
    if (sold < 100) {
      profit = sold * profit - 50 * this.design.colors;
      profit = (profit > 0) ? profit : 0;
    } else {
      profit = sold * profit;
    }
    $(".yousold").text(sold);
    $(".yougot").text(profit);
  },
  set_login_check: function(f) {
    this.login_check = f;
  },
  init: function() {
    var _this = this;
    this.slider_area().slider({
      "min": 0,
      "max": 70,
      "value": 15,
      "change": function(event, ui) {
        _this.anticipate();
      }
    });
    this.anticipate();
    this.check();
    this.tabs().click(function(e) {
      e.preventDefault();
      if ($(this).hasClass("current")) return;
      var side = $(this).attr("side");
      _this.tabs().removeClass("current");
      _this.tabs(side).addClass("current");
      _this.product_lists().each(function(){
        var dom = $(this).find("img:eq(0)");
        var data = $(dom).attr(side);
        if (data == undefined) return;
        data = data.split(",");
        var img = _this.pic_path + data[0];
        $(dom).attr("src", img);
        $(dom).siblings("img").remove();
        if (data.length > 0 && typeof(_this.design[side]) != "undefined") {
          img = _this.pic_path + _this.design[side]['image'];
          var style = "border:0px;" + data[1];
          var content = '<img src="' + img + '" style="' + style + '"/>';
          $(dom).after($(content));
        }
      });
    });
    this.tabs("front").click();

    this.profit_input().keyup(this, this.check);
    this.reback_link().click(function(e) {
      e.preventDefault();
      window.location = "/stores/teekerit_choose_shirt"; // TODO
    });
    this.commit_button().click(function(e) {
      e.preventDefault();
      if (_this.login_check != null) {
        _this.login_check($.proxy(_this, "commit"));
      } else {
        _this.commit();
      }
    });
    window.onscroll = function() {
      _this.scroll();
    }
    window.onresize = function() {
      _this.scroll();
    }
  },
  check: function(e) {
    var _this = this;
    if (arguments.length > 0) {
      _this = e.data;
    }
    var val = _this.profit_input().val();
    var newval = val.replace(/\D/g, '');
    newval = TeekerItConst.limit_in_a_gap(newval, 0, 9999);
    _this.profit_input().val(newval);
    _this.product_lists().each(function() {
      var max = parseFloat($(this).attr("max")),
      cost = parseFloat($(this).attr("c")),
      printing = parseFloat($(this).attr("p"));
      var profit = newval;
      var total = cost + printing + profit;
      if ((cost + profit) > max) {
        profit = max - cost;
        total = max + printing;
        profit = profit.toFixed(1);
        $(this).children(".borcolr").text("本款商品除印花外的售价不能超过" + max
          + "元，您的实际收益将为"+ profit + "元");
        $(this).children(".borcolr").show();
      } else {
        $(this).children(".borcolr").empty();
        $(this).children(".borcolr").hide();
      }
      $(this).find(".profit").text(profit);
      $(this).find(".final").text(total);
    });
    _this.anticipate();
  },
  commit: function() {
    this.check();
    var profit = $.trim(this.profit_input().val());
    if (profit == "" || isNaN(parseInt(profit))) {
      alert("请设置收益！");
      return false;
    }

    // TODO check login
    this.commit_button().parents("form").submit();
    return true;
  },
  scroll: function() {
    var scroll_top = window.pageYOfffset || document.documentElement.scrollTop
    || document.body.scrollTop || 0;
    if (scroll_top > this.price_area().offset().top) {
      var max_height = this.price_area().offset().top + this.price_area().height();
      if (max_height > (scroll_top + this.income_area().height())) {
        this.income_area().css("margin-top", (scroll_top
          - this.price_area().offset().top) + "px");
      } else {
        this.income_area().css("margin-top", (this.price_area().height()
          - this.income_area().height()) + "px");
      }
    } else {
      this.income_area().css("margin-top", "0px");
    }
  }
};

var SimpleEditorDialog = function(dom_id) {
  this.dialog_id = dom_id;
  this.request = null;
  this.callback = null;
  this.key = null;

};
SimpleEditorDialog.prototype = {
  get_dialog: function() {
    return $("#" + this.dialog_id);
  },
  text_area: function() {
    return this.get_dialog().find("dt");
  },
  input_area: function() {
    return this.get_dialog().find("input");
  },
  close_but: function() {
    return this.get_dialog().find(".close");
  },
  giveup_but: function() {
    return this.get_dialog().find(".giveupb");
  },
  commit_but: function() {
    return this.get_dialog().find(".commitb");
  },
  init: function() {
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

    var _this = this;
    this.giveup_but().click(function(e) {
      e.preventDefault();
      _this.close();
    });
    this.commit_but().click(function(e) {
      e.preventDefault();
      _this.commit();
    });
    this.close_but().click(function(e) {
      e.preventDefault();
      _this.close();
    });
  },
  open: function(url, callback) {
    this.get_dialog().dialog("open");
  },
  close: function() {
    this.get_dialog().dialog("close");
  },
  edit: function(key, val, text, url, callback) {
    this.text_area().text(text);
    this.input_area().val(val);
    this.key = key;
    this.request = url;
    this.callback = callback;
    this.open();
  },
  commit: function() {
    if ($.trim(this.input_area()) == "") {
      this.input_area().focus();
      return;
    }
    var _this = this;
    var val = $.trim(this.input_area().val());
    var data = {
      "f": this.key,
      "v": val
    };
    var url = this.request;
    $.ajax({
      url: url,
      type: 'post',
      data: data,
      async: true,
      dataType: 'json',
      success: function(r) {
        if (r.status) {
          _this.close();
          if (_this.callback != null) {
            _this.callback(data);
          }
        }
      }
    });
  }
};

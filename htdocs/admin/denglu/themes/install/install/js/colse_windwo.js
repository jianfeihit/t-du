var browser=navigator.appName
var b_version=navigator.appVersion
var version=b_version.split(";");
var trim_Version=version[1].replace(/[ ]/g,"");
if(browser=="Microsoft Internet Explorer" && trim_Version>="MSIE8.0") {
    alert("Please use IE7.0 version.");
    window.close();
}


jQuery.debounce = function(func, wait, immediate) {
  var timeout;
  if (wait == null) {
    wait = 250;
  }
  if (immediate == null) {
    immediate = true;
  }
  timeout = void 0;
  return function() {
    var args, callNow, context, later;
    context = this;
    args = arguments;
    later = function() {
      timeout = null;
      if (!immediate) {
        func.apply(context, args);
      }
    };
    callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) {
      func.apply(context, args);
    }
  };
};

// !function(e,o,n){window.HSCW=o,window.HS=n,n.beacon=n.beacon||{};var t=n.beacon;t.userConfig={},t.readyQueue=[],t.config=function(e){this.userConfig=e},t.ready=function(e){this.readyQueue.push(e)},o.config={docs:{enabled:!1,baseUrl:""},contact:{enabled:!0,formId:"67b642dd-88b5-11e6-91aa-0a5fecc78a4d"}};var r=e.getElementsByTagName("script")[0],c=e.createElement("script");c.type="text/javascript",c.async=!0,c.src="https://djtflbt20bdde.cloudfront.net/",r.parentNode.insertBefore(c,r)}(document,window.HSCW||{},window.HS||{});

// @codekit-append "../../bower_components/tinycolor/tinycolor.js"
// @codekit-append "vendor/ntc.js"
// @codekit-append "vendor/select-togglebutton.custom.js"
// @codekit-append "../../bower_components/jquery-storage-api/jquery.storageapi.js"
// @codekit-append "../../bower_components/matchHeight/dist/jquery.matchHeight.js"
// @  codekit-append "vendor/headroom.js"
// @codekit-append "vendor/imagesloaded.pkgd.js"
// @codekit-append "../../bower_components/gsap/src/uncompressed/TweenMax.js"
// @codekit-append "../../bower_components/gsap/src/uncompressed/easing/EasePack.js"
// @codekit-append "../../bower_components/gsap/src/uncompressed/plugins/ScrollToPlugin.js"
// @codekit-append "../../bower_components/trianglify/dist/trianglify.min.js"

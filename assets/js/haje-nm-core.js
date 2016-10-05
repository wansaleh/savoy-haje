!function($){"use strict";function e(){var e=this;e.BREAKPOINT_LARGE=864,e.classHeaderFixed="header-on-scroll",e.classMobileMenuOpen="mobile-menu-open",e.classWidgetPanelOpen="widget-panel-open",e.$window=$(window),e.$document=$(document),e.$html=$("html"),e.$body=$("body"),e.$pageIncludes=$("#nm-page-includes"),e.$pageOverlay=$("#nm-page-overlay"),e.$widgetPanelOverlay=$("#nm-widget-panel-overlay"),e.$topBar=$("#nm-top-bar"),e.$header=$("#nm-header"),e.$headerPlaceholder=$("#nm-header-placeholder"),e.headerScrollTolerance=0,e.$mobileMenuBtn=$("#nm-mobile-menu-button"),e.$mobileMenu=$("#nm-mobile-menu"),e.$mobileMenuScroller=e.$mobileMenu.children(".nm-mobile-menu-scroll"),e.$mobileMenuLi=e.$mobileMenu.find("ul li.menu-item"),e.$widgetPanel=$("#nm-widget-panel"),e.widgetPanelAnimSpeed=250,e.panelsAnimSpeed=200,e.$shopWrap=$("#nm-shop"),e.isShop=!!e.$shopWrap.length,e.shopCustomSelect="0"!=nm_wp_vars.shopCustomSelect,e.searchEnabled=!1,e.searchInHeader=!1,"0"!==nm_wp_vars.shopSearch&&(e.searchEnabled=!0,e.$searchPanel=$("#nm-shop-search"),e.$searchNotice=$("#nm-shop-search-notice"),"header"===nm_wp_vars.shopSearch?(e.searchInHeader=!0,e.$searchBtn=$("#nm-menu-search-btn")):e.isShop&&(e.$searchBtn=$("#nm-shop-search-btn"))),e.init()}$.nmThemeExtensions||($.nmThemeExtensions={}),e.prototype={init:function(){var e=this;"0"!=nm_wp_vars.pageLoadTransition&&(e.isIos=navigator.userAgent.match(/iPad/i)||navigator.userAgent.match(/iPhone/i),e.isIos||e.$window.on("beforeunload",function(n){$("#nm-page-load-overlay").addClass("nm-loader"),e.$html.removeClass("nm-page-loaded")}),setTimeout(function(){e.$html.addClass("nm-page-loaded")},300)),e.$body.removeClass("nm-preload"),e.headerIsFixed=!!e.$body.hasClass("header-fixed"),e.$html.hasClass("history")?(e.hasPushState=!0,window.history.replaceState({nmShop:!0},"",window.location.href)):e.hasPushState=!1,e.setScrollbarWidth(),e.headerCheckPlaceholderHeight(),e.headerIsFixed&&(e.headerSetScrollTolerance(),e.mobileMenuPrep()),e.widgetPanelPrep();var n=window.navigator.userAgent,a=n.indexOf("MSIE ");a>0&&e.$html.addClass("nm-old-ie"),e.isTouch=!!e.$html.hasClass("touch"),e.loadExtension(),e.bind(),e.initPageIncludes(),e.$body.hasClass("nm-added-to-cart")&&(e.$body.removeClass("nm-added-to-cart"),e.$window.load(function(){e.$widgetPanel.length&&(e.widgetPanelShow(!0),setTimeout(function(){e.widgetPanelCartHideLoader()},1e3))}))},loadExtension:function(){var e=this;$.nmThemeExtensions.shop&&$.nmThemeExtensions.shop.call(e),$.nmThemeExtensions.singleProduct&&$.nmThemeExtensions.singleProduct.call(e),$.nmThemeExtensions.cart&&$.nmThemeExtensions.cart.call(e),$.nmThemeExtensions.checkout&&$.nmThemeExtensions.checkout.call(e)},setScrollbarWidth:function(){var e=this,n=document.createElement("div");n.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(n),e.scrollbarWidth=n.offsetWidth-n.clientWidth,document.body.removeChild(n)},pageIsScrollable:function(){return document.body.scrollHeight>document.body.clientHeight},updateUrlParameter:function(e,n,a){var t=e.indexOf("#"),i=t===-1?"":e.substr(t);e=t===-1?e:e.substr(0,t);var s=new RegExp("([?&])"+n+"=.*?(&|$)","i"),o=e.indexOf("?")!==-1?"&":"?";return e=e.match(s)?e.replace(s,"$1"+n+"="+a+"$2"):e+o+n+"="+a,e+i},setPushState:function(e){var n=this;n.hasPushState&&window.history.pushState({nmShop:!0},"",e)},headerCheckPlaceholderHeight:function(){var e=this;if(!e.$body.hasClass(e.classHeaderFixed)){var n=e.$header.innerHeight(),a=parseInt(e.$headerPlaceholder.css("height"));n!==a&&e.$headerPlaceholder.css("height",n+"px")}},headerSetScrollTolerance:function(){var e=this;e.headerScrollTolerance=e.$topBar.length&&e.$topBar.is(":visible")?e.$topBar.outerHeight(!0):0},headerToggleFixedClass:function(e){e.$document.scrollTop()>e.headerScrollTolerance?e.$body.hasClass(e.classHeaderFixed)||e.$body.addClass(e.classHeaderFixed):e.$body.hasClass(e.classHeaderFixed)&&e.$body.removeClass(e.classHeaderFixed)},bind:function(){var e=this,n=null,a;e.$window.resize(function(){n&&clearTimeout(n),n=setTimeout(function(){a=parseInt(e.$html.css("width")),e.$body.hasClass(e.classMobileMenuOpen)&&a>e.BREAKPOINT_LARGE&&e.$pageOverlay.trigger("click"),e.headerCheckPlaceholderHeight(),e.headerIsFixed&&(e.headerSetScrollTolerance(),e.mobileMenuPrep())},250)}),e.headerIsFixed&&(e.$window.bind("scroll.nmheader",function(){e.headerToggleFixedClass(e)}),e.$window.trigger("scroll"));var t=$("#nm-top-menu").children(".menu-item"),i=$("#nm-main-menu-ul").children(".menu-item"),s=$.merge(t,i);s.hover(function(){var n=$(this).children(".sub-menu");if(n.length){var a=e.$window.innerWidth(),t=n.offset().left,i=n.width(),s=a-(t+i);s<0?n.css("left",s-33+"px"):n.css("left","")}}),e.$mobileMenuBtn.bind("click",function(n){n.preventDefault(),e.$body.hasClass(e.classMobileMenuOpen)?e.mobileMenuClose(!0):e.mobileMenuOpen()});var o=function(e,n){e.toggleClass("active"),n.toggleClass("open")};if(e.$mobileMenuLi.bind("click",function(e){e.preventDefault(),e.stopPropagation();var n=$(this),a=n.children("ul");a.length&&o(n,a)}),e.$mobileMenuLi.find("a").bind("click",function(e){e.stopPropagation();var n=$(this),a=n.parent("li"),t=a.children("ul");!t.length&&"#"!=n.attr("href").substr(0,1)||a.hasClass("nm-notoggle")||(e.preventDefault(),o(a,t))}),e.searchEnabled){e.searchInHeader&&e.$searchBtn.bind("click",function(n){n.preventDefault(),$(this).toggleClass("active"),e.$body.toggleClass("header-search-open"),e.searchPanelToggle()}),$("#nm-shop-search-close").bind("click",function(n){n.preventDefault(),e.$searchBtn.trigger("click")});var l;$("#nm-shop-search-input").on("input",function(){l=e.shopSearchValidateInput($(this).val()),l?e.$searchNotice.addClass("show"):e.$searchNotice.removeClass("show")}).trigger("input")}e.$widgetPanel.length&&e.widgetPanelBind(),e.$pageIncludes.hasClass("login-popup")&&$("#nm-menu-account-btn").bind("click",function(e){e.preventDefault(),$("#nm-login-wrap").children(".login").css("display",""),$.magnificPopup.open({mainClass:"nm-login-popup nm-mfp-fade-in",alignTop:!0,closeMarkup:'<a class="mfp-close nm-font nm-font-close2"></a>',removalDelay:180,items:{src:"#nm-login-popup-wrap",type:"inline"},callbacks:{close:function(){$("#nm-login-wrap").addClass("inline fade-in slide-up"),$("#nm-register-wrap").removeClass("inline fade-in slide-up")}}})}),$("#nm-blog-categories-toggle-link").bind("click",function(e){e.preventDefault();var n=$(this);$("#nm-blog-categories-list").slideToggle(200,function(){var e=$(this);n.toggleClass("active"),n.hasClass("active")||e.css("display","")})}),$("#nm-page-overlay, #nm-widget-panel-overlay").bind("click",function(){var n=$(this);e.$body.hasClass(e.classMobileMenuOpen)?e.mobileMenuClose(!1):e.widgetPanelHide(),n.addClass("fade-out"),setTimeout(function(){n.removeClass("show fade-out")},e.panelsAnimSpeed)})},mobileMenuPrep:function(){var e=this,n=e.$window.height()-e.$header.outerHeight(!0);e.$mobileMenuScroller.css({"max-height":n+"px","margin-right":"-"+e.scrollbarWidth+"px"})},mobileMenuOpen:function(e){var n=this,a=n.$header.outerHeight(!0);n.$mobileMenuScroller.css("margin-top",a+"px"),n.$body.addClass(n.classMobileMenuOpen),n.$pageOverlay.addClass("show")},mobileMenuClose:function(e){var n=this;n.$body.removeClass(n.classMobileMenuOpen),e&&n.$pageOverlay.trigger("click"),setTimeout(function(){$("#nm-mobile-menu-main-ul").children(".active").removeClass("active").children("ul").removeClass("open"),$("#nm-mobile-menu-secondary-ul").children(".active").removeClass("active").children("ul").removeClass("open")},250)},searchPanelToggle:function(){var e=this,n=$("#nm-shop-search-input");e.$searchPanel.slideToggle(200,function(){e.$searchPanel.toggleClass("fade-in"),e.$searchPanel.hasClass("fade-in")?n.focus():n.val(""),e.filterPanelSliding=!1}),e.shopSearchHideNotice()},shopSearchValidateInput:function(e){return!!(/\S/.test(e)&&e.length>nm_wp_vars.shopSearchMinChar-1)},shopSearchHideNotice:function(e){$("#nm-shop-search-notice").removeClass("show")},widgetPanelPrep:function(){var e=this;e.widgetPanelCartHideScrollbar(),e.cartPanelAjax=null,e.quantityInputsBindButtons(e.$widgetPanel),e.$widgetPanel.on("blur","input.qty",function(){var n=$(this),a=parseFloat(n.val()),t=parseFloat(n.attr("max"));""!==a&&"NaN"!==a||(a=0),"NaN"===t&&(t=""),a>t&&(n.val(t),a=t),a>0&&e.widgetPanelCartUpdate(n)}),e.$document.on("nm_qty_change",function(n,a){e.$body.hasClass(e.classWidgetPanelOpen)&&e.widgetPanelCartUpdate($(a))})},widgetPanelBind:function(){var e=this;e.isTouch&&(e.headerIsFixed&&e.$pageOverlay.on("touchmove",function(e){e.preventDefault()}),e.$widgetPanelOverlay.on("touchmove",function(e){e.preventDefault()}),e.$widgetPanel.on("touchmove",function(e){e.stopPropagation()})),$("#nm-menu-cart-btn, #nm-mobile-menu-cart-btn").bind("click",function(n){if(n.preventDefault(),e.$body.hasClass(e.classMobileMenuOpen)){var a=$(this);e.$pageOverlay.trigger("click"),setTimeout(function(){a.trigger("click")},e.panelsAnimSpeed)}else e.widgetPanelShow()}),$("#nm-widget-panel-close").bind("click.nmWidgetPanelClose",function(e){e.preventDefault(),$("#nm-widget-panel-overlay").trigger("click")}),e.$widgetPanel.on("click.nmCartPanelClose","#nm-cart-panel-continue",function(e){e.preventDefault(),$("#nm-widget-panel-overlay").trigger("click")}),e.$widgetPanel.on("click","#nm-cart-panel .cart_list .remove",function(n){n.preventDefault(),e.cartPanelAjax||e.widgetPanelCartRemoveProduct(this)})},widgetPanelShow:function(e){var n=this;e&&n.widgetPanelCartShowLoader(),n.$body.addClass("widget-panel-opening "+n.classWidgetPanelOpen),n.$widgetPanelOverlay.addClass("show"),setTimeout(function(){n.$body.removeClass("widget-panel-opening")},n.widgetPanelAnimSpeed)},widgetPanelHide:function(){var e=this;e.$body.addClass("widget-panel-closing"),e.$body.removeClass(e.classWidgetPanelOpen),setTimeout(function(){e.$body.removeClass("widget-panel-closing")},e.widgetPanelAnimSpeed)},widgetPanelCartShowLoader:function(){$("#nm-cart-panel-loader").addClass("show")},widgetPanelCartHideLoader:function(){var e=this;$("#nm-cart-panel-loader").addClass("fade-out"),setTimeout(function(){$("#nm-cart-panel-loader").removeClass("fade-out show")},200)},widgetPanelCartHideScrollbar:function(){var e=this;e.$widgetPanel.children(".nm-widget-panel-inner").css("marginRight","-"+e.scrollbarWidth+"px")},widgetPanelCartRemoveProduct:function(e){var n=this,a=$(e),t=a.closest("li"),i=t.parent("ul"),s=a.data("cart-item-key");t.closest("li").addClass("loading"),n.cartPanelAjax=$.ajax({type:"POST",url:nm_wp_vars.ajaxUrl,data:{action:"nm_cart_panel_remove_product",cart_item_key:s},dataType:"json",error:function(e,n,a){console.log("NM: AJAX error - widgetPanelCartRemoveProduct() - "+a),t.closest("li").removeClass("loading")},complete:function(e){n.cartPanelAjax=null;var a=e.responseJSON;a&&"1"===a.status?(t.css({"-webkit-transition":"0.2s opacity ease",transition:"0.2s opacity ease",opacity:"0"}),setTimeout(function(){t.css("display","block").slideUp(150,function(){t.remove();var e=i.children("li");1==e.length&&$("#nm-cart-panel").addClass("nm-cart-panel-empty"),n.shopReplaceFragments(a.fragments),n.$body.trigger("added_to_cart",[a.fragments,a.cart_hash,!1])})},160)):console.log("NM: Couldn't remove product from cart")}})},widgetPanelCartUpdate:function(e){var n=this;n.cartPanelAjax&&n.cartPanelAjax.abort(),e.closest("li").addClass("loading");var a={action:"nm_cart_panel_update"};a[e.attr("name")]=e.val(),n.cartPanelAjax=$.ajax({type:"POST",url:nm_wp_vars.ajaxUrl,data:a,dataType:"json",complete:function(e){n.cartPanelAjax=null;var a=e.responseJSON;a&&"1"===a.status&&n.shopReplaceFragments(a.fragments),$("#nm-cart-panel .cart_list").children(".loading").removeClass("loading")}})},shopReplaceFragments:function(e){var n;$.each(e,function(e,a){n=$(a),n.length&&$(e).replaceWith(n)})},quantityInputsBindButtons:function(e){var n=this;e.off("click.nmQty").on("click.nmQty",".nm-qty-plus, .nm-qty-minus",function(){var e=$(this),a=e.closest(".quantity").find(".qty"),t=parseFloat(a.val()),i=parseFloat(a.attr("max")),s=parseFloat(a.attr("min")),o=a.attr("step");t&&""!==t&&"NaN"!==t||(t=0),""!==i&&"NaN"!==i||(i=""),""!==s&&"NaN"!==s||(s=0),"any"!==o&&""!==o&&void 0!==o&&"NaN"!==parseFloat(o)||(o=1),e.hasClass("nm-qty-plus")?i&&(i==t||t>i)?a.val(i):(a.val(t+parseFloat(o)),n.quantityInputsTriggerEvents(a)):s&&(s==t||t<s)?a.val(s):t>0&&(a.val(t-parseFloat(o)),n.quantityInputsTriggerEvents(a))})},quantityInputsTriggerEvents:function(e){var n=this;e.trigger("change"),n.$document.trigger("nm_qty_change",e)},initPageIncludes:function(){var e=this;if(!e.isTouch&&e.$pageIncludes.hasClass("video-background")&&$(".nm-row-video").each(function(){var e=$(this),n=e.data("video-url");if(n){var a=vcExtractYoutubeId(n);a&&insertYoutubeVideoAsBackground(e,a)}}),e.$window.load(function(){if(e.$pageIncludes.hasClass("blog-grid")){var n=$("#nm-blog-grid-ul");n.packery({itemSelector:".post",gutter:0,isInitLayout:!1}),n.packery("once","layoutComplete",function(){n.removeClass("nm-loader hide")}),n.packery()}if(e.$pageIncludes.hasClass("banner")){var a=$(".nm-banner"),t=a.find(".nm-banner-alt-image");e.isShop&&e.filtersEnableAjax&&a.find(".nm-banner-shop-link").bind("click",function(n){n.preventDefault();var a=$(this).attr("href");a&&e.shopExternalGetPage($(this).attr("href"))});var i=function(){if(e.$window.width()<=768){for(var n,a,i=0;i<t.length;i++)n=$(t[i]),a=$(t[i]).data("src"),n.hasClass("img")?n.attr("src",a):n.css("background-image","url("+a+")");e.$window.unbind("resize.banners")}},s=null;e.$window.bind("resize.banners",function(){s&&clearTimeout(s),s=setTimeout(function(){i()},250)}),i()}if(e.$pageIncludes.hasClass("banner-slider")){var o=$(".nm-banner-slider"),l=function(e,n){e.$bannerContent=n.find(".nm-banner-text-inner"),e.$bannerContent.length&&(e.bannerAnimation=e.$bannerContent.data("animate"),e.$bannerContent.addClass(e.bannerAnimation))};o.each(function(){var n=$(this),a={arrows:!1,prevArrow:'<a class="slick-prev"><i class="nm-font nm-font-angle-thin-left"></i></a>',nextArrow:'<a class="slick-next"><i class="nm-font nm-font-angle-thin-right"></i></a>',dots:!1,edgeFriction:0,infinite:!1,pauseOnHover:!1,speed:350,touchThreshold:30};n.children().wrap("<div></div>"),a=$.extend(a,n.data()),n.on("init",function(){e.$document.trigger("banner-slider-loaded"),l(n,n.find(".slick-track .slick-active"))}),n.on("afterChange",function(e,a,t){n.slideIndex!=t&&(n.slideIndex=t,n.$bannerContent&&n.$bannerContent.removeClass(n.bannerAnimation),l(n,n.find(".slick-track .slick-active")))}),n.on("setPosition",function(e,n){var a=$(n.$slides[n.currentSlide]),t=a.children(".nm-banner");t.hasClass("has-alt-image")&&t.children(".nm-banner-alt-image").is(":visible")?n.$slider.addClass("alt-image-visible"):n.$slider.removeClass("alt-image-visible")}),n.slick(a)})}if(e.$pageIncludes.hasClass("product-slider")){var r=$(".nm-product-slider"),c={adaptiveHeight:!0,arrows:!1,dots:!0,edgeFriction:0,infinite:!1,speed:350,touchThreshold:30,slidesToShow:4,slidesToScroll:4,responsive:[{breakpoint:1024,settings:{slidesToShow:3,slidesToScroll:3}},{breakpoint:768,settings:{slidesToShow:2,slidesToScroll:2}},{breakpoint:518,settings:{slidesToShow:1,slidesToScroll:1}}]};r.each(function(){var e=$(this),n=e.find(".nm-products:first");c=$.extend(c,e.data()),n.slick(c)})}if(e.$pageIncludes.hasClass("post-slider")){var r=$(".nm-post-slider"),c={adaptiveHeight:!0,arrows:!1,dots:!0,edgeFriction:0,infinite:!1,pauseOnHover:!1,speed:350,touchThreshold:30,slidesToShow:4,slidesToScroll:4,responsive:[{breakpoint:1024,settings:{slidesToShow:3,slidesToScroll:3}},{breakpoint:768,settings:{slidesToShow:2,slidesToScroll:2}},{breakpoint:518,settings:{slidesToShow:1,slidesToScroll:1}}]};r.each(function(){var e=$(this);c=$.extend(c,e.data()),e.slick(c)})}if(e.$pageIncludes.hasClass("blog-slider")){var d=$(".nm-blog-slider"),c={prevArrow:'<a class="slick-prev"><i class="nm-font nm-font-angle-left"></i></a>',nextArrow:'<a class="slick-next"><i class="nm-font nm-font-angle-right"></i></a>',dots:!0,edgeFriction:0,infinite:!1,pauseOnHover:!1,speed:350,touchThreshold:30,responsive:[{breakpoint:550,settings:{slidesToShow:1}}]};d.each(function(){var e=$(this);c=$.extend(c,e.data()),e.slick(c)})}"0"!=nm_wp_vars.wpGalleryPopup&&e.$pageIncludes.hasClass("wp-gallery")&&$(".gallery").each(function(){$(this).magnificPopup({mainClass:"nm-wp-gallery-popup nm-mfp-fade-in",closeMarkup:'<a class="mfp-close nm-font nm-font-close2"></a>',removalDelay:180,delegate:".gallery-icon > a",type:"image",gallery:{enabled:!0,arrowMarkup:'<a title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% nm-font nm-font-angle-right"></a>'},closeBtnInside:!1})})}),e.$pageIncludes.hasClass("product_categories")){var n=$(".nm-product-categories");e.isShop&&e.filtersEnableAjax&&n.find(".product-category a").bind("click",function(n){n.preventDefault(),e.shopExternalGetPage($(this).attr("href"))}),e.$pageIncludes.hasClass("product_categories_packery")&&e.$window.load(function(){for(var e=0;e<n.length;e++){var a=$(n[e]).children(".woocommerce").children("ul");a.packery({itemSelector:".product-category",gutter:0,isInitLayout:!1}),a.packery("once","layoutComplete",function(){a.closest(".nm-product-categories").removeClass("nm-loader"),a.addClass("show")}),a.packery()}})}if(e.$pageIncludes.hasClass("lightbox")){var a,t,i;$(".nm-lightbox").each(function(){$(this).bind("click",function(e){e.preventDefault(),e.stopPropagation(),a=$(this),t=a.data("mfp-type"),i={mainClass:"nm-wp-gallery-popup nm-mfp-zoom-in",closeMarkup:'<a class="mfp-close nm-font nm-font-close2"></a>',removalDelay:180,type:t,closeBtnInside:!1},i.closeOnContentClick="inline"!=t,a.magnificPopup(i).magnificPopup("open")})})}}},$.nmTheme=e.prototype,$(document).ready(function(){new e})}(jQuery);
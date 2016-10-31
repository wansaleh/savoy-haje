!function($){"use strict";$.extend($.nmTheme,{singleProduct_init:function(){var i=this;i.zoomEnabled=!1,i.singleProductVariationsInit(),i.quantityInputsBindButtons($("#nm-product-summary")),i.singleProductFeaturedVideoInit(),i.singleProductGalleryInit();var e=$("#nm-comment-form-rating");e.on("click.nmAddParentClass",".stars a",function(){e.children(".stars").addClass("has-active")});var n=$("#nm-upsells").find(".nm-shop-loop-thumbnail .unveil-image"),a=$("#nm-related").find(".nm-shop-loop-thumbnail .unveil-image"),t=$.merge(n,a);i.$window.load(function(){t.length&&t.unveil(1,function(){$(this).parents("li").first().addClass("image-loaded")})}),"0"!=nm_wp_vars.shopRedirectScroll&&($("#nm-breadcrumb").find("a").bind("click.nmShopRedirect",function(e){e.preventDefault(),i.singleProductRedirectWithHash(this)}),$("#nm-product-meta").find("a").bind("click.nmShopRedirect",function(e){e.preventDefault(),i.singleProductRedirectWithHash(this)}))},singleProductRedirectWithHash:function(i){var e=$(i).attr("href");window.location.href=e+"#shop"},singleProductVariationsInit:function(){var i=this;i.$variationsForm=$("#nm-variations-form"),i.$variationsWrap=i.$variationsForm.children(".variations"),i.$variationDetailsWrap=i.$variationsForm.children(".single_variation_wrap").children(".single_variation"),i.shopCustomSelect&&i.$variationsWrap.find("select").selectOrDie(i.shopSelectConfig),i.shopCheckVariationDetails(i.$variationDetailsWrap),i.$variationDetailsWrap.on("show_variation",function(){i.shopCheckVariationDetails(i.$variationDetailsWrap)}),i.$variationDetailsWrap.on("hide_variation",function(){i.$variationDetailsWrap.css("display","none")}),i.$variationsForm.on("woocommerce_variation_select_change",function(){i.$productImageSlider&&i.$productImageSlider.length&&i.$productImageSlider.slick("slickGoTo",0,!1),i.zoomEnabled&&i.singleProductZoomUpdateImage()})},singleProductZoomUpdateImage:function(){var i=this,e=i.$productImageSlider.find(".slick-slide").first(),n=e.children("a").attr("href"),a=e.data("easyZoom");a.swap(n)},singleProductFeaturedVideoInit:function(){var i=this;i.hasFeaturedVideo=!1,i.$featuredVideoBtn=$("#nm-featured-video-link"),i.$featuredVideoBtn.length&&(i.hasFeaturedVideo=!0,i.$featuredVideoBtn.bind("click",function(e){e.preventDefault(),i.$featuredVideoBtn.magnificPopup({mainClass:"nm-featured-video-popup nm-mfp-fade-in",closeMarkup:'<a class="mfp-close nm-font nm-font-close2"></a>',removalDelay:180,type:"iframe",closeOnContentClick:!0,closeBtnInside:!1}).magnificPopup("open")}))},singleProductGalleryInit:function(){var i=this;if($("#nm-page-includes").hasClass("product-gallery")){i.$productImageSlider=$("#nm-product-images-slider");var e=$("#nm-product-images-col"),n=i.$productImageSlider.children("div"),a=$("#nm-product-thumbnails-slider"),t=a.children("div"),o=t.first(),s=t.length,r=6,l=s>r?r:s,c=300,d=!1,u=e.hasClass("modal-enabled");i.zoomEnabled=!i.isTouch&&e.hasClass("zoom-enabled"),i.zoomEnabled&&i.$productImageSlider.on("init",function(){n.easyZoom()}),u?i.$productImageSlider.on("init",function(){n.bind("click",function(e){if(!i.$productImageSlider.hasClass("animating")){e.preventDefault();var n=$(this).index();i.hasFeaturedVideo&&0==n&&i.$featuredVideoBtn.hasClass("modal-override")?i.$featuredVideoBtn.trigger("click"):m(this,n)}})}):i.hasFeaturedVideo&&i.$productImageSlider.on("init",function(){n.bind("click",function(e){i.$productImageSlider.hasClass("animating")||(e.preventDefault(),i.$featuredVideoBtn.trigger("click"))})}),i.$productImageSlider.on("beforeChange",function(e,n,t,o){d||a.find(".slick-slide").eq(o).trigger("click"),d=!1,i.$productImageSlider.addClass("animating")}),i.$productImageSlider.on("afterChange",function(){i.$productImageSlider.removeClass("animating")}),i.$productImageSlider.slick({adaptiveHeight:!0,slidesToShow:1,slidesToScroll:1,prevArrow:'<a class="slick-prev"><i class="nm-font nm-font-angle-thin-left"></i></a>',nextArrow:'<a class="slick-next"><i class="nm-font nm-font-angle-thin-right"></i></a>',dots:!0,fade:!1,cssEase:"ease",infinite:!1,speed:c}),a.on("init",function(){t.bind("click",function(){var e=$(this);i.$productImageSlider.hasClass("animating")||e.hasClass("current")||(d=!0,o.removeClass("current"),e.addClass("current"),o=e,e.next().hasClass("slick-active")?e.prev().hasClass("slick-active")||a.slick("slickPrev"):a.slick("slickNext"),i.$productImageSlider.slick("slickGoTo",e.index(),!1))})}),a.slick({slidesToShow:l,slidesToScroll:1,arrows:!1,infinite:!1,focusOnSelect:!1,vertical:!0,draggable:!1,speed:c,swipe:!1,touchMove:!1});var m=function(e,t){var o,s,r,l=[],d,u;n.each(function(){o=$(this),s=o.children("a"),r=s.children("img"),d=s.data("size").split("x"),u={src:s.attr("href"),w:parseInt(d[0],10),h:parseInt(d[1],10),msrc:r.attr("src"),el:s[0]},l.push(u)});var m={index:t,showHideOpacity:!0,bgOpacity:1,loop:!1,closeOnVerticalDrag:!1,mainClass:n.length>1?"pswp--minimal--dark":"pswp--minimal--dark pswp--single--image",barsSize:{top:0,bottom:0},captionEl:!1,fullscreenEl:!1,zoomEl:!1,shareE1:!0,counterEl:!1,tapToClose:!0,tapToToggleControls:!1},p=$("#pswp")[0],h=new PhotoSwipe(p,PhotoSwipeUI_Default,l,m);h.init(),h.listen("initialZoomIn",function(){a.slick("slickSetOption","speed",0)});var f=t;h.listen("beforeChange",function(e){f+=e,i.$productImageSlider.slick("slickGoTo",f,!0)}),h.listen("close",function(){a.slick("slickSetOption","speed",c)})}}}}),$.nmThemeExtensions.singleProduct=$.nmTheme.singleProduct_init}(jQuery);
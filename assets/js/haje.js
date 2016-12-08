// Generated by CoffeeScript 1.10.0
(function() {
  "use strict";
  var $, findKey, ls;

  $ = jQuery.noConflict();

  ls = $.localStorage;

  $.fn.bgOverlay = function(css) {
    if (css == null) {
      css = {};
    }
    return this.each(function() {
      var overlay;
      overlay = $('<div class="bg-overlay"></div>').css(css);
      $(this).prepend(overlay).css({
        position: 'relative'
      });
      return overlay;
    });
  };

  findKey = function(obj, keyToFind) {
    var result;
    result = null;
    $.each(obj, function(key, val) {
      if (key.toLowerCase() === keyToFind.toLowerCase()) {
        result = val;
        return false;
      }
    });
    return result;
  };

  window.Haje = (function() {
    function Haje() {
      $('#nm-mobile-menu-button').click(function() {
        var hamburger;
        hamburger = $(this).children('.hamburger');
        if ($('body').hasClass('mobile-menu-open')) {
          return hamburger.addClass('is-active');
        } else {
          return hamburger.removeClass('is-active');
        }
      });
    }

    return Haje;

  })();

  Haje.Alert = (function() {
    function Alert() {
      this.setupAlert();
      window._alert = window.alert;
      window.alert = (function(_this) {
        return function(content) {
          return _this.showAlert(content);
        };
      })(this);
    }

    Alert.prototype.setupAlert = function() {
      this.overlay = $('<div class="hj-alert-overlay"></div>');
      this.alert = $('<div class="hj-alert"><div class="hj-alert-content"></div><div class="hj-alert-action"><a href="#">Close</a></div></div>');
      this.alertContent = this.alert.find('.hj-alert-content');
      this.actionButton = this.alert.find('.hj-alert-action > a');
      this.actionButton.click((function(_this) {
        return function(ev) {
          ev.stopPropagation();
          return _this.overlay.removeClass('show');
        };
      })(this));
      this.overlay.click((function(_this) {
        return function(ev) {
          ev.stopPropagation();
          return _this.overlay.removeClass('show');
        };
      })(this));
      this.alert.click(function(ev) {
        return ev.stopPropagation();
      });
      return $('body').append(this.overlay.append(this.alert));
    };

    Alert.prototype.showAlert = function(content) {
      if (content == null) {
        content = 'Test';
      }
      this.overlay.addClass('show');
      return this.alertContent.html(content);
    };

    return Alert;

  })();

  $(function() {
    new Haje;
    return new Haje.Alert;
  });

  "use strict";

  $ = jQuery.noConflict();

  Haje.Forms = (function() {
    function Forms() {
      this.base();
      this.gforms();
    }

    Forms.prototype.base = function() {
      $('form .form-row').find('input, textarea, select, label').focus(function() {
        return $(this).closest('.form-row').addClass('focus');
      }).blur(function() {
        return $(this).closest('.form-row').removeClass('focus');
      });
      $('p[class^="comment-form-"]').find('input, textarea, select, label').focus(function() {
        return $(this).closest('p[class^="comment-form-"]').addClass('focus');
      }).blur(function() {
        return $(this).closest('p[class^="comment-form-"]').removeClass('focus');
      });
      $('.mc4wp-form input[type=email]').focus(function() {
        return $(this).closest('.mc4wp-form').addClass('focus');
      }).blur(function() {
        return $(this).closest('.mc4wp-form').removeClass('focus');
      });
      return $('.followup-checkout input[type=checkbox]').each(function() {
        var _this, check;
        _this = $(this);
        check = function() {
          if (_this.is(':checked')) {
            return _this.closest('label').addClass('checked');
          } else {
            return _this.closest('label').removeClass('checked');
          }
        };
        check();
        return $(this).change(check);
      });
    };

    Forms.prototype.gforms = function() {
      $('.ginput_container .gfield:not(.gf_readonly)').find('input, textarea, select, label').focus(function() {
        return $(this).closest('.gfield').addClass('focus');
      }).blur(function() {
        return $(this).closest('.gfield').removeClass('focus');
      });
      return $(".gfield.gf_readonly input").attr("readonly", "readonly");
    };

    Forms.prototype.wppb = function() {
      $('.wppb-user-forms').find('input, textarea, select, label').focus(function() {
        return $(this).closest('.wppb-form-field, p').addClass('focus');
      }).blur(function() {
        return $(this).closest('.wppb-form-field, p').removeClass('focus');
      });
      $('.wppb-user-forms').find(':checkbox').each(function() {
        if ($(this).is(':checked')) {
          return $(this).closest('.wppb-form-field, p').addClass('checked');
        }
      }).change(function() {
        if ($(this).is(':checked')) {
          return $(this).closest('.wppb-form-field, p').addClass('checked');
        } else {
          return $(this).closest('.wppb-form-field, p').removeClass('checked');
        }
      });
      return $('.woocommerce-MyAccount-content .wppb-edit-user .wppb-password-heading .wppb-description-delimiter').html('Leave the password fields blank if you don\'t need to change them.');
    };

    return Forms;

  })();

  $(function() {
    return new Haje.Forms;
  });

  "use strict";

  $ = jQuery.noConflict();

  Haje.Home = (function() {
    function Home() {
      if (!$('body').hasClass('home')) {
        return;
      }
    }

    return Home;

  })();

  $(function() {
    return new Haje.Home;
  });

  "use strict";

  $ = jQuery.noConflict();

  ls = $.localStorage;

  Haje.WC = (function() {
    function WC() {}

    return WC;

  })();

  Haje.WC.Filters = (function() {
    function Filters() {
      this.init();
    }

    Filters.prototype.init = function() {
      var color_widget, original_title, widget_title;
      color_widget = $('.nm_widget_color_filter');
      widget_title = $(color_widget).find('.nm-widget-title');
      original_title = widget_title.text();
      color_widget.data('original-title', original_title);
      return $(color_widget).find('.wc-layered-nav-term a').each(function() {
        return $(this).hover((function(_this) {
          return function() {
            return widget_title.text($(_this).children('i')[0].nextSibling.nodeValue);
          };
        })(this), (function(_this) {
          return function() {
            return widget_title.text(color_widget.data('original-title'));
          };
        })(this));
      });
    };

    return Filters;

  })();

  Haje.WC.Tabs = (function() {
    function Tabs() {
      $('.woocommerce-tabs .panel:first-child').addClass('current');
      $('.woocommerce-tabs ul.tabs li a').off('click').on('click', function() {
        var currentPanel, that;
        that = $(this);
        currentPanel = that.attr('href');
        that.parent().siblings().removeClass('active').end().addClass('active');
        $('.woocommerce-tabs').find(currentPanel).siblings('.panel').filter(':visible').fadeOut(200, function() {
          $('.woocommerce-tabs').find(currentPanel).siblings('.panel').removeClass('current');
          return $('.woocommerce-tabs').find(currentPanel).addClass('current').fadeIn(200);
        });
        return false;
      });
    }

    return Tabs;

  })();

  Haje.WC.VariationNumberGuide = (function() {
    function VariationNumberGuide() {}

    return VariationNumberGuide;

  })();

  Haje.WC.VariationSwatches = (function() {
    function VariationSwatches() {
      this.init('#nm-product-summary');
      Haje.WC_Variation_Swatches = this;
    }

    VariationSwatches.prototype.init = function(parent) {
      if (!$(parent).find('table.variations .nm-variation-row').length) {
        return;
      }
      this.replaceSelect(parent);
      return this.toggleVariations(parent);
    };

    VariationSwatches.prototype.colorFromName = function(compare) {
      var hex, i, len, name, ref;
      if ((typeof haje_hex !== "undefined" && haje_hex !== null)) {
        hex = findKey(haje_hex, compare);
        return hex;
      } else {
        ref = ntc.names;
        for (i = 0, len = ref.length; i < len; i++) {
          name = ref[i];
          if (compare.toLowerCase().trim() === name[1].toLowerCase()) {
            return name[0];
          }
        }
      }
      return false;
    };

    VariationSwatches.prototype.replaceSelect = function(parent) {
      var _this;
      _this = this;
      return $(parent).find('table.variations .nm-variation-row').each(function() {
        var attr_name, dehighlightColor, highlightColor, isAttributeColor, isAttributeSize, select, sizeguide, variation_label, variation_label_display, variation_row, variation_value;
        variation_row = $(this).addClass('haje-swatch');
        variation_label = variation_row.children('.label');
        variation_value = variation_row.children('.value');
        attr_name = variation_row.data('attribute_name');
        isAttributeColor = attr_name === 'color' || attr_name === 'pa_color';
        isAttributeSize = attr_name === 'size' || attr_name === 'pa_size';
        variation_label.children('label').append('<div class="label-display"></div>');
        variation_label_display = variation_label.find('.label-display');
        select = variation_value.children('select');
        if (!select.length) {
          return;
        }
        if (isAttributeColor) {
          select.children('option').each(function() {
            if ($(this).val() !== '') {
              return $(this).attr('data-hex', _this.colorFromName($(this).val()));
            }
          });
        }
        highlightColor = function(hex) {
          var color, color2, multicolor;
          if (isAttributeColor) {
            variation_label_display.removeClass('dark light');
            color = String(hex);
            color2 = null;
            if (color.indexOf(',') > -1) {
              multicolor = color.split(',');
              color = multicolor[0];
              color2 = multicolor[1];
            }
            if (!color2) {
              return variation_label_display.addClass(tinycolor(color).getBrightness() < 150 ? 'dark' : 'light').css({
                background: "#" + color
              });
            } else {
              return variation_label_display.addClass(tinycolor(color).getBrightness() < 150 ? 'dark' : 'light').css({
                background: "#" + color,
                boxShadow: "-10px 0 0 #" + color2
              });
            }
          }
        };
        dehighlightColor = function() {
          if (isAttributeColor) {
            return variation_label_display.removeClass('dark light').css({
              background: "none",
              boxShadow: "none"
            });
          }
        };
        select.togglebutton({
          removeFirst: true,
          onChange: function(val, text, btn) {
            if (select.val()) {
              variation_label_display.text(text).data('original-label', text);
              return highlightColor(btn.data('hex'));
            } else {
              variation_label_display.data('original-label', '');
              return dehighlightColor();
            }
          }
        });
        select.data('buttons').hover(function() {
          variation_label_display.data('original-label', variation_label_display.text());
          return variation_label_display.text($(this).text());
        }, function() {
          return variation_label_display.text(variation_label_display.data('original-label'));
        });
        variation_label_display.data('original-label', select.val());
        variation_label_display.text(select.val());
        $.each(select.data(), function(attr_name, attr_val) {
          if (typeof attr_val === 'string') {
            return select.data('group').attr('data-' + attr_name, attr_val.replace(/^attribute_/, ''));
          }
        });
        if (isAttributeColor) {
          _this.colorizeSwatch(select.data('buttons'));
          select.data('buttons').sort(function(a, b) {
            var a_color, a_value, b_color, b_value, hue_diff;
            a_value = $(a).attr('value');
            a_color = String($(a).data('hex'));
            if (a_color.indexOf(',') > -1) {
              a_color = a_color.split(',')[0];
            }
            a_color = tinycolor(a_color);
            b_value = $(b).attr('value');
            b_color = String($(b).data('hex'));
            if (b_color.indexOf(',') > -1) {
              b_color = b_color.split(',')[0];
            }
            b_color = tinycolor(b_color);
            hue_diff = a_color.toHsl().h - b_color.toHsl().h;
            if (hue_diff !== 0) {
              return -hue_diff;
            } else {
              return b_color.getBrightness() - a_color.getBrightness();
            }
          });
          select.data('buttons').detach().appendTo(select.data('group'));
        }
        if ($('.size_guide_tab').length && isAttributeSize) {
          sizeguide = $('<button type="button" class="swatch size-guide">Size Guide</button>').appendTo(select.data('group'));
          return sizeguide.click(function() {
            return $('html, body').animate({
              scrollTop: $('.wc-tabs').offset().top
            }, 300);
          });
        }
      });
    };

    VariationSwatches.prototype.colorizeSwatch = function(swatches) {
      var _this;
      _this = this;
      return swatches.each(function() {
        var altcolor, color, color2, multicolor;
        color = String($(this).data('hex'));
        color2 = null;
        if (color.indexOf(',') > -1) {
          multicolor = color.split(',');
          color = multicolor[0];
          color2 = multicolor[1];
        }
        if (!color2) {
          return $(this).css({
            background: "#" + color
          });
        } else {
          altcolor = $('<span class="alt-color"></span>').css({
            background: "#" + color2
          });
          return $(this).css({
            background: "#" + color,
            borderColor: "#" + color2,
            borderWidth: "8px"
          }).append(altcolor);
        }
      });
    };

    VariationSwatches.prototype.toggleVariations = function(parent) {
      return $(parent).find('table.variations .nm-variation-row').each(function() {
        var attr_name, variation_label, variation_label_display, variation_row, variation_value;
        variation_row = $(this);
        variation_label = variation_row.children('.label');
        variation_value = variation_row.children('.value');
        variation_label_display = variation_label.find('.label-display');
        attr_name = variation_row.data('attribute_name');
        if (ls.get('haje_open_variation_' + $(this).data('attribute_name'))) {
          $(this).addClass('open');
        }
        if (location.href.indexOf('attribute_' + $(this).data('attribute_name')) > -1) {
          $(this).addClass('open');
        }
        return variation_label.click(function() {
          var value_container;
          value_container = $(this).next('.value');
          if (!variation_row.hasClass('open')) {
            variation_row.addClass('open');
            return ls.set('haje_open_variation_' + attr_name, true);
          } else {
            variation_row.removeClass('open');
            return ls.set('haje_open_variation_' + attr_name, false);
          }
        });
      });
    };

    return VariationSwatches;

  })();

  Haje.WC.ColorCart = (function() {
    function ColorCart() {
      this.init();
    }

    ColorCart.prototype.init = function() {
      this.colorizeTags();
      $(document.body).on('updated_checkout', (function(_this) {
        return function() {
          return _this.colorizeTags();
        };
      })(this));
      $(document.body).on('wc_fragments_refreshed', (function(_this) {
        return function() {
          return _this.colorizeTags();
        };
      })(this));
      return $(document.body).on('added_to_cart', (function(_this) {
        return function() {
          return _this.colorizeTags();
        };
      })(this));
    };

    ColorCart.prototype.colorizeTags = function() {
      var _this;
      _this = this;
      return $('.cart_item, .mini_cart_item').find('.variation-Color:last-child p').each(function() {
        var color, colorname, multicolor, value;
        value = $(this).html();
        color = String($(this).parent().data('hex'));
        colorname = $(this).parent().data('color');
        multicolor = color.indexOf(',') > -1 ? color.split(',') : [];
        if (multicolor.length) {
          color = multicolor[0];
        }
        $(this).parent().addClass(tinycolor(color).getBrightness() < 150 ? 'dark' : 'light');
        if (colorname === 'white' || colorname === 'White') {
          return $(this).parent().css({
            background: "#" + color
          });
        } else {
          $(this).parent().css({
            background: "#" + color,
            borderColor: "#" + color
          });
          if (multicolor.length) {
            return $(this).parent().css({
              boxShadow: "10px 0 0 #" + multicolor[1],
              marginRight: '10px'
            });
          }
        }
      });
    };

    return ColorCart;

  })();

  Haje.WC.PaymentMethods = (function() {
    function PaymentMethods() {
      this.init();
      $(document).ajaxSuccess((function(_this) {
        return function() {
          return _this.init();
        };
      })(this));
      $(document.body).on('updated_checkout', (function(_this) {
        return function() {
          return _this.init();
        };
      })(this));
    }

    PaymentMethods.prototype.init = function() {
      return $('#payment').each(function() {
        if ($(this).find('.wc_payment_method').length === 1) {
          return $(this).children('ul').addClass('single-method');
        } else {
          return $(this).children('ul').addClass('multiple-method');
        }
      });
    };

    return PaymentMethods;

  })();

  $(function() {
    new Haje.WC;
    new Haje.WC.Filters;
    new Haje.WC.Tabs;
    new Haje.WC.VariationNumberGuide;
    new Haje.WC.VariationSwatches;
    new Haje.WC.ColorCart;
    return new Haje.WC.PaymentMethods;
  });

}).call(this);


//# sourceMappingURL=haje.js.map

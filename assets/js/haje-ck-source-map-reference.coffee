"use strict"

$ = jQuery.noConflict()
ls = $.localStorage

$.fn.bgOverlay = (css = {}) ->
  @each ->
    overlay = $('<div class="bg-overlay"></div>').css(css)
    $(this).prepend(overlay).css({position: 'relative'})
    overlay

findKey = (obj, keyToFind) ->
  result = null
  $.each obj, (key, val) ->
    if key.toLowerCase() == keyToFind.toLowerCase()
      result = val
      return false
  result

class window.Haje
  constructor: ->
    # do ->
    #   $('.menu-login a').attr('href', _hj_vars.login_url)
    #   $('.menu-logout a').attr('href', _hj_vars.logout_url)

      # $('.menu-login, .menu-logout').find('a').each ->
      #   currentURL = window.location.href
      #   $(this).attr('href', $(this).attr('href') + '?' + $.param(redirect_to: currentURL))

    # do ->
    #   heading = $('.upsells h2, .related h2, .woocommerce-cart .woocommerce>form>h3, .cart-collaterals>h2, #customer_details h3, #order_review_heading, #nm-wishlist h1, .woocommerce-edit-address .woocommerce-MyAccount-content h2')
    #   heading.length && heading.each ->
    #     heading_html = $(this).html().trim()
    #     if ! /<[a-z][\s\S]*>/i.test(heading_html)
    #       substr = heading_html.split(/\s+/)
    #       substr_last = substr.pop()
    #       $(this).html(substr.join(' ') + " <em>#{substr_last}</em>")

    # new Headroom($('#nm-header')[0], {
    #   offset: 128,
    #   tolerance: 5,
    # }).init();

    $('#nm-mobile-menu-button').click ->
      hamburger = $(this).children('.hamburger')
      if $('body').hasClass('mobile-menu-open')
        hamburger.addClass('is-active')
      else
        hamburger.removeClass('is-active')

class Haje.Forms
  constructor: ->
    $('form .form-row').find('input, textarea, select, label')
      .focus -> $(this).closest('.form-row').addClass('focus')
      .blur -> $(this).closest('.form-row').removeClass('focus')

    $('p[class^="comment-form-"]').find('input, textarea, select, label')
      .focus -> $(this).closest('p[class^="comment-form-"]').addClass('focus')
      .blur -> $(this).closest('p[class^="comment-form-"]').removeClass('focus')

    $('.mc4wp-form input[type=email]')
      .focus -> $(this).closest('.mc4wp-form').addClass('focus')
      .blur -> $(this).closest('.mc4wp-form').removeClass('focus')

    # GRAVITY FORMS
    $('.ginput_container').find('input, textarea, select, label')
      .focus -> $(this).closest('.gfield').addClass('focus')
      .blur -> $(this).closest('.gfield').removeClass('focus')

    # # USERPRO
    # $('.userpro-field').find('input, textarea, select, label')
    #   .focus -> $(this).closest('.userpro-field').addClass('focus')
    #   .blur -> $(this).closest('.userpro-field').removeClass('focus')

    # PROFILE BUILDER
    $('.wppb-user-forms').find('input, textarea, select, label')
      .focus -> $(this).closest('.wppb-form-field, p').addClass('focus')
      .blur -> $(this).closest('.wppb-form-field, p').removeClass('focus')

    $('.wppb-user-forms').find(':checkbox')
      .each ->
        if $(this).is(':checked')
          $(this).closest('.wppb-form-field, p').addClass('checked')
      .change ->
        if $(this).is(':checked')
          $(this).closest('.wppb-form-field, p').addClass('checked')
        else
          $(this).closest('.wppb-form-field, p').removeClass('checked')

    $('.woocommerce-MyAccount-content .wppb-edit-user .wppb-password-heading .wppb-description-delimiter')
      .html('Leave the password fields blank if you don\'t need to change them.')

class Haje.Alert
  constructor: ->
    @setupAlert()

    window._alert = window.alert
    window.alert = (content) =>
      @showAlert(content)

  setupAlert: ->
    @overlay = $('<div class="hj-alert-overlay"></div>')
    @alert = $('<div class="hj-alert"><div class="hj-alert-content"></div><div class="hj-alert-action"><a href="#">Close</a></div></div>')
    @alertContent = @alert.find('.hj-alert-content')
    @actionButton = @alert.find('.hj-alert-action > a')

    @actionButton.click (ev) =>
      ev.stopPropagation()
      @overlay.removeClass('show')

    @overlay.click (ev) =>
      ev.stopPropagation()
      @overlay.removeClass('show')

    @alert.click (ev) ->
      ev.stopPropagation()

    $('body').append(@overlay.append(@alert))

  showAlert: (content = 'Test') ->
    @overlay.addClass('show')
    @alertContent.html(content)

# HS.beacon.config
#   color: '#2979FF'
#   icon: 'message'
#   poweredBy: false

$ ->
  new Haje
  new Haje.Forms
  new Haje.Alert

# @codekit-append "_haje-home";
# @codekit-append "_haje-wc";


"use strict"

$ = jQuery.noConflict()

class Haje.Home
  constructor: ->
    if !$('body').hasClass('home') then return

    do ->
      $('a[href*="#"]:not([href="#"])').click ->
        if location.pathname.replace(/^\//, '') == @pathname.replace(/^\//, '') and location.hostname == @hostname
          target = $(@hash)
          target = if target.length then target else $('[name=' + @hash.slice(1) + ']')
          console.log target
          if target.length
            TweenMax.to window, .5,
              scrollTo:
                y: target
                offsetY: 0
              ease: Power2.easeInOut
            return false
        return

    TweenMax.to('#haje-logo', 1, {
      delay: 2
      width: 300
      autoAlpha: 1
      ease: Back.easeOut.config(3) })

    tl = new TimelineMax repeat: -1
    tl
    .staggerTo('.hexagon', 2, {
      width: 340
      opacity: .3
      ease: Power3.easeInOut
    }, 0.5)
    .staggerTo('.hexagon', 1.5, {
      width: 700
      opacity: 0
      ease: Power3.easeInOut
    }, 0.2)

    $gradient = $('#home-gradient')
    $upright = $('#home-upright')

    # colors = Trianglify.colorbrewer.YlGnBu.reverse()
    # makePatternHero = (fadeIn = false) ->
    #   $gradient.find('canvas').remove()
    #   pattern = Trianglify(
    #     width: $gradient.outerWidth()
    #     height: $gradient.outerHeight()
    #     x_colors: colors
    #   )
    #   canvas = pattern.canvas()
    #   $gradient.append(canvas)
    #
    #   if fadeIn
    #     TweenMax.to(canvas, 3, { delay: 0, autoAlpha: .9, ease: Power2.easeInOut })
    #   else
    #     TweenMax.set(canvas, { autoAlpha: .9 })
    #
    # makePatternHero(true)
    #
    # $(window).resize $.debounce((->
    #   makePatternHero()
    # ), 10)
$ ->
  new Haje.Home


"use strict"

$ = jQuery.noConflict()
ls = $.localStorage

class Haje.WC
  constructor: ->
    # single_product_summary = $('.nm-product-thumbnails-col, .nm-product-images-col, .nm-product-summary-col, .nm-single-product-right-col')
    # single_product_summary.length && single_product_summary.imagesLoaded ->
    #   single_product_summary.matchHeight( property: 'min-height' )

class Haje.WC.Filters
  constructor: ->
    @init()

  init: ->
    color_widget = $('.nm_widget_color_filter')
    widget_title = $(color_widget).find('.nm-widget-title')
    original_title = widget_title.text()
    color_widget.data('original-title', original_title)

    $(color_widget).find('.wc-layered-nav-term a').each ->
      $(this).hover(
        => widget_title.text($(this).children('i')[0].nextSibling.nodeValue)
        => widget_title.text(color_widget.data('original-title'))
      )

class Haje.WC.Tabs
  constructor: ->
    $('.woocommerce-tabs .panel:first-child').addClass 'current'
    $('.woocommerce-tabs ul.tabs li a').off('click').on 'click', ->
      that = $(this)
      currentPanel = that.attr('href')
      that.parent().siblings().removeClass('active').end().addClass 'active'

      $('.woocommerce-tabs').find(currentPanel).siblings('.panel').filter(':visible').fadeOut 200, ->
        $('.woocommerce-tabs').find(currentPanel).siblings('.panel').removeClass 'current'
        $('.woocommerce-tabs').find(currentPanel).addClass('current').fadeIn 200

      false

class Haje.WC.VariationNumberGuide
  constructor: ->
    # $('#nm-product-summary table.variations .nm-variation-row .label').each (index, row) ->
    #   $(row).prepend("<div class='big-number'>#{index + 1}</div>")

class Haje.WC.VariationSwatches
  constructor: ->
    @init('#nm-product-summary')
    Haje.WC_Variation_Swatches = this

  init: (parent) ->
    return if !$(parent).find('table.variations .nm-variation-row').length

    @replaceSelect(parent)
    @toggleVariations(parent)
    # @resetVariations()

  # resetVariations: ->
  #   return if !$('a.reset_variations').length
  #
  #   $('a.reset_variations').detach().insertBefore('table.variations')

  colorFromName: (compare) ->
    if (haje_hex?)
      hex = findKey(haje_hex, compare)

      return hex

      # if hex.indexOf(',') > -1
      #   hex = hex.split(',')
      #   return [tinycolor(hex[0]).toHex(), tinycolor(hex[1]).toHex()]
      #
      # else
      #   return tinycolor(hex).toHex()

    else
      for name in ntc.names
        return name[0] if compare.toLowerCase().trim() == name[1].toLowerCase()

    false

  replaceSelect: (parent) ->
    _this = this

    # Loop around variation-row
    $(parent).find('table.variations .nm-variation-row').each ->
      variation_row = $(this).addClass('haje-swatch')
      variation_label = variation_row.children('.label')
      variation_value = variation_row.children('.value')

      attr_name = variation_row.data('attribute_name')

      isAttributeColor = attr_name == 'color' || attr_name == 'pa_color'
      isAttributeSize = attr_name == 'size' || attr_name == 'pa_size'

      # Add some structure
      variation_label.children('label').append('<div class="label-display"></div>')
      # variation_label.children('label').wrapInner('<div class="label-count"></div>').append('<div class="label-display"></div>')

      # variation_label_count = variation_label.find('.label-count')
      variation_label_display = variation_label.find('.label-display')

      # Replace select box
      select = variation_value.children('select')

      # Only continue if this a normal selectbox
      # If the selectbox has been replaced by "Variation Swatches & Colors" plugin, skip
      return if !select.length

      if isAttributeColor
        select.children('option').each ->
          if $(this).val() != ''
            $(this).attr('data-hex', _this.colorFromName($(this).val()))

      highlightColor = (hex) ->
        if isAttributeColor
          variation_label_display.removeClass('dark light');

          color = String hex
          color2 = null

          if color.indexOf(',') > -1
            multicolor = color.split(',')
            color = multicolor[0]
            color2 = multicolor[1]

          if !color2
            variation_label_display
              .addClass( if tinycolor(color).getBrightness() < 150 then 'dark' else 'light' )
              .css( background: "##{color}" )

          else
            variation_label_display
              .addClass( if tinycolor(color).getBrightness() < 150 then 'dark' else 'light' )
              .css(
                background: "##{color}",
                boxShadow: "-10px 0 0 ##{color2}" )

      dehighlightColor = ->
        if isAttributeColor
          variation_label_display
            .removeClass('dark light')
            .css(
              background: "none",
              boxShadow: "none" )

      select.togglebutton {
        removeFirst: true,
        onChange: (val, text, btn) ->
          if select.val()
            variation_label_display
              .text(text)
              .data('original-label', text)

            highlightColor(btn.data('hex'))

          else
            variation_label_display
              .data('original-label', '')

            dehighlightColor()
      }

      # Change label on hover
      select.data('buttons').hover(
        ->
          variation_label_display.data('original-label', variation_label_display.text())
          variation_label_display.text($(this).text())
        ,
        ->
          variation_label_display.text(variation_label_display.data('original-label'))
      )

      # Set label on init (through url param)
      variation_label_display.data('original-label', select.val())
      variation_label_display.text(select.val())
      # highlightColor()

      $.each select.data(), (attr_name, attr_val) ->
        if typeof attr_val == 'string'
          select.data('group').attr('data-' + attr_name, attr_val.replace(/^attribute_/, ''))

      if isAttributeColor
        _this.colorizeSwatch(select.data('buttons'))

        # Sort color by brightness
        select.data('buttons').sort (a, b) ->
          a_value = $(a).attr('value')
          # a_color = tinycolor(_this.colorFromName(a_value))

          a_color = String($(a).data('hex'))
          if a_color.indexOf(',') > -1
            a_color = a_color.split(',')[0]
          a_color = tinycolor(a_color)

          b_value = $(b).attr('value')
          # b_color = tinycolor(_this.colorFromName(b_value))

          b_color = String($(b).data('hex'))
          if b_color.indexOf(',') > -1
            b_color = b_color.split(',')[0]
          b_color = tinycolor(b_color)

          # b_color.getBrightness() - a_color.getBrightness()
          hue_diff = a_color.toHsl().h - b_color.toHsl().h
          if hue_diff != 0
            -hue_diff
          else
            b_color.getBrightness() - a_color.getBrightness()

        select.data('buttons').detach().appendTo(select.data('group'))

      if $('.size_guide_tab').length && isAttributeSize
        sizeguide = $('<button type="button" class="swatch size-guide">Size Guide</button>').appendTo(select.data('group'))

        sizeguide.click ->
          TweenMax.to window, .5,
            scrollTo:
              y: $('.wc-tabs')
              offsetY: 0
            ease: Power2.easeInOut
            onComplete: ->
              $('.wc-tabs .size_guide_tab a').trigger('click')

          # $('html, body').animate({
          #  scrollTop: $('.wc-tabs').offset().top
          # }, 300);

  colorizeSwatch: (swatches) ->
    _this = this

    swatches.each ->
      color = String $(this).data('hex')
      color2 = null

      if color.indexOf(',') > -1
        multicolor = color.split(',')
        color = multicolor[0]
        color2 = multicolor[1]

      if !color2
        $(this).css( background: "##{color}" )

      else
        altcolor = $('<span class="alt-color"></span>').css( background: "##{color2}" )
        $(this)
          .css( background: "##{color}", borderColor: "##{color2}", borderWidth: "8px" )
          .append(altcolor)

  toggleVariations: (parent) ->
    $(parent).find('table.variations .nm-variation-row').each ->
      variation_row = $(this)
      variation_label = variation_row.children('.label')
      variation_value = variation_row.children('.value')
      variation_label_display = variation_label.find('.label-display')

      attr_name = variation_row.data('attribute_name')

      # check localStorage
      if ls.get('haje_open_variation_' + $(this).data('attribute_name'))
        $(this).addClass('open')

      if location.href.indexOf('attribute_' + $(this).data('attribute_name')) > -1
        $(this).addClass('open')

      # bind click event
      variation_label.click ->
        value_container = $(this).next('.value')
        if (!variation_row.hasClass('open'))
          variation_row.addClass('open')
          ls.set('haje_open_variation_' + attr_name, true)
        else
          variation_row.removeClass('open')
          ls.set('haje_open_variation_' + attr_name, false)


class Haje.WC.ColorCart
  constructor: ->
    @init()

  init: ->
    @colorizeTags()

    $(document.body).on 'updated_checkout', => @colorizeTags()
    $(document.body).on 'wc_fragments_refreshed', => @colorizeTags()
    $(document.body).on 'added_to_cart', => @colorizeTags()

  colorizeTags: ->
    _this = this

    $('.cart_item, .mini_cart_item').find('.variation-Color:last-child p').each ->
      value = $(this).html()
      # product_id = $(this).closest('.cart_item, .mini_cart_item').attr('class').match(/product-id-(\d+)/)[1]
      # color = _this.colorFromName(value, product_id)
      color = String $(this).parent().data('hex')
      colorname = $(this).parent().data('color')

      multicolor = if color.indexOf(',') > -1 then color.split(',') else []

      if multicolor.length
        color = multicolor[0]

      $(this).parent().addClass( if tinycolor(color).getBrightness() < 150 then 'dark' else 'light' )

      if colorname == 'white' or colorname == 'White'
        $(this).parent().css( { background: "##{color}" } )
      else
        $(this).parent().css( { background: "##{color}", borderColor: "##{color}" } )
        if multicolor.length
          $(this).parent().css( { boxShadow: "10px 0 0 ##{multicolor[1]}", marginRight: '10px' } )

  # colorFromName: (compare, product_id = null) ->
  #   if (product_id and haje_cart_hex? and haje_cart_hex[product_id])
  #     return tinycolor(haje_cart_hex[product_id][compare]).toHex()
  #   else
  #     for name in ntc.names
  #       return name[0] if $.trim(compare.toLowerCase()) == name[1].toLowerCase()
  #   false

class Haje.WC.PaymentMethods
  constructor: ->
    @init()
    $(document).ajaxSuccess => @init()
    $(document.body).on 'updated_checkout', => @init()

  init: ->
    $('#payment').each ->
      if $(this).find('.wc_payment_method').length == 1
        $(this).children('ul').addClass('single-method')
      else
        $(this).children('ul').addClass('multiple-method')

$ ->
  new Haje.WC
  new Haje.WC.Filters
  new Haje.WC.Tabs
  new Haje.WC.VariationNumberGuide
  new Haje.WC.VariationSwatches
  new Haje.WC.ColorCart
  new Haje.WC.PaymentMethods
  # new Haje.Support



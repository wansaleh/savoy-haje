"use strict"

$ = jQuery
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
    $('#nm-footer').bgOverlay()

    # logolink = $('.header-transparency .nm-header-logo > a')
    # $(logolink).children('img.nm-logo').clone().addClass('alt').appendTo(logolink)


    # $(".wpb_wrapper h4").stick_in_parent({
    #   parent: ''
    #   offset_top: 200
    # })


class Haje.Alert
  constructor: ->
    @setupAlert()

    window._alert = window.alert
    window.alert = (content) =>
      @showAlert(content)

  setupAlert: ->
    @overlay = $('<div class="haje-alert-overlay"></div>')
    @alert = $('<div class="haje-alert"><div class="haje-alert-content"></div><div class="haje-alert-action"><a href="#">Close</a></div></div>')
    @alertContent = @alert.find('.haje-alert-content')
    @actionButton = @alert.find('.haje-alert-action > a')

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
    @alertContent.html(content)
    @overlay.addClass('show')

    $(document).on 'keyup', (evt) =>
      if evt.keyCode == 27
        @overlay.removeClass('show')
        $(document).off 'keyup'


class Haje.WC
  constructor: ->
    single_product_summary = $('.nm-product-thumbnails-col, .nm-product-images-col, .nm-product-summary-col, .nm-single-product-right-col')
    single_product_summary.imagesLoaded ->
      single_product_summary.matchHeight( property: 'min-height' )


class Haje.WC.Forms
  constructor: ->
    $('form .form-row').find('input, textarea, select, label')
      .focus -> $(this).closest('.form-row').addClass('focus')
      .blur -> $(this).closest('.form-row').removeClass('focus')

    $('p[class^="comment-form-"]').find('input, textarea, select, label')
      .focus -> $(this).closest('p[class^="comment-form-"]').addClass('focus')
      .blur -> $(this).closest('p[class^="comment-form-"]').removeClass('focus')


class Haje.WC.VariationSwatches
  constructor: ->
    @init($('#nm-product-summary'))

  init: (parent) ->
    return if !$(parent).find('table.variations .nm-variation-row').length

    @replaceSelect(parent)
    @toggleVariations(parent)
    # @resetVariations()

  # resetVariations: ->
  #   return if !$('a.reset_variations').length
  #
  #   $('a.reset_variations').detach().insertBefore('table.variations')


  replaceSelect: (parent) ->
    _this = this

    # Loop around variation-row
    $(parent).find('table.variations .nm-variation-row').each ->
      variation_row = $(this).addClass('haje-swatch')
      variation_label = variation_row.children('.label')
      variation_value = variation_row.children('.value')

      # Add some structure
      variation_label.children('label').wrapInner('<div class="label-count"></div>').append('<div class="label-display"></div>')

      variation_label_count = variation_label.find('.label-count')
      variation_label_display = variation_label.find('.label-display')

      # Replace select box
      select = variation_value.children('select')

      select.togglebutton {
        removeFirst: true,
        # onChange: (val, text) ->
        #   if select.val()
        #     # variation_label_display.addClass('active').text(text)
        #     variation_label_display.text(text)
        #     variation_label_display.data('original-label', text)
        #   else
        #     # variation_label_display.removeClass('active')
        #     variation_label_display.data('original-label', '')
      }

      $.each select.data(), (attr_name, attr_val) ->
        if typeof attr_val == 'string'
          select.data('group').attr('data-' + attr_name, attr_val.replace(/^attribute_/, ''))

      select.change ->
        if select.val()
          # variation_label_display.addClass('active')
          variation_label_display.text(select.val())
          variation_label_display.data('original-label', select.val())
        else
          # variation_label_display.removeClass('active')
          variation_label_display.data('original-label', '')


      # Change label on hover
      select.data('buttons').hover(
        ->
          variation_label_display.data('original-label', variation_label_display.text())
          variation_label_display.text($(this).text())
        ,
        ->
          variation_label_display.text(variation_label_display.data('original-label'))
      )

      if (variation_row.data('attribute_name') == 'color' ||
          variation_row.data('attribute_name') == 'pa_color')
        _this.colorizeSwatch(select.data('buttons'))

        # Sort color by brightness
        select.data('buttons').sort (a, b) ->
          a_value = $(a).attr('value')
          a_color = tinycolor(_this.colorFromName(a_value))
          b_value = $(b).attr('value')
          b_color = tinycolor(_this.colorFromName(b_value))

          b_color.getBrightness() - a_color.getBrightness()
          # hue_diff = a_color.toHsl().h - b_color.toHsl().h
          # if hue_diff != 0
          #   return -hue_diff
          # else
          #   b_color.getBrightness() - a_color.getBrightness()

        select.data('buttons').detach().appendTo(select.data('group'))

      # Number of Variations
      variation_label_count.html("<strong>#{select.data('buttons').length}</strong> #{variation_label_count.text()}s")

  colorizeSwatch: (swatches) ->
    _this = this

    swatches.each ->
      color = _this.colorFromName $(this).attr('value')
      $(this).css( backgroundColor: "##{color}" )

  toggleVariations: (parent) ->
    $(parent).find('table.variations .nm-variation-row').each ->
      variation_row = $(this)
      variation_label = variation_row.children('.label')
      variation_value = variation_row.children('.value')

      attr_name = variation_row.data('attribute_name')

      # check localStorage
      if ls.get('haje_open_variation_' + $(this).data('attribute_name'))
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

  colorFromName: (compare) ->
    if (_haje_hex?)
      return tinycolor(findKey(_haje_hex, compare)).toHex()
    else
      for name in ntc.names
        return name[0] if compare.toLowerCase().trim() == name[1].toLowerCase()
    false

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
      product_id = $(this).closest('.cart_item, .mini_cart_item').attr('class').match(/product-id-(\d+)/)[1]
      color = _this.colorFromName(value, product_id)

      $(this).parent().addClass( if tinycolor(color).getBrightness() < 180 then 'dark' else 'light' )
      $(this).parent().css( { background: "##{color}", borderColor: "##{color}" } )

  colorFromName: (compare, product_id = null) ->
    if (product_id and _haje_cart_hex? and _haje_cart_hex[product_id])
      return tinycolor(_haje_cart_hex[product_id][compare]).toHex()
    else
      for name in ntc.names
        return name[0] if $.trim(compare.toLowerCase()) == name[1].toLowerCase()
    false

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
  new Haje
  new Haje.Alert
  new Haje.WC
  new Haje.WC.Forms
  Haje.WC_Variation_Swatches = new Haje.WC.VariationSwatches
  new Haje.WC.ColorCart
  new Haje.WC.PaymentMethods

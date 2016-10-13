"use strict"

$ = jQuery
ls = $.localStorage

class Haje.WC
  constructor: ->
    single_product_summary = $('.nm-product-thumbnails-col, .nm-product-images-col, .nm-product-summary-col, .nm-single-product-right-col')
    single_product_summary.imagesLoaded ->
      single_product_summary.matchHeight( property: 'min-height' )

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


  replaceSelect: (parent) ->
    _this = this

    # Loop around variation-row
    $(parent).find('table.variations .nm-variation-row').each ->
      variation_row = $(this).addClass('haje-swatch')
      variation_label = variation_row.children('.label')
      variation_value = variation_row.children('.value')

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

      select.togglebutton({
        removeFirst: true,
        onChange: (val, text) ->
          if select.val()
            # variation_label_display.addClass('active').text(text)
            variation_label_display.text(text)
            variation_label_display.data('original-label', text)
          else
            # variation_label_display.removeClass('active')
            variation_label_display.data('original-label', '')
      })

      # Number of Variations
      # variation_label_count.html("<strong>#{select.data('buttons').length}</strong> #{variation_label_count.text()}s")

      $.each select.data(), (attr_name, attr_val) ->
        if typeof attr_val == 'string'
          select.data('group').attr('data-' + attr_name, attr_val.replace(/^attribute_/, ''))

      # select.change ->
      #   if select.val()
      #     # variation_label_display.addClass('active')
      #     variation_label_display.text(select.val())
      #     variation_label_display.data('original-label', select.val())
      #   else
      #     # variation_label_display.removeClass('active')
      #     variation_label_display.data('original-label', '')

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
          # a_color = tinycolor($(a).data('hex'))

          b_value = $(b).attr('value')
          b_color = tinycolor(_this.colorFromName(b_value))
          # b_color = tinycolor($(b).data('hex'))

          # b_color.getBrightness() - a_color.getBrightness()
          hue_diff = a_color.toHsl().h - b_color.toHsl().h
          if hue_diff != 0
            -hue_diff
          else
            b_color.getBrightness() - a_color.getBrightness()

        select.data('buttons').detach().appendTo(select.data('group'))

      if (variation_row.data('attribute_name') == 'size' ||
          variation_row.data('attribute_name') == 'pa_size')

        sizeguide = $('<button type="button" class="swatch size-guide">Size Guide</button>').appendTo(select.data('group'))

        sizeguide.click ->
          $.magnificPopup.open
            midClick: true
            closeBtnInside: true
            closeMarkup: '<a class="mfp-close nm-font nm-font-close2"></a>',
            items: {
              src: $('#ct_size_guide')
              type: 'inline'
            }


  colorizeSwatch: (swatches) ->
    _this = this

    swatches.each ->
      color = _this.colorFromName $(this).attr('value')
      # color = $(this).data('hex')
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
    if (haje_hex?)
      return tinycolor(findKey(haje_hex, compare)).toHex()
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
      # product_id = $(this).closest('.cart_item, .mini_cart_item').attr('class').match(/product-id-(\d+)/)[1]
      # color = _this.colorFromName(value, product_id)
      color = $(this).parent().data('hex')
      colorname = $(this).parent().data('color')

      $(this).parent().addClass( if tinycolor(color).getBrightness() < 180 then 'dark' else 'light' )

      if colorname == 'white' or colorname == 'White'
        $(this).parent().css( { background: "##{color}" } )
      else
        $(this).parent().css( { background: "##{color}", borderColor: "##{color}" } )

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
  new Haje.WC.VariationSwatches
  new Haje.WC.ColorCart
  new Haje.WC.PaymentMethods
  # new Haje.Support
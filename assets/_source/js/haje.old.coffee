"use strict"

$ = jQuery

debounce = (func, wait, immediate) ->
  timeout = undefined
  ->
    context = this
    args = arguments

    later = ->
      timeout = null
      if !immediate
        func.apply context, args
      return

    callNow = immediate and !timeout
    clearTimeout timeout
    timeout = setTimeout(later, wait)
    if callNow
      func.apply context, args
    return


class Haje
class Haje.WC
  constructor: ->
    single_product_summary = $('.nm-product-thumbnails-col, .nm-product-images-col, .nm-product-summary-col, .nm-single-product-right-col')
    single_product_summary.imagesLoaded ->
      single_product_summary.matchHeight()


class Haje.WC.Forms
  constructor: ->
    $('form .form-row').find('input, textarea, select, label')
      .focus -> $(this).closest('.form-row').addClass('focus')
      .blur -> $(this).closest('.form-row').removeClass('focus')

    $('p[class^="comment-form-"]').find('input, textarea, select, label')
      .focus -> $(this).closest('p[class^="comment-form-"]').addClass('focus')
      .blur -> $(this).closest('p[class^="comment-form-"]').removeClass('focus')


class Haje.WC.VariationForm
  constructor: ->
    return if !$('.sod_select').length

    _this = this

    # # set sod height
    # sodHeight = ->
    #   $('.sod_select').each ->
    #     bottom = $(this).position().top + $(this).offset().top + $(this).outerHeight(true)
    #     maxheight = $(window).height() - bottom - 40
    #     $(this).find('.sod_list_wrapper').css({ 'max-height': maxheight })
    #
    # sodHeight()
    # $(window).resize(debounce(sodHeight, 250))

    variations_form = $('.variations_form.cart')

    select = $('select#color')
    sod_select = select.closest('.sod_select')
    sod_list_wrapper = select.prev()
    sod_list = sod_list_wrapper.find('.sod_list')
    sod_label = select.prev().prev()

    sod_label.data('original', sod_label.html())

    addColorLabel = ->
      sod_options = sod_list_wrapper.find('.sod_option:not(:first-child)')
      sod_options.each ->
        value = $(this).data('value')
        color_label = $('<span class="haje_color_label">' + value + '</span>')
        $(this).html(color_label)
        color = _this.getColorFromName value
        color_label.addClass( if tinycolor(color).getBrightness() < 180 then 'dark' else 'light' )
        color_label.css( background: "##{color}" )

    # sod_option.sort (a, b) ->
    #   a_value = $(a).data('value')
    #   a_color = tinycolor(_this.getColorFromName(a_value))
    #   b_value = $(b).data('value')
    #   b_color = tinycolor(_this.getColorFromName(b_value))
    #
    #   b_color.toHsl().h - a_color.toHsl().h
    #
    # sod_option.detach().appendTo(sod_list)

    selectChange = ->
      value = select.val().trim()

      if value != ''
        sod_label_tag = $('<span class="haje_color_label">' + value + '</span>')
        sod_label.html(sod_label_tag)
        color = _this.getColorFromName sod_label_tag.html()
        sod_label_tag.removeClass('dark light').addClass( if tinycolor(color).getBrightness() < 180 then 'dark' else 'light' )
        sod_label_tag.css( background: "##{color}" )
      else
        sod_label.html(sod_label.data('original'))

    select.change selectChange
    select.change ->
      $('#nm-product-images-slider').slick('slickGoTo', 0, false);

    sod_select.click selectChange
    sod_select.click addColorLabel

    selectChange()


  getColorFromName: (compare) ->
    if (_haje_color_hex?)
      return _haje_color_hex[compare]
    else
      for name in ntc.names
        return name[0] if compare.toLowerCase().trim() == name[1].toLowerCase()



class Haje.WC.ColorCart
  constructor: ->
    return if !$('.woocommerce-cart .cart_item').length

    _this = this

    $('.woocommerce-cart .cart_item .variation-Color:last-child p').each ->
      value = $(this).html()
      product_id = $(this).closest('.cart_item').attr('class').match(/product-id-(\d+)/)[1]
      color = _this.getColorFromName(value, product_id)

      $(this).parent().addClass( if tinycolor(color).getBrightness() < 180 then 'dark' else 'light' )
      $(this).parent().css( { background: "##{color}", borderColor: "##{color}" } )

  getColorFromName: (compare, product_id = null) ->
    if (product_id and _haje_cart_color_hex? and _haje_cart_color_hex[product_id])
      return _haje_cart_color_hex[product_id][compare]
    else
    for name in ntc.names
      return name[0] if $.trim(compare.toLowerCase()) == name[1].toLowerCase()

$ ->
  new Haje.WC
  new Haje.WC.Forms
  new Haje.WC.VariationForm
  new Haje.WC.ColorCart

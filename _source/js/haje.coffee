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
    do ->
      $('a[href*="#"]:not([href="#"])').click ->
        if location.pathname.replace(/^\//, '') == @pathname.replace(/^\//, '') and location.hostname == @hostname
          target = $(@hash)
          target = if target.length then target else $('[name=' + @hash.slice(1) + ']')
          console.log target
          if target.length
            $(target).velocity 'scroll',
              duration: 500
              offset: -40
              easing: 'ease-in-out'

            # $('html, body').velocity { scrollTop: target.offset().top }, 300, 'easeInOutQuad'
            return false
        return


    do ->
      heading = $('.upsells h2, .related h2, .woocommerce-cart .woocommerce>form>h3, .cart-collaterals>h2, #customer_details h3, #order_review_heading, #nm-wishlist h1, .woocommerce-edit-address .woocommerce-MyAccount-content h2')
      heading.length && heading.each ->
        heading_html = $(this).html().trim()
        if ! /<[a-z][\s\S]*>/i.test(heading_html)
          substr = heading_html.split(/\s+/)
          substr_last = substr.pop()
          $(this).html(substr.join(' ') + " <em>#{substr_last}</em>")

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
    @alertContent.html(content)
    @overlay.addClass('show')

# HS.beacon.config
#   color: '#2979FF'
#   icon: 'message'
#   poweredBy: false

$ ->
  new Haje
  new Haje.Forms
  new Haje.Alert

# @codekit-append "haje-wc";

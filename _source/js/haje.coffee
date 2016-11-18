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

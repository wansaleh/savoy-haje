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
  new Haje.Alert

# @codekit-append "_haje-forms";
# @codekit-append "_haje-home";
# @codekit-append "_haje-wc";

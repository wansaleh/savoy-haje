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
    new Headroom($('#nm-header')[0], {
      offset: 128,
      tolerance: 5,
    }).init();

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

# HS.beacon.config
#   color: '#2979FF'
#   icon: 'message'
#   poweredBy: false

$ ->
  new Haje
  new Haje.Forms
  new Haje.Alert

# @codekit-append "haje-wc";

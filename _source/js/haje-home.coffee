"use strict"

$ = jQuery.noConflict()

class Haje.Home
  constructor: ->
    if !$('body').hasClass('home') then return

    TweenMax.to($('#haje-logo')[0], 1, {
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

    colors = Trianglify.colorbrewer.YlGnBu.reverse()

    makePatternHero = (fadeIn = false) ->
      $gradient.find('canvas').remove()
      pattern = Trianglify(
        width: $gradient.outerWidth()
        height: $gradient.outerHeight()
        x_colors: colors
      )
      canvas = pattern.canvas()
      $gradient.append(canvas)

      if fadeIn
        TweenMax.to(canvas, 3, { delay: 0, autoAlpha: .9, ease: Power2.easeInOut })
      else
        TweenMax.set(canvas, { autoAlpha: .9 })

    makePatternHero(true)

    $(window).resize $.debounce((->
      makePatternHero()
    ), 10)
$ ->
  new Haje.Home

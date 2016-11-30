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

    # new Vivus('hero-waves', { duration: 2000 })

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

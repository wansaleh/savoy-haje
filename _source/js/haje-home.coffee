"use strict"

$ = jQuery

class Haje.Home
  constructor: ->

    $('.hexagon-dashed').clone().insertAfter('.hexagon-dashed:last-of-type')
    $('.hexagon-dashed:last-of-type').clone().insertAfter('.hexagon-dashed:last-of-type')
    $('.hexagon-dashed:last-of-type').clone().insertAfter('.hexagon-dashed:last-of-type')
    $('.hexagon-dashed:last-of-type').clone().insertAfter('.hexagon-dashed:last-of-type')

    tl = new TimelineMax(repeat: -1)

    TweenMax.staggerTo '.hexagon-dashed', 5, {
      width: 700
      autoAlpha: 0
      ease: Power3.easeInOut
      repeat: -1
    }, 0.35

    # TweenMax.staggerTo '.ripple-inner', 5, {
    #   width: 1000
    #   height: 1000
    #   x: '-=500'
    #   y: '-=500'
    #   autoAlpha: 0
    #   ease: Power3.easeInOut
    #   repeat: -1
    # }, 0.4

$ ->
  new Haje.Home

"use strict"

$ = jQuery.noConflict()

class Haje.Forms
  constructor: ->
    @base()
    @gforms()

  base: ->
    $('form .form-row').find('input, textarea, select, label')
      .focus -> $(this).closest('.form-row').addClass('focus')
      .blur -> $(this).closest('.form-row').removeClass('focus')

    $('p[class^="comment-form-"]').find('input, textarea, select, label')
      .focus -> $(this).closest('p[class^="comment-form-"]').addClass('focus')
      .blur -> $(this).closest('p[class^="comment-form-"]').removeClass('focus')

    $('.mc4wp-form input[type=email]')
      .focus -> $(this).closest('.mc4wp-form').addClass('focus')
      .blur -> $(this).closest('.mc4wp-form').removeClass('focus')

    # Follow Up Emails Checkout Opt-in
    $('.followup-checkout input[type=checkbox]').each ->
      _this = $(this)
      check = ->
        if _this.is(':checked')
          _this.closest('label').addClass('checked')
        else
          _this.closest('label').removeClass('checked')

      check()
      $(this).change check

    # # USERPRO
    # $('.userpro-field').find('input, textarea, select, label')
    #   .focus -> $(this).closest('.userpro-field').addClass('focus')
    #   .blur -> $(this).closest('.userpro-field').removeClass('focus')

  gforms: ->
    # GRAVITY FORMS
    $('.gfield:not(.gf_readonly)').find('input, textarea, select, label')
      .focus -> $(this).closest('.gfield').addClass('focus')
      .blur -> $(this).closest('.gfield').removeClass('focus')

    $(".gfield.gf_readonly input").attr("readonly", "readonly")

  wppb: ->
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

    $('.woocommerce-MyAccount-content .wppb-edit-user .wppb-password-heading .wppb-description-delimiter')
      .html('Leave the password fields blank if you don\'t need to change them.')

$ ->
  new Haje.Forms

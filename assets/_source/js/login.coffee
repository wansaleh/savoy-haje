$ = jQuery

$ ->

  if $('p.message').length
    $('p.message').html($('p.message').html().replace('Register For This Site', 'Register with Haje.'))

  $('#loginform label input')
    .focus -> $(this).parent().addClass('focus')
    .blur -> $(this).parent().removeClass('focus')

  $('#registerform label input')
    .focus -> $(this).parent().addClass('focus')
    .blur -> $(this).parent().removeClass('focus')

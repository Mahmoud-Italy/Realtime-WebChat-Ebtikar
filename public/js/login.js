$(document).ready(function(){

  $('.input').focus(function(){
    $(this).parent().find(".label-txt").addClass('label-active');
  });

  $(".input").focusout(function(){
    if ($(this).val() == '') {
      $(this).parent().find(".label-txt").removeClass('label-active');
    };
  });

  $('.openSignup').click(function(){
  	$("#frmLogin").addClass('hidden');
  	$("#frmSignup").removeClass('hidden').fadeIn();
  });

  $('.openLogin').click(function(){
  	$("#frmSignup").addClass('hidden');
  	$("#frmLogin").removeClass('hidden').fadeIn();
  });

});
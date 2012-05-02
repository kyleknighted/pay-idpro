function stripeResponseHandler(status, response) {
  // console.log(status);
  // console.log(response);
  if (response.error) {
    // re-enable the submit button
    $('.submit-button').removeAttr("disabled");
    // show the errors on the form
    $(".payment-errors").html(response.error.message);
    // console.log(response.error.message);
  } else {
    var form$ = $("#gkmpay");
    // token contains id, last4, and card type
    var token = response['id'];
    // insert the token into the form so it gets submitted to the server
    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
    // and submit
    form$.get(0).submit();
  }
}

$(function(){
  $('#ccard').creditcard({
    'cardType' :  '#card-type',
    'cardNames'   :  {'mc' : 'MasterCard', 'visa' : 'Visa', 'disc' : 'Discover', 'amex' : 'American Express'}
  });

  $('#gkmpay').submit(function(e){
    $('.submit-button').attr("disabled", "disabled");
    $('input', this).each(function(){
      if($(this).val() == '') {
        $(this).parents('.control-group').addClass('error');
        $('.payment-errors').text('All fields are required.');
        $('.submit-button').removeAttr("disabled");
      } else {
        $(this).parents('.control-group').removeClass('error');
      }
    });
    $('select', this).each(function(){
      if($(this).val() == '') {
        $(this).parents('.control-group').addClass('error');
        $('.payment-errors').text('All fields are required.');
        $('.submit-button').removeAttr("disabled");
      } else {
        $(this).parents('.control-group').removeClass('error');
      }
    });

    if($('.error').length === 0) {
      $('.payment-errors').text('');
      Stripe.createToken({
        number: $('#ccard').val(),
        cvc: $('#cccvv').val(),
        exp_month: $('#exp_mm').val(),
        exp_year: $('#exp_yy').val()
      }, stripeResponseHandler);
    } else {
      $('.payment-errors').text('All fields are required.');
      $('.submit-button').removeAttr("disabled");
    }
    e.preventDefault();
  });
});
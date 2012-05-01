<?php
// set your secret key: remember to change this to your live secret key in production
// see your keys here https://manage.stripe.com/account
Stripe::setApiKey("20CFf2y7xRHoVezUgAIDeX8rJFgWytkg");

// get the credit card details submitted by the form
$token = $_POST['stripeToken'];
$invoice = $_POST['invoice'];
$amount = $_POST['amount'] * 100;

// create the charge on Stripe's servers - this will charge the user's card
$charge = Stripe_Charge::create(array(
  "amount" => $amount, // amount in cents, again
  "currency" => "usd",
  "card" => $token,
  "description" => "Invoice: $invoice")
);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Good Knight Mulimedia - Online Payment</title>
    <meta name="description" content="">
    <meta name="author" content="Kyle Knight">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      .container {
        padding-top: 30px;
      }
      #jqcard-type { margin: 0; padding: 0; float: left; }
      #jqcard-type li {
        list-style: none;
        float: left;
        margin: 0 3px 0 0;
        display: block;
        width: 24px;
        height: 24px;
        background: url(img/ccards.png) no-repeat 0 0;
        text-indent: -999em;
      }
      #jqcard-type li.visa { background-position: 0px 0px; }
      #jqcard-type li.visa.active { background-position: 0px -24px; }
      #jqcard-type li.mc { background-position: -24px 0px; }
      #jqcard-type li.mc.active { background-position: -24px -24px; }
      #jqcard-type li.amex { background-position: -48px 0px; }
      #jqcard-type li.amex.active { background-position: -48px -24px; }
      #jqcard-type li.disc { background-position: -72px 0px; }
      #jqcard-type li.disc.active { background-position: -72px -24px; }
      .cc-warning { color: #ff8400; clear: left; }
      .cc-error { color: #f00; clear: left; }
      .cc-success { color: #0c621c; clear: left; }
      
      #shipto-address { display: none; }
    </style>
    
    <script src="js/jquery-1.7.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.creditcard.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
    
    <script>
    Stripe.setPublishableKey('pk_fRxCsPx1cntNqqVD6WG1yO1Ill4Ir');

    function stripeResponseHandler(status, response) {
      if (response.error) {
        // re-enable the submit button
        $('.submit-button').removeAttr("disabled");
        // show the errors on the form
        $(".payment-errors").html(response.error.message);
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
          } else {
            $(this).parents('.control-group').removeClass('error');
          }
        });
        $('select', this).each(function(){
          if($(this).val() == '') {
            $(this).parents('.control-group').addClass('error');
          } else {
            $(this).parents('.control-group').removeClass('error');
          }
        });

        if($('.error').length === 0) {
          Stripe.createToken({
            number: $('#ccard').val(),
            cvc: $('#cccvv').val(),
            exp_month: $('#exp_mm').val(),
            exp_year: $('#exp_yy').val()
          }, stripeResponseHandler);
        }
        e.preventDefault();
      });
    });
    </script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
  </head>

  <body>

    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">Creditcard</a>
          <ul class="nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Welcome to GKMOPPMYLEBNYDHMMC!</h1>
        <p>Which stands for 'Good Knight Multimedia Online Payment Processor to Make Your Life Easier Because Now You Don't Have to Mail Me a Check'.</p>
        <p>Please contact me at <a href="mailto:kyle@idprojections.com">kyle@idprojections.com</a> if you have any issues using this system.</p>
      </div>

      <!-- Example row of columns -->
      <div class="row">

        <form action="/" method="post" id="gkmpay">
          <div class="span5">
            <legend>Billing Info</legend>
            <fieldset class="control-group">
              <label class="control-label" for="billing-name">Full Name</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-name" name="billing-name">
              </div>
            </fieldset>
            <fieldset class="control-group">
              <label class="control-label" for="billing-address">Address</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-address" name="billing-address">
              </div>
            </fieldset>
            <fieldset class="control-group">
              <label class="control-label" for="billing-city">City</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-city" name="billing-city">
              </div>
            </fieldset>
            <fieldset class="control-group">
              <label class="control-label" for="billing-state">State</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-state" name="billing-state">
              </div>
            </fieldset>
            <fieldset class="control-group">
              <label class="control-label" for="billing-code">Postal Code</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-code" name="billing-code">
              </div>
            </fieldset>
            <fieldset class="control-group">
              <label class="control-label" for="billing-phone">Phone Number</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-phone" name="billing-phone">
              </div>
            </fieldset>
            <fieldset class="control-group">
              <label class="control-label" for="billing-email">Email Address</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-email" name="billing-email">
              </div>
            </fieldset>
          </div>
          <div class="span6">
              <legend>Enter Billing Info</legend>
              <fieldset class="control-group">
                <label class="control-label" for="amount">Amount Paying</label>
                <div class="controls">
                  <input type="text" class="xlarge" id="amount" name="amount">
                  <p class="help-text">Please do not include the dollar sign ($)</p>
                </div>
              </fieldset>
              <fieldset class="control-group">
                <label class="control-label" for="invoice">Invoice Number</label>
                <div class="controls">
                  <input type="text" class="xlarge" id="invoice" name="invoice">
                  <p class="help-text">Please include the invoice number you are paying against</p>
                </div>
              </fieldset>
              <fieldset class="control-group">
                <label class="control-label" for="ccard">Credit Card Number</label>
                <div class="controls">
                  <input type="text" class="xlarge" id="ccard" name="ccard">
                  <p class="help-text">We accept Visa, MasterCard, Discover, and Amex.</p>
                </div>
              </fieldset>
              <fieldset class="control-group">
                <label class="control-label" for="card-type">Choose Card Type</label>
                <div class="controls">
                  <select name="card-type" id="card-type">
                    <option value="">Select One</option>
                    <option value="visa">Visa</option>
                    <option value="mc">MasterCard</option>
                    <option value="disc">Discover</option>
                    <option value="amex">American Express</option>
                  </select>
                </div>
              </fieldset>
              <fieldset class="control-group">
                <label class="control-label" for="ccard">Expiration Date MM/YY</label>
                <div class="controls">
                  <select name="exp_mm" id="exp_mm">
                    <option value="">MM</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
                  <select name="exp_yy" id="exp_yy">
                    <option value="">YY</option>
                    <option value="2012">12</option>
                    <option value="2013">13</option>
                    <option value="2014">14</option>
                    <option value="2015">15</option>
                    <option value="2016">16</option>
                    <option value="2017">17</option>
                    <option value="2018">18</option>
                    <option value="2019">19</option>
                    <option value="2020">20</option>
                  </select>
                </div>
              </fieldset>
              <fieldset class="control-group">
                <label class="control-label" for="cccvv">Security Code (CSV/CVV)</label>
                <div class="controls">
                  <input type="text" class="xlarge" id="cccvv" name="cccvv">
                  <p class="help-text">It's usually a three digit number on the back of your card</p>
                </div>
                <div id="card-type"></div>
              </fieldset>
              <fieldset class="form-actions">
                <input type="submit" class="btn btn-primary submit-button" value="Pay!">
              </fieldset>
            </form>
          </div>
        </form>
      </div>
      

      <footer>
        <p>&copy; Good Knight Multimedia <?php echo date('Y'); ?></p>
      </footer>

    </div> <!-- /container -->

  </body>
</html>
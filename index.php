<?php
$paid = false;
if($_POST) {
  require_once("stripe/lib/Stripe.php");
  // set your secret key: remember to change this to your live secret key in production
  // see your keys here https://manage.stripe.com/account
  Stripe::setApiKey($_ENV["STRIPE_PRIVATE"]);

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
  $paid = true;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Good Knight Mulimedia - Online Payment</title>
    <meta name="description" content="An easy way to take payments online.">
    <meta name="author" content="Kyle Knight">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
    
    <script src="js/jquery-1.7.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.creditcard.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.stripe.com/v1/" type="text/javascript"></script>
    <script>Stripe.setPublishableKey('<?php echo $_ENV["STRIPE_PUBLIC"]; ?>');</script>
    <script src="js/common.js" type="text/javascript" charset="utf-8"></script>
    
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="/">GKMOPPMYLEBNYDHMMC</a>
        </div>
      </div>
    </div>

    <div class="container main-wrap">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <?php if($paid) { ?>
      <div class="hero-unit">
        <h1>Thank you!</h1>
        <p>Your payment has been processed.</p>
        <p>Please contact me at <a href="mailto:kyle@idprojections.com">kyle@idprojections.com</a> if you have any issues using this system.</p>
      </div>
      <?php } else { ?>
      <div class="hero-unit">
        <h1>Welcome to GKMOPPMYLEBNYDHMMC!</h1>
        <p>Which stands for 'Good Knight Multimedia Online Payment Processor to Make Your Life Easier Because Now You Don't Have to Mail Me a Check'.</p>
        <p>Please contact me at <a href="mailto:kyle@idprojections.com">kyle@idprojections.com</a> if you have any issues using this system.</p>
      </div>
      <?php } ?>
      
      <!-- Example row of columns -->
      <form action="/" method="post" id="gkmpay">
        <div class="row">
          <div class="span12">
            <p class="payment-errors"></p>
          </div>
        </div>
        <div class="row">
          <div class="span6">
            <legend>Personal Info</legend>
            <div class="control-group">
              <label class="control-label" for="billing-name">Full Name</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-name" name="billing-name">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="billing-address">Address</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-address" name="billing-address">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="billing-city">City</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-city" name="billing-city">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="billing-state">State</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-state" name="billing-state">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="billing-code">Postal Code</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-code" name="billing-code">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="billing-phone">Phone Number</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-phone" name="billing-phone">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="billing-email">Email Address</label>
              <div class="controls">
                <input type="text" class="xlarge" id="billing-email" name="billing-email">
              </div>
            </div>
          </div>
          <div class="span6">
            <legend>Billing Info</legend>
            <div class="control-group">
              <label class="control-label" for="amount">Amount Paying</label>
              <div class="controls">
                <input type="text" class="xlarge" id="amount" name="amount">
                <p class="help-text">Please do not include the dollar sign ($)</p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="invoice">Invoice Number</label>
              <div class="controls">
                <input type="text" class="xlarge" id="invoice" name="invoice">
                <p class="help-text">Please include the invoice number you are paying against</p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="ccard">Credit Card Number</label>
              <div class="controls">
                <input type="text" class="xlarge" id="ccard">
                <p class="help-text">We accept Visa, MasterCard, Discover, and Amex.</p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="card-type">Card Type</label>
              <div class="controls">
                <select id="card-type">
                  <option value="">Select One</option>
                  <option value="visa">Visa</option>
                  <option value="mc">MasterCard</option>
                  <option value="disc">Discover</option>
                  <option value="amex">American Express</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="ccard">Expiration Date MM/YY</label>
              <div class="controls">
                <select id="exp_mm">
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
                <select id="exp_yy">
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
            </div>
            <div class="control-group">
              <label class="control-label" for="cccvv">Security Code (CSV/CVV)</label>
              <div class="controls">
                <input type="text" class="xlarge" id="cccvv">
                <p class="help-text">It's usually a three digit number on the back of your card</p>
              </div>
              <div id="card-type"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="span12">
            <div class="form-actions">
              <input type="submit" class="btn btn-primary submit-button" value="Pay!">
            </div>
          </div>
        </div>
      </form>
      

      <footer>
        <p>&copy; Good Knight Multimedia <?php echo date('Y'); ?></p>
      </footer>

    </div> <!-- /container -->

  </body>
</html>
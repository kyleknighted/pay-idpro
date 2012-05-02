/* ============================================================
 * jquery.credicard.js v0.1.1
 * http://twitter.github.com/idpro
 * ============================================================
 * Copyright (C) 2012 Good Knight Multimedia, LLC
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all 
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR 
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE 
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, 
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE 
 * OR OTHER DEALINGS IN THE SOFTWARE.
 * ============================================================ */

(function ($) {
  $.fn.creditcard = function (options) {
    // For now, the only option is the wrapper ID for the CC logos
    var settings = $.extend( {
      'cardType'  :  '#card-type',
      'cardNames' :  {'mc' : 'MasterCard', 'visa' : 'Visa', 'disc' : 'Discover', 'amex' : 'American Express', 'diner' : 'Diners Club'},
      'cardRegex' :  {'mc' : /^5[1-5][0-9]{14}$/, 'visa' : /^4[0-9]{12}(?:[0-9]{3})?$/, 'disc' : /^6(?:011|5[0-9]{2})[0-9]{12}$/, 'amex' : /^3[47][0-9]{13}$/, 'diner' : /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/}
    }, options);
    
    // Init Variables
    var typeWrapper, cardNames, cardRegex, messageWrap, testNumbers;
    
    // Set Variables
    cardType = $(settings.cardType);
    cardType.before('<ul id="jqcard-type"></ul><p id="jqcard-message"></p>').hide();
    typeWrapper = $('#jqcard-type');
    messageWrap = $('#jqcard-message');
    cardNames = settings.cardNames;
    cardRegex = settings.cardRegex;
    
    // Setup array of known test numbers
    testNumbers = [
      '378282246310005', // amex
      '371449635398431', // amex
      '378734493671000', // amex
      '30569309025904', // diners
      '38520000023237', // diners
      '6011111111111117', // disc
      '6011000990139424', // disc
      '5555555555554444', // mc
      '5105105105105100', // mc
      '4111111111111111', // visa
      '4012888888881881', // visa
      '4242424242424242', // visa
      '4222222222222' // visa
    ];
    
    $.each(cardNames, function(index, value){
      $(typeWrapper).append('<li class="'+index+'">'+value+'</li>')
    });

    return this.each(function (i, obj) {
      // Grab Input Object
      var ccard = $(this);
      

      ccard.keydown(function (event) {
        // Allow only backspace, delete, tab, and numbers
        if (event.keyCode === 46 || event.keyCode === 8 || event.keyCode === 9) {
          // let it happen, don't do anything
        } else {
          // Ensure that it is a number or stop the keypress
          if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
            event.preventDefault();
          }
        }
      });

      ccard.keyup(function () {
        cnum = ccard.val();
        // validate card number against number range and count
        $.each(cardRegex, function (index, value) {
          if (value.test(cnum)) {
            $('li.' + index, typeWrapper).addClass('active'); 
            $('#card-type option[value="'+index+'"]').prop('selected', true);
            // validate card against known test numbers
            $.each(testNumbers, function (index, value) {
              if (value == cnum) {
                messageWrap.text('Warning: This is a known test number.').removeClass().addClass('cc-warning');
                return false;
              }
            });

            // validate security code against Luhn Algorithm (http://en.wikipedia.org/wiki/Luhn_algorithm)
            var checksum = 0;
            var mychar = "";
            var j = 1;
          
            var calc;
            for (i = cnum.length - 1; i >= 0; i--) {
              calc = Number(cnum.charAt(i)) * j;
              if (calc > 9) {
                checksum = checksum + 1;
                calc = calc - 10;
              }
              checksum = checksum + calc;
              if (j == 1) {
                j = 2
              } else {
                j = 1
              };
            }

            if (checksum % 10 != 0) { // not mod10
              messageWrap.text('Error: Invalid Card Number.').removeClass().addClass('cc-error');
            }
          
            return false;
          } else {
            $('li', typeWrapper).removeClass('active');
            messageWrap.text('Error: Invalid Card Number.').removeClass().addClass('cc-error');
          }
        });
      });
    });
  }
})(jQuery);
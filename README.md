pay.idprojections.com
=====================

Quick tutorial to get payments up and running on [Heroku](http://www.heroku.com/)

* If you don't know GIT, Command Prompt, or PHP you should probably find someone who does or do some research first.
* Sign up for Heroku and install the CLI.
* Go to your command prompt, I'm on a Mac, so these sample commands are in Terminal, so I don't guarantee they run in Linux or Windows.
* You will want to grab the code from here `cd ~/Sites` and `git clone git@github.com:idpro/pay-idpro.git APPNAME`
  * Where APPNAME is the name of your product.
* `heroku create APPNAME --stack cedar` 
  * Remember the git URL they return, usually git@heroku.com:APPNAME.git
* Change directory to your project `cd ~/Sites/APPNAME`
* Make the changes to your new application and `git commit -am "your commit message"`
* Now that your git repository is ready to go you can add Heroku as a destination.
* `git remote add heroku git@heroku.com:APPNAME.git`
* Add the Stripe API variables to the Heroku enviroment `heroku config:add STRIPE_PUBLIC=pk_xxxxxxxx STRIPE_PRIVATE=yyyyyyyyy --app APPNAME`
  * This will allow you to not have to add these variables directly into your code
* Now that we have your repo setup, you've edited the code to your liking, you've commited all your changes, setup your Heroku app and setup the enviroment variables, you are ready to deploy your application with `git push heroku master`

This should be all you need to get running, feel free to post an Issue if you run into any problems and I'll do my best to help out!

This is free, released under the [MIT License](http://www.opensource.org/licenses/mit-license.php)

I do not guarantee that this code works beyond the date that I launched it. It worked at one point and it probably still works, you may have just done something wrong.

If you'd like to donate your hard earned money to me so that I can continue to buy the fuel that helps me build (Bud Select), it'd be much aprpeciated. Also, while you're donating, you'll notice that this is also a demo of the application you're about to download.

[Donate and/or Demo](https://idpro.herokuapp.com/)

- - - - 

Copyright (C) 2012 Good Knight Multimedia, LLC

Permission is hereby granted, free of charge, to any person obtaining a copy of  
this software and associated documentation files (the "Software"), to deal in  
the Software without restriction, including without limitation the rights to  
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of  
the Software, and to permit persons to whom the Software is furnished to do so,  
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all   
copies or substantial portions of the Software. 

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,  
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR  
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE  
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,  
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE   
OR OTHER DEALINGS IN THE SOFTWARE.  
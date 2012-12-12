#BgSlider

A mootools based fullscreen background slider with fade effect for Contao 3.


## Features

* Autoplay
* Transition / wait time configuration
* Navigation
* Slide after site-change: The last background image gets restored on domready and slides to the sites-one after this is fully loaded.
* Shows the image which name is identically to the page-alias first

The last two features lets you nicly use a fullscreen-background-image for every single page with a nice transition after page-change. The visitor dosnt have to look to the ugly background-color until the image is loaded.


## Installation/Usage
Just copy the files to `system/modules/BgSlider` and run a database-update. Or use the Contao extension repository.

After installation you could create a new Module `BgSlider` and include it into your pagelayout.

If you use the Navigation youve to CSS `#BgSliderPrev` and `#BgSliderNext` Elements a bit. They get injected into `<body>`.

### Copyright
License: http://www.gnu.org/licenses/lgpl-3.0.html LGPL <br>
Author: [4ward.media](http://www.4wardmedia.de)
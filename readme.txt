# Emulsion

Contributors: nobita
Requires at least: WordPress 5.3
Tested up to: WordPress 6.0
Requires PHP: 5.6
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: one-column, two-columns, left-sidebar, right-sidebar, custom-colors, custom-header, custom-background, custom-menu, editor-style, theme-options, threaded-comments, sticky-post, translation-ready, post-formats, featured-images, full-width-template, grid-layout, flexible-header, custom-logo, featured-image-header, footer-widgets, block-styles, wide-blocks

## Description

By switching Customize / Theme Operation Mode. A universal theme that allows you to use the latest Setting Full Site Editing (Editor), Block Editor, Block Template.You can also view the traditional sidebar by selecting FSE Transitional Theme.You will be free to go back and forth between the future of WordPress and the present.

* Archives layout
	* Archive has 3 layout. list, grid and stream
        * list : Displays posts in list format. You can set whether to display featured image.
        * grid : Displays posts in grid format. You can set whether to display featured image.
        * stream : Displays posts in stream format. You can set whether to display featured image.The contents can be displayed simply by operating the buttons. In this case, page transition is not performed and Rest API is used.

* Entry Title
	* In grid layout and stream layout, long titles are displayed up to two lines. If there are more than 2 lines in length, reduce the font size
        * When the post title is displayed in the header, it will be displayed in up to 8 lines.If there are more than 2 lines in length, reduce the font size

* Entry Content
	* excerpt: Summary is not counted by word count. Based on the number of characters. This is to support CJK languages with no spaces between words.
        * <table> <del> <figure> <blockquote> These elements are not included in excerpt.

* Page Spead ( apply front end and not logged in )
	* In order to harmonize the Rich Media created by the block editor with the Respose of the site, there are lazyload of images and pre-during functions at link hover.
	* If there is a similar function in a plug-in, etc., there is a possibility of conflict. You can stop these functions in the customizer.

* About compatibility with plug-ins
        * Cache plugin : This theme performs simple display on the ie11 browser. When using a cache plug-in, it is recommended to change to a setting that does not use the cache when accessing from a browser older than IE 11
        * Lazy load plugin : This theme includes lazyload function. When plug-in is used, it may conflict and may not work properly
        * Experimental support plugins [AMP](https://wordpress.org/plugins/amp/), [PWA](https://wordpress.org/plugins/pwa/)
        * If you have any problems using the plugin, please contact support forum
## Translations

* You can translate the theme on the following channels
	* [translate.wordpress.org](https://translate.wordpress.org/projects/wp-themes/emulsion/)

## Frequently Asked Questions

* You can contact bugs and ask questions in the following channels
	* [Docs](https://www.tenman.info/wp3/emulsion/category/docs/)
	* [FAQ](https://www.tenman.info/wp3/emulsion/category/faq/)
	* [Support Forum](https://wordpress.org/support/theme/emulsion/)

## Screenshots

* emulsion/screenshot.png

## Copyright

### Images

screenshot.png
background-image.png
emulsion-addons.png
bloging.png
daybreak.png
default.png
grid.png
midnight.png
stream.png

* Above images License
	* Copyright: Copyright (c) 2010-2017, Tenman
	* License: GNU General Public License v2 or later
        * License URI: http://www.gnu.org/licenses/gpl-2.0.html

### SVG

'behance',  'codepen',  'deviantart',  'digg',  'dockerhub',  'dribbble',  'dropbox',
'facebook',  'flickr',  'foursquare',  'google-plus',  'github',  'instagram',
'linkedin',  'envelope-o',  'medium',  'pinterest-p',  'periscope',  'get-pocket',
'reddit-alien',  'skype',  'skype',  'slideshare',  'snapchat-ghost',  'soundcloud',
'spotify',  'stumbleupon',  'tumblr',  'twitch',  'twitter',  'vimeo',  'vine',
'vk',  'wordpress',  'wordpress',  'yelp',  'youtube',

* Above SVG symbol License
        Twentyseventeen theme symbols
        https://wordpress.org/
	License: GNU General Public License v2 or later
        License URI: http://www.gnu.org/licenses/gpl-2.0.html

'default',  'icon-expand',  'enlarge',  'shrink',  'search',  'cross',  'lock',  'play',  'pause',
'icon-behance',  'phone',  'email',  'rss',  'embed',  'bell',  'location',  'pdf',  'zip',  'html5',
'category',  'tag',  'clock',  'contrast',  'home',  'bookmark',  'quote',  'edit',  'web',  'human',
'new-tab',  'checkbox_checked',  'checkbox',  'radio_checked',  'radio',  'notice',  'info',  'block',

* Other SVG symbol License
	* Copyright: Copyright (c) 2019, Tenman
	* License: GNU General Public License v2.0
	* License URI: http://www.gnu.org/licenses/gpl-2.0.html

### Plugin Installer

        * This theme using  TGM-Plugin-Activation license below
        * @package   TGM-Plugin-Activation
        * @version   2.6.1 for parent theme emulsion for publication on WordPress.org
        * @link      http://tgmpluginactivation.com/
        * @author    Thomas Griffin, Gary Jones, Juliette Reinders Folmer
        * @copyright Copyright (c) 2011, Thomas Griffin
        * @license   GPL-2.0+

### Plugins

* Breadcrumb NavXT
	* Contributors: mtekk, hakre
	* License: GPLv2 or later
* AMP
	* Contributors: Google, XWP, Automatic, Weston Ruter, albertomedina, Alain Schlesser, Pascal Birchler, Pierre Gordon, Ryan Kienstra
	* License: GPLv2 or later
* PWA
	* Contributors: Google, XWP, Weston Ruter, albertomedina
	* License: GPLv2 or later

### js

* InstantClick 3.1.0 | (C) 2014 Alexandre Dieulot | http://instantclick.io/license
	* License: MIT
* Lazy Load - JavaScript plugin for lazy loading images
	* https://appelsiini.net/projects/lazyload
	* License: MIT
* toc - jQuery Table of Contents Plugin
        * v0.3.2
        * http://projects.jga.me/toc/
        * copyright Greg Allen 2014
        * MIT License
* smooth-scroller - Javascript lib to handle smooth scrolling
        * v0.1.2
        * https://github.com/firstandthird/smooth-scroller
        * copyright First+Third 2014
        * MIT License

### CSS

* normalize.css, Copyright 2012-2016 Nicolas Gallagher and Jonathan Neal
	* License: MIT
	* Source: https://necolas.github.io/normalize.css/
* css3patterns
	* License: MIT
        * Source: https://github.com/LeaVerou/css3patterns

## Changelog
###  august 29 2022
		* 2.4.8
        * https://github.com/tenman/emulsion/releases
###  august 16 2022
		* 2.4.7
        * https://github.com/tenman/emulsion/releases
###  august 8 2022
		* 2.4.6
        * https://github.com/tenman/emulsion/releases
###  july 29 2022
		* 2.4.5
        * https://github.com/tenman/emulsion/releases
###  july 14 2022
		* 2.4.3
        * https://github.com/tenman/emulsion/releases
###  july 6 2022
		* 2.4.2
        * https://github.com/tenman/emulsion/releases
###  july 4 2022
		* 2.4.0
        * https://github.com/tenman/emulsion/releases
###  june 23 2022
		* 2.3.9
        * https://github.com/tenman/emulsion/releases
###  june 16 2022
		* 2.3.8
        * https://github.com/tenman/emulsion/releases
###  june 9 2022
		* 2.3.7
        * https://github.com/tenman/emulsion/releases
###  june 7 2022
		* 2.3.6
        * https://github.com/tenman/emulsion/releases
###  may 25 2022
		* 2.3.5
        * https://github.com/tenman/emulsion/releases
###  may 11 2022
		* 2.3.4
        * https://github.com/tenman/emulsion/releases
###  may 9 2022
		* 2.3.3
        * https://github.com/tenman/emulsion/releases
###  april 25 2022
		* 2.3.2
        * https://github.com/tenman/emulsion/releases
###  april 22 2022
		* 2.3.1
        * https://github.com/tenman/emulsion/releases
###  april 20 2022
		* 2.3.0
        * https://github.com/tenman/emulsion/releases
###  march 22 2022
		* 2.2.9
        * https://github.com/tenman/emulsion/releases
###  march 11 2022
		* 2.2.8
        * https://github.com/tenman/emulsion/releases
###  march 10 2022
		* 2.2.7
        * https://github.com/tenman/emulsion/releases
###  february 25 2022
		* 2.2.6
        * https://github.com/tenman/emulsion/releases
###  february 22 2022
		* 2.2.5
        * https://github.com/tenman/emulsion/releases
###  february 14 2022
		* 2.2.4
        * https://github.com/tenman/emulsion/releases
###  february 08 2022
		* 2.2.3
        * https://github.com/tenman/emulsion/releases
### January 27 2022
		* 2.2.2
        * https://github.com/tenman/emulsion/releases
### January 25 2022
		* 2.2.1
        * https://github.com/tenman/emulsion/releases
### January 24 2022
		* 2.2.0
        * https://github.com/tenman/emulsion/releases
### January 18 2022
		* 2.1.9
        * https://github.com/tenman/emulsion/releases
### January 6 2022
		* 2.1.8
        * https://github.com/tenman/emulsion/releases
### December 28 2021
		* 2.1.7
        * https://github.com/tenman/emulsion/releases
### December 20 2021
		* 2.1.6
        * https://github.com/tenman/emulsion/releases
### December 10 2021
		* 2.1.5
        * https://github.com/tenman/emulsion/releases
### November 30 2021
		* 2.1.4
        * https://github.com/tenman/emulsion/releases
### November 29 2021
		* 2.1.3
        * https://github.com/tenman/emulsion/releases
### November 17 2021
		* 2.1.2
        * https://github.com/tenman/emulsion/releases
### November 11 2021
		* 2.1.1
        * https://github.com/tenman/emulsion/releases
### November 1 2021
		* 2.1.0
        * https://github.com/tenman/emulsion/releases
### October 26 2021
		* 2.0.9
        * https://github.com/tenman/emulsion/releases
### October 25 2021
		* 2.0.8
        * https://github.com/tenman/emulsion/releases
### October 12 2021
		* 2.0.7
        * https://github.com/tenman/emulsion/releases
### September 17 2021
		* 2.0.6
        * https://github.com/tenman/emulsion/releases
### august 30 2021
		* 2.0.5
        * https://github.com/tenman/emulsion/releases
### august 6 2021
		* 2.0.3
        * https://github.com/tenman/emulsion/releases
### july 21 2021
		* 2.0.2
        * https://github.com/tenman/emulsion/releases
### july 12 2021
		* 2.0.0
        * https://github.com/tenman/emulsion/releases
### may 25 2021
		* 1.9.5
        * https://github.com/tenman/emulsion/releases
### may 17 2021
		* 1.9.4
        * https://github.com/tenman/emulsion/releases
### may 7 2021
		* 1.9.3
        * https://github.com/tenman/emulsion/releases
### april 27 2021
		* 1.9.2
        * https://github.com/tenman/emulsion/releases
### april 21 2021
		* 1.9.1
        * https://github.com/tenman/emulsion/releases
### april 8 2021
		* 1.9.0
        * https://github.com/tenman/emulsion/releases
### april 1 2021
		* 1.8.2
        * https://github.com/tenman/emulsion/releases
### march 29 2021
		* 1.8.1
        * https://github.com/tenman/emulsion/releases
### march 29 2021
		* 1.8.0
        * https://github.com/tenman/emulsion/releases
### march 24 2021
		* 1.7.9
        * https://github.com/tenman/emulsion/releases
### march 9 2021
		* 1.7.8
        * https://github.com/tenman/emulsion/releases
### february 25 2021
		* 1.7.7
        * https://github.com/tenman/emulsion/releases
### february 25 2021
		* 1.7.6
        * https://github.com/tenman/emulsion/releases
### february 19 2021
		* 1.7.5
        * https://github.com/tenman/emulsion/releases
### february 8 2021
		* 1.7.4
        * https://github.com/tenman/emulsion/releases
### January 29 2021
		* 1.7.3
        * https://github.com/tenman/emulsion/releases
### January 16 2021
		* 1.7.2
        * https://github.com/tenman/emulsion/releases
### december 27 2020
		* 1.7.1
        * https://github.com/tenman/emulsion/releases
### december 16 2020
		* 1.6.9
        * https://github.com/tenman/emulsion/releases
### december 8 2020
		* 1.6.8
        * https://github.com/tenman/emulsion/releases
### december 1 2020
		* 1.6.7
        * https://github.com/tenman/emulsion/releases
### december 1 2020
		* 1.6.6
        * https://github.com/tenman/emulsion/releases
### november 22 2020
		* 1.6.5
        * https://github.com/tenman/emulsion/releases
### november 20 2020
		* 1.6.4
        * https://github.com/tenman/emulsion/releases
### november 20 2020
		* 1.6.3
        * https://github.com/tenman/emulsion/releases
### october 30 2020
		* 1.6.2
        * https://github.com/tenman/emulsion/releases
### october 29 2020
		* 1.6.1
        * https://github.com/tenman/emulsion/releases
### october 13 2020
		* 1.6.0
        * https://github.com/tenman/emulsion/releases
### october 8 2020
		* 1.5.9
        * https://github.com/tenman/emulsion/releases
### october 2 2020
		* 1.5.8
        * https://github.com/tenman/emulsion/releases
### october 1 2020
		* 1.5.7
        * https://github.com/tenman/emulsion/releases
### september 30 2020
		* 1.5.6
        * https://github.com/tenman/emulsion/releases
### september 28 2020
		* 1.5.5
        * https://github.com/tenman/emulsion/releases
### september 16 2020
		* 1.5.4
        * https://github.com/tenman/emulsion/releases
### august 31 2020
		* 1.5.2
        * https://github.com/tenman/emulsion/releases
### august 20 2020
		* 1.5.1
        * https://github.com/tenman/emulsion/releases
### august 11 2020
		* 1.5.0
        * https://github.com/tenman/emulsion/releases
### august 3 2020
		* 1.4.5
        * https://github.com/tenman/emulsion/releases
### July 22 2020
		* 1.4.4
        * https://github.com/tenman/emulsion/releases
### July 13 2020
		* 1.4.3
        * https://github.com/tenman/emulsion/releases
### July 1 2020
		* 1.4.2
        * https://github.com/tenman/emulsion/releases
### June 13 2020
		* 1.4.1
        * https://github.com/tenman/emulsion/releases
### June 13 2020
		* 1.4.0
        * https://github.com/tenman/emulsion/releases
### June 12 2020
### June 12 2020
		* 1.3.9
        * https://github.com/tenman/emulsion/releases
### June 12 2020
		* 1.3.8
        * https://github.com/tenman/emulsion/releases
### June 6 2020
		* 1.3.7
        * https://github.com/tenman/emulsion/releases
### June 1 2020
		* 1.3.6
        * https://github.com/tenman/emulsion/releases
### May 23 2020
		* 1.3.5
        * https://github.com/tenman/emulsion/releases
### May 15 2020
		* 1.3.4
        * https://github.com/tenman/emulsion/releases
### May 7 2020
		* 1.3.3
        * https://github.com/tenman/emulsion/releases
### May 7 2020
		* 1.3.2
        * https://github.com/tenman/emulsion/releases
### May 4 2020
		* 1.3.1
        * https://github.com/tenman/emulsion/releases
### May 2 2020
		* 1.3.0
        * https://github.com/tenman/emulsion/releases
### May 1 2020
		* 1.2.9
        * https://github.com/tenman/emulsion/releases
### April 27 2020
		* 1.2.8
        * https://github.com/tenman/emulsion/releases
### April 23 2020
		* 1.2.7
        * https://github.com/tenman/emulsion/releases
### April 16 2020
		* 1.2.6
        * https://github.com/tenman/emulsion/releases
### April 15 2020
		* 1.2.5
        * https://github.com/tenman/emulsion/releases
### April 15 2020
		* 1.2.4
        * https://github.com/tenman/emulsion/releases
### April 8 2020
		* 1.2.3
        * https://github.com/tenman/emulsion/releases
### April 8 2020
		* 1.2.2
        * https://github.com/tenman/emulsion/releases
### April 8 2020
		* 1.2.1
        * https://github.com/tenman/emulsion/releases
### April 6 2020
		* 1.1.9
        * https://github.com/tenman/emulsion/releases
### April 1 2020
		* 1.1.8
        * https://github.com/tenman/emulsion/releases
### March 23 2020
		* 1.1.7
        * https://github.com/tenman/emulsion/releases
### february 20 2020
		* 1.1.5
        * https://github.com/tenman/emulsion/releases
### february 14 2020
		* 1.1.2
        * https://github.com/tenman/emulsion/releases
### february 6 2020
		* 1.1.1
        * https://github.com/tenman/emulsion/releases
### January 28 2020
		* 1.1.0
        * https://github.com/tenman/emulsion/releases
### January 27 2020
		* 1.0.9
        * https://github.com/tenman/emulsion/releases
### January 14 2020
		* 1.0.8
        * https://github.com/tenman/emulsion/releases
### January 8 2020
		* 1.0.7
        * https://github.com/tenman/emulsion/releases
### January 7 2020
		* 1.0.6
        * https://github.com/tenman/emulsion/releases
### december 30 2019
		* 1.0.5
        * https://github.com/tenman/emulsion/releases
### december 30 2019
		* 1.0.4
        * https://github.com/tenman/emulsion/releases
### december 30 2019
		* 1.0.3
        * https://github.com/tenman/emulsion/releases
### december 30 2019
		* 1.0.2
        * https://github.com/tenman/emulsion/releases
### december 29 2019
		* 1.0.1
        * https://github.com/tenman/emulsion/releases
### december 23 2019
		* 1.0.0
        * https://github.com/tenman/emulsion/releases
### december 20 2019
		* 0.9.9
        * https://github.com/tenman/emulsion/releases
### nobember 18 2019
		* 0.9.8
        * https://github.com/tenman/emulsion/releases
### nobember 10 2019
		* 0.9.7
        * https://github.com/tenman/emulsion/releases
### august 15 2019
        * 0.9.6
        * https://github.com/tenman/emulsion/releases

### august 6 2019
        * 0.9.4
        * https://github.com/tenman/emulsion/releases
### august 1 2019
        * 0.9.0
        * Initial release
## Upgrade Notice

### 0.9.0
Read the [release announcement post](https://www.tenman.info/wp3/emulsion/category/releases/)


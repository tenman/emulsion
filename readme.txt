# Emulsion
 
Contributors: nobita
Requires at least: WordPress 5.0
Tested up to: WordPress 5.3.2
Requires PHP: 5.6
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: one-column, two-columns, left-sidebar, right-sidebar, custom-colors, custom-header, custom-background, custom-menu, editor-style, theme-options, threaded-comments, sticky-post, translation-ready, post-formats, featured-images, full-width-template, grid-layout, flexible-header, custom-logo, featured-image-header, footer-widgets

## Description

block editor, classic editor both supports. Conventional, Image Media New Block Type Image Both media can be displayed correctly.
Theme can stop at each theme style page for page builder users. Customizer can easily view changes with automatic preview redirection.
Theme is designed with the goal of minimizing user frustration.

### Theme-specific presentation
* Moduled presentation

The theme consists of the following modules:
'enqueue','primary_menu','search_drawer','search_keyword_highlight','sidebar','sidebar_page','footer','footer_page',
'alignfull','title_in_page_header','toc','header','background','custom-logo','social-link-menu',
'footer-svg','excerpt','relate_posts','tooltip','amp','entry_content_html_cleaner','block_sectionize','background_css_pattern',
'meta_description','TGMPA',

A theme can enable or disable these features on a per-template basis.

Since WordPress 5.0, CSS has been integrated into the core.
Prior to that, CSS had the theme of defining presentations.
Due to this change, the CSS settings for presentations that have traditionally become more complex and useless.
For example, the social link menu was a theme function, but if you use the social menu in the block editor, it may not be necessary anymore.
This is why I tried modularization.

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

* Back END and Front END CSS relation
	* Customizer CSS settings are communicated to the front end, editor style, classic editor using CSS variables.
	* SCSS PHP compiler (wp-scss plugin) can be used to easily compile SCSS on the server.( wp-scss has not been updated for a long time,Whether to use it is at your own discretion )
        * @see https://www.tenman.info/wp3/emulsion/en/2020/03/23/scss-%e3%83%95%e3%82%a1%e3%82%a4%e3%83%ab%e3%81%ae%e7%b7%a8%e9%9b%86%e3%82%92%e8%a1%8c%e3%81%86%e5%a0%b4%e5%90%88%e3%81%ab/
	* For each post or page, you can completely stop the CSS and script of the theme. This feature may be useful when using a page builder.
	* In browsers such as IE11 that do not support CSS varialbes, simple display that supports only readability is performed.

* Page Spead ( apply front end and not logged in )
	* In order to harmonize the Rich Media created by the block editor with the Respose of the site, there are lazyload of images and pre-during functions at link hover.
	* If there is a similar function in a plug-in, etc., there is a possibility of conflict. You can stop these functions in the customizer.

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
### March 23 2020
		* 1.1.6
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


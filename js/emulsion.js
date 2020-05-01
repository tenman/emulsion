jQuery(function ($) {
    "use strict";
    $("body").removeClass('noscript');
    // element wrap
    /**
     * the table element can not be controlled with max-width,
     *
     * without WordPress 5.3 figure.wp-block-table. table elements wrapping with <div class="emulsion-table-wrapper"></div>
     * emulsion-table-wrapper bais set CSS overflow-x auto
     *
     * If the table width exceeds the size of the content area, display scroll bars to maintain readability.
     * If the table width is smaller than the content area, the stretch class displays the content width.
     *
     */
    jQuery(".gist table,.sidebar-widget-area table, .footer-widget-area table").each(function (i) {
        jQuery(this).wrap('<div class="emulsion-table-wrapper"></div>');
        var parent_width = $(this).parent('.emulsion-table-wrapper').width();
        var table_width = $(this).width();
        if (parent_width > table_width) {
            $(this).addClass('stretch');
        }
    });
    jQuery("table.wp-block-table, .entry-content > table").not('shrink').each(function (i) {
        /**
         * WordPress 5.0 old gutenberg block
         */
        jQuery(this).wrap('<figure class="wp-block-table exception"></figure>');
        var parent_width = $(this).parent('.wp-block-table').width();
        var table_width = $(this).width();
        if (parent_width > table_width) {
            $(this).addClass('stretch');
        }
    });
    jQuery("table.alignleft").each(function (i) {
        jQuery(this).parent().addClass('alignleft');
        jQuery(this).removeClass('alignleft');
    });
    jQuery("table.alignright").each(function (i) {
        jQuery(this).parent().addClass('alignright');
        jQuery(this).removeClass('alignright');
    });
    jQuery("table.aligncenter").each(function (i) {
        jQuery(this).parent().addClass('aligncenter');
        jQuery(this).removeClass('aligncenter');
    });
    jQuery("table.alignfull").each(function (i) {
        jQuery(this).parent().addClass('alignfull');
        jQuery(this).removeClass('alignfull');
    });
    jQuery("table.alignwide").each(function (i) {
        jQuery(this).parent().addClass('alignwide');
        jQuery(this).removeClass('alignwide');
    });
    /**
     * wp_block wrap
     * WordPress block is wrapping with <section class="sectionized-[block name]"></section>
     * and if possible add unique id for each block can do indivisual CSS design
     * Note:We can not guarantee that id is a completely unique value. After editing, the id value also changes.
     */
    if (true == emulsion_script_vars.block_sectionize) {
        $('.entry-content > [class|="wp-block"]').not('.alignleft, .alignright, .wp-block-image,.wp-block-cover, \n\
            .wp-block-embed, .wp-block-group, .wp-block-table, .wp-block-spacer, .wp-block-button, .wp-block-separator, .wp-block-navigation').wrap(function () {
            var classes = $(this).attr('class').match(/wp-block-\S+/);
            var brightness_class = '';
            var section_title = '';
            if ('wp-block-columns' == classes) {
                brightness_class = 'columns-' + emulsion_script_vars.block_columns_class;
                section_title = emulsion_script_vars.block_columns_class_title;
            }
            if ('wp-block-gallery' == classes) {
                brightness_class = 'gallery-' + emulsion_script_vars.block_gallery_class;
                section_title = emulsion_script_vars.block_gallery_class_title;
            }
            if ('wp-block-media-text' == classes) {
                brightness_class = 'media-text-' + emulsion_script_vars.block_media_text_class;
                section_title = emulsion_script_vars.block_media_text_class_title;
            }
            if ('wp-block-pullquote' == classes || 'wp-block-quote' == classes) {
                section_title = emulsion_script_vars.block_quote_class_title;
            }
            if ('wp-block-buttons' == classes) {
                section_title = emulsion_script_vars.block_buttons_class_title;
            }
            $(this).wrap('<section class="sectionized-' + classes + ' ' + brightness_class + '" ></section>');

            var string = $(this).html().slice(0, 4);
            var id = $(this).html().length;
            id = classes + '-' + parseInt(emulsion_script_vars.post_id) + '-' + parseInt(id);
            if ('is_preview' !== emulsion_script_vars.is_customize_preview) {
                
                if ( section_title ) {
                    $(this).parent().addClass(id).prepend('<h2 class="screen-reader-text">' + section_title + '</h2>');
                } else {
                    $(this).parent().addClass(id);
                }
            }
        });
    }
    /**
     * wp-block unwrap
     */
    $('.entry-content .wp-block-image figure').each(function () {
        if ($(this).hasClass('alignleft')) {
            $(this).removeClass('alignleft');
            $(this).removeAttr('style');
            $(this).parent().addClass('alignleft');
        }
        if ($(this).hasClass('alignright')) {
            $(this).removeClass('alignright');
            $(this).removeAttr('style');
            $(this).parent().addClass('alignright');
        }
        if ($(this).hasClass('aligncenter')) {
            $(this).removeClass('aligncenter');
            $(this).parent().addClass('aligncenter');
        }
        if ($(this).hasClass('is-resized')) {
            $(this).removeClass('is-resized');
            $(this).parent().addClass('is-resized');
        }
    });
});
jQuery(function ($) {
    /**
     * Function for opening / closing the child menu of wp_nav_menu ()
     */
    $('.wp-nav-menu .menu-item-has-children > a').each(function (i) {
        var text = $(this).parent().attr('id');
        var text_id = text + '-opener';
        if ('undefined' !== text_id) {
            text_id = 'primary-opener-' + i;
        }
        $(this).siblings('.nav-menu-child-opener, .nav-menu-child-opener-label').remove(); //for browser back
        $(this).parents('nav').addClass('has-chckbox-control');
        $(this).parents('nav').attr('tabindex', 0);
        $(this).after('<input id="' + text_id + '" type="checkbox" class="nav-menu-child-opener" /><label tabindex="0" class="nav-menu-child-opener-label" for="' + text_id + '"></label>');
    });
    // Sidebar Widget
    $('.widget_nav_menu .menu-item-has-children > a').each(function (i) {
        var text = $(this).parent().attr('id');
        var text_id = text + '-opener';
        if ('undefined' !== text_id) {
            text_id = 'widget-opener-' + i;
        }
        $(this).siblings('.nav-menu-child-opener, .nav-menu-child-opener-label').remove(); //for browser back
        $(this).parents('div').addClass('has-chckbox-control');
        $(this).after('<input id="' + text_id + '" type="checkbox" class="nav-menu-child-opener" /><label tabindex="0" class="nav-menu-child-opener-label" for="' + text_id + '"></label>');
    });
});

jQuery(function ($) {
    /**
     * Keyboard navigation for accessibility
     */
    $('.has-chckbox-control .nav-menu-child-opener-label').focus(function () {
        var focus = $(this);
        $(window).keyup(function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 9) {
                focus.siblings().prop("checked", true);
                focus.parents('.wp-nav-menu > li').prev().find('.nav-menu-child-opener').prop("checked", false);
            }
        });
    });
    $('.wp-nav-menu.primary a').focus(function () {
        var focus = $(this);
        $(window).keyup(function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 9) {
                focus.parents('.wp-nav-menu > li').prev().find('.nav-menu-child-opener').prop("checked", false);
            }
        });
    });
    $('.wp-nav-menu.primary a').blur(function () {
        var unfocus = $(this);
        $(window).keyup(function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 9) {
                unfocus.parents('.wp-nav-menu > li').find('.nav-menu-child-opener').prop("checked", false);
            }
        });
    });

    //tab navigation when mobile humberger menu

    $('#primary-menu-controll').focusin(function (e) {
        var chk_status = $(this).prop("checked");
        if (chk_status) {
            $(this).prop('checked', false);
        } else {
            $(this).prop('checked', true);
        }
    });
    $('.layout a').focusin(function () {
        // close tab navigation
        $('#primary-menu-controll').prop('checked', false);
    });
    $('.layout,.header-layer').on('click', function () {
        // close Click around the button
        $('#primary-menu-controll').prop('checked', false);
    });
    $('#primary-menu-controll').on('click', function (e) {
        // button click 
        var chk_status = $(this).prop("checked");
        if (chk_status) {
            $(this).prop('checked', false);
        } else {
            $(this).prop('checked', true);
        }
    });
});
jQuery(function ($) {
    "use strict";
    /**
     * We control display of post summary sentence by line instead of number of characters.
     *
     */
    $('.trancate').each(function (index) {
        var rows = $(this).data('rows');
        if (!rows) {
            rows = 3;
        }
        var line_height = parseInt($(this).css('line-height'));
        var box_height = parseInt(Math.ceil(rows * line_height));
        $(this).wrapInner("<span class='multiline-text-overflow'></span>");
        $(this).css({'height': box_height});
        if (parseInt($('.multiline-text-overflow', this).height()) > box_height) {
            $(this).addClass('on-trancate');
            $(this).removeClass('off-trancate');
        }
        if (parseInt($('.multiline-text-overflow', this).height()) < box_height) {
            $(this).addClass('off-trancate');
            $(this).removeClass('on-trancate');
        }
    });
    $('.trancate-heading').each(function (index) {
        /**
         * If the title is long, reduce the font size and display the title as much as possible
         * @type {Number}
         */
        var rows = $(this).data('rows');
        if (!rows) {
            rows = 8;
        }
        var line_height = parseInt($(this).css('line-height'));
        var box_height = parseInt(Math.ceil(rows * line_height));
        $(this).wrapInner("<span class='multiline-text-overflow'></span>");
        if (parseInt($('.multiline-text-overflow', this).height()) < box_height) {
            $(this).addClass('off-trancate');
            $(this).removeClass('on-trancate');
        }
        if (parseInt($('.multiline-text-overflow', this).height()) > box_height) {
            $(this).css("fontSize", '1rem');
            line_height = parseInt($(this).css('line-height'));
            box_height = parseInt(Math.ceil(rows * line_height));
            if (parseInt($('.multiline-text-overflow', this).height()) > box_height) {
                $(this).css({'max-height': box_height});
                $(this).addClass('on-trancate');
                $(this).removeClass('off-trancate');
            } else {
                $(this).addClass('off-trancate');
                $(this).removeClass('on-trancate');
            }
        }
        $(this).css({'visibility': 'visible'});
    });
    $('.related-posts .on-trancate > span').each(function (index) {
        var text = $(this).text();
        $(this).attr('title', text);
    });
});
jQuery(function ($) {
    "use strict";
    /**
     * On the archive page, the contents are
     * displayed in full text without page transition.
     *
     * @param {type} sParam
     * @return {emulsionL#166.getUrlParameter.sParameterName|Boolean}
     */
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };
    /**
     * Escape
     */
    function escapeString(val) {
        return $('<div>').text(val).html();
    }

});
jQuery(function ($) {
    "use strict";
    /**
     * To suppress the display of the title tooltip and change the attribute name
     * to the data attribute to enable display control on the CSS.
     */
    $('.sidebar-widget-area a, .footer-widget-area a, .page-wrapper a, .search-drawer a, .header-layer a').not('.social-links-menu a').each(function (index) {
        var text = $(this).attr('title');
        $(this).removeAttr('title');
        $(this).attr('data-title', text);
    });
});
jQuery(function ($) {
    "use strict";
    /**
     * Header Search box filter
     * Filter the list of categories and tags according to the search keyword.
     */

    $(".search-drawer .wp-block-search .wp-block-search__input").on("keyup touchend", function () {
        var value = $(this).val().toLowerCase();
        $(".search-info li ul li").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
jQuery(function ($) {
    "use strict";
    /**
     * Add lnline SVG
     */
    $('[class|="ico"],[class*=" ico-"]').not('svg').each(function (index) {
        var classes = $(this).attr('class');
        var target_class = classes.match(/^.*(ico-\S+).*$/);
        target_class = target_class[1];
        target_class = target_class.replace("ico-", "");

        var icon_classes = emulsion_script_vars.emulsion_accepted_svg_ids;

        if ($.inArray(target_class, icon_classes)) {

            var tag_name = $(this).prop("tagName");

            if ('UL' == tag_name) {
                $(this).addClass('list-style-none').children('li').prepend('<svg class="icon ico-' + target_class + '" aria-hidden="true" style="width:1em;height:1em" role="img"><use xlink:href="#' + target_class + '" /></svg>');
            } else if ($(this).hasClass('wp-block-navigation')) {
                $(this).children('ul').addClass('list-style-none').children('li').prepend('<svg class="icon ico-' + target_class + '" aria-hidden="true" style="width:1em;height:1em" role="img"><use xlink:href="#' + target_class + '" /></svg>');
            } else {
                $(this).prepend('<svg class="icon ico-' + target_class + '" aria-hidden="true" style="width:1em;height:1em" role="img"><use xlink:href="#' + target_class + '" /></svg>');
            }
        }

    });
});
jQuery(function ($) {

    /**
     * Repaire block editor WordPress 5.3.1 + gutenberg 7.1
     * block latest posts ( full content ) inline code decoded
     * Since tags such as script are removed, the code cannot be reproduced accurately,
     * but it is better than being decoded
     */

    $('.wp-block-latest-posts__post-full-content code').each(function (index) {
        var html = $(this).html();

        $(this).text(html);
    });
});

jQuery(function ($) {
    "use strict";
    /**
     * Clicked Search icon in header add Class .is-searching-progress in header element
     */
    $('.drawer-wrapper input[type="checkbox"]').change(function () {
        if ($(this).attr("checked")) {
            $(this).parents('header').addClass('is-searching-progress');
        } else {
            $(this).parents('header').removeClass('is-searching-progress');
        }
    });
});
jQuery(function ($) {
    "use strict";
    /**
     * add external class for external links
     * data-no-instant  relate instantclick.js
     */
    if('enable' == emulsion_script_vars.instantclick_support){
        
        $('a[href^=http]').not('[href^="' + emulsion_script_vars.home_url + '"]').addClass('external').attr('data-no-instant', 'data-no-instant');
        /**
         * instantcclick exclude links
         */
        //.nav-links a,
        $('#wpadminbar a,.editor a, .post-edit-link,  a[href*="wp-admin"], a[href$="/amp"], a[href*="#"]').attr('data-no-instant', 'data-no-instant');
        $('a[href$="action=register"], a[href*="wp-login"]').attr('data-no-instant', 'data-no-instant');
    }
    /**
     * add required attribute on search form
     * Searching is a load-intensive process. If you do not enter it in the text field, no processing will be done
     */
    $('.search-form [type="search"]').attr('required', 'required');
    /**
     * Anchor Type
     */
    $("a:not(:has(*))").addClass('has-text');
    $('img').parent('a').addClass('has-image');
});
jQuery(function ($) {
    "use strict";
    /**
     * Detect window scroll
     * add class on-scroll
     */
    $(window).scroll(function () {
        var ua = navigator.userAgent;
        var scrolle_y = $(window).scrollTop();
        var offset_primary_menu = $('body > .header-layer').height();
        if (parseInt(scrolle_y) < parseInt(offset_primary_menu) || parseInt(scrolle_y) < 20) {
            $('body').removeClass('on-scroll');
        }
        if (parseInt(scrolle_y) > parseInt(offset_primary_menu)) {
            $('body').addClass('on-scroll');
        }
    });
});
jQuery(function ($) {
    "use strict";
    var userAgent = window.navigator.userAgent.toLowerCase();
    if (userAgent.match(/msie/i) || (userAgent.match(/Trident/i) && userAgent.match(/rv:11/i))) {
        $('.alignfull').each(function (index) {
            $(this).removeClass('alignfull');
        });
    }    
});
jQuery(function ($) {
    "use strict";
    var widget_width = $('.sidebar-widget-area').width();
    widget_width = parseInt(widget_width);
    if (widget_width > 640) {
        $('.sidebar-widget-area').addClass('is-wide-widget-area');
    } else {
        $('.sidebar-widget-area').removeClass('is-wide-widget-area');
    }
});
jQuery(function ($) {
    "use strict";
    /**
     * TRANSLATE
     */
    /**
     * Add screen reader text when entry ttle is blank
     */
    "use strict";
    $('.entry-title a:empty, .relate-posts a:empty').prepend('<span class="screen-reader-text">' + emulsion_script_vars.i18n_blank_entry_title + '</span><span>...</span>');
});
jQuery(function ($) {
    /**
     * alignfull helper
     */
    "use strict";
    function emulsion_resizes() {
        $('.shortcode-wrapper').each(function (i) {
            if ($(this).children().hasClass('alignfull')) {
                $(this).children().removeClass('alignfull')
                $(this).addClass('alignfull');
            }
            if ($(this).children().hasClass('alignwide')) {
                $(this).children().removeClass('alignwide')
                $(this).addClass('alignwide');
            }
        });
        $(".emulsion-has-sidebar.enable-alignfull .entry-content > .alignfull").not('.wp-block-cover').each(function (i) {
            var article_width = $(this).parents('article').width();
            var parent_width = $(this).parents('.entry-content').width();
            var negative_margin = parseInt(article_width) - parseInt(parent_width);
            negative_margin = negative_margin / -2;
            $(this).css({'width': article_width, 'left': negative_margin, 'visibility': 'visible'});
        });
        $(".emulsion-no-sidebar.enable-alignfull .entry-content > .alignfull").not('.wp-block-cover').each(function (i) {
            var article_width = $(this).parents('article').width();
            var parent_width = $(this).parents('.entry-content').width();
            var negative_margin = parseInt(article_width) - parseInt(parent_width);
            var main_width = $(this).parents('main').width();
            negative_margin = parseInt(main_width) - parseInt(article_width) + parseInt(negative_margin);
            negative_margin = negative_margin / -2;
            $(this).css({'width': article_width, 'left': negative_margin, 'position': 'relative', 'visibility': 'visible'});
        });
        $(".emulsion-has-sidebar.enable-alignfull .entry-content > .emulsion-full").not('.wp-block-cover').each(function (i) {
            var article_width = $(this).parents('article').width();
            var parent_width = $(this).parents('.entry-content').width();
            var negative_margin = parseInt(article_width) - parseInt(parent_width);
            negative_margin = negative_margin / -2;
            $(this).css({'width': article_width, 'left': negative_margin, 'visibility': 'visible'});
        });
        $(".emulsion-no-sidebar.enable-alignfull .entry-content > .emulsion-full").each(function (i) {
            var article_width = $(this).parents('article').width();
            var parent_width = $(this).parents('.entry-content').width();
            var negative_margin = parseInt(article_width) - parseInt(parent_width);
            var main_width = $(this).parents('main').width();
            negative_margin = parseInt(main_width) - parseInt(article_width) + parseInt(negative_margin);
            negative_margin = negative_margin / -2;
            $(this).css({'width': article_width, 'left': negative_margin, 'position': 'relative', 'visibility': 'visible'});
        });
        $('.emulsion-has-sidebar.enable-alignfull .entry-content > .wp-block-cover.alignfull, .emulsion-has-sidebar.enable-alignfull [class|="sectionized"]').each(function (i) {
            var sidebar_width = $('aside.sidebar-widget-area').width();
            var article_width = $(this).parents('article').width();
            var parent_width = $(this).parents('.entry-content').width();
            var negative_margin = parseInt(article_width) - parseInt(parent_width);
            var negative_margin = negative_margin / -2;
            $(this).css({'width': article_width, 'left': negative_margin, 'position': 'relative', 'display': 'flex', 'visibility': 'visible'});
        });
        /**
         * Detect mobile devices.
         * For example, it is used to switch display of the child menu of the primary menu.
         */
        var ua = navigator.userAgent;
        $('body').removeClass('agent-mobile-phone agent-tablet');
        var emulsion_window_width = parseInt(jQuery(window).width());
        var break_point = parseInt(emulsion_script_vars.content_width) + parseInt(emulsion_script_vars.content_gap) * 2;

        if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
            $('body').addClass('agent-mobile-phone');
            //wp_nav_menu() change from horizontal menu to vertical menu
            $('.primary').attr('data-direction', 'vertical');
        } else if (ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0) {
            $('body').addClass('agent-tablet');
            if (emulsion_window_width < break_point) {
                $('.primary').attr('data-direction', 'vertical');
            }
            if (emulsion_window_width > break_point) {
                $('.primary').attr('data-direction', 'horizontal');
            }
        } else {
            if (emulsion_window_width < break_point) {
                $('.primary').attr('data-direction', 'vertical');
            }
            if (emulsion_window_width > break_point) {
                $('.primary').attr('data-direction', 'horizontal');
            }
        }
    }
    $(window).on("resize", function (e) {
        emulsion_resizes();
    });
    emulsion_resizes();
});
jQuery(function ($) {
    "use strict";
     if ('is_checked' == localStorage.getItem('toc-toggle') ) {
        $("#toc-toggle").prop("checked", true);
    }
    $("#toc-toggle").change(function () {
        var is_checked = this.checked ? 'is_checked' : 'no_checked';
        localStorage.setItem('toc-toggle', is_checked);
    });
});
jQuery(function ($) {
    /**
     * singular title scroll
     * @type {type}
     */
    var scroll_link = $('.emulsion-scroll');
    scroll_link.click(function (e) {
        e.preventDefault();
        $('body,html').animate({
            scrollTop: $(this.hash).offset().top
        }, 500);
    });
    /**
     * hash scroll
     *
     */
    $('a[href^="#"]').click(function (e) {
        e.preventDefault();
        if ($('body').hasClass('logged-in')) {
            $('html, body').animate({
                scrollTop: $(this.hash).offset().top - 120
            }, 500);
        } else {
            $('html, body').animate({
                scrollTop: $(this.hash).offset().top - 100
            }, 500);
        }
        return false;
    });
    /**
     * scroll top button
     * 
     * 
     *
     */

    $('body').not('.attachment').append('<span id="scroll-top" class="scroll-button-top skin-button" title="' + emulsion_script_vars.go_to_top_label + '"><span>Top</span></span>');

    $('#scroll-top').click(function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 500);
    });
});
jQuery(function ($) {
    /**
     * Highlight related links when hovering category links
     */
    $('.cat-item a').hover(function () {
        var link = $(this).parent().attr('class').replace('cat-item', '');
        link = link.replace(' ', '');
        $(this).parents('body').addClass('hilight-' + link);
    }, function () {
        var link = $(this).parent().attr('class').replace('cat-item', '');
        link = link.replace(' ', '');
        $(this).parents('body').removeClass('hilight-' + link);
    });
});
jQuery(function ($) {
    /**
     * detect if there is a link to the current page
     */
    var request_url = window.location.href;
    $("a").each(function (i) {
        var link_url = $(this).attr('href');
        if (request_url == link_url) {
            $(this).parent('li').addClass('current-page');
        }
    });
});
jQuery(function ($) {
    /**
     * Oembed
     */
    $('.wp-block-embed__wrapper').children('.wp-block-embed__wrapper').removeClass('wp-block-embed__wrapper');
    $(".wp-block-embed-wordpress iframe").load(function (i) {
        var height = $(this).attr('height');
        $(this).parents('.wp-block-embed__wrapper').css({'height': height});
    });
});

jQuery(function ($) {
    /**
     * sidebar_position
     */
    if ('left' == emulsion_script_vars.sidebar_position) {
        $('.side-right,.side-left,.side-none').removeClass('side-right side-none screen-reader-text').addClass('side-left');
    }
    if ('right' == emulsion_script_vars.sidebar_position) {
        $('.side-right,.side-left,.side-none').removeClass('side-left side-none screen-reader-text').addClass('side-right');
    }
    if ('none' == emulsion_script_vars.sidebar_position) {
        $('.sidebar-widget-area').addClass('screen-reader-text');
    }
});
jQuery(function ($) {
    /**
     * detect paragraph only inline image
     */
    $('.wp-block-column  p > img:only-child').each(function (i) {
        $(this).parent().addClass('has-only-image');
    });
});
jQuery(function ($) {
    /**
     * detect button has background
     */
    $('.wp-block-button a').each(function (i) {
        if ($(this).hasClass('has-background')) {
            $(this).parent().addClass('button-has-background');
        }
    });
});
jQuery(function ($) {
    /**
     * customizer sticky sidebar setting relate class
     */
    if ('disable' == emulsion_script_vars.sticky_sidebar) {
        $('body').addClass('disable-sidebar-sticky');
    }
    if ('enable' == emulsion_script_vars.sticky_sidebar) {
        $('body').addClass('enable-sidebar-sticky');
    }
});
jQuery(function ($) {
    /**
     * contrast check
     */
    if (emulsion_script_vars.force_contrast) {
        $('.entry-content > div:not(.shortcode-wrapper),.entry-content > .shortcode-wrapper > div, .has-background, .entry-content > .has-background:not(.has-text-color)').not('.wp-block-button, .plain').each(function (i) {
            var background_color_rgb = $(this).css("background-color");
            var general_background_color = emulsion_script_vars.background_color;
            if (general_background_color !== background_color_rgb && background_color_rgb.match(/^rgb\(/)) {
                var contrast_color = emulsion_text_color(background_color_rgb);
                if (contrast_color == '#ffffff') {
                    $(this).addClass('emulsion-add-dark-color has-background');
                } else if (contrast_color == '#333333') {
                    $(this).addClass('emulsion-add-light-color has-background');
                }
            }
            if (background_color_rgb.match(/^rgba\(/)) {

                //TODO
                if ($(this).is('[id="bbpress-forums"]')) {
                    $(this).addClass('has-background emulsion-initial-color').css({'position': 'relative', 'z-index': 'auto'}); // chnge 1 to auto 8/27
                    return;
                }
                if (background_color_rgb == "rgba(0, 0, 0, 0)" || 'transparent' == background_color_rgb) {
                    $(this).addClass('emulsion-current-color');
                } else {
                    $(this).addClass('emulsion-initial-color');
                    //.css({'backgroud': background_color_rgb, 'position': 'relative', 'z-index': '-1'}); // chnge 1 to auto 8/27
                    //11/5 change auto to -1
                    //11/25 remove css pullquote
                }
            }
        });
    }
    function emulsion_text_color(newval) {
        var hex = newval;
        if (hex.indexOf('#') === 0) {
            hex = hex.slice(1);
        }
        if (hex.length === 3) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        if (hex.length !== 6) {
            // console.log( hex.length );
            if (hex.match(/^rgb\(/)) {
                var rgb = hex.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
                var r = parseInt(rgb[1]);
                var g = parseInt(rgb[2]);
                var b = parseInt(rgb[3]);
            }
            if (hex.match(/^transparent/)) {
                // todo
                return 'transparent';
            }
        } else {
            var r = parseInt(hex.slice(0, 2), 16);
            var g = parseInt(hex.slice(2, 4), 16);
            var b = parseInt(hex.slice(4, 6), 16);
        }
        var result = (r * 0.299 + g * 0.587 + b * 0.114) > 186 ? '#333333' : '#ffffff';
        return result;
    }
});
jQuery(function ($) {
    /**
     * Stop alignwide support if browser too old
     */
    var userAgent = window.navigator.userAgent.toLowerCase();
    if (userAgent.match(/Trident/i) && userAgent.match(/rv:11/i)) {
        $('body').removeClass('enable-alignfull');
        $('body').removeClass('enable-sidebar-sticky');
    }
});
jQuery(function ($) {
    /**
     * detect IE,EDGE browser
     */
    var userAgent = window.navigator.userAgent.toLowerCase();
    if (userAgent.match(/Edge\/\d+/i)) {
        jQuery('body').addClass('agent-edge');
    } else if (userAgent.match(/Trident/i) && userAgent.match(/rv:11/i)) {
        jQuery('body').addClass('agent-ie11');
    }
});
jQuery(function ($) {
    /**
     * Display nested list elements like tabs. experimental
     * title depth 0
     * content depth 1
     */
    $('.list-style-tab > li').each(function (i) {
        $(this).attr({
            'tabindex': '0',
            'role': 'tab',
        });
        $(this).parent().attr({
            'tabindex': '0',
            'role': 'tabgroup',
        });
        $(this).parent().addClass('success-js');
    });
    $('.list-style-tab > li')
            .focusin(function (e) {
                var height = Math.round($(this).children().height()) + 36;
                $(this).attr({
                    'style': 'margin-bottom:' + height + 'px',
                    'class': 'active',
                    'aria-selected': 'true',
                });
            })
            .focusout(function (e) {
                $(this).removeAttr('style aria-selected').removeClass('active');
            });
});
jQuery(function ($) {

    $('.cta-layer').each(function (i) {
        $(this).attr({
            'tabindex': '0',
        });

    });
});


jQuery(function ($) {
    /**
     * wp-block-search
     * Request should not be made even if field is blank
     */
    $('.wp-block-search .wp-block-search__input').each(function (i) {
        $(this).attr({
            'required': 'required'
        });
    });
});
jQuery(function ($) {
    /**
     * wp-block-tagcloud
     * If the block class has a tag-cloud-style-flat, remove the style and stop highlighting the text size
     */
    $('.wp-block-tag-cloud.tag-cloud-style-flat a').each(function (i) {
        $(this).removeAttr('style');
    });
});
jQuery(function ($) {
    /**
     * search drawer tab navigation
     * @since 0.98
     */
    $(".drawer-wrapper .icon").focusin(function (e) {
        $('body').addClass("drawer-is-active");
        /**
         * wai-aria
         */
        $(this).parent().next().attr({
            'area-expanded': true,
            'id': 'search-drawer',
        });
        $(this).attr({
            'area-expanded': true,
            'aria-controls': 'search-drawer',
        });
        $('.drawer-wrapper input').prop("checked", true);
    });
    $('.drawer-end').focusin(function (e) {
        $('body').removeClass("drawer-is-active");
        $('.drawer-wrapper input').prop("checked", false);
        /**
         * wai-aria
         */
        $('.drawer-wrapper .icon').attr({
            'area-expanded': false,
            'aria-controls': 'search-drawer',
            'area-hidden': true,
        });
        $('#search-drawer').attr({
            'area-expanded': false,
            'area-hidden': true,
        });
    });
    $('.drawer-is-active .drawer-wrapper .icon').on("click", function (e) {
        $('body').removeClass("drawer-is-active");
        $('.drawer-wrapper input').prop("checked", false);
        /**
         * wai-aria
         */
        $('.drawer-wrapper .icon').attr({
            'area-expanded': false,
            'aria-controls': 'search-drawer',
            'area-hidden': true,
        });
        $('#search-drawer').attr({
            'area-expanded': false,
            'area-hidden': true,
        });
    });
    /**
     * search drawer toggle
     */
    $(".drawer-wrapper .icon").on("click", function (e) {
        $('.drawer-wrapper .icon').removeAttr('area-expanded aria-controls search-drawer area-hidden');
        $('#search-drawer').removeAttr('area-expanded area-hidden');
        $('body').toggleClass("drawer-is-active");
    });
});

jQuery(function ($) {
    /**
     * link add when heading has id
     * for allow user to copy link
     * Only singular page
     */
    $('.is-singular .entry-content h1[id],.is-singular .entry-content h2[id],.is-singular .entry-content h3[id],.is-singular .entry-content h4[id],.is-singular .entry-content h5[id],.is-singular .entry-content h6[id]').each(function (i) {
        var fragment = $(this).attr('id');
        if ($(this).find("a").length == 0) {
            $(this).wrapInner($('<a href="#' + fragment + '"></a>'));
        }
    });
});
jQuery(function ($) {

    /**
     * Add a wrapper block whose diameter is the diagonal length of the block
     */

    $('.badge').each(function (i) {

        var width_raw = $(this).outerWidth();
        var width = Math.pow(width_raw, 2);
        var height_raw = $(this).outerHeight();
        var height = Math.pow(height_raw, 2);
        var diagonal_length = Math.pow(width + height, 1 / 2);
        var class_name = $(this).attr('class');
        var style = $(this).attr('style');
        var image = $(this).find('img');
        if (image.length) {
            $(this).css({'width': width_raw}).addClass('has-image-badge');
            $(image).css({'width': image.width(), 'height': image.width()});
        }
        if (!image.length) {
            $(this).wrap($('<div class="' + class_name + '" style="' + style + '"></div>')).removeClass(class_name).removeAttr('style');
            $(this).parent().css({'width': diagonal_length, 'height': diagonal_length});
        }

    });
});
jQuery(function ($) {

    /**
     * System Theme Color
     */

    if (true == emulsion_script_vars.prefers_color_scheme) {

        const is_dark = window.matchMedia('(prefers-color-scheme: dark)');
        if (is_dark.matches) {
            if ($('body').hasClass('is-light')) {

                $('body').removeClass('is-light').addClass('is-dark prefers-color-scheme-dark');
                return;
            } else {
                $('body').removeClass('is-dark prefers-color-scheme-dark').addClass('is-light');
            }
        } else {

            const is_light = window.matchMedia('(prefers-color-scheme: light)');
            if (is_light.matches && $('body').hasClass('is-dark')) {

                $('body').removeClass('is-dark').addClass('is-light prefers-color-scheme-light');
            } else {
                $('body').removeClass('is-light prefers-color-scheme-light').addClass('is-dark');
            }
        }
    }
});
jQuery(function ($) {
    /**
     * Accessibility tab navigation
     * 
     * When focus visible. default hidden content 
     */
    $('.blocks-gallery-item, details:not([open])').attr('tabindex', 0);

    $('details').on('focus', function () {
        $(this).attr({
            'open': true,
        });
    });
    $('details').on('blur', function () {
        $(this).attr({
            'open': false,
        });
    });

});

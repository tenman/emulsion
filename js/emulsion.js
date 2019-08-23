jQuery(function ($) {
    "use strict";

    $("body").removeClass('noscript');

    // element wrap
    /**
     * the table element can not be controlled with max-width,
     *
     * All table elements wrapping with <div class="emulsion-table-wrapper"></div>
     * emulsion-table-wrapper is set CSS overflow-x auto
     * 
     * If the table width exceeds the size of the content area, display scroll bars to maintain readability.
     * If the table width is smaller than the content area, the stretch class displays the content width.
     * 
     */
    jQuery("table").each(function (i) {
        jQuery(this).wrap('<div class="emulsion-table-wrapper"></div>');

        var parent_width = $(this).parent('.emulsion-table-wrapper').width();
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

        $('.entry-content > [class|="wp-block"]').not('.alignleft, .alignright, .wp-block-image,.wp-block-image,.wp-block-cover, .wp-block-embed, .wp-block-group').wrap(function () {
            var classes = $(this).attr('class').match(/wp-block-\S+/);

            var brightness_class = '';

            if ('wp-block-columns' == classes) {
                brightness_class = 'columns-' + emulsion_script_vars.block_columns_class;
            }

            $(this).wrap('<section class="sectionized-' + classes + ' ' + brightness_class + '" ></section>');
            var string = $(this).html().slice(0, 4);
            var id = $(this).html().length;
            id = classes + '-' + parseInt(emulsion_script_vars.post_id) + '-' + parseInt(id);
            if ('is_preview' !== emulsion_script_vars.is_customize_preview) {
                $(this).parent().addClass(id);
            }
        });
    }

    /**
     * wp-block unwrap
     */

    $('.entry-content .wp-block-image figure').each(function ( ) {
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
            //0819
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

    /**
     * Single Post
     */

    $(document).on("click", ".show-content", function (event) {

        if (!$('body').hasClass('home') || !$('body').hasClass('archive') || !$('body').hasClass('blog')) {
            event.preventDefault();
        }

        var state = $(this).data('state');
        var single_id = parseInt($(this).data("id"));
        var single_type = $(this).data("type");

        switch (state) {
            case 1 :
            case undefined :
                var content_base = $("#post-" + single_id + " .entry-content").html();
                break;
        }

        switch (state) {
            case 1 :
            case undefined :

                $(this).addClass('is-active');
                $(this).parents('article').addClass('preview-is-active');
                $(this).data('state', 2);

                $("#loading").css("display", "block");

                if ('page' == single_type) {
                    var nobita_rest_query = 'wp/v2/pages/' + single_id;
                }
                if ('post' == single_type) {
                    var nobita_rest_query = 'wp/v2/posts/' + single_id;
                }

                var request_url = emulsion_script_vars.end_point + nobita_rest_query;


                $.getJSON(request_url, function (results) {

                    if ($("#post-" + single_id + " div").hasClass('entry-content')) {
                    } else {
                        $("#post-" + single_id + " .content").after('<div class="entry-content">' + results.content.rendered + '</div>');
                        $("#post-" + single_id + " .content").hide();
                    }
                    $(".blog #post-" + single_id + ",.home #post-" + single_id + ",.archive #post-" + single_id).parents('.article-wrapper').css({'flex-basis': '100%'});
                });
                $(document).ajaxComplete(function () {

                    $("#loading").css("display", "none").removeAttr('style');

                    $("#post-" + single_id + " .entry-content").css("display", "block").addClass('archive-preview');
                    $("html,body").animate({scrollTop: $("#post-" + single_id).offset().top - 70});
                });

                break;
            case 2 :
                $(this).data('state', 1);

                $(this).removeClass('is-active');
                $(this).parents('article').removeClass('preview-is-active');
                $("#post-" + single_id + " .content").show();
                $("#post-" + single_id + " .entry-content").removeAttr('style');
                $("#post-" + single_id + " .entry-content").remove();
                $("#post-" + single_id).parents('.article-wrapper').removeAttr('style');

                break;
        }
    });

});

jQuery(function ($) {
    "use strict";
    /**
     * To suppress the display of the title tooltip and change the attribute name
     * to the data attribute to enable display control on the CSS.
     */
    $('.sidebar-widget-area a, .footer-widget-area a, .page-wrapper a, .search-drawer a, .header-layer a').each(function (index) {
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
    $(".search-drawer .search-form .search-field").on("keyup touchend", function () {
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
    $('[class|="ico"],[class*=" ico-"]').each(function (index) {

        var classes = $(this).attr('class');
        console.log(classes);
        var target_class = classes.match(/^.*(ico-\S+).*$/);
        target_class = target_class[1];
        target_class = target_class.split('-');

        var tag_name = $(this).prop("tagName");

        if ('UL' == tag_name) {
            $(this).children('li').css({'list-style': 'none'}).prepend('<svg class="icon ' + target_class[1] + '" aria-hidden="true" style="width:1em;height:1em" role="img"><use xlink:href="#' + target_class[1] + '" /></svg>');
        } else {

            $(this).prepend('<svg class="icon ' + target_class[1] + '" aria-hidden="true" style="width:1em;height:1em" role="img"><use xlink:href="#' + target_class[1] + '" /></svg>');
        }

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
    $('a[href^=http]').not('[href^="' + emulsion_script_vars.home_url + '"]').addClass('external').attr('data-no-instant', 'data-no-instant');

    /**
     * instantcclick exclude links
     */
    $('#wpadminbar a,.editor a, .post-edit-link, .nav-links a, a[href*="wp-admin"], a[href$="/amp"], a[href*="#"]').attr('data-no-instant', 'data-no-instant');

    $('a[href$="action=register"], a[href*="wp-login"]').attr('data-no-instant', 'data-no-instant');

    /**
     * add required attribute on search form
     * Searching is a load-intensive process. If you do not enter it in the text field, no processing will be done
     */
    $('.search-form [type="search"]').attr('required', 'required');

    /**
     * Anchor Type
     */
    $("a:not(:has(*))").addClass('text-link');
    $('img').parent('a').addClass('image-link');

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

    var userAgent = window.navigator.userAgent.toLowerCase( );

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

        $(".emulsion-no-sidebar.enable-alignfull .entry-content > .wp-block-cover.alignfull[style] .wp-block-cover__inner-container").each(function (i) {

            var article_width = $(this).parents('article').width();
            var parent_width = $(this).parents('.entry-content').width();
            var negative_margin = parseInt(article_width) - parseInt(parent_width);
            var main_width = $(this).parents('main').width();
            negative_margin = parseInt(main_width) - parseInt(article_width) + parseInt(negative_margin);
            negative_margin = negative_margin / -2;

            $(this).css({'width': article_width, 'left': negative_margin, 'position': 'relative', 'display': 'flex', 'visibility': 'visible'});
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

        if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {

            $('body').addClass('agent-mobile-phone');

            //wp_nav_menu() change from horizontal menu to vertical menu
            //  $('.primary').attr('data-direction', 'vertical');

        } else if (ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0) {

            $('body').addClass('agent-tablet');
        } else {

            var emulsion_window_width = parseInt(jQuery(window).width());
            var break_point = parseInt(emulsion_script_vars.content_width) + parseInt(emulsion_script_vars.content_gap) * 2;

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

    emulsion_resizes( );
});

jQuery(function ($) {
    /**
     * Cookie
     *
     * @param {type} key
     * @param {type} value
     * @return {undefined}
     */
    "use strict";
    function emulsion_set_cookie(key, value) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (1 * 24 * 60 * 60));
        document.cookie = key + '=' + value + ';path=/' + ';expires=' + expires.toUTCString();
    }

    function emulsion_get_cookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }

    if ('is_checked' == emulsion_get_cookie('toc-toggle') /*　デフォルトでオープン　|| null == emulsion_get_cookie('toc-toggle')*/) {

        $("#toc-toggle").prop("checked", true);
    }

    $("#toc-toggle").change(function () {
        var is_checked = this.checked ? 'is_checked' : 'no_checked';

        emulsion_set_cookie('toc-toggle', is_checked);
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
     */

    $('body').append('<a id="scroll-top" class="scroll-button-top skin-button"><span>Top</span></a>');

    $('#scroll-top').click(function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 500);
    });
});

jQuery(function ($) {
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
     * Accessible
     */
    $('.entry-content a').keyup(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);

        if (code == 9) {
            $('.entry-content a').focusin(function (e) {

            });
            $('.entry-content a').blur(function (e) {

                $(this).parent().css({'border': 'none'});
            });
        }
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
    $('.wp-block-column  p > img:only-child').each(function (i) {
        $(this).parent().addClass('has-only-image');
    });
});
jQuery(function ($) {
    $('.wp-block-button a').each(function (i) {
        if ($(this).hasClass('has-background')) {
            $(this).parent().addClass('button-has-background');
        }
    });
});
jQuery(function ($) {
    if ('disable' == emulsion_script_vars.sticky_sidebar) {
        $('body').addClass('disable-sidebar-sticky');
    }
    if ('enable' == emulsion_script_vars.sticky_sidebar) {
        $('body').addClass('enable-sidebar-sticky');
    }
});
jQuery(function ($) {
    if (emulsion_script_vars.force_contrast) {

        $('.entry-content > div:not(.shortcode-wrapper),.entry-content > .shortcode-wrapper > div, .entry-content > .has-background:not(.has-text-color)').not('.wp-block-button').each(function (i) {

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
                console.log(background_color_rgb);
                //TODO
                if ($(this).is('[id="bbpress-forums"]')) {
                    $(this).addClass('has-background emulsion-initial-color').css({'position': 'relative', 'z-index': '1'});
                    return;

                }
                if (background_color_rgb == "rgba(0, 0, 0, 0)" || 'transparent' == background_color_rgb) {
                    $(this).addClass('emulsion-current-color');
                } else {
                    $(this).addClass('emulsion-initial-color').css({'backgroud': background_color_rgb, 'position': 'relative', 'z-index': '1'});
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
    var userAgent = window.navigator.userAgent.toLowerCase( );

    if (userAgent.match(/Trident/i) && userAgent.match(/rv:11/i)) {
        $('body').removeClass('enable-alignfull');
        $('body').removeClass('enable-sidebar-sticky');
    }
});
jQuery(function ($) {
    var userAgent = window.navigator.userAgent.toLowerCase( );
    if (userAgent.match(/Edge\/\d+/i)) {
        jQuery('body').addClass('agent-edge');

    } else if (userAgent.match(/Trident/i) && userAgent.match(/rv:11/i)) {
        jQuery('body').addClass('agent-ie11');
    }
});

jQuery(function ($) {
    $('.transform-tab > li,.is-style-tab > li').each(function (i) {
        var height = Math.round($(this).children().height()) + 32;
        $(this).attr({
            'tabindex': '0',
            'style': 'margin-bottom:' + height + 'px'
        });
        $(this).parent().attr({
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

//drawer-wrapper
jQuery(function ($) {
    $(".drawer-wrapper .icon").on("click", function () {
        $('body').toggleClass("drawer-is-active");
    });
});

jQuery(document).ready(function ($) {
    /**
     * when not exists meta description tag, add meta description tag
     * 
     */
    function emulsion_get_meta(metaName) {
        const metas = document.getElementsByTagName('meta');

        for (let i = 0; i < metas.length; i++) {
            if (metas[i].getAttribute('name') === metaName) {
                return metas[i].getAttribute('content');
            }
        }

        return '';
    }

    if ('' == emulsion_get_meta('description') && '' !== emulsion_script_vars.meta_description) {

        $("head").append('<meta name="description" content="' + emulsion_script_vars.meta_description + '" />');
    }


});
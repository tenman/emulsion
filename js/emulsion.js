jQuery(function ($) {
    "use strict";
    $("body").removeClass('noscript');


    //   $(".primary-menu-wrapper [id].menu").attr('data-type', 'accordion');

    /**
     * wp-block unwrap
     */

    if ($('.wp-block-image').length) {
        $('.wp-block-image figure').each(function () {
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
                var image_width = $(this).children().attr('width');
                $(this).parent().addClass('is-resized').attr('style', "width:" + image_width + "px");

            }
            if ($(this).hasClass('size-medium')) {

                $(this).parent().addClass('size-medium');
            }
        });
    }
});
jQuery(function ($) {
    /**
     * Function for opening / closing the child menu of wp_nav_menu ()
     */
    if ($('.menu-item-has-children').length) {
        $('.wp-nav-menu .menu-item-has-children > a').each(function (i) {
            var text = $(this).parent().attr('id');
            var text_id = text + '-opener';
            if ('undefined' !== text_id) {
                text_id = 'primary-opener-' + i;
            }
            $(this).siblings('.nav-menu-child-opener, .nav-menu-child-opener-label').remove(); //for browser back
            $(this).parents('nav').addClass('has-chckbox-control');
            $(this).parents('nav').attr('tabindex', 0);
            $(this).after('<input id="' + text_id + '" type="checkbox" class="nav-menu-child-opener" /><label tabindex="0" class="nav-menu-child-opener-label" for="' + text_id + '"><svg class="description" width="1" height="1"><desc>has child menu</desc></svg></label>');
        });
        // Sidebar Widget
        $('.widget_nav_menu .menu-item-has-children > a').each(function (i) {
            var text = $(this).parent().attr('id');
            var text_id = text + '-opener';
            if ('undefined' !== text_id) {
                text_id = 'widget-opener-' + i;
            }
            $(this).siblings('.nav-menu-child-opener, .nav-menu-child-opener-label').remove(); //for browser back
            $(this).parents('nav').addClass('has-chckbox-control');
            $(this).after('<input id="' + text_id + '" type="checkbox" class="nav-menu-child-opener" /><label tabindex="0" class="nav-menu-child-opener-label" for="' + text_id + '"><svg class="description" width="1" height="1"><desc>has child menu</desc></svg></label>');
        });
    }
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
    $('.layout,.header-layer').not('.template-part-header').on('click', function () {
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
    if ('ja' == emulsion_script_vars.locale || 'ko-KR' == emulsion_script_vars.locale || 'zh-CN' == emulsion_script_vars.locale || 'zh-TW' == emulsion_script_vars.locale || 'zh-HK' == emulsion_script_vars.locale) {

        $('.wp-block-latest-posts__list.is-grid .wp-block-latest-posts__post-excerpt').each(function (index) {

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
    }


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
            $(this).css({"fontSize": '1rem'});
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
    $('.sidebar-widget-area a, .footer-widget-area a, .page-wrapper a, .search-drawer a, .header-layer a').not('.wp-block-navigation-item__content, .social-links-menu a, a.has-title, .has-title a').each(function (index) {
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
    //$(".search-drawer .wp-block-search .wp-block-search__input").on("keyup touchend", function () {

    $(".widget_categories.search-drawer-content > ul").addClass('horizontal-list-group');
    $(".search-drawer .wp-block-search__inside-wrapper .wp-block-search__input").on("keyup touchend", function () {
        var value = $(this).val().toLowerCase();
        $(".search-info li ul li, .search-info .tagcloud a").filter(function () {
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
            } else if ($(this).hasClass('wp-block-button')) {
                $(this).children('a').prepend('<svg class="icon ico-' + target_class + '" aria-hidden="true" style="width:1em;height:1em" role="img"><use xlink:href="#' + target_class + '" /></svg>');
            } else {
                $(this).prepend('<svg class="icon ico-' + target_class + '" aria-hidden="true" style="width:1em;height:1em" role="img"><use xlink:href="#' + target_class + '" /></svg>');
            }
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
    if ('enable' == emulsion_script_vars.instantclick_support) {

        $('a[href^=http]').not('[href^="' + emulsion_script_vars.home_url + '"]').addClass('external').attr('data-no-instant', 'data-no-instant');
        $('.emulsion-removed-presentation a, .emulsion-not-support-presentation a').attr('data-no-instant', 'data-no-instant');

        $('.logged-in a').attr('data-no-instant', 'data-no-instant');



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
    $('svg').parent('a').addClass('has-svg');
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
        var offset_primary_menu = $('body .header-layer').height();
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
     * Add screen reader text when entry ttle is blank
     */
    $('.entry-title a:empty, .relate-posts a:empty').prepend('<span class="screen-reader-text">' + emulsion_script_vars.i18n_blank_entry_title + '</span><span>...</span>');
});
jQuery(function ($) {
    /**
     * alignfull helper
     */
    "use strict";
    function emulsion_resizes() {
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
});
jQuery(function ($) {
    "use strict";
    if ('is_checked' == localStorage.getItem('toc-toggle')) {
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
    $(".wp-block-embed-wordpress iframe").on('load', function (i) {
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

        $('.is-dark div[id], .is-dark .shortcode-wrapper').not('#wpadminbar, #site-title, #main, input, .has-text-color').each(function (i) {

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

                } else if (background_color_rgb !== "rgba(0, 0, 0, 0)" && 'transparent' !== background_color_rgb) {
                    $(this).addClass('emulsion-transparent-correction');
                } else {
                    $(this).addClass('emulsion-initial-color');
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
    /**
     * Pending during implementation with PHP function
     * emulsion_fse_background_color_class()
     * @type String
     */
   /* $(".is-presentation-fse").each(function () {
        var background_color = $(this).css('background-color');
        var text_color = emulsion_text_color(background_color);
        if (text_color == "#ffffff") {
            var color_class = 'fse-dark';
        } else {
            var color_class = 'fse-light';
        }
        $(this).addClass(color_class);

        if ('rgb(27, 38, 44)' == background_color || 'rgba(27, 38, 44, 1)' == background_color) {
            $(this).addClass('fse-variation-midnight');
        }
    });*/

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

    $('.dropdown-on-hover, .dropdown-on-click').each(function (i) {
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
            //   $(this).wrapInner($('<a href="#' + fragment + '"></a>'));
        }
    });
});

jQuery(function ($) {

    /**
     * System Theme Color
     */

    if ('enable' == emulsion_script_vars.prefers_color_scheme) {

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

jQuery(function ($) {

    $('[for="primary-menu-controll"]').on('click', function () {

        var ua = navigator.userAgent.toLowerCase(), isIOS = /iphone|ipod|ipad/.test(ua),
                isLine = /line/.test(ua), isFb = /fb/.test(ua), isTw = /twitter/.test(ua),
                isSafari = /safari/.test(ua), isChrome = /crios/.test(ua);

        if (isIOS && isSafari) {

            if ($(this).hasClass('is-primary-menu-open')) {

                $(this).removeClass('is-primary-menu-open').siblings('nav').css({'visibility': 'hidden', 'display': 'none'});
            } else {
                $(this).addClass('is-primary-menu-open').siblings('nav').css({'visibility': 'visible', 'display': 'block'});
            }

        }
    });

});
jQuery(function ($) {
    if ($('.shortcode-wrapper').length) {

        $('.shortcode-wrapper').each(function (i) {

            if ($(this).children().hasClass('alignleft')) {
                $(this).children().removeClass('alignleft');
                $(this).addClass('alignleft');
            }
            if ($(this).children().hasClass('alignright')) {
                $(this).children().removeClass('alignright');
                $(this).addClass('alignright');
            }
            if ($(this).children().hasClass('alignfull')) {
                $(this).children().removeClass('alignfull');
                $(this).addClass('alignfull');
            }
            if ($(this).children().hasClass('alignwide')) {
                $(this).children().removeClass('alignwide');
                $(this).addClass('alignwide');
            }
        });
    }
});
jQuery(function ($) {
    $('.wp-block-search__inside-wrapper[style]').each(function (i) {

        var form_width = $(this).parent().width();
        form_width = parseInt(form_width);
        console.log(form_width);

        var content_width = $(this).attr('style');
        content_width = String(content_width).replace(/[^0-9]/g, '');
        content_width = parseInt(content_width) / 100;


        var form_width_result = form_width * content_width;

        $(this).removeAttr('style');
        $(this).parent().css({'width': form_width_result + 'px', 'max-width': '100%'});

    });
});
jQuery(function ($) {
    if ($('.wp-block-columns').length) {

        $('.wp-block-column').each(function (i) {

            var column_width = $(this).width();
            column_width = parseInt(column_width);

            if (580 > column_width) {
                $(this).children().removeClass('alignleft alignright alignfull alignwide');
            }


        });
        $('.wp-block-latest-posts__list.is-grid .wp-block-latest-posts__post-full-content').each(function (i) {

            $(this).children().removeClass('alignleft alignright alignfull alignwide size1of2 size1of3 size1of4 size2of4 size1of5 size2of5 size3of5');
        });
    }
});
jQuery(function ($) {

    //Modal box
    if ($('.modal-open-link').length) {
        $('.modal-open-link').on('click', function () {

            $(this).next('.emulsion-modal').addClass('is-opened');
        });
        $('.emulsion-modal-title').on('click', function () {

            $(this).parents('.emulsion-modal').removeClass('is-opened');


        });

        var lastHash = location.hash.substring(1);
        var lastHash_class = lastHash.replace(/[a-z0-9-_]/g, '');

        $('.modal-close-link').on('click', function () {
            var Y = window.scrollY;
            var hash = location.hash.substring(1);
            var hash_class = hash.replace(/[a-z0-9-_]/g, '');
            location.hash = hash_class;

            if (hash_class || lastHash_class) {
                location.reload();
            }
            $(window).scrollTop(Y);

        });
        $(document).on('click', '.modal-close-link', function () {
            var Y = window.scrollY;
            var hash = location.hash.substring(1);
            var hash_class = hash.replace(/[a-z0-9-_]/g, '');
            location.hash = hash_class;

            if (hash_class || lastHash_class) {
                location.reload();
            }
            $(window).scrollTop(Y);

        });


        // dropdown on click

        $('.dropdown-on-click-title').on('click', function () {

            $(this).parents('.dropdown-on-click').addClass('is-opened');
        });

        $('.dropdown-on-click').blur(function () {

            $(this).removeClass('is-opened');
        });
    }

});

jQuery(function ($) {

    $(".is-style-sticky").parents().css("overflow", "visible");
});

jQuery(function ($) {

    $(".menu-main-container").attr('aria-labelledby', 'main menu');

    $('.wp-block-page-list__submenu-icon').attr('tabindex', 0);

});

jQuery(function ($) {
    $('.navigation .screen-reader-text').attr('tabindex', 0).css({'top': '-2rem'});
});
jQuery(function ($) {
    $('.wp-block-navigation .wp-block-navigation__submenu-icon').attr('tabindex', 0);
    $('.wp-block-navigation .wp-block-navigation__submenu-icon:focus, .wp-block-navigation .wp-block-navigation__submenu-icon:active,.wp-block-navigation .wp-block-navigation__submenu-icon:focus-within').attr('aria-expanded', true);
});
jQuery(function ($) {
    $('.alignleft .size-thumbnail,.alignright .size-thumbnail').parent().addClass('size-thumbnail');
    $('.alignleft .size-mediuml,.alignright .size-medium').parent().addClass('size-medium');
    $('.alignleft .size-large,.alignright .size-large').parent().addClass('size-large');
    $('.alignleft .size-full,.alignright .size-full').parent().addClass('size-full');
});

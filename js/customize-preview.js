(function ($) {

    function hasHeaderImage() {
        var image = wp.customize('header_image')();
        return '' !== image && 'remove-header' !== image;
    }
    function hasHeaderVideo() {
        var externalVideo = wp.customize('external_header_video')(),
                video = wp.customize('header_video')();

        return '' !== externalVideo || (0 !== video && '' !== video);
    }

    $.each(['external_header_video', 'header_image', 'header_video'], function (index, settingId) {
        wp.customize(settingId, function (setting) {
            setting.bind(function () {

                if (hasHeaderImage()) {
                    $('.header-layer').removeClass('header-video-active no-header-media');
                    $('.header-layer').addClass('header-image-active');

                } else {
                    $('.header-layer').removeClass('no-header-media header-video-active');
                    $('.header-layer').addClass('no-header-media');
                }

                if (!hasHeaderVideo()) {
                    $('.header-layer').removeClass('no-header-media header-image-active');
                    $('.header-layer').addClass('header-video-active');
                }
                if (!hasHeaderVideo() && !hasHeaderImage()) {
                    $('.header-layer').removeClass('header-video-active header-image-active');
                    $('.header-layer').addClass('no-header-media');
                }

            });
        });
    });
})(jQuery);

(function ($) {

    function emulsion_hex_to_rgba(hex, alfa) {
        // must 6digit
        var c;
        if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
            c = hex.substring(1).split('');
            if (c.length == 3) {
                c = [c[0], c[0], c[1], c[1], c[2], c[2]];
            }
            c = '0x' + c.join('');
            return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ', alfa)';
        }
        throw new Error('Bad Hex');
    }

    function sub_color(color, percent) {
        var r = parseInt(color.substring(1, 3), 16);
        var g = parseInt(color.substring(3, 5), 16);
        var b = parseInt(color.substring(5, 7), 16);

        r = parseInt(r * (100 + percent) / 100);
        g = parseInt(g * (100 + percent) / 100);
        b = parseInt(b * (100 + percent) / 100);

        r = (r < 255) ? r : 255;
        g = (g < 255) ? g : 255;
        b = (b < 255) ? b : 255;

        var rr = ((r.toString(16).length == 1) ? "0" + r.toString(16) : r.toString(16));
        var gg = ((g.toString(16).length == 1) ? "0" + g.toString(16) : g.toString(16));
        var bb = ((b.toString(16).length == 1) ? "0" + b.toString(16) : b.toString(16));

        return "#" + rr + gg + bb;
    }

    function emulsion_text_color(newval) {

        var hex = newval;
        // console.log(hex);
        if (hex.indexOf('#') === 0) {
            hex = hex.slice(1);
        }

        if (hex.length === 3) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        if (hex.length !== 6) {
            var rgb = hex.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            var r = rgb[1];
            var g = rgb[2];
            var r = rgb[3];

        } else {
            var r = parseInt(hex.slice(0, 2), 16);
            var g = parseInt(hex.slice(2, 4), 16);
            var b = parseInt(hex.slice(4, 6), 16);
        }

        var result = (r * 0.299 + g * 0.587 + b * 0.114) > 186
                ? '#333333'
                : '#ffffff';

        return result;
    }

    function emulsion_rgb2hsl(r, g, b, condition, hue, saturation, lightness) {

        r /= 255, g /= 255, b /= 255;

        var max = Math.max(r, g, b), min = Math.min(r, g, b);
        var h, s, l = (max + min) / 2;

        if (max == min) {
            h = s = 0; // achromatic
        } else {
            var d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);

            switch (max) {
                case r:
                    h = (g - b) / d + (g < b ? 6 : 0);
                    break;
                case g:
                    h = (b - r) / d + 2;
                    break;
                case b:
                    h = (r - g) / d + 4;
                    break;
            }

            h /= 6;
        }



        h = 0 === h.length ? 60 : h + 60;
        h = h > 360 ? h - 360 : h;
        h = h < 0 ? 360 + h : h;

        if ('#fff' == condition) {

            s = 0 === s.length ? 100 : saturation;
            l = 0 === l.length ? 30 : lightness;
        }

        if ('#000' == condition) {

            s = 0 === s.length ? 70 : saturation;
            l = 0 === s.length ? 30 : lightness;
        }
        h = Math.round(h);
        s = Math.round(s) * 100 + '%';
        l = Math.round(l) * 100 + '%';

        return 'hsl( ' + h + ', ' + s + ', ' + l + ')';
    }

    wp.customize('background_color', function (value) {

        value.bind(function (newval) {

            var hex = newval;
            // console.log(hex);
            if (hex.indexOf('#') === 0) {
                hex = hex.slice(1);
            }

            if (hex.length === 3) {
                hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
            }
            if (hex.length !== 6) {
                var rgb = hex.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

                var r = rgb[1];
                var g = rgb[2];
                var r = rgb[3];

            } else {
                var r = parseInt(hex.slice(0, 2), 16);
                var g = parseInt(hex.slice(2, 4), 16);
                var b = parseInt(hex.slice(4, 6), 16);
            }

            var result = (r * 0.299 + g * 0.587 + b * 0.114) > 186
                    ? 'light'
                    : 'dark';


            if ('light' == result) {
                $('body').removeClass('is-dark').addClass('is-light');

                var hue = 5;
                var saturation = 20;
                var lightness = 90;
                var text_color = '#333333';
                var sidebar_bg = '#ffffff';

            }
            if ('dark' == result) {
                $('body').removeClass('is-light').addClass('is-dark');
                var hue = 5;
                var saturation = 20;
                var lightness = 15;
                var text_color = '#ffffff';
                var sidebar_bg = '#000000';
                var current_sidebar_color = $('.sidebar-widget-area').css("background-color");
            }

            if ($(".sidebar-widget-area").css("background-color") == "rgb(255,255,255)" ||
                    $(".sidebar-widget-area").css("background-color") == "rgb(255, 255, 255)" ||
                    $(".sidebar-widget-area").css("background-color") == "#ffffff" ||
                    $(".sidebar-widget-area").css("background-color") == "rgb(0,0,0)" ||
                    $(".sidebar-widget-area").css("background-color") == "rgb(0, 0, 0)" ||
                    $(".sidebar-widget-area").css("background-color") == "#000000") {

                $('.sidebar-widget-area, .sidebar-widget-area a').css({'background-color': sidebar_bg, 'color': text_color});
            }

            if ($(".primary-menu-wrapper").css("background-color") == "rgb(255,255,255)" ||
                    $(".primary-menu-wrapper").css("background-color") == "rgb(255, 255, 255)" ||
                    $(".primary-menu-wrapper").css("background-color") == "#ffffff" ||
                    $(".primary-menu-wrapper").css("background-color") == "rgb(0,0,0)" ||
                    $(".primary-menu-wrapper").css("background-color") == "rgb(0, 0, 0)" ||
                    $(".primary-menu-wrapper").css("background-color") == "#000000") {

                $('.primary-menu-wrapper, .primary-menu-wrapper a').css({'background-color': sidebar_bg, 'color': text_color});
            }

            $('article a,.placeholder-header a, .entry-date').css({'color': text_color, 'background': 'transparent'});
            $('body, .custom-background.background-css-pattern-seigaiha').css('background-color', newval);
            $('.menu-placeholder').css({'background': 'transparent'});

        });
    });
    wp.customize('blogname', function (value) {
        value.bind(function (newval) {
            $('#site-title a').html(newval);
        });
    });
    wp.customize('emulsion_alignfull', function (value) {
        value.bind(function (newval) {
            if ('disable' == newval) {
                $('body').removeClass('enable-alignfull').addClass('disable-alignfull');
                $('.alignfull, .alignwide').removeAttr('style').css({'max-width': '100%'});
            }
            if ('enable' == newval) {
                $('body').removeClass('disable-alignfull').addClass('enable-alignfull');
                $('.alignfull, .alignwide').removeAttr('style').css({'max-width': 'none'});
            }
        });
    });

    wp.customize('display_header_text', function (value) {
        value.bind(function (newval) {
            if (true !== newval) {
                $('.site-title-text, .site-description').css({'display': 'none'});
            }
        });
    });

    wp.customize('blogdescription', function (value) {
        value.bind(function (newval) {
            $('.site-description').html(newval);
        });
    });

    wp.customize('emulsion_general_link_hover_color', function (value) {
        value.bind(function (newval) {
            $('head').append('<style>a:hover{color:' + newval + ' ! important;}</style>');
        });
    });

    wp.customize('background_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--thm_background_color', newval);
            document.documentElement.style.setProperty('--thm_sub_background_color_lighten', sub_color(newval, 125));
            document.documentElement.style.setProperty('--thm_sub_background_color_darken', sub_color(newval, 75));

            $('article, .entry-title, .entry-content *').css({'color': emulsion_text_color(newval)});
        });
    });

    wp.customize('emulsion_background_css_pattern', function (value) {
        value.bind(function (newval) {
            $('body').removeClass('background-css-pattern-carbon-fiber background-css-pattern-seigaiha background-css-pattern-cicada background-css-pattern-lattice background-css-pattern-hexagonal');
            $('body').addClass('background-css-pattern-' + newval);
        });
    });

    wp.customize('emulsion_header_gradient', function (value) {
        value.bind(function (newval) {

            if ('disable' == newval) {
                $('header.header-layer').removeAttr('style');
                $('.header-layer').css('background', 'var( --thm_header_bg_color )');

            } else {
                $('.header-layer').removeAttr('style');

            }
        });
    });

    wp.customize('emulsion_category_colors', function (value) {
        value.bind(function (newval) {
            if ('disable' == newval) {
                $('body').removeClass('has-category-colors');
                $('body').addClass('disable-category-colors');
            } else {
                $('body').addClass('has-category-colors');
                $('body').removeClass('disable-category-colors');
            }
        });
    });
    wp.customize('emulsion_common_font_size', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--thm_common-font-size', newval);

        });
    });
    wp.customize('background_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--thm_background_color', newval);
        });
    });

    wp.customize('emulsion_post_display_date', function (value) {
        value.bind(function (newval) {

            $('.posted-on [rel="date"], .wp-block-latest-posts__post-date').css('display', newval);

        });
    });
    wp.customize('emulsion_post_display_author', function (value) {
        value.bind(function (newval) {

            $('.posted-on .author').css('display', newval);
        });
    });
    wp.customize('emulsion_post_display_category', function (value) {
        value.bind(function (newval) {

            $('.post-category .cat-item').css('display', newval);
        });
    });
    wp.customize('emulsion_post_display_tag', function (value) {
        value.bind(function (newval) {

            $('.post-tag li').css('display', newval);
        });
    });
    wp.customize('emulsion_common_font_family', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty(' --thm_common_font_family', newval);
        });
    });
    wp.customize('emulsion_heading_font_family', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--thm_heading_font_family', newval);

        });
    });

    wp.customize('emulsion_heading_font_weight', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--thm_heading_font_weight', newval);
        });
    });
    wp.customize('emulsion_heading_font_scale', function (value) {
        value.bind(function (newval) {

            if (newval == '3x') {
                $('.entry-content h1,.entry-content .h1').css('font-size', '3rem');
                $('.entry-content h2,.entry-content .h2, .entry-title').css('font-size', '2rem');
                $('.entry-content h3,.entry-content .h3').css('font-size', '1.5rem');
            }
            if (newval == '2x') {
                $('.entry-content h1,.entry-content .h1').css('font-size', '2rem');
                $('.entry-content h2,.entry-content .h2, .entry-title').css('font-size', '1.4rem');
                $('.entry-content h3,.entry-content .h3').css('font-size', '1.17rem');
            }
        });
    });
    wp.customize('emulsion_heading_font_transform', function (value) {
        value.bind(function (newval) {
            $('h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6').css('text-transform', newval);
            $('h1 a,h2 a,h3 a,h4 a,h5 a,h6 a,.h1 a,.h2 a,.h3 a,.h4 a,.h5 a,.h6 a').css('text-transform', newval);
        });
    });
    wp.customize('emulsion_widget_meta_font_size', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--thm_heading_font_weight', newval);
        });
    });
    wp.customize('emulsion_widget_meta_font_family', function (value) {
        value.bind(function (newval) {
            $('.wp-nav-menu a,.sidebar-widget-area a, .footer-widget-area .footer-widget-area-lists a,footer address').css('font-family', newval);
        });
    });
    wp.customize('emulsion_widget_meta_font_transform', function (value) {
        value.bind(function (newval) {
            $('.wp-nav-menu a,.sidebar-widget-area a, .footer-widget-area .footer-widget-area-lists a,footer address').css('text-transform', newval);
        });
    });
    wp.customize('emulsion_footer_columns', function (value) {
        value.bind(function (newval) {
            var cols = parseInt(newval);
            var cols_percent = 100 / cols;
            cols_percent = Math.floor(cols_percent) - 3;

            $('.template-part-widget-footer.footer-widget-area .footer-widget-area-lists > li').css({'flex-basis': cols_percent + '%'});
        });
    });
    wp.customize('emulsion_sidebar_position', function (value) {
        value.bind(function (newval) {
            if (newval == 'left') {

                $('.sidebar-widget-area,.menu-placeholder').css('order', '0');
            }
            if (newval == 'right') {

                $('.sidebar-widget-area,.menu-placeholder').css('order', '2');
            }
        });
    });
    wp.customize('emulsion_layout_homepage', function (value) {
        value.bind(function (newval) {
            $('.home main > div').removeAttr('class').addClass(newval);
        });
    });
    wp.customize('emulsion_layout_posts_page', function (value) {
        value.bind(function (newval) {
            console.log(newval);
            $('.blog main > div').removeAttr('class').addClass(newval);
        });
    });
    wp.customize('emulsion_layout_date_archives', function (value) {
        value.bind(function (newval) {
            $('.date main > div').removeAttr('class').addClass(newval);
        });
    });
    wp.customize('emulsion_layout_category_archives', function (value) {
        value.bind(function (newval) {
            $('.category main > div').removeAttr('class').addClass(newval);
        });
    });
    wp.customize('emulsion_layout_tag_archives', function (value) {
        value.bind(function (newval) {
            $('.tag main > div').removeAttr('class').addClass(newval);
        });
    });
    wp.customize('emulsion_layout_author_archives', function (value) {
        value.bind(function (newval) {
            $('.author main > div').removeAttr('class').addClass(newval);
        });
    });
    wp.customize('emulsion_table_of_contents', function (value) {
        value.bind(function (newval) {
            if ('disable' == newval) {
                $('.menu-placeholder [for="toc-toggle"]').addClass('screen-reader-text');
            }
            if ('enable' == newval) {
                $('.menu-placeholder [for="toc-toggle"]').removeClass('screen-reader-text');
            }
        });
    });

    wp.customize('emulsion_title_in_header', function (value) {
        value.bind(function (newval) {
            if ('yes' == newval) {
                $('article header').addClass('screen-reader-text');
                $('.woocommerce-products-header').addClass('screen-reader-text');
                $('header .entry-text').css('display', 'flex');
            }
            if ('no' == newval) {
                $('article header').removeClass('screen-reader-text');
                $('.woocommerce-products-header').removeClass('screen-reader-text');
                $('header .entry-text').css('display', 'none');
            }
        });
    });
    wp.customize('emulsion_box_gap', function (value) {
        value.bind(function (newval) {
            $('.blocks-gallery-item').css('margin', newval + 'px');
            var double = newval * 2;
            $('.columns-2 .blocks-gallery-item').css({'width': 'calc( 99.9% / 2 - ' + double + 'px)'});
            $('.columns-3 .blocks-gallery-item').css({'width': 'calc( 99.9% / 3 - ' + double + 'px)'});
            $('.columns-4 .blocks-gallery-item').css({'width': 'calc( 99.9% / 4 - ' + double + 'px)'});
            $('.columns-5 .blocks-gallery-item').css({'width': 'calc( 99.9% / 5 - ' + double + 'px)'});
            $('.columns-6 .blocks-gallery-item').css({'width': 'calc( 99.9% / 6 - ' + double + 'px)'});

        });
    });
    wp.customize('emulsion_box_gap', function (value) {
        value.bind(function (newval) {
            $('.wp-block-columns .wp-block-column').css('margin', newval + 'px');
            var double = newval * 2;
            $('.has-2-columns .wp-block-column').css({'width': 'calc( 99.9% / 2 - ' + double + 'px)'});
            $('.has-3-columns .wp-block-column').css({'width': 'calc( 99.9% / 3 - ' + double + 'px)'});
            $('.has-4-columns .wp-block-column').css({'width': 'calc( 99.9% / 4 - ' + double + 'px)'});
            $('.has-5-columns .wp-block-column').css({'width': 'calc( 99.9% / 5 - ' + double + 'px)'});
            $('.has-6-columns .wp-block-column').css({'width': 'calc( 99.9% / 6 - ' + double + 'px)'});
        });
    });
    wp.customize('emulsion_box_gap', function (value) {
        value.bind(function (newval) {
            $('.grid .article-wrapper').css({'margin': newval + 'px'});
            $('.stream .article-wrapper').css({'margin': newval + 'px'});
        });
    });
    wp.customize('emulsion_sticky_sidebar', function (value) {
        value.bind(function (newval) {
            if ('disable' == newval) {
                $('.sidebar-widget-area .widget:last-child').css({'position': 'static'});
            }
            if ('enable' == newval) {
                $('.sidebar-widget-area .widget:last-child').css({'position': 'sticky'});
            }
        });
    });
    wp.customize('emulsion_block_gallery_section_height', function (value) {
        value.bind(function (newval) {
            $('.sectionized-wp-block-gallery').css({'min-height': newval + 'vh'});
        });
    });
    wp.customize('emulsion_block_columns_section_height', function (value) {
        value.bind(function (newval) {
            $('.wp-block-columns').css({'min-height': newval + 'vh'});
        });
    });
    wp.customize('emulsion_block_media_text_section_height', function (value) {
        value.bind(function (newval) {
            $('.wp-block-media-text').css({'min-height': newval + 'vh'});
        });
    });
    wp.customize('emulsion_block_gallery_section_bg', function (value) {
        value.bind(function (newval) {
            var color = emulsion_text_color(newval);
            $('.sectionized-wp-block-gallery').css({'background': newval, 'color': color});
        });
    });
    wp.customize('emulsion_primary_menu_background', function (value) {
        value.bind(function (newval) {
            var color = emulsion_text_color(newval);
            $('.primary-menu-wrapper').css({'background': newval, 'color': color});
            $('.primary-menu-wrapper a').css({'color': color, 'background': 'transparent'});

            $('.primary-menu-wrapper').removeClass('menu-is-light menu-is-dark');

            if ('#ffffff' == emulsion_text_color(newval)) {
                $('.primary-menu-wrapper').addClass('menu-is-dark');
            } else {
                $('.primary-menu-wrapper').addClass('menu-is-light');
            }
        });
    });
    wp.customize('emulsion_sidebar_background', function (value) {
        value.bind(function (newval) {
            var color = emulsion_text_color(newval);
            $('.sidebar-widget-area').css({'background': newval, 'color': color});
            $('.sidebar-widget-area #calendar_wrap th, .sidebar-widget-area #calendar_wrap td').css({'background': newval, 'color': color});
            $('.sidebar-widget-area a').css({'color': color, 'background': 'transparent'});
            $('.emulsion-has-sidebar .primary-menu-wrapper .menu-placeholder').css({'background': newval, 'color': color});

            $('.sidebar-widget-area, .footer-widget-area').removeClass('sidebar-is-light sidebar-is-dark sidebar-is-default');

            if ('#ffffff' == newval) {
                $('.sidebar-widget-area, .footer-widget-area').addClass('sidebar-is-default');
            } else if ('#ffffff' == emulsion_text_color(newval)) {
                $('.sidebar-widget-area, .footer-widget-area').addClass('sidebar-is-dark');
            } else {
                $('.sidebar-widget-area, .footer-widget-area').addClass('sidebar-is-light');
            }
        });
    });
    //emulsion_sidebar_background
    wp.customize('emulsion_block_columns_section_bg', function (value) {
        value.bind(function (newval) {
            var color = emulsion_text_color(newval);
            $('.sectionized-wp-block-columns').css({'background': newval, 'color': color});
        });
    });
    wp.customize('emulsion_favorite_color_palette', function (value) {
        value.bind(function (newval) {
            $('.has-custom-background-color').css({'background': newval});
            $('.has-custom-color').css({'color': newval});
        });
    });
    //emulsion_favorite_color_palette
    wp.customize('emulsion_block_media_text_section_bg', function (value) {
        value.bind(function (newval) {
            var color = emulsion_text_color(newval);
            $('.sectionized-wp-block-media-text').css({'background': newval, 'color': color});
        });
    });
    wp.customize('emulsion_relate_posts_bg', function (value) {
        value.bind(function (newval) {
            var color = emulsion_text_color(newval);
            $('.relate-content-wrapper').css({'background': newval, 'color': color});
            $('.relate-content-wrapper a').css({'background': 'transparent', 'color': color});
        });
    });
    wp.customize('emulsion_excerpt_linebreak', function (value) {
        value.bind(function (newval) {
            $('blockquote.content-excerpt br').css({'display': newval});
        });
    });
    wp.customize('emulsion_general_link_color', function (value) {
        value.bind(function (newval) {
            $('.page-wrapper a').css({'color': newval});
        });
    });
    wp.customize('emulsion_general_link_hover_color', function (value) {
        value.bind(function (newval) {
            $('.page-wrapper a:hover').css({'color': newval});
        });
    });
    wp.customize('emulsion_general_text_color', function (value) {
        value.bind(function (newval) {
            $('p,ul,ol,table,footer address').css({'color': newval});
        });
    });
    wp.customize('emulsion_relate_posts', function (value) {
        value.bind(function (newval) {
            if ('disable' == newval) {
                $('.relate-content-wrapper').css({'display': 'none'});
            }
            if ('enable' == newval) {
                $('.relate-content-wrapper').css({'display': 'block'});
            }
        });
    });
    wp.customize('emulsion_widget_meta_title', function (value) {
        value.bind(function (newval) {
            if (true == newval) {
                var font_family = $(this).find('a').css('font-family');
                $('.widgettitle').css({'font-family': font_family});
            }
        });
    });

    wp.customize('emulsion_comments_bg', function (value) {
        value.bind(function (newval) {
            var color = emulsion_text_color(newval);
            $('.comment-wrapper').css({'background': newval, 'color': color});
            $('.comment-wrapper .comment-reply-title,.comment-wrapper .logged-in-as a').css({'color': color});
            $('.comment-wrapper .comment-form-comment label,.comment-wrapper .comment-notes').css({'color': color});
            $('.comment-wrapper .comment-form-author label,.comment-wrapper .comment-form-email label').css({'color': color});
            $('.comment-wrapper  .comment-form-url label,.comment-wrapper  .paginate-comment-links a').css({'color': color});
            $('.comment-wrapper  [type="submit"]').css({'border-color': color});
        });
    });

    wp.customize('emulsion_sidebar_width', function (value) {
        value.bind(function (newval) {
            $('.sidebar-widget-area').css({'min-width': newval, 'max-width': newval, 'width': newval, 'flex-basis': newval, 'border': '2px dashed'});
            $('.emulsion-has-sidebar .primary-menu-wrapper .menu-placeholder').css({'width': newval});
            setTimeout(function () {

                var div = $('.sidebar-widget-area,.emulsion-has-sidebar .primary-menu-wrapper .menu-placeholder');
                $({alpha: 1}).animate({alpha: 0}, {
                    duration: 1000,
                    step: function () {
                        div.css('border-color', 'rgba(52, 152, 219,' + this.alpha + ')');
                    }
                });

            }, 5000);

        });
    });

    wp.customize('emulsion_header_media_max_height', function (value) {
        value.bind(function (newval) {
            //    document.documentElement.style.setProperty('--thm_header_media_max_height', newval + 'vh');
            $('header.header-image-active, .header-video-active, .wp-custom-header img, .header-image-active .wp-post-image,.header-video-active video#wp-custom-header-video').css({'max-height': newval + 'vh', 'height': newval + 'vh'})

            setTimeout(function () {

                var div = $('.header-layer');
                $({alpha: 1}).animate({alpha: 0}, {
                    duration: 1000,
                    step: function () {
                        div.css('border-color', 'rgba(52, 152, 219,' + this.alpha + ')');
                    }
                });

            }, 5000);

        });
    });

    wp.customize('emulsion_main_width', function (value) {
        value.bind(function (newval) {

            if ($('body').hasClass('emulsion-has-sidebar')) {

                $('.emulsion-has-sidebar .page-wrapper').css({'border': '2px dashed'});

                var width = parseInt(newval) + parseInt(emulsion_script_vars.sidebar_width);

                $('.emulsion-has-sidebar .layout-block').css({'max-width': width + 'px'});
                setTimeout(function () {

                    var div = $('.emulsion-has-sidebar .page-wrapper');
                    $({alpha: 1}).animate({alpha: 0}, {
                        duration: 1000,
                        step: function () {
                            div.css('border-color', 'rgba(52, 152, 219,' + this.alpha + ')');
                        }
                    });

                }, 5000);
            }
        });
    });

    wp.customize('emulsion_main_width', function (value) {
        value.bind(function (newval) {

            if ($('body').hasClass('emulsion-no-sidebar')) {

                $('.entry-content').css({'border': '2px dashed', 'max-width': newval, 'width': newval});

                setTimeout(function () {

                    var div = $('.entry-content');
                    $({alpha: 1}).animate({alpha: 0}, {
                        duration: 1000,
                        step: function () {
                            div.css('border-color', 'rgba(52, 152, 219,' + this.alpha + ')');
                        }
                    });

                }, 5000);
            }
        });
    });
    wp.customize('emulsion_content_width', function (value) {
        value.bind(function (newval) {
            if ($('body').hasClass('emulsion-has-sidebar')) {

                $('.entry-content > *').css({'border': '2px dashed', 'max-width': newval, 'width': newval});

                setTimeout(function () {

                    var div = $('.entry-content > *');
                    $({alpha: 1}).animate({alpha: 0}, {
                        duration: 1000,
                        step: function () {
                            div.css('border-color', 'rgba(52, 152, 219,' + this.alpha + ')');
                        }
                    });

                }, 5000);
            }

        });
    });
    wp.customize('emulsion_content_width', function (value) {
        value.bind(function (newval) {
            if ($('body').hasClass('emulsion-no-sidebar')) {

                $('.entry-content > *').css({'border': '2px dashed', 'max-width': newval, 'width': newval});

                setTimeout(function () {
                    var div = $('.entry-content > *');
                    $({alpha: 1}).animate({alpha: 0}, {
                        duration: 1000,
                        step: function () {
                            div.css('border-color', 'rgba(52, 152, 219,' + this.alpha + ')');
                        }
                    });

                }, 5000);
            }

        });
    });

    wp.customize('emulsion_content_margin_top', function (value) {
        value.bind(function (newval) {
            if ($('body').hasClass('single')) {

                console.log(newval);

                $('article').css({'border': '2px dashed', 'margin-top': newval + 'px'});

                setTimeout(function () {
                    var elm = $('article');
                    $({alpha: 1}).animate({alpha: 0}, {
                        duration: 1000,
                        step: function () {
                            elm.css('border-color', 'rgba(52, 152, 219,' + this.alpha + ')');
                        }
                    });

                }, 5000);
            }

        });
    });

    wp.customize('emulsion_content_margin_top', function (value) {
        value.bind(function (newval) {
            if ($('body').hasClass('page')) {

                $('article').css({'border': '2px dashed', 'margin-top': newval + 'px'});

                setTimeout(function () {
                    var elm = $('article');
                    $({alpha: 1}).animate({alpha: 0}, {
                        duration: 1000,
                        step: function () {
                            elm.css('border-color', 'rgba(52, 152, 219,' + this.alpha + ')');
                        }
                    });

                }, 5000);
            }

        });
    });

    wp.customize('emulsion_header_background_color', function (value) {
        value.bind(function (newval) {

            document.documentElement.style.setProperty('--thm_header_bg_color', newval);//fx

            $('header.header-layer').css({'background': newval});

            $('.header-layer .site-title-text, .header-layer .site-description, .header-layer .entry-title, .header-layer .has-text, .header-layer .posted-on .entry-date, .header-layer .taxonomy-description').css({'color': emulsion_text_color(newval)});

            $('.header-layer').removeClass('header-is-light header-is-dark header-is-default-color');

            if ('#ffffff' == newval) {
                $('.header-layer').addClass('header-is-default-color');

            } else if ('#ffffff' == emulsion_text_color(newval)) {

                $('.header-layer').addClass('header-is-dark');
            } else {
                $('.header-layer').addClass('header-is-light');
            }
        });
    });
    wp.customize('header_textcolor', function (value) {
        value.bind(function (newval) {

            if (newval !== emulsion_script_vars.header_default_color) {

                $('#site-title a, #site-title .site-title-text, .site-description').css('color', newval);
            } else {

                $('.header-is-dark #site-title a, .header-is-dark  #site-title .site-title-text,.header-is-dark .site-description').css({'color': '#ffffff'});
                $('.header-is-light #site-title a, .header-is-light  #site-title .site-title-text,.header-is-light .site-description').css({'color': '#333333'});
            }
        });
    });
    wp.customize('emulsion_header_sub_background_color', function (value) {
        value.bind(function (newval) {

            document.documentElement.style.setProperty('--thm_header_background_gradient_color', newval);

            var start_color = getComputedStyle(document.documentElement).getPropertyValue('--thm_header_bg_color');

            $('header.header-layer').css({'background': 'linear-gradient(90deg, ' + start_color + ',' + newval + ')'});

        });
    });
    wp.customize('emulsion_header_gradient', function (value) {
        value.bind(function (newval) {
            if ('enable' == newval) {
                var start_color = getComputedStyle(document.documentElement).getPropertyValue('--thm_header_bg_color');
                var to_color = getComputedStyle(document.documentElement).getPropertyValue('--thm_header_background_gradient_color');
                $('header.header-layer').css({'background': 'linear-gradient(90deg, ' + start_color + ',' + to_color + ')'});

            }
        });
    });


    wp.customize('background_image', function (value) {
        value.bind(function (newval) {
            //  $('body').css({'background': 'url(' + newval + ')'});
            $('#custom-background-css').text('body.custom-background { ' + newval + ' }');

        });
    });
    wp.customize('emulsion_bg_image_text', function (value) {
        value.bind(function (newval) {
            if ('white' == newval) {

                $('article').not('has-background').css({'color': '#fff'});

            }
        });
    });

    wp.customize('emulsion_bg_image_blend_color', function (value) {
        value.bind(function (newval) {
            if ('white' == newval) {

                var amount = wp.customize.instance('emulsion_bg_image_blend_color_amount').get();
                amount = parseInt(amount) / 100;

                var body_background_image_dim = emulsion_hex_to_rgba(newval, amount);

                document.documentElement.style.setProperty('--thm_background_image_dim', newval);
            }
        });
    });

    wp.customize('emulsion_bg_image_blend_color_amount', function (value) {
        value.bind(function (newval) {
            if ('white' == newval) {

                var color = wp.customize.instance('emulsion_bg_image_blend_color').get();

                amount = parseInt(newval) / 100;

                var body_background_image_dim = emulsion_hex_to_rgba(color, amount);

                document.documentElement.style.setProperty('--thm_background_image_dim', newval);
            }
        });
    });

})(jQuery);
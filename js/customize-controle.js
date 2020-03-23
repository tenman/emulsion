(function ($) {

    const PREVIEW_REDIRECT = emulsion_customizer_controle.customizer_preview_redirect;

    function emulsion_text_color(newval) {

        var hex = newval;

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

    wp.customize.section('background_image', function (section) {
        section.expanded.bind(function (isExpanded) {
            var url;
            if (isExpanded && PREVIEW_REDIRECT == "enable") {
                url = wp.customize.settings.url.home + '?p=' + parseInt(emulsion_customizer_controle.latest_post_id, 10);
                wp.customize.previewer.previewUrl.set(url);

                var code = 'background_image';
                wp.customize.section('background_image').notifications.add(code, new wp.customize.Notification(code, {
                    dismissible: true,
                    message: emulsion_customizer_controle.background_image_notification,
                    type: 'info'
                }));

                setTimeout(function () {
                    $('.emulsion_fadeout_message__section_background_image').fadeOut();
                }, 5000);
            }
        });
    });
    
    function emulsion_redirect_notification(section, message, url, code ) {

        wp.customize.previewer.previewUrl.set(url);
        wp.customize.section(section).notifications.add(section, new wp.customize.Notification(code, {
            dismissible: true,
            message: message,
            type: 'info'
        }));

        var fadeout_class = section.replace("emulsion", "");

        fadeout_class = 'emulsion_fadeout_message' + fadeout_class;

        if( 'header_image' == section ) { //core
             fadeout_class = 'emulsion_fadeout_message_section_header_image';
        }

        setTimeout(function () {
                    $( '.' + fadeout_class ).fadeOut();
         }, 5000);
    }

    wp.customize.section('emulsion_section_layout_homepage', function (section) {
        section.expanded.bind(function (isExpanded) {
            if (isExpanded && PREVIEW_REDIRECT == "enable") {
                var code    = 'redirect';
                var url     = wp.customize.settings.url.home;
                var section = 'emulsion_section_layout_homepage';
                var message = emulsion_customizer_controle.code_section_layout_homepage_notification;
                emulsion_redirect_notification(section, message, url, code);
            }
        });
    });
 
    wp.customize.section('emulsion_section_layout_category_archives', function (section) {
        section.expanded.bind(function (isExpanded) {
            if (isExpanded && PREVIEW_REDIRECT == "enable") {
                var code    = 'redirect';
                var url     = wp.customize.settings.url.home + '?cat=1';
                var section = 'emulsion_section_layout_category_archives';
                var message = emulsion_customizer_controle.code_section_layout_category_archives_notification;
                emulsion_redirect_notification(section, message, url, code);
            }
        });
    });
 
    wp.customize.section('emulsion_section_layout_author_archives', function (section) {
        section.expanded.bind(function (isExpanded) {
            if (isExpanded && PREVIEW_REDIRECT == "enable") {
                var code    = 'redirect';
                var url     = wp.customize.settings.url.home + '?author=1';
                var section = 'emulsion_section_layout_author_archives';
                var message = emulsion_customizer_controle.code_section_layout_author_archives_notification;
                emulsion_redirect_notification(section, message, url, code);
            }
        });
    });
 
    wp.customize.section('emulsion_section_layout_date_archives', function (section) {
        section.expanded.bind(function (isExpanded) {

            if (isExpanded && PREVIEW_REDIRECT == "enable") {
                var code    = 'redirect';
                var url     = wp.customize.settings.url.home + '?m=' + this_month;
                var section = 'emulsion_section_layout_date_archives';
                var message = emulsion_customizer_controle.code_section_layout_date_archives_notification;
                emulsion_redirect_notification(section, message, url, code);
            }
        });
    });

    wp.customize.section('emulsion_section_layout_tag_archives', function (section) {
        section.expanded.bind(function (isExpanded) {
            if (isExpanded && PREVIEW_REDIRECT == "enable") {
                var code    = 'redirect';
                var url     = wp.customize.settings.url.home + '?tag=' + emulsion_customizer_controle.most_used_tag_slug;
                var section = 'emulsion_section_layout_tag_archives';
                var message = emulsion_customizer_controle.code_section_layout_tag_archives_notification;
                emulsion_redirect_notification(section, message, url, code);
            }
        });
    });
    wp.customize.section('header_image', function (section) {
        section.expanded.bind(function (isExpanded) {
            if (isExpanded && PREVIEW_REDIRECT == "enable") {
                var code    = 'redirect';
                var url     = wp.customize.settings.url.home;
                var section = 'header_image';
                var message = emulsion_customizer_controle.code_section_header_image_notification;
                emulsion_redirect_notification(section, message, url, code);

            }
        });
    });
    wp.customize.section('static_front_page', function (section) {
        section.expanded.bind(function (isExpanded) {
            var url;
            if (isExpanded && PREVIEW_REDIRECT == "enable") {
                url = wp.customize.settings.url.home;
                wp.customize.previewer.previewUrl.set(url);
            }
        });
    });

    wp.customize.section('emulsion_section_layout_main', function (section) {
        section.expanded.bind(function (isExpanded) {
            if (isExpanded && PREVIEW_REDIRECT == "enable") {
                var code    = 'redirect';
                var url     = wp.customize.settings.url.home + '?p=' + parseInt(emulsion_customizer_controle.latest_post_id, 10);
                var section = 'emulsion_section_layout_main';
                var message = emulsion_customizer_controle.code__section_layout_main_notification;
                emulsion_redirect_notification(section, message, url, code);
            }
        });
    });

    wp.customize.section('colors', function (section) {
        section.expanded.bind(function (isExpanded) {
            var gradient_setting = emulsion_customizer_controle.$header_gradient_setting;
            if (gradient_setting == 'disable') {
                $('#customize-control-emulsion_header_sub_background_color').css({'visibility': 'hidden'});
            }
        });
    });

    wp.customize('background_color', 'emulsion_general_text_color', 'emulsion_general_link_color', 'emulsion_general_link_hover_color', function (background_color, emulsion_general_text_color, emulsion_general_link_color, emulsion_general_link_hover_color) {
        background_color.bind(function (newval) {
            var text_color = emulsion_text_color(newval);
            emulsion_general_text_color.set(text_color);
            emulsion_general_link_hover_color.set(text_color);

            if ('#ffffff' == text_color) {
                emulsion_general_link_color.set('#cccccc');
            } else {
                emulsion_general_link_color.set('#666666');
            }
        });
    });
    /**
     * customizer value conditional change
     */
    wp.customize('emulsion_header_layout', 'emulsion_title_in_header', function (emulsion_header_layout, emulsion_title_in_header) {
        emulsion_header_layout.bind(function (newval) {
            if ('custom' !== newval) {
                emulsion_title_in_header.set('no');

                var code = 'header-image-info';
                wp.customize.section('header_image').notifications.add(code, new wp.customize.Notification(code, {
                    dismissible: true,
                    message: emulsion_customizer_controle.code_header_image_notification,
                    type: 'warning'
                }));

            }
        });
    });

   var emulsion_alignwide_post_id = parseInt(emulsion_customizer_controle.alignwide_post_id, 10);

    if (Number.isInteger(emulsion_alignwide_post_id) && 0 < emulsion_alignwide_post_id) {

        wp.customize.section('emulsion_section_block_editor_alignwide', function (section) {
            section.expanded.bind(function (isExpanded) {
                if (isExpanded && PREVIEW_REDIRECT == "enable") {
                    var code = 'redirect';
                    var url = wp.customize.settings.url.home + '?p=' + emulsion_alignwide_post_id;
                    var section = 'emulsion_section_block_editor_alignwide';
                    var message = emulsion_customizer_controle.code_section_block_editor_alignwide_notification;
                    emulsion_redirect_notification(section, message, url, code);

                }
            });
        });
    } else {
        wp.customize.section('emulsion_section_block_editor_alignwide', function (section) {
            section.expanded.bind(function (isExpanded) {
                var url;
                if (isExpanded) {
                    var code = 'not_found';
                    wp.customize.section('emulsion_section_block_editor_alignwide').notifications.add(code, new wp.customize.Notification(code, {
                        dismissible: true,
                        message: emulsion_customizer_controle.code_section_block_editor_not_found_notification,
                        type: 'warning'
                    }));
                }
            });
        });
    }

    var emulsion_gallery_post_id = parseInt(emulsion_customizer_controle.galley_post_id, 10);

    if (Number.isInteger(emulsion_gallery_post_id) && 0 < emulsion_gallery_post_id) {
        wp.customize.section('emulsion_section_block_editor_box_gap', function (section) {
            section.expanded.bind(function (isExpanded) {
                if (isExpanded && PREVIEW_REDIRECT == "enable") {
                    var code = 'redirect';
                    var emulsion_gallery_post_id = parseInt(emulsion_customizer_controle.galley_post_id, 10);
                    var url = wp.customize.settings.url.home + '?p=' + emulsion_gallery_post_id;
                    var section = 'emulsion_section_block_editor_box_gap';
                    var message = emulsion_customizer_controle.code_section_block_editor_box_gap_notification;
                    emulsion_redirect_notification(section, message, url, code);

                }
            });
        });
    } else {
        wp.customize.section('emulsion_section_block_editor_box_gap', function (section) {
            section.expanded.bind(function (isExpanded) {
                if (isExpanded) {
                    var code = 'not_found';
                    wp.customize.section('emulsion_section_block_editor_box_gap').notifications.add(code, new wp.customize.Notification(code, {
                        dismissible: true,
                        message: emulsion_customizer_controle.code_section_block_editor_not_found_notification,
                        type: 'warning'
                    }));
                }
            });
        });
    }

    var emulsion_gallery_post_id = parseInt(emulsion_customizer_controle.galley_post_id, 10);

    if (Number.isInteger(emulsion_gallery_post_id) && 0 < emulsion_gallery_post_id) {
        wp.customize.section('emulsion_section_block_editor_block_gallery', function (section) {
            section.expanded.bind(function (isExpanded) {
                if (isExpanded && PREVIEW_REDIRECT == "enable") {
                    var code = 'redirect';
                    var emulsion_gallery_post_id = parseInt(emulsion_customizer_controle.galley_post_id, 10);
                    var url = wp.customize.settings.url.home + '?p=' + emulsion_gallery_post_id;
                    var section = 'emulsion_section_block_editor_block_gallery';
                    var message = emulsion_customizer_controle.code_section_block_editor_block_gallery_notification;
                    emulsion_redirect_notification(section, message, url, code);
                }
            });
        });
    } else {
        wp.customize.section('emulsion_section_block_editor_block_gallery', function (section) {
            section.expanded.bind(function (isExpanded) {
                var url;
                if (isExpanded) {
                    var code = 'not_found';
                    wp.customize.section('emulsion_section_block_editor_block_gallery').notifications.add(code, new wp.customize.Notification(code, {
                        dismissible: true,
                        message: emulsion_customizer_controle.code_section_block_editor_not_found_notification,
                        type: 'warning'
                    }));
                }
            });
        });
    }

    var emulsion_columns_post_id = parseInt(emulsion_customizer_controle.columns_post_id, 10);

    if (Number.isInteger(emulsion_columns_post_id) && 0 < emulsion_columns_post_id) {

        wp.customize.section('emulsion_section_block_editor_block_columns', function (section) {
            section.expanded.bind(function (isExpanded) {
                if (isExpanded && PREVIEW_REDIRECT == "enable") {
                    var code = 'redirect';
                    var emulsion_columns_post_id = parseInt(emulsion_customizer_controle.columns_post_id, 10);
                    var url = wp.customize.settings.url.home + '?p=' + emulsion_columns_post_id;
                    var section = 'emulsion_section_block_editor_block_columns';
                    var message = emulsion_customizer_controle.code_section_block_editor_block_columns_notification;
                    emulsion_redirect_notification(section, message, url, code);
                }
            });
        });
    } else {
        wp.customize.section('emulsion_section_block_editor_block_columns', function (section) {
            section.expanded.bind(function (isExpanded) {
                var url;
                if (isExpanded) {
                    var code = 'not_found';
                    wp.customize.section('emulsion_section_block_editor_block_columns').notifications.add(code, new wp.customize.Notification(code, {
                        dismissible: true,
                        message: emulsion_customizer_controle.code_section_block_editor_not_found_notification,
                        type: 'warning'
                    }));

                }
            });
        });
    }
  
    var emulsion_media_text_post_id = parseInt(emulsion_customizer_controle.media_text_post_id, 10);

    if (Number.isInteger(emulsion_media_text_post_id) && 0 < emulsion_media_text_post_id) {
        wp.customize.section('emulsion_section_block_editor_block_media_text', function (section) {
            section.expanded.bind(function (isExpanded) {
                if (isExpanded && PREVIEW_REDIRECT == "enable") {
                    var code = 'redirect';
                    var emulsion_media_text_post_id = parseInt(emulsion_customizer_controle.media_text_post_id, 10);
                    var url = wp.customize.settings.url.home + '?p=' + emulsion_media_text_post_id;
                    var section = 'emulsion_section_block_editor_block_media_text';
                    var message = emulsion_customizer_controle.code_section_block_editor_block_media_text_notification;
                    emulsion_redirect_notification(section, message, url, code);

                }
            });
        });
    } else {
        wp.customize.section('emulsion_section_block_editor_block_media_text', function (section) {
            section.expanded.bind(function (isExpanded) {
                var url;
                if (isExpanded) {
                    var code = 'not_found';
                    wp.customize.section('emulsion_section_block_editor_block_media_text').notifications.add(code, new wp.customize.Notification(code, {
                        dismissible: true,
                        message: emulsion_customizer_controle.code_section_block_editor_not_found_notification,
                        type: 'warning'
                    }));
                }
            });
        });
    }

    /**
     * Notification
     */

    $(document).ready(function (type) {
        //Notification type: 'none', 'error', 'warning', 'info', 'success'
        var code = 'widget-panel-info';
        wp.customize.panel('widgets').notifications.add(code, new wp.customize.Notification(code, {
            dismissible: true,
            message: emulsion_customizer_controle.code_widgets_panel_notification,
            type: 'info'
        }));

    });

    wp.customize('emulsion_category_colors', function (setting) {
        setting.bind(function (value) {
            var code = 'category colors';

            if ('enable' == value) {

                url = wp.customize.settings.url.home + '?cat=1';
                wp.customize.previewer.previewUrl.set(url);

                setTimeout(function () {
                    $('.emulsion_fadeout_message_category_colors').fadeOut();
                }, 5000);

                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_fadeout_message_category_colors
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });

    wp.customize('emulsion_reset_theme_settings', function (setting) {
        setting.bind(function (value) {
            var code = 'reset_theme_setting';

            if ('reset' == value) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_reset_theme_setting_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });
    wp.customize('emulsion_block_media_text_section_bg', function (setting) {
        setting.bind(function (value) {
            var code = 'media_text_not_found';
            var emulsion_media_text_post_id = parseInt(emulsion_customizer_controle.media_text_post_id, 10);

            if (!Number.isInteger(emulsion_media_text_post_id)) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_media_text_not_found_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });

    wp.customize('emulsion_block_media_text_section_height', function (setting) {
        setting.bind(function (value) {
            var code = 'media_text_not_found';
            var emulsion_media_text_post_id = parseInt(emulsion_customizer_controle.media_text_post_id, 10);

            if (!Number.isInteger(emulsion_media_text_post_id)) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_media_text_not_found_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });
    wp.customize('emulsion_block_columns_section_bg', function (setting) {
        setting.bind(function (value) {
            var code = 'columns_not_found';
            var emulsion_columns_post_id = parseInt(emulsion_customizer_controle.columns_post_id, 10);

            if (!Number.isInteger(emulsion_columns_post_id)) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_columns_not_found_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });
    wp.customize('emulsion_block_columns_section_height', function (setting) {
        setting.bind(function (value) {
            var code = 'columns_not_found';
            var emulsion_columns_post_id = parseInt(emulsion_customizer_controle.columns_post_id, 10);

            if (!Number.isInteger(emulsion_columns_post_id)) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_columns_not_found_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });
    wp.customize('emulsion_block_gallery_section_bg', function (setting) {
        setting.bind(function (value) {
            var code = 'gallery_not_found';
            var emulsion_gallery_post_id = parseInt(emulsion_customizer_controle.galley_post_id, 10);

            if (!Number.isInteger(emulsion_gallery_post_id)) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_gallery_not_found_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });
    wp.customize('emulsion_block_gallery_section_height', function (setting) {
        setting.bind(function (value) {
            var code = 'gallery_not_found';
            var emulsion_gallery_post_id = parseInt(emulsion_customizer_controle.galley_post_id, 10);

            if (!Number.isInteger(emulsion_gallery_post_id)) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_gallery_not_found_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });
    wp.customize('emulsion_box_gap', function (setting) {
        setting.bind(function (value) {
            var code = 'box_gap_not_found';
            var emulsion_gallery_post_id = parseInt(emulsion_customizer_controle.galley_post_id, 10);

            if (!Number.isInteger(emulsion_gallery_post_id)) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_box_gap_not_found_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });
    wp.customize('emulsion_main_width', function (setting) {
        setting.bind(function (value) {
            var code = 'narrow_width';
            var content_width = wp.customize('emulsion_content_width').get();
            if (parseInt(value) < parseInt(content_width)) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_narrow_width_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });

    wp.customize('emulsion_content_width', function (setting) {
        setting.bind(function (value) {
            var code = 'too_width';
            var main_width = wp.customize('emulsion_main_width').get();
            if (parseInt(value) > parseInt(main_width)) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_too_width_notification
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });

    wp.customize('emulsion_header_layout', function (setting) {
        setting.bind(function (value) {
            var code = 'relate_setting_alert';
            if ('self' == value || 'simple' == value) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: emulsion_customizer_controle.code_relate_setting_alert
                        }
                ));
            } else {
                setting.notifications.remove(code);
            }
        });
    });

    /**
     * Alternative to Active Callback
     *  active callback works only refresh
     */

    wp.customize.bind('ready', function () {

        wp.customize('emulsion_header_gradient', function (emulsion_header_gradient) {
            emulsion_header_gradient.bind(function (newval) {

                if ('enable' !== newval) {
                    $('#customize-control-emulsion_header_sub_background_color').css({'visibility': 'hidden'});
                }
                if ('enable' == newval) {
                    $('#customize-control-emulsion_header_sub_background_color').css({'visibility': 'visible'});
                }
            });
        });
    });

})(jQuery);
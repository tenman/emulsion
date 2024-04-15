/**
 * todo: Currently blockVariation titles cannot be internationalized
 *
 */
wp.blocks.registerBlockVariation(
        'core/list', {
            name: 'ol',
            title: wp.i18n.__('ol', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: '',
                className: '',
                "ordered": true,
            },
            keywords: [wp.i18n.__('ol', 'emulsion')]
        }
);
wp.blocks.registerBlockVariation(
        'core/list', {
            name: 'ul',
            title: wp.i18n.__('ul', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: '',
                className: ''
            },
            keywords: [wp.i18n.__('ul', 'emulsion')]
        }
);

wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'section',
            title: wp.i18n.__('section', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: 'full',
                className: '',
                "tagName": "section"
            },
            keywords: [wp.i18n.__('section', 'emulsion')]
        }
);
wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'aside',
            title: wp.i18n.__('aside', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: 'full',
                className: '',
                "tagName": "aside"
            },
            keywords: [wp.i18n.__('aside', 'emulsion')]
        }
);
wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'div',
            title: wp.i18n.__('div', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: 'full',
                className: ''
            },
            keywords: [wp.i18n.__('div', 'emulsion')]
        }
);

wp.blocks.registerBlockVariation(
        'core/heading', {
            name: 'h2',
            title: wp.i18n.__('h2', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: '',
                className: '',
                level: 2
            },
            keywords: [wp.i18n.__('h2', 'emulsion')]
        }
);
wp.blocks.registerBlockVariation(
        'core/heading', {
            name: 'h3',
            title: wp.i18n.__('h3', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: '',
                className: '',
                level: 3
            },
            keywords: [wp.i18n.__('h3', 'emulsion')]
        }
);
wp.blocks.registerBlockVariation(
        'core/heading', {
            name: 'h4',
            title: wp.i18n.__('h4', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: '',
                className: '',
                level: 4
            },
            keywords: [wp.i18n.__('h4', 'emulsion')]
        }
);
wp.blocks.registerBlockVariation(
        'core/heading', {
            name: 'h5',
            title: wp.i18n.__('h5', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: '',
                className: '',
                level: 5
            },
            keywords: [wp.i18n.__('h5', 'emulsion')]
        }
);
wp.blocks.registerBlockVariation(
        'core/heading', {
            name: 'h6',
            title: wp.i18n.__('h6', 'emulsion'),
            icon: 'html',
            scope: ['inserter'],
            attributes: {
                align: '',
                className: '',
                level: 6
            },
            keywords: [wp.i18n.__('h6', 'emulsion')]
        }
);

wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'emulsion-panel',
            title: wp.i18n.__('Panel', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
            keywords: ["emulsion", "container", "wrapper", "panel"],
            innerBlocks: [

                ['core/heading', {level: 3, placeholder: 'Panel Title', className: 'emulsion-panel-title'}],
                ['core/group', {className: 'emulsion-panel-content'}, [
                        ['core/paragraph', {placeholder: 'content'}]
                    ]]

            ],
            attributes: {
                className: 'emulsion-panel solid-border'
            },
            keywords: [wp.i18n.__('panel', 'emulsion')]
        }
);

wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'dropdown-on-hover',
            title: wp.i18n.__('Dropdown on hover', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
            keywords: ["emulsion", "container", "wrapper", "panel", "dropdown"],
            innerBlocks: [
                ['core/paragraph', {placeholder: 'Dropdown Title', className: 'dropdown-on-hover-title'}],
                ['core/group', {className: 'dropdown-on-hover-content'}, [
                        ['core/paragraph', {placeholder: 'content'}]
                    ]]
            ],
            attributes: {
                className: 'dropdown-on-hover'
            },
            keywords: [wp.i18n.__('dropdown', 'emulsion')]
        }
);
wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'dropdown-on-click',
            title: wp.i18n.__('Dropdown on click', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
            keywords: ["emulsion", "container", "wrapper", "panel", "dropdown"],
            innerBlocks: [
                ['core/paragraph', {placeholder: 'Dropdown Title', className: 'dropdown-on-click-title'}],
                ['core/group', {className: 'dropdown-on-click-content'}, [
                        ['core/paragraph', {placeholder: 'content'}]
                    ]]
            ],
            attributes: {
                className: 'dropdown-on-click'
            },
            keywords: [wp.i18n.__('dropdown', 'emulsion')]
        }
);

/**
 * editor button
 * @param {type} wp
 * @returns {undefined}
 */

(function (wp) {
    var emulsionTextEmphasisButton = function (props) {
        return wp.element.createElement(
                wp.blockEditor.RichTextToolbarButton,
                {
                    icon: 'admin-customizer',
                    title: wp.i18n.__('Text Emphasis', 'emulsion'),
                    onClick: function () {
                        props.onChange(
                                wp.richText.toggleFormat(
                                        props.value,
                                        {
                                            type: 'emulsion/text-emphasis',
                                        }
                                )
                                );
                        props.onFocus();
                    },
                }
        );
    }

    wp.richText.registerFormatType(
            'emulsion/text-emphasis',
            {
                title: wp.i18n.__('Text Emphasis', 'emulsion'),
                tagName: 'span',
                className: 'text-emphasis',
                edit: emulsionTextEmphasisButton
            }
    );
})(window.wp);




function emulsionGetParameterByName(name, url = window.location.href) {

    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

document.addEventListener("DOMContentLoaded", function () {
    var body = document.body;
    if (body.classList.contains('site-editor-php') && emulsionGetParameterByName('notice')) {
        window.wp.data.dispatch('core/notices').createNotice(
                'warning',
                wp.i18n.__('A PHP template has been applied. <br />Style changes will be reflected, but the template cannot be edited.', 'emulsion'),
                {
                    __unstableHTML: true, // true = allows HTML; default false
                    isDismissible: true,
                    actions: [
                        {
                            url: 'customize.php?autofocus[section]=emulsion_editor',
                            label: 'Change setting in Customizer',
                        },
                    ],
                }
        )
    }


});

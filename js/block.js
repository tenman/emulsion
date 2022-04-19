/**
 * todo: Currently blockVariation titles cannot be internationalized
 *
 */
//https://github.com/WordPress/gutenberg/issues/33374
wp.blocks.registerBlockVariation(
        'core/group',
        {
            isDefault: true,
            attributes: {
                layout: {
                    inherit: true,
                }
            }
        }
);
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
            }
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
            }
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
            }
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
            }
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
            }
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
            }
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
            }
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
            }
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
            }
        }
);
wp.blocks.registerBlockVariation(
        'core/columns', {
            name: 'cta-block',
            title: wp.i18n.__('CTA Block', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
            keywords: ["emulsion", "columns", "call to action", "cta"],
            innerBlocks: [
                ['core/column', {}, [
                        ['core/image'],
                        ['core/heading', {level: 3, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description'}],
                        ['core/buttons']
                    ]],
                ['core/column', {}, [
                        ['core/image'],
                        ['core/heading', {level: 3, placeholder: 'Title'}],
                        ['core/paragraph', {placeholder: 'description'}],
                        ['core/buttons']
                    ]],
                ['core/column', {}, [
                        ['core/image'],
                        ['core/heading', {level: 3, placeholder: 'Title'}],
                        ['core/paragraph', {placeholder: 'description'}],
                        ['core/buttons']
                    ]]
            ],
            attributes: {
                className: 'emulsion-cta-block'
            }
        }
);

wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'grid-group-2col',
            title: wp.i18n.__('Group Grid 2', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
            keywords: ["emulsion", "container", "wrapper", "grid", "2column", "photo", "image", "img"],
            innerBlocks: [
                ['core/group', {className: 'size1of2'}, [
                        ['core/image', {className: 'alignfull'}]
                    ]],
                ['core/group', {className: 'size1of2 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]]

            ],
            attributes: {
                align: 'full',
                className: 'grid grid-group-2col grid-group'
            }
        }
);

wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'grid-group-3col',
            title: wp.i18n.__('Group Grid 3', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
            keywords: ["emulsion", "container", "wrapper", "grid", "3column"],
            innerBlocks: [
                ['core/group', {className: 'size1of3 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]],
                ['core/group', {className: 'size1of3 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]],
                ['core/group', {className: 'size1of3 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]]

            ],
            attributes: {
                align: 'full',
                className: 'grid grid-group-3col grid-group'
            }
        }
);
wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'grid-group-4col',
            title: wp.i18n.__('Group Grid 4', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
            keywords: ["emulsion", "container", "wrapper", "grid", "4column"],
            innerBlocks: [
                ['core/group', {className: 'size1of4 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]],
                ['core/group', {className: 'size1of4 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]],
                ['core/group', {className: 'size1of4 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]],
                ['core/group', {className: 'size1of4 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]]

            ],
            attributes: {
                align: 'full',
                className: 'grid grid-group-4col grid-group'
            }
        }
);
wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'grid-group-5col',
            title: wp.i18n.__('Group Grid 5', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
            keywords: ["emulsion", "container", "wrapper", "grid", "5column"],
            innerBlocks: [
                ['core/group', {className: 'size1of5 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]],
                ['core/group', {className: 'size1of5 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]],
                ['core/group', {className: 'size1of5 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]],
                ['core/group', {className: 'size1of5 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]],
                ['core/group', {className: 'size1of5 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]]

            ],
            attributes: {
                align: 'full',
                className: 'grid grid-group-5col grid-group'
            }
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

                ['core/heading', {level: 4, placeholder: 'Panel Title', className: 'emulsion-panel-title'}],
                ['core/group', {className: 'emulsion-panel-content'}, [
                        ['core/paragraph', {placeholder: 'content'}]
                    ]]

            ],
            attributes: {
                className: 'emulsion-panel solid-border'
            }
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
            }
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
            }
        }
);
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
    // Todo: 5.9.3 not work this notices (customizer site editor link has postType)
    //5.8
    if (body.classList.contains('site-editor-php') && body.classList.contains('is-presentation-theme') && !emulsionGetParameterByName('postType')) {
        window.wp.data.dispatch('core/notices').createNotice(
                'warning',
                'The settings made here will not take effect unless you change the theme settings.<br /> Please open the customizer from the link below and select <b>Full Site Editing Theme or FSE Transitional Theme</b>.',
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
    //for 5.9
    if (body.classList.contains('appearance_page_gutenberg-edit-site') && body.classList.contains('is-presentation-theme') && !emulsionGetParameterByName('postType')) {
        window.wp.data.dispatch('core/notices').createNotice(
                'warning',
                'The settings made here will not take effect unless you change the theme settings.<br /> Please open the customizer from the link below and select <b>Full Site Editing Theme or FSE Transitional Theme</b>.',
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
    if (body.classList.contains('widgets-php') && body.classList.contains('is-presentation-fse')) {
        window.wp.data.dispatch('core/notices').createNotice(
                'warning',
                'The settings made here will not take effect unless you change the theme settings.<br />Please open the customizer from the link below and select <b>FSE Transitional Theme or Classic Theme</b>.',
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

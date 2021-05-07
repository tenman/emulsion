wp.blocks.registerBlockVariation(
        'core/columns', {
            name: 'cta-block',
            title: wp.i18n.__('CTA Block', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
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
            innerBlocks: [
                ['core/group', {className: 'size1of2'}, [
                        ['core/image']
                    ]],
                ['core/group', {className: 'size1of2 centered'}, [
                        ['core/heading', {level: 2, placeholder: 'Title', align: 'center'}],
                        ['core/paragraph', {placeholder: 'description', align: 'center'}]
                    ]]

            ],
            attributes: {
                align: 'full',
                className: 'grid'
            }
        }
);

wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'grid-group-3col',
            title: wp.i18n.__('Group Grid 3', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
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
                className: 'grid'
            }
        }
);
wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'grid-group-4col',
            title: wp.i18n.__('Group Grid 4', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
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
                className: 'grid'
            }
        }
);
wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'grid-group-5col',
            title: wp.i18n.__('Group Grid 5', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
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
                className: 'grid'
            }
        }
);
wp.blocks.registerBlockVariation(
        'core/group', {
            name: 'emulsion-panel',
            title: wp.i18n.__('Panel', 'emulsion'),
            icon: 'admin-appearance',
            scope: ['inserter'],
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
jQuery(function ($) {

    $(".is-style-sticky").parents().css("overflow", "visible");
    
});
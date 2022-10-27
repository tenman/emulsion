document.addEventListener('DOMContentLoaded', function (event) {

    /**
     * Block Variation
     * @see lig/blocks.php
     */

    wp.blocks.unregisterBlockVariation('core/columns', 'cta-block');
    wp.blocks.unregisterBlockVariation('core/group', 'grid-group-2col');
    wp.blocks.unregisterBlockVariation('core/group', 'grid-group-3col');
    wp.blocks.unregisterBlockVariation('core/group', 'grid-group-4col');
    wp.blocks.unregisterBlockVariation('core/group', 'grid-group-5col');
    wp.blocks.unregisterBlockStyle('core/paragraph', 'hanging-indent');
    wp.blocks.unregisterBlockStyle('core/paragraph', 'indent-15rem');

    /**
     * Block Style
     * @see lig/blocks.php
     */

    wp.blocks.unregisterBlockStyle('core/list', 'list-style-initial');
    wp.blocks.unregisterBlockStyle('core/list', 'circle-mask');

    wp.blocks.registerBlockStyle('core/image', {
        name: 'fit-wide',
        label: 'Align Offset Wide',
        isDefault: false
    });
    wp.blocks.registerBlockStyle('core/gallery', {
        name: 'fit-wide',
        label: 'Align Offset Wide',
        isDefault: false
    });
    wp.blocks.registerBlockStyle('core/gallery', {
        name: 'shrink',
        label: 'Align Offset Zero',
        isDefault: false
    });
    wp.blocks.registerBlockStyle('core/group', {
        name: 'layout-flow',
        label: 'Flow Layout',
        isDefault: false
    });

});

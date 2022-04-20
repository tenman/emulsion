document.addEventListener('DOMContentLoaded', function (event) {

    wp.blocks.unregisterBlockVariation('core/columns', 'cta-block');

    //Gutenberg 12.9.0 The following variations cannot be removed at this time

    wp.blocks.unregisterBlockVariation('core/group', 'grid-group-2col');
    wp.blocks.unregisterBlockVariation('core/group', 'grid-group-3col');
    wp.blocks.unregisterBlockVariation('core/group', 'grid-group-4col');
    wp.blocks.unregisterBlockVariation('core/group', 'grid-group-5col');

    //style
    wp.blocks.unregisterBlockStyle('core/list', 'list-style-initial');
    wp.blocks.unregisterBlockStyle('core/list', 'circle-mask');

    //Gutenberg 12.9.0 The following variations cannot be removed at this time

    wp.blocks.unregisterBlockStyle('core/paragraph', 'hanging-indent');
    wp.blocks.unregisterBlockStyle('core/paragraph', 'indent-15rem');


});
(function () {
    /**
     *
     * @type NodeList
     */
    var tab_index_class = document.querySelectorAll('.dropdown-on-hover, .dropdown-on-click, .modal-open-link > .wp-block-button');
    for (var i = 0; i < tab_index_class.length; i++) {
        tab_index_class[i].setAttribute("tabindex", 0);
    }
    /**
     *
     * @returns {undefined}
     */

    document.getElementsByClassName('modal-close-link').onclick = function emulsionAddClass() {

        window.location.href.split('#')[0];
    }
    if (document.querySelector(".modal-open-link > .wp-block-button") !== null) {

        document.querySelector(".modal-open-link > .wp-block-button").onclick = function focus_modal_open_link() {
            document.querySelector(".modal-open-link > .wp-block-button").focus();
            document.querySelector(".modal-open-link + .modal").classList.add('is-opened');
        }
    }

    /**
     *
     * @type NodeList
     */

    var wp_block_column_class = document.getElementsByClassName('wp-block-column is-style-sticky');
    if (wp_block_column_class.length) {

        var sticky_exception = document.querySelectorAll('.wp-block-group,.wp-block-post-content,.wp-block-template-part');
        for (var i = 0; i < sticky_exception.length; i++) {
            sticky_exception[i].style.overflow = 'visible';
        }
    }



}());

(function () {
    const tab_list = document.querySelectorAll('.list-style-tab > li');

    tab_list.forEach(function (val, index) {
        console.log(val);
        val.setAttribute('tabindex', '0');
        val.setAttribute('role', 'tab');
        val.parentNode.setAttribute('tabindex', '0');
        val.parentNode.setAttribute('role', 'tablist');
        val.parentNode.classList.add('success-js');

        val.addEventListener('focusin', (event) => {

            var height = Math.round(event.target.firstElementChild.clientHeight) + 36;

            event.target.style.marginBottom = height + 'px';
            event.target.setAttribute('aria-selected', 'true');
            event.target.classList.add('active');

        });
        val.addEventListener('focusout', (event) => {
            event.target.style.background = '';
            event.target.classList.remove('active');
        });
    });


}());
window.addEventListener('DOMContentLoaded', function () {

    window.addEventListener('scroll', function () {
        /*
         elements.classList.add(‘className’)
         elements.classList.remove(‘className’)
         elements.classList.toggle(‘className’)
         elements.classList.contains(‘className’)
         */
        var scrolle_y = window.scrollY;
        var offset_primary_menu = document.querySelector('.fse-header').clientHeight;
        var body_element = document.getElementsByTagName('body');

        if (parseInt(scrolle_y) < parseInt(offset_primary_menu) || parseInt(scrolle_y) < 20) {
            body_element[0].classList.remove('on-scroll');
        }
        if (parseInt(scrolle_y) > parseInt(offset_primary_menu)) {
            body_element[0].classList.add('on-scroll');
        }

    });
});
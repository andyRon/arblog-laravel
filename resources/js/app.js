import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


/**
 * Blog Javascript
 * Copied from Clean Blog v1.0.0 (http://startbootstrap.com)
 * 这段代码实现了 tooltips，并且在用户滚动页面时将导航条悬浮在页面顶部。
 */

// Navigation Scripts to Show Header on Scroll-Up
jQuery(document).ready(function ($) {
    var MQL = 1170;

    //primary navigation slide-in effect
    if ($(window).width() > MQL) {
        var headerHeight = $('.navbar-custom').height();
        $(window).on('scroll', {
                previousTop: 0
            },
            function () {
                var currentTop = $(window).scrollTop();

                //if user is scrolling up
                if (currentTop < this.previousTop) {
                    if (currentTop > 0 && $('.navbar-custom').hasClass('is-fixed')) {
                        $('.navbar-custom').addClass('is-visible');
                    } else {
                        $('.navbar-custom').removeClass('is-visible is-fixed');
                    }
                    //if scrolling down...
                } else {
                    $('.navbar-custom').removeClass('is-visible');
                    if (currentTop > headerHeight && !$('.navbar-custom').hasClass('is-fixed')) {
                        $('.navbar-custom').addClass('is-fixed');
                    }
                }
                this.previousTop = currentTop;
            });
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});

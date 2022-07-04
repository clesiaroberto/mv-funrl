// ------------------------------------------------------------------------------ //
//
// Name website : MovelCare
// Categorie : E-commerce
// Author : Clésia Chale
// Version : v.1.0.6
// Created : 2020-11-11
// Last update : 2021-05-28
//
// ------------------------------------------------------------------------------ //

$(document).ready(function() {
	/*-------------------
		Fixed Menu
	--------------------- */
	$(window).on('scroll', function() {
		if ($(window).scrollTop() > 100) {
			$('.main-header').addClass('fixed-menu');
		} else {
			$('.main-header').removeClass('fixed-menu');
		}
	});
});

$(function() {
    $('.lazy').lazy({
        scrollDirection: 'vertical',
        effect: "fadeIn",
        visibleOnly: true,
        effectTime: 2000,
        threshold: 0
    });
});
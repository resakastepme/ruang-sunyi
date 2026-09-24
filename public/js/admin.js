/*
 * Ruang Sunyi — Admin Panel (jQuery)
 * Toggle lampiran editor, penghitung kata, dan show/hide password login.
 */
$(function () {
    'use strict';

    // Toggle boks lampiran (kutipan / gambar) via data-attribute -----------
    $('[data-toggle-box]').on('click', function () {
        var target = $(this).attr('data-toggle-box');
        $(target).toggleClass('d-none');
    });

    // Penghitung kata pada composer ---------------------------------------
    var $counter = $('#wordCounter');
    $('#mainComposerText').on('input', function () {
        var value = $.trim($(this).val());
        var words = value === '' ? 0 : value.split(/\s+/).length;
        $counter.text(words);
    });

    // Show / hide password (halaman login) --------------------------------
    $('#togglePassword').on('click', function () {
        var $input = $('#password');
        var toText = $input.attr('type') === 'password';
        $input.attr('type', toText ? 'text' : 'password');
        $(this).find('i').toggleClass('bi-eye bi-eye-slash');
    });
});

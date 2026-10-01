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

    // Putuskan YouTube — submit lewat form dinamis (hindari <form> nested) --
    $('#yt-disconnect').on('click', function () {
        if (!window.confirm('Disconnect YouTube?')) {
            return;
        }
        var token = $('meta[name="csrf-token"]').attr('content');
        $('<form method="POST">')
            .attr('action', $(this).data('url'))
            .append($('<input type="hidden" name="_token">').val(token))
            .appendTo('body')
            .trigger('submit');
    });

    // Show / hide password (halaman login) --------------------------------
    $('#togglePassword').on('click', function () {
        var $input = $('#password');
        var toText = $input.attr('type') === 'password';
        $input.attr('type', toText ? 'text' : 'password');
        $(this).find('i').toggleClass('bi-eye bi-eye-slash');
    });
});

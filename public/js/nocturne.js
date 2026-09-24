/*
 * Ruang Sunyi — logika interaktif (jQuery)
 * Filter kategori, tombol reaksi, dan form "salam" anonim.
 */
$(function () {
    'use strict';

    // Filter kategori -----------------------------------------------------
    $('.btn-pill-filter').on('click', function () {
        var category = $(this).attr('data-category');

        $('.btn-pill-filter').removeClass('active');
        $(this).addClass('active');

        $('.feed-entry').each(function () {
            if (category === 'all') {
                $(this).show();
                return;
            }

            var tags = $(this).attr('data-tags') || '';
            $(this).toggle(tags.indexOf(category) !== -1);
        });
    });

    // Toggle reaksi -------------------------------------------------------
    $('.btn-reaction').on('click', function () {
        var $btn = $(this);
        var $counter = $btn.find('.font-mono-code');

        if (!$counter.length) {
            return;
        }

        var count = parseInt($counter.text(), 10) || 0;

        if ($btn.hasClass('active')) {
            $btn.removeClass('active');
            $counter.text(Math.max(0, count - 1));
        } else {
            $btn.addClass('active');
            $counter.text(count + 1);
        }
    });

    // Kirim salam anonim --------------------------------------------------
    var $feedback = $('#salam-feedback');
    var feedbackTimer = null;

    $('#send-salam-btn').on('click', function () {
        var $input = $('#anon-input');

        if ($.trim($input.val()) === '') {
            return;
        }

        $input.val('');
        $feedback.removeClass('d-none');

        clearTimeout(feedbackTimer);
        feedbackTimer = setTimeout(function () {
            $feedback.addClass('d-none');
        }, 3500);
    });
});

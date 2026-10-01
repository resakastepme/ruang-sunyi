/*
 * Ruang Sunyi — logika interaktif (jQuery)
 * Filter kategori, tombol reaksi, dan form "salam" anonim.
 */
$(function () {
    'use strict';

    // Filter kategori kini ditangani server-side (tautan pill ?category=...).

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

    // Form "Surat Digital" (halaman Tentang) ------------------------------
    $('#quietNoteForm').on('submit', function (e) {
        e.preventDefault();
        $(this).addClass('d-none');
        $('#thankYouNote').removeClass('d-none');
    });

    // Pratinjau gambar / lightbox (semua halaman) -------------------------
    (function () {
        var $overlay = $(
            '<div class="img-lightbox" aria-hidden="true">' +
                '<button type="button" class="img-lightbox-close" aria-label="Tutup pratinjau">&times;</button>' +
                '<img src="" alt="Preview">' +
            '</div>'
        );
        var $overlayImg = $overlay.find('img');
        $('body').append($overlay);

        function openPreview(src, alt) {
            if (!src) {
                return;
            }
            $overlayImg.attr('src', src).attr('alt', alt || 'Preview');
            $overlay.addClass('show').attr('aria-hidden', 'false');
            $('body').addClass('overflow-hidden');
        }

        function closePreview() {
            $overlay.removeClass('show').attr('aria-hidden', 'true');
            $('body').removeClass('overflow-hidden');
            $overlayImg.attr('src', '');
        }

        // Delegasi: gambar statis maupun yang ditambah dinamis ikut bekerja.
        $(document).on('click', '.img-preview', function () {
            var $img = $(this);
            openPreview($img.data('preview-src') || $img.attr('src'), $img.attr('alt'));
        });

        // Klik backdrop / tombol close menutup; klik gambar tidak.
        $overlay.on('click', function (e) {
            if (e.target !== $overlayImg[0]) {
                closePreview();
            }
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && $overlay.hasClass('show')) {
                closePreview();
            }
        });
    })();

    // Ruang komentar — delegasi, mendukung banyak instance, tersimpan ke DB --
    // Setiap .comment-section bekerja mandiri (mis. di tiap kartu linimasa).
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Tampilkan input nama hanya saat memilih "Use a name".
    $(document).on('change', '.comment-identity', function () {
        var $section = $(this).closest('.comment-section');
        var $wrap    = $section.find('.comment-username-wrap');

        if ($(this).val() === 'named') {
            $wrap.removeClass('d-none');
            $section.find('.comment-username').trigger('focus');
        } else {
            $wrap.addClass('d-none');
        }
    });

    // Bangun satu elemen komentar dari data server.
    function buildCommentItem(data) {
        var $avatar = $('<div class="comment-avatar"></div>');
        if (data.is_anonymous) {
            $avatar.html('<i class="bi bi-incognito"></i>');
        } else {
            $avatar.text((data.name || 'A').charAt(0).toUpperCase());
        }

        var $head = $('<div class="d-flex align-items-center justify-content-between gap-2 mb-1"></div>')
            .append($('<span class="fw-semibold text-light" style="font-size: 0.9rem;"></span>').text(data.name))
            .append($('<small class="text-muted" style="font-size: 0.72rem;"></small>').text(data.created_at_human || 'just now'));

        var $bubble = $('<div class="comment-bubble"></div>')
            .append($head)
            .append($('<p class="comment-text text-secondary small mb-0"></p>').text(data.body));

        return $('<li class="comment-item"></li>').append($avatar).append($bubble);
    }

    $(document).on('submit', '.comment-form', function (e) {
        e.preventDefault();

        var $form    = $(this);
        var $section = $form.closest('.comment-section');
        var $body    = $section.find('.comment-body');
        var $error   = $section.find('.comment-error');
        var $btn     = $form.find('button[type="submit"]');
        var text     = $.trim($body.val());

        $error.addClass('d-none').text('');

        if (text === '') {
            $body.trigger('focus');
            return;
        }

        $btn.prop('disabled', true);

        $.ajax({
            url: $form.data('store-url'),
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: {
                scope:       $section.data('scope'),
                identity:    $section.find('.comment-identity').val(),
                author_name: $section.find('.comment-username').val(),
                body:        text
            }
        }).done(function (data) {
            var $list = $section.find('.comment-list');
            $list.removeClass('d-none').addClass('d-flex').prepend(buildCommentItem(data));
            $section.find('.comment-empty').addClass('d-none');
            $section.find('.comment-count').text($list.children().length);

            // Reset form ke keadaan anonim.
            $body.val('');
            $section.find('.comment-username').val('');
            $section.find('.comment-identity').val('anonymous');
            $section.find('.comment-username-wrap').addClass('d-none');
        }).fail(function (xhr) {
            var msg = 'Failed to post comment. Please try again.';
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = xhr.responseJSON.errors;
                msg = errors[Object.keys(errors)[0]][0];
            }
            $error.text(msg).removeClass('d-none');
        }).always(function () {
            $btn.prop('disabled', false);
        });
    });
});

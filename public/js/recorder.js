/*
 * Nocturne Notes — perekam video in-browser (admin).
 * Pilih kamera & mic, preview live, rekam (MediaRecorder), lalu
 * putar ulang / unduh klip. Auto-upload ke YouTube menyusul setelah
 * OAuth tersambung. Vanilla JS, butuh HTTPS atau localhost.
 */
(function () {
    'use strict';

    var root = document.getElementById('videoRecorder');
    if (!root) {
        return;
    }

    var camSel    = document.getElementById('recCamera');
    var micSel    = document.getElementById('recMic');
    var preview   = document.getElementById('recPreview');
    var playback  = document.getElementById('recPlayback');
    var enableBtn = document.getElementById('recEnable');
    var startBtn  = document.getElementById('recStart');
    var stopBtn   = document.getElementById('recStop');
    var dl        = document.getElementById('recDownload');
    var err       = document.getElementById('recError');

    var uploadBtn     = document.getElementById('recUpload');
    var fileInput     = document.getElementById('recFile');
    var uploadFileBtn = document.getElementById('recUploadFile');
    var uploadStatus  = document.getElementById('recUploadStatus');

    var connected  = root.getAttribute('data-connected') === '1';
    var sessionUrl = root.getAttribute('data-session-url');
    var chunkUrl   = root.getAttribute('data-chunk-url');
    var csrfMeta   = document.querySelector('meta[name="csrf-token"]');
    var csrf       = csrfMeta ? csrfMeta.getAttribute('content') : '';

    var CHUNK_SIZE = 5 * 1024 * 1024; // 5 MB (kelipatan 256KB, aman < post_max_size default)

    var stream = null;
    var recorder = null;
    var chunks = [];
    var blobUrl = null;
    var lastBlob = null;

    function showError(msg) {
        err.textContent = msg;
        err.classList.remove('d-none');
    }

    function clearError() {
        err.textContent = '';
        err.classList.add('d-none');
    }

    // Guard kompatibilitas (butuh secure context: HTTPS atau localhost).
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia || !window.MediaRecorder) {
        enableBtn.disabled = true;
        showError('Browser ini belum mendukung rekam kamera (butuh browser modern via HTTPS atau localhost).');
        return;
    }

    function stopStream() {
        if (stream) {
            stream.getTracks().forEach(function (t) { t.stop(); });
            stream = null;
        }
    }

    function buildConstraints() {
        var c = { video: true, audio: true };
        if (camSel.value) { c.video = { deviceId: { exact: camSel.value } }; }
        if (micSel.value) { c.audio = { deviceId: { exact: micSel.value } }; }
        return c;
    }

    function fillSelect(sel, list, label) {
        var current = sel.value;
        sel.innerHTML = '';
        list.forEach(function (device, i) {
            var opt = document.createElement('option');
            opt.value = device.deviceId;
            opt.textContent = device.label || (label + ' ' + (i + 1));
            sel.appendChild(opt);
        });
        if (current) { sel.value = current; }
    }

    function populateDevices() {
        return navigator.mediaDevices.enumerateDevices().then(function (devices) {
            fillSelect(camSel, devices.filter(function (d) { return d.kind === 'videoinput'; }), 'Camera');
            fillSelect(micSel, devices.filter(function (d) { return d.kind === 'audioinput'; }), 'Microphone');
        });
    }

    // Ambil ulang stream sesuai perangkat terpilih.
    function startStream() {
        stopStream();
        return navigator.mediaDevices.getUserMedia(buildConstraints()).then(function (s) {
            stream = s;
            preview.srcObject = s;
            startBtn.disabled = false;
            clearError();
        }).catch(function (e) {
            showError('Tidak bisa mengakses perangkat: ' + e.message);
        });
    }

    enableBtn.addEventListener('click', function () {
        clearError();
        enableBtn.disabled = true;
        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then(function (s) {
                stream = s;
                preview.srcObject = s;
                startBtn.disabled = false;
                return populateDevices();
            })
            .then(function () {
                enableBtn.textContent = 'Camera ready';
            })
            .catch(function (e) {
                enableBtn.disabled = false;
                showError('Tidak bisa mengakses kamera/mic: ' + e.message);
            });
    });

    camSel.addEventListener('change', startStream);
    micSel.addEventListener('change', startStream);

    startBtn.addEventListener('click', function () {
        if (!stream) { return; }
        chunks = [];
        try {
            // Batasi bitrate agar ukuran file wajar; fallback bila opsi tak didukung.
            try {
                recorder = new MediaRecorder(stream, {
                    videoBitsPerSecond: 2000000,
                    audioBitsPerSecond: 128000,
                });
            } catch (optErr) {
                recorder = new MediaRecorder(stream);
            }
        } catch (e) {
            showError('Perekaman tidak didukung: ' + e.message);
            return;
        }

        recorder.ondataavailable = function (ev) {
            if (ev.data && ev.data.size) { chunks.push(ev.data); }
        };
        recorder.onstop = function () {
            var blob = new Blob(chunks, { type: chunks.length ? chunks[0].type : 'video/webm' });
            lastBlob = blob;
            if (blobUrl) { URL.revokeObjectURL(blobUrl); }
            blobUrl = URL.createObjectURL(blob);
            playback.src = blobUrl;
            playback.classList.remove('d-none');
            dl.href = blobUrl;
            dl.classList.remove('d-none');
            if (connected && uploadBtn) { uploadBtn.classList.remove('d-none'); }
        };

        recorder.start();
        startBtn.disabled = true;
        stopBtn.disabled = false;
        dl.classList.add('d-none');
        playback.classList.add('d-none');
    });

    stopBtn.addEventListener('click', function () {
        if (recorder && recorder.state !== 'inactive') { recorder.stop(); }
        stopBtn.disabled = true;
        startBtn.disabled = false;
    });

    // Upload ke YouTube --------------------------------------------------
    function setStatus(msg, kind) {
        if (!uploadStatus) { return; }
        var tone = kind === 'error' ? 'text-danger' : (kind === 'ok' ? 'text-info' : 'text-secondary');
        uploadStatus.textContent = msg;
        uploadStatus.className = 'small mt-2 ' + tone;
        uploadStatus.classList.remove('d-none');
    }

    function setBusy(busy) {
        if (uploadBtn) { uploadBtn.disabled = busy; }
        if (uploadFileBtn) { uploadFileBtn.disabled = busy; }
    }

    async function postJson(url, payload) {
        var res = await fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        var data = {};
        try { data = await res.json(); } catch (e) { data = {}; }
        if (!res.ok) { throw new Error(data.message || 'Request failed.'); }
        return data;
    }

    // Upload chunked langsung ke sesi resumable (lewat server, same-origin).
    async function uploadToYoutube(file, filename) {
        if (!file) { setStatus('Nothing to upload yet.', 'error'); return; }
        if (!connected) { setStatus('Connect YouTube first (button above).', 'error'); return; }

        setBusy(true);
        setStatus('Preparing upload…', 'info');

        try {
            var init = await postJson(sessionUrl, {
                title: filename || 'nocturne-clip',
                size: file.size,
                mimeType: file.type || 'video/webm'
            });
            var uploadUrl = init.upload_url;

            var start = 0;
            var videoId = null;

            while (start < file.size) {
                var end = Math.min(start + CHUNK_SIZE, file.size);
                var res = await fetch(chunkUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'X-Session-Url': uploadUrl,
                        'X-Chunk-Start': String(start),
                        'X-Total-Size': String(file.size),
                        'Content-Type': 'application/octet-stream',
                        'Accept': 'application/json'
                    },
                    body: file.slice(start, end)
                });
                var data = {};
                try { data = await res.json(); } catch (e) { data = {}; }
                if (!res.ok) { throw new Error(data.message || 'Upload failed.'); }

                setStatus('Uploading… ' + Math.round((end / file.size) * 100) + '%', 'info');

                if (data.status === 'done') { videoId = data.video_id; break; }
                start = end;
            }

            if (!videoId) { throw new Error('Upload did not complete.'); }

            var field = document.getElementById('noteYoutube');
            if (field) { field.value = videoId; }
            setStatus('Uploaded as unlisted. Link filled above — now Publish/Save the note.', 'ok');
        } catch (e) {
            setStatus(e.message || 'Upload failed.', 'error');
        } finally {
            setBusy(false);
        }
    }

    if (uploadBtn) {
        uploadBtn.addEventListener('click', function () {
            uploadToYoutube(lastBlob, 'nocturne-clip.webm');
        });
    }
    if (uploadFileBtn) {
        uploadFileBtn.addEventListener('click', function () {
            var f = fileInput && fileInput.files && fileInput.files[0];
            if (!f) { setStatus('Choose a video file first.', 'error'); return; }
            uploadToYoutube(f, f.name);
        });
    }

    window.addEventListener('beforeunload', stopStream);
})();

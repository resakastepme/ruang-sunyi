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

    var connected = root.getAttribute('data-connected') === '1';
    var uploadUrl = root.getAttribute('data-upload-url');
    var csrfMeta  = document.querySelector('meta[name="csrf-token"]');
    var csrf      = csrfMeta ? csrfMeta.getAttribute('content') : '';

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
            recorder = new MediaRecorder(stream);
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

    function uploadToYoutube(file, filename) {
        if (!file) { setStatus('Nothing to upload yet.', 'error'); return; }
        if (!connected) { setStatus('Connect YouTube first (button above).', 'error'); return; }

        var fd = new FormData();
        fd.append('video', file, filename || 'video.webm');

        if (uploadBtn) { uploadBtn.disabled = true; }
        if (uploadFileBtn) { uploadFileBtn.disabled = true; }
        setStatus('Uploading to YouTube… this can take a while for large files.', 'info');

        fetch(uploadUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: fd
        }).then(function (res) {
            return res.text().then(function (text) {
                var data = {};
                try { data = text ? JSON.parse(text) : {}; } catch (e) { data = {}; }
                return { ok: res.ok, data: data };
            });
        }).then(function (r) {
            if (!r.ok) {
                throw new Error(r.data && r.data.message ? r.data.message : 'Upload failed.');
            }
            var field = document.getElementById('noteYoutube');
            if (field && r.data.video_id) { field.value = r.data.video_id; }
            setStatus('Uploaded as unlisted. Link filled above — now Publish/Save the note.', 'ok');
        }).catch(function (e) {
            setStatus(e.message || 'Upload failed.', 'error');
        }).then(function () {
            if (uploadBtn) { uploadBtn.disabled = false; }
            if (uploadFileBtn) { uploadFileBtn.disabled = false; }
        });
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

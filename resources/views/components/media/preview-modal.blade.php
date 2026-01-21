@props([
'id' => 'mediaPreviewModal',
// endpointni component chaqirganda berasan
'endpoint' => '',
])

{{-- ✅ Modal: VIDEO preview --}}
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 14px;">
            <div class="modal-header">
                <div class="d-flex align-items-end gap-2">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body">
                {{-- loading --}}
                <div id="{{ $id }}Loading" class="text-center py-4 text-muted" style="display:none;">
                    <div class="spinner-border" role="status"></div>
                    <div class="mt-2">Yuklanyapti...</div>
                </div>

                {{-- error --}}
                <div id="{{ $id }}Error" class="alert alert-warning" style="display:none;"></div>

                {{-- video --}}
                <video id="{{ $id }}Video"
                    class="preview-video"
                    controls
                    playsinline
                    preload="metadata"></video>
            </div>
        </div>
    </div>
</div>

@once
@push('customJs')
<script>
    // ✅ shu holicha: 2 ta parametr
    async function openMediaPreview(url, type = null) {


        const modalId = @json($id);
        const endpoint = @json($endpoint);


        const video = document.getElementById(modalId + 'Video');
        const loading = document.getElementById(modalId + 'Loading');
        const errorBox = document.getElementById(modalId + 'Error');

        // UI reset
        errorBox.style.display = 'none';
        errorBox.textContent = '';

        loading.style.display = 'block';

        // old video stop
        try {
            video.pause();
        } catch (e) {}
        video.removeAttribute('src');
        video.load();

        try {

            let query = '';

            if (type === 'url') {
                query = 'url=' + encodeURIComponent(url);
            } else if (type === 'fileName') {
                query = 'filename=' + encodeURIComponent(url);
            }

            const res = await fetch(`${endpoint}?${query}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });


            const data = await res.json();
            console.log(data);

            if (!res.ok || !data.ok) {
                throw new Error(data.message || 'Preview error');
            }

            // signed mp4 url
            if (data.video_url) {
                video.src = data.video_url;
                video.load();
                // video.play().catch(() => {});
            }

        } catch (e) {
            errorBox.style.display = 'block';
            errorBox.textContent = e.message || 'Xatolik';
        } finally {
            loading.style.display = 'none';
        }
    }

    // modal yopilganda video to'xtasin
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById(@json($id));
        if (!modalEl) return;

        modalEl.addEventListener('hidden.bs.modal', function() {
            const video = document.getElementById(@json($id) + 'Video');
            if (!video) return;

            try {
                video.pause();
            } catch (e) {}
            video.removeAttribute('src');
            video.load();

            const errorBox = document.getElementById(@json($id) + 'Error');
            const loading = document.getElementById(@json($id) + 'Loading');

            if (errorBox) {
                errorBox.style.display = 'none';
                errorBox.textContent = '';
            }
            if (loading) {
                loading.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endonce
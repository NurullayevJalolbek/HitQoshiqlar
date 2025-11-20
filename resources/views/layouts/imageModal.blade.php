<!-- Modal for Image Preview -->
<div class="modal fade" id="image-preview-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 0; max-width: 100vw;">
        <div class="modal-content bg-transparent border-0">
            <!-- YARIM QORONG'U ORQA FON -->
            <div class="modal-body p-0 position-relative d-flex align-items-center justify-content-center"
                style="background-color: rgba(0, 0, 0, 0.3); width: 100vw; height: 100vh;">

                <!-- CLICK QILIB YOPISH ZONASI -->
                <div class="position-absolute top-0 start-0 w-100 h-100" data-bs-dismiss="modal" style="z-index: 1;">
                </div>

                <!-- RASM VA X TUGMASI -->
                <div class="position-relative" style="z-index: 2; display: inline-block;">
                    <img id="image-preview-full" src="" alt="Preview" class="img-fluid rounded shadow"
                        style="max-width: 90vw; max-height: 90vh; object-fit: contain;" />

                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</div>

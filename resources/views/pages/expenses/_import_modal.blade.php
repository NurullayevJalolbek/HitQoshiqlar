<div class="modal fade" id="importExpensesModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Харажатларни импорт қилиш</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Давр</label>
                    <select class="form-select">
                        <option>2025-Ноябрь</option>
                        <option>2025-Декабрь</option>
                        <option>2026-Январь</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Валюта</label>
                    <select class="form-select">
                        <option>UZS</option>
                        <option>USD</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Импорт файли (Excel)</label>
                    <input type="file" class="form-control">

                    <a href="#"
                       class="small text-primary d-inline-block mt-1">
                        📥 Импорт шаблонини юклаб олиш
                    </a>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Бекор қилиш
                </button>
                <button class="btn btn-primary">
                    <i class="bi bi-save"></i> Сақлаш
                </button>
            </div>
        </div>
    </div>
</div>

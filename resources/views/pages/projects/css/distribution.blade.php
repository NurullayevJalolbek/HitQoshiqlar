.distribution-segment {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 0.9rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.border-top-2 {
    border-top: 2px solid #dee2e6 !important;
}

/* Badge styles */
.badge {
    padding: 0.35em 0.65em;
    font-weight: 500;
}

/* Modal improvements */
.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

/* Form improvements */
.form-select:focus,
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

/* Table improvements */
.table > :not(caption) > * > * {
    padding: 0.75rem;
}

.table thead th {
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
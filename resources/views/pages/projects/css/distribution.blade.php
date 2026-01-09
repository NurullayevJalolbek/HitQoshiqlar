.distribution-visual {
    display: flex;
    width: 100%;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    position: relative;
}

.empty-distribution {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #6c757d;
    font-weight: 500;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
}

.distribution-segment {
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 0.9rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 0 8px;
}

.segment-partners {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.segment-investors {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.segment-charity {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

/* Info Card Styles */
.info-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}

.info-card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

/* Allocation Item Styles */
.allocation-item {
    transition: all 0.2s ease;
}

.allocation-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

/* Form Improvements */
.form-select:focus,
.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15);
}

/* Badge Improvements */
.badge {
    padding: 0.35em 0.65em;
    font-weight: 500;
    font-size: 0.875rem;
}

/* Button Styles */
.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .distribution-segment {
        font-size: 0.75rem;
        padding: 0 4px;
    }
    
    .allocation-item {
        padding: 0.75rem !important;
    }
}
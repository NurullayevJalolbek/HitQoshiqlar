@extends('layouts.app')
@push('customCss')
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1e40af;
            --success-color: #16a34a;
            --warning-color: #ea580c;
            --danger-color: #dc2626;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
            --border-radius: 0.5rem;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* === RISKS INFO (model + level) nicer UI === */
        #risksInfoContent.info-grid {
            gap: 12px;
        }

        #risksInfoContent .info-item {
            border: 1px solid var(--gray-200);
            background: var(--gray-50);
            border-radius: 12px;
            padding: 12px 14px;
            display: grid;
            gap: 6px;
        }

        #risksInfoContent .info-label {
            font-size: 0.82rem;
            color: var(--gray-600);
            font-weight: 600;
            letter-spacing: .2px;
        }

        #risksInfoContent .info-value {
            font-size: 0.98rem;
            color: var(--gray-900);
            font-weight: 600;
            line-height: 1.45;
            word-break: break-word;
        }

        #risksInfoContent .info-value.muted {
            color: var(--gray-600);
            font-weight: 500;
        }

        #risksInfoContent .form-control,
        #risksInfoContent .form-select {
            border-radius: 10px;
        }

        #risksInfoContent textarea.form-control {
            min-height: 92px;
        }

        .risk-actions-row {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .project-header {
            background: #ffffff;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 1.5rem;
            margin-top: 0.5rem;
            border: 1px solid var(--gray-200);
        }

        .project-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .project-code {
            color: var(--gray-600);
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .status-row {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
            border: 1px solid;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
            border-color: #86efac;
        }

        .status-inprogress {
            background: #DBEAFE;
            color: #1E40AF;
            border-color: #93c5fd;
        }

        .status-planned {
            background: #dbeafe;
            color: #1e40af;
            border-color: #93c5fd;
        }

        .status-completed {
            background: #dcfce7;
            color: #10B981;
            border-color: #86efac;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fca5a5;
        }

        .funding-display {
            text-align: right;
        }

        .funding-percent {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }

        .funding-label {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* --------------------- Tab menu css start ------------------------------ */

        .nav-tabs-container {
            position: relative;
            margin-bottom: 1rem;
            padding: 0 0.75rem;
        }

        .nav-tabs {
            border-bottom: 2px solid #e5e7eb;
            overflow-x: auto;
            white-space: nowrap;
            flex-wrap: nowrap;
            overflow-y: hidden;
            padding-bottom: 0.5rem;
            scroll-behavior: smooth;
        }

        .nav-tabs::-webkit-scrollbar {
            height: 8px;
        }

        .nav-tabs::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .nav-tabs::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .nav-tabs::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0;
            color: #1F2937;
            z-index: 10;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            pointer-events: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .scroll-btn i {
            font-size: 0.875rem;
            transition: transform 0.3s;
        }

        .nav-tabs-container:hover .scroll-btn {
            opacity: 1;
            pointer-events: all;
        }

        .scroll-btn:hover {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: #2563eb;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .scroll-btn:hover i {
            transform: scale(1.2);
        }

        .scroll-btn:active {
            transform: translateY(-50%) scale(0.95);
        }

        .scroll-btn-left {
            left: 8px;
        }

        .scroll-btn-right {
            right: 8px;
        }

        .scroll-btn.hidden {
            display: none;
        }

        .nav-tabs .nav-link {
            height: 40px;
            color: #1F2937;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            background: #ebeaeaff;
            margin-right: 0.25rem;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background: #1F2937;
            border-bottom: 3px solid #2a3441;
            font-weight: 600;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* --------------------- Tab menu css end ------------------------------ */


        .info-card {
            background: #ffffff;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-200);
        }

        .info-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex: 1 1 auto;
            /* let title take remaining space */
            min-width: 0;
            /* allow truncation when space is limited */
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Make header row show full-width HR and keep actions vertically centered */
        .info-card>.d-flex.justify-content-between.align-items-center {
            align-items: center;
            gap: 0.5rem;
            border-bottom: 2px solid var(--gray-200);
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
            flex-wrap: nowrap;
            /* prevent button from wrapping to next line */
        }

        /* Prevent action buttons text from wrapping and keep them vertically centered */
        .info-card .d-flex.align-items-center .btn {
            white-space: nowrap;
            margin-top: 0;
        }

        .info-grid {
            display: grid;
            gap: 1rem;
        }

        .info-row {
            display: grid;
            grid-template-columns: minmax(180px, 1fr) 2fr;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--gray-600);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .info-value {
            color: var(--gray-900);
            font-weight: 600;
        }

        .media-placeholder {
            background: var(--gray-100);
            border: 2px dashed var(--gray-300);
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
            text-align: center;
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        .media-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
            color: var(--gray-400);
        }

        .progress-section {
            margin-bottom: 2rem;
        }

        .progress-bar-wrapper {
            background: var(--gray-100);
            border-radius: 0.5rem;
            height: 2.5rem;
            overflow: hidden;
            position: relative;
            border: 1px solid var(--gray-200);
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            transition: width 0.5s ease;
        }

        .stage-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            justify-content: flex-end;
        }

        .badge-stage-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 500;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .badge-stage-completed {
            background: rgba(22, 163, 74, 0.12);
            color: #166534;
        }

        .badge-stage-in-progress {
            background: rgba(37, 99, 235, 0.12);
            color: #1d4ed8;
        }

        .badge-stage-planned {
            background: rgba(148, 163, 184, 0.2);
            color: #4b5563;
        }

        .timeline {
            position: relative;
            padding-left: 2.5rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: -2.5rem;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 600;
            border: 3px solid;
            background: white;
        }

        .timeline-marker.completed {
            color: var(--success-color);
            border-color: var(--success-color);
        }

        .timeline-marker.in-progress {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .timeline-marker.planned {
            color: var(--gray-400);
            border-color: var(--gray-300);
        }

        .timeline-line {
            position: absolute;
            left: -1.3rem;
            top: 2.5rem;
            bottom: 0;
            width: 2px;
            background: var(--gray-200);
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-content {
            background: var(--gray-50);
            padding: 1rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-200);
        }

        .timeline-title {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .timeline-date {
            color: var(--gray-600);
            font-size: 0.85rem;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-200);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .partner-card {
            background: var(--gray-50);
            padding: 1.25rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-200);
            margin-bottom: 1rem;
        }

        .partner-header {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .risk-item {
            padding: 1.25rem;
            background: var(--gray-50);
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            border-left: 4px solid var(--warning-color);
            transition: all 0.2s;
            border: 1px solid var(--gray-200);
            border-left: 4px solid var(--warning-color);
        }

        .risk-item:hover {
            background: white;
            box-shadow: var(--shadow-sm);
        }

        .risk-title {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .risk-title i {
            color: var(--warning-color);
        }

        .risk-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.6;
        }

        .document-list {
            display: grid;
            gap: 0.75rem;
        }

        .document-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-200);
            transition: all 0.2s;
        }

        .document-item:hover {
            background: white;
            border-color: var(--primary-color);
        }

        .document-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .document-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--primary-color);
            color: white;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .round-item {
            background: var(--gray-50);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 0.75rem;
            border: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .round-info h6 {
            margin: 0 0 0.5rem 0;
            font-weight: 600;
            color: var(--gray-900);
        }

        .round-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .distribution-visual {
            display: flex;
            height: 3rem;
            border-radius: var(--border-radius);
            overflow: hidden;
            margin: 1.5rem 0;
            border: 1px solid var(--gray-200);
        }

        .distribution-segment {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            transition: width 0.3s ease;
        }

        .segment-partners {
            background: var(--primary-color);
        }

        .segment-investors {
            background: var(--success-color);
        }

        .map-container {
            width: 100%;
            height: 300px;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--gray-200);
            margin-top: 1rem;
        }

        .dividend-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.875rem;
            background: var(--gray-50);
            border-radius: var(--border-radius);
            margin-bottom: 0.5rem;
            border: 1px solid var(--gray-200);
        }

        .dividend-date {
            font-weight: 600;
            color: var(--gray-900);
        }

        .dividend-status {
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        .dividend-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--success-color);
        }

        .dividend-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--gray-200);
            margin-top: 1rem;
        }

        .dividend-table thead {
            background: var(--gray-100);
        }

        .dividend-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--gray-200);
        }

        .dividend-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
        }

        .dividend-table tbody tr:hover {
            background: var(--gray-50);
        }

        .dividend-table tbody tr:last-child td {
            border-bottom: none;
        }

        .dividend-table .status-badge-paid {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .dividend-table .status-badge-pending {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde047;
        }

        /* === Pagination (x-pagination bilan bir xil stil) === */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 5px;
            align-items: center;
            position: relative;
        }

        .page-item {
            margin: 0;
            position: relative;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            color: #1F2937;
            text-decoration: none;
            background-color: #fff;
            transition: all 0.3s;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }

        .page-link:hover:not(.disabled) {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .page-item.active .page-link {
            background-color: #1F2937;
            border-color: #1F2937;
            color: #fff;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .gallery-item {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s;
            aspect-ratio: 16/9;
        }

        .gallery-item:hover {
            transform: translateY(-4px);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-item.video-item {
            position: relative;
            background: var(--gray-900);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-item.video-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
            transition: background 0.3s;
        }

        .gallery-item.video-item:hover::before {
            background: rgba(0, 0, 0, 0.5);
        }

        .gallery-item.video-item .play-icon {
            position: absolute;
            z-index: 2;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.5rem;
            transition: all 0.3s;
        }

        .gallery-item.video-item:hover .play-icon {
            transform: scale(1.1);
            background: white;
        }

        .gallery-item.video-item iframe {
            width: 100%;
            height: 100%;
            border: 0;
            pointer-events: none;
        }

        .video-embed {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
        }

        .video-embed iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
            pointer-events: none;
        }

        .image-slider {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            height: 260px;
            background: var(--gray-100);
            cursor: pointer;
        }

        .image-slider img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-nav:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .slider-nav.prev {
            left: 1rem;
        }

        .slider-nav.next {
            right: 1rem;
        }

        .slider-indicators {
            position: absolute;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.5rem;
            z-index: 10;
        }

        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .indicator.active {
            background: white;
            width: 30px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .info-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .funding-display {
                text-align: left;
                margin-top: 1rem;
            }

            .stat-grid {
                grid-template-columns: 1fr;
            }

            .nav-tabs .nav-link {
                font-size: 0.85rem;
                padding: 0.5rem 1rem;
            }
        }

        /* Tab header action buttonlari (Tahrirlash / Saqlash) texti 2-qatorga tushmasligi uchun */
        .info-card .btn {
            white-space: nowrap;
        }

        /* === Header action alignment (fix) === */
        .info-card>.d-flex.justify-content-between.align-items-center {
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .info-card-title {
            margin: 0;
            line-height: 1.2;
        }

        .info-card .btn.btn-sm {
            height: 34px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border-radius: 0.5rem;
        }

        .info-card .btn.btn-sm i {
            line-height: 1;
        }

        /* === Rounds/Risks tools === */
        .tab-tools {
            display: none;
        }

        .tab-tools.active {
            display: inline-flex;
        }

        .drag-handle {
            width: 34px;
            height: 34px;
            border-radius: 0.5rem;
            border: 1px solid var(--gray-200);
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: grab;
            user-select: none;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        .priority-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #eef2ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
            white-space: nowrap;
        }

        .drop-hint {
            font-size: 0.8rem;
            color: var(--gray-600);
            display: none;
            align-items: center;
            gap: 0.35rem;
            white-space: nowrap;
        }

        .drop-hint.active {
            display: inline-flex;
        }

        .round-item.is-drag-over,
        .risk-item.is-drag-over {
            outline: 2px dashed rgba(37, 99, 235, 0.45);
            outline-offset: 3px;
            background: #ffffff;
        }

        /* === Dynamic tab header actions (all tabs) === */
        .tab-header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .tab-header-actions .btn.btn-sm {
            border-radius: 0.65rem;
            padding: 0.42rem 0.7rem;
            font-weight: 600;
        }

        .tab-header-actions .input-group-sm>.input-group-text {
            border-radius: 0.65rem 0 0 0.65rem;
        }

        .tab-header-actions .input-group-sm>.form-select {
            border-radius: 0 0.65rem 0.65rem 0;
        }

        .info-card>.d-flex.justify-content-between.align-items-center {
            flex-wrap: wrap;
            gap: .75rem;
        }

        .info-card>.d-flex.justify-content-between.align-items-center>.tab-header-actions {
            margin-left: auto;
        }

        /* === Media controls: upload tile + delete X overlay === */
        .gallery-item {
            position: relative;
        }

        .media-controls {
            position: absolute;
            top: 8px;
            right: 8px;
            z-index: 6;
            display: flex;
            gap: 6px;
        }

        .media-delete-btn {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, .08);
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
            padding: 0;
        }

        .media-delete-btn:hover {
            transform: scale(1.06);
            background: rgba(255, 255, 255, .98);
            box-shadow: 0 4px 14px rgba(0, 0, 0, .18);
        }

        .media-delete-btn svg {
            width: 18px;
            height: 18px;
            color: #DC2626;
        }

        .media-upload-card {
            border: 2px dashed var(--gray-300);
            background: var(--gray-50);
            border-radius: .75rem;
            min-height: 130px;
            cursor: pointer;
            transition: border-color .15s ease, transform .15s ease, background .15s ease;
        }

        .media-upload-card:hover {
            border-color: #93c5fd;
            background: #eff6ff;
            transform: translateY(-1px);
        }

        .media-upload-content {
            width: 100%;
            min-height: 130px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            color: var(--gray-700);
        }

        .media-upload-content i {
            font-size: 28px;
            color: var(--primary-color);
        }

        /* === Stages progress label: 20% ham ko‘rinadi === */
        .progress-bar-wrapper {
            position: relative;
        }

        .progress-bar-label {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: .9rem;
            color: var(--gray-900);
            pointer-events: none;
            text-shadow: 0 1px 2px rgba(255, 255, 255, .35);
        }

        .stage-item.is-drag-over {
            outline: 2px dashed #93c5fd;
            outline-offset: 4px;
            border-radius: .75rem;
        }
    </style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 px-3 mt-3"
    style="border: 1px solid var(--gray-200); border-radius: var(--border-radius); background-color: #ffffff;">
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Loyihalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Loyiha kartochkasi</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        @php($projectId = request()->route('project'))
    </div>
</div>
@endsection

@section('content')
    <div class="project-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="project-title" id="projectName">Yuklanmoqda...</h1>
                <p class="project-code" id="projectCode">ID: -</p>
                <div class="status-row">
                    <span class="status-badge" id="projectStatus">-</span>
                    <span class="status-badge" id="projectCategory">-</span>
                </div>
            </div>
            <div class="col-md-4 funding-display">
                <div class="funding-percent" id="fundingPercent">0%</div>
                <div class="funding-label">Moliyalashtirilganlik darajasi</div>
            </div>
        </div>
    </div>

    <div class="card card-body shadow-sm border-0">
        <div style="border-color: rgba(0,0,0,0.05); background-color: #fff; padding: 0;">
            <!-- Tab Navigation -->
            <div class="nav-tabs-container">
                <button class="scroll-btn scroll-btn-left" onclick="scrollTabs('left')" id="scrollLeftBtn"
                    aria-label="Scroll left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" onclick="switchTab('characteristics')" type="button">
                            Xarakteristik ma'lumotlar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('stages')" type="button">
                            Loyiha bosqichlari
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('distribution')" type="button">
                            Taqsimot sozlamalari
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('rounds')" type="button">
                            Loyiha raundlari
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('financial')" type="button">
                            Moliyaviy ko'rsatkichlar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('partners')" type="button">
                            To'liq sheriklar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('risks')" type="button">
                            Risklar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('documents')" type="button">
                            Loyiha hujjatlari
                        </button>
                    </li>
                </ul>
                <button class="scroll-btn scroll-btn-right" onclick="scrollTabs('right')" id="scrollRightBtn"
                    aria-label="Scroll right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="characteristics" class="tab-content active">
            <!-- Basic Information -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="info-card-title">
                                <i class="bi bi-info-circle"></i>
                                Asosiy ma'lumotlar
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleBasicInfoBtn"
                                    onclick="toggleBasicInfoEdit()">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Tahrirlash
                                </button>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-hash me-1 text-muted"></i>
                                    Loyihaning unikal IDsi
                                </span>
                                <span class="info-value" id="projectId">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-type me-1 text-muted"></i>
                                    Nomi
                                </span>
                                <span class="info-value" id="name">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-card-text me-1 text-muted"></i>
                                    Qisqacha tavsif
                                </span>
                                <span class="info-value" id="shortDesc">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-bullseye me-1 text-muted"></i>
                                    Maqsadi
                                </span>
                                <span class="info-value" id="purpose">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-tags me-1 text-muted"></i>
                                    Kategoriya
                                </span>
                                <span class="info-value" id="category">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-flag me-1 text-muted"></i>
                                    Holati
                                </span>
                                <span class="info-value" id="status">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="info-card-title">
                                <i class="bi bi-geo-alt"></i>
                                Joylashuv manzili
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleLocationBtn"
                                    onclick="toggleLocationEdit()">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Tahrirlash
                                </button>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    Shahar
                                </span>
                                <span class="info-value" id="city">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-geo-alt me-1 text-muted"></i>
                                    Tuman
                                </span>
                                <span class="info-value" id="district">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-signpost-2 me-1 text-muted"></i>
                                    Ko'cha
                                </span>
                                <span class="info-value" id="street">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-house-door me-1 text-muted"></i>
                                    Uy
                                </span>
                                <span class="info-value" id="house">-</span>
                            </div>
                        </div>
                        <h6 style="margin-top: 1.5rem; margin-bottom: 0.5rem; font-weight: 600;">Joylashuv lokatsiyasi</h6>
                        <div class="map-container">
                            <iframe id="mapFrame" width="100%" height="100%" frameborder="0" style="border:0"></iframe>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="info-card-title">
                                <i class="bi bi-briefcase"></i>
                                Loyiha boshqaruvchisi
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleManagerBtn"
                                    onclick="toggleManagerEdit()">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Tahrirlash
                                </button>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    Tashkilot nomi
                                </span>
                                <span class="info-value" id="managerOrg">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-file-earmark-text me-1 text-muted"></i>
                                    Litsenziya raqami
                                </span>
                                <span class="info-value" id="licenseNumber">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" id="constructionCard" style="display: none;">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="info-card-title">
                                <i class="bi bi-building"></i>
                                Qurilish tashkiloti haqida ma'lumot
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleConstructionBtn"
                                    onclick="toggleConstructionEdit()">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Tahrirlash
                                </button>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    Tashkilot nomi
                                </span>
                                <span class="info-value" id="constructionName">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-image me-1 text-muted"></i>
                                    Logotipi
                                </span>
                                <span class="info-value" id="constructionLogo">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-card-text me-1 text-muted"></i>
                                    Qisqacha tavsif
                                </span>
                                <span class="info-value" id="constructionDesc">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Images -->
                <div class="info-card" id="mainImagesCard">
                    <h5 class="info-card-title">
                        <i class="bi bi-images"></i>
                        Asosiy fon rasmlari
                    </h5>
                    <div class="gallery-grid" id="mainImagesContainer"></div>
                </div>
                <!-- Construction Process Images -->
                <div class="info-card" id="processImagesCard">
                    <h5 class="info-card-title">
                        <i class="bi bi-camera"></i>
                        Qurilish jarayoniga doir rasmlar
                    </h5>
                    <div class="gallery-grid" id="processImagesContainer"></div>
                </div>
                <!-- Videos Section -->
                <div class="info-card" id="videosCard">
                    <h5 class="info-card-title">
                        <i class="bi bi-camera-video"></i>
                        Loyiha videolari
                    </h5>
                    <div class="gallery-grid" id="videosContainer"></div>
                </div>
            </div>
        </div>

        <div id="stages" class="tab-content">
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-diagram-3"></i>
                        Loyiha (mulk) bosqichlari
                    </h5>
                    <div class="tab-header-actions">
                        <div class="input-group input-group-sm w-auto tab-tools" id="stagesTools">
                            <span class="input-group-text"><i class="bi bi-node-plus"></i></span>
                            <select class="form-select form-select-sm" id="stageInsertAfterSelect"
                                onchange="setStageInsertAfter(this.value)">
                                <option value="">Oxiriga qo‘shish</option>
                            </select>
                        </div>

                        <span class="drop-hint" id="stagesHint">
                            <i class="bi bi-grip-vertical"></i>
                            Ushlab tortib joyini o‘zgartiring
                        </span>

                        <button type="button" class="btn btn-primary btn-sm d-none" id="addStageBtn"
                            onclick="addNewStage()">
                            <i class="bi bi-plus-lg me-1"></i>
                            Yangi bosqich qo‘shish
                        </button>

                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleStagesEditBtn"
                            onclick="toggleStagesEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>
                <div class="progress-section">
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar-fill" id="progressBar" style="width: 0%"></div>
                        <div class="progress-bar-label" id="progressBarLabel">0%</div>
                    </div>
                </div>
                <div class="list-group list-group-flush list-group-timeline" id="timeline"></div>
            </div>
        </div>

        <div id="distribution" class="tab-content">
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-pie-chart"></i>
                        Taqsimot sozlamalari
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleDistributionEditBtn"
                            onclick="toggleDistributionEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>
                <div class="info-grid" id="distributionContent">
                    <div class="info-row">
                        <span class="info-label">To'liq sherikning investitsion loyihadagi o'ziga tegishli ulushining
                            realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <span class="info-value" id="fullPartnerOwnShare">100%</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">To'liq sherikning investitsion Kommanditchilarning loyihadagi tegishli
                            ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <span class="info-value" id="fullPartnerInvestorShare">30%</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kommanditchilarning investitsion loyihadagi o'ziga tegishli ulushining
                            realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <span class="info-value" id="investorsOwnShare">70%</span>
                    </div>
                </div>

                <h6 style="margin-top: 2rem; margin-bottom: 1rem; font-weight: 600;">Vizual taqsimot</h6>
                <div class="distribution-visual" id="distributionVisual">
                    <div class="distribution-segment segment-partners" id="partnersSegment" style="width: 30%">
                        To'liq sheriklar: 30%
                    </div>
                    <div class="distribution-segment segment-investors" id="investorsSegment" style="width: 70%">
                        Kommanditchilar: 70%
                    </div>
                </div>
            </div>
        </div>

        <div id="rounds" class="tab-content">
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-arrow-repeat"></i>
                        Loyiha raundlari
                    </h5>

                    <div class="tab-header-actions">
                        <div class="input-group input-group-sm w-auto tab-tools" id="roundsTools">
                            <span class="input-group-text"><i class="bi bi-node-plus"></i></span>
                            <select class="form-select form-select-sm" id="roundInsertAfterSelect"
                                onchange="setRoundInsertAfter(this.value)">
                                <option value="">Oxiriga qo‘shish</option>
                            </select>
                        </div>
                        <span class="drop-hint" id="roundsHint">
                            <i class="bi bi-grip-vertical"></i>
                            Ushlab tortib joyini o‘zgartiring
                        </span>
                        <button type="button" class="btn btn-primary btn-sm d-none" id="addRoundBtn"
                            onclick="addNewRound()">
                            <i class="bi bi-plus-lg me-1"></i>
                            Yangi raund qo'shish
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleRoundsEditBtn"
                            onclick="toggleRoundsEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>
                <div id="roundsContainer"></div>
            </div>
        </div>

        <div id="financial" class="tab-content">
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-cash-stack"></i>
                    Moliyaviy ko'rsatkichlar
                </h5>
                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-currency-exchange"></i>
                        </div>
                        <div class="stat-value" id="totalValue">0</div>
                        <div class="stat-label">Umumiy qiymati</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <div class="stat-value" id="minShare">0</div>
                        <div class="stat-label">Minimal ulush miqdori narxi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div class="stat-value" id="yearlyProfit">0%</div>
                        <div class="stat-label">Kutilayotgan daromad (yillik, foizlarda)</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-pie-chart-fill"></i>
                        </div>
                        <div class="stat-value" id="fundingStatus">0%</div>
                        <div class="stat-label">Moliyalashtirilganlik holati ko'rsatkichi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-calendar-range"></i>
                        </div>
                        <div class="stat-value" id="investmentPeriod">-</div>
                        <div class="stat-label">Investitsiya davri yoki davomiyligi</div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-percent me-1 text-muted"></i>
                            Rentabellik ko'rsatkichi (%) yoki prognoz qilingan daromad summasi
                        </span>
                        <span class="info-value" id="profitability">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-share me-1 text-muted"></i>
                            To'liq sheriklar va Kommanditchilar o'rtasidagi foyda/zararning taqsimot
                            ko'rsatkichlari
                        </span>
                        <span class="info-value" id="distributionIndicators">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-calendar-event me-1 text-muted"></i>
                            Taqsimot amaga oshirilishi boshlanadigan davr
                        </span>
                        <span class="info-value" id="distributionStart">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-cash-stack me-1 text-muted"></i>
                            Eng oxirgi marta taqsimlangan dividend foiz ko'rsatkichi
                        </span>
                        <span class="info-value" id="lastDividend">-</span>
                    </div>
                </div>

                <h6
                    style="margin-top: 2rem; margin-bottom: 1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-clock-history"></i>
                    Loyiha doirasida taqsimlangan dividendlar tarixi
                </h6>
                <div id="dividendHistory"></div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div class="text-muted" id="dividendSummary"></div>
                    <div id="dividendPagination"></div>
                </div>
            </div>
        </div>

        <div id="partners" class="tab-content">
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-people"></i>
                        To'liq sheriklar rekvizit ma'lumotlari
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-primary btn-sm" id="addPartnerBtn" onclick="addNewPartner()"
                            style="display: none;">
                            <i class="bi bi-plus-lg me-1"></i>
                            Yangi sherik qo'shish
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="togglePartnersEditBtn"
                            onclick="togglePartnersEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>
                <div id="partnersContainer"></div>
            </div>
        </div>

        <div id="risks" class="tab-content">

            {{-- === RISKS INFO CARD === --}}
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center" id="risksListContent">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-diagram-3"></i>
                        Loyihaning boshqarilish modeli va xatar darajasi
                    </h5>
                    <div class="tab-header-actions">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleRisksInfoEditBtn"
                            onclick="toggleRisksInfoEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>

                <div class="info-grid" id="risksInfoContent">
                    {{-- JS orqali to‘ldiriladi --}}
                </div>
            </div>

            {{-- === RISKS LIST CARD === --}}
            <div class="info-card mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-exclamation-triangle"></i>
                        Loyihadagi asosiy xatarlar
                    </h5>
                    <div class="tab-header-actions">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleRisksListEditBtn"
                            onclick="toggleRisksListEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>

                <div id="risksContainer" class="sortable-risks-list"></div>
            </div>


        </div>

        <div id="documents" class="tab-content">
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-file-earmark-text"></i>
                        Loyiha (mulk) hujjatlari
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-success btn-sm" id="addDocumentBtn" onclick="addNewDocument()"
                            style="display: none;">
                            <i class="bi bi-plus-lg me-1"></i>
                            Yangi hujjat qo'shish
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleDocumentsEditBtn"
                            onclick="toggleDocumentsEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>
                <div class="document-list" id="documentsContainer"></div>
            </div>
        </div>
    </div>

    <!-- Media Modal (images & videos) -->
    <div class="modal fade" id="mediaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: transparent; border: none;">
                <button type="button" class="btn-close bg-white rounded-circle shadow position-absolute"
                    style="top: 10px; right: 10px; z-index: 1051;" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                    <img id="mediaModalImage" src="" alt="Media" class="img-fluid d-none"
                        style="border-radius: 0.5rem; max-height: 80vh; object-fit: contain;">
                    <div id="mediaModalVideoWrapper" class="ratio ratio-16x9 d-none" style="width: 100%;">
                        <iframe id="mediaModalVideo" src="" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            style="border-radius: 0.5rem;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    @include('pages.projects._scripts')
@endpush
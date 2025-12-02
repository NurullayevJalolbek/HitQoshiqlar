<style>
    /* Sidebar yig‘ilganda matn yo‘qoladi */
    .sidebar.contracted #project-logo img:last-child {
        display: none;
    }

    .sidebar:not(.contracted) #project-logo img:last-child {
        display: inline-block;
    }

    /* === Form Control Search === */
    #form-control-search::placeholder {
        color: #adb5bd;
        opacity: 1;
    }

    /* === Sidebar menu wrapper scroll === */
    #sidebar-menu-wrapper {
        overflow-y: auto;
        overflow-x: hidden;
        flex: 1;
        padding: 10px 16px 100px;
        margin-top: 10px;
    }

    /* Scroll bar uchun chiroyli style */
    #sidebar-menu-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    #sidebar-menu-wrapper::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
        transition: background 0.2s;
    }

    #sidebar-menu-wrapper::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.5);
    }

    #sidebar-menu-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    /* === Sweet Alert Styles === */
    .swal2-actions {
        gap: 16px;
    }

    .btn-outline-secondary {
        color: #6A7D9C;
        background-color: #ffffff;
        border-color: #6A7D9C;
        padding: 10px;
        max-width: 150px;
        width: 100%;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-danger {
        display: flex;
        align-items: center;
        gap: 6px;
        background-color: #FF4C4C !important;
        color: #ffffff;
        border: none !important;
        padding: 10px;
        max-width: 150px;
        width: 100%;
        box-shadow: none !important;
        font-weight: 600;
        font-size: 14px;
    }

    /* === SIDEBAR BASE STYLES === */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh !important;
        width: 260px;
        background: #1f2937;
        z-index: 1000;
        overflow: hidden !important;
        transition: width 0.3s ease;
    }

    .sidebar-inner {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden !important;
        max-height: 100% !important;
        position: relative;
    }

    /* === NAV LINK WIDTH === */
    .sidebar .nav-link {
        width: auto;
        max-width: 250px;
    }

    /* === SIDEBAR CLOSE FIGURE === */
    .sidebar-close-figure {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        margin: 0;
        padding: 20px;
        background: linear-gradient(to top, #1f2937 80%, transparent);
        display: none;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 101;
    }

    @media (max-width: 768px) {
        .sidebar-close-figure {
            display: flex;
            position: fixed;
            top: 0;
            right: 0;
            left: auto;
            bottom: auto;
            background: rgb(31, 41, 55);
            padding: 13px 18px 13px 10px;
            z-index: 100;
        }
    }

    .sidebar-close-icon {
        width: 32px;
        height: 32px;
        transition: transform 0.2s ease;
        filter: brightness(0) invert(1);
    }

    .sidebar-close-figure:hover .sidebar-close-icon {
        transform: scale(1.15) rotate(90deg);
    }

    /* === PROJECT LOGO FIXED === */
    #project-logo {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #1F2937;
        padding: 20px 16px 0;
        list-style: none;
        margin-top: 0 !important;
    }

    @media (max-width: 768px) {
        #project-logo {
            width: 100% !important;
        }
    }

    #project-logo a {
        text-decoration: none;
        color: white;
    }

    /* === LOGO IMAGES === */
    #project-logo img:last-child {
        transition: opacity 0.3s ease;
    }

    /* === PAGINATION === */
    .pagination-block .mx-4 {
        flex-shrink: 0;
    }

    /* === BREADCRUMB MOBILE === */
    @media (max-width: 768px) {
        .breadcrumb-block {
            margin-bottom: 10px;
            height: 0;
            padding: 0 !important;
        }
    }

    /* === COLUMN MOBILE === */
    @media (max-width: 768px) {
        .column-mobile {
            position: unset !important;
            left: unset !important;
        }
    }

    /* === NAV ITEMS STYLING === */
    .sidebar .nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar .nav-item {
        margin-bottom: 4px;
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 16px;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .sidebar .nav-item.active>.nav-link,
    .sidebar .nav-link.active {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
    }

    /* === SIDEBAR TEXT === */
    .sidebar-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: opacity 0.3s ease;
    }

    /* === ICONS === */
    .sidebar i,
    .sidebar .bi {
        font-size: 1.1rem;
        min-width: 20px;
        display: inline-flex;
        justify-content: center;
    }

    /* === SUBMENU STYLES === */
    .multi-level {
        padding-left: 12px;
        transition: all 0.3s ease;
    }

    .multi-level .nav-link {
        font-size: 0.9rem;
        padding: 10px 16px;
    }

    .multi-level .nav {
        padding-left: 8px;
    }

    /* === COLLAPSE ARROW === */
    .link-arrow {
        transition: transform 0.2s ease;
        display: inline-flex;
        align-items: center;
        margin-left: auto;
    }

    .nav-link[aria-expanded="true"] .link-arrow {
        transform: rotate(90deg);
    }

    .link-arrow svg,
    .link-arrow .icon {
        width: 16px;
        height: 16px;
    }

    /* === DIVIDER === */
    .dropdown-divider {
        margin: 12px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .border-gray-700 {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }

    /* === CONTRACTED SIDEBAR === */
    .sidebar.contracted {
        width: 80px;
    }

    .sidebar.contracted .sidebar-text {
        display: none;
        opacity: 0;
    }

    .sidebar.contracted .logo-text {
        display: none;
    }

    .sidebar.contracted .link-arrow {
        display: none;
    }

    .sidebar.contracted #project-logo {
        padding: 20px 12px 0;
    }

    .sidebar.contracted #sidebar-menu-wrapper {
        padding: 10px 8px 100px;
    }

    .sidebar.contracted .nav-link {
        justify-content: center;
        padding: 12px;
    }

    .sidebar.contracted .multi-level {
        padding-left: 0;
    }

    /* Hover qilganda contracted sidebar ochiladi */
    .sidebar.contracted:hover {
        width: 260px;
    }

    .sidebar.contracted:hover .sidebar-text {
        display: inline;
        opacity: 1;
    }

    .sidebar.contracted:hover .logo-text {
        display: inline-block;
    }

    .sidebar.contracted:hover .link-arrow {
        display: inline-flex;
    }

    .sidebar.contracted:hover .nav-link {
        justify-content: flex-start;
        padding: 12px 16px;
    }

    /* === MOBILE RESPONSIVE === */
    @media (max-width: 991.98px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-close-figure {
            display: flex !important;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            max-width: 280px;
        }

        #project-logo {
            width: 100%;
        }

        #sidebar-menu-wrapper {
            padding: 10px 12px 100px;
        }
    }

    /* === NOTIFICATION COUNTS === */
    .notification-count {
        background: #ef4444;
        color: white;
        border-radius: 12px;
        padding: 2px 8px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 8px;
        min-width: 20px;
        text-align: center;
    }

    .sidebar.contracted .notification-count {
        margin-left: 0;
        width: 30px;
    }

    /* === SMOOTH TRANSITIONS === */
    .sidebar * {
        transition: all 0.2s ease;
    }

    .sidebar .collapse {
        transition: height 0.3s ease;
    }

    /* === TEXT UTILITIES === */
    .text-break {
        word-wrap: break-word;
        word-break: break-word;
    }

    .flex-fill {
        flex: 1 1 auto;
    }

    /* === GAP UTILITY === */
    .gap-2 {
        gap: 0.5rem;
    }

    /* === MARGIN/PADDING UTILITIES === */
    .ms-2 {
        margin-left: 0.5rem;
    }

    .my-3 {
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .pt-3 {
        padding-top: 0.75rem;
    }

    .px-2 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    /* === BACKGROUND COLOR === */
    .bg-gray-800 {
        background-color: #1f2937;
    }

    /* === TEXT COLOR === */
    .text-white {
        color: #ffffff;
    }

    /* === DISPLAY UTILITIES === */
    .d-flex {
        display: flex;
    }

    .d-lg-block {
        display: block;
    }

    .align-items-center {
        align-items: center;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .flex-column {
        flex-direction: column;
    }

    /* === COLLAPSE UTILITIES === */
    .collapse:not(.show) {
        display: none;
    }

    .collapse.show {
        display: block;
    }

    .collapsed {
        cursor: pointer;
    }

    /* === SCROLLBAR FOR FIREFOX === */
    #sidebar-menu-wrapper {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
    }

    /* === HOVER EFFECTS === */
    .sidebar .nav-link:not(.collapsed):hover {
        background: rgba(255, 255, 255, 0.15);
    }

    .sidebar .nav-item.active>.nav-link:hover {
        background: rgba(59, 130, 246, 0.25);
    }

    /* === FOCUS STATES === */
    .sidebar .nav-link:focus {
        outline: 2px solid rgba(59, 130, 246, 0.5);
        outline-offset: 2px;
    }

    /* === ANIMATION === */
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
        }

        to {
            transform: translateX(0);
        }
    }

    .sidebar.show {
        animation: slideIn 0.3s ease-in-out;
    }

    /* === ADDITIONAL UTILITIES === */
    .sidebar .dropdown-divider {
        height: 0;
        overflow: hidden;
    }

    /* === LOGO WRAPPER === */
    .sidebar-logo-wrapper {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #1f2937;
    }

    /* === Z-INDEX MANAGEMENT === */
    .sidebar {
        z-index: 1030;
    }

    #project-logo {
        z-index: 1031;
    }

    .sidebar-close-figure {
        z-index: 1032;
    }

    /* === PERFORMANCE OPTIMIZATION === */
    .sidebar * {
        will-change: auto;
    }

    .sidebar .nav-link:hover {
        will-change: background-color, color;
    }

    /* === ACCESSIBILITY === */
    .sidebar .nav-link:focus-visible {
        outline: 2px solid #60a5fa;
        outline-offset: 2px;
    }

    /* Screen reader only */
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }

    /* === DARK MODE SUPPORT === */
    @media (prefers-color-scheme: dark) {
        .sidebar {
            background: #1f2937;
        }

        #project-logo {
            background: #1f2937;
        }
    }

    /* === PRINT STYLES === */
    @media print {
        .sidebar {
            display: none;
        }
    }
</style>

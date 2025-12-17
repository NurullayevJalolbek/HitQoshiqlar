@extends('layouts.app')

@push('customCss')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/quill-emoji@0.2.0/dist/quill-emoji.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/quill-image-resize@3.0.0/image-resize.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    /* =========================
   QUILL EDITOR – FINAL CSS
========================= */

    .ql-toolbar {
        border-radius: 8px 8px 0 0;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .ql-container {
        border-radius: 0 0 8px 8px;
        border: 1px solid #dee2e6;
        border-top: none;
        min-height: 280px;
        font-size: 16px;
    }

    .ql-editor {
        min-height: 280px;
        line-height: 1.7;
        padding: 16px;
    }

    /* Placeholder */
    .ql-editor.ql-blank::before {
        color: #6c757d;
        font-style: normal;
        left: 16px;
    }

    /* =========================
   FONT STYLES (IMPORTANT)
========================= */

    /* Default */
    .ql-font-default {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Serif */
    .ql-font-serif {
        font-family: Georgia, 'Times New Roman', serif;
    }

    /* Monospace */
    .ql-font-monospace {
        font-family: Consolas, 'Courier New', monospace;
    }

    /* Roboto */
    .ql-font-roboto {
        font-family: 'Roboto', sans-serif;
    }

    /* Poppins */
    .ql-font-poppins {
        font-family: 'Poppins', sans-serif;
    }

    /* Inter */
    .ql-font-inter {
        font-family: 'Inter', sans-serif;
    }

    /* Toolbar font labels */
    .ql-snow .ql-picker.ql-font .ql-picker-label::before,
    .ql-snow .ql-picker.ql-font .ql-picker-item::before {
        content: attr(data-value);
    }

    /* Set default font */
    .ql-editor {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Qo'shimcha shriftlar uchun CSS */
    .ql-font-arial {
        font-family: Arial, sans-serif;
    }

    .ql-font-times-new-roman {
        font-family: "Times New Roman", serif;
    }

    .ql-font-georgia {
        font-family: Georgia, serif;
    }

    .ql-font-verdana {
        font-family: Verdana, sans-serif;
    }

    .ql-font-courier-new {
        font-family: "Courier New", monospace;
    }

    .ql-font-tahoma {
        font-family: Tahoma, sans-serif;
    }

    .ql-font-trebuchet-ms {
        font-family: "Trebuchet MS", sans-serif;
    }

    .ql-font-impact {
        font-family: Impact, sans-serif;
    }

    .ql-font-comic-sans-ms {
        font-family: "Comic Sans MS", cursive;
    }

    .ql-font-lucida-console {
        font-family: "Lucida Console", monospace;
    }

    .ql-font-palatino {
        font-family: "Palatino Linotype", serif;
    }

    .ql-font-garamond {
        font-family: Garamond, serif;
    }

    .ql-font-bookman {
        font-family: Bookman, serif;
    }

    .ql-font-helvetica {
        font-family: Helvetica, sans-serif;
    }

    .ql-font-futura {
        font-family: Futura, sans-serif;
    }
</style>
@endpush


@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">

    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.user-interface.index') }}">
                        Statik sahifalar
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    @isset($model)
                    Statik sahifani tahrirlash
                    @else
                    Statik sahifa qo‘shish
                    @endisset
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection


@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card card-body border-0 shadow mb-4">

            <h2 class="h5 mb-4">
                @isset($model)
                Statik sahifani tahrirlash
                @else
                Yangi statik sahifa
                @endisset
            </h2>

            <form method="POST"
                action="#"
                class="needs-validation"
                novalidate
                id="pageForm">

                @csrf
                @isset($model)
                @method('PUT')
                @endisset


                <!-- TITLE -->
                <div class="mb-3">
                    <label class="form-label required">Sahifa nomi</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        placeholder="Masalan: Biz haqimizda"
                        value="{{ old('title', $model['title'] ?? '') }}"
                        required
                        id="titleInput">
                </div>

                <!-- QUILL EDITOR -->
                <div class="mb-4">
                    <label class="form-label required">Sahifa matni</label>
                    <div id="editor-container">
                        <div id="editor">
                        </div>
                    </div>
                    <input type="hidden" name="description" id="description">
                </div>

                <!-- AUTO-SAVE STATUS -->
                <div class="save-status" id="saveStatus"></div>

                <!-- BUTTONS -->
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.user-interface.static-pages.index') }}" class="btn btn-secondary">
                        Bekor qilish
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save me-1"></i>
                        Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('customJs')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill-emoji@0.2.0/dist/quill-emoji.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill-image-resize@3.0.0/image-resize.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill-image-drop-module@1.0.4/image-drop.min.js"></script>

<script>
    const fontFamilies = [
        'Arial', 'Times New Roman', 'Georgia', 'Verdana',
        'Courier New', 'Tahoma', 'Trebuchet MS', 'Impact',
        'Comic Sans MS', 'Lucida Console', 'Palatino',
        'Garamond', 'Bookman', 'Helvetica', 'Futura'
    ];

    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Matnni shu yerga yozing...',
        modules: {
            toolbar: {
                container: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{
                        'header': 1
                    }, {
                        'header': 2
                    }, {
                        'header': 3
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'font': fontFamilies
                    }],
                    [{
                        'align': []
                    }],
                    ['clean'],
                    ['link', 'image', 'video'],
                    ['emoji']
                ],
                handlers: {
                    'emoji': function() {}
                }
            },
            'emoji-toolbar': true,
            'emoji-shortname': true,
            imageResize: {
                displaySize: true,
                modules: ['Resize', 'DisplaySize']
            },
            imageDrop: true
        }
    });

    const font = Quill.import('formats/font');
    font.whitelist = fontFamilies;
    Quill.register(font, true);

    // Backenddan kelgan matnni Quillga yuklash
    if (isset($model['description'])) {
        quill.root.innerHTML = $model['description'];
    }

    // Form submit bo'lganda editor matnini hidden inputga joylash
    const form = document.getElementById('pageForm');
    form.addEventListener('submit', function(e) {
        document.getElementById('description').value = quill.root.innerHTML;
    });
</script>
@endpush
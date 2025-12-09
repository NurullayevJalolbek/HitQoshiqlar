<script>
    const sidebarToggle = document.querySelector('#sidebar-toggle')
    const sidebarText = document.querySelector('#project-name')
    const sidebarMenu = document.querySelector('#sidebarMenu')
    const notificationCounts = [...document.querySelectorAll('.notification-count')]
    const projectLogo = document.querySelector('#project-logo')

    toggleSidebar()

    if (sidebarToggle && sidebarText && sidebarMenu) {
        sidebarToggle.addEventListener('click', () => {
            toggleSidebar()
        })
    }


    function toggleSidebar() {
        if (sidebarMenu.classList.contains('contracted')) {
            sidebarText.style.display = 'none'
            notificationCounts.forEach(count => {
                count.style.marginLeft = 'unset !important';
                count.style.width = '30px';
            })
            projectLogo.style.left = "17px";
            projectLogo.style.width = "unset";
        } else {
            sidebarText.style.display = 'flex'
            notificationCounts.forEach(count => {
                count.style.marginLeft = '16px ';
                count.style.width = 'unset';
            })
            projectLogo.style.left = "unset";
            projectLogo.style.width = "230px";
        }
    }

    sidebarMenu.addEventListener('mouseenter', () => {
        if (!sidebarMenu.classList.contains('contracted')) {
            sidebarText.style.display = 'flex'
            notificationCounts.forEach(count => {
                count.style.marginLeft = '16px ';
                count.style.width = 'unset';
            })
        }
    })

    sidebarMenu.addEventListener('mouseleave', () => {
        if (sidebarMenu.classList.contains('contracted')) {
            sidebarText.style.display = 'none'
            notificationCounts.forEach(count => {
                count.style.marginLeft = 'unset !important';
                count.style.width = '30px';
            })
        }
    })

    const sidebarCloser = document.querySelector('#sidebar-close-figure')
    if (sidebarCloser && sidebarMenu) {
        sidebarCloser.addEventListener('click', () => {
            console.log('hello')
            sidebarMenu.classList.remove('show')
        })
    }

    function toggleLangDropdown() {

        const opener = document.querySelector('#lang-form')
        const dropdown = document.querySelector('#lang-form .lang__dropdown')
        if (opener) {
            opener.addEventListener('click', (e) => {
                e.stopPropagation()
                // dropdown.classList.toggle('active')
                dropdown.style.display = dropdown.style.display === "flex" ? "none" : "flex";
            })
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target) && e.target !== opener) {
                    // dropdown.classList.remove('active')
                    dropdown.style.display = "none";
                }
            })
        }
    }

    function submitLangForm(lang) {
        document.getElementById("locale-input").value = lang;
        document.getElementById("lang-form").submit();
    }

    const opener = document.querySelector('#lang-form')
    const dropdown = document.querySelector('#lang-form .lang__dropdown')
    if (opener) {
        opener.addEventListener('click', (e) => {
            e.stopPropagation()
            dropdown.classList.toggle('active')
        })
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && e.target !== opener) {
                dropdown.classList.remove('active')
            }
        })
    }


    // Har qanday formani boshqarish uchun umumiy funksiya
    function initToggleForm(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form) return;

        const inputs = form.querySelectorAll('[data-toggle-field]');
        const searchButton = form.querySelector('#search-button');
        const cleanButton = form.querySelector('#clean-button');

        function toggleButtons() {
            let hasValue = false;

            inputs.forEach(input => {
                if (input.value && input.value.trim() !== '') {
                    hasValue = true;
                }
            });

            if (hasValue) {
                searchButton?.classList.remove('disabled');
                cleanButton?.classList.remove('disabled');
            } else {
                searchButton?.classList.add('disabled');
                cleanButton?.classList.add('disabled');
            }
        }

        inputs.forEach(input => {
            const eventType = input.tagName === 'SELECT' ? 'change' : 'input';
            input.addEventListener(eventType, toggleButtons);
        });

        toggleButtons();
    }

    document.addEventListener('DOMContentLoaded', function () {
        initToggleForm('#user-search-form');
        initToggleForm('#compatriot-discussion-search-form');
        initToggleForm('#academic-degrees-search-form');
        initToggleForm('#date-log-search-form');
        initToggleForm('#access-log-search-form');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Global delete function
        window.deleteModel = function (url) {
            Swal.fire({
                title: `{{ __('admin.are_you_sure') }}`,
                text: `{!! __('admin.you_wont_be_able_to_revert_this') !!}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: `{{ __('admin.yes_delete_it') }}`,
                cancelButtonText: `{{ __('admin.cancel') }}`,
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                confirmButtonColor: '#dc3545', // Qizil rang
                cancelButtonColor: 'rgb(31, 41, 55)' // Kustom kulrang
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            window.sweetSuccess('', data.result);
                            setTimeout(() => { location.reload(); }, 1000);
                        },
                        error: function (data) {
                            data = JSON.parse(data.responseText);
                            window.sweetError('', data.errors);
                        }
                    });
                }
            });
        }

        // Global confirm function
        window.confirmModel = function (url, method) {
            Swal.fire({
                title: `{{ __('admin.are_you_sure') }}`,
                text: `{!! __('admin.you_wont_be_able_to_revert_this') !!}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: `{{ __('admin.confirm') }}`,
                cancelButtonText: `{{ __('admin.cancel') }}`,
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                confirmButtonColor: '#dc3545', // Qizil rang
                cancelButtonColor: 'rgb(31, 41, 55)' // Kustom kulrang
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: method,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            window.sweetSuccess('', data.result);
                            setTimeout(() => { location.reload(); }, 1000);
                        },
                        error: function (data) {
                            data = JSON.parse(data.responseText);
                            window.sweetError('', data.errors);
                        }
                    });
                }
            });
        }

        // Global success alert
        window.sweetSuccess = function (title = null, text = null) {
            text = text ?? `{{ session()->get('success') }}`;
            if (text) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
        }

        // Global info alert (faqat ogohlantirish / xabar)
            window.infoModal = function (title = null, text = null) {
                Swal.fire({
                    title: title ?? "{{ __('admin.info') }}",
                    text: text ?? "",
                    icon: 'info',
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    },
                    buttonsStyling: false
                });
            }


        // Global error alert
        window.sweetError = function (title = null, text = null) {
            text = text ?? `{{ session()->get('error') }}`;
            if (text) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            }
        }

        // Agar session da success/error bo'lsa avtomatik alert
        window.sweetSuccess();
        window.sweetError();
    });




    document.querySelectorAll('.toggle-ai-permission').forEach(checkbox => {
        checkbox.addEventListener('change', function (e) {
            e.preventDefault();
            const isChecked = this.checked;
            const userId = this.dataset.id;

            // Avval revert qilish (hozircha toggle holatini saqlab turish)
            this.checked = !isChecked;

            const iconUrl = isChecked ?
                "{{ asset('assets/img/icons/delete-waring-icon.png') }}" // ruxsat berish icon (o'zingiz qo'shing)
                :
                "{{ asset('assets/img/icons/delete-waring-icon.png') }}"; // taqiqlash icon (o'zingiz qo'shing)

            const title = isChecked ? 'Ruxsat berilsinmi?' : 'Taqiqlansinmi?';
            const text = isChecked ?
                'Foydalanuvchiga AI funksiyasi yoqiladi' :
                'AI funksiyasidan foydalanish bloklanadi';

            const confirmText = isChecked ?
                'Ruxsat berish <img src="{{ asset('assets/img/icons/allow.svg') }}" style="width: 16px;">' :
                'Taqiqlash <img src="{{ asset('assets/img/icons/deny.svg') }}" style="width: 16px;">';

            const cancelText =
                'Bekor qilish <img src="{{ asset('assets/img/icons/cancel-button.png') }}" style="width: 16px;">';

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                html: `
                    <div style="text-align: center;">
                        <div style="margin-bottom: 20px;">
                            <img src="${iconUrl}" style="width: 60px; height: 60px;">
                        </div>
                        <h2 style="font-size: 20px; margin-bottom: 10px; color: #333;">
                            ${title}
                        </h2>
                        <p style="font-size: 14px; color: #6c757d; margin-bottom: 0;">
                            ${text}
                        </p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                buttonsStyling: false,
                customClass: {
                    confirmButton: isChecked ? 'btn btn-success' : 'btn btn-danger',
                    cancelButton: 'btn btn-outline-secondary',
                    popup: 'p-4 rounded shadow'
                },
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/${userId}/toggle-ai-permission`, {

                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            ai_permission: isChecked
                        })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.result) {
                                checkbox.checked = isChecked;
                            } else {
                                Swal.fire('Xatolik',
                                    'Maʼlumotni yangilashda xatolik yuz berdi', 'error');
                                checkbox.checked = !isChecked;
                            }
                        });
                }
            });
        });
    });


    //Rasm ochish
    function enableImagePreview(selector = 'img') {
        document.querySelectorAll(selector).forEach(img => {
            img.style.cursor = 'zoom-in';
            img.addEventListener('click', () => {
                const modal = new bootstrap.Modal(document.getElementById('image-preview-modal'));
                document.getElementById('image-preview-full').src = img.src;
                modal.show();
            });
        });
    }
</script>


<script>
    document.querySelectorAll('.delete-chat').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                html: `
                <div style="text-align: center;">
                    <div style="margin-bottom: 20px;">
                        <img src="{{ asset('assets/img/icons/delete-waring-icon.png') }}" style="width: 60px; height: 60px;">
                    </div>
                    <h2 style="font-size: 20px; margin-bottom: 10px; color: #333;">
                        {{ __('message.Are you sure?') }}
                    </h2>
                    <p style="font-size: 14px; color: #6c757d; margin-bottom: 0;">
                        {{ __('message.You wont be able to revert this!') }}
                    </p>
                </div>
            `,
                showCancelButton: true,
                confirmButtonText: '{{ __('admin.Delete') }} <img src="{{ asset('assets/img/icons/trash.png') }}" style="width: 16;" class="fas fa-trash-alt"></img>',
                cancelButtonText: '{{ __('message.Cancel') }} <img src="{{ asset('assets/img/icons/cancel-button.png') }}" style="width: 16;" class="fas fa-times-circle"></img>',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger ',
                    cancelButton: 'btn btn-outline-secondary',
                    popup: 'p-4 rounded shadow'
                },
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });



    ///employee status  permission

    document.querySelectorAll('.toggle-permission').forEach(checkbox => {
        checkbox.addEventListener('change', function (e) {
            const isChecked = this.checked;
            const userId = this.dataset.id;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/admin/status/${userId}/login-permission`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    login_access: isChecked
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.result) {
                        Swal.fire('Xatolik', 'Maʼlumotni yangilashda xatolik yuz berdi', 'error');
                        checkbox.checked = !isChecked; // revert if error
                    }
                })
                .catch(() => {
                    Swal.fire('Xatolik', 'Server bilan aloqa muvaffaqiyatsiz tugadi', 'error');
                    checkbox.checked = !isChecked;
                });
        });
    });


    //Rasm ochish
    function enableImagePreview(selector = 'img') {
        document.querySelectorAll(selector).forEach(img => {
            img.style.cursor = 'zoom-in';
            img.addEventListener('click', () => {
                const modal = new bootstrap.Modal(document.getElementById('image-preview-modal'));
                document.getElementById('image-preview-full').src = img.src;
                modal.show();
            });
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('modal-default'));
            myModal.show();
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ __('message.Successfully') }}',
                text: "{{ session('success') }}",
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: '{{ __('message.Something went wrong!') }}',
                text: "{{ session('error') }}",
                timer: 6000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @elseif (session('info'))
            /**
             * INFO modal: shunchaki ma’lumot berish uchun.
             * icon: 'info'  —  ko‘k rangdagi belgichasi bor.
             */
            Swal.fire({
                icon: 'info',
                title: '{{ __('message.Information') }}',
                text: "{{ session('info') }}",
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif
        // Image tegining id sini berib qoyilsa boldi
        enableImagePreview('#photo-preview');
        enableImagePreview('#user-photo-preview');

    });

    function showSwalNotification(type, message, title = '') {
        const titles = {
            success: title || '{{ __('message.Successfully') }}',
            error: title || '{{ __('message.Something went wrong!') }}',
            warning: title || '{{ __('message.Information') }}',
            info: title || '{{ __('message.Information') }}',
        };

        const icons = ['success', 'error', 'warning', 'info'];

        Swal.fire({
            icon: icons.includes(type) ? type : 'info',
            title: titles[type] || title,
            text: message,
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const readSelect = document.getElementById('readSelect');
        const readSelect2 = document.getElementById('employee-select');
        const searchBtn = document.getElementById('searchBtn');
        const clearBtn = document.getElementById('clearBtn');

        function toggleButtons() {
            const hasSearch = searchInput?.value.trim().length > 0;
            const hasRead = readSelect ? readSelect.value.trim().length > 0 : false;
            const hasRead2 = readSelect2 ? readSelect2.value.trim().length > 0 : false;

            const hasAnyInput = hasSearch || hasRead || hasRead2;

            if (searchBtn) {
                searchBtn.disabled = !hasAnyInput;
            }

            if (clearBtn) {
                clearBtn.classList.toggle('disabled', !hasAnyInput);
                clearBtn.style.pointerEvents = hasAnyInput ? 'auto' : 'none';
                clearBtn.style.opacity = hasAnyInput ? '1' : '0.5';
            }
        }


        toggleButtons();

        if (searchInput) {
            searchInput.addEventListener('input', toggleButtons);
        }

        if (readSelect) {
            readSelect.addEventListener('change', toggleButtons);

            $(readSelect).on('change', toggleButtons);
        }
    });
</script>

<!-- Core -->
<script src="{{ asset('vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
{{--
<script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>


<!-- Vendor JS -->
<script src="{{ asset('vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>

<!-- Slider -->
<script src="{{ asset('vendor/nouislider/distribute/nouislider.min.js') }}"></script>

<!-- Smooth scroll -->
<script src="{{ asset('vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>

<!-- Count up -->
<script src="{{ asset('vendor/countup.js/dist/countUp.umd.js') }}"></script>

<!-- Apex Charts -->
{{--
<script src="{{ asset('vendor/apexcharts/dist/apexcharts.min.js') }}"></script> --}}

<!-- Datepicker -->
<script src="{{ asset('vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('vendor/simple-datatables/dist/umd/simple-datatables.js') }}"></script>

<!-- Sweet Alerts 2 -->
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>

<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

<!-- Vanilla JS Datepicker -->
<script src="{{ asset('vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>

<!-- Full Calendar -->
<script src="{{ asset('vendor/fullcalendar/main.min.js') }}"></script>

<!-- Dropzone -->
<script src="{{ asset('vendor/dropzone/dist/min/dropzone.min.js') }}"></script>

<!-- Choices.js -->
<script src="{{ asset('vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>

<!-- Notyf -->
<script src="{{ asset('vendor/notyf/notyf.min.js') }}"></script>

<!-- Mapbox & Leaflet.js -->
<script src="{{ asset('vendor/leaflet/dist/leaflet.js') }}"></script>

<!-- SVG Map -->
{{--
<script src="{{ asset('vendor/svg-pan-zoom/dist/svg-pan-zoom.min.js') }}"></script> --}}
<script src="{{ asset('vendor/svgmap/dist/svgMap.min.js') }}"></script>

<!-- Simplebar -->
<script src="{{ asset('vendor/simplebar/dist/simplebar.min.js') }}"></script>

<!-- Sortable Js -->
<script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Volt JS -->
<script src="{{ asset('js/volt.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@push('customJs')
    <script>
        let projectData = null;
        let currentTab = 'characteristics';
        let currentMainImageIndex = 0;
        let mainImages = [];

        const mockData = {
            id: 1,
            project_id: "PRJ-2024-001",
            name: "Premium Turar-joy Majmuasi",
            short_description: "Toshkent shahar markazida zamonaviy turar-joy majmuasi qurilishi loyihasi",
            purpose: "Yuqori sifatli va zamonaviy uy-joy bilan ta'minlash, shahar infratuzilmasini rivojlantirish",
            category: "construction",
            status: "active",
            city: "Toshkent",
            district: "Yunusobod",
            street: "Amir Temur ko'chasi",
            house: "123",
            location_lat: 41.311081,
            location_lng: 69.240562,
            manager_organization: "Envast Construction MChJ",
            license_number: "LIC-2024-12345",
            construction_org: {
                name: "Premium Build MChJ",
                url: "https://www.shutterstock.com/image-vector/building-construction-logo-design-template-260nw-1558797890.jpg",
                logo: "logo_url_placeholder",
                description: "15 yillik tajribaga ega professional qurilish kompaniyasi"
            },
            main_images: [
                "https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1200&q=80",
                "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&q=80",
                "https://images.unsplash.com/photo-1448630360428-65456885c650?w=1200&q=80",
                "https://images.unsplash.com/photo-1519643381401-22c77e60520e?w=1200&q=80"
            ],
            videos: [
                "https://www.youtube.com/embed/QWIoR7vjpBU",
                "https://www.youtube.com/embed/TlP92LPvUjY"
            ],
            process_images: [
                "https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=800&q=80",
                "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&q=80",
                "https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80",
                "https://images.unsplash.com/photo-1590489702772-d6e776a01551?w=800&q=80",
                "https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=800&q=80",
                "https://images.unsplash.com/photo-1503594384566-461fe158e797?w=800&q=80"
            ],
            funding_percent: 72,
            total_value: 5000000000,
            min_share: 10000000,
            yearly_profit: 18,
            funding_status: 72,
            investment_period: "24 oy",
            profitability: "25%",
            distribution: {
                full_partner_own_share: 100,
                full_partner_investor_share: 30,
                investors_own_share: 70
            },
            distribution_indicators: "To'liq sheriklar: 30%, Kommanditchilar: 70%",
            distribution_start: "2025-yil yanvar",
            last_dividend: 4.5,
            dividend_history: [{
                date: "2024-12",
                amount: 4.5,
                status: "To'langan"
            },
            {
                date: "2024-09",
                amount: 4.2,
                status: "To'langan"
            },
            {
                date: "2024-06",
                amount: 4.0,
                status: "To'langan"
            },
            {
                date: "2024-03",
                amount: 3.8,
                status: "To'langan"
            },
            {
                date: "2023-12",
                amount: 3.5,
                status: "To'langan"
            },
            {
                date: "2023-09",
                amount: 3.2,
                status: "To'langan"
            },
            {
                date: "2023-06",
                amount: 3.0,
                status: "To'langan"
            },
            {
                date: "2023-03",
                amount: 2.8,
                status: "To'langan"
            },
            {
                date: "2022-12",
                amount: 2.5,
                status: "To'langan"
            },
            {
                date: "2022-09",
                amount: 2.2,
                status: "To'langan"
            }
            ],
            stages: [{
                id: 1,
                name: "Yer sotib olish va ruxsatnomalar",
                status: "completed",
                icon: "bi-check-circle",
                order: 1,
                start_date: "2024-01",
                end_date: "2024-02",
                progress: 20
            },
            {
                id: 2,
                name: "Loyiha-smeta hujjatlari tayyorlash",
                status: "completed",
                icon: "bi-check-circle",
                order: 2,
                start_date: "2024-03",
                end_date: "2024-04",
                progress: 15
            },
            {
                id: 3,
                name: "Qurilish ishlari boshlash",
                status: "completed",
                icon: "bi-check-circle",
                order: 3,
                start_date: "2024-05",
                end_date: "2024-06",
                progress: 10
            },
            {
                id: 4,
                name: "Asosiy konstruksiyalarni qurish",
                status: "in_progress",
                icon: "bi-arrow-clockwise",
                order: 4,
                start_date: "2024-07",
                end_date: "2024-12",
                progress: 30
            },
            {
                id: 5,
                name: "Ichki va tashqi bezatish ishlari",
                status: "planned",
                icon: "bi-circle",
                order: 5,
                start_date: "2025-01",
                end_date: "2025-03",
                progress: 15
            },
            {
                id: 6,
                name: "Foydalanishga topshirish va hujjatlashtirish",
                status: "planned",
                icon: "bi-circle",
                order: 6,
                start_date: "2025-04",
                end_date: "2025-04",
                progress: 10
            }
            ],
            rounds: [{
                id: 1,
                name: "1-raund (Boshlang'ich)",
                status: "completed",
                min_share: 5000000
            },
            {
                id: 2,
                name: "2-raund (Asosiy)",
                status: "in_progress",
                min_share: 10000000
            },
            {
                id: 3,
                name: "3-raund (Yakunlovchi)",
                status: "inactive",
                min_share: 15000000
            }
            ],
            partners: [{
                id: 1,
                company_name: "Innovatsiya Invest MChJ",
                inn: "123456789",
                ifut: "00001",
                type: "MChJ",
                address: "Toshkent sh., Yunusobod t., Amir Temur ko'ch., 100-uy",
                director: "Karimov Jasur Akmalovich",
                phone: "+998 90 123-45-67",
                email: "info@innovatsiya.uz",
                registration_date: "15.05.2020",
                registration_number: "REG-2020-12345",
                registration_org: "Yunusobod tumani Adliya bo'limi",
                passport_data: "-",
                pinfl: "-",
                account_status: "active",
                partnership_date: "10.01.2024",
                investor_certificate: "certificate_file.pdf",
                share_amount: 1500000000,
                share_percent: 30
            },
            {
                id: 2,
                company_name: "Aliyev Aziz Karimovich",
                inn: "987654321",
                ifut: "-",
                type: "YaTT",
                address: "Toshkent sh., Chilonzor t., Bunyodkor ko'ch., 45-uy",
                director: "Aliyev Aziz Karimovich",
                phone: "+998 91 234-56-78",
                email: "aziz@example.uz",
                registration_date: "20.03.2019",
                registration_number: "-",
                registration_org: "-",
                passport_data: "AA1234567",
                pinfl: "12345678901234",
                account_status: "active",
                partnership_date: "15.02.2024",
                investor_certificate: "certificate2_file.pdf",
                share_amount: 1000000000,
                share_percent: 20
            }
            ],
            risks: {
                management_model: "Markazlashgan boshqaruv modeli",
                management_desc: "Barcha strategik qarorlar markaziy boshqaruv idorasi tomonidan qabul qilinadi",
                management_info: "Loyiha boshqaruvi markazlashgan tuzilmada amalga oshiriladi. Operativ qarorlar esa loyiha menejerlariga topshirilgan. Har hafta hisobotlar taqdim etiladi.",
                management_description: "Loyiha boshqaruvi markazlashgan tuzilmada amalga oshiriladi. Barcha strategik qarorlar markaziy boshqaruv idorasi tomonidan qabul qilinadi. Operativ qarorlar esa loyiha menejerlariga topshirilgan. Har hafta hisobotlar taqdim etiladi va barcha qarorlar investorlar kengashida muhokama qilinadi. Bu model loyihaning samarali boshqarilishini va shaffoflikni ta'minlaydi.",
                risk_level: "low",
                risk_items: [{
                    id: 1,
                    name: "Bozor riski",
                    description: "Ko'chmas mulk bozoridagi narxlarning kutilmagan pasayishi, talab-talabning kamayishi. Bu risk bozor sharoitlarining o'zgarishi, iqtisodiy inqirozlar yoki mintaqaviy omillar tufayli yuzaga kelishi mumkin. Riskni kamaytirish uchun bozor tendentsiyalarini doimiy kuzatish va diversifikatsiya strategiyasini qo'llash tavsiya etiladi."
                },
                {
                    id: 2,
                    name: "Qurilish riski",
                    description: "Qurilish materiallarining narxining oshishi, qurilish jarayonida texnik muammolar. Materiallar narxining o'zgarishi, yetkazib beruvchilar bilan muammolar, iqlim sharoitlari va texnik xatolar qurilish jarayoniga ta'sir qilishi mumkin. Bu riskni minimallashtirish uchun ehtiyotkorlik bilan rejalashtirish va professional qurilish kompaniyalari bilan ishlash muhimdir."
                },
                {
                    id: 3,
                    name: "Moliyaviy risk",
                    description: "Investorlar tomonidan mablag'larning o'z vaqtida kiritilmasligi, valyuta kursining o'zgarishi. Moliyaviy risklar loyihaning moliyalashtirilishiga ta'sir qilishi mumkin. Valyuta kursining o'zgarishi, investorlarning moliyaviy qiyinchiliklari yoki makroiqtisodiy omillar bu risklarni keltirib chiqarishi mumkin. Moliyaviy rejalashtirish va zaxira mablag'larini yaratish bu risklarni kamaytirishga yordam beradi."
                },
                {
                    id: 4,
                    name: "Huquqiy risk",
                    description: "Qonunchilikdagi o'zgarishlar, ruxsatnomalarni olishdagi kechikishlar. Huquqiy risklar loyihaning amalga oshirilishiga to'sqinlik qilishi mumkin. Qonunchilikdagi o'zgarishlar, ruxsatnomalarni olishdagi kechikishlar yoki huquqiy muammolar loyihani kechiktirishi yoki to'xtatishi mumkin. Bu riskni kamaytirish uchun barcha huquqiy hujjatlarni vaqtida tayyorlash va huquqiy maslahatchilar bilan ishlash tavsiya etiladi."
                }
                ]
            },
            documents: [{
                id: 1,
                name: "Yer uchastkasi hujjatlari",
                file: "land_documents.pdf"
            },
            {
                id: 2,
                name: "Investitsiya shartnomasi",
                file: "investment_contract.pdf"
            },
            {
                id: 3,
                name: "Qurilish ruxsatnomasi",
                file: "construction_license.pdf"
            },
            {
                id: 4,
                name: "Loyiha-smeta hujjatlari",
                file: "project_estimate.pdf"
            },
            {
                id: 5,
                name: "Texnik shartlar",
                file: "technical_specs.pdf"
            }
            ]
        };

        function loadProjectData() {
            projectData = mockData;
            displayProjectData();
        }

        function displayProjectData() {
            const p = projectData;

            document.getElementById('projectName').textContent = p.name;
            document.getElementById('projectCode').textContent = `ID: ${p.project_id}`;
            document.getElementById('fundingPercent').textContent = p.funding_percent + '%';

            const statusMap = {
                'active': {
                    text: 'Faol',
                    class: 'status-active'
                },
                'planned': {
                    text: 'Rejalashtirilgan',
                    class: 'status-planned'
                },
                'completed': {
                    text: 'Yakunlangan',
                    class: 'status-completed'
                },
                'inactive': {
                    text: 'Nofaol',
                    class: 'status-inactive'
                }
            };

            const status = statusMap[p.status];
            const statusEl = document.getElementById('projectStatus');
            statusEl.textContent = status.text;
            statusEl.className = `status-badge ${status.class}`;

            const categoryMap = {
                'land': 'Yer uchastkasi',
                'construction': 'Qurilish',
                'rental': 'Ijara'
            };

            const categoryEl = document.getElementById('projectCategory');
            categoryEl.textContent = categoryMap[p.category];
            categoryEl.className = 'status-badge status-planned';

            document.getElementById('projectId').textContent = p.project_id;
            document.getElementById('name').textContent = p.name;
            document.getElementById('shortDesc').textContent = p.short_description;
            document.getElementById('purpose').textContent = p.purpose;
            document.getElementById('category').textContent = categoryMap[p.category];
            document.getElementById('status').textContent = status.text;

            document.getElementById('city').textContent = p.city;
            document.getElementById('district').textContent = p.district;
            document.getElementById('street').textContent = p.street;
            document.getElementById('house').textContent = p.house;

            const mapUrl =
                `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2996.5!2d${p.location_lng}!3d${p.location_lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDE4JzM5LjkiTiA2OcKwMTQnMjYuMCJF!5e0!3m2!1sen!2s!4v1234567890`;
            document.getElementById('mapFrame').src = mapUrl;

            document.getElementById('managerOrg').textContent = p.manager_organization;
            document.getElementById('licenseNumber').textContent = p.license_number;

            if (p.category === 'construction' || p.category === 'rental') {
                document.getElementById('constructionCard').style.display = 'block';
                document.getElementById('constructionName').textContent = p.construction_org.name;
                document.getElementById('constructionLogo').textContent = p.construction_org.logo;
                document.getElementById('constructionDesc').textContent = p.construction_org.description;

                const logoEl = document.getElementById('constructionLogo')
                logoEl.innerHTML = '';

                if (p.construction_org.url) {
                    const img = document.createElement('img')
                    img.src = p.construction_org.url
                    img.alt = p.construction_org.name
                    img.style.maxWidth = '120px';
                    img.style.maxHeight = '60px';
                    img.style.objectFit = 'contain';

                    logoEl.appendChild(img);
                } else {
                    logoEl.textContent = '-'
                }
            }

            displayMainImages(p.main_images);
            displayVideos(p.videos);
            displayProcessImages(p.process_images);
            displayStages(p.stages);
            displayDistribution(p.distribution);
            displayRounds(p.rounds);
            displayFinancial(p);
            displayPartners(p.partners);
            displayRisks(p.risks); // Bu qator muhim!
            displayDocuments(p.documents);
        }

        function displayMainImages(images) {
            if (!images || images.length === 0) {
                document.getElementById('mainImagesCard').style.display = 'none';
                return;
            }

            document.getElementById('mainImagesCard').style.display = 'block';
            mainImages = images;
            currentMainImageIndex = 0;

            const container = document.getElementById('mainImagesContainer');
            container.innerHTML = images.map((img, index) => `
                                                                                                                                            <div class="gallery-item" data-media-src="${img}" onclick="openImageModal('${img}')">
                                                                                                                                                <img src="${img}" alt="Asosiy fon rasmi ${index + 1}" loading="lazy">
                                                                                                                                            </div>
                                                                                                                                        `).join('');
        }

        function displayVideos(videos) {
            if (!videos || videos.length === 0) {
                document.getElementById('videosCard').style.display = 'none';
                return;
            }

            document.getElementById('videosCard').style.display = 'block';
            const container = document.getElementById('videosContainer');
            container.innerHTML = videos.map((url, index) => {
                // YouTube URL dan thumbnail olish
                const videoId = url.match(/(?:youtube\.com\/embed\/|youtu\.be\/)([^&\n?#]+)/)?.[1];
                const thumbnailUrl = videoId ?
                    `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg` :
                    '';

                return `
                                                                                                                                                <div class="gallery-item video-item" data-media-src="${url}" onclick="openVideoModal('${url}')">
                                                                                                                                                    ${thumbnailUrl ? `<img src="${thumbnailUrl}" alt="Video ${index + 1}" loading="lazy">` : ''}
                                                                                                                                                    <div class="play-icon">
                                                                                                                                                        <i class="bi bi-play-fill"></i>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            `;
            }).join('');
        }

        function displayProcessImages(images) {
            if (!images || images.length === 0) {
                document.getElementById('processImagesCard').style.display = 'none';
                return;
            }

            document.getElementById('processImagesCard').style.display = 'block';
            const container = document.getElementById('processImagesContainer');
            container.innerHTML = images.map((img, index) => `
                                                                                                                                                                <div class="gallery-item" data-media-src="${img}" onclick="openImageModal('${img}')">
                                                                                                                                                                    <img src="${img}" alt="Qurilish jarayoni ${index + 1}" loading="lazy">
                                                                                                                                                                </div>
                                                                                                                                                            `).join('');
        }

        function openImageModal(imageUrl) {
            const modalEl = document.getElementById('mediaModal');
            const bsModal = new bootstrap.Modal(modalEl);
            const imgEl = document.getElementById('mediaModalImage');
            const videoWrapper = document.getElementById('mediaModalVideoWrapper');
            const videoEl = document.getElementById('mediaModalVideo');

            // faqat rasm ko'rsatamiz
            imgEl.classList.remove('d-none');
            videoWrapper.classList.add('d-none');
            videoEl.src = '';
            imgEl.src = imageUrl;

            bsModal.show();
        }

        function openVideoModal(videoUrl) {
            const modalEl = document.getElementById('mediaModal');
            const bsModal = new bootstrap.Modal(modalEl);
            const imgEl = document.getElementById('mediaModalImage');
            const videoWrapper = document.getElementById('mediaModalVideoWrapper');
            const videoEl = document.getElementById('mediaModalVideo');

            // faqat video ko'rsatamiz
            imgEl.classList.add('d-none');
            videoWrapper.classList.remove('d-none');
            videoEl.src = videoUrl;

            bsModal.show();
        }

        // =================== TO'LIQ SHERIKLAR EDIT ===================
        let partnersEditMode = false;
        let nextPartnerId = 3; // Yangi sheriklar uchun ID
        let originalPartnersData = [];

        function togglePartnersEdit() {
            partnersEditMode = !partnersEditMode;
            const btn = document.getElementById('togglePartnersEditBtn');
            const addBtn = document.getElementById('addPartnerBtn');

            if (partnersEditMode) {
                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Saqlash';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');

                if (addBtn) addBtn.style.display = 'inline-flex';

                // Asl ma'lumotlarni saqlash
                originalPartnersData = JSON.parse(JSON.stringify(projectData.partners || []));

            } else {
                savePartnersChanges();

                btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');

                if (addBtn) addBtn.style.display = 'none';
            }

            displayPartners(projectData.partners || []);
        }

        // function displayPartners(partners) {
        //     const container = document.getElementById('partnersContainer');

        //     if (!partners || partners.length === 0) {
        //         container.innerHTML = '<p class="text-muted text-center py-4">To\'liq sheriklar mavjud emas</p>';
        //         return;
        //     }

        //     if (!partnersEditMode) {
        //         // Ko'rish rejimi
        //         container.innerHTML = partners.map(partner => `
        //         <div class="partner-card" style="margin-bottom: 1.5rem;">
        //             <div class="partner-header">
        //                 <i class="bi bi-building me-2"></i>
        //                 ${partner.company_name}
        //             </div>
        //             <div class="info-grid">
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-hash me-1 text-muted"></i>
        //                         To'liq sherikning identifikatori (ID)
        //                     </span>
        //                     <span class="info-value">${partner.id}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-building me-1 text-muted"></i>
        //                         Korxona to'liq nomi
        //                     </span>
        //                     <span class="info-value">${partner.company_name}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-card-text me-1 text-muted"></i>
        //                         INN
        //                     </span>
        //                     <span class="info-value">${partner.inn}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-upc-scan me-1 text-muted"></i>
        //                         IFUT kodi
        //                     </span>
        //                     <span class="info-value">${partner.ifut}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-briefcase me-1 text-muted"></i>
        //                         Faoliyat turi
        //                     </span>
        //                     <span class="info-value">${partner.type}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-geo-alt me-1 text-muted"></i>
        //                         Manzil
        //                     </span>
        //                     <span class="info-value">${partner.address}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-person-badge me-1 text-muted"></i>
        //                         Direktor F.I.O.
        //                     </span>
        //                     <span class="info-value">${partner.director}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-telephone me-1 text-muted"></i>
        //                         Bog'lanish uchun telefon raqami
        //                     </span>
        //                     <span class="info-value">${partner.phone}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-envelope me-1 text-muted"></i>
        //                         Email
        //                     </span>
        //                     <span class="info-value">${partner.email}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-calendar-check me-1 text-muted"></i>
        //                         Ro'yxatdan o'tkazilgan sana
        //                     </span>
        //                     <span class="info-value">${partner.registration_date}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-file-earmark-text me-1 text-muted"></i>
        //                         Ro'yxatdan o'tkazish raqami
        //                     </span>
        //                     <span class="info-value">${partner.registration_number}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-building-check me-1 text-muted"></i>
        //                         Ro'yxatdan o'tkazuvchi davlat tashkiloti nomi
        //                     </span>
        //                     <span class="info-value">${partner.registration_org}</span>
        //                 </div>
        //                 ${partner.type === 'YaTT' ? `
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-person-vcard me-1 text-muted"></i>
        //                         Pasport ma'lumoti
        //                     </span>
        //                     <span class="info-value">${partner.passport_data}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-fingerprint me-1 text-muted"></i>
        //                         JSHSHIR
        //                     </span>
        //                     <span class="info-value">${partner.pinfl}</span>
        //                 </div>
        //                 ` : ''}
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-toggle-on me-1 text-muted"></i>
        //                         Akkount holati
        //                     </span>
        //                     <span class="info-value">
        //                         ${partner.account_status === 'active'
        //                 ? '<span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Faol</span>'
        //                 : '<span class="status-badge status-inactive"><i class="bi bi-x-circle me-1"></i>Bloklangan</span>'}
        //                     </span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-handshake me-1 text-muted"></i>
        //                         To'liq sheriklik holati sanasi
        //                     </span>
        //                     <span class="info-value">${partner.partnership_date}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-file-earmark-pdf me-1 text-muted"></i>
        //                         Investorlik sertifikati fayli
        //                     </span>
        //                     <span class="info-value">${partner.investor_certificate}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-cash-stack me-1 text-muted"></i>
        //                         Loyihadagi jami ulushi (summada)
        //                     </span>
        //                     <span class="info-value">${formatMoney(partner.share_amount)}</span>
        //                 </div>
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-percent me-1 text-muted"></i>
        //                         Loyihadagi jami ulushi (foizda)
        //                     </span>
        //                     <span class="info-value">${partner.share_percent}%</span>
        //                 </div>
        //             </div>
        //         </div>
        //     `).join('');
        //     } else {
        //         // Tahrirlash rejimi
        //         container.innerHTML = partners.map((partner, index) => `
        //         <div class="partner-card" style="margin-bottom: 1.5rem; border: 2px solid var(--gray-200);">
        //             <div class="d-flex justify-content-between align-items-center mb-3">
        //                 <div class="partner-header mb-0">
        //                     <i class="bi bi-building me-2"></i>
        //                     Sherik #${index + 1}
        //                 </div>
        //                 <button type="button" class="btn btn-danger btn-sm" onclick="deletePartner(${partner.id})">
        //                     <i class="bi bi-trash me-1"></i>
        //                     O'chirish
        //                 </button>
        //             </div>

        //             <div class="info-grid">
        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-building me-1 text-muted"></i>
        //                         Korxona to'liq nomi
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.company_name)}"
        //                         onchange="updatePartnerField(${partner.id}, 'company_name', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-card-text me-1 text-muted"></i>
        //                         INN
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.inn)}"
        //                         onchange="updatePartnerField(${partner.id}, 'inn', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-upc-scan me-1 text-muted"></i>
        //                         IFUT kodi
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.ifut)}"
        //                         onchange="updatePartnerField(${partner.id}, 'ifut', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-briefcase me-1 text-muted"></i>
        //                         Faoliyat turi
        //                     </span>
        //                     <select class="form-select form-select-sm" onchange="updatePartnerField(${partner.id}, 'type', this.value)">
        //                         <option value="MChJ" ${partner.type === 'MChJ' ? 'selected' : ''}>MChJ</option>
        //                         <option value="YaTT" ${partner.type === 'YaTT' ? 'selected' : ''}>YaTT</option>
        //                         <option value="QMJ" ${partner.type === 'QMJ' ? 'selected' : ''}>QMJ</option>
        //                         <option value="OAJ" ${partner.type === 'OAJ' ? 'selected' : ''}>OAJ</option>
        //                     </select>
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-geo-alt me-1 text-muted"></i>
        //                         Manzil
        //                     </span>
        //                     <textarea class="form-control form-control-sm" rows="2"
        //                         onchange="updatePartnerField(${partner.id}, 'address', this.value)">${uiEscapeHtml(partner.address)}</textarea>
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-person-badge me-1 text-muted"></i>
        //                         Direktor F.I.O.
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.director)}"
        //                         onchange="updatePartnerField(${partner.id}, 'director', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-telephone me-1 text-muted"></i>
        //                         Telefon raqami
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.phone)}"
        //                         onchange="updatePartnerField(${partner.id}, 'phone', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-envelope me-1 text-muted"></i>
        //                         Email
        //                     </span>
        //                     <input type="email" class="form-control form-control-sm" value="${uiEscapeHtml(partner.email)}"
        //                         onchange="updatePartnerField(${partner.id}, 'email', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-calendar-check me-1 text-muted"></i>
        //                         Ro'yxatdan o'tkazilgan sana
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.registration_date)}"
        //                         onchange="updatePartnerField(${partner.id}, 'registration_date', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-file-earmark-text me-1 text-muted"></i>
        //                         Ro'yxatdan o'tkazish raqami
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.registration_number)}"
        //                         onchange="updatePartnerField(${partner.id}, 'registration_number', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-building-check me-1 text-muted"></i>
        //                         Ro'yxatdan o'tkazuvchi tashkilot
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.registration_org)}"
        //                         onchange="updatePartnerField(${partner.id}, 'registration_org', this.value)">
        //                 </div>

        //                 <div class="info-row" id="partnerPassportRow_${partner.id}" style="display: ${partner.type === 'YaTT' ? 'grid' : 'none'}">
        //                     <span class="info-label">
        //                         <i class="bi bi-person-vcard me-1 text-muted"></i>
        //                         Pasport ma'lumoti
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.passport_data || '')}"
        //                         onchange="updatePartnerField(${partner.id}, 'passport_data', this.value)">
        //                 </div>

        //                 <div class="info-row" id="partnerPinflRow_${partner.id}" style="display: ${partner.type === 'YaTT' ? 'grid' : 'none'}">
        //                     <span class="info-label">
        //                         <i class="bi bi-fingerprint me-1 text-muted"></i>
        //                         JSHSHIR
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.pinfl || '')}"
        //                         onchange="updatePartnerField(${partner.id}, 'pinfl', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-toggle-on me-1 text-muted"></i>
        //                         Akkount holati
        //                     </span>
        //                     <select class="form-select form-select-sm" onchange="updatePartnerField(${partner.id}, 'account_status', this.value)">
        //                         <option value="active" ${partner.account_status === 'active' ? 'selected' : ''}>Faol</option>
        //                         <option value="blocked" ${partner.account_status === 'blocked' ? 'selected' : ''}>Bloklangan</option>
        //                     </select>
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-handshake me-1 text-muted"></i>
        //                         To'liq sheriklik holati sanasi
        //                     </span>
        //                     <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.partnership_date)}"
        //                         onchange="updatePartnerField(${partner.id}, 'partnership_date', this.value)">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-cash-stack me-1 text-muted"></i>
        //                         Loyihadagi jami ulushi (summada)
        //                     </span>
        //                     <input type="number" class="form-control form-control-sm" value="${partner.share_amount}"
        //                         onchange="updatePartnerField(${partner.id}, 'share_amount', Number(this.value))">
        //                 </div>

        //                 <div class="info-row">
        //                     <span class="info-label">
        //                         <i class="bi bi-percent me-1 text-muted"></i>
        //                         Loyihadagi jami ulushi (foizda)
        //                     </span>
        //                     <input type="number" class="form-control form-control-sm" value="${partner.share_percent}"
        //                         min="0" max="100" step="0.1"
        //                         onchange="updatePartnerField(${partner.id}, 'share_percent', Number(this.value))">
        //                 </div>
        //             </div>
        //         </div>
        //     `).join('');
        //     }
        // }

        function updatePartnerField(partnerId, field, value) {
            if (!projectData || !Array.isArray(projectData.partners)) return;

            const partner = projectData.partners.find(p => p.id === partnerId);
            if (!partner) return;

            partner[field] = value;

            // Agar faoliyat turi o'zgarsa, YaTT maydonlarini ko'rsatish/yashirish
            if (field === 'type') {
                const passportRow = document.getElementById(`partnerPassportRow_${partnerId}`);
                const pinflRow = document.getElementById(`partnerPinflRow_${partnerId}`);

                if (passportRow && pinflRow) {
                    const showYaTTFields = value === 'YaTT';
                    passportRow.style.display = showYaTTFields ? 'grid' : 'none';
                    pinflRow.style.display = showYaTTFields ? 'grid' : 'none';
                }
            }
        }

        function addNewPartner() {
            if (!projectData) return;
            if (!Array.isArray(projectData.partners)) projectData.partners = [];

            const newPartner = {
                id: nextPartnerId++,
                company_name: "Yangi sherik",
                inn: "",
                ifut: "",
                type: "MChJ",
                address: "",
                director: "",
                phone: "",
                email: "",
                registration_date: "",
                registration_number: "",
                registration_org: "",
                passport_data: "",
                pinfl: "",
                account_status: "active",
                partnership_date: "",
                investor_certificate: "",
                share_amount: 0,
                share_percent: 0
            };

            projectData.partners.push(newPartner);
            displayPartners(projectData.partners);

            showToast('Yangi sherik qo\'shildi', 'success');
        }

        function deletePartner(partnerId) {
            if (!projectData || !Array.isArray(projectData.partners)) return;

            if (confirm('Bu sherikni o\'chirishni xohlaysizmi?')) {
                projectData.partners = projectData.partners.filter(p => p.id !== partnerId);
                displayPartners(projectData.partners);
                showToast('Sherik o\'chirildi', 'success');
            }
        }

        function savePartnersChanges() {
            // Bu yerda API ga yuborish kodi bo'ladi
            console.log('Sheriklar ma\'lumotlari saqlandi:', projectData.partners);
            showToast('Sheriklar ma\'lumotlari muvaffaqiyatli saqlandi', 'success');
        }

        let stagesEditMode = false;
        let nextStageId = 1;
        let stageInsertAfterId = '';
        let dragStageId = null;

        function setStageInsertAfter(v) {
            stageInsertAfterId = (v === null || v === undefined) ? '' : String(v);
        }

        function buildStageInsertAfterSelect() {
            const sel = document.getElementById('stageInsertAfterSelect');
            if (!sel || !projectData || !Array.isArray(projectData.stages)) return;

            uiEnsurePriority(projectData.stages, 'order');

            const opts = ['<option value="">Oxiriga qo‘shish</option>']
                .concat(projectData.stages.map(s =>
                    `<option value="${s.id}">#${s.order} — ${uiEscapeHtml(s.name)}</option>`
                ));

            sel.innerHTML = opts.join('');
            sel.value = stageInsertAfterId;
        }

        function addNewStage() {
            if (!projectData || !Array.isArray(projectData.stages)) return;

            uiEnsurePriority(projectData.stages, 'order');

            const newStage = {
                id: nextStageId++,
                name: 'Yangi bosqich',
                status: 'planned',
                icon: 'bi-circle',
                order: projectData.stages.length + 1,
                start_date: '',
                end_date: '',
                progress: 0
            };

            const afterId = stageInsertAfterId;
            if (afterId) {
                const idx = projectData.stages.findIndex(s => String(s.id) === String(afterId));
                if (idx === -1) projectData.stages.push(newStage);
                else projectData.stages.splice(idx + 1, 0, newStage);
            } else {
                projectData.stages.push(newStage);
            }

            uiEnsurePriority(projectData.stages, 'order');
            displayStages(projectData.stages);
            buildStageInsertAfterSelect();
        }

        function buildStageMoveAfterSelect(stageId) {
            if (!projectData || !Array.isArray(projectData.stages)) return '';

            uiEnsurePriority(projectData.stages, 'order');

            const options = ['<option value="">Boshiga</option>']
                .concat(
                    projectData.stages
                        .filter(s => String(s.id) !== String(stageId))
                        .map(s => `<option value="${s.id}">#${s.order} — ${uiEscapeHtml(s.name)}</option>`)
                );

            return `<select class="form-select form-select-sm" onchange="moveStageToAfter(${stageId}, this.value)">
                                                                                                                                            ${options.join('')}
                                                                                                                                        </select>`;
        }

        function moveStageToAfter(stageId, afterId) {
            if (!projectData || !Array.isArray(projectData.stages)) return;

            uiEnsurePriority(projectData.stages, 'order');

            const list = projectData.stages.slice();
            const fromIndex = list.findIndex(s => String(s.id) === String(stageId));
            if (fromIndex === -1) return;

            const [moved] = list.splice(fromIndex, 1);

            if (!afterId) list.unshift(moved);
            else {
                const toIndex = list.findIndex(s => String(s.id) === String(afterId));
                if (toIndex === -1) list.push(moved);
                else list.splice(toIndex + 1, 0, moved);
            }

            projectData.stages = list;
            uiEnsurePriority(projectData.stages, 'order');
            displayStages(projectData.stages);
            buildStageInsertAfterSelect();
        }

        function onStageDragStart(e, stageId) {
            dragStageId = stageId;
            try { e.dataTransfer.setData('text/plain', String(stageId)); } catch (err) { }
            e.dataTransfer.effectAllowed = 'move';
        }

        function onStageDragOver(e, targetId) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            const target = document.querySelector(`.stage-item[data-stage-id="${targetId}"]`);
            if (target) target.classList.add('is-drag-over');
        }

        function onStageDragLeave(e, targetId) {
            const target = document.querySelector(`.stage-item[data-stage-id="${targetId}"]`);
            if (target) target.classList.remove('is-drag-over');
        }

        function onStageDrop(e, targetId) {
            e.preventDefault();

            const targetEl = document.querySelector(`.stage-item[data-stage-id="${targetId}"]`);
            if (targetEl) targetEl.classList.remove('is-drag-over');

            const draggedId = dragStageId || (function () {
                try { return e.dataTransfer.getData('text/plain'); } catch (err) { return null; }
            })();

            if (!draggedId || String(draggedId) === String(targetId)) return;
            if (!projectData || !Array.isArray(projectData.stages)) return;

            uiEnsurePriority(projectData.stages, 'order');

            const list = projectData.stages.slice();
            const fromIndex = list.findIndex(s => String(s.id) === String(draggedId));
            const toIndex = list.findIndex(s => String(s.id) === String(targetId));
            if (fromIndex === -1 || toIndex === -1) return;

            const [dragged] = list.splice(fromIndex, 1);

            const rect = targetEl ? targetEl.getBoundingClientRect() : null;
            const placeAfter = rect ? ((e.clientY - rect.top) > rect.height / 2) : true;

            const insertIndex = (fromIndex < toIndex)
                ? (placeAfter ? toIndex : toIndex - 1)
                : (placeAfter ? toIndex + 1 : toIndex);

            const safeIndex = Math.max(0, Math.min(insertIndex, list.length));
            list.splice(safeIndex, 0, dragged);

            projectData.stages = list;
            uiEnsurePriority(projectData.stages, 'order');
            displayStages(projectData.stages);
            buildStageInsertAfterSelect();
        }


        function displayStages(stages) {
            if (!Array.isArray(stages)) stages = [];
            if (projectData && Array.isArray(projectData.stages)) {
                uiEnsurePriority(projectData.stages, 'order');
                stages = projectData.stages;
            } else {
                uiEnsurePriority(stages, 'order');
            }

            const totalProgress = stages.reduce((sum, stage) => {
                return sum + (stage.status === 'completed' ? (Number(stage.progress) || 0) : 0);
            }, 0);

            const progressBar = document.getElementById('progressBar');
            const progressBarLabel = document.getElementById('progressBarLabel');

            const progress = Math.min(100, Math.max(0, totalProgress));
            if (progressBar) progressBar.style.width = progress + '%';
            if (progressBarLabel) progressBarLabel.textContent = progress + '%';
            if (progressBar && !progressBarLabel) progressBar.textContent = progress + '%';

            const timeline = document.getElementById('timeline');
            timeline.innerHTML = '';

            const statusMap = {
                'completed': {
                    icon: 'bi-check-circle',
                    badgeClass: 'badge-stage-status badge-stage-completed',
                    text: 'Bajarildi'
                },
                'in_progress': {
                    icon: 'bi-arrow-clockwise',
                    badgeClass: 'badge-stage-status badge-stage-in-progress',
                    text: 'Jarayonda'
                },
                'planned': {
                    icon: 'bi-circle',
                    badgeClass: 'badge-stage-status badge-stage-planned',
                    text: 'Rejalashtirilgan'
                }
            };

            stages.forEach((stage, index) => {
                const status = statusMap[stage.status] || statusMap.planned;

                const itemEl = document.createElement('div');
                itemEl.className = 'list-group-item border-0 stage-item';
                itemEl.setAttribute('data-stage-id', stage.id);

                if (!stagesEditMode) {
                    itemEl.innerHTML = `
                                                                                                                                                    <div class="row ps-lg-1 align-items-center">
                                                                                                                                                        <div class="col-auto">
                                                                                                                                                            <div class="${status.badgeClass}">
                                                                                                                                                                <i class="${status.icon}"></i>
                                                                                                                                                                ${status.text}
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col ms-n2 mb-2">
                                                                                                                                                            <h3 class="fs-6 fw-bold mb-1">${stage.name}</h3>
                                                                                                                                                            <div class="d-flex align-items-center small text-muted">
                                                                                                                                                                <i class="bi bi-calendar3 me-1"></i>
                                                                                                                                                                <span>${stage.start_date} - ${stage.end_date}</span>
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-auto">
                                                                                                                                                            <span class="badge bg-white text-dark">${Number(stage.progress) || 0}%</span>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                `;
                } else {
                    itemEl.setAttribute('draggable', 'true');
                    itemEl.setAttribute('ondragstart', `onStageDragStart(event, ${stage.id})`);
                    itemEl.setAttribute('ondragover', `onStageDragOver(event, ${stage.id})`);
                    itemEl.setAttribute('ondragleave', `onStageDragLeave(event, ${stage.id})`);
                    itemEl.setAttribute('ondrop', `onStageDrop(event, ${stage.id})`);

                    itemEl.innerHTML = `
                                                                                                                                                    <div class="row ps-lg-1 align-items-start gy-2">
                                                                                                                                                        <div class="col-auto">
                                                                                                                                                            <div class="drag-handle" title="Joyini o‘zgartirish">
                                                                                                                                                                <i class="bi bi-grip-vertical"></i>
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-auto">
                                                                                                                                                            <span class="priority-pill">#${stage.order}</span>
                                                                                                                                                        </div>

                                                                                                                                                        <div class="col-12 col-md-4">
                                                                                                                                                            <label class="form-label small mb-1">Bosqich nomi</label>
                                                                                                                                                            <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(stage.name)}"
                                                                                                                                                                onchange="updateStageField(${stage.id}, 'name', this.value)">
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-6 col-md-3">
                                                                                                                                                            <label class="form-label small mb-1">Holati</label>
                                                                                                                                                            <select class="form-select form-select-sm"
                                                                                                                                                                onchange="updateStageField(${stage.id}, 'status', this.value)">
                                                                                                                                                                <option value="planned" ${stage.status === 'planned' ? 'selected' : ''}>Rejalashtirilgan</option>
                                                                                                                                                                <option value="in_progress" ${stage.status === 'in_progress' ? 'selected' : ''}>Jarayonda</option>
                                                                                                                                                                <option value="completed" ${stage.status === 'completed' ? 'selected' : ''}>Bajarildi</option>
                                                                                                                                                            </select>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-6 col-md-2">
                                                                                                                                                            <label class="form-label small mb-1">% bajarilgan</label>
                                                                                                                                                            <input type="number" min="0" max="100" class="form-control form-control-sm" value="${Number(stage.progress) || 0}"
                                                                                                                                                                onchange="updateStageField(${stage.id}, 'progress', Number(this.value) || 0)">
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-6 col-md-1">
                                                                                                                                                            <label class="form-label small mb-1">Boshlanish</label>
                                                                                                                                                            <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(stage.start_date || '')}"
                                                                                                                                                                onchange="updateStageField(${stage.id}, 'start_date', this.value)">
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-6 col-md-1">
                                                                                                                                                            <label class="form-label small mb-1">Yakun</label>
                                                                                                                                                            <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(stage.end_date || '')}"
                                                                                                                                                                onchange="updateStageField(${stage.id}, 'end_date', this.value)">
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-12 col-md-2">
                                                                                                                                                            <label class="form-label small mb-1">Joylashuvi</label>
                                                                                                                                                            ${buildStageMoveAfterSelect(stage.id)}
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                `;
                }

                timeline.appendChild(itemEl);
            });

            buildStageInsertAfterSelect();
        }

        function toggleStagesEdit() {
            stagesEditMode = !stagesEditMode;

            const btn = document.getElementById('toggleStagesEditBtn');
            const addBtn = document.getElementById('addStageBtn');
            const tools = document.getElementById('stagesTools');
            const hint = document.getElementById('stagesHint');

            if (btn) {
                btn.innerHTML = stagesEditMode
                    ? '<i class="bi bi-check-lg me-1"></i> Saqlash'
                    : '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
            }

            uiToggleEditButton(btn, stagesEditMode);

            if (addBtn) addBtn.classList.toggle('d-none', !stagesEditMode);
            if (tools) tools.classList.toggle('active', stagesEditMode);
            if (hint) hint.classList.toggle('active', stagesEditMode);

            buildStageInsertAfterSelect();
            displayStages(projectData.stages || []);
        }

        function updateStageField(stageId, field, value) {
            if (!projectData || !Array.isArray(projectData.stages)) return;
            const stage = projectData.stages.find(s => String(s.id) === String(stageId));
            if (!stage) return;

            stage[field] = value;
            displayStages(projectData.stages);
        }

        let distributionEditMode = false;

        function displayDistribution(distribution) {
            if (!distribution) return;

            const content = document.getElementById('distributionContent');

            if (!distributionEditMode) {
                // Ko'rish rejimi
                content.innerHTML = `
                                                                                                                                                <div class="info-row">
                                                                                                                                                    <span class="info-label">To'liq sherikning investitsion loyihadagi o'ziga tegishli ulushining
                                                                                                                                                        realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                                                                                                                                                    <span class="info-value" id="fullPartnerOwnShare">${distribution.full_partner_own_share}%</span>
                                                                                                                                                </div>
                                                                                                                                                <div class="info-row">
                                                                                                                                                    <span class="info-label">To'liq sherikning investitsion Kommanditchilarning loyihadagi tegishli
                                                                                                                                                        ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                                                                                                                                                    <span class="info-value" id="fullPartnerInvestorShare">${distribution.full_partner_investor_share}%</span>
                                                                                                                                                </div>
                                                                                                                                                <div class="info-row">
                                                                                                                                                    <span class="info-label">Kommanditchilarning investitsion loyihadagi o'ziga tegishli ulushining
                                                                                                                                                        realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                                                                                                                                                    <span class="info-value" id="investorsOwnShare">${distribution.investors_own_share}%</span>
                                                                                                                                                </div>
                                                                                                                                            `;
            } else {
                // Tahrirlash rejimi
                content.innerHTML = `
                                                                                                                                                <div class="info-row">
                                                                                                                                                    <span class="info-label">To'liq sherikning investitsion loyihadagi o'ziga tegishli ulushining
                                                                                                                                                        realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                                                                                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                                                                                        <input type="number" min="0" max="100" step="0.1" 
                                                                                                                                                            class="form-control form-control-sm" style="max-width: 120px;" 
                                                                                                                                                            value="${distribution.full_partner_own_share}"
                                                                                                                                                            disabled
                                                                                                                                                            id="editFullPartnerOwnShare">
                                                                                                                                                        <span class="text-muted">%</span>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="info-row">
                                                                                                                                                    <span class="info-label">To'liq sherikning investitsion Kommanditchilarning loyihadagi tegishli
                                                                                                                                                        ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                                                                                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                                                                                        <input type="number" min="0" max="100" step="0.1" 
                                                                                                                                                            class="form-control form-control-sm" style="max-width: 120px;" 
                                                                                                                                                            value="${distribution.full_partner_investor_share}"
                                                                                                                                                            onchange="updateDistributionField('full_partner_investor_share', Number(this.value) || 0)"
                                                                                                                                                            id="editFullPartnerInvestorShare">
                                                                                                                                                        <span class="text-muted">%</span>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="info-row">
                                                                                                                                                    <span class="info-label">Kommanditchilarning investitsion loyihadagi o'ziga tegishli ulushining
                                                                                                                                                        realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                                                                                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                                                                                        <input type="number" min="0" max="100" step="0.1" 
                                                                                                                                                            class="form-control form-control-sm" style="max-width: 120px;" 
                                                                                                                                                            value="${distribution.investors_own_share}"
                                                                                                                                                            disabled
                                                                                                                                                            id="editInvestorsOwnShare">
                                                                                                                                                        <span class="text-muted">%</span>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            `;
            }

            // Vizual taqsimotni yangilash
            updateDistributionVisual(distribution);
        }

        function updateDistributionVisual(distribution) {
            const partnersPercent = distribution.full_partner_investor_share;
            const investorsPercent = distribution.investors_own_share;

            const partnersSegment = document.getElementById('partnersSegment');
            const investorsSegment = document.getElementById('investorsSegment');

            if (partnersSegment && investorsSegment) {
                partnersSegment.style.width = partnersPercent + '%';
                partnersSegment.textContent = `To'liq sheriklar: ${partnersPercent}%`;

                investorsSegment.style.width = investorsPercent + '%';
                investorsSegment.textContent = `Kommanditchilar: ${investorsPercent}%`;
            }
        }

        function toggleDistributionEdit() {
            distributionEditMode = !distributionEditMode;
            const btn = document.getElementById('toggleDistributionEditBtn');
            btn.innerHTML = distributionEditMode ?
                '<i class="bi bi-check-lg me-1"></i> Saqlash' :
                '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

            if (projectData && projectData.distribution) {
                displayDistribution(projectData.distribution);
            }
        }

        function updateDistributionField(field, value) {
            if (!projectData || !projectData.distribution) return;

            // Faqat to'liq sherik ulushi tahrirlanadi
            if (field !== 'full_partner_investor_share') return;

            // Qiymatni cheklash
            if (value < 0) value = 0;
            if (value > 100) value = 100;

            projectData.distribution[field] = value;

            // Agar full_partner_investor_share o'zgarsa, investors_own_share ni avtomatik hisoblaymiz
            if (field === 'full_partner_investor_share') {
                projectData.distribution.investors_own_share = 100 - value;
                // Input qiymatini yangilaymiz
                const investorsInput = document.getElementById('editInvestorsOwnShare');
                if (investorsInput) {
                    investorsInput.value = projectData.distribution.investors_own_share;
                }
            }

            // Agar investors_own_share o'zgarsa, full_partner_investor_share ni avtomatik hisoblaymiz
            if (field === 'investors_own_share') {
                projectData.distribution.full_partner_investor_share = 100 - value;
                // Input qiymatini yangilaymiz
                const partnerInput = document.getElementById('editFullPartnerInvestorShare');
                if (partnerInput) {
                    partnerInput.value = projectData.distribution.full_partner_investor_share;
                }
            }

            // Vizual taqsimotni yangilash
            updateDistributionVisual(projectData.distribution);
        }

        let roundsEditMode = false;
        let nextRoundId = 4; // Yangi raundlar uchun ID
        let roundInsertAfterId = '';

        let dragRoundId = null;

        function uiEscapeHtml(str) {
            return String(str ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function uiToggleEditButton(btn, isEditMode) {
            if (!btn) return;
            btn.classList.toggle('btn-outline-secondary', !isEditMode);
            btn.classList.toggle('btn-success', isEditMode);
        }

        function uiEnsurePriority(list, key) {
            if (!Array.isArray(list)) return [];
            list.forEach((it, idx) => {
                const v = Number(it[key]);
                if (!Number.isFinite(v) || v <= 0) it[key] = idx + 1;
            });
            list.sort((a, b) => Number(a[key]) - Number(b[key]));
            list.forEach((it, idx) => (it[key] = idx + 1));
            return list;
        }

        function setRoundInsertAfter(v) {
            roundInsertAfterId = (v === null || v === undefined) ? '' : String(v);
        }

        function buildRoundInsertAfterSelect() {
            const sel = document.getElementById('roundInsertAfterSelect');
            if (!sel || !projectData || !Array.isArray(projectData.rounds)) return;

            uiEnsurePriority(projectData.rounds, 'priority');

            const opts = [
                `<option value="">Oxiriga qo‘shish</option>`,
                ...projectData.rounds.map(r => `<option value="${r.id}">#${r.priority} — ${uiEscapeHtml(r.name)}</option>`)
            ];

            sel.innerHTML = opts.join('');
            sel.value = roundInsertAfterId;
        }

        function buildRoundMoveAfterSelect(roundId) {
            if (!projectData || !Array.isArray(projectData.rounds)) return '';
            uiEnsurePriority(projectData.rounds, 'priority');

            const options = [
                `<option value="">Boshiga</option>`,
                ...projectData.rounds
                    .filter(r => r.id !== roundId)
                    .map(r => `<option value="${r.id}">#${r.priority} — ${uiEscapeHtml(r.name)}</option>`)
            ];

            return `<select class="form-select form-select-sm" onchange="moveRoundToAfter(${roundId}, this.value)">
                                                                                                                                            ${options.join('')}
                                                                                                                                        </select>`;
        }

        function moveRoundToAfter(roundId, afterId) {
            if (!projectData || !Array.isArray(projectData.rounds)) return;

            uiEnsurePriority(projectData.rounds, 'priority');

            const draggedId = roundId;
            const targetId = (afterId === null || afterId === undefined) ? '' : String(afterId);

            if (targetId === String(draggedId)) return;

            const list = projectData.rounds.slice();
            const draggedIndex = list.findIndex(r => String(r.id) === String(draggedId));
            if (draggedIndex === -1) return;

            const [dragged] = list.splice(draggedIndex, 1);

            if (targetId === '') {
                list.unshift(dragged);
            } else {
                const targetIndex = list.findIndex(r => String(r.id) === String(targetId));
                if (targetIndex === -1) {
                    list.push(dragged);
                } else {
                    list.splice(targetIndex + 1, 0, dragged);
                }
            }

            projectData.rounds = list;
            uiEnsurePriority(projectData.rounds, 'priority');
            displayRounds(projectData.rounds);
        }

        function onRoundDragStart(e, roundId) {
            dragRoundId = roundId;
            try {
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', String(roundId));
            } catch (err) { }
        }

        function onRoundDragOver(e, targetId) {
            e.preventDefault();
            const el = document.querySelector(`.round-item[data-round-id="${targetId}"]`);
            if (el) el.classList.add('is-drag-over');
        }

        function onRoundDragLeave(e, targetId) {
            const el = document.querySelector(`.round-item[data-round-id="${targetId}"]`);
            if (el) el.classList.remove('is-drag-over');
        }

        function onRoundDrop(e, targetId) {
            e.preventDefault();

            const targetEl = document.querySelector(`.round-item[data-round-id="${targetId}"]`);
            if (targetEl) targetEl.classList.remove('is-drag-over');

            const draggedId = dragRoundId || (function () {
                try { return e.dataTransfer.getData('text/plain'); } catch (err) { return null; }
            })();

            if (!draggedId || String(draggedId) === String(targetId)) return;
            if (!projectData || !Array.isArray(projectData.rounds)) return;

            uiEnsurePriority(projectData.rounds, 'priority');

            const rect = targetEl ? targetEl.getBoundingClientRect() : null;
            const placeAfter = rect ? ((e.clientY - rect.top) > rect.height / 2) : true;

            const list = projectData.rounds.slice();
            const fromIndex = list.findIndex(r => String(r.id) === String(draggedId));
            const toIndex = list.findIndex(r => String(r.id) === String(targetId));
            if (fromIndex === -1 || toIndex === -1) return;

            const [dragged] = list.splice(fromIndex, 1);
            const insertIndex = (fromIndex < toIndex)
                ? (placeAfter ? toIndex : toIndex - 1)
                : (placeAfter ? toIndex + 1 : toIndex);

            const safeIndex = Math.max(0, Math.min(insertIndex, list.length));
            list.splice(safeIndex, 0, dragged);

            projectData.rounds = list;
            uiEnsurePriority(projectData.rounds, 'priority');
            displayRounds(projectData.rounds);
        }

        function displayRounds(rounds) {
            const container = document.getElementById('roundsContainer');
            if (!container) return;

            const statusMap = {
                'in_progress': { text: 'Jarayonda', class: 'status-inprogress' },
                'completed': { text: 'Yakunlangan', class: 'status-completed' },
                'inactive': { text: 'Nofaol', class: 'status-inactive' }
            };

            if (!rounds || rounds.length === 0) {
                container.innerHTML = '<p class="text-muted text-center py-4">Raundlar mavjud emas</p>';
                buildRoundInsertAfterSelect();
                return;
            }

            uiEnsurePriority(rounds, 'priority');

            if (!roundsEditMode) {
                container.innerHTML = rounds.map(round => {
                    const status = statusMap[round.status] || statusMap['inactive'];
                    return `
                                                                                                                                            <div class="round-item">
                                                                                                                                                <div class="round-info">
                                                                                                                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                                                                                                                        <span class="priority-pill">#${round.priority}</span>
                                                                                                                                                        <h6 class="mb-0">${uiEscapeHtml(round.name)}</h6>
                                                                                                                                                    </div>
                                                                                                                                                    <span class="status-badge ${status.class}">${status.text}</span>
                                                                                                                                                </div>
                                                                                                                                                <div style="text-align: right;">
                                                                                                                                                    <div class="round-amount">${formatMoney(round.min_share)}</div>
                                                                                                                                                    <div style="font-size: 0.85rem; color: var(--gray-600);">Minimal ulush</div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                        `;
                }).join('');
            } else {
                container.innerHTML = rounds.map(round => {
                    const status = statusMap[round.status] || statusMap['inactive'];
                    const canDelete = String(round.status) === 'inactive';

                    return `
                                                                                                                                            <div class="round-item" data-round-id="${round.id}"
                                                                                                                                                 ondragover="onRoundDragOver(event, ${round.id})"
                                                                                                                                                 ondragleave="onRoundDragLeave(event, ${round.id})"
                                                                                                                                                 ondrop="onRoundDrop(event, ${round.id})"
                                                                                                                                                 style="flex-direction: column; align-items: stretch; gap: 1rem;">
                                                                                                                                                <div class="row g-2 align-items-end">
                                                                                                                                                    <div class="col-12 col-md-2">
                                                                                                                                                        <label class="form-label small mb-1">Tartib</label>
                                                                                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                                                                                            <div class="drag-handle" draggable="true"
                                                                                                                                                                 ondragstart="onRoundDragStart(event, ${round.id})"
                                                                                                                                                                 title="Ushlab torting">
                                                                                                                                                                <i class="bi bi-grip-vertical"></i>
                                                                                                                                                            </div>
                                                                                                                                                            <span class="priority-pill">#${round.priority}</span>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-12 col-md-3">
                                                                                                                                                        <label class="form-label small mb-1">Raund nomi</label>
                                                                                                                                                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(round.name)}"
                                                                                                                                                            onchange="updateRoundField(${round.id}, 'name', this.value)"
                                                                                                                                                            id="roundName_${round.id}">
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-6 col-md-2">
                                                                                                                                                        <label class="form-label small mb-1">Holati</label>
                                                                                                                                                        <select class="form-select form-select-sm"
                                                                                                                                                            onchange="updateRoundField(${round.id}, 'status', this.value)"
                                                                                                                                                            id="roundStatus_${round.id}">
                                                                                                                                                            <option value="inactive" ${round.status === 'inactive' ? 'selected' : ''}>Nofaol</option>
                                                                                                                                                            <option value="in_progress" ${round.status === 'in_progress' ? 'selected' : ''}>Jarayonda</option>
                                                                                                                                                            <option value="completed" ${round.status === 'completed' ? 'selected' : ''}>Yakunlangan</option>
                                                                                                                                                        </select>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-6 col-md-2">
                                                                                                                                                        <label class="form-label small mb-1">Minimal ulush (so'm)</label>
                                                                                                                                                        <input type="number" min="0" step="1000" class="form-control form-control-sm"
                                                                                                                                                            value="${Number(round.min_share) || 0}"
                                                                                                                                                            onchange="updateRoundField(${round.id}, 'min_share', Number(this.value) || 0)"
                                                                                                                                                            id="roundMinShare_${round.id}">
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-12 col-md-2">
                                                                                                                                                        <label class="form-label small mb-1">Joylashuvi</label>
                                                                                                                                                        ${buildRoundMoveAfterSelect(round.id)}
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-12 col-md-1 d-flex justify-content-end">
                                                                                                                                                        <button type="button" class="btn btn-danger btn-sm w-100"
                                                                                                                                                            ${canDelete ? '' : 'disabled'}
                                                                                                                                                            title="${canDelete ? ' ' : 'Faqat nofaol raundni o‘chirish mumkin'}"
                                                                                                                                                            onclick="deleteRound(${round.id})">
                                                                                                                                                            <i class="bi bi-trash"></i>
                                                                                                                                                            {{ __("admin.delete") }}
                                                                                                                                                        </button>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                        `;
                }).join('');
            }

            buildRoundInsertAfterSelect();
        }

        function toggleRoundsEdit() {
            roundsEditMode = !roundsEditMode;

            const btn = document.getElementById('toggleRoundsEditBtn');
            const addBtn = document.getElementById('addRoundBtn');
            const tools = document.getElementById('roundsTools');
            const hint = document.getElementById('roundsHint');

            if (btn) {
                btn.innerHTML = roundsEditMode
                    ? '<i class="bi bi-check-lg me-1"></i> Saqlash'
                    : '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
            }

            uiToggleEditButton(btn, roundsEditMode);

            if (addBtn) addBtn.classList.toggle('d-none', !roundsEditMode);
            if (tools) tools.classList.toggle('active', roundsEditMode);
            if (hint) hint.classList.toggle('active', roundsEditMode);

            buildRoundInsertAfterSelect();

            if (projectData && projectData.rounds) displayRounds(projectData.rounds);
        }

        function addNewRound() {
            if (!projectData || !Array.isArray(projectData.rounds)) return;

            uiEnsurePriority(projectData.rounds, 'priority');

            const newRound = {
                id: nextRoundId++,
                name: `Yangi raund`,
                status: 'inactive',
                min_share: 0,
                priority: projectData.rounds.length + 1
            };

            const afterId = roundInsertAfterId;
            if (afterId) {
                const idx = projectData.rounds.findIndex(r => String(r.id) === String(afterId));
                if (idx === -1) projectData.rounds.push(newRound);
                else projectData.rounds.splice(idx + 1, 0, newRound);
            } else {
                projectData.rounds.push(newRound);
            }

            uiEnsurePriority(projectData.rounds, 'priority');
            displayRounds(projectData.rounds);
        }

        function updateRoundField(roundId, field, value) {
            if (!projectData || !Array.isArray(projectData.rounds)) return;

            const round = projectData.rounds.find(r => r.id === roundId);
            if (!round) return;

            round[field] = value;

            if (field === 'status') {
                // delete cheklovi UI’da qayta hisoblanadi
            }

            if (roundsEditMode) displayRounds(projectData.rounds);
        }

        function deleteRound(roundId) {
            if (!projectData || !Array.isArray(projectData.rounds)) return;

            const round = projectData.rounds.find(r => r.id === roundId);
            if (!round) return;

            if (String(round.status) !== 'inactive') return;

            if (confirm('Bu raundni o\'chirishni xohlaysizmi?')) {
                projectData.rounds = projectData.rounds.filter(r => r.id !== roundId);
                uiEnsurePriority(projectData.rounds, 'priority');
                displayRounds(projectData.rounds);
            }
        }

        let currentDividendPage = 1;

        const itemsPerPage = 5;

        function displayFinancial(p) {
            document.getElementById('totalValue').textContent = formatMoney(p.total_value);
            document.getElementById('minShare').textContent = formatMoney(p.min_share);
            document.getElementById('yearlyProfit').textContent = p.yearly_profit + '%';
            document.getElementById('fundingStatus').textContent = p.funding_status + '%';
            document.getElementById('investmentPeriod').textContent = p.investment_period;
            document.getElementById('profitability').textContent = p.profitability;
            document.getElementById('distributionIndicators').textContent = p.distribution_indicators;
            document.getElementById('distributionStart').textContent = p.distribution_start;
            document.getElementById('lastDividend').textContent = p.last_dividend + '%';

            displayDividendHistory(p.dividend_history);
        }

        function displayDividendHistory(dividendHistory) {
            if (!dividendHistory || dividendHistory.length === 0) {
                document.getElementById('dividendHistory').innerHTML = `
                                                                                                                                                <div class="text-center py-4 text-muted">
                                                                                                                                                    <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                                                                                                                                    <p>Dividendlar tarixi mavjud emas</p>
                                                                                                                                                </div>
                                                                                                                                            `;
                const paginationEl = document.getElementById('dividendPagination');
                const summaryEl = document.getElementById('dividendSummary');
                if (paginationEl) paginationEl.innerHTML = '';
                if (summaryEl) summaryEl.textContent = '';
                return;
            }

            const totalPages = Math.ceil(dividendHistory.length / itemsPerPage);
            const startIndex = (currentDividendPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const paginatedItems = dividendHistory.slice(startIndex, endIndex);

            // Summary text (1 - 5 / Jami: 10) user page uslubida
            const total = dividendHistory.length;
            const start = startIndex + 1;
            const end = Math.min(endIndex, total);
            const summaryEl = document.getElementById('dividendSummary');
            if (summaryEl) {
                summaryEl.textContent = `${start} - ${end} / Jami: ${total}`;
            }

            const historyContainer = document.getElementById('dividendHistory');
            historyContainer.innerHTML = `
                                                                                                                                            <table class="table user-table table-bordered table-hover table-striped align-items-center">
                                                                                                                                                <thead class="table-dark">
                                                                                                                                                    <tr>
                                                                                                                                                        <th>
                                                                                                                                                            <i class="bi bi-calendar3 me-1"></i>
                                                                                                                                                            Sana
                                                                                                                                                        </th>
                                                                                                                                                        <th>
                                                                                                                                                            <i class="bi bi-percent me-1"></i>
                                                                                                                                                            Dividend foizi
                                                                                                                                                        </th>
                                                                                                                                                        <th>
                                                                                                                                                            <i class="bi bi-check-circle me-1"></i>
                                                                                                                                                            Holati
                                                                                                                                                        </th>
                                                                                                                                                    </tr>
                                                                                                                                                </thead>
                                                                                                                                                <tbody>
                                                                                                                                                    ${paginatedItems.map(item => {
                const statusClass = item.status === 'To\'langan' ? 'status-badge-paid' : 'status-badge-pending';
                const statusIcon = item.status === 'To\'langan' ? 'bi-check-circle-fill' : 'bi-clock';
                return `
                                                                                                                                                            <tr>
                                                                                                                                                                <td>
                                                                                                                                                                    <i class="bi bi-calendar-event me-1 text-muted"></i>
                                                                                                                                                                    <strong>${item.date}</strong>
                                                                                                                                                                </td>
                                                                                                                                                                <td>
                                                                                                                                                                    <span style="font-size: 1.1rem; font-weight: 600; color: var(--success-color);">
                                                                                                                                                                        ${item.amount}%
                                                                                                                                                                    </span>
                                                                                                                                                                </td>
                                                                                                                                                                <td>
                                                                                                                                                                    <span class="${statusClass}">
                                                                                                                                                                        <i class="bi ${statusIcon}"></i>
                                                                                                                                                                        ${item.status}
                                                                                                                                                                    </span>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                        `;
            }).join('')}
                                                                                                                                                </tbody>
                                                                                                                                            </table>
                                                                                                                                        `;

            // Pagination
            if (totalPages > 1) {
                displayDividendPagination(totalPages);
            } else {
                document.getElementById('dividendPagination').innerHTML = '';
            }
        }

        function displayDividendPagination(totalPages) {
            const paginationContainer = document.getElementById('dividendPagination');
            let paginationHTML = '<ul class="pagination pagination-sm mb-0 mt-2">';

            // Previous
            paginationHTML += `
                                                                                                                                            <li class="page-item ${currentDividendPage === 1 ? 'disabled' : ''}">
                                                                                                                                                <a class="page-link" href="javascript:void(0)" onclick="changeDividendPage(${currentDividendPage - 1})">
                                                                                                                                                    <i class="fa-solid fa-angle-left"></i>
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        `;

            // Page numbers (simple version: all pages, with active state)
            for (let i = 1; i <= totalPages; i++) {
                paginationHTML += `
                                                                                                                                                <li class="page-item ${i === currentDividendPage ? 'active' : ''}">
                                                                                                                                                    <a class="page-link" href="javascript:void(0)" onclick="changeDividendPage(${i})">
                                                                                                                                                        ${i}
                                                                                                                                                    </a>
                                                                                                                                                </li>
                                                                                                                                            `;
            }

            // Next
            paginationHTML += `
                                                                                                                                            <li class="page-item ${currentDividendPage === totalPages ? 'disabled' : ''}">
                                                                                                                                                <a class="page-link" href="javascript:void(0)" onclick="changeDividendPage(${currentDividendPage + 1})">
                                                                                                                                                    <i class="fa-solid fa-angle-right"></i>
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        `;

            paginationHTML += '</ul>';
            paginationContainer.innerHTML = paginationHTML;
        }

        function changeDividendPage(page) {
            if (page < 1 || !projectData || !projectData.dividend_history) return;
            const totalPages = Math.ceil(projectData.dividend_history.length / itemsPerPage);
            if (page > totalPages) return;

            currentDividendPage = page;
            displayDividendHistory(projectData.dividend_history);

            // Scroll to top of table
            const historyContainer = document.getElementById('dividendHistory');
            historyContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function displayPartners(partners) {
            const container = document.getElementById('partnersContainer');

            if (!partners || partners.length === 0) {
                container.innerHTML = '<p class="text-muted text-center py-4">To\'liq sheriklar mavjud emas</p>';
                return;
            }

            if (!partnersEditMode) {
                // Ko'rish rejimi
                container.innerHTML = partners.map(partner => `
                                                                                                                    <div class="partner-card" style="margin-bottom: 1.5rem;">
                                                                                                                        <div class="partner-header">
                                                                                                                            <i class="bi bi-building me-2"></i>
                                                                                                                            ${uiEscapeHtml(partner.company_name)}
                                                                                                                        </div>
                                                                                                                        <div class="info-grid">
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-hash me-1 text-muted"></i>
                                                                                                                                    To'liq sherikning identifikatori (ID)
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${partner.id}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-building me-1 text-muted"></i>
                                                                                                                                    Korxona to'liq nomi
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.company_name)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-card-text me-1 text-muted"></i>
                                                                                                                                    INN
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.inn)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-upc-scan me-1 text-muted"></i>
                                                                                                                                    IFUT kodi
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.ifut)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-briefcase me-1 text-muted"></i>
                                                                                                                                    Faoliyat turi
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.type)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-geo-alt me-1 text-muted"></i>
                                                                                                                                    Manzil
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.address)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-person-badge me-1 text-muted"></i>
                                                                                                                                    Direktor F.I.O.
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.director)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-telephone me-1 text-muted"></i>
                                                                                                                                    Bog'lanish uchun telefon raqami
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.phone)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-envelope me-1 text-muted"></i>
                                                                                                                                    Email
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.email)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-calendar-check me-1 text-muted"></i>
                                                                                                                                    Ro'yxatdan o'tkazilgan sana
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.registration_date)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-file-earmark-text me-1 text-muted"></i>
                                                                                                                                    Ro'yxatdan o'tkazish raqami
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.registration_number)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-building-check me-1 text-muted"></i>
                                                                                                                                    Ro'yxatdan o'tkazuvchi davlat tashkiloti nomi
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.registration_org)}</span>
                                                                                                                            </div>
                                                                                                                            ${partner.type === 'YaTT' ? `
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-person-vcard me-1 text-muted"></i>
                                                                                                                                    Pasport ma'lumoti
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.passport_data)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-fingerprint me-1 text-muted"></i>
                                                                                                                                    JSHSHIR
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.pinfl)}</span>
                                                                                                                            </div>
                                                                                                                            ` : ''}
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-toggle-on me-1 text-muted"></i>
                                                                                                                                    Akkount holati
                                                                                                                                </span>
                                                                                                                                <span class="info-value">
                                                                                                                                    ${partner.account_status === 'active'
                        ? '<span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Faol</span>'
                        : '<span class="status-badge status-inactive"><i class="bi bi-x-circle me-1"></i>Bloklangan</span>'}
                                                                                                                                </span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-handshake me-1 text-muted"></i>
                                                                                                                                    To'liq sheriklik holati sanasi
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.partnership_date)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-file-earmark-pdf me-1 text-muted"></i>
                                                                                                                                    Investorlik sertifikati fayli
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${uiEscapeHtml(partner.investor_certificate)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-cash-stack me-1 text-muted"></i>
                                                                                                                                    Loyihadagi jami ulushi (summada)
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${formatMoney(partner.share_amount)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-percent me-1 text-muted"></i>
                                                                                                                                    Loyihadagi jami ulushi (foizda)
                                                                                                                                </span>
                                                                                                                                <span class="info-value">${partner.share_percent}%</span>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                `).join('');
            } else {
                // Tahrirlash rejimi
                container.innerHTML = partners.map((partner, index) => `
                                                                                                                    <div class="partner-card" style="margin-bottom: 1.5rem; border: 2px solid var(--gray-200);">
                                                                                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                                                                                            <div class="partner-header mb-0">
                                                                                                                                <i class="bi bi-building me-2"></i>
                                                                                                                                Sherik #${index + 1}
                                                                                                                            </div>
                                                                                                                            <button type="button" class="btn btn-danger btn-sm" onclick="deletePartner(${partner.id})">
                                                                                                                                <i class="bi bi-trash me-1"></i>
                                                                                                                                O'chirish
                                                                                                                            </button>
                                                                                                                        </div>

                                                                                                                        <div class="info-grid">
                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-building me-1 text-muted"></i>
                                                                                                                                    Korxona to'liq nomi
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.company_name)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'company_name', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-card-text me-1 text-muted"></i>
                                                                                                                                    INN
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.inn)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'inn', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-upc-scan me-1 text-muted"></i>
                                                                                                                                    IFUT kodi
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.ifut)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'ifut', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-briefcase me-1 text-muted"></i>
                                                                                                                                    Faoliyat turi
                                                                                                                                </span>
                                                                                                                                <select class="form-select form-select-sm" onchange="updatePartnerField(${partner.id}, 'type', this.value)">
                                                                                                                                    <option value="MChJ" ${partner.type === 'MChJ' ? 'selected' : ''}>MChJ</option>
                                                                                                                                    <option value="YaTT" ${partner.type === 'YaTT' ? 'selected' : ''}>YaTT</option>
                                                                                                                                    <option value="QMJ" ${partner.type === 'QMJ' ? 'selected' : ''}>QMJ</option>
                                                                                                                                    <option value="OAJ" ${partner.type === 'OAJ' ? 'selected' : ''}>OAJ</option>
                                                                                                                                </select>
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-geo-alt me-1 text-muted"></i>
                                                                                                                                    Manzil
                                                                                                                                </span>
                                                                                                                                <textarea class="form-control form-control-sm" rows="2"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'address', this.value)">${uiEscapeHtml(partner.address)}</textarea>
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-person-badge me-1 text-muted"></i>
                                                                                                                                    Direktor F.I.O.
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.director)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'director', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-telephone me-1 text-muted"></i>
                                                                                                                                    Telefon raqami
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.phone)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'phone', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-envelope me-1 text-muted"></i>
                                                                                                                                    Email
                                                                                                                                </span>
                                                                                                                                <input type="email" class="form-control form-control-sm" value="${uiEscapeHtml(partner.email)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'email', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-calendar-check me-1 text-muted"></i>
                                                                                                                                    Ro'yxatdan o'tkazilgan sana
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.registration_date)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'registration_date', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-file-earmark-text me-1 text-muted"></i>
                                                                                                                                    Ro'yxatdan o'tkazish raqami
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.registration_number)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'registration_number', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-building-check me-1 text-muted"></i>
                                                                                                                                    Ro'yxatdan o'tkazuvchi tashkilot
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.registration_org)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'registration_org', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row" id="partnerPassportRow_${partner.id}" style="display: ${partner.type === 'YaTT' ? 'grid' : 'none'}">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-person-vcard me-1 text-muted"></i>
                                                                                                                                    Pasport ma'lumoti
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.passport_data || '')}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'passport_data', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row" id="partnerPinflRow_${partner.id}" style="display: ${partner.type === 'YaTT' ? 'grid' : 'none'}">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-fingerprint me-1 text-muted"></i>
                                                                                                                                    JSHSHIR
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.pinfl || '')}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'pinfl', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-toggle-on me-1 text-muted"></i>
                                                                                                                                    Akkount holati
                                                                                                                                </span>
                                                                                                                                <select class="form-select form-select-sm" onchange="updatePartnerField(${partner.id}, 'account_status', this.value)">
                                                                                                                                    <option value="active" ${partner.account_status === 'active' ? 'selected' : ''}>Faol</option>
                                                                                                                                    <option value="blocked" ${partner.account_status === 'blocked' ? 'selected' : ''}>Bloklangan</option>
                                                                                                                                </select>
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-handshake me-1 text-muted"></i>
                                                                                                                                    To'liq sheriklik holati sanasi
                                                                                                                                </span>
                                                                                                                                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.partnership_date)}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'partnership_date', this.value)">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-cash-stack me-1 text-muted"></i>
                                                                                                                                    Loyihadagi jami ulushi (summada)
                                                                                                                                </span>
                                                                                                                                <input type="number" class="form-control form-control-sm" value="${partner.share_amount}"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'share_amount', Number(this.value))">
                                                                                                                            </div>

                                                                                                                            <div class="info-row">
                                                                                                                                <span class="info-label">
                                                                                                                                    <i class="bi bi-percent me-1 text-muted"></i>
                                                                                                                                    Loyihadagi jami ulushi (foizda)
                                                                                                                                </span>
                                                                                                                                <input type="number" class="form-control form-control-sm" value="${partner.share_percent}"
                                                                                                                                    min="0" max="100" step="0.1"
                                                                                                                                    onchange="updatePartnerField(${partner.id}, 'share_percent', Number(this.value))">
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                `).join('');
            }
        }

        let risksEditMode = false;
        // let nextRiskId = 5; // Yangi risklar uchun ID
        // let riskInsertAfterId = '';
        // let dragRiskId = null;

        function setRiskInsertAfter(v) {
            riskInsertAfterId = (v === null || v === undefined) ? '' : String(v);
        }

        function uiEnsureRiskIds(list) {
            if (!Array.isArray(list)) return [];
            let maxId = 0;
            list.forEach(it => {
                const idNum = Number(it.id);
                if (Number.isFinite(idNum)) maxId = Math.max(maxId, idNum);
            });
            nextRiskId = Math.max(nextRiskId, maxId + 1);

            list.forEach(it => {
                if (it.id === undefined || it.id === null || it.id === '') {
                    it.id = nextRiskId++;
                }
            });

            return list;
        }

        function buildRiskInsertAfterSelect() {
            const sel = document.getElementById('riskInsertAfterSelect');
            if (!sel || !projectData || !projectData.risks || !Array.isArray(projectData.risks.risk_items)) return;

            uiEnsureRiskIds(projectData.risks.risk_items);
            uiEnsurePriority(projectData.risks.risk_items, 'priority');

            const opts = [
                `<option value="">Oxiriga qo‘shish</option>`,
                ...projectData.risks.risk_items.map(r => `<option value="${r.id}">#${r.priority} — ${uiEscapeHtml(r.name)}</option>`)
            ];

            sel.innerHTML = opts.join('');
            sel.value = riskInsertAfterId;
        }

        function buildRiskMoveAfterSelect(riskId) {
            if (!projectData || !projectData.risks || !Array.isArray(projectData.risks.risk_items)) return '';

            uiEnsureRiskIds(projectData.risks.risk_items);
            uiEnsurePriority(projectData.risks.risk_items, 'priority');

            const options = [
                `<option value="">Boshiga</option>`,
                ...projectData.risks.risk_items
                    .filter(r => String(r.id) !== String(riskId))
                    .map(r => `<option value="${r.id}">#${r.priority} — ${uiEscapeHtml(r.name)}</option>`)
            ];

            return `<select class="form-select form-select-sm" onchange="moveRiskToAfter(${riskId}, this.value)">
                                                                                                                                            ${options.join('')}
                                                                                                                                        </select>`;
        }

        function moveRiskToAfter(riskId, afterId) {
            if (!projectData || !projectData.risks || !Array.isArray(projectData.risks.risk_items)) return;

            uiEnsureRiskIds(projectData.risks.risk_items);
            uiEnsurePriority(projectData.risks.risk_items, 'priority');

            const draggedId = riskId;
            const targetId = (afterId === null || afterId === undefined) ? '' : String(afterId);
            if (targetId === String(draggedId)) return;

            const list = projectData.risks.risk_items.slice();
            const draggedIndex = list.findIndex(r => String(r.id) === String(draggedId));
            if (draggedIndex === -1) return;

            const [dragged] = list.splice(draggedIndex, 1);

            if (targetId === '') {
                list.unshift(dragged);
            } else {
                const targetIndex = list.findIndex(r => String(r.id) === String(targetId));
                if (targetIndex === -1) list.push(dragged);
                else list.splice(targetIndex + 1, 0, dragged);
            }

            projectData.risks.risk_items = list;
            uiEnsurePriority(projectData.risks.risk_items, 'priority');
            displayRisks(projectData.risks);
        }

        function onRiskDragStart(e) {
            dragRiskIndex = Number(e.currentTarget.dataset.index);
            e.currentTarget.classList.add('dragging');
        }

        function onRiskDragOver(e) {
            e.preventDefault();
        }

        function onRiskDragLeave(e, targetId) {
            const el = document.querySelector(`.risk-item[data-risk-id="${targetId}"]`);
            if (el) el.classList.remove('is-drag-over');
        }

        function onRiskDrop(e) {
            e.preventDefault();

            const targetIndex = Number(e.currentTarget.dataset.index);
            if (dragRiskIndex === null || dragRiskIndex === targetIndex) return;

            const items = projectData.risks.risk_items;
            const moved = items.splice(dragRiskIndex, 1)[0];
            items.splice(targetIndex, 0, moved);

            // PRIORITY QAYTA HISOB
            items.forEach((item, i) => {
                item.priority = i + 1;
            });

            dragRiskIndex = null;
            displayRisks(projectData.risks);
        }

        function displayRisks(risks) {
            if (!risks) return;

            // 1) Info grid markupni DOMga qo'yish (IDlar shu yerda yaratiladi)
            const infoGrid = document.getElementById('risksInfoContent');
            if (infoGrid) {
                infoGrid.innerHTML = `
          <div class="info-item">
            <div class="info-label">Boshqarilish modeli nomi</div>
            <div class="info-value" id="risk_management_model">-</div>
          </div>

          <div class="info-item">
            <div class="info-label">Boshqarilish modeli qisqacha tavsifi</div>
            <div class="info-value" id="risk_management_description">-</div>
          </div>

          <div class="info-item">
            <div class="info-label">Boshqarilish modeli haqida ma’lumot</div>
            <div class="info-value" id="risk_management_info">-</div>
          </div>

          <div class="info-item">
            <div class="info-label">Xatar darajasi</div>
            <div class="info-value" id="risk_level">
              <span class="status-badge status-inactive">-</span>
            </div>
          </div>
        `;
            }

            // 2) Risk level badge
            const riskMap = {
                low: { text: 'Past', class: 'status-active' },
                medium: { text: "O'rta", class: 'status-planned' },
                high: { text: 'Yuqori', class: 'status-inactive' }
            };
            const riskMeta = riskMap[risks.risk_level] || { text: '-', class: 'status-inactive' };

            // 3) Elementlar va qiymatlar (key mismatch uchun fallback)
            const modelEl = document.getElementById('risk_management_model');
            const descEl = document.getElementById('risk_management_description');
            const infoEl = document.getElementById('risk_management_info');
            const levelEl = document.getElementById('risk_level');

            const modelVal = risks.management_model ?? '-';
            const descVal = risks.management_desc ?? risks.management_description ?? '-';
            const infoVal = risks.management_info ?? '-';

            if (modelEl) modelEl.textContent = modelVal;
            if (descEl) descEl.textContent = descVal;
            if (infoEl) infoEl.textContent = infoVal;

            if (levelEl) {
                levelEl.innerHTML = `<span class="status-badge ${riskMeta.class}">${riskMeta.text}</span>`;
            }

            // 4) Risk items (sizdagi kod o'zgarishsiz qoladi)
            const container = document.getElementById('risksContainer');
            if (!container) return;

            if (!risks.risk_items || risks.risk_items.length === 0) {
                container.innerHTML = '<p class="text-muted text-center py-4">Xatarlar mavjud emas</p>';
                return;
            }

            uiEnsureRiskIds(risks.risk_items);
            uiEnsurePriority(risks.risk_items, 'priority');

            if (!risksEditMode) {
                container.innerHTML = risks.risk_items.map(item => `
          <div class="risk-item">
            <div class="risk-title" style="display:flex; align-items:center; gap:0.5rem;">
              <span class="priority-pill">#${item.priority}</span>
              <i class="bi bi-exclamation-triangle"></i>
              ${uiEscapeHtml(item.name)}
            </div>
            <p class="risk-description">${uiEscapeHtml(item.description)}</p>
          </div>
        `).join('');
            } else {
                container.innerHTML = risks.risk_items.map(item => `
          <div class="risk-item" data-risk-id="${item.id}"
               ondragover="onRiskDragOver(event, ${item.id})"
               ondragleave="onRiskDragLeave(event, ${item.id})"
               ondrop="onRiskDrop(event, ${item.id})"
               style="border: 1px solid var(--gray-200); padding: 1.25rem;">
            <div class="row g-3 align-items-end">
              <div class="col-12 col-md-2">
                <label class="form-label small mb-1">Tartib</label>
                <div class="d-flex align-items-center gap-2">
                  <div class="drag-handle" draggable="true"
                       ondragstart="onRiskDragStart(event, ${item.id})"
                       title="Ushlab torting">
                    <i class="bi bi-grip-vertical"></i>
                  </div>
                  <span class="priority-pill">#${item.priority}</span>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label small mb-1">Xatar nomi</label>
                <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(item.name)}"
                  onchange="updateRiskItemField(${item.id}, 'name', this.value)">
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label small mb-1">Joylashuvi</label>
                ${buildRiskMoveAfterSelect(item.id)}
              </div>
              <div class="col-12 col-md-2">
                <button type="button" class="btn btn-danger btn-sm w-100"
                  onclick="deleteRisk(${item.id})">
                  <i class="bi bi-trash me-1"></i>
                  O'chirish
                </button>
              </div>
              <div class="col-12">
                <label class="form-label small mb-1">Xatar tavsifi</label>
                <textarea class="form-control form-control-sm" rows="3"
                  onchange="updateRiskItemField(${item.id}, 'description', this.value)">${uiEscapeHtml(item.description)}</textarea>
              </div>
            </div>
          </div>
        `).join('');
            }

            buildRiskInsertAfterSelect();
        }

        // let risksEditMode = false;
        let nextRiskId = 5;
        let riskInsertAfterId = '';
        let dragRiskId = null;

        function toggleRisksEdit() {
            if (!projectData || !projectData.risks) return;

            risksEditMode = !risksEditMode;
            const btn = document.getElementById('toggleRisksEditBtn');
            const addBtn = document.getElementById('addRiskBtn');
            const tools = document.getElementById('risksTools');
            const hint = document.getElementById('risksHint');

            if (risksEditMode) {
                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Saqlash';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');

                if (addBtn) addBtn.classList.remove('d-none');
                if (tools) tools.classList.add('active');
                if (hint) hint.classList.add('active');
            } else {
                btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');

                if (addBtn) addBtn.classList.add('d-none');
                if (tools) tools.classList.remove('active');
                if (hint) hint.classList.remove('active');

                saveRisksChanges();
            }

            displayRisks(projectData.risks);
        }

        function saveRisksChanges() {
            console.log('Risklar ma\'lumotlari saqlandi:', projectData.risks);
            showToast('Risklar ma\'lumotlari muvaffaqiyatli saqlandi', 'success');
        }

        function displayRisksView() {
            const r = projectData.risks;

            document.getElementById('risk_management_model').textContent =
                r.management_model || '-';

            document.getElementById('risk_management_description').textContent =
                r.management_description || '-';

            document.getElementById('risk_level').textContent =
                r.risk_level || '-';

            const container = document.getElementById('risksContainer');

            if (!Array.isArray(r.risk_items) || r.risk_items.length === 0) {
                container.innerHTML = '<p class="text-muted">Xatarlar mavjud emas</p>';
                return;
            }

            container.innerHTML = r.risk_items.map(item => `
                                                                                            <div class="risk-item">
                                                                                                <div class="risk-title">${uiEscapeHtml(item.name)}</div>
                                                                                                <p class="risk-description">${uiEscapeHtml(item.description)}</p>
                                                                                            </div>
                                                                                        `).join('');
        }

        function convertRisksToInputs() {
            const r = projectData.risks;

            document.getElementById('risk_management_model').innerHTML =
                `<input class="form-control"
                                                                                                value="${uiEscapeHtml(r.management_model || '')}">`;

            document.getElementById('risk_management_description').innerHTML =
                `<textarea class="form-control" rows="3">${uiEscapeHtml(r.management_description || '')}</textarea>`;

            document.getElementById('risk_level').innerHTML =
                `<select class="form-select">
                                                                                            <option value="low" ${r.risk_level === 'low' ? 'selected' : ''}>Past</option>
                                                                                            <option value="medium" ${r.risk_level === 'medium' ? 'selected' : ''}>O‘rta</option>
                                                                                            <option value="high" ${r.risk_level === 'high' ? 'selected' : ''}>Yuqori</option>
                                                                                        </select>`;

            const container = document.getElementById('risksContainer');

            container.innerHTML = r.risk_items.map((item, i) => `
                                                                                        <div class="risk-item">
                                                                                            <input class="form-control mb-2"
                                                                                                   data-index="${i}"
                                                                                                   data-field="name"
                                                                                                   value="${uiEscapeHtml(item.name)}">

                                                                                            <textarea class="form-control"
                                                                                                      data-index="${i}"
                                                                                                      data-field="description">${uiEscapeHtml(item.description)}</textarea>
                                                                                        </div>
                                                                                    `).join('');
        }

        /* ================= SAVE ================= */
        function restoreRisksFromInputs() {
            const r = projectData.risks;

            r.management_model =
                document.querySelector('#risk_management_model input').value;

            r.management_description =
                document.querySelector('#risk_management_description textarea').value;

            r.risk_level =
                document.querySelector('#risk_level select').value;

            document.querySelectorAll('#risksContainer [data-index]').forEach(el => {
                const index = Number(el.dataset.index);
                const field = el.dataset.field;
                r.risk_items[index][field] = el.value;
            });

            displayRisksView();
        }

        /* ================= INIT ================= */
        document.addEventListener('DOMContentLoaded', () => {
            if (projectData && projectData.risks) {
                displayRisksView();
            }
        });


        function updateRiskField(field, value) {
            if (!projectData || !projectData.risks) return;

            projectData.risks[field] = value;

            if (field === 'risk_level') {
                const riskMap = {
                    'low': { text: 'Past', class: 'status-active' },
                    'medium': { text: "O'rta", class: 'status-planned' },
                    'high': { text: 'Yuqori', class: 'status-inactive' }
                };
                const riskMeta = riskMap[value] || { text: '-', class: 'status-inactive' };
                const riskEl = document.getElementById('riskLevel');
                if (riskEl) {
                    riskEl.textContent = riskMeta.text;
                    riskEl.className = `status-badge ${riskMeta.class}`;
                }
            }
        }

        function updateRiskItemField(riskId, field, value) {
            if (!projectData || !projectData.risks || !Array.isArray(projectData.risks.risk_items)) return;

            const item = projectData.risks.risk_items.find(r => String(r.id) === String(riskId));
            if (!item) return;

            item[field] = value;
        }

        function addNewRisk() {
            if (!projectData || !projectData.risks) return;

            if (!Array.isArray(projectData.risks.risk_items)) projectData.risks.risk_items = [];

            uiEnsureRiskIds(projectData.risks.risk_items);
            uiEnsurePriority(projectData.risks.risk_items, 'priority');

            const newRisk = {
                id: nextRiskId++,
                name: 'Yangi xatar',
                description: 'Xatar tavsifini kiriting...',
                priority: projectData.risks.risk_items.length + 1
            };

            const afterId = riskInsertAfterId;
            if (afterId) {
                const idx = projectData.risks.risk_items.findIndex(r => String(r.id) === String(afterId));
                if (idx === -1) projectData.risks.risk_items.push(newRisk);
                else projectData.risks.risk_items.splice(idx + 1, 0, newRisk);
            } else {
                projectData.risks.risk_items.push(newRisk);
            }

            uiEnsurePriority(projectData.risks.risk_items, 'priority');
            displayRisks(projectData.risks);
        }

        function deleteRisk(riskId) {
            if (!projectData || !projectData.risks || !Array.isArray(projectData.risks.risk_items)) return;

            if (confirm('Bu xatarni o\'chirishni xohlaysizmi?')) {
                projectData.risks.risk_items = projectData.risks.risk_items.filter(r => String(r.id) !== String(riskId));
                uiEnsurePriority(projectData.risks.risk_items, 'priority');
                displayRisks(projectData.risks);
            }
        }

        let documentsEditMode = false;

        let nextDocumentId = 6; // Yangi hujjatlar uchun ID

        function displayDocuments(documents) {
            const container = document.getElementById('documentsContainer');

            if (!documents || documents.length === 0) {
                container.innerHTML = '<p class="text-muted text-center py-4">Hujjatlar mavjud emas</p>';
                return;
            }

            if (!documentsEditMode) {
                // Ko'rish rejimi
                container.innerHTML = documents.map(doc => `
                                                                                                                                                <div class="document-item">
                                                                                                                                                    <div class="document-info">
                                                                                                                                                        <div class="document-icon">
                                                                                                                                                            <i class="bi bi-file-earmark-pdf"></i>
                                                                                                                                                        </div>
                                                                                                                                                        <div>
                                                                                                                                                            <div style="font-weight: 600; color: var(--gray-900);">${doc.name}</div>
                                                                                                                                                            <div style="font-size: 0.85rem; color: var(--gray-600);">
                                                                                                                                                                <i class="bi bi-file-earmark me-1"></i>
                                                                                                                                                                ${doc.file}
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                    <button class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1"
                                                                                                                                                        onclick="downloadDocument('${doc.file}')">
                                                                                                                                                        <i class="bi bi-download"></i> Yuklash
                                                                                                                                                    </button>
                                                                                                                                                </div>
                                                                                                                                            `).join('');
            } else {
                // Tahrirlash rejimi
                container.innerHTML = documents.map((doc, index) => `
                                                                                                                                                <div class="document-item" style="flex-direction: column; align-items: stretch; gap: 1rem; padding: 1.5rem;">
                                                                                                                                                    <div class="row g-3 align-items-end">
                                                                                                                                                        <div class="col-12 col-md-5">
                                                                                                                                                            <label class="form-label small mb-1">
                                                                                                                                                                <i class="bi bi-file-text me-1 text-muted"></i>
                                                                                                                                                                Hujjat nomi
                                                                                                                                                            </label>
                                                                                                                                                            <input type="text" class="form-control form-control-sm" value="${doc.name}"
                                                                                                                                                                onchange="updateDocumentField(${doc.id || index}, 'name', this.value)"
                                                                                                                                                                id="docName_${doc.id || index}">
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-12 col-md-4">
                                                                                                                                                            <label class="form-label small mb-1">
                                                                                                                                                                <i class="bi bi-file-earmark me-1 text-muted"></i>
                                                                                                                                                                Hozirgi fayl
                                                                                                                                                            </label>
                                                                                                                                                            <div class="form-control form-control-sm" style="background: var(--gray-50); padding: 0.5rem;">
                                                                                                                                                                <i class="bi bi-file-earmark-pdf me-1"></i>
                                                                                                                                                                <span style="font-size: 0.875rem;">${doc.file}</span>
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-12 col-md-3">
                                                                                                                                                            <label class="form-label small mb-1">
                                                                                                                                                                <i class="bi bi-upload me-1 text-muted"></i>
                                                                                                                                                                Yangi fayl yuklash
                                                                                                                                                            </label>
                                                                                                                                                            <input type="file" class="form-control form-control-sm" 
                                                                                                                                                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                                                                                                                                                                onchange="handleFileUpload(${doc.id || index}, this)"
                                                                                                                                                                id="docFile_${doc.id || index}">
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="d-flex gap-2 justify-content-end">
                                                                                                                                                        <button class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1"
                                                                                                                                                            onclick="downloadDocument('${doc.file}')">
                                                                                                                                                            <i class="bi bi-download"></i> Yuklash
                                                                                                                                                        </button>
                                                                                                                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                                                                                                                            onclick="deleteDocument(${doc.id || index})">
                                                                                                                                                            <i class="bi bi-trash me-1"></i>
                                                                                                                                                            O'chirish
                                                                                                                                                        </button>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            `).join('');
            }
        }

        function toggleDocumentsEdit() {
            documentsEditMode = !documentsEditMode;
            const btn = document.getElementById('toggleDocumentsEditBtn');
            const addBtn = document.getElementById('addDocumentBtn');

            btn.innerHTML = documentsEditMode ?
                '<i class="bi bi-check-lg me-1"></i> Saqlash' :
                '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

            addBtn.style.display = documentsEditMode ? 'inline-flex' : 'none';

            if (projectData && projectData.documents) {
                displayDocuments(projectData.documents);
            }
        }

        function updateDocumentField(docId, field, value) {
            if (!projectData || !projectData.documents) return;

            const doc = projectData.documents.find(d => d.id === docId) ||
                projectData.documents[docId];
            if (!doc) return;

            doc[field] = value;
        }

        function handleFileUpload(docId, input) {
            if (!input.files || input.files.length === 0) return;

            const file = input.files[0];
            const fileName = file.name;

            if (!projectData || !projectData.documents) return;

            const doc = projectData.documents.find(d => d.id === docId) ||
                projectData.documents[docId];
            if (!doc) return;

            // Fayl nomini yangilaymiz
            doc.file = fileName;

            // Bu yerda haqiqiy fayl yuklash API chaqiruvini qo'shish mumkin
            // Masalan: uploadFileToServer(file, docId)

            // Ko'rinishni yangilaymiz
            displayDocuments(projectData.documents);

            // Input ni tozalaymiz (yangi fayl yuklash uchun)
            input.value = '';
        }

        function addNewDocument() {
            if (!projectData || !projectData.documents) return;

            const newDoc = {
                id: nextDocumentId++,
                name: 'Yangi hujjat',
                file: 'fayl_yuklanmagan.pdf'
            };

            projectData.documents.push(newDoc);
            displayDocuments(projectData.documents);
        }

        function deleteDocument(docId) {
            if (!projectData || !projectData.documents) return;

            if (confirm('Bu hujjatni o\'chirishni xohlaysizmi?')) {
                projectData.documents = projectData.documents.filter(d => d.id !== docId);
                displayDocuments(projectData.documents);
            }
        }

        function switchTab(tabName) {
            document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            event.target.classList.add('active');
            document.getElementById(tabName).classList.add('active');
            currentTab = tabName;
        }

        function scrollTabs(direction) {
            const navTabs = document.getElementById('projectTabs');
            const scrollAmount = 200;

            if (direction === 'left') {
                navTabs.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            } else {
                navTabs.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            }

            // Scroll tugmalarini tekshirish
            setTimeout(() => {
                checkScrollButtons();
            }, 300);
        }

        function checkScrollButtons() {
            const navTabs = document.getElementById('projectTabs');
            const scrollLeftBtn = document.getElementById('scrollLeftBtn');
            const scrollRightBtn = document.getElementById('scrollRightBtn');

            // Chap tugma
            if (navTabs.scrollLeft <= 0) {
                scrollLeftBtn.classList.add('hidden');
            } else {
                scrollLeftBtn.classList.remove('hidden');
            }

            // O'ng tugma
            if (navTabs.scrollLeft >= navTabs.scrollWidth - navTabs.clientWidth - 1) {
                scrollRightBtn.classList.add('hidden');
            } else {
                scrollRightBtn.classList.remove('hidden');
            }
        }

        // Scroll holatini kuzatish
        document.addEventListener('DOMContentLoaded', function () {
            const navTabs = document.getElementById('projectTabs');
            if (navTabs) {
                checkScrollButtons();
                navTabs.addEventListener('scroll', checkScrollButtons);
            }
        });

        function formatMoney(amount) {
            return new Intl.NumberFormat('uz-UZ').format(amount) + " so'm";
        }

        function enableEdit() {
            alert('Tahrirlash rejimi yoqildi');
            document.getElementById('saveBtn').style.display = 'inline-flex';
        }

        function saveChanges() {
            alert("O'zgarishlar saqlandi");
            document.getElementById('saveBtn').style.display = 'none';
        }

        function downloadDocument(filename) {
            alert(`Hujjat yuklanmoqda: ${filename}`);
        }

        document.addEventListener('DOMContentLoaded', loadProjectData);

        let editModes = {
            basicInfo: false,
            location: false,
            manager: false,
            construction: false
        };

        let originalData = {
            basicInfo: {},
            location: {},
            manager: {},
            construction: {}
        };

        // =================== ASOSIY MA'LUMOTLAR EDIT ===================

        // =================== RISKS INFO EDIT ===================
        let originalRisksInfo = null;

        function toggleRisksInfoEdit() {
            if (!projectData || !projectData.risks) return;

            const btn = document.getElementById('toggleRisksInfoEditBtn');
            risksInfoEditMode = !risksInfoEditMode;

            if (risksInfoEditMode) {
                originalRisksInfo = JSON.parse(JSON.stringify(projectData.risks));

                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Saqlash';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');
            } else {
                saveRisksInfoChanges();

                btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');
            }

            displayRisks(projectData.risks);
        }

        function saveRisksInfoChanges() {
            console.log('Risk info saqlandi:', projectData.risks);
            showToast('Risk maʼlumotlari saqlandi', 'success');
        }

        // =================== RISKS LIST EDIT ===================
        let originalRiskItems = null;

        function toggleRisksListEdit() {
            risksListEditMode = !risksListEditMode;

            const btn = document.getElementById('toggleRisksListEditBtn');
            btn.innerHTML = risksListEditMode
                ? '<i class="bi bi-check-lg me-1"></i> Saqlash'
                : '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

            btn.classList.toggle('btn-success', risksListEditMode);
            btn.classList.toggle('btn-outline-secondary', !risksListEditMode);

            displayRisks(projectData.risks);
        }

        function saveRisksListChanges() {
            console.log('Risklar ro‘yxati saqlandi:', projectData.risks.risk_items);
            showToast('Risklar ro‘yxati saqlandi', 'success');
        }

        function toggleBasicInfoEdit() {
            editModes.basicInfo = !editModes.basicInfo;
            const btn = document.getElementById('toggleBasicInfoBtn');

            if (editModes.basicInfo) {
                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Saqlash';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');

                originalData.basicInfo = {
                    projectId: document.getElementById('projectId').textContent,
                    name: document.getElementById('name').textContent,
                    shortDesc: document.getElementById('shortDesc').textContent,
                    purpose: document.getElementById('purpose').textContent,
                    category: document.getElementById('category').textContent,
                    status: document.getElementById('status').textContent
                };

                convertBasicInfoToInputs();

                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.className = 'btn btn-outline-danger btn-sm';
                cancelBtn.id = 'cancelBasicInfoBtn';
                cancelBtn.innerHTML = '<i class="bi bi-x-lg me-1"></i>Bekor qilish';
                cancelBtn.onclick = cancelBasicInfoEdit;
                btn.parentElement.insertBefore(cancelBtn, btn);

            } else {
                saveBasicInfoChanges();

                btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');

                const cancelBtn = document.getElementById('cancelBasicInfoBtn');
                if (cancelBtn) cancelBtn.remove();

                convertBasicInfoToText();
            }
        }

        function convertBasicInfoToInputs() {
            const fields = [
                { id: 'projectId', type: 'text', readonly: true },
                { id: 'name', type: 'text' },
                { id: 'shortDesc', type: 'textarea' },
                { id: 'purpose', type: 'textarea' },
                { id: 'category', type: 'text' },
                { id: 'status', type: 'text' }
            ];

            fields.forEach(field => {
                const element = document.getElementById(field.id);
                const value = element.textContent;

                if (field.type === 'textarea') {
                    element.innerHTML = `<textarea class="form-control" rows="3" style="font-weight: 600; color: var(--gray-900);">${value}</textarea>`;
                } else {
                    element.innerHTML = `<input type="text" class="form-control" value="${value}" ${field.readonly ? 'readonly' : ''} style="font-weight: 600; color: var(--gray-900);">`;
                }
            });
        }

        function convertBasicInfoToText() {
            const fields = ['projectId', 'name', 'shortDesc', 'purpose', 'category', 'status'];

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const input = element.querySelector('input, textarea');
                if (input) {
                    element.textContent = input.value;
                }
            });
        }

        function saveBasicInfoChanges() {
            const fields = ['projectId', 'name', 'shortDesc', 'purpose', 'category', 'status'];
            const newData = {};

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const input = element.querySelector('input, textarea');
                if (input) {
                    newData[fieldId] = input.value;
                }
            });

            console.log('Asosiy ma\'lumotlar saqlandi:', newData);
            showToast('Asosiy ma\'lumotlar muvaffaqiyatli saqlandi', 'success');
        }

        function cancelBasicInfoEdit() {
            editModes.basicInfo = false;

            Object.keys(originalData.basicInfo).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.textContent = originalData.basicInfo[key];
                }
            });

            const btn = document.getElementById('toggleBasicInfoBtn');
            btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');

            const cancelBtn = document.getElementById('cancelBasicInfoBtn');
            if (cancelBtn) cancelBtn.remove();

            showToast('O\'zgarishlar bekor qilindi', 'info');
        }

        // =================== JOYLASHUV MA'LUMOTLARI EDIT ===================
        function toggleLocationEdit() {
            editModes.location = !editModes.location;
            const btn = document.getElementById('toggleLocationBtn');

            if (editModes.location) {
                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Saqlash';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');

                originalData.location = {
                    city: document.getElementById('city').textContent,
                    district: document.getElementById('district').textContent,
                    street: document.getElementById('street').textContent,
                    house: document.getElementById('house').textContent
                };

                convertLocationToInputs();

                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.className = 'btn btn-outline-danger btn-sm';
                cancelBtn.id = 'cancelLocationBtn';
                cancelBtn.innerHTML = '<i class="bi bi-x-lg me-1"></i>Bekor qilish';
                cancelBtn.onclick = cancelLocationEdit;
                btn.parentElement.insertBefore(cancelBtn, btn);

            } else {
                saveLocationChanges();

                btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');

                const cancelBtn = document.getElementById('cancelLocationBtn');
                if (cancelBtn) cancelBtn.remove();

                convertLocationToText();
            }
        }

        function convertLocationToInputs() {
            const fields = ['city', 'district', 'street', 'house'];

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const value = element.textContent;
                element.innerHTML = `<input type="text" class="form-control" value="${value}" style="font-weight: 600; color: var(--gray-900);">`;
            });
        }

        function convertLocationToText() {
            const fields = ['city', 'district', 'street', 'house'];

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const input = element.querySelector('input');
                if (input) {
                    element.textContent = input.value;
                }
            });
        }

        function saveLocationChanges() {
            const fields = ['city', 'district', 'street', 'house'];
            const newData = {};

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const input = element.querySelector('input');
                if (input) {
                    newData[fieldId] = input.value;
                }
            });

            console.log('Joylashuv ma\'lumotlari saqlandi:', newData);
            showToast('Joylashuv ma\'lumotlari muvaffaqiyatli saqlandi', 'success');
        }

        function cancelLocationEdit() {
            editModes.location = false;

            Object.keys(originalData.location).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.textContent = originalData.location[key];
                }
            });

            const btn = document.getElementById('toggleLocationBtn');
            btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');

            const cancelBtn = document.getElementById('cancelLocationBtn');
            if (cancelBtn) cancelBtn.remove();

            showToast('O\'zgarishlar bekor qilindi', 'info');
        }

        // =================== LOYIHA BOSHQARUVCHISI EDIT ===================
        function toggleManagerEdit() {
            editModes.manager = !editModes.manager;
            const btn = document.getElementById('toggleManagerBtn');

            if (editModes.manager) {
                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Saqlash';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');

                originalData.manager = {
                    managerOrg: document.getElementById('managerOrg').textContent,
                    licenseNumber: document.getElementById('licenseNumber').textContent
                };

                convertManagerToInputs();

                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.className = 'btn btn-outline-danger btn-sm';
                cancelBtn.id = 'cancelManagerBtn';
                cancelBtn.innerHTML = '<i class="bi bi-x-lg me-1"></i>Bekor qilish';
                cancelBtn.onclick = cancelManagerEdit;
                btn.parentElement.insertBefore(cancelBtn, btn);

            } else {
                saveManagerChanges();

                btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');

                const cancelBtn = document.getElementById('cancelManagerBtn');
                if (cancelBtn) cancelBtn.remove();

                convertManagerToText();
            }
        }

        function convertManagerToInputs() {
            const fields = ['managerOrg', 'licenseNumber'];

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const value = element.textContent;
                element.innerHTML = `<input type="text" class="form-control" value="${value}" style="font-weight: 600; color: var(--gray-900);">`;
            });
        }

        function convertManagerToText() {
            const fields = ['managerOrg', 'licenseNumber'];

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const input = element.querySelector('input');
                if (input) {
                    element.textContent = input.value;
                }
            });
        }

        function saveManagerChanges() {
            const fields = ['managerOrg', 'licenseNumber'];
            const newData = {};

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const input = element.querySelector('input');
                if (input) {
                    newData[fieldId] = input.value;
                }
            });

            console.log('Loyiha boshqaruvchisi ma\'lumotlari saqlandi:', newData);
            showToast('Loyiha boshqaruvchisi ma\'lumotlari muvaffaqiyatli saqlandi', 'success');
        }

        function cancelManagerEdit() {
            editModes.manager = false;

            Object.keys(originalData.manager).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.textContent = originalData.manager[key];
                }
            });

            const btn = document.getElementById('toggleManagerBtn');
            btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');

            const cancelBtn = document.getElementById('cancelManagerBtn');
            if (cancelBtn) cancelBtn.remove();

            showToast('O\'zgarishlar bekor qilindi', 'info');
        }

        // =================== QURILISH TASHKILOTI EDIT ===================
        function toggleConstructionEdit() {
            editModes.construction = !editModes.construction;
            const btn = document.getElementById('toggleConstructionBtn');

            if (editModes.construction) {
                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Saqlash';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');

                originalData.construction = {
                    constructionName: document.getElementById('constructionName').textContent,
                    constructionDesc: document.getElementById('constructionDesc').textContent
                };

                convertConstructionToInputs();

                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.className = 'btn btn-outline-danger btn-sm';
                cancelBtn.id = 'cancelConstructionBtn';
                cancelBtn.innerHTML = '<i class="bi bi-x-lg me-1"></i>Bekor qilish';
                cancelBtn.onclick = cancelConstructionEdit;
                btn.parentElement.insertBefore(cancelBtn, btn);

            } else {
                saveConstructionChanges();

                btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');

                const cancelBtn = document.getElementById('cancelConstructionBtn');
                if (cancelBtn) cancelBtn.remove();

                convertConstructionToText();
            }
        }

        function convertConstructionToInputs() {
            const fields = [
                { id: 'constructionName', type: 'text' },
                { id: 'constructionDesc', type: 'textarea' }
            ];

            fields.forEach(field => {
                const element = document.getElementById(field.id);
                const value = element.textContent;

                if (field.type === 'textarea') {
                    element.innerHTML = `<textarea class="form-control" rows="3" style="font-weight: 600; color: var(--gray-900);">${value}</textarea>`;
                } else {
                    element.innerHTML = `<input type="text" class="form-control" value="${value}" style="font-weight: 600; color: var(--gray-900);">`;
                }
            });
        }

        function convertConstructionToText() {
            const fields = ['constructionName', 'constructionDesc'];

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const input = element.querySelector('input, textarea');
                if (input) {
                    element.textContent = input.value;
                }
            });
        }

        function saveConstructionChanges() {
            const fields = ['constructionName', 'constructionDesc'];
            const newData = {};

            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                const input = element.querySelector('input, textarea');
                if (input) {
                    newData[fieldId] = input.value;
                }
            });

            console.log('Qurilish tashkiloti ma\'lumotlari saqlandi:', newData);
            showToast('Qurilish tashkiloti ma\'lumotlari muvaffaqiyatli saqlandi', 'success');
        }

        function cancelConstructionEdit() {
            editModes.construction = false;

            Object.keys(originalData.construction).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.textContent = originalData.construction[key];
                }
            });

            const btn = document.getElementById('toggleConstructionBtn');
            btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');

            const cancelBtn = document.getElementById('cancelConstructionBtn');
            if (cancelBtn) cancelBtn.remove();

            showToast('O\'zgarishlar bekor qilindi', 'info');
        }

        // =================== MEDIA (IMAGES/VIDEOS) MANAGEMENT ===================
        function deleteMedia(mediaId, mediaType, mediaSrc) {
            if (!confirm('Ushbu faylni o\'chirmoqchimisiz?')) return;

            // API call would go here
            console.log('Deleting media:', { mediaId, mediaType, mediaSrc });

            // 1) Data’dan olib tashlash (delete bosilgach ochib yuborish muammosi shu yerda yo‘qoladi)
            if (projectData) {
                if (mediaType === 'main-image' && Array.isArray(projectData.main_images)) {
                    projectData.main_images = projectData.main_images.filter(u => String(u) !== String(mediaSrc));
                    displayMainImages(projectData.main_images);
                }
                if (mediaType === 'process-image' && Array.isArray(projectData.process_images)) {
                    projectData.process_images = projectData.process_images.filter(u => String(u) !== String(mediaSrc));
                    displayProcessImages(projectData.process_images);
                }
                if (mediaType === 'video' && Array.isArray(projectData.videos)) {
                    projectData.videos = projectData.videos.filter(u => String(u) !== String(mediaSrc));
                    displayVideos(projectData.videos);
                }
            }

            // 2) Control’larni qayta qo‘yish
            setTimeout(addMediaControls, 0);

            showToast('Fayl muvaffaqiyatli o\'chirildi', 'success');
        }

        function uploadNewMedia(mediaType) {
            // Create file input
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = mediaType === 'video' ? 'video/*' : 'image/*';
            input.multiple = true;

            input.onchange = function (e) {
                const files = e.target.files;
                if (files.length === 0) return;

                // API call would go here
                console.log('Uploading files:', files);

                // Simulate upload
                Array.from(files).forEach((file, index) => {
                    setTimeout(() => {
                        showToast(`${file.name} yuklandi`, 'success');
                    }, index * 500);
                });
            };

            input.click();
        }

        // Add delete and upload buttons to media items
        function addMediaControls() {
            // Main Images
            const mainImagesContainer = document.getElementById('mainImagesContainer');
            if (mainImagesContainer) {
                addControlsToContainer(mainImagesContainer, 'main-image');
            }

            // Process Images
            const processImagesContainer = document.getElementById('processImagesContainer');
            if (processImagesContainer) {
                addControlsToContainer(processImagesContainer, 'process-image');
            }

            // Videos
            const videosContainer = document.getElementById('videosContainer');
            if (videosContainer) {
                addControlsToContainer(videosContainer, 'video');
            }
        }

        function addControlsToContainer(container, mediaType) {
            const items = container.querySelectorAll('.gallery-item');

            items.forEach((item, index) => {
                if (item.classList.contains('media-upload-card')) return;
                if (item.querySelector('.media-controls')) return; // Already has controls

                const mediaSrc = item.getAttribute('data-media-src') || (item.querySelector('img')?.getAttribute('src') ?? '');
                const mediaId = `${mediaType}-${index}`;
                item.setAttribute('data-media-id', mediaId);

                const controls = document.createElement('div');
                controls.className = 'media-controls';

                // delete icon: delete-button.blade.php’dagi SVG path
                controls.innerHTML = `
                                                                                                                                    <button type="button" class="media-delete-btn" title="O'chirish">
                                                                                                                                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                                                                                                                            <path fill-rule="evenodd"
                                                                                                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                                                                                                                clip-rule="evenodd"></path>
                                                                                                                                        </svg>
                                                                                                                                    </button>
                                                                                                                                `;

                // click bubbling to‘xtatish (delete bosilganda modal ochilmasin)
                const btn = controls.querySelector('button');
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    deleteMedia(mediaId, mediaType, mediaSrc);
                });
                controls.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                });

                item.appendChild(controls);
            });

            // Add upload button (1 dona)
            if (!container.querySelector('.media-upload-card')) {
                const uploadCard = document.createElement('div');
                uploadCard.className = 'gallery-item media-upload-card';
                uploadCard.innerHTML = `
                                                                                                                                    <div class="media-upload-content">
                                                                                                                                        <i class="bi bi-cloud-upload"></i>
                                                                                                                                        <span>Yangi yuklash</span>
                                                                                                                                    </div>
                                                                                                                                `;
                uploadCard.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    uploadNewMedia(mediaType);
                });

                container.appendChild(uploadCard);
            }
        }

        // Call this function after page loads or when data is loaded
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize media controls after a short delay (when images are loaded)
            setTimeout(addMediaControls, 1000);
        });

        // =================== TOAST NOTIFICATION ===================
        function showToast(message, type = 'info') {
            const existingToast = document.querySelector('.custom-toast');
            if (existingToast) {
                existingToast.remove();
            }

            const toast = document.createElement('div');
            toast.className = `custom-toast toast-${type}`;
            toast.textContent = message;

            const styles = `
                                                                                                                                .custom-toast {
                                                                                                                                    position: fixed;
                                                                                                                                    top: 20px;
                                                                                                                                    right: 20px;
                                                                                                                                    padding: 1rem 1.5rem;
                                                                                                                                    background: white;
                                                                                                                                    border-radius: 0.5rem;
                                                                                                                                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                                                                                                                                    z-index: 9999;
                                                                                                                                    animation: slideIn 0.3s ease;
                                                                                                                                    border-left: 4px solid;
                                                                                                                                    font-weight: 500;
                                                                                                                                }
                                                                                                                                .toast-success { border-left-color: #16a34a; color: #166534; }
                                                                                                                                .toast-info { border-left-color: #2563eb; color: #1e40af; }
                                                                                                                                .toast-danger { border-left-color: #dc2626; color: #991b1b; }
                                                                                                                                @keyframes slideIn {
                                                                                                                                    from { transform: translateX(400px); opacity: 0; }
                                                                                                                                    to { transform: translateX(0); opacity: 1; }
                                                                                                                                }

                                                                                                                                /* Media Controls Styles */
                                                                                                                                .media-controls {
                                                                                                                                    position: absolute;
                                                                                                                                    top: 0.5rem;
                                                                                                                                    right: 0.5rem;
                                                                                                                                    display: flex;
                                                                                                                                    gap: 0.5rem;
                                                                                                                                    z-index: 10;
                                                                                                                                    opacity: 0;
                                                                                                                                    transition: opacity 0.3s;
                                                                                                                                }

                                                                                                                                .gallery-item:hover .media-controls {
                                                                                                                                    opacity: 1;
                                                                                                                                }

                                                                                                                                .media-delete-btn {
                                                                                                                                    width: 32px;
                                                                                                                                    height: 32px;
                                                                                                                                    border-radius: 50%;
                                                                                                                                    border: none;
                                                                                                                                    background: rgba(220, 38, 38, 0.9);
                                                                                                                                    color: white;
                                                                                                                                    display: flex;
                                                                                                                                    align-items: center;
                                                                                                                                    justify-content: center;
                                                                                                                                    cursor: pointer;
                                                                                                                                    transition: all 0.3s;
                                                                                                                                    font-size: 0.875rem;
                                                                                                                                }

                                                                                                                                .media-delete-btn:hover {
                                                                                                                                    background: rgba(220, 38, 38, 1);
                                                                                                                                    transform: scale(1.1);
                                                                                                                                }

                                                                                                                                .media-upload-card {
                                                                                                                                    border: 2px dashed var(--gray-300);
                                                                                                                                    background: var(--gray-50);
                                                                                                                                    display: flex;
                                                                                                                                    align-items: center;
                                                                                                                                    justify-content: center;
                                                                                                                                    cursor: pointer;
                                                                                                                                    transition: all 0.3s;
                                                                                                                                }

                                                                                                                                .media-upload-card:hover {
                                                                                                                                    border-color: var(--primary-color);
                                                                                                                                    background: var(--gray-100);
                                                                                                                                    transform: translateY(0);
                                                                                                                                }

                                                                                                                                .media-upload-content {
                                                                                                                                    display: flex;
                                                                                                                                    flex-direction: column;
                                                                                                                                    align-items: center;
                                                                                                                                    gap: 0.5rem;
                                                                                                                                    color: var(--gray-600);
                                                                                                                                }

                                                                                                                                .media-upload-content i {
                                                                                                                                    font-size: 2rem;
                                                                                                                                }

                                                                                                                                .media-upload-content span {
                                                                                                                                    font-weight: 500;
                                                                                                                                    font-size: 0.875rem;
                                                                                                                                }
                                                                                                                            `;

            if (!document.getElementById('toast-styles')) {
                const styleSheet = document.createElement('style');
                styleSheet.id = 'toast-styles';
                styleSheet.textContent = styles;
                document.head.appendChild(styleSheet);
            }

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        let risksInfoEditMode = false;
        let risksListEditMode = false;
        let dragRiskIndex = null;

        /* ================= TOGGLE INFO ================= */
        function toggleRisksInfoEdit() {
            risksInfoEditMode = !risksInfoEditMode;
            displayRisks(projectData.risks);

            const btn = document.getElementById('toggleRisksInfoEditBtn');
            btn.innerHTML = risksInfoEditMode
                ? '<i class="bi bi-check-lg me-1"></i> Saqlash'
                : '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

            uiToggleEditButton(btn, risksInfoEditMode);
        }

        /* ================= TOGGLE LIST ================= */
        // function toggleRisksListEdit() {
        //     risksListEditMode = !risksListEditMode;
        //     displayRisks(projectData.risks);

        //     const btn = document.getElementById('toggleRisksListEditBtn');
        //     btn.innerHTML = risksListEditMode
        //         ? '<i class="bi bi-check-lg me-1"></i> Saqlash'
        //         : '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

        //     uiToggleEditButton(btn, risksListEditMode);
        // }

        /* ================= DISPLAY ================= */
        function displayRisks(risks) {
            const list = document.getElementById('risksContainer');

            if (!Array.isArray(risks.risk_items) || risks.risk_items.length === 0) {
                list.innerHTML = '<p class="text-muted text-center py-3">Xatarlar mavjud emas</p>';
                return;
            }

            if (!risksListEditMode) {
                list.innerHTML = risks.risk_items
                    .sort((a, b) => (a.priority || 0) - (b.priority || 0))
                    .map(r => `
                                            <div class="risk-item">
                                                <div class="risk-title">${uiEscapeHtml(r.name)}</div>
                                                <p class="risk-description">${uiEscapeHtml(r.description)}</p>
                                            </div>
                                        `).join('');
            } else {
                list.innerHTML = risks.risk_items
                    .sort((a, b) => (a.priority || 0) - (b.priority || 0))
                    .map((r, index) => `
                                            <div class="risk-item draggable-risk"
                                                 draggable="true"
                                                 data-index="${index}"
                                                 ondragstart="onRiskDragStart(event)"
                                                 ondragover="onRiskDragOver(event)"
                                                 ondrop="onRiskDrop(event)">

                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <i class="bi bi-grip-vertical text-muted"></i>
                                                    <strong>#${index + 1}</strong>
                                                </div>

                                                <input class="form-control mb-2"
                                                    value="${uiEscapeHtml(r.name)}"
                                                    onchange="projectData.risks.risk_items[${index}].name = this.value">

                                                <textarea class="form-control"
                                                    rows="3"
                                                    onchange="projectData.risks.risk_items[${index}].description = this.value">
                            ${uiEscapeHtml(r.description)}</textarea>
                                            </div>
                                        `).join('');
            }
        }
        /* ================= INIT ================= */
        document.addEventListener('DOMContentLoaded', function () {
            if (projectData && projectData.risks) {
                projectData.risks.risk_items.forEach((r, i) => {
                    if (typeof r.priority !== 'number') {
                        r.priority = i + 1;
                    }
                });

                displayRisks(projectData.risks);
            }
        });

    // Append risk management functions from a dedicated partial. These
    // functions override any earlier definitions and provide improved
    // handling of risk information and list editing.
    @include('pages.projects.scripts.risks')
    </script>
@endpush
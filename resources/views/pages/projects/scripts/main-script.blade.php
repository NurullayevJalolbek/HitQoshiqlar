// =================== GLOBAL VARIABLES ===================
let projectData = null;
let currentTab = 'characteristics';
let currentMainImageIndex = 0;
let mainImages = [];

// =================== MOCK DATA ===================
// Bu mockData ni main-script.blade.php dagi eski mockData o'rniga qo'ying

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
        "https://images.unsplash.com/photo-1448630360428-65456885c650?w=1200&q=80"
    ],
    videos: [
        "https://www.youtube.com/embed/QWIoR7vjpBU",
        "https://www.youtube.com/embed/TlP92LPvUjY"
    ],
    process_images: [
        "https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=800&q=80",
        "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&q=80",
        "https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80"
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
    dividend_history: [
        { date: "2024-12", amount: 4.5, status: "To'langan" },
        { date: "2024-09", amount: 4.2, status: "To'langan" },
        { date: "2024-06", amount: 4.0, status: "To'langan" },
        { date: "2024-03", amount: 3.8, status: "To'langan" },
        { date: "2023-12", amount: 3.5, status: "To'langan" },
        { date: "2023-09", amount: 3.2, status: "To'langan" },
        { date: "2023-06", amount: 3.0, status: "To'langan" },
        { date: "2023-03", amount: 2.8, status: "To'langan" }
    ],
    stages: [
        {
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
    rounds: [
        {
            id: 1,
            name: "1-raund (Boshlang'ich)",
            status: "completed",
            min_share: 5000000,
            priority: 1
        },
        {
            id: 2,
            name: "2-raund (Asosiy)",
            status: "in_progress",
            min_share: 10000000,
            priority: 2
        },
        {
            id: 3,
            name: "3-raund (Yakunlovchi)",
            status: "inactive",
            min_share: 15000000,
            priority: 3
        }
    ],
    partners: [
        {
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
        risk_level: "low",
        risk_items: [
            {
                id: 1,
                name: "Bozor riski",
                description: "Ko'chmas mulk bozoridagi narxlarning kutilmagan pasayishi, talab-talabning kamayishi. Bu risk bozor sharoitlarining o'zgarishi, iqtisodiy inqirozlar yoki mintaqaviy omillar tufayli yuzaga kelishi mumkin.",
                priority: 1
            },
            {
                id: 2,
                name: "Qurilish riski",
                description: "Qurilish materiallarining narxining oshishi, qurilish jarayonida texnik muammolar. Materiallar narxining o'zgarishi, yetkazib beruvchilar bilan muammolar, iqlim sharoitlari va texnik xatolar qurilish jarayoniga ta'sir qilishi mumkin.",
                priority: 2
            },
            {
                id: 3,
                name: "Moliyaviy risk",
                description: "Investorlar tomonidan mablag'larning o'z vaqtida kiritilmasligi, valyuta kursining o'zgarishi. Moliyaviy risklar loyihaning moliyalashtirilishiga ta'sir qilishi mumkin.",
                priority: 3
            },
            {
                id: 4,
                name: "Huquqiy risk",
                description: "Qonunchilikdagi o'zgarishlar, ruxsatnomalarni olishdagi kechikishlar. Huquqiy risklar loyihaning amalga oshirilishiga to'sqinlik qilishi mumkin.",
                priority: 4
            }
        ]
    },
    documents: [
        {
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

// =================== UTILITY FUNCTIONS ===================
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

function formatMoney(amount) {
    return new Intl.NumberFormat('uz-UZ').format(amount) + " so'm";
}

function showToast(message, type = 'info') {
    const existingToast = document.querySelector('.custom-toast');
    if (existingToast) existingToast.remove();

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

// =================== TAB SWITCHING ===================
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
        navTabs.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else {
        navTabs.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }

    setTimeout(() => checkScrollButtons(), 300);
}

function checkScrollButtons() {
    const navTabs = document.getElementById('projectTabs');
    const scrollLeftBtn = document.getElementById('scrollLeftBtn');
    const scrollRightBtn = document.getElementById('scrollRightBtn');

    if (navTabs.scrollLeft <= 0) {
        scrollLeftBtn.classList.add('hidden');
    } else {
        scrollLeftBtn.classList.remove('hidden');
    }

    if (navTabs.scrollLeft >= navTabs.scrollWidth - navTabs.clientWidth - 1) {
        scrollRightBtn.classList.add('hidden');
    } else {
        scrollRightBtn.classList.remove('hidden');
    }
}

// =================== MEDIA FUNCTIONS ===================
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
        const videoId = url.match(/(?:youtube\.com\/embed\/|youtu\.be\/)([^&\n?#]+)/)?.[1];
        const thumbnailUrl = videoId ? `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg` : '';

        return `
            <div class="gallery-item video-item" data-media-src="${url}" onclick="openVideoModal('${url}')">
                ${thumbnailUrl ? `<img src="${thumbnailUrl}" alt="Video ${index + 1}" loading="lazy">` : ''}
                <div class="play-icon"><i class="bi bi-play-fill"></i></div>
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

    imgEl.classList.add('d-none');
    videoWrapper.classList.remove('d-none');
    videoEl.src = videoUrl;

    bsModal.show();
}

// =================== DATA LOADING ===================
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
        'active': { text: 'Faol', class: 'status-active' },
        'planned': { text: 'Rejalashtirilgan', class: 'status-planned' },
        'completed': { text: 'Yakunlangan', class: 'status-completed' },
        'inactive': { text: 'Nofaol', class: 'status-inactive' }
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

    // Xarakteristik ma'lumotlar
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

    const mapUrl = `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2996.5!2d${p.location_lng}!3d${p.location_lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDE4JzM5LjkiTiA2OcKwMTQnMjYuMCJF!5e0!3m2!1sen!2s!4v1234567890`;
    document.getElementById('mapFrame').src = mapUrl;

    document.getElementById('managerOrg').textContent = p.manager_organization;
    document.getElementById('licenseNumber').textContent = p.license_number;

    if (p.category === 'construction' || p.category === 'rental') {
        document.getElementById('constructionCard').style.display = 'block';
        document.getElementById('constructionName').textContent = p.construction_org.name;
        document.getElementById('constructionDesc').textContent = p.construction_org.description;

        const logoEl = document.getElementById('constructionLogo');
        logoEl.innerHTML = '';

        if (p.construction_org.url) {
            const img = document.createElement('img');
            img.src = p.construction_org.url;
            img.alt = p.construction_org.name;
            img.style.maxWidth = '120px';
            img.style.maxHeight = '60px';
            img.style.objectFit = 'contain';
            logoEl.appendChild(img);
        } else {
            logoEl.textContent = '-';
        }
    }

    displayMainImages(p.main_images);
    displayVideos(p.videos);
    displayProcessImages(p.process_images);
    
    // =================== QUYIDAGILARNI QO'SHING ===================
    // Barcha tablarni chaqirish
    if (typeof displayStages === 'function') displayStages(p.stages);
    if (typeof displayDistribution === 'function') displayDistribution(p.distribution);
    if (typeof displayRounds === 'function') displayRounds(p.rounds);
    if (typeof displayFinancial === 'function') displayFinancial(p);
    if (typeof displayPartners === 'function') displayPartners(p.partners);
    if (typeof displayRisks === 'function') displayRisks(p.risks);
    if (typeof displayDocuments === 'function') displayDocuments(p.documents);
}

// =================== INITIALIZATION ===================
document.addEventListener('DOMContentLoaded', function() {
    loadProjectData();
    
    const navTabs = document.getElementById('projectTabs');
    if (navTabs) {
        checkScrollButtons();
        navTabs.addEventListener('scroll', checkScrollButtons);
    }
});
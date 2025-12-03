/**
 * Dashboard Static Data
 * Real dataga yaqin static ma'lumotlar
 */

window.dashboardData = {
    // Oylik ma'lumotlar (12 oy)
    monthly: {
        categories: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'Iyun', 'Iyul', 'Avg', 'Sen', 'Okt', 'Noy', 'Dek'],
        
        investors: {
            active: [320, 385, 412, 468, 521, 587, 642, 698, 745, 812, 878, 945],
            passive: [98, 112, 128, 145, 162, 178, 195, 210, 228, 245, 262, 280]
        },
        
        revenue: [1200, 1450, 1680, 1920, 2150, 2480, 2720, 2950, 3180, 3420, 3650, 3890],
        
        payments: [280, 320, 360, 410, 450, 490, 530, 570, 610, 650, 690, 730],
        
        contractRevenue: [850, 920, 1050, 1180, 1320, 1450, 1580, 1720, 1850, 1980, 2110, 2250],
        
        profit: [420, 480, 540, 610, 680, 750, 820, 890, 960, 1030, 1100, 1170],
        
        contracts: [12, 15, 18, 22, 25, 28, 32, 35, 38, 42, 45, 48],
        
        documents: [45, 52, 58, 65, 72, 80, 88, 95, 103, 112, 120, 128]
    },
    
    // Kunlik ma'lumotlar (30 kun - oxirgi oy)
    daily: {
        categories: [
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10',
            '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
            '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'
        ],
        
        investors: {
            // Asta-sekin o'sib boruvchi kunlik ma'lumotlar
            active: [
                819, 821, 823, 825, 827, 830, 832, 834, 836, 838,
                841, 843, 845, 847, 849, 852, 854, 856, 858, 860,
                863, 865, 867, 869, 871, 874, 876, 878, 880, 882
            ],
            passive: [
                247, 247, 248, 248, 249, 250, 250, 251, 251, 252,
                252, 253, 254, 254, 255, 255, 256, 256, 257, 257,
                258, 259, 259, 260, 260, 261, 261, 262, 263, 263
            ]
        },
        
        // Kunlik tushumlar (~3890/30 ≈ 130K per day)
        revenue: [
            122, 125, 128, 130, 132, 135, 128, 130, 132, 135,
            138, 140, 142, 135, 138, 140, 142, 145, 148, 150,
            145, 148, 150, 152, 155, 158, 160, 155, 158, 160
        ],
        
        // Kunlik to'lovlar (~730/30 ≈ 24K per day)
        payments: [
            23, 24, 24, 25, 25, 24, 23, 24, 24, 25,
            25, 26, 24, 24, 23, 24, 24, 25, 25, 24,
            23, 24, 24, 25, 25, 26, 24, 24, 23, 24
        ],
        
        // Kunlik shartnoma daromadi (~2250/30 ≈ 75K per day)
        contractRevenue: [
            70, 72, 74, 75, 76, 78, 75, 76, 78, 80,
            72, 74, 75, 76, 78, 80, 72, 74, 75, 76,
            78, 80, 72, 74, 75, 76, 78, 80, 75, 76
        ],
        
        // Kunlik foyda (~1170/30 ≈ 39K per day)
        profit: [
            37, 38, 39, 40, 38, 39, 40, 37, 38, 39,
            40, 38, 39, 40, 37, 38, 39, 40, 38, 39,
            40, 37, 38, 39, 40, 38, 39, 40, 37, 38
        ],
        
        // Kunlik shartnomalar (~48/30 ≈ 1-2 per day)
        contracts: [
            42, 42, 42, 43, 43, 43, 43, 43, 43, 43,
            43, 43, 44, 44, 44, 44, 44, 44, 44, 44,
            44, 44, 44, 45, 45, 45, 45, 45, 45, 45
        ],
        
        // Kunlik hujjatlar (~128/30 ≈ 4 per day)
        documents: [
            113, 113, 113, 114, 114, 114, 114, 115, 115, 115,
            115, 116, 116, 116, 117, 117, 117, 117, 118, 118,
            118, 118, 119, 119, 119, 119, 120, 120, 120, 121
        ]
    },
    
    // Static donut va pie chart ma'lumotlari
    projectsDistribution: {
        series: [35, 32, 33],  // Foizlar
        labels: ['Land', 'Rent', 'Construction'],
        counts: [24, 22, 22]  // Haqiqiy loyihalar soni
    },
    
    dividendsDistribution: {
        series: [65, 35],  // Foizlar
        labels: ['Paid', 'Pending'],
        amounts: [6500000, 3500000]  // UZS
    },
    
    revenueByProject: {
        series: [850, 720, 680],  // K UZS
        categories: ['Land', 'Rent', 'Construction']
    },
    
    // KPI summary data
    summary: {
        totalInvestors: 1225,
        totalInvestorsGrowth: 15.2,
        totalInvestment: 125000000,  // UZS
        totalInvestmentGrowth: 22.8,
        activeProjects: 68,
        activeProjectsGrowth: 8.5,
        totalRevenue: 3890000,  // UZS
        totalRevenueGrowth: 18.5
    }
};

/**
 * Filter bo'yicha ma'lumotlarni olish
 */
window.getFilteredData = function(filters) {
    const { period, startDate, endDate, projectType, investorType } = filters;
    
    // Base data
    let data = period === 'daily' 
        ? JSON.parse(JSON.stringify(window.dashboardData.daily))
        : JSON.parse(JSON.stringify(window.dashboardData.monthly));
    
    // Agar sana filtri bo'lsa
    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const daysDiff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
        
        // Sana oralig'iga mos ma'lumotlarni kesib olish
        if (daysDiff < 30 && period === 'daily') {
            // Kunlik ma'lumotlardan kerakli qismini olish
            const sliceEnd = Math.min(daysDiff, data.categories.length);
            data.categories = data.categories.slice(0, sliceEnd);
            data.investors.active = data.investors.active.slice(0, sliceEnd);
            data.investors.passive = data.investors.passive.slice(0, sliceEnd);
            data.revenue = data.revenue.slice(0, sliceEnd);
            data.payments = data.payments.slice(0, sliceEnd);
            data.contractRevenue = data.contractRevenue.slice(0, sliceEnd);
            data.profit = data.profit.slice(0, sliceEnd);
            data.contracts = data.contracts.slice(0, sliceEnd);
            data.documents = data.documents.slice(0, sliceEnd);
        }
    }
    
    // Loyiha turi filtri
    if (projectType && projectType !== 'all') {
        // Loyiha turiga qarab ma'lumotlarni o'zgartirish
        const multiplier = projectType === 'land' ? 1.2 : 
                          projectType === 'rent' ? 0.9 : 1.0;
        
        data.revenue = data.revenue.map(v => Math.round(v * multiplier));
        data.contractRevenue = data.contractRevenue.map(v => Math.round(v * multiplier));
        data.profit = data.profit.map(v => Math.round(v * multiplier));
    }
    
    // Investor turi filtri
    if (investorType && investorType !== 'all') {
        if (investorType === 'active') {
            // Faqat active investorlar
            data.investors.passive = data.investors.passive.map(() => 0);
        } else if (investorType === 'passive') {
            // Faqat passive investorlar
            data.investors.active = data.investors.active.map(() => 0);
        }
    }
    
    return data;
};

/**
 * Tarjimalar bilan kategoriyalarni yangilash
 */
window.updateCategoriesWithTranslation = function(period) {
    const trans = window.dashboardTranslations || {};
    
    if (period === 'monthly' && trans.months) {
        return Object.values(trans.months);
    }
    
    return window.dashboardData[period].categories;
};
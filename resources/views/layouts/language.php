<li style="position: relative;">
    <form id="lang-form">
        <input type="hidden" name="lang_id" id="lang-id-input">

        <!-- Tanlangan til -->
        <div class="lang-select" onclick="toggleLangDropdown()"
             style="
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            background: #fff;
            padding: 10px 14px;
            border-radius: 20px;
            cursor: pointer;
            user-select: none;
            width: 140px;
            z-index: 10;
            position: relative;
            box-shadow: 0 0 6px rgba(0,0,0,0.1);
        ">
            <div style="display: flex; gap: 6px; align-items: center;">
                <img id="curr-flag" src="https://flagcdn.com/uz.svg" alt="lang" style="width: 18px;"/>
                <p id="curr-text" style="margin: 0; font-size: 14px;">UZ</p>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/32/32195.png" alt="arrow down"
                 style="width: 10px;" />
        </div>

        <!-- Dropdown -->
        <ul class="lang__dropdown"
            style="
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 140px;
            margin-top: 4px;
            list-style: none;
            padding: 8px;
            border-radius: 15px;
            background-color: #fff;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            flex-direction: column;
        ">
            <li style="margin-bottom: 4px;">
                <button type="button" class="lang-option" data-lang="uz"
                        style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 8px;
                    width: 100%;
                    background: #fff;
                    border: none;
                    padding: 8px 10px;
                    border-radius: 20px;
                    cursor: pointer;
                    font-size: 14px;
                    text-align: left;
                ">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <img src="https://flagcdn.com/uz.svg" alt="UZ" style="width: 18px;" />
                        <span>UZ</span>
                    </div>
                </button>
            </li>
            <li style="margin-bottom: 4px;">
                <button type="button" class="lang-option" data-lang="ru"
                        style="display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%; background: #fff; border: none; padding: 8px 10px; border-radius: 20px; cursor: pointer; font-size: 14px; text-align: left;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <img src="https://flagcdn.com/ru.svg" alt="RU" style="width: 18px;" />
                        <span>RU</span>
                    </div>
                </button>
            </li>
            <li style="margin-bottom: 4px;">
                <button type="button" class="lang-option" data-lang="en"
                        style="display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%; background: #fff; border: none; padding: 8px 10px; border-radius: 20px; cursor: pointer; font-size: 14px; text-align: left;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <img src="https://flagcdn.com/gb.svg" alt="EN" style="width: 18px;" />
                        <span>EN</span>
                    </div>
                </button>
            </li>
            <li style="margin-bottom: 4px;">
                <button type="button" class="lang-option" data-lang="ar"
                        style="display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%; background: #fff; border: none; padding: 8px 10px; border-radius: 20px; cursor: pointer; font-size: 14px; text-align: left;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <img src="https://flagcdn.com/sa.svg" alt="AR" style="width: 18px;" />
                        <span>AR</span>
                    </div>
                </button>
            </li>
        </ul>
    </form>
</li>

<script>
    function toggleLangDropdown() {
        const dropdown = document.querySelector('.lang__dropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'flex' : 'none';
    }

    document.querySelectorAll('.lang-option').forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            const flagMap = {
                'uz': 'https://flagcdn.com/uz.svg',
                'ru': 'https://flagcdn.com/ru.svg',
                'en': 'https://flagcdn.com/gb.svg',
                'ar': 'https://flagcdn.com/sa.svg'
            };
            const textMap = { 'uz':'UZ', 'ru':'RU', 'en':'EN', 'ar':'AR' };

            document.getElementById('curr-flag').src = flagMap[lang];
            document.getElementById('curr-text').innerText = textMap[lang];
            document.getElementById('lang-id-input').value = lang;

            document.querySelector('.lang__dropdown').style.display = 'none';
        });
    });
</script>


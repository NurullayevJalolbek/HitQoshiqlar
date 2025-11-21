<li style="position: relative;">
    <form action="{{ route('language.change') }}" method="POST" id="lang-form">
        @csrf
        <input type="hidden" name="lang_id" id="lang-id-input">

        {{-- Select - tanlangan til ko‘rinadigan joy --}}
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
            width: 120px;
            z-index: 10;
            position: relative;
            box-shadow: 0 0 6px rgba(0,0,0,0.1);
        ">
            @foreach ($languages as $lang)
                @if ($lang->url == auth()->user()?->locale)
                    <div style="display: flex; gap: 6px; align-items: center;">
                        <img class="lang-curr-icon" src="{{ asset($lang->icon) }}" alt="lang"
                             style="width: 18px;"/>
                        <p class="lang-curr-text" style="margin: 0; font-size: 14px;">
                            {{ $lang->name }}
                        </p>
                    </div>
                    <img class="lang-arrow-icon" src="{{ asset('assets/img/icons/arrow-down.svg') }}" alt="arrow down"
                         style="width: 10px;"/>
                @endif
            @endforeach
        </div>

        {{-- Dropdown - tillar ro‘yxati --}}
        <ul class="lang__dropdown"
            style="
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 120px;
            margin-top: 4px;
            list-style: none;
            padding: 8px;
            border-radius: 15px;
            background-color: #fff;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            flex-direction: column;
        ">
            @foreach ($languages as $lang)
                <li style="margin-bottom: 4px;">
                    <button type="button" class="lang-option" data-lang="{{ $lang->id }}"
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
                            <img src="{{ asset($lang->icon) }}" alt="{{ $lang->url }}" style="width: 18px;"/>
                            <span>{{ $lang->name }}</span>
                        </div>
                        @if (auth()->user()?->locale == $lang->url)
                            <img src="{{ asset('assets/img/icons/tick.svg') }}" alt="tick"
                                 style="width: 12px; margin-left: 12px"/>
                        @endif
                    </button>
                </li>
            @endforeach
        </ul>
    </form>
</li>

<script>
    function toggleLangDropdown() {
        const dropdown = document.querySelector('.lang__dropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'flex' : 'none';
    }

    document.querySelectorAll('.lang-option').forEach(option => {
        option.addEventListener('click', function () {
            const langId = this.getAttribute('data-lang');
            document.getElementById('lang-id-input').value = langId;
            document.getElementById('lang-form').submit();
        });
    });
</script>

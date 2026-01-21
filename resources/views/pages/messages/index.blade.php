@extends('layouts.app')

@push('customCss')
<style>
    .msg-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid rgba(0, 0, 0, 0.06);
        background: rgba(31, 41, 55, 0.06);
        color: #1F2937;
    }

    .msg-copy {
        cursor: pointer;
        position: relative;
    }

    .msg-copy:hover {
        text-decoration: underline;
    }


    .msg-meta {
        font-size: 12px;
        opacity: .75;
    }

    .msg-text {
        max-width: 520px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .preview-btn {
        border: 0;
        background: transparent;
        padding: 0;
        margin: 0;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .preview-btn i {
        font-size: 18px;
    }

    .preview-btn.tiktok i {
        color: #111;
    }

    .preview-btn.instagram i {
        color: #E1306C;
    }

    .preview-video {
        width: 100%;
        max-height: 520px;
        border-radius: 12px;
        background: #000;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">

    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Messages</li>
            </ol>
        </nav>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">
        {{-- export kerak bo'lsa --}}
        {{-- <x-export-dropdown :items="['excel','csv']" :urls="['excel' => '#','csv' => '#']" /> --}}
    </div>
</div>
@endsection

@section('content')

@php
$start = $datas->firstItem() ?? 0;
$end = $datas->lastItem() ?? 0;
$total = $datas->total() ?? 0;
@endphp

<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
    <table class="table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th style="width:60px">#</th>
                <th>User</th>
                <th>Username</th>
                <th>Message</th>
                <th style="width:120px">Chat ID</th>
                <th style="width:100px">Msg ID</th>
                <th style="width:160px">Created at</th>
                <th style="width:90px" class="text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($datas as $index => $row)
            @php
            $u = $row->user;

            $username = $u?->username;
            $tg = $username ? ltrim($username, '@') : null;

            $msgText = $row->message ?? '';

            // 1) message ichidan link topamiz
            preg_match('/https?:\/\/\S+/i', $msgText, $m);
            $url = $m[0] ?? null;

            // 2) platform aniqlaymiz
            $isTikTok = $url && (str_contains($url, 'tiktok.com') || str_contains($url, 'vt.tiktok.com'));
            $isInstagram = $url && str_contains($url, 'instagram.com');

            $platform = $isTikTok ? 'tiktok' : ($isInstagram ? 'instagram' : null);
            @endphp

            <tr>
                <td class="text-center fw-bold">{{ ($start ?: 1) + $index }}</td>

                <td>
                    <div class="d-flex flex-column">
                        <span class="fw-semibold">{{ $u?->fullname ?? '-' }}</span>
                        <span class="msg-meta">User ID: {{ $row->user_id ?? '-' }}</span>
                    </div>
                </td>

                <td>
                    @if($tg)
                    <a href="https://t.me/{{ $tg }}"
                        target="_blank"
                        class="text-decoration-none d-inline-flex align-items-center gap-1">
                        <i class="fa-brands fa-telegram" style="color:#229ED9;"></i>
                        <span>{{ '@'.$tg }}</span>
                    </a>
                    @else
                    -
                    @endif
                </td>

                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="msg-text msg-copy"
                            title="Bosib nusxa olish"
                            data-text="{{ $msgText }}">
                            {{ $msgText }}
                        </div>


                        {{-- link bo'lsa faqat iconka --}}
                        @if($platform && $url)
                        <button type="button"
                            class="preview-btn {{ $platform }}"
                            title="Preview"
                            data-bs-toggle="modal"
                            data-bs-target="#mediaPreviewModal"
                            onclick="openMediaPreview(@js($url),@js('url'))">
                            @if($platform === 'tiktok')
                            <i class="fa-brands fa-tiktok"></i>
                            @else
                            <i class="fa-brands fa-instagram"></i>
                            @endif
                        </button>
                        @endif
                    </div>

                    @if(!empty($row->meta))
                    <div class="msg-meta mt-1">
                        meta: {{ is_string($row->meta) ? $row->meta : json_encode($row->meta) }}
                    </div>
                    @endif
                </td>

                <td>{{ $row->chat_id ?? '-' }}</td>
                <td>{{ $row->message_id ?? '-' }}</td>

                <td>
                    {{ $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('H:i d.m.y') : '-' }}
                </td>

                <td class="text-center">
                    <a href="#"
                        class="btn btn-sm d-inline-flex align-items-center gap-1"
                        style="color:#1F2937;"
                        title="Ko'rish">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    Hozircha xabarlar topilmadi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-2">
        <div class="text-muted">
            {{ $start }} - {{ $end }} / Jami: {{ $total }}
        </div>

        <div>
            {{ $datas->links() }}
        </div>
    </div>
</div>
<x-media.preview-modal
    id="mediaPreviewModal"
    :endpoint="route('admin.messages.preview')" />

@endsection

@push('customJs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.msg-copy').forEach(el => {
            el.addEventListener('click', async function() {
                const text = this.dataset.text;
                if (!text) return;

                try {
                    await navigator.clipboard.writeText(text);

                    // 🔔 kichkina feedback
                    const old = this.innerText;
                    this.innerText = '✅ Copied!';
                    this.style.opacity = '0.7';

                    setTimeout(() => {
                        this.innerText = old;
                        this.style.opacity = '1';
                    }, 800);

                } catch (e) {
                    alert('Copy bo‘lmadi 😕');
                }
            });
        });
    });
</script>
@endpush
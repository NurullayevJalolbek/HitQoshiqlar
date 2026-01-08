@push('customJs')
    <script>
        // 1. BIRINCHI - Asosiy script
        @include('pages.projects.scripts.main-script')
        
        // 2. IKKINCHI - Tab scriptlar
        @include('pages.projects.scripts.characteristics')
        @include('pages.projects.scripts.stages')
        @include('pages.projects.scripts.distribution')
        @include('pages.projects.scripts.rounds')
        @include('pages.projects.scripts.financial')
        @include('pages.projects.scripts.partners')
        @include('pages.projects.scripts.risks')
        @include('pages.projects.scripts.documents')
    </script>
@endpush
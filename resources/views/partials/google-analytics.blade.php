@php($gaId = config('services.google_analytics.measurement_id'))
@if($gaId && app()->isProduction())
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', @json($gaId), {
            allow_google_signals: false,
            allow_ad_personalization_signals: false
        });
        @if(session('analytics_event') === 'generate_lead')
            gtag('event', 'generate_lead', { form_name: 'contacto' });
        @endif
    </script>
@endif

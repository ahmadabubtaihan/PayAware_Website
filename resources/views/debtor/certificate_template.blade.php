<!DOCTYPE html>
<html dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('strings.clearance_certificate') ?? 'Clearance Certificate' }}</title>
    <link rel="stylesheet" href="{{ asset('css/debtorStyle.css') }}">
</head>
<body onload="window.print()">

    <div class="certificate">
        <div class="header">
            <h1 class="title">{{ __('strings.clearance_certificate') }}</h1>
            <p style="color: #64748b;">{{ __('strings.app_name') ?? 'PayAware Financial System' }}</p>
        </div>

        <div class="content">
            <p>
                {{ __('strings.cert_body_1') }} <span class="highlight">{{ __('strings.app_name') ?? 'PayAware' }}</span> {{ __('strings.cert_body_2') }}: <br>
                <span class="highlight" style="font-size: 24px; display: block; text-align: center; margin: 10px 0;">{{ $user->name }}</span>
            </p>
            <p>
                {{ __('strings.cert_body_3', ['id' => $user->id]) }}
            </p>
            <p>
                {{ __('strings.cert_body_4', ['date' => date('Y-m-d')]) }}:
            </p>
            <div style="text-align: center; margin: 20px 0;">
                <span class="highlight" style="font-size: 30px;">${{ number_format($remainingDebt, 2) }}</span>
            </div>
            
            @if($remainingDebt == 0)
                <p style="text-align: center; color: green; font-weight: bold;">
                    {{ __('strings.cert_status_clear') }}
                </p>
            @else
                <p style="text-align: center; color: #b91c1c; font-weight: bold;">
                    {{ __('strings.cert_status_debt') }}
                </p>
            @endif

            <p style="font-size: 14px; color: #64748b; margin-top: 30px;">
                * {{ __('strings.cert_footer_note') }}
            </p>
        </div>

        <div class="footer">
            <div class="signature">
                <p>{{ __('strings.authorized_signature') }}</p>
                <img src="https://ui-avatars.com/api/?name=Admin&background=0d9488&color=fff" width="60" style="border-radius: 50%;">
            </div>
            <div class="signature">
                <div class="seal">
                    {{ __('strings.official_seal') }}
                    <br>PayAware
                </div>
            </div>
        </div>
    </div>

</body>
</html>
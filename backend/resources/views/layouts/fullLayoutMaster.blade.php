@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

    <!DOCTYPE html>
{{-- {!! Helper::applClasses() !!} --}}
@php
    $configData = Helper::applClasses();
@endphp
<html lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
      data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
      class="loading {{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}"
      data-layout="dark-layout">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="test-api-token" content="{{ Helper::personalToken() }}">

    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{Helper::getFaviconName()}}">
    {{--    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/favicon.ico')}}">--}}

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')
</head>


<body class="vertical-layout vertical-menu-modern {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{($configData['theme'] === 'dark') ? 'dark-layout' : 'light' }}
    data-menu=" vertical-menu-modern
"
data-layout="{{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}"
style="{{ $configData['bodyStyle'] }}" data-framework="laravel" data-asset-path="{{ asset('/')}}">

<!-- BEGIN: Content-->
<div class=" {{ $configData['pageClass'] }}">
    <div class="content-wrapper">
        <div class="content-body">

            {{-- Include Startkit Content --}}
            @yield('content')

        </div>
    </div>
</div>
<!-- End: Content-->

{{-- include default scripts --}}
@include('panels/scripts')


</body>

</html>

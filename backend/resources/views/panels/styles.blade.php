<link rel="stylesheet" href="{{ Helper::getMix("vendors/css/vendors.min.css") }}"/>
<link rel="stylesheet" href="{{ Helper::getMix("vendors/css/ui/prism.min.css") }}"/>
{{-- Vendor Styles --}}
@yield('vendor-style')
{{-- Theme Styles --}}

<link rel="stylesheet" href="{{ Helper::getMix("css/core.css") }}"/>

{{-- {!! Helper::applClasses() !!} --}}
@php $configData = Helper::applClasses(); @endphp

{{-- Page Styles --}}
@if($configData['mainLayoutType'] === 'horizontal')
    <link rel="stylesheet" href="{{ Helper::getMix("css/base/core/menu/menu-types/horizontal-menu.css") }}"/>
@endif
<link rel="stylesheet" href="{{ Helper::getMix("css/base/core/menu/menu-types/vertical-menu.css") }}"/>
<!-- <link rel="stylesheet" href="{{ Helper::getMix("css/base/core/colors/palette-gradient.css") }}"> -->

{{-- Page Styles --}}
@yield('page-style')

{{-- Laravel Style --}}
<link rel="stylesheet" href="{{ Helper::getMix("css/overrides.css") }}"/>


@vite("resources/sass/app.scss")

{{-- Custom RTL Styles --}}

@if($configData['direction'] === 'rtl' && isset($configData['direction']))
    <link rel="stylesheet" href="{{ Helper::getMix("css-rtl/custom-rtl.css") }}"/>
    <link rel="stylesheet" href="{{ Helper::getMix("css-rtl/style-rtl.css") }}"/>
@endif

{{-- user custom styles --}}
<link rel="stylesheet" href="{{ Helper::getMix("css/style.css") }}"/>
<style>
    .up {
        margin-top: -65px;
    }


    .app-content {
        padding: 10px !important;
    }

    .horizontal-menu .header-navbar.navbar-horizontal.floating-nav {
        top: 0px !important;
    }


    .header-navbar.floating-nav {
        position: relative
    }

    .horizontal-menu .horizontal-menu-wrapper {
        position: unset

    }

    .horizontal-layout.navbar-floating .header-navbar-shadow {
        display: none
    }

    .horizontal-menu .header-navbar.navbar-horizontal.floating-nav {
        width: 100% !important;
        margin-bottom: 20px !important;
    }

    .horizontal-layout.navbar-floating .horizontal-menu-wrapper {
        margin: 0 auto;
    }
    .navigation li  {
        white-space: inherit !important;
    }
</style>



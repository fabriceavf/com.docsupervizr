{{-- Vendor Scripts --}}
<script src="{{ Helper::getMix("vendors/js/vendors.min.js") }}"></script>
<script src="{{ Helper::getMix("vendors/js/ui/prism.min.js") }}"></script>

@yield('vendor-script')
{{-- Theme Scripts --}}
<script src="{{ Helper::getMix("js/core/app-menu.js") }}"></script>
<script src="{{ Helper::getMix("js/core/app.js") }}"></script>
@if($configData['blankPage'] === false)
    <script src="{{ Helper::getMix("js/scripts/customizer.js") }}"></script>
@endif
<script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
<script>

    window.laravel_echo_port = '{{env("LARAVEL_ECHO_PORT")}}';

</script>
@yield('page-script')


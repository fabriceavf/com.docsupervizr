{{-- For Horizontal submenu --}}
<ul class="dropdown-menu">
    @if(isset($menu))
        @foreach($menu as $submenu)
            @if(\App\Helpers\Helpers::canShowMenu($submenu))
            @php
                $custom_classes = "";
                if(isset($submenu->classlist)) {
                  $custom_classes = $submenu->classlist;
                }
            @endphp

            <li
                class="{{ $custom_classes }}{{ (isset($submenu->submenu)) ? 'dropdown dropdown-submenu' : '' }} {{ $submenu->slug === Route::currentRouteName() ? 'active' : '' }}" @if(isset($submenu->submenu))
                {{'data-menu=dropdown-submenu'}}
                @endif>
                <a href="{{Helper::getMenuLink($submenu)}}"
                   class="dropdown-item {{ (isset($submenu->submenu)) ? 'dropdown-toggle' : '' }} d-flex align-items-center"
                   {{ (isset($submenu->submenu)) ? 'data-toggle=dropdown' : '' }} target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
                    @if (isset($submenu->icon))
                        {{-- <i data-feather="{{ $submenu->icon }}"></i> --}}
                        <i class="{{$submenu->icon}}"></i>
                    @endif
                    {{-- <span>{{ __('locale.'.$submenu->name) }}</span> --}}
                    <span>{{ __($submenu->name) }}</span>
                </a>
                @if (isset($submenu->submenu))
                    @include('panels/horizontalSubmenu', ['menu' => $submenu->submenu])
                @endif
            </li>
            @endif
        @endforeach
    @endif
</ul>

{{-- For submenu --}}
<ul class="menu-content">
    @if(isset($menu))
        @foreach($menu as $submenu)
            @if(Helper::canShowMenu($submenu))
                <li class="{{ $submenu->slug === Route::currentRouteName() ? 'active' : '' }}">
                    <a href="{{Helper::getMenuLink($submenu)}}" class="d-flex align-items-center"
                       target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
                        @if(isset($submenu->icon))
                            {{--      <i data-feather="{{$submenu->icon}}"></i>--}}
                            <i class="{{$submenu->icon}}"></i>
                        @endif
                        {{--      <span class="menu-item text-truncate">{{ __('locale.'.$submenu->name) }}</span>--}}
                        <span class="menu-item text-truncate">{{ $submenu->name }}</span>
                    </a>
                    @if (isset($submenu->submenu))
                        @include('panels/submenu', ['menu' => $submenu->submenu])
                    @endif
                </li>
            @endif
        @endforeach
    @endif
</ul>

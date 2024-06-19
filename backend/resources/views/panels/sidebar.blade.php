@php
    $configData = Helper::applClasses();
@endphp
<div
    class="main-menu menu-fixed {{(($configData['theme'] === 'dark') || ($configData['theme'] === 'semi-dark')) ? 'menu-dark' : 'menu-light'}} menu-accordion menu-shadow"
    data-scroll-to-active="true">
    <div class="navbar-header row">
        <ul class="nav navbar-nav " style="width:100%">
            <li class="nav-item mr-auto col-10">
                <a class="navbar-brand mx-auto d-block" href="{{url('/')}}"> 
                
          <span class="brand-logo ">
          </span>
                    <img class="rounded mx-auto d-block " src="{{Helper::getLogoName()}}" alt="avatar" height="40"
                         width="40">
                       
                         

                    <h2 class="brand-text text-center mt-1">Documentation</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle col-2">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i> 
                    <i class="fa-solid fa-book "></i> 
                    <!-- icon de documentation  -->
                   
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>


    <div class="main-menu-content mt-1">
        <div class="p-2 text-center border-bottom" style="border-color:#777 !important;display:flex">
            {{--                    <img class="round  border-primary mb-2" src="{{"https://ui-avatars.com/api/?name=".(trim(Auth::user()->nom)[0])."+".(trim(Auth::user()->prenom)[0])."+H&color=7F9CF5&background=EBF4FF"}}" alt="avatar" height="40" width="40">--}}
            {{--                    <img--}}
            {{--                        src="{{"https://ui-avatars.com/api/?name=".(trim(Auth::user()->nom)[0])."+".(trim(Auth::user()->prenom)[0])."+H&color=7F9CF5&background=EBF4FF"}}"--}}
            {{--                        class="img-fluid1 rounded-circle border-primary mb-2"--}}
            {{--                        style="width: 20px; height:200px; border-width: 3px !important"--}}
            {{--                        style="width: 110px; height:110px; border-width: 3px !important"--}}
            {{--                        alt="">--}}
            <div>

                <h6 class="text-dark weight-bold mb-0 mt-1">{{Auth::user()->prenom}} {{Auth::user()->nom}}</h6>
                <p class="mb-0 weight-bold text-primary font-8 mt-1">{{Auth::user()->email}}</p>
                <a href="{{\App\Helpers\Helpers::getLogoutRoute()}}">
                    <button class="btn btn-danger mt-1">Deconnection</button>
                </a>

            </div>
        </div>
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- Foreach menu item starts --}}
            @if(isset($menuData[0]))

                @foreach(Helper::myMenu($menuData[0]->menu) as $menu)
                    @if(isset($menu->navheader))
                        <li class="navigation-header">
                            {{--        <span>{{ __('locale.'.$menu->navheader) }}</span>--}}
                            <span>{{ $menu->navheader }}</span>
                            <i data-feather="more-horizontal"></i>
                        </li>
                    @else
                        {{-- Add Custom Class with nav-item --}}
                        @php
                            $custom_classes = "";
                            if(isset($menu->classlist)) {
                            $custom_classes = $menu->classlist;
                            }
                        @endphp

                        @if(Helper::hideMenu($menu))

                        @elseif(Helper::veroullerMenu($menu))

                            {{--                            <li class="nav-item {{ Route::currentRouteName() === $menu->slug ? 'active' : '' }} {{ $custom_classes }}">--}}
                            {{--                                <a href="{{Helper::getMenuLink($menu)}}" style="background: #bdbbbb;border-radius: 5px;"--}}
                            {{--                                   class="d-flex align-items-center"--}}
                            {{--                                   target="{{isset($menu->newTab) ? '_blank':'_self'}}">--}}
                            {{--                                    <i class="{{ $menu->icon }}"></i>--}}
                            {{--                                    <i class="fa-solid fa-eye-slash"--}}
                            {{--                                       style="position: absolute;top: 10px;right: 10px;z-index: 100;color: #ea5455;"></i>--}}
                            {{--                                    <span class="menu-title text-truncate">{{ $menu->name }}</span>--}}
                            {{--                                    @if (isset($menu->badge))--}}
                            {{--                                            <?php $badgeClasses = "badge badge-pill badge-light-primary ml-auto mr-1" ?>--}}
                            {{--                                        <span--}}
                            {{--                                            class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }} ">{{$menu->badge}}</span>--}}
                            {{--                                    @endif--}}
                            {{--                                </a>--}}
                            {{--                                @if(isset($menu->submenu))--}}
                            {{--                                    @include('panels/submenu', ['menu' => $menu->submenu])--}}
                            {{--                                @endif--}}
                            {{--                            </li>--}}
                        @else
                            <li class="nav-item {{ Route::currentRouteName() === $menu->slug ? 'active' : '' }} {{ $custom_classes }}">
                                <a href="{{Helper::getMenuLink($menu)}}" class="d-flex align-items-center"
                                   target="{{isset($menu->newTab) ? '_blank':'_self'}}">
                                    <i class="{{ $menu->icon }}"></i>
                                    {{--                  <span class="menu-title text-truncate">{{ __('locale.'.$menu->name) }}</span>--}}
                                    <span class="menu-title ">{{ $menu->name }}</span>
                                    @if (isset($menu->badge))
                                            <?php $badgeClasses = "badge badge-pill badge-light-primary ml-auto mr-1" ?>
                                        <span
                                            class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }} ">{{$menu->badge}}</span>
                                    @endif
                                </a>
                                @if(isset($menu->submenu))
                                    @include('panels/submenu', ['menu' => $menu->submenu])
                                @endif
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif
            {{-- Foreach menu item ends --}}
        </ul>
    </div>
</div>
<!-- END: Main Menu-->

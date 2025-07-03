<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">SPI POLINEMA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">SPI</a>
        </div>
        <ul class="sidebar-menu">

            @foreach ($merged_menus as $item)
                @if ($item instanceof \App\Models\Menu)
                    <li class="{{ Request::is(ltrim($item->link, '/')) ? 'active' : '' }}">
                        <a href="{{ $item->link }}" class="nav-link">
                            <i class="nav-icon {{ $item->icon }}"></i>
                            <span>{{ $item->name }}</span>
                        </a>
                    </li>
                @else
                    {{-- Head menu --}}
                    @php
                        $count = 0;
                        foreach ($item->Menu as $menu) {
                            if ($menu->Level_menu->pluck('id_level')->contains(auth()->user()->id_level)) {
                                $count++;
                            }
                        }
                    @endphp

                    @if ($count > 0)
                        @php
                            $isActiveParent = false;
                            foreach ($item->Menu as $menu) {
                                if (Request::is(ltrim($menu->link, '/'))) {
                                    $isActiveParent = true;
                                    break;
                                }
                            }
                        @endphp
                        <li class="nav-item dropdown {{ $isActiveParent ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown">
                                <i class="nav-icon {{ $item->icon }}"></i>
                                <span>{{ $item->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($item->Menu as $menu)
                                    @if ($menu->Level_menu->pluck('id_level')->contains(auth()->user()->id_level))
                                        <li class="{{ Request::is(ltrim($menu->link, '/')) ? 'active' : '' }}">
                                            <a href="{{ $menu->link }}" class="nav-link">
                                                <i class="{{ $menu->icon }}"></i>
                                                <span>{{ $menu->name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach

            <li>
                <a href="/logout" class="nav-link">
                    <i class="fas fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>

    </aside>
</div>

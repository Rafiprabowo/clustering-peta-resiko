<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">SPI POLINEMA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">SPI</a>
        </div>

        @php $panelMenus = collect($panel_menus); @endphp

        <ul class="sidebar-menu">
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ $first_menu->link }}" class="nav-link">
                    <i class="{{ $first_menu->icon }}"></i>
                    <span>{{ $first_menu->name }}</span>
                </a>
            </li>

            @foreach ($head_menus as $head_menu)
                @php $count = 0; @endphp
                @foreach ($head_menu->Menu as $menu)
                    @php
                        $level_menu = $menu->Level_menu->pluck('id_level')->toArray();
                    @endphp
                    @if (in_array(auth()->user()->id_level, $level_menu))
                        @php $count++; @endphp
                    @endif
                @endforeach

                @if ($count > 0)
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon {{ $head_menu->icon }}"></i>
                            <span>{{ $head_menu->name }}</span>
                            <i class="fas fa-angle-left right"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($head_menu->Menu as $menu)
                                @php
                                    $level_menu = $menu->Level_menu->pluck('id_level')->toArray();
                                @endphp
                                @if (in_array(auth()->user()->id_level, $level_menu))
                                    @php $active = ltrim($menu->link, '/'); @endphp
                                    <li class="{{ Request::is($active) ? 'active' : '' }}">
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
            @endforeach

            @foreach ($panelMenus->take(3) as $menu)
                <li class="{{ $active == $menu->id ? 'active' : '' }}">
                    <a href="{{ $menu->link }}" class="nav-link">
                        <i class="nav-icon {{ $menu->icon }}"></i>
                        <span>{{ $menu->name }}</span>
                    </a>
                </li>
            @endforeach

            {{-- Dropdown: Peta Risiko --}}
            <li class="nav-item dropdown {{ in_array($active, [21, 7]) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-map"></i>
                    <span>Peta Risiko</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ $active == 21 ? 'active' : '' }}">
                        <a class="nav-link" href="/analisis">Analisis Peta Risiko</a>
                    </li>
                    <li class="{{ $active == 7 ? 'active' : '' }}">
                        <a class="nav-link" href="/petas">Peta Risiko</a>
                    </li>
                </ul>
            </li>

            {{-- Dropdown: Clustering --}}
            <li class="nav-item dropdown  {{ in_array($active, [20, 25, 25]) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-project-diagram"></i>
                    <span>Clustering</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ $active == 20 ? 'active' : '' }}">
                        <a class="nav-link" href="/dataset">Unggah Dataset</a>
                    </li>

                     <li class="{{ $active == 25 ? 'active' : '' }}">
                        <a class="nav-link" href="/proses-clustering">Proses Clustering</a>
                    </li>

                     <li class="{{ $active == 26 ? 'active' : '' }}">
                        <a class="nav-link" href="/riwayat-clustering">Riwayat Clustering</a>
                    </li>
                </ul>


            </li>


            @php
                $excluded_ids = [7, 20, 21, 25, 26];
                $filteredMenus = $panelMenus->slice(5)->filter(function ($menu) use ($excluded_ids) {
                    return !in_array($menu->id, $excluded_ids);
                });
            @endphp

            @foreach ($filteredMenus as $menu)
                <li class="{{ $active == $menu->id ? 'active' : '' }}">
                    <a href="{{ $menu->link }}" class="nav-link">
                        <i class="nav-icon {{ $menu->icon }}"></i>
                        <span>{{ $menu->name }}</span>
                    </a>
                </li>
            @endforeach


            {{-- Logout --}}
            <li>
                <a href="/logout" class="nav-link">
                    <i class="fas fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>
</div>

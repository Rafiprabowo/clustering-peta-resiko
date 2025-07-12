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
                    {{-- Menu tanpa head --}}
                    @php
                        $currentLink = trim($item->link, '/');
                        $isMenuActive = request()->is($currentLink) || request()->is($currentLink . '/*');

                        // Deteksi apakah nama menu mengandung "Manual Book"
                        $isManualBook = str_contains($item->name, 'Manual Book');
                        $isKuisioner = str_contains($item->name, 'Link Kuisioner');
                    @endphp

                    <li class="{{ $isMenuActive ? 'active' : '' }}">
                        <a href="{{ $item->link }}" class="nav-link {{ $isManualBook || $isKuisioner ? 'small-font' : '' }}">
                            <i class="nav-icon {{ $item->icon }}"></i>
                            <span>{{ $item->name }}</span>
                        </a>
                    </li>
                @else
                    {{-- Head Menu (dropdown) --}}
                    @php
                        // Deteksi apakah salah satu submenu aktif
                        $isParentActive = $item->Menu->contains(function ($menu) {
                            $link = trim($menu->link, '/');
                            return request()->is($link) || request()->is($link . '/*');
                        });
                    @endphp

                    <li class="nav-item dropdown {{ $isParentActive ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown toggle-submenu">
                            <i class="nav-icon {{ $item->icon }}"></i>
                            <span>{{ $item->name }}</span>
                        </a>
                        <ul class="dropdown-menu {{ $isParentActive ? 'show' : '' }}">
                            @foreach ($item->Menu as $menu)
                                @php
                                    $isSubActive =
                                        request()->is(trim($menu->link, '/')) ||
                                        request()->is(trim($menu->link, '/') . '/*');
                                @endphp
                                <li class="{{ $isSubActive ? 'active' : '' }}">
                                    <a href="{{ $menu->link }}" class="nav-link">
                                        <i class="{{ $menu->icon }}"></i>
                                        <span>{{ $menu->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-submenu').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();

                const parent = this.closest('.nav-item.dropdown');
                const menu = parent.querySelector('.dropdown-menu');

                // Tutup semua dropdown lain
                document.querySelectorAll('.dropdown-menu').forEach(el => {
                    if (el !== menu) el.classList.remove('show');
                });
                document.querySelectorAll('.nav-item.dropdown').forEach(el => {
                    if (el !== parent) el.classList.remove('active');
                });

                // Toggle yang ini
                menu.classList.toggle('show');
                parent.classList.toggle('active');
            });
        });
    });
</script>

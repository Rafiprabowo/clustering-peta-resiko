<?php

namespace App\Providers;

use App\Models\Level_menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;
use App\Models\Head_menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
{
    View::composer('*', function ($view) {
        View::share('user', auth()->user());

        if (auth()->check()) {
            $level_menus = Level_menu::where('id_level', auth()->user()->id_level)->get();
            $allowed_menu_ids = $level_menus->pluck('id_menu')->toArray();

            // Menu tanpa head
            $panel_menus = Menu::whereNull('id_head_menu')
                ->whereIn('id', $allowed_menu_ids)
                ->orderBy('order')
                ->get()
                ->map(function ($menu) {
                    $menu->menu_type = 'single';
                    $menu->global_order = $menu->order ?? 999;
                    return $menu;
                });

            // Menu dalam Head_menu
            $head_menus = Head_menu::with(['Menu' => function ($query) use ($allowed_menu_ids) {
                $query->whereIn('id', $allowed_menu_ids)
                      ->orderBy('order')
                      ->with('Level_menu');
            }])->orderBy('order')->get();

            // Filter dan beri tipe
            $head_menus = $head_menus->filter(function ($head_menu) {
                return $head_menu->Menu->count() > 0;
            })->map(function ($head_menu) {
                $head_menu->menu_type = 'head';
                $head_menu->global_order = $head_menu->order ?? 999;
                return $head_menu;
            });

            $merged_menus = $panel_menus
                ->concat($head_menus)
                ->sortBy('global_order')
                ->values();

            View::share([
                'first_menu' => Menu::first(),
                'panel_menus' => $panel_menus,
                'head_menus' => $head_menus,
                'level_menus' => $level_menus,
                'merged_menus' => $merged_menus,
            ]);
        }
    });
}

}

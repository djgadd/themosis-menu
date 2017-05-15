<?php

namespace KeltieCochrane\Menu;

use Themosis\Foundation\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Defer loading unless we need it, saves us a little bit of overhead if the
   * current request isn't trying to log anything.
   *
   * @var bool
   */
  protected $defer = true;

  /**
   * Register bindings in the container.
   *
   * @return void
  */
  public function register ()
  {
    $this->app->singleton('menu', function ($app) {
      return new MenuManager();
    });

    // Handle the cache when menu's change
    app('action')->add('wp_update_nav_menu', function ($menuId) {
      app('menu')->clear($menuId);
    });
  }
}

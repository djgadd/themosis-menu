<?php

namespace KeltieCochrane\Menu;

use Illuminate\Support\Collection;

class MenuLocation
{
  /**
   * @var string
   */
  protected $location;

  /**
   * @var \KeltieCochrane\Menu\Menu
   */
  protected $menu;

  /**
   * Bleep bloop
   *
   * @param string $location
   * @param int $activePostId
   */
  public function __construct (string $location, int $activePostId = null)
  {
    $this->location = $location;
    $this->activePostId = $activePostId ?: get_queried_object_id();

    // Parse the menu
    $this->parseMenu();
  }

  /**
   * Builds up our menu
   *
   * @return void
   */
  protected function parseMenu ()
  {
    // Don't do anything if the menu location doesn't exist
    if (!app('menu')->getLocations()->has($this->location)) {
      return;
    }

    // Get the menu
    $this->menu = new Menu(app('menu')->getLocations()->get($this->location));
  }

  /**
   * Map calls onto the menu
   *
   * @param string $method
   * @param array $args
   * @return mixed
   */
  public function __call (string $method, array $args)
  {
    return call_user_func_array([$this->menu, $method], $args);
  }

  /**
   * Maps get calls onto the menu
   *
   * @param string $property
   * @return mixed
   */
  public function __get (string $property)
  {
    return $this->menu->$property;
  }
}

<?php

namespace KeltieCochrane\Menu;

use Illuminate\Support\Collection;

class MenuManager
{
  /**
   * @var \Illuminate\Support\Collection
   */
  protected $locations;

  /**
   * Bleep bloop
   */
  public function __construct ()
  {
    $this->locations = collect(get_nav_menu_locations());
  }

  /**
   * Gets a menu by ID
   *
   * @param int $id
   * @param int $activePostId
   * @return \KeltieCochrane\Menu\Menu
   */
  public function get (int $id, int $activePostId = null) : Menu
  {
    return new Menu($id, $activePostId);
  }

  /**
   * Gets a menu by theme location
   *
   * @param string $location
   * @param int $activePostId
   * @return \KeltieCochrane\Menu\MenuLocation
   */
  public function getByLocation (string $location, int $activePostId = null) : MenuLocation
  {
    return new MenuLocation($location, $activePostId);
  }

  /**
   * Clears a menu from the cache, useful for when menus are updated
   *
   * @param string $id
   * @return bool
   */
  public function clear (int $id) : bool
  {
    return app('cache')->tags(['menus', $id])->flush();
  }

  /**
   * Returns the themes locations
   *
   * @return \Illuminate\Support\Collection
   */
  public function getLocations () : Collection
  {
    return $this->locations;
  }
}

<?php

if (!function_exists('getMenuById')) {
  /**
   * Helper functino that maps to MenuManager::get
   *
   * @param int $id
   * @param int $activePostId
   * @return \KeltieCochrane\Menu\Menu
   */
  function getMenuById (int $id, int $activePostId = null) : \KeltieCochrane\Menu\Menu
  {
    return app('menu')->get($id, $activePostId);
  }
}

if (!function_exists('getMenuByLocation')) {
  /**
   * Helper function that maps to MenuManager::getByLocation
   *
   * @param string $location
   * @param int $activePostId
   * @return \KeltieCochrane\Menu\MenuLocation
   */
  function getMenuByLocation(string $location, int $activePostId = null) : \KeltieCochrane\Menu\MenuLocation
  {
    return app('menu')->getByLocation($location, $activePostId);
  }
}

<?php

namespace KeltieCochrane\Menu;

use Illuminate\Support\Collection;

class Menu
{
  /**
   * @var int
   */
  protected $id;

  /**
   * @var int|null
   */
  protected $activePostId;

  /**
   * @var \WP_Term
   */
  protected $menu;

  /**
   * @var \Illuminate\Support\Collection
   */
  protected $items;

  /**
   * Bleep bloop
   *
   * @param string $id
   * @param int $activePostId
   */
  public function __construct (int $id, int $activePostId = null)
  {
    $this->id = $id;
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
    // Get the menu
    $this->menu = wp_get_nav_menu_object($this->id);

    // Build a menu if we don't have a cached copy of it
    if (!app('cache')->tags(['menus', $this->id])->has($this->activePostId)) {
      $this->items = $this->buildMenu();
      app('cache')->tags(['menus', $this->id])->forever($this->activePostId, $this->items);
    }
    else {
      $this->items = app('cache')->tags(['menus', $this->id])->get($this->activePostId);
    }
  }

  /**
   * Builds a menu from source
   *
   * @return \Illuminate\Support\Collection
   */
  protected function buildMenu () : Collection
  {
    $items = wp_get_nav_menu_items($this->menu->term_id);
    _wp_menu_item_classes_by_context($items);

    // Collect the items and sort by the menu parent, which will ensure we have
    // an item with it's complete list of descendants
    $items = collect($items)->sortByDesc('menu_item_parent');

    // Group children
    foreach ($items as &$item) {
      $item->children = $items->where('menu_item_parent', '=', $item->ID);
    }

    // Get top level items and sort by menu_order
    return $items->where('menu_item_parent', '=', 0)->sortBy('menu_order');
  }

  /**
   * Map calls onto the collection
   *
   * @param string $method
   * @param array $args
   * @return mixed
   */
  public function __call (string $method, array $args)
  {
    return call_user_func_array([$this->items, $method], $args);
  }

  /**
   * Maps get calls onto the WP_Term instance
   *
   * @param string $property
   * @return mixed
   */
  public function __get (string $property)
  {
    return $this->menu->$property;
  }
}

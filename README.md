# Themosis Cache
A package to make working with menus easier. Requires `keltiecochrane/themosis-illuminate` and `keltiecochrane/themosis-cache` to be setup for collections and caching. Will build menus from source and cache them "forever", will clear the menu from cache if it's updated/deleted.

## Install
Install through composer: -
`composer require keltiecochrane/themosis-menu`

Register the service provider in your `theme/resources/config/providers.php` file: -
`KeltieCochrane\Menu\MenuServiceProvider::class,`

Optionally register the alias in your `theme/resources/config/theme.php` file: -
`'Menu' => KeltieCochrane\Menu\MenuFacade::class,`

## Examples
```
  $menu = Menu::getByLocation('header-nav');
  $menu->name; // The menu's name
  $menu->each(function ($item) {
    $item->children; // The menu items children
    $item->descendants; // A collection of IDs for all this items descendants
    $item->active; // Boolean indicating whether this item is the current page/post/etc.
    $item->active_descendant // Boolean indicating whether a descendant is active

    // Plus all the usual WP_Post fields
  });
```

See the [Laravel docs](https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md) for more info.

## Helpers
The following (additional) helpers are available: -

* getMenuById(1)
* getMenuByLocation('header-nav')

## To Do

* Testing

## Support
This plugin is provided as is, though we'll endeavour to help where we can.

## Contributing
Any contributions would be encouraged and much appreciated, you can contribute by: -

* Reporting bugs
* Suggesting features
* Sending pull requests

<?php

/**
 * @package D9SPL
 */

namespace Inc;

final class Init
{
    /**
     * Store all the classes inside an array
     * @return array Full list of classes
     * @since 1.0.0
     */
    public static function get_services()
    {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Pages\Settings::class
        ];
    }

    /**
     * Loop through the classes, initialize them, 
     * and call the register() method if it exists
     * @return
     * @since 1.0.0
     */
    public static function register_services()
    {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     * @param  class $class    class from the services array
     * @return class instance  new instance of the class
     * @since 1.0.0
     */
    private static function instantiate($class)
    {
        $service = new $class();

        return $service;
    }
}

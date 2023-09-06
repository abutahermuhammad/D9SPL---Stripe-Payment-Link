<?php

/**
 * @package D9SPL
 */

namespace Inc;

final class Init
{
    private static $instances = array();

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
            Pages\Settings::class,
            Pages\NewLink::class,
            Pages\PaymentLinks::class,
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
            $service = self::get_instance($class);

            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }


    /**
     * Get a single instance of the class
     * @param  class $class    class from the services array
     * @return class instance  instance of the class
     * @since 1.0.0
     */
    public static function get_instance($class)
    {
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }
}

<?php

namespace Application;

use Symfony\Component\Yaml\Yaml;

class Configuration
{
    private static $config;

    const CONFIG_FILE_PATH = __DIR__ . "/../config/settings.yml";

    public static function get($key)
    {
        $settings = static::getSettings();

        $setting = $settings;
        $parts = explode("/", $key);
        foreach ($parts as $part) {
            if (!isset($setting[$part])) {
                throw new \Exception('Configuration error: Key ' . $key . ' not found.');
            }

            $setting = $setting[$part];
        }

        return $setting;
    }

    protected static function getSettings()
    {
        if (!file_exists(static::CONFIG_FILE_PATH)) {
            throw new \Exception("Configuration file not found. Expected: ".static::CONFIG_FILE_PATH);
        }

        if (!static::$config) {
            static::$config = Yaml::parse(file_get_contents(static::CONFIG_FILE_PATH));
        }

        return static::$config;
    }

}

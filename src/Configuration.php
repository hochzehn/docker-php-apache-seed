<?php

namespace Application;

use Symfony\Component\Yaml\Yaml;

class Configuration
{
    const CONFIG_FILE_PATH = __DIR__ . "/../config/settings.yml";

    private static $config = null;

    /**
     * Get configuration value for specified configuration key.
     *
     * Key can be a multi-path key, e.g. "foo/bar", which will be mapped to
     *   # config/settings.yml
     *   foo:
     *     bar: 42
     *
     * @param  string $key
     * @return mixed
     * @throws \Exception
     */
    public static function get($key)
    {
        $settings = static::getSettings();

        $currentNode = $settings;
        $paths = explode("/", $key);
        foreach ($paths as $path) {
            if (!isset($currentNode[$path])) {
                throw new \Exception('Configuration error: Key ' . $key . ' not found.');
            }

            $currentNode = $currentNode[$path];
        }

        $result = $currentNode;
        return $result;
    }

    /**
     * Set array of settings to be used instead of reading from file.
     *
     * Useful for testing.
     *
     * @param array $settings
     */
    public static function setSettings($settings)
    {
        static::$config = $settings;
    }

    /**
     * Get settings, cached.
     *
     * @return array
     * @throws \Exception
     */
    protected static function getSettings()
    {
        if (!static::$config) {
            static::$config = static::readSettingsFromFile();
        }
        return static::$config;
    }

    /**
     * Read settings from settings file.
     *
     * @return array
     * @throws \Exception
     */
    protected static function readSettingsFromFile()
    {
        if (!file_exists(static::CONFIG_FILE_PATH)) {
            throw new \Exception("Configuration file not found. Expected: ".static::CONFIG_FILE_PATH);
        }

        $fileContent = file_get_contents(static::CONFIG_FILE_PATH);
        $result = Yaml::parse($fileContent);

        return $result;
    }

}

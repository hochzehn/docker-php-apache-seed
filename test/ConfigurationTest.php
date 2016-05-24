<?php

namespace Application;

use PHPUnit_Framework_TestCase;

/**
 * Test the configuration. It should load a configuration file and return its values.
 *
 * @see Configuration
 */
class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Reset after each test. Static attributes, yay!
     */
    protected function tearDown()
    {
        Configuration::setSettings(null);
    }

    /**
     * It retrieves a value from a configuration.
     *
     * @test
     *
     * @return void
     */
    public function itGetsAValueFromAGivenConfiguration()
    {
        Configuration::setSettings(array('foo' => array ( 'bar' => 42)));
        $this->assertEquals(
            42,
            Configuration::get('foo/bar')
        );
    }

    /**
     * It throws an exception for unknown configuration keys.
     *
     * @test
     *
     * @return void
     */
    public function itThrowsAnExceptionForUnknownKey()
    {
        Configuration::setSettings(array('foo' => 42));
        $this->setExpectedException('Exception', 'Configuration error: Key bar not found.');

        Configuration::get('bar');
    }

}

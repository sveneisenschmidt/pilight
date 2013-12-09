<?php
/**
 * This file is part of the Pilight php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Pilight\Tests;

/**
 *
 * @package SE\Component\Pilight\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class DeviceTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function SimpleConstruction()
    {
        $protocol = sha1(uniqid());
        $device = new \SE\Component\Pilight\Device($protocol);

        $this->assertEquals($protocol, $device->getProtocol());
    }

    /**
     *
     * @test
     */
    public function FullConstruction()
    {
        $protocol = sha1(uniqid());
        $arguments = array(
            'a' => sha1(uniqid()),
            'b' => sha1(uniqid()),
            'c' => sha1(uniqid()),
            'd'
        );
        $device = new \SE\Component\Pilight\Device($protocol, $arguments);

        $this->assertEquals($protocol, $device->getProtocol());
        $this->assertNotEquals($arguments, $device->getArguments());

        $arguments[0] = 'd';
        $this->assertNotEquals($arguments, $device->getArguments());
    }
}
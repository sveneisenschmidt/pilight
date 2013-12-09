<?php
/**
 * This file is part of the Pilight php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Pilight;

/**
 *
 * @package SE\Component\Pilight
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class Device
{
    /**
     *
     * @var string
     */
    protected $protocol;

    /**
     *
     * @var array
     */
    protected $arguments = array();

    /**
     *
     *
     * @param string $protocol
     * @param array $arguments
     */
    public function __construct($protocol, array $arguments = array())
    {
        $this->setProtocol($protocol);
        $this->setArguments($arguments);
    }

    /**
     *
     * @param string $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     *
     * @param array $arguments
     */
    public function setArguments(array $arguments)
    {
        foreach($arguments as $argument => $value) {
            if(is_numeric($argument) === true) {
                $argument = $value;
                $value = null;
            }
            $this->addArgument($argument, $value);
        }
    }

    /**
     *
     * @param string $argument
     * @param string $value
     */
    public function addArgument($argument, $value = null)
    {
        $this->arguments[$argument] = $value;
    }

    /**
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }
}

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

use \SE\Component\Pilight\Device;
use \Symfony\Component\Process\Process;

/**
 *
 * @package SE\Component\Pilight
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class Sender
{
    const DEFAULT_EXEC = 'pilight-send';
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT = 5000;
    const DEFAULT_SUDO = false;

    /**
     *
     * @var string
     */
    protected $host = self::DEFAULT_HOST;

    /**
     *
     * @var integer
     */
    protected $port = self::DEFAULT_PORT;

    /**
     *
     * @var string
     */
    protected $exec = self::DEFAULT_EXEC;

    /**
     *
     * @var string
     */
    protected $delay = 2;

    /**
     *
     * @var boolean
     */
    protected $sudo = self::DEFAULT_SUDO;

    /**
     *
     * @param string $host
     * @param int $port
     */
    public function __construct($host = self::DEFAULT_HOST, $port = self::DEFAULT_PORT)
    {
        $this->setHost($host);
        $this->setPort($port);
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param integer $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param boolean $sudo
     */
    public function setSudo($sudo)
    {
        $this->sudo = (bool)$sudo;
    }

    /**
     * @return boolean
     */
    public function getSudo()
    {
        return $this->sudo;
    }



    /**
     *
     * @param string $exec
     */
    public function setExec($exec)
    {
        $this->exec = $exec;
    }

    /**
     *
     * @return string
     */
    public function getExec()
    {
        return $this->exec;
    }

    /**
     *
     * @return array
     */
    public function getServerArguments()
    {
        return array(
            'S' => $this->host,
            'P' => $this->port,
        );
    }

    /**
     *
     * @param \SE\Component\Pilight\Device $device
     * @param integer $idleTimeout
     * @throws \RuntimeException
     * @return \Symfony\Component\Process\Process
     */
    public function send(Device $device, $idleTimeout = 10)
    {
        $arguments = array_merge(
            $this->getServerArguments(),
            array('p' => $device->getProtocol()),
            $device->getArguments()
        );

        $stack  = array();
        foreach($arguments as $switch => $value) {
            if(is_null($value) === true) {
                $stack []= sprintf('-%s', $switch);
            } else {
                $stack []= sprintf('-%s=%s', $switch, $value);
            }
        }

        $command = sprintf('%s %s %s && sleep %s',
            $this->getSudo() ? 'sudo' : '',
            $this->getExec(),
            implode(' ', $stack),
        $this->delay);

        $process = new Process($command);
        $process->setIdleTimeout($idleTimeout);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process;
    }
}
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
class SenderTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function SimpleConstruction()
    {
        $sender = new \SE\Component\Pilight\Sender();
        $this->assertEquals($sender->getExec(), \SE\Component\Pilight\Sender::DEFAULT_EXEC);
        $this->assertEquals($sender->getHost(), \SE\Component\Pilight\Sender::DEFAULT_HOST);
        $this->assertEquals($sender->getPort(), \SE\Component\Pilight\Sender::DEFAULT_PORT);
        $this->assertEquals($sender->getSudo(), \SE\Component\Pilight\Sender::DEFAULT_SUDO);

        $exec = sha1(uniqid());
        $sender->setExec($exec);
        $this->assertEquals($exec, $sender->getExec());
    }

    /**
     *
     * @test
     */
    public function FullConstruction()
    {
        $sender = new \SE\Component\Pilight\Sender($host = '192.168.0.1', $port = rand(9000, 9999));

        $this->assertEquals($sender->getHost(), $host);
        $this->assertEquals($sender->getPort(), $port);

        $this->assertEquals(array('S' => $host, 'P' => $port), $sender->getServerArguments());
    }

    /**
     *
     * @test
     * @expectedException \Symfony\Component\Process\Exception\ProcessTimedOutException
     */
    public function Send()
    {
        $fixture = sprintf('sh %s/Fixtures/pilight-send.sh', __DIR__);

        $sender = new \SE\Component\Pilight\Sender($host = '192.168.1.1', $port = rand(9000, 9999));
        $sender->setExec($fixture);

        $device = new \SE\Component\Pilight\Device($protocol = sha1(uniqid()));
        $device->setArguments(array('a' => $a = rand(1,5), 'b' => $b = rand(1,5), 'c'));

        $process = $sender->send($device);
        $this->assertEquals(sprintf("-S=%s -P=%s -p=%s -a=%s -b=%s -c\n", $host, $port, $protocol, $a, $b), $process->getOutput());

        $sender->setSudo(true);
        $process = $sender->send($device, 1);
        $this->assertRegExp(sprintf('/sudo %s/', $fixture), $process->getCommandLine());
    }
}
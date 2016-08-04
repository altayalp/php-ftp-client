<?php
namespace altayalp\FtpClient\Tests;

/**
 * Test of Server Exceptions
 *
 * @package FtpClient
 * @subpackage Tests
 * @author altayalp <altayalp@gmail.com>
 */
class ServerExceptionTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * @expectedException \altayalp\FtpClient\Exceptions\ConnectionFailedException
     */
    public function testConnectException() {
        @$server = new \altayalp\FtpClient\Servers\SftpServer('xx.xx.com');
    }
    
}

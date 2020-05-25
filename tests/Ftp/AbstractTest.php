<?php
namespace altayalp\FtpClient\Tests;

use \altayalp\FtpClient\Servers\FtpServer;

/**
 * Abstract class for test
 *
 * @package FtpClient
 * @subpackage Tests
 * @author altayalp <altayalp@gmail.com>
 */

abstract class AbstractTest extends \PHPUnit_Framework_TestCase {
    
    protected static $session;


    public static function setUpBeforeClass()
    {
        $server = new FtpServer( getenv('FTP_HOST') );
        $server->login(getenv('FTP_USER'), getenv('FTP_PASS'));
        $server->enablePassive();
        self::$session = $server;
    }
    
    /**
     * @return Connection
     */
    protected static function getSession()
    {
        return self::$session;
    }
    
}

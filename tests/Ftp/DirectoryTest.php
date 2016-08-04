<?php
namespace altayalp\FtpClient\Tests;
use altayalp\FtpClient\Directories\FtpDirectory;

/**
 * Unittest of Directory class
 *
 * @package FtpClient
 * @subpackage Tests
 * @author altayalp <altayalp@gmail.com>
 */
class DirectoryTest extends AbstractTest {
    
    protected static $directory;
    
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$directory = new FtpDirectory(self::getSession());
    }
    
    public function testListItem()
    {
        $dirList = self::$directory->ls('.');
        $this->assertTrue(is_array($dirList));
    }
    
    public function testMkdir()
    {
        $mkdir = self::$directory->mkdir('ftp_test');
        $this->assertTrue($mkdir);
        $this->assertEquals('dir', self::$directory->isDirOrFile('ftp_test'));
    }
    
    public function testCd()
    {
        $cd = self::$directory->cd('ftp_test');
        $this->assertTrue($cd);
        $this->assertEquals('/ftp_test', self::$directory->pwd());
    }
    
    public function testPwd()
    {
        $this->assertEquals('/ftp_test', self::$directory->pwd());
    }
    
    public function testCdUp()
    {
        $cdUp = self::$directory->cdUp();
        $this->assertTrue($cdUp);
        $this->assertEquals('/', self::$directory->pwd());
    }
    
    public function testRm()
    {
        $rmTestDir = self::$directory->rm('ftp_test');
        $this->assertTrue($rmTestDir);
    }
    
}

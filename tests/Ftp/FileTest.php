<?php
namespace altayalp\FtpClient\Tests;

use altayalp\FtpClient\Files\FtpFile;

/**
 * Unittest of File
 *
 * @package FtpClient
 * @subpackage Tests
 * @author altayalp <altayalp@gmail.com>
 */
class FileTest extends AbstractTest {

    protected static $file;

    
    
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$file = new FtpFile(self::getSession());
    }

    public function testListItem()
    {
        $fileList = self::$file->ls('.');
        $this->assertTrue(is_array($fileList));
    }
    
    public function testUpload()
    {
        $this->assertFileExists('tests/file/test.txt');
        $upload = self::$file->upload('tests/file/test.txt','test.txt');
        $this->assertTrue($upload);
    }

    public function testDownload()
    {
        $download = self::$file->download('test.txt', 'tests/file/test_download.txt');
        $this->assertTrue($download);
        $this->assertFileExists('tests/file/test_download.txt');
    }    

    public function testRename()
    {
        $rename = self::$file->rename('test.txt', 'test_newname.txt');
        $this->assertTrue($rename);
    }
    
    public function testChmod()
    {
        $chmod = self::$file->chmod(0777, 'test_newname.txt');
        $this->assertTrue($chmod);
    }

    public function testGetLastMod()
    {
        $lastMod = self::$file->getLastMod('test_newname.txt');
        $this->assertTrue(is_int($lastMod));
    }
    
    public function testRm()
    {
        $rm = self::$file->rm('test_newname.txt');
        $this->assertTrue($rm);
    }

}

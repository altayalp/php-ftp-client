<?php
namespace altayalp\FtpClient\Tests;

use altayalp\FtpClient\Files\SftpFile;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Tests of File Exceptions
 *
 * @package FtpClient
 * @subpackage Tests
 * @author altayalp <altayalp@gmail.com>
 */
class FileExceptionTest extends AbstractTest
{
    
    protected static $file;
    
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$file = new SftpFile(self::getSession());
    }
    
    /**
     * @expectedException \altayalp\FtpClient\Exceptions\FileException
     */
    public function testUpload()
    {
        @self::$file->upload('noFile.file','');
    }
    
    /**
     * @expectedException \altayalp\FtpClient\Exceptions\FileException
     */
    public function testRm()
    {
        @self::$file->rm('noFile.file');
    }
    
}

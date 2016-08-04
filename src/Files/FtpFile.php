<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Files;

use altayalp\FtpClient\Interfaces\FileInterface;
use altayalp\FtpClient\Abstracts\AbstractFtp;
use altayalp\FtpClient\Interfaces\ServerInterface;
use altayalp\FtpClient\Exceptions\FileException;

/**
 * File class for ftp file process
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Files
 * @link https://github.com/altayalp/php-ftpclient
 */
class FtpFile extends AbstractFtp implements FileInterface
{
    
    /**
     * Constructor method
     * 
     * @param object $server instance of ServerInterface
     */
    public function __construct(ServerInterface $server)
    {
        $this->session = $server->getSession();
    }
    
    /**
     * {@inheritDoc}
     * @throws FileException
     */
    public function ls($dir = '.', $recursive = false, $ignore = array())
    {
        return $this->listItem('file', $dir, $recursive, $ignore);
    }
    
    /**
     * {@inheritDoc}
     */
    public function download($remote, $local, $mode = FTP_BINARY)
    {
        if (! ftp_get($this->session, $local, $remote, $mode)) {
            throw new FileException('File not downloaded');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     */
    public function upload($local, $remote, $mode = FTP_BINARY)
    {
        if (! ftp_put($this->session, $remote, $local, $mode)) {
            throw new FileException('File don\'t uploaded');
        }
        return true;
    }
    
    /**
     * Upload file to ftp server from http address
     * 
     * @link http://php.net/ftp_fput Php manuel
     * @access public
     * @param string $httpFile http file name with address
     * @param string $remote file name to upload ftp server
     * @param string $mode Upload mode FTP_BINARY or FTP_ASCII
     * @return boolean true if success
     * @throws FileException|RuntimeException
     */
    public function wget($httpFile, $remote, $mode = FTP_BINARY)
    {
        if (! ini_get('allow_url_fopen')) {
            throw new \RuntimeException('allow_url_fopen must enabled');
        }
        if (! $handle = fopen($httpFile)) {
            throw new \RuntimeException('File can not opened');
        }
        if (! ftp_fput($this->session, $remote, $handle, $mode) ) {
            throw new FileException('File not uploaded to ftp server');
        }
        fclose($handle);
        return true;
    }
    
    /**
     * {@inheritDoc}
     * @throws FileException
     */
    public function rm($file)
    {
        if (! ftp_delete($this->session, $file)) {
            throw new FileException('File not deleted');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getLastMod($file)
    {
        return ftp_mdtm($this->session, $file);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSize($file)
    {
        return ftp_size($this->session, $file);
    }
    
}

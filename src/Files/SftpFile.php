<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Files;

use altayalp\FtpClient\Interfaces\FileInterface;
use altayalp\FtpClient\Abstracts\AbstractSftp;
use altayalp\FtpClient\Interfaces\ServerInterface;
use altayalp\FtpClient\Exceptions\FileException;

/**
 * File class for ssh file process
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Files
 */
class SftpFile extends AbstractSftp implements FileInterface
{
    
    /**
     * Constructor method
     * 
     * @param object $server instance of ServerInterface
     */
    public function __construct(ServerInterface $server)
    {
        $this->session = $server->getSession();
        $this->sFtp();
    }
    
    /**
     * {@inheritDoc}
     * @throws FileException
     */
    public function ls($dir = '/.', $recursive = false, $ignore = array())
    {
        return $this->listItem('file', $dir, $recursive, $ignore);
    }
    
    /**
     * {@inheritDoc}
     */
    public function download($remote, $local)
    {
        $parseFile = $this->parseLastDirectory($remote);
        if (! ssh2_scp_recv($this->session, $parseFile, $local)) {
            throw new FileException('File can not downloaded');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     */
    public function upload($local, $remote)
    {
        $parseFile = $this->parseLastDirectory($remote);
        if (! ssh2_scp_send($this->session, $local, $parseFile)) {
            throw new FileException('File can not uploaded');
        }
        return true;
    }
    
    /**
     * Upload file to ssh server from http address
     * 
     * @access public
     * @param string $httpFile http file name with address
     * @param string $remote file name to upload ssh server
     * @return boolean true if success
     * @throws FileException|RuntimeException
     */
    public function wget($httpFile, $remote)
    {
        if (! ini_get('allow_url_fopen')) {
            throw new \RuntimeException('allow_url_fopen must enabled');
        }
        if (! $fileData = file_get_contents($httpFile)) {
            throw new \RuntimeException('Can nat get file content');
        }
        $parseFile = $this->parseLastDirectory($remote);
        if (! file_put_contents($this->getWrapper("/$parseFile"), $fileData)) {
            throw new FileException('File not uploaded to ftp server');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     * @throws FileException
     */
    public function rm($file)
    {
        $parseFile = $this->parseLastDirectory($file);
        if (! ssh2_sftp_unlink($this->getSFtp(), $parseFile)) {
            throw new FileException('File can not deleted');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getLastMod($file)
    {
        $parseFile = $this->parseLastDirectory($file);
        return filemtime($this->getWrapper("/$parseFile"));
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSize($file)
    {
        $parseFile = $this->parseLastDirectory($file);
        return filesize($this->getWrapper("/$parseFile"));
    }
    
}

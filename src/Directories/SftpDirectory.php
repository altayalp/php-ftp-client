<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Directories;

use altayalp\FtpClient\Interfaces\DirectoryInterface;
use altayalp\FtpClient\Abstracts\AbstractSftp;
use altayalp\FtpClient\Interfaces\ServerInterface;
use altayalp\FtpClient\Exceptions\DirectoryException;

/**
 * Directory class for Sftp server
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Directories
 */
class SftpDirectory extends AbstractSftp implements DirectoryInterface
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
     * @throws DirectoryException
     */
    public function ls($dir = null, $recursive = false, $ignore = array())
    {
        return $this->listItem('dir', $dir, $recursive, $ignore);
    }
    
    /**
     * Remove a directory
     * 
     * @link http://php.net/ssh2_sftp_rmdir Php manuel
     * @access public
     * @param string $dir dir name to remove ssh server
     * @return boolean true if success
     * @throws DirectoryException
     */
    public function rm($dir)
    {
        $parseDir = $this->parseLastDirectory($dir);
        if (! ssh2_sftp_rmdir($this->getSFtp(), $parseDir)) {
            throw new DirectoryException('Directory not deleted');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     */
    public function cd($dir)
    {
        $this->setLastDirectory($dir);
        return $dir;
    }
    
    /**
     * {@inheritDoc}
     */
    public function mkdir($dir)
    {
        $parseDir = $this->parseLastDirectory($dir);
        if (! ssh2_sftp_mkdir($this->getSFtp(), $parseDir)) {
            throw new DirectoryException('Directory can not be created');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     */
    public function pwd()
    {
        return $this->getLastDirectory();
    }
    
}

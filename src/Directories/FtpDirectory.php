<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Directories;

use altayalp\FtpClient\Interfaces\DirectoryInterface;
use altayalp\FtpClient\Abstracts\AbstractFtp;
use altayalp\FtpClient\Interfaces\ServerInterface;
use altayalp\FtpClient\Exceptions\DirectoryException;

/**
 * Directory class for ftp directory process
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @link https://github.com/altayalp/php-ftpclient
 */
class FtpDirectory extends AbstractFtp implements DirectoryInterface
{
    
    /**
     * Constructor method
     * 
     * @param resource $server instance of ServerInterface
     */
    public function __construct(ServerInterface $server)
    {
        $this->session = $server->getSession();
    }

    /**
     * {@inheritDoc}
     * @throws DirectoryException
     */
    public function ls($dir = '.', $recursive = false, $ignore = array())
    {
        return $this->listItem('dir', $dir, $recursive, $ignore);
    }
    
    /**
     * Remove a directory and files
     * 
     * @link http://php.net/ftp_rmdir Php manuel
     * @access public
     * @param string $dir dir name to remove ftp server
     * @return boolean true if success
     * @throws DirectoryException
     */
    public function rm($dir)
    {
        if (! ftp_rmdir($this->session, $dir)) {
            throw new DirectoryException('Directory not deleted');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     */
    public function cd($dir)
    {
        if (! ftp_chdir($this->session, $dir)) {
            throw new DirectoryException('Work directory can not be change');
        }
        return true;
    }
    
    /**
     * Changes to the parent directory
     * 
     * @link http://php.net/ftp_cdup Php manuel address
     * @return boolean true if success
     * @throws DirectoryException
     */
    public function cdUp()
    {
        if (! ftp_cdup($this->session)) {
            throw new DirectoryException('The parent directory can not changes');
        }
        return true;
    }


    /**
     * {@inheritDoc}
     */
    public function mkdir($dir)
    {
        if (! ftp_mkdir($this->session, $dir)) {
            throw new DirectoryException('Directory can not be created');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     * @throws DirectoryException
     */
    public function pwd()
    {
        if (! $workDir = ftp_pwd($this->session)) {
            throw new DirectoryException('Can not get current directory');
        }
        return $workDir;
    }
    
}

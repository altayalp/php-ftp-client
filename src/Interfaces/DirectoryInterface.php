<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Interfaces;

/**
 * Interface for Directory Class
 * 
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Interfaces
 */
interface DirectoryInterface extends FileDirectoryInterface
{
    
    /**
     * Change working directory to server
     * 
     * @access public
     * @param string $dir directory name to switch
     * @return boolean true if success
     * @throws DirectoryException
     */
    public function cd($dir);
    
    /**
     * Make new directory to ftp server
     * 
     * @access public
     * @param string $dir directory name to create
     * @return boolean true if success
     * @throws DirectoryException
     */
    public function mkdir($dir);
    
    /**
     * Get current working directory
     * 
     * @access public
     * @return string current working directory
     */
    public function pwd();

}

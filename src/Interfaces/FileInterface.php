<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Interfaces;

/**
 * Dosya ve klasör işlemleri için interface
 * 
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Interfaces
 */
interface FileInterface extends FileDirectoryInterface
{
    
    /**
     * Download file from server
     * 
     * @access public
     * @param string $remote remote file name
     * @param string $local new file name to save local disc
     * @return boolean return true if success
     * @throws FileException
     */
    public function download($remote, $local);
    
    /**
     * Upload file to server from local disc
     * 
     * @access public
     * @param string $local local file name
     * @param string $remote file name to upload ftp server
     * @return boolean true if success
     * @throws FileException
     */
    public function upload($local, $remote);
        
    /**
     * Get the file last modified time to file
     * 
     * @access public
     * @param string $file name of file to server
     * @return integer last modified time of file to Unix timestamp
     */
    public function getLastMod($file);
    
    /**
     * Get file size
     * 
     * @access public
     * @param string $file name of file to server
     * @return int file size
     */
    public function getSize($file);
    
}

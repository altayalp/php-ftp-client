<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file.
 */

namespace altayalp\FtpClient\Interfaces;

/**
 * Parent interface for file and directory interface
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Interfaces
 */
interface FileDirectoryInterface
{
    
    /**
     * List items
     * 
     * @access public
     * @param string $dir directory name
     * @param boolean $recursive Recursive directory (true or false)
     * @param array $ignore Ignored directory name or file extension
     * @return array item list
     */
    public function ls($dir, $recursive, $ignore);
    
    /**
     * Remove item from server
     * 
     * @access public
     * @param string $item item name to remove server
     * @return boolean Return true if success
     */
    public function rm($item);
    
    /**
     * Rename file or directory to server
     * 
     * @access public
     * @param string $oldName file or directory name to change new name
     * @param string $newName new file or directory name
     * @return boolean true if success
     */
    public function rename($oldName, $newName);
    
    /**
     * Set chmod to file or directory
     * 
     * @access public
     * @param int $permission chmod settings
     * @param string $item item name
     * @return boolean if success
     */
    public function chmod($permission, $item);
    
}

<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Abstracts;

use altayalp\FtpClient\FtpTrait;

/**
 * Abstract class for File and Directory classes common methods
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Abstracts
 */
abstract class AbstractFtp
{
    
    use FtpTrait;
    
    /**
     * Ftp connection session (instance of Server)
     * 
     * @access protected
     * @var resource
     */
    protected $session;
    
    /**
     * {@inheritDoc}
     * @throws RuntimeException
     */
    public function rename($oldName, $newName)
    {
        if (! ftp_rename($this->session, $oldName, $newName)) {
            throw new \RuntimeException('Name can not be changed');
        }
        return true;
    }
    
     /**
     * {@inheritDoc}
     * @throws RuntimeException
     */
    public function chmod($permission,$file)
    {
        if (! ftp_chmod($this->session, $permission, $file)) {
            throw new \RuntimeException('Chmod can not be changed');
        }
        return true;
    }
    
    /**
     * $name file or directory, its public for unittest
     * 
     * @access public
     * @param string $name name of file or directory
     * @return strıng if is dir return dir else return file
     */
    public function isDirOrFile($name)
    {
        if (ftp_size($this->session, $name) < 0) {
            return 'dir';
        } else {
            return 'file';
        }
    }
    
    /**
     * Returns a list of files in the given directory
     * 
     * @link http://php.net/ftp_nlist
     * @param string $dir The directory to be listed
     * @throws RuntimeException
     * @return array File list
     */
    private function nList($dir)
    {
        $dirList = ftp_nlist($this->session, $dir);
        if ($dirList === false) {
            throw new \RuntimeException('List error');
        }
        return $dirList;
    }
    
    /**
     * List of file or directory
     * 
     * @link http://php.net/ftp_nlist Php manuel
     * @access public
     * @param string $dir ftp directory name
     * @return array file list
     * @throws FileException
     */
    public function listItem($type, $dir = '.', $recursive = false, $ignore = array())
    {
        if ($type != 'dir' && $type != 'file') {
            throw new \InvalidArgumentException('$type must "file" or "dir"');
        }
        $fileList = $this->nList($dir);
        $fileInfo = array();
        foreach ($fileList as $file) {
            // remove directory and subdirectory name
            $file = str_replace("$dir/", '', $file);
            if ($this->ignoreItem($type, $file, $ignore) !== true && $this->isDirOrFile("$dir/$file") == $type) {
                $fileInfo[] = $file;
            }
            if ($recursive === true && $this->isDirOrFile("$dir/$file") == 'dir') {
                $fileInfo = array_merge($fileInfo, $this->listItem($type, "$dir/$file", $recursive, $ignore));
            }
        }
        return $fileInfo;
    }
    
}

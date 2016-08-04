<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file.
 */

namespace altayalp\FtpClient\Abstracts;

use altayalp\FtpClient\FtpTrait;

/**
 * Abstract class for SftpFile and SftpDirectory classes common methods
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Abstracts
 */
abstract class AbstractSftp
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
     * Sftp resource
     * 
     * @access protected
     * @var resource
     */
    private $sFtp;
    
    /**
     * Working last directory
     * 
     * @access private
     * @var string
     */
    private static $lastDirectory;
    
    /**
     * Get $lastDirectory
     * 
     * @return string $lastDirectory
     */
    protected function getLastDirectory()
    {
        return self::$lastDirectory;
    }
    
    /**
     * Set $lastDirectory
     */
    protected function setLastDirectory($dir)
    {
        self::$lastDirectory = $dir;
    }

    /**
     * Initialize SFTP subsystem
     * 
     * @link http://php.net/ssh2_sftp Php manuel
     * @access protected
     * @throws RuntimeException
     */
    protected function sFtp()
    {
        if (! $this->sFtp = ssh2_sftp($this->session)) {
            throw new \RuntimeException('Can not initialize SFTP');
        }
    }
    
    /**
     * Get ssh2:// wrapper
     * 
     * @link http://php.net/wrappers_ssh2 Php manuel
     * @access protected
     * @param string $file Remote file name
     * @return string url with sftp wrapper
     */
    protected function getWrapper($file)
    {
        return sprintf('ssh2.sftp://%s%s', $this->sFtp, $file);
    }
    
    /**
     * Parse $lastDirectory
     * 
     * @access protected
     * @param string $dir Directory name
     * @return string Parse dir name
     */
    protected function parseLastDirectory($dir)
    {
        if (substr($dir,0,1) == '/') {
            return $dir;
        } else {
            return self::$lastDirectory . "/$dir";
        }
    }
    
    /**
     * Get sFtp
     * 
     * @access protected
     * @return resource sFtp source
     */
    protected function getSFtp()
    {
        return $this->sFtp;
    }

    /**
     * {@inheritDoc}
     * @throws RuntimeException
     */
    public function rename($oldName, $newName)
    {
        if (! ssh2_sftp_rename($this->sFtp, $oldName, $newName)) {
            throw new \RuntimeException('Name can not be changed');
        }
        return true;
    }
    
    /**
     * {@inheritDoc}
     * @throws RuntimeException
     */
    public function chmod($file, $permission)
    {
        if (! ssh2_sftp_chmod($this->sFtp, $file, $permission)) {
            throw new \RuntimeException('Chmod can not be changed');
        }
        return true;
    }
    
    /**
     * List of file
     * 
     * @link http://php.net/scandir Php manuel
     * @access public
     * @param string $dir ssh directory name
     * @return array file list
     * @throws FileException
     */
    protected function listItem($type, $dir = '/.', $recursive = false, $ignore = array())
    {
        if ($type == 'dir') {
            $bool = true;
        } elseif ($type == 'file') {
            $bool = false;
        } else {
            throw new \InvalidArgumentException('$type must "file" or "dir"');
        }
        
        $parseDir = $this->parseLastDirectory($dir);
        $sDir = $this->getWrapper($parseDir);
        $fileList = array_diff(scandir($sDir), array('..', '.'));
        
        $fileInfo = array();
        foreach ($fileList as $file) {
            if ($this->ignoreItem($type, $file, $ignore) !== true && is_dir("$sDir/$file") === $bool) {
                $fileInfo[] = $file;
            }
            if ($recursive === true && is_dir("$sDir/$file") === true) {
                $fileInfo = array_merge($fileInfo, $this->listItem($type, "$dir/$file", $recursive, $ignore));
            }
        }
        
        return $fileInfo;
    }
    
}

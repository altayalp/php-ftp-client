<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file.
 */

namespace altayalp\FtpClient\Helper;

/**
 * Helper class for the library
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 */
class Helper
{
    
    /**
     * Format file size to human readable
     * 
     * @access public
     * @param int $byte byte of file size
     * @return strıng formatted file size
     */    
    public static function formatByte($byte)
    {
        // ignore "Warning: Division by zero"
        if ($byte == 0) {
            return '0 B';
        }
        $s = array('B', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        $e = floor(log($byte)/log(1024));
        return sprintf('%.2f '.$s[$e], ($byte/pow(1024, floor($e))));
    }
    
    /**
     * Format unix time
     * 
     * @access public
     * @param int $date unix time
     * @return string Formatted date
     */
    public static function formatDate($date, $format = 'd.m.Y H:i')
    {
        return date($format, $date);
    }

    /**
     * Get file extension
     * 
     * @access public
     * @param type $file name of file
     * @return string file extension without dot
     */
    public static function getFileExtension($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }
    
    /*
     * if exist local file, rename file
     * demo.html renamed to demo_dae4c9057b2ea5c3c9e96e8352ac28f0c7d87f7d.html
     * 
     * @access public
     * @param string $name file name
     * @return new file name
     */
    public static function newName($name)
    {
        if (file_exists($name)) {
            $extension = self::getFileExtension($name);
            $name = substr($name,0,(-strlen($extension)-1)) . '_' . sha1(uniqid(rand(), true)) . ".$extension";
        }
        return $name;
    }
}

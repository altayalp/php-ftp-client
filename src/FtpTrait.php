<?php

/* 
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file.
 */

namespace altayalp\FtpClient;

/**
 * Trait for the library
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 */
trait FtpTrait
{
    /**
     * Ignore item to itemList
     * 
     * @access private
     * @param string $type Type of item
     * @param string $name Name of item
     * @param array $ignore Names or extension item for ignore
     * @return boolean
     */
    private function ignoreItem($type, $name, $ignore)
    {
        if ($type == 'file' && in_array(pathinfo($name, PATHINFO_EXTENSION), $ignore)) {
            return true;
        } elseif ($type == 'dir' && in_array($name, $ignore)) {
            return true;
        }
        return false;
    }
}

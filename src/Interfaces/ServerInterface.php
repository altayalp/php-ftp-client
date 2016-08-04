<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Interfaces;

/**
 * Interface for Server Class
 * 
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Interfaces
 */
interface ServerInterface
{
    
    /**
     * Connect to server
     * 
     * @access public
     * @throws ConnectionFailedException
     */
    public function connect();
    
    /**
     * Log in to server
     * 
     * @access public
     * @param string $userName user name
     * @param string $password password
     * @throws AuthenticationFailedException
     * 
     */
    public function login($userName, $password);
    
    /**
     * Get connection session
     * 
     * @access public
     * @return resurce Connection session
     */
    public function getSession();
    
}

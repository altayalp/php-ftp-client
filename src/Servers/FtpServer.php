<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Servers;

use altayalp\FtpClient\Interfaces\ServerInterface;
use altayalp\FtpClient\Exceptions\ExtensionMissingException;
use altayalp\FtpClient\Exceptions\ConnectionFailedException;
use altayalp\FtpClient\Exceptions\AuthenticationFailedException;

/**
 * Connect and log in to ftp server
 *
 * @package FtpClient
 * @subpackage Servers
 * @author altayalp <altayalp@gmail.com>
 * @link https://github.com/altayalp/php-ftpclient
 */
class FtpServer implements ServerInterface
{
    
    /**
     * Connect session
     * 
     * @access private
     * @var string
     */
    private $session;
    
    /**
     * Connect server addres
     * 
     * @access protected
     * @var string
     */
    protected $server;
    
    /**
     * Connect port
     * 
     * @access protected
     * @var boolean
     */
    protected $port;
    
    /**
     * Connection timeout
     * 
     * @access protected
     * @var integer
     */
    protected $timeout;

    /**
     * Constructor method
     * 
     * @param String $server connect server address
     * @param integer $port connect server port
     * @param integer $timeOut server time out
     * @throws ExtensionMissingException
     */
    public function __construct($server, $port = 21, $timeOut = 90)
    {
        if (! extension_loaded('ftp')) {
            throw new ExtensionMissingException('Ftp extension must be loaded');
        }
        $this->server = $server;
        $this->port = $port;
        $this->timeout = $timeOut;
        $this->connect();
    }
    
    public function __destruct()
    {
        if (is_resource($this->session) === true) {
            ftp_close($this->session);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function connect()
    {
        if (! $this->session = ftp_connect($this->server, $this->port, $this->timeout)) {
            throw new ConnectionFailedException('Could not connect to the server');
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function login($userName, $password)
    {
        if (! ftp_login($this->session, $userName, $password)) {
            throw new AuthenticationFailedException('Could not login server');
        }
    }
    
    /**
     * Turns passive mode on
     * 
     * @access public
     */
    public function turnPassive()
    {
        ftp_pasv($this->session, true);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSession()
    {
        return $this->session;
    }
    
    /**
     * Set sesion
     * 
     * @access protected
     * @param resource $session Connection session
     */
    protected function setSession($session)
    {
        $this->session = $session;
    }
    
}

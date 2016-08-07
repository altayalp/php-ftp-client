<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Servers;

use altayalp\FtpClient\Interfaces\ServerInterface;
use altayalp\FtpClient\Exceptions\ExtensionMissingException;
use altayalp\FtpClient\Exceptions\ConnectionFailedException;

/**
 * Connect and log in to ssh server
 *
 * @author altayalp
 */
class SftpServer implements ServerInterface
{
    
    /**
     * Connect session
     * 
     * @access private
     * @var resource
     */
    private $session;
    /**
     * Connect server addres
     * 
     * @access private
     * @var string
     */
    private $server;
    /**
     * Connect port
     * 
     * @access private
     * @var boolean
     */
    private $port;
    
    /**
     * Constructor method
     * 
     * @param String $server connect server address
     * @param integer $port connect server port
     * @throws ExtensionMissingException
     */
    public function __construct($server, $port = 22) {
        if (! extension_loaded('ssh2')) {
            throw new ExtensionMissingException('Ssh2 extension must be loaded');
        }
        if (version_compare(PHP_VERSION, '5.4.0') < 0) {
            throw new Exception('PHP 5.4+ required for the library');
        }
        $this->server = $server;
        $this->port = $port;
        $this->connect();
    }
    
    public function __destruct()
    {
        if (is_resource($this->session) === true) {
            unset($this->session);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function connect()
    {
        if (! $this->session = ssh2_connect($this->server, $this->port)) {
            throw new ConnectionFailedException('Could not connect to the server');
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function login($userName, $password)
    {
        if (! ssh2_auth_password($this->session, $userName, $password)) {
            throw new AuthenticationFailedException('Could not login server');
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSession()
    {
        return $this->session;
    }
    
}

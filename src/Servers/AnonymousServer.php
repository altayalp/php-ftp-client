<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file.
 */

namespace altayalp\FtpClient\Servers;

/**
 * Connect to anonymous server
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Servers
 */
class AnonymousServer extends FtpServer
{
    /**
     * Constructor method
     * 
     * @param String $server connect server address
     * @param integer $port connect server port
     * @param integer $timeOut server time out
     */
    public function __construct($server, $port = 21, $timeOut = 90)
    {
        parent::__construct($server, $port, $timeOut);
        $this->connect();
        $this->login('Anonymous', '');
    }
}

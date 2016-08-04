<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Servers;

use altayalp\FtpClient\Exceptions\ConnectionFailedException;

/**
 * Connect to ssl server
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Servers
 */
class SslServer extends FtpServer
{
    
    /**
     * {@inheritDoc}
     */
    public function connect()
    {
        if (! $session = ftp_ssl_connect($this->server, $this->port, $this->timeout)) {
            throw new ConnectionFailedException('Could not connect to the ssl server');
        }
        $this->setSession($session);
    }
    
}

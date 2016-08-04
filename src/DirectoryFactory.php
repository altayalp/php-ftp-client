<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient;

use altayalp\FtpClient\Interfaces\ServerInterface;
use altayalp\FtpClient\Interfaces\FactoryInterface;
use altayalp\FtpClient\Servers\FtpServer;
use altayalp\FtpClient\Servers\SftpServer;
use altayalp\FtpClient\Directories\FtpDirectory;
use altayalp\FtpClient\Directories\SftpDirectory;

/**
 * Factory for Directory classes
 *
 * @author altayalp
 */
class DirectoryFactory implements FactoryInterface
{
    
    /**
     * Build method for Directory classes
     */
    public static function build(ServerInterface $server)
    {
        if ($server instanceof SftpServer) {
            return new SftpDirectory($server);
        } elseif ($server instanceof FtpServer || $server instanceof SslServer) {
            return new FtpDirectory($server);
        } else {
            throw new \InvalidArgumentException('The argument is must instance of server class');
        }
    }
    
}

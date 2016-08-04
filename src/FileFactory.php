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
use altayalp\FtpClient\Files\FtpFile;
use altayalp\FtpClient\Files\SftpFile;

/**
 * Factory for File classes
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 */
class FileFactory implements FactoryInterface
{
    
    /**
     * Build method for File classes
     */
    public static function build(ServerInterface $server)
    {
        if ($server instanceof SftpServer) {
            return new SftpFile($server);
        } elseif ($server instanceof FtpServer || $server instanceof SslServer) {
            return new FtpFile($server);
        } else {
            throw new \InvalidArgumentException('The argument is must instance of server class');
        }
    }
    
}

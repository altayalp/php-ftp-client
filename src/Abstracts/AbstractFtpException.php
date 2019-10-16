<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Abstracts;

use altayalp\FtpClient\Interfaces\ExceptionInterface;

/**
 * Abstract class for FtpException
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Abstracts
 */
abstract class AbstractFtpException extends \Exception implements ExceptionInterface
{
    /**
     * Exception message
     * 
     * @access protected
     * @var string
     */
    protected $message = 'Unknown error';
    
    /**
     * Exception code
     * 
     * @access protected
     * @var int
     */
    protected $code = 0;
    
    /**
     * Source filename of exception
     * 
     * @access protected
     * @var string
     */
    protected $file;
    
    /**
     * Source line of exception
     * 
     * @access protected
     * @var int
     */
    protected $line;
    
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        if ($message === null) {
            $message = $this->message;
        }
        parent::__construct($message, $code, $previous);
    }
    
    public function __toString()
    {
        return get_class($this) .
            " '{$this->message}' in {$this->file} ({$this->line})\n" .
            "{$this->getTraceAsString()}";
    }
}

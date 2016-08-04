<?php

/*
 * The sofware is provided under Mit License.
 * For the full copyright and license information, please view the LICENSE file
 */

namespace altayalp\FtpClient\Interfaces;

/**
 * Interface for exceptions
 *
 * @author altayalp <altayalp@gmail.com>
 * @package FtpClient
 * @subpackage Interfaces
 */
interface ExceptionInterface
{
    /**
     * Exception message
     */
    public function getMessage();
    
    /**
     * User defined Exception code
     */
    public function getCode();
    
    /**
     * Source filename
     */
    public function getFile();
    
    /**
     * Source line
     */
    public function getLine();
    
    /**
     * An array of backtrace
     */
    public function getTrace();
    
    /**
     * Formated string of trace
     */
    public function getTraceAsString();
    
    /**
     * Formatted text to display exception message
     */
    public function __toString();
    
    /**
     * Constructer method
     */
    public function __construct($message, $code = 0, \Exception $previous = null);
}

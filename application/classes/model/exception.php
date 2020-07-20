<?php 

/**
 * Model层数据异常
 */
class Model_Exception extends Kohana_Exception
{
    const ERROR_CODE_UNKNOWN = -1;

    /**
     * Model_Exception constructor.
     * @param $message
     * @param int $code
     * @param null $variables
     */
    public function __construct($message, $code = self::ERROR_CODE_UNKNOWN, $variables = NULL)
    {
        parent::__construct($message, $variables, $code);
    }
}
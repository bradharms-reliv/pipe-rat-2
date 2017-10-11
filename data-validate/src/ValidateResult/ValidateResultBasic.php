<?php

namespace Reliv\PipeRat2\DataValidate\ValidateResult;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateResultBasic extends ValidateResultAbstract implements ValidateResult
{
    /**
     * @param bool   $valid
     * @param string $primaryMessage
     * @param null   $validData
     * @param array  $fieldMessages
     */
    public function __construct(
        bool $valid = true,
        string $primaryMessage = '',
        $validData = null,
        array $fieldMessages = []
    ) {
        parent::__construct(
            $valid,
            $primaryMessage,
            $validData,
            $fieldMessages
        );
    }
}

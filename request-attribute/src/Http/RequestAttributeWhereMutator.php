<?php

namespace Reliv\PipeRat2\RequestAttribute\Http;

use Reliv\PipeRat2\Core\Http\MiddlewareWithConfigKey;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RequestAttributeWhereMutator extends MiddlewareWithConfigKey
{
    const ATTRIBUTE = RequestAttributeWhere::ATTRIBUTE;
}
<?php

namespace Reliv\PipeRat2\RepositoryDoctrine\Config;

use Reliv\PipeRat2\Acl\Api\IsAllowedNotConfigured;
use Reliv\PipeRat2\Acl\Http\RequestAclMiddleware;
use Reliv\PipeRat2\Core\Config\RouteConfig;
use Reliv\PipeRat2\Core\Config\RouteConfigAbstract;
use Reliv\PipeRat2\DataExtractor\Api\ExtractCollectionPropertyGetter;
use Reliv\PipeRat2\DataExtractor\Api\ResponseDataExtractor;
use Reliv\PipeRat2\Repository\Http\RepositoryFind;
use Reliv\PipeRat2\RequestAttribute\Http\RequestAttributeUrlEncodedFiltersFields;
use Reliv\PipeRat2\RequestAttribute\Http\RequestAttributeUrlEncodedFiltersLimit;
use Reliv\PipeRat2\RequestAttribute\Http\RequestAttributeUrlEncodedFiltersOrder;
use Reliv\PipeRat2\RequestAttribute\Http\RequestAttributeUrlEncodedFiltersSkip;
use Reliv\PipeRat2\RequestAttribute\Http\RequestAttributeUrlEncodedFiltersWhere;
use Reliv\PipeRat2\RequestFormat\Http\RequestFormatJson;
use Reliv\PipeRat2\ResponseFormat\Http\ResponseFormatJson;
use Reliv\PipeRat2\ResponseHeaders\Http\ResponseHeadersAdd;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RouteConfigFind extends RouteConfigAbstract implements RouteConfig
{
    protected static function requiredParams(): array
    {
        $requiredParams = parent::requiredParams();
        $requiredParams[] = 'entity-class';

        return $requiredParams;
    }

    protected static function defaultConfig(): array
    {
        return [
            'name' => '[--{root-path}--].[--{resource-name}--].find',

            'path' => '[--{root-path}--]/[--{resource-name}--]',

            'middleware' => [
                RequestFormatJson::configKey()
                => RequestFormatJson::class,

                RequestAclMiddleware::configKey()
                => RequestAclMiddleware::class,

                RequestAttributeUrlEncodedFiltersWhere::configKey()
                => RequestAttributeUrlEncodedFiltersWhere::class,

                RequestAttributeUrlEncodedFiltersFields::configKey()
                => RequestAttributeUrlEncodedFiltersFields::class,

                RequestAttributeUrlEncodedFiltersOrder::configKey()
                => RequestAttributeUrlEncodedFiltersOrder::class,

                RequestAttributeUrlEncodedFiltersSkip::configKey()
                => RequestAttributeUrlEncodedFiltersSkip::class,

                RequestAttributeUrlEncodedFiltersLimit::configKey()
                => RequestAttributeUrlEncodedFiltersLimit::class,

                /** <response-mutators> */
                ResponseHeadersAdd::configKey()
                => ResponseHeadersAdd::class,

                ResponseFormatJson::configKey()
                => ResponseFormatJson::class,

                ResponseDataExtractor::configKey()
                => ResponseDataExtractor::class,
                /** </response-mutators> */

                RepositoryFind::configKey()
                => RepositoryFind::class,
            ],

            'options' => [
                RequestFormatJson::configKey() => [
                    RequestFormatJson::OPTION_VALID_CONTENT_TYPES => ['application/json'],
                ],

                RequestAclMiddleware::configKey() => [
                    RequestAclMiddleware::OPTION_SERVICE_NAME
                    => IsAllowedNotConfigured::class,

                    RequestAclMiddleware::OPTION_SERVICE_OPTIONS => [
                        IsAllowedNotConfigured::OPTION_MESSAGE
                        => IsAllowedNotConfigured::DEFAULT_MESSAGE
                            . ' for pipe-rat-2 resource: "[--{resource-name}--]"'
                            . ' in file: "[--{source-config-file}--]"',
                    ],
                ],

                RequestAttributeUrlEncodedFiltersWhere::configKey() => [
                    RequestAttributeUrlEncodedFiltersWhere::OPTION_ALLOW_DEEP_WHERES => false,
                ],

                RequestAttributeUrlEncodedFiltersFields::configKey() => [],

                RequestAttributeUrlEncodedFiltersOrder::configKey() => [],

                RequestAttributeUrlEncodedFiltersSkip::configKey() => [],

                RequestAttributeUrlEncodedFiltersLimit::configKey() => [],

                /** <response-mutators> */
                ResponseHeadersAdd::configKey() => [
                    ResponseHeadersAdd::OPTION_HEADERS
                    => [],
                ],

                ResponseFormatJson::configKey() => [
                    ResponseFormatJson::OPTION_JSON_ENCODING_OPTIONS => JSON_PRETTY_PRINT,
                ],

                ResponseDataExtractor::configKey() => [
                    ResponseDataExtractor::OPTION_SERVICE_NAME => ExtractCollectionPropertyGetter::class,
                    ResponseDataExtractor::OPTION_SERVICE_OPTIONS => [
                        ExtractCollectionPropertyGetter::OPTION_PROPERTY_LIST => null,
                        ExtractCollectionPropertyGetter::OPTION_PROPERTY_DEPTH_LIMIT => 1,
                    ],
                ],
                /** </response-mutators> */

                RepositoryFind::configKey() => [
                    RepositoryFind::OPTION_SERVICE_NAME
                    => \Reliv\PipeRat2\RepositoryDoctrine\Api\Find::class,

                    RepositoryFind::OPTION_SERVICE_OPTIONS => [
                        \Reliv\PipeRat2\RepositoryDoctrine\Api\Find::OPTION_ENTITY_CLASS_NAME
                        => '[--{entity-class}--]',
                    ],
                ],
            ],

            'allowed_methods' => ['GET'],
        ];
    }

    protected static function defaultPriorities(): array
    {
        return [
            RequestFormatJson::configKey() => 1100,
            RequestAclMiddleware::configKey() => 1000,
            RequestAttributeUrlEncodedFiltersWhere::configKey() => 900,
            RequestAttributeUrlEncodedFiltersFields::configKey() => 800,
            RequestAttributeUrlEncodedFiltersOrder::configKey() => 700,
            RequestAttributeUrlEncodedFiltersSkip::configKey() => 600,
            RequestAttributeUrlEncodedFiltersLimit::configKey() => 500,

            /** <response-mutators> */
            ResponseHeadersAdd::configKey() => 400,
            ResponseFormatJson::configKey() => 300,
            ResponseDataExtractor::configKey() => 200,
            /** </response-mutators> */

            RepositoryFind::configKey() => 100,
        ];
    }
}
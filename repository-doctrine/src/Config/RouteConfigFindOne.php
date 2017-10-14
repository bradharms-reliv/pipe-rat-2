<?php

namespace Reliv\PipeRat2\RepositoryDoctrine\Config;

use Reliv\PipeRat2\Acl\Api\IsAllowedNotConfigured;
use Reliv\PipeRat2\Acl\Http\RequestAcl;
use Reliv\PipeRat2\Core\Config\RouteConfig;
use Reliv\PipeRat2\Core\Config\RouteConfigAbstract;
use Reliv\PipeRat2\DataExtractor\Api\ExtractPropertyGetter;
use Reliv\PipeRat2\DataExtractor\Http\ResponseDataExtractor;
use Reliv\PipeRat2\Repository\Http\RepositoryFindOne;
use Reliv\PipeRat2\RepositoryDoctrine\Api\FindOne;
use Reliv\PipeRat2\RequestAttribute\Api\WithRequestAttributeFields;
use Reliv\PipeRat2\RequestAttribute\Api\WithRequestAttributeUrlEncodedFields;
use Reliv\PipeRat2\RequestAttribute\Api\WithRequestAttributeUrlEncodedWhere;
use Reliv\PipeRat2\RequestAttribute\Api\WithRequestAttributeWhere;
use Reliv\PipeRat2\RequestAttribute\Api\WithRequestAttributeWhereMutator;
use Reliv\PipeRat2\RequestAttribute\Api\WithRequestAttributeWhereMutatorNoop;
use Reliv\PipeRat2\RequestAttribute\Http\RequestAttributes;
use Reliv\PipeRat2\RequestFormat\Api\WithParsedBodyJson;
use Reliv\PipeRat2\RequestFormat\Http\RequestFormat;
use Reliv\PipeRat2\ResponseFormat\Api\WithFormattedResponseJson;
use Reliv\PipeRat2\ResponseFormat\Http\ResponseFormat;
use Reliv\PipeRat2\ResponseHeaders\Api\WithResponseHeadersAdded;
use Reliv\PipeRat2\ResponseHeaders\Http\ResponseHeaders;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RouteConfigFindOne extends RouteConfigAbstract implements RouteConfig
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
            'name' => '{pipe-rat-2-config.root-path}.{pipe-rat-2-config.resource-name}.findOne',

            'path' => '{pipe-rat-2-config.root-path}/{pipe-rat-2-config.resource-name}/findOne',

            'middleware' => [
                RequestFormat::configKey()
                => RequestFormat::class,

                RequestAcl::configKey()
                => RequestAcl::class,

                RequestAttributes::configKey()
                => RequestAttributes::class,

                /** <response-mutators> */
                ResponseHeaders::configKey()
                => ResponseHeaders::class,

                ResponseFormat::configKey()
                => ResponseFormat::class,

                ResponseDataExtractor::configKey()
                => ResponseDataExtractor::class,
                /** </response-mutators> */

                RepositoryFindOne::configKey()
                => RepositoryFindOne::class,
            ],

            'options' => [
                RequestFormat::configKey() => [
                    RequestFormat::OPTION_SERVICE_NAME
                    => WithParsedBodyJson::class,

                    RequestFormat::OPTION_SERVICE_OPTIONS => [],
                ],

                RequestAcl::configKey() => [
                    RequestAcl::OPTION_SERVICE_NAME
                    => IsAllowedNotConfigured::class,

                    RequestAcl::OPTION_SERVICE_OPTIONS => [
                        IsAllowedNotConfigured::OPTION_MESSAGE
                        => IsAllowedNotConfigured::DEFAULT_MESSAGE
                            . ' for pipe-rat-2 resource: "{pipe-rat-2-config.resource-name}"'
                            . ' in file: "{pipe-rat-2-config.source-config-file}"',
                    ],
                ],

                RequestAttributes::configKey() => [
                    RequestAttributes::OPTION_SERVICE_NAMES => [
                        WithRequestAttributeWhere::class
                        => WithRequestAttributeUrlEncodedWhere::class,

                        WithRequestAttributeWhereMutator::class
                        => WithRequestAttributeWhereMutatorNoop::class,

                        WithRequestAttributeFields::class
                        => WithRequestAttributeUrlEncodedFields::class,
                    ],

                    RequestAttributes::OPTION_SERVICE_NAMES_OPTIONS => [
                        WithRequestAttributeWhere::class => [
                            WithRequestAttributeUrlEncodedWhere::OPTION_ALLOW_DEEP_WHERES => false,
                        ]
                    ],
                ],

                /** <response-mutators> */
                ResponseHeaders::configKey() => [
                    ResponseHeaders::OPTION_SERVICE_NAME
                    => WithResponseHeadersAdded::class,

                    ResponseHeaders::OPTION_SERVICE_OPTIONS => [
                        WithResponseHeadersAdded::OPTION_HEADERS => []
                    ],
                ],

                ResponseFormat::configKey() => [
                    ResponseFormat::OPTION_SERVICE_NAME
                    => WithFormattedResponseJson::class,

                    ResponseFormat::OPTION_SERVICE_OPTIONS => [],
                ],

                ResponseDataExtractor::configKey() => [
                    ResponseDataExtractor::OPTION_SERVICE_NAME => ExtractPropertyGetter::class,
                    ResponseDataExtractor::OPTION_SERVICE_OPTIONS => [
                        ExtractPropertyGetter::OPTION_PROPERTY_LIST => null,
                        ExtractPropertyGetter::OPTION_PROPERTY_DEPTH_LIMIT => 1,
                    ],
                ],
                /** </response-mutators> */

                RepositoryFindOne::configKey() => [
                    RepositoryFindOne::OPTION_SERVICE_NAME
                    => FindOne::class,

                    RepositoryFindOne::OPTION_SERVICE_OPTIONS => [
                        FindOne::OPTION_ENTITY_CLASS_NAME
                        => '{pipe-rat-2-config.entity-class}',
                    ],
                ],
            ],

            'allowed_methods' => ['GET'],
        ];
    }

    protected static function defaultPriorities(): array
    {
        return [
            RequestFormat::configKey() => 700,
            RequestAcl::configKey() => 600,
            RequestAttributes::configKey() => 500,

            /** <response-mutators> */
            ResponseHeaders::configKey() => 400,
            ResponseFormat::configKey() => 300,
            ResponseDataExtractor::configKey() => 200,
            /** </response-mutators> */

            RepositoryFindOne::configKey() => 100,
        ];
    }
}

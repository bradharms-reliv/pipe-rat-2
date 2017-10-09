<?php

namespace Reliv\PipeRat2\DataValidate;

use Reliv\PipeRat2\Core\Api\GetOptions;
use Reliv\PipeRat2\Core\Api\GetServiceFromConfigOptions;
use Reliv\PipeRat2\Core\Api\GetServiceOptionsFromConfigOptions;
use Reliv\PipeRat2\DataValidate\Api\Validate;
use Reliv\PipeRat2\DataValidate\Api\ValidateZfInputFilter;
use Reliv\PipeRat2\DataValidate\Api\ValidateZfInputFilterFactory;
use Reliv\PipeRat2\DataValidate\Http\ValidateMiddleware;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    Validate::class => [
                        'class' => ValidateZfInputFilter::class,
                        'factory' => ValidateZfInputFilterFactory::class,
                    ],
                    ValidateZfInputFilter::class => [
                        'factory' => ValidateZfInputFilterFactory::class,
                    ],

                    ValidateMiddleware::class => [
                        'arguments' => [
                            GetOptions::class,
                            GetServiceFromConfigOptions::class,
                            GetServiceOptionsFromConfigOptions::class,
                            ['literal' => 400]
                        ],
                    ]
                ],
            ],
        ];
    }
}
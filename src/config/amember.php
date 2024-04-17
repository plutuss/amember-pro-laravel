<?php

use Plutuss\AMember\Response\Adapter\ArrayReportAdapter;
use Plutuss\AMember\Response\Adapter\CollectionReportAdapter;
use Plutuss\AMember\Response\Adapter\JsonReportAdapter;

return [


    'amember_url' => env('AMEMBER_URL', ''),
    'amember_api_key' => env('AMEMBER_API_KEY', ''),

    'type_response' => [

        /**
         * You can choose the format of your answer
         *
         * collection, array, json
         */
        'default' => env('AMEMBER_TYPE_RESPONSE', 'collection'),

        /**
         * You can change the response class by using ReportAdapterInterface in your class
         */
        'response_class' => [
            'collection' => CollectionReportAdapter::class,
            'array' => ArrayReportAdapter::class,
            'json' => JsonReportAdapter::class,
        ],

    ],

];

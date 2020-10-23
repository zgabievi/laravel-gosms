<?php

return [

    /**
     * This value decides to log or not to log requests.
     */
    'debug' => env('GOSMS_DEBUG', false),

    /**
     * This is the api key, which should be generated
     * by gosms.ge website.
     */
    'api_key' => env('GOSMS_API_KEY'),

    /**
     * This is the url provided by gosms.ge api docs.
     */
    'api_url' => env('GOSMS_API_URL', 'https://api.gosms.ge/api'),

    /**
     * This is the brand name which you have registered on gosms.ge.
     */
    'brand_name' => env('GOSMS_BRAND'),
];

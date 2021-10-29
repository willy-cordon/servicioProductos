<?php

return [

    'ml_oauth_token'=>[
        //authenticate and call new access_token
        'url'=>env('ML_OAUTH_URL')
    ],
    'callback_url_app'=>[
        'url'=>env('CALLBACK_URL_APP')
    ],
    'ml_product'=>[
        'create_product'=>env('CREATE_PRODUCT')
    ],
    'ml_search_items'=>[
        'search_items'=>env('SEARCH_ITEMS_BY_SELLER')
    ],
    'ml_categories'=>[
        'AR'=>env('ML_URL_CATEGORIES')
    ],
    'ml_update_product'=>[
        'getItem'=>env('ML_PRODUCT_URL'),
        'url'=>env('ML_UPDATE_PRODUCT_URL'),
        'urlDescription'=>env('ML_UPDATE_ITEM_DESCRIPTION'),
        'urlImg'=>env('ML_UPDATE_ITEM_PICTURES')
    ],
    'ml_attributes'=>[
        'gender'=>'BOOK_GENRE',
        'subgender'=>'SUBGENRES',
        'productFormat'=>'BOOK_COVER',
        'numberOfPages'=>'NUMBER_OF_PAGES',
        'publisher'=>'PUBLISHER',
        'author'=>'AUTHOR',
        'language'=>'LANGUAGE',
        'format'=>'FORMAT',
    ],
    'ml_list_types'=>[
        '1'=>'gold_pro',
        '2'=>'gold_premium',
        '3'=>'gold_special',
        '4'=>'gold',
        '5'=>'silver',
        '6'=>'bronze',
        '7'=>'free',
    ],
    'ml_url_orders'=>[
        'url_order'=>env('ML_URL_ORDER'),
        'url_orders_from_to' => env('ML_URL_ORDER_RANGE_DATE')
    ],
    'woo_url_orders'=>[
        'url'=>env('WOO_URL_ORDER'),
        'url_from_to'=>env('WOO_URL_ORDER_AFTER_BEFORE')
    ]
];




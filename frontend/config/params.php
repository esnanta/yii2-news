<?php
return [
    'bsVersion' => '5.x',
    //'bsDependencyEnabled' => false,// this will not load Bootstrap CSS and JS for all Krajee extensions
    'adminEmail' => 'ombakrinai@gmail.com',

    'meta_description'          => ['name' => 'description', 'content' => 'Your go-to source for affordable small business software solutions'],
    'meta_keywords'             => ['name' => 'keywords', 'content' => 'daraspace, software, tutorial, information technology'],
    'meta_author'               => ['name' => 'author', 'content' => 'daraspace'],

    'og_site_name'              => ['property' => 'og:site_name', 'content' => 'Daraspace'],
    'og_title'                  => ['property' => 'og:title', 'content' => 'Welcome to Daraspace'],
    'og_description'            => ['property' => 'og:description', 'content' => 'Discover beneficial content and resources.'],
    'og_type'                   => ['property' => 'og:type', 'content' => 'website'],
    'og_url'                    => ['property' => 'og:url', 'content' => 'https://www.daraspace.com/'],
    'og_image'                  => ['property' => 'og:image:secure_url', 'itemprop' => 'image', 'content' => 'https://www.daraspace.com/images/og-image.jpg'],
    'og_width'                  => ['property' => 'og:image:width', 'content' => '200'],
    'og_height'                 => ['property' => 'og:image:height', 'content' => '100'],
    'og_updated_time'           => ['property' => 'og:updated_time', 'content' => date('c', time())],

    'twitter_title'             => ['property' => 'twitter:title', 'content' => 'Welcome to Daraspace'],
    'twitter_description'       => ['property' => 'twitter:description', 'content' => 'Discover beneficial content and resources.'],
    'twitter_card'              => ['property' => 'twitter:card', 'content' => 'summary_large_image'],
    'twitter_url'               => ['property' => 'twitter:url', 'content' => 'https://www.daraspace.com/'],
    'twitter_image'             => ['property' => 'twitter:image', 'content' => 'https://www.daraspace.com/images/twitter-image.jpg'],

    'googleplus_name'           => ['itemprop' => 'name', 'content' => 'Welcome to Daraspace'],
    'googleplus_description'    => ['itemprop' => 'description', 'content' => 'Discover beneficial content and resources.'],
    'googleplus_image'          => ['itemprop' => 'image', 'content' => 'https://www.daraspace.com/images/googleplus-image.jpg'],

//    'onBeginRequest'            => create_function('$event', 'return ob_start("ob_gzhandler");'),
//    'onEndRequest'              => create_function('$event', 'return ob_end_flush();'),

    'GOOGLE_API_KEY'            => 'AIzaSyAkkJTa7erb_WQNe78_cvVBo8-nsvKlu9c', // use your own api key
    'googleMapsApiKey'          => 'AIzaSyAkkJTa7erb_WQNe78_cvVBo8-nsvKlu9c', // use your own api key
];

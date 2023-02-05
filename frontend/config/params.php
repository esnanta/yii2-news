<?php
return [
    'bsVersion' => '4.x',
    //'bsDependencyEnabled' => false,// this will not load Bootstrap CSS and JS for all Krajee extensions
    'adminEmail' => 'ombakrinai@gmail.com',
    
    
    'meta_description'          => ['name' => 'description', 'content' => 'description'],
    'meta_keywords'             => ['name' => 'keywords', 'content' => 'keywords'],
    'meta_author'               => ['name' => 'author', 'content' => 'author'],
    
    'og_site_name'              => ['property' => 'og:site_name', 'content' => 'site name'],
    'og_title'                  => ['property' => 'og:title', 'content' => 'title'],
    'og_description'            => ['property' => 'og:description', 'content' => 'description'],
    'og_type'                   => ['property' => 'og:type', 'content' => 'website'],
    'og_url'                    => ['property' => 'og:url', 'content' => '/'],
    'og_image'                  => ['property' => 'og:image:secure_url', 'itemprop'=>'image', 'content' => 'image'],
    'og_width'                  => ['property' => 'og:image:width', 'content' => '300'],
    'og_height'                 => ['property' => 'og:image:height', 'content' => '300'],
    'og_updated_time'           => ['property' => 'og:updated_time', 'content' => time()],
    
    'twitter_title'             => ['property' => 'twitter:title', 'content' => 'title'],
    'twitter_description'       => ['property' => 'twitter:description', 'content' => 'description'],
    'twitter_card'              => ['property' => 'twitter:card', 'content' => 'website'],
    'twitter_url'               => ['property' => 'twitter:url', 'content' => '/'],
    'twitter_image'             => ['property' => 'twitter:image', 'content' => 'image'],

    'googleplus_name'           => ['itemprop' => 'name', 'content' => 'title'],
    'googleplus_description'    => ['itemprop' => 'description', 'content' => 'description'],
    'googleplus_image'          => ['itemprop' => 'image', 'content' => 'image'],

//    'onBeginRequest'            => create_function('$event', 'return ob_start("ob_gzhandler");'),
//    'onEndRequest'              => create_function('$event', 'return ob_end_flush();'),

    'GOOGLE_API_KEY'            => 'AIzaSyAkkJTa7erb_WQNe78_cvVBo8-nsvKlu9c', // use your own api key
    'googleMapsApiKey'          => 'AIzaSyAkkJTa7erb_WQNe78_cvVBo8-nsvKlu9c', // use your own api key
];

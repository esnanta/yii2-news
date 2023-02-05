<!-- Google Map -->
<?php
//use voime\GoogleMaps\Map;
//
//echo Map::widget([
//    'zoom' => 16,
////    'center' => 'Red Square',
//    'width' => '100%',
//    'height' => '400px',
//    'mapType' => Map::MAP_TYPE_SATELLITE,
//    
//    'center' => [5.21745993, 97.04116344],
//    'markers' => [
//        ['position' => [5.21745993, 97.04116344], 'title' => 'Puja TV', 'content' => 'InfoWindow content', 'options' => ["icon" => "'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'"]],
//        ['position' => [5.18935, 97.14903]],
//    ]    
//]);


    use dosamigos\google\maps\LatLng;
    use dosamigos\google\maps\services\DirectionsWayPoint;
    use dosamigos\google\maps\services\TravelMode;
    use dosamigos\google\maps\overlays\PolylineOptions;
    use dosamigos\google\maps\services\DirectionsRenderer;
    use dosamigos\google\maps\services\DirectionsService;
    use dosamigos\google\maps\overlays\InfoWindow;
    use dosamigos\google\maps\overlays\Marker;
    use dosamigos\google\maps\Map;
    use dosamigos\google\maps\services\DirectionsRequest;
    use dosamigos\google\maps\overlays\Polygon;
    use dosamigos\google\maps\layers\BicyclingLayer;

    $coord = new LatLng(['lat' => $office->latitude, 'lng' => $office->longitude]);
    $map = new Map([
        'center' => $coord,
        'zoom' => 10,
        'width'=>'100%'
    ]);

//    // lets use the directions renderer
    $home           = new LatLng(['lat' => $office->latitude, 'lng' => $office->longitude]);
    $destination    = new LatLng(['lat' => $model->latitude, 'lng' => $model->longitude]);
    //$waypoin  = new LatLng(['lat' => 39.72118906848983, 'lng' => 2.907628202438368]);

    // setup just one waypoint (Google allows a max of 8)
//    $waypoints = [
//        new DirectionsWayPoint(['location' => $santo_domingo])
//    ];

    $directionsRequest = new DirectionsRequest([
        'origin' => $home,
        //'destination' => $home,
        'destination' => $destination,
//        'waypoints' => $waypoints,
        'travelMode' => TravelMode::DRIVING
    ]);
//
//    // Lets configure the polyline that renders the direction
//    $polylineOptions = new PolylineOptions([
//        'strokeColor' => '#FFAA00',
//        'draggable' => true
//    ]);

    // Now the renderer
    $directionsRenderer = new DirectionsRenderer([
        'map' => $map->getName(),
        //'polylineOptions' => $polylineOptions
    ]);

    // Finally the directions service
    $directionsService = new DirectionsService([
        'directionsRenderer' => $directionsRenderer,
        'directionsRequest' => $directionsRequest
    ]);

    // Thats it, append the resulting script to the map
    $map->appendScript($directionsService->getJs());

//    // Lets add a marker now
//    $marker = new Marker([
//        'position' => $coord,
//        'title' => $office->title,
//    ]);
//
//    // Provide a shared InfoWindow to the marker
//    $marker->attachInfoWindow(
//        new InfoWindow([
//            'content' => '<p>This is my super cool content</p>'
//        ])
//    );
//
//    // Add marker to the map
//    $map->addOverlay($marker);

//    // Now lets write a polygon
//    $coords = [
//        new LatLng(['lat' => 25.774252, 'lng' => -80.190262]),
//        new LatLng(['lat' => 18.466465, 'lng' => -66.118292]),
//        new LatLng(['lat' => 32.321384, 'lng' => -64.75737]),
//        new LatLng(['lat' => 25.774252, 'lng' => -80.190262])
//    ];
//
//    $polygon = new Polygon([
//        'paths' => $coords
//    ]);
//
//    // Add a shared info window
//    $polygon->attachInfoWindow(new InfoWindow([
//            'content' => '<p>This is my super cool Polygon</p>'
//        ]));
//
//    // Add it now to the map
//    $map->addOverlay($polygon);


    // Lets show the BicyclingLayer :)
    $bikeLayer = new BicyclingLayer(['map' => $map->getName()]);

    // Append its resulting script
    $map->appendScript($bikeLayer->getJs());

    // Display the map -finally :)
    echo $map->display();




?>
<!-- End Google Map -->
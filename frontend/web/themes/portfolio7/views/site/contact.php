<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

//$this->title = 'Contact';
//$this->params['breadcrumbs'][] = $this->title;
?>


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
        'zoom' => 15,
        'width'=>'100%'
    ]);

//    // lets use the directions renderer
    $home = new LatLng(['lat' => $office->latitude, 'lng' => $office->longitude]);
//    $school = new LatLng(['lat' => 39.719456079114956, 'lng' => 2.8979293346405166]);
//    $santo_domingo = new LatLng(['lat' => 39.72118906848983, 'lng' => 2.907628202438368]);
//
//    // setup just one waypoint (Google allows a max of 8)
//    $waypoints = [
//        new DirectionsWayPoint(['location' => $santo_domingo])
//    ];
//
    $directionsRequest = new DirectionsRequest([
        'origin' => $home,
        'destination' => $home,
//        'destination' => $school,
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

    // Lets add a marker now
    $marker = new Marker([
        'position' => $coord,
        'title' => $office->title,
    ]);

    // Provide a shared InfoWindow to the marker
    $marker->attachInfoWindow(
        new InfoWindow([
            'content' => '<p>This is my super cool content</p>'
        ])
    );

    // Add marker to the map
    $map->addOverlay($marker);

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

<section class="container g-pt-100 g-pb-40">
    <div class="row justify-content-between">
        <div class="col-md-7 g-mb-60">
            <h1 class="g-font-weight-300 mb-4">Contact Us</h1>
            <!-- Contact Form -->
            
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true])->input('name', ['placeholder' => "Enter Your Name"])  ?>

                <?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => "Enter Your Email"]) ?>

                <?= $form->field($model, 'subject')->input('subject', ['placeholder' => "Enter Subject/Title"])  ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>            
            
            <!-- End Contact Form -->
        </div>

        <div class="col-md-4">
            <h1 class="g-font-weight-300 mb-4"><?=$office->title?></h1>

            <div class="mb-4">
                <h2 class="h5 g-color-gray-dark-v2 g-font-weight-600">Address:</h2>
                <p class="g-color-gray-dark-v4 g-font-size-16"><?=$office->address?></p>
            </div>

            <div class="mb-4">
                <h2 class="h5 g-color-gray-dark-v2 g-font-weight-600">Email us:</h2>
                <p class="g-color-gray-dark-v4">Email: <span class="g-color-gray-dark-v2"><?=$office->email?></span>
                </p>
            </div>

            <div class="mb-3">
                <h2 class="h5 g-color-gray-dark-v2 g-font-weight-600">Call us:</h2>
                <p class="g-color-gray-dark-v4">Call: <span class="g-color-gray-dark-v2"><?=$office->phone_number?></span>
                </p>
            </div>

            <div class="g-mb-30">
                <p class="g-color-gray-dark-v5 g-font-weight-600 g-font-size-16"><em><?=$office->description?></em>
                </p>
            </div>

            <!-- Figure Social Icons -->
<!--            <ul class="list-inline">
                <li class="list-inline-item">
                    <a class="u-icon-v1 g-color-gray-dark-v5 g-bg-gray-light-v5 g-color-white--hover g-bg-primary--hover rounded-circle" href="#">
                        <i class="g-font-size-default fa fa-facebook"></i>
                    </a>
                </li>
                <li class="list-inline-item g-mx-4">
                    <a class="u-icon-v1 g-color-gray-dark-v5 g-bg-gray-light-v5 g-color-white--hover g-bg-primary--hover rounded-circle" href="#">
                        <i class="g-font-size-default fa fa-twitter"></i>
                    </a>
                </li>
                <li class="list-inline-item g-mx-4">
                    <a class="u-icon-v1 g-color-gray-dark-v5 g-bg-gray-light-v5 g-color-white--hover g-bg-primary--hover rounded-circle" href="#">
                        <i class="g-font-size-default fa fa-google-plus"></i>
                    </a>
                </li>
                <li class="list-inline-item g-mx-4">
                    <a class="u-icon-v1 g-color-gray-dark-v5 g-bg-gray-light-v5 g-color-white--hover g-bg-primary--hover rounded-circle" href="#">
                        <i class="g-font-size-default fa fa-linkedin"></i>
                    </a>
                </li>
            </ul>-->
            <!-- End Figure Social Icons -->
        </div>
    </div>
</section>

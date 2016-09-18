<?php

include 'helpers.php';

$ZIP_CODE = getenv('APP_ZIP_CODE');
$PRODUCTS = explode(",", getenv('APP_PRODUCTS'));
$EMAIL = getenv('APP_NOTIFY_EMAIL');

//-- Search for a given zip code
$json              = file_get_contents("http://www.apple.com/shop/retail/pickup-message?".generate_parts_url($PRODUCTS)."&location={$ZIP_CODE}");
$data              = json_decode($json);
$stores            = $data->body->stores;
$products_friendly = array();
$availability      = array();

// -- Do some work
$availability = process_results($stores, $PRODUCTS);

// -- Get product friendly names
foreach ($stores[0]->partsAvailability as $product) {
	$products_friendly[] = $product->storePickupProductTitle;
}

// -- Print status screen
print_monitoring_screen($availability, $products_friendly);

//-- Filter only those stores with Apple Pencil availability --//
$filtered_array = filter_for_available_products($availability);

//-- If available in-store within the search area, send an email alert --//
if ( count($filtered_array) > 0 ) {
	send_email($filtered_array, $EMAIL, $ZIP_CODE);
}else{
	echo "\nNothing found. Sad face :'(\n\n";
}
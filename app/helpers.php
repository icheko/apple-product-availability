<?php

/**
 * Generate the parts parameters for the search URL
 * @param  array $products
 * @return string
 */
function generate_parts_url($products){
	$index = 0;
	$url = "";

	foreach ($products as $product) {
		$url .= "parts.{$index}=".urlencode($product)."&";
		$index++;
	}

	return substr($url, 0, -1);
}

/**
 * Create a two dimensional array from the search results for easy printing
 * @param  array $stores
 * @param  array $products
 * @return array
 */
function process_results($stores, $products){
	$availability = array();
	$store_index = 0;

	foreach ($stores as $store) {
	
		$product_index = 0;
		$availability[$store_index]["store"] = array(
			"store_name" => $store->storeName,
			"store_dist" => $store->storedistance
		);
		
		foreach ($products as $product) {
			$availability[$store_index]["products"][] = array(
				"store_stat" => $store->partsAvailability->{$product}->pickupDisplay, // rand(0,1) ? 'unavailable' : 'available'
				"product_name" => $store->partsAvailability->{$product}->storePickupProductTitle,
				"product_num" => $product_index
			);
			$product_index++;
		}

		$store_index++;
	}

	return $availability;
}

/**
 * A helper to print the heading info
 * @param  string $text
 * @param  int $width
 * @return string
 */
function print_header($text, $width){
	return str_pad($text, $width, " ", STR_PAD_BOTH)." | ";
}

/**
 * For some terminal monitoring fun
 * @param  array $availability
 * @param  array $products_friendly
 * @return null
 */
function print_monitoring_screen($availability, $products_friendly){
	echo "\nMonitoring availability for the following:\n\n";
	$index = 0;
	foreach ($products_friendly as $product) {
		echo "Product [".$index ."] ". $product ."\n";
		$index++;
	}

	echo "\n";

	echo print_header("Store", 45) . print_header("PRODUCT", 9) . print_header("AVAILABILITY", 20) . "\n\n";

	foreach ($availability as $index => $detail) {
		
		echo "Store: {$availability[$index]['store']['store_name']}\n";

		foreach ($detail['products'] as $product) {
			echo 
				str_pad(substr("    ".$product['product_name'], 0, 43), 45, ".", STR_PAD_RIGHT)."   ".
				str_pad($product['product_num'], 9, " ", STR_PAD_BOTH)."   ".
				str_pad($product['store_stat'], 20, " ", STR_PAD_BOTH)."   ".
				"\n";
		}
		echo "\n";
	}
}

/**
 * Filter the search results for available products to kick off the email
 * @param  array $availability
 * @return array
 */
function filter_for_available_products($availability){
	$filter = array(
	   'store_stat' => "available"
	);

	$filtered_array = array();

	foreach ($availability as $index => $detail) {
		
		$filtered_item = array();

		$filtered_products = array_filter($availability[$index]['products'], function ($val_array) use ($filter) {
		    $intersection = array_intersect_assoc($val_array, $filter);
		    return (count($intersection)) === count($filter);
		});

		if(count($filtered_products) == 0){
			continue;
		}

		$filtered_item['store'] = $availability[$index]['store'];
		$filtered_item['products'] = $filtered_products;

		array_push($filtered_array, $filtered_item);
	}

	return $filtered_array;
}

/**
 * Send the email. Boom. Go buy some shit.
 * @param  array $filtered_array
 * @param  string $email
 * @param  string $zip_code
 * @return null
 */
function send_email($filtered_array, $EMAIL, $ZIP_CODE){
	$subject = 'Apple Product Availability Update';
	$headers = "From: " . $EMAIL . "\r\n";
	$headers .= "Reply-To: no-reply@apple-availability-script.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$html_email = file_get_contents('email.html');
	$email_body = "";

	foreach($filtered_array as $index => $detail) {
		$name     = $filtered_array[$index]['store']['store_name'];
		$dist     = $filtered_array[$index]['store']['store_dist'];
		$products = $filtered_array[$index]['products'];

		$msg_store = "<h2 class=\"size-16\" style=\"Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #3e4751;font-size: 16px;line-height: 24px;font-family: Ubuntu,sans-serif;\" lang=\"x-size-16\"><strong>$name, $dist miles from {$ZIP_CODE}</strong></h2>";

		// $message .= "---------------------------------------";
		$msg_products = "";
		foreach ($products as $product) {
			$msg_products .= "<h2 class=\"size-16\" style=\"Margin-top: 16px;Margin-bottom: 16px;font-style: normal;font-weight: normal;color: #3e4751;font-size: 16px;line-height: 24px;font-family: Ubuntu,sans-serif;\" lang=\"x-size-16\"><font color=\"#7c7e7f\"> ". $product['product_name'] ."</font></h2>";
		}

		$email_body .= $msg_store . $msg_products . "<br/>";
	}

	echo $html_email = str_replace("[EMAIL_BODY]", $email_body, $html_email);

	echo "\nSending Email to {$EMAIL} ...\n";
	mail($EMAIL, $subject, $html_email, $headers);
	echo "\nDONE!\n\n";
}
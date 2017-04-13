<?

// Bus API for interview

// find if a key exists in a multidimensional array
function keyExists($array, $searchTerm)
{
	// loop through the keys in the array
    foreach ($array as $key => $item) {
    	// if the key is equal to the search term, return true
        if ($key == $searchTerm) {
            return true;
        } // endif
        // key wasn't found, continue
        else {
        	// if the key is an array, run it through the function again
            if (is_array($item) && keyExists($item, $searchTerm)) {
               return true;
            } // endif
        } // endif
    } // end foreach

    // otherwise return false
    return false;
} // end keyExists

// declare the error variable
$error = false;

// when the form is submitted
if(isset($_POST['submit'])) {

	// check to see if the postcode has been filled in
	if(empty($_POST['postcode'])) {

		// make sure the error shows
		$error = true;

	} else {

		// continue with the code
		// get the lat / lng from the postcode

		// call the json api
		$json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $_POST['postcode']);
		// decode the json
		$obj = json_decode($json);
		// cast the object into an array
		$address_details = (array) $obj;

		// check to see if the location key is NOT in the array
		if(!keyExists($address_details, 'location')) {
			// return the error
			$error = true;
		} else {

			// declare the lat / lng
			$lat = $address_details['results'][0]->geometry->location->lat;
			$lng = $address_details['results'][0]->geometry->location->lng;

			// call the transport api to get the nearest bus stops
			$stops = file_get_contents('http://transportapi.com/v3/uk/bus/stops/near.json?lat=' . $lat . '&lon=' . $lng . '&app_id=1403ee9a&app_key=fa018b243dec452605ed2cf555e369b1');
			$stops_obj = json_decode($stops);
			$stops_array = (array)$stops_obj;

			$stops = array();

			foreach ($stops_array['stops'] as $key => $value) {

				$stop_array = (array) $value;
				array_push($stops, $stop_array['stop_name']);

			} // endforeach

		} // endif

	} // endif

} // endif


?>
<html>
<head>
	<title>Bus API</title>
</head>
<body>

<h1>Bus Api</h1>
<p>Please type your postcode</p>
<?= ($error ? '<p style="color: #FF0000">An error occured.</p>' : ''); ?>
<form id="form" action="" method="post">
	<input type="text" id="postcode" placeholder="POSTCODE" value="bs42xj" name="postcode">
	<button type="submit" id="submit" name="submit">
		Submit
	</button>
</form>
<?php
/**
* Plugin Name: Bus Test
* Plugin URI: http://eamonsdiary.co.uk/
* Description: BUS api for interview
* Version: 1.0
* Author: Eamon Boyle
* Author URI: eamonsdiary.co.uk
* License: A "Slug" license name e.g. GPL12
*/

function bus_api() {
    include('busapi_admin.php');
}
 
function bus_api_actions() {
    add_options_page("Bus API Test", "Bus API Test", 1, "Bus API Test", "bus_api");
}
 
add_action('admin_menu', 'bus_api_actions');

?>
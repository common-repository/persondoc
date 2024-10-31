<?php

/*
Plugin Name: PersonDoc
Plugin URI: https://www.persondoc.com/
Description: Todos tus documentos personales juntos, seguros, ordenados, actualizados y con alarmas de caducidad.
Version: 1.1
Author: robertcierczek
Author URI: http://robertcierczek.es/
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Include the main class.
if ( ! class_exists( 'Persondoc' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-persondoc.php';
}
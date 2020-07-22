<?php
/*
 *	Plugin Name: Developer Applicant Chalenge
 *	Description: Developer challenge plugin
 *	Author: Kevin Batdorf
 *	Text Domain: developer-applicant-challenge
 *	Version: 0.1.0
 */
if (!defined( 'ABSPATH' )) die( 'No direct access.' );

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

new KevinBatdorf\App;
new KevinBatdorf\AdminPage;
new KevinBatdorf\routes\API;
new KevinBatdorf\routes\Console;
new KevinBatdorf\Shortcode;

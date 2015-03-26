<?php
/**
 * Config-file for tomtom. Change settings here to affect installation.
 *
 */

/**
 * Set the error reporting.
 *
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly


/**
 * Define tomtom paths.
 *
 */
define('tomtom_INSTALL_PATH', __DIR__ . '/..');
define('tomtom_THEME_PATH', tomtom_INSTALL_PATH . '/theme/render.php');


/**
 * Include bootstrapping functions.
 *
 */
include(tomtom_INSTALL_PATH . '/src/bootstrap.php');


/**
 * Start the session.
 *
 */
session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();


/**
 * Create the tomtom variable.
 *
 */
$tomtom = array();


/**
 * Site wide settings.
 *
 */
$tomtom['lang']         = 'sv';
$tomtom['title_append'] = ' | videouthyrning';


$tomtom['header'] = <<<EOD
<div class="width">
<img class='sitelogo' src='favicon.png' alt='tomtom Logo'/>
<span class='sitetitle'>Your title here</span>
<span class='siteslogan'>Your slogan here</span>
</div>
EOD;

$admin = isset($_SESSION['admin']) ? $_SESSION['admin']->acronym : null;
$tomtom['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Wild West Rentals | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a>
EOD;
if ($admin){
	$tomtom['footer'] .=<<<EOD
	<a href='source.php'>Sourcecode if admin</a>
EOD;
}
$tomtom['footer'] .=<<<EOD
</span></footer>
EOD;

/**
 * The navbar
 *
 */
//$tomtom['navbar'] = null; // To skip the navbar
	$tomtom['navbar']=array(
		'class'=> 'navbar',
		'items'=> array(
			'home' => array('text' => 'home' , 'url'=>'me.php', 'title'=>'Home')
  'callback_selected' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);

// Connect to a MySQL database using PHP PDO
define('DB_USER', '????');
define('DB_PASSWORD', '????');
$tomtom['database']['dsn']= 'mysql:host=localhost;dbname=?????;';
$tomtom['database']['username']= DB_USER;
$tomtom['database']['password'] = DB_PASSWORD;
$tomtom['database']['driver_options']= array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");


/**
 * Theme related settings.
 *
 */
//$tomtom['stylesheet'] = 'css/style.css';
$tomtom['stylesheets'] = array('css/style.css', 'css/dice.css', 'css/table.css', 'css/gallery.css');
$tomtom['favicon']    = 'favicon.png';



/**
 * Settings for JavaScript.
 *
 */
$tomtom['modernizr'] = 'js/modernizr.js';
$tomtom['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
//$tomtom['jquery'] = null; // To disable jQuery
$tomtom['javascript_include'] = array();
//$tomtom['javascript_include'] = array('js/main.js'); // To add extra javascript files



/**
 * Google analytics.
 *
 */
$tomtom['google_analytics'] = 'UA-22093351-1'; // Set to null to disable google analytics

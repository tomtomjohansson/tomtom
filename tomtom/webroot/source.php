<?php 
/**
 * This is a tomtom pagecontroller.
 *
 */
// Include the essential config-file which also creates the $tomtom variable with its defaults.
include(__DIR__.'/config.php'); 


// Add style for csource
$tomtom['stylesheets'][] = 'css/source.css';


// Create the object to display sourcecode
//$source = new CSource();
$source = new CSource(array('secure_dir' => '..', 'base_dir' => '..'));


// Do it and store it all in variables in the tomtom container.
$tomtom['title'] = "Visa källkod";

$tomtom['main'] = "<h1>Visa källkod</h1>\n" . $source->View();


// Finally, leave it all to the rendering phase of tomtom.
include(tomtom_THEME_PATH);

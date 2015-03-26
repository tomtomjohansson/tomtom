<?php 
/**
 * This is a tomtom pagecontroller.
 *
 */
// Include the essential config-file which also creates the $tomtom variable with its defaults.
include(__DIR__.'/config.php'); 



// Do it and store it all in variables in the tomtom container.
$tomtom['title'] = "404";
$tomtom['header'] = "";
$tomtom['main'] = "This is a tomtom 404. Document is not here.";
$tomtom['footer'] = "";

// Send the 404 header 
header("HTTP/1.0 404 Not Found");


// Finally, leave it all to the rendering phase of tomtom.
include(tomtom_THEME_PATH);

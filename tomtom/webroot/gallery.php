<?php 
/**
 * This is a tomtom pagecontroller.
 *
 */
// Include the essential config-file which also creates the $tomtom variable with its defaults.
include(__DIR__.'/config.php'); 

$tomtom['title'] = "Gallery";

$Gallery=new CGallery(__DIR__);

// Prepare content and store it all in variables in the tomtom container.
$breadcrumb = $Gallery->createBreadcrumb($Gallery->pathToGallery);
$Galleri = $Gallery->makeGallery();

$tomtom['main'] = <<<EOD
 
$breadcrumb
 
$Galleri
 
EOD;

// Finally, leave it all to the rendering phase of tomtom.
include(tomtom_THEME_PATH);
<?php
/* This is the tomtom-pagecontroller */

include(__DIR__.'/config.php');

/* Spara alla variabler i tomtom-me */
$tomtom['title'] = "Your title here";


$tomtom['main'] = 
<<<EOD
		<h1>Hello World!</h1>
		<p>Here is some content for you to enjoy!</p>
EOD;


//Finally, let's render tomtom
include(tomtom_THEME_PATH); 
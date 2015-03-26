<?php 

include("../src/CImage/CImage.php"); 
/**
 * This is a PHP skript to process images using PHP GD.
 *
 */


// Ensure error reporting is on
//
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly

// Define some constant values, append slash
// Use DIRECTORY_SEPARATOR to make it work on both windows and unix.
//
define('IMG_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'img/Pmovie' . DIRECTORY_SEPARATOR);
define('CACHE_PATH', __DIR__ . '/cache/');


    $src = isset($_GET['src']) ? $_GET['src'] : null;
    $verbose = isset($_GET['verbose']) ? true : null;
    $saveAs = isset($_GET['save-as']) ? $_GET['save-as'] : null;
    $quality = isset($_GET['quality']) ? (int)$_GET['quality'] : 60;
    $ignoreCache = isset($_GET['no-cache']) ? true : null;
    $newWidth = isset($_GET['width']) ? (int)$_GET['width'] : null;
    $newHeight = isset($_GET['height']) ? (int)$_GET['height'] : null;
    $cropToFit = isset($_GET['crop-to-fit']) ? true : null;
    $sharpen = isset($_GET['sharpen']) ? true : null;



    $cImage = new CImage($src, $verbose, $saveAs, $quality, $ignoreCache, $newWidth, $newHeight, $cropToFit, $sharpen, IMG_PATH, CACHE_PATH);


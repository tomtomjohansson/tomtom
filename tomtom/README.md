tomtom-base (original by Mikael Roos called anax-base)
=========

A webbtemplate / boilerplate for smaller websites and webbapplications using PHP.

Built by Mikael Roos, tweaked by Tomas Johansson.

Read article about this here: http://dbwebb.se/kunskap/anax-en-hallbar-struktur-for-dina-webbapplikationer

Guide to tomtom
------------------
tomtom contains three folders: webroot, src and theme.

1. Webroot
------------------
1.2 Folders in Webroot
cache - Cache for files from img.php.

csss- contains files with basic designs for html elements. Seperated into the main style.css, table.css, gallery.css and source.css.

img - For images. Subdirectory gallery works with img.php.

js - support for javascript.

1.3 Files in Webroot
404.php - Pops up if url points to non-existing page.

uploader.php - Support for uploading files. Checks if file is an image, else dies.

source.php - For viewing sourcecode from all pages.

me.php - A dummy for how to make a simple page.

gallery.php - For presenting a gallery.

favicon - The tomtom-logo!

config.php - The brain! Should be included in all page-controllers. Sets error-reporting. Calls on autoloader. Starts session. Contains header, footer and navbar. Selects stylesheets. Settings for java. And more.

2. Src
------------------
CUser - Class with functions for login, logout and statuscheck. Based on MySQL-table User.

CTextfilter - Class with support for various textfilters including markdown and bbcode.

CSource - Class that lets you view all your sourcecode.

CImage - Class that together with file img.php lets you change size of the image, crop the image, change filetype and more.

CGallery - Class for creating a gallery together with gallery.php.

CHtmlTable - Class for building a html-table with support for pagination, sorting, and deciding amount of rows shown.

CContent - Class that gives you everything you need to create a blog. Functions for adding posts, deleting posts and updating posts. Class also contains function for filling a sql-table with sample-code that fits all other functions.

CDatabase - Important class. Collects info from config about database. Provides models for PHP PDO querys.

bootstrap.php - Autoloads all classfiles in directory src. Is called upon in config.php.

3. Theme
------------------
functions.php - Gets title and navbar for page.

index.tpl.php - The template for all pages. This is your HTML-basics. Header, footer, content-div. Contains the head with all the typical stuff involved. Also place for javascripts.

render.php - Small but powerful. This piece of code gathers the array with all content and turns it into variables for the template file to read. Cool stuff!


License 
------------------

This software is free software and carries a MIT license.



Use of external libraries
-----------------------------------

The following external modules are included and subject to its own license.



### Modernizr
* Website: http://modernizr.com/
* Version: 2.6.2
* License: MIT license 
* Path: included in `webroot/js/modernizr.js`



History
-----------------------------------


v1.0.3 (2013-11-22)

* Naming of session in `webroot/config.php` allows only alphanumeric characters.


v1.0.2 (2013-09-23)

* Needs to define the ANAX_INSTALL path before using it. v1.0.1 did not work.


v1.0.1 (2013-09-19)

* `config.php`, including `bootstrap.php` before starting session, needs the autoloader()`.


v1.0.0 (2013-06-28)

* First release after initial article on Anax.



------------------
 .  
..:

Copyright (c) 2013 Mikael Roos




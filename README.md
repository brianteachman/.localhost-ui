LICENSE: WTFPL ( http://sam.zoy.org/wtfpl/COPYING )

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                    Version 2, December 2004

 Copyright (C) 2004 Sam Hocevar <sam@hocevar.net>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.
  
***

Simple localhost Interface
==========================

A lightweight user interface for LAMP development. Upon entering your localhost in a web browser this package provides links for quick access to:

+ the web root directory 
+ the VirtualHost directory found on Ubuntu flavored debian
+ phpMyAdmin, for MySQL needs
+ phpinfo()
+ local documentation

> This was implemented on Ubuntu and as such may need to be configured to suit your system, see step 2 below.

Install:

1. Place index.php and .localhost directory in your root web directory.
   + ``cd /var/www/`` (or whatever)
   + ``git clone git://github.com/lordbushi/Simple-localhost-Landing-Page.git``
2. In /.localhost/runtime.inc.php, configure any constants that need configuring.
3. This app relies on [dflydev-markdown](http://github.com/dflydev/dflydev-markdown) to display markdown syntax. I am using [composer](http://getcomposer.org/) to install dependancies into the /.localhost/vendor directory and configure the autoloader, but you can download it manually if you want. If you don't use composer, be sure to remove 
``require('vendor/autoload.php');`` from /.localhost/runtime.inc.php.


Here are my current thoughts on localhost access to resources.

API:
----

> ``Localhost::readIt($directory, $show_hidden=false, $usr_exceptions=null)``
    
> ``Localhost::parse($subject)``
    
> ``Localhost::build($options=null, $li_class_override=null)``

Typical use case:

    $host = new Localhost();
    $view = new View();

    $files = $host->readIt( CURRENT_DIR );
    $file_meta = array(
        'title' => 'localhost',
        'tagline' => 'Listing: ' . getcwd(),
        'slug' => '?list=' . HTTPD . '/',
    );
    $host->build($files, $file_meta);

    $virtual_host = $host->readIt( VHOST );
    $vhost_meta = array(
        'title' => 'VirtualHost',
        'tagline' => 'Site Development',
        'slug' => 'http://',
    );
    $host->build($virtual_host, $vhost_meta, 'vhost');
    
    $view->render($host, 'Yo house');
    
Other typical use case:
    
    list($resource, $subdir) = parse($_GET["list"]);
    
    if (is_array($resource)) {
    
        //@todo prepend $dir to all links in listed directory using javascript
        $dir = realpath(dirname($_GET["list"]));

        $file_meta = array(
            'title' => 'File Handler',
            'tagline' => $dir,
            'slug' => "?list={$dir}/",
        );
        if (isset($subdir)) {
            $file_meta["title"] = ucfirst($subdir);
            $file_meta["tagline"] .= "/$subdir/";
            $file_meta["slug"] .= "$subdir/";
        }
        $host->build($resource, $file_meta);
        
        $view->render($host);
        
    } else {
        echo $view->head('Resource Listing');
        echo $resource;
        echo $view->foot();
    }
    
------------------------------------------------------------------------------------

TODO:

* Finish file handler (eg, be able to open most all text based files in the browser)
+ Implement [Syntax highlighter](http://alexgorbatchev.com/SyntaxHighlighter/)
* Integrate [text editor](https://github.com/lordbushi/Quite_Simple_PHP_File_Editor)

> Note: (maybe) In the future this will switch this to XML and XSL to use as apache2 directory listing page.


# Localhost UI
> LICENSE: [WTFPL](http://sam.zoy.org/wtfpl/COPYING)

A lightweight user interface for LAMP development. Upon entering your localhost in a web browser this package provides links for quick access to:

+ the web root directory 
+ the VirtualHost directory found on Ubuntu flavored debian
+ phpMyAdmin, for MySQL needs
+ phpinfo()
+ local documentation

> This was implemented on a debian build and as such may need to be configured to suit your system, see step 2 below.

Install:

1. Clone localhost-ui into your root web directory.
   + `cd /var/www` (or whatever)
   + `git clone git://github.com/lordbushi/Simple-localhost-Landing-Page.git`
2. In /.localhost/runtime.inc.php, configure any constants that need configuring.
3. This app depends on [dflydev-markdown](http://github.com/dflydev/dflydev-markdown) to display markdown syntax. I am using [composer](http://getcomposer.org/) to install dependancies into the /.localhost/vendor directory and configure the autoloader, but you can download it manually if you want. If you don't use composer, be sure to remove 
`require('vendor/autoload.php');` from /.localhost/runtime.inc.php.


Here are my current thoughts on localhost access to resources.

## API: 

    $host = new Localhost();

    // Delegate content to proper handler
    $host->set($directory, $options);
        
    // load template with content, set title, output to stream
    $host->view();


Typical use case:

    $host = new Localhost();

    $file_meta = array(
        'title' => 'localhost',
        'tagline' => 'Listing: ' . getcwd(),
    );
    $host->set(HTTPD, $file_meta);

    $vhost_meta = array(
        'title' => 'VirtualHost',
        'tagline' => 'Site Development',
    );
    $host->set(VHOST, $vhost_meta, 'vhost');
    
    $host->view();
    
Other typical use case:
    
    if ($_GET["list"] == 'all') {
        
        $local_docs = HTTPD . '/docs/';
        $file_meta = array(
            'title' => 'Local Docs',
            'tagline' => 'Listing: localhost/docs',
            'slug' => '?list=' . $local_docs,
        );
        $host->set($local_docs, $file_meta);

        $pear_meta = array(
            'title' => 'PEAR Docs',
            'tagline' => 'Listing: ' . PEAR_DOC_PATH,
            'slug' => '?list=' . PEAR_DOC_PATH,
        );
        $host->set(PEAR_DOC_PATH, $pear_meta);
        
        $host->view();
        
    } else {

        $style = $host->set($_GET["list"]);
        $host->view($style);
        
    }
    
------------------------------------------------------------------------------------

TODO:

+ Implement [Syntax highlighter](http://alexgorbatchev.com/SyntaxHighlighter/)
* Integrate [text editor](https://github.com/lordbushi/Quite_Simple_PHP_File_Editor)

> Note: (maybe) In the future this will switch this to XML and XSL to use as apache2 directory listing page.


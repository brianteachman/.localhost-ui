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
   + `git clone git://github.com/lordbushi/.localhost-ui.git`
2. In /.localhost-ui/runtime.config.php, configure any elements that need configuring.
3. This app depends on [dflydev-markdown](http://github.com/dflydev/dflydev-markdown) to display markdown syntax. I am using [composer](http://getcomposer.org/) to install it into /.localhost/vendor directory. So, run:
   + `cp .localhost-ui/index.php index.php`
   + `cd .localhost-ui`
   + `php composer.phar install`


Here are my current thoughts on localhost access to resources.

## API: 

In `.localhost-ui/runtime.php`:

    <?php
    use Localhost\View,
        Localhost\ResourceLister;
    
    $config = include 'runtime.config.php';
    
    $view = new View('Localhost-UI');
    $host = new ResourceLister(
        $view,
        $config
    );

    // Delegate content to proper handler
    $host->set($directory, $options);
        
    // load template with content, set title, output to stream
    $host->view();


Typical use case:

    $file_meta = array(
        'title' => 'localhost',
        'tagline' => 'Listing: ' . getcwd(),
    );
    $host->set($config['httpd'], $file_meta);

    $vhost_meta = array(
        'title' => 'VirtualHost',
        'tagline' => 'My Domains',
    );
    $host->set('/etc/apache2/sites-enabled', $vhost_meta, 'vhost');
    
    $host->view();
    
Other typical use case:
    
    if ($_GET["list"] == 'all') {
        
        $local_docs = $config['httpd'] . '/docs/';
        $file_meta = array(
            'title' => 'Local Docs',
            'tagline' => 'Listing: localhost/docs',
            'slug' => '?list=' . $local_docs,
        );
        $host->set($local_docs, $file_meta);
        
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


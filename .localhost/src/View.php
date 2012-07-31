<?php

/**
 * View
 */
class View
{
    public $title;
    
    public function __construct ($title='Localhost')
    {
        $this->title = $title;
    }
    
    /**
     * Return HTML header as string
     * 
     * @param string $title
     * @param bool $html5 True sets HTML doctype, false sets XHTML
     * @return string
     */
    public function head($title)
    {
        $bootstrap = ASSETS . 'bootstrap/css/bootstrap.css';
        $styles = ASSETS . 'styles.css';
        $phpinfo = SCRIPTS . 'phpinfo.php';

        header('Content-type: text/html; charset=utf-8'); 
        
        return <<<HEADER
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>localhost &raquo; {$title}</title>
        <link href="{$bootstrap}" rel="stylesheet">
        <link rel="stylesheet" href="{$styles}" />
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <header class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="/">{$title}</a>
                    <ul class="nav">
                        <li><a href="http://localhost/phpmyadmin/" target="blank">phpMyAdmin</a></li>
                        <li><a href="{$phpinfo}" target="blank">phpinfo()</a></li>
                        <li><a href="/?list=all">Docs</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <section class="lister row">
HEADER;
    }

    /**
     * Return HTML footer as string
     * 
     * @return string
     */
    public function foot()
    {
        $bootstrap = ASSETS . 'bootstrap/js/bootstrap.js';
        
        $footer = <<<FOOTER
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <!-- Bootstrap plugins -->
        <script src="{$bootstrap}"></script>
        
        <script type="text/javascript">
        
        </script>
    </body>
</html>
FOOTER;
        return $footer;
    }

    /**
     * @return string
     */
    public function messenger()
    {
        if (isset($_SESSION["message"])) {
            echo '<span class="error">' . $_SESSION["message"] . '</span>';
            unset($_SESSION["message"]);
        }
    }
    
    /**
     * Return styled HTML list as a string
     * 
     * @param 
     * @return string
     */
    public function render($content, $title=null)
    {
        if ($title === null) {
            $title = $this->title;
        }
        echo $this->head($title)
               . $this->messenger()
               . $content 
               . $this->foot();
    }
}


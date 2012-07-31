<?php

/**
 * Return HTML header as string
 * 
 * @param string $title
 * @param bool $html5 True sets HTML doctype, false sets XHTML
 * @return string
 */
function head($title='Localhost Interface')
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
function foot()
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
 * Return styled HTML list as a string
 * 
 * @param array $options
 * @param string Optional list class attribute
 * @return string
 */
function list_view($resource, $options=null, $li_class_override=null)
{
    static $module_id = 0;
    $meta = array(
        'id' => "module-" .  ++$module_id,
        'title' => 'Default Module Title',
        'tagline' => 'This is the default module tagline.',
        'slug' => '',
    );
    if (isset($options) && is_array($options)) {
        $meta = array_merge($meta, $options);
    }
    
    $html = '<div id="' . $meta["id"] . '" class="listing span4">'
            . '<h2>' . ucfirst($meta["title"]) . '</h2>'
            . '<p>' . $meta["tagline"] . "</p>\n"
            . "<ul>\n";
    foreach($resource as $listing) {
        
        if ($li_class_override !== null) {
            $listing["type"] = $li_class_override;
        }
        $html .= '<li class="' . $listing["type"] . '">'
                 . '<a href="' . $meta["slug"] . $listing["name"] . '">'
                    . '<span class="link">' . $listing["name"] . '</span>'
                 . '</a>'
               . "</li>\n";
    }
    $html .= "</ul>\n</div>\n";
    
    return $html;
}

/**
 * @return string
 */
function flash_messenger()
{
    if (isset($_SESSION["message"])) {
        echo '<span class="error">' . $_SESSION["message"] . '</span>';
        unset($_SESSION["message"]);
    }
}


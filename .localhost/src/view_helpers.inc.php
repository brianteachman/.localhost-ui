<?php
/**
 * Display header
 * 
 * @param string $title
 * @return string
 */
function head($title='Localhost Interface')
{
    $styles = ASSETS_LINK . 'styles.css';
    $phpinfo = SCRIPTS . 'phpinfo.php';
    header('Content-type: text/html; charset=utf-8'); 
    
    return <<<HEADER
<DOCTYPE html>
<html>
    <head>
        <title>localhost >> {$title}</title>
        <link rel="stylesheet" href="{$styles}" />
    </head>
    <body>
        <header>
            <h1>{$title}</h1>
            <nav>
                | <a href="http://localhost/phpmyadmin/" target="_blank">phpMyAdmin</a>
                | <a href="{$phpinfo}" target="_blank">phpinfo()</a>
                | <a href="/docs.php" target="_blank">Docs</a>
            </nav>
        </header>
        <section>
HEADER;
}

/**
 * Display footer
 * 
 * @return string
 */
function foot()
{
    $footer = <<<FOOTER
        </section>
    </body
</html>
FOOTER;
    return $footer;
}

/**
 * Styled HTML block for listing arrays
 * 
 * @param array $options
 * @return string
 */
function list_module($resource, $options=null, $li_class_override=null)
{
    $meta = array(
        'id' => 'module',
        'title' => 'Default Module Title',
        'tagline' => 'This is the default module tagline.',
        'slug' => '',
    );
    if (isset($options) && is_array($options)) {
        $meta = array_merge($meta, $options);
    }
    
    $html = '<div id="' . $meta["id"] . '" class="listing">'
            . '<h2>' . ucfirst($meta["title"]) . '</h2>'
            . '<hr><p>' . $meta["tagline"] . "</p>\n"
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


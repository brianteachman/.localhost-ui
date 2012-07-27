<?php
$block_element = 'section';

/**
 * Return HTML header as string
 * 
 * @param string $title
 * @param bool $html5 True sets HTML doctype, false sets XHTML
 * @return string
 */
function head($title='Localhost Interface', $html5=false)
{
    global $block_element;
    $styles = ASSETS_LINK . 'styles.css';
    $phpinfo = SCRIPTS . 'phpinfo.php';
    
    if ($html5) {
        $doctype = <<<HTML
<!DOCTYPE html>
<html>
HTML;
    } else {
        $doctype = <<<XHTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
XHTML;
        $block_element = 'div';
    }

    header('Content-type: text/html; charset=utf-8'); 
    
    return <<<HEADER
{$doctype}
    <head>
        <title>localhost &raquo; {$title}</title>
        <link rel="stylesheet" href="{$styles}" />
    </head>
    <body>
        <div id="header">
            <h1>{$title}</h1>
            <div id="nav">
                | <a href="http://localhost/phpmyadmin/">phpMyAdmin</a>
                | <a href="{$phpinfo}">phpinfo()</a>
                | <a href="/docs.php">Vendor docs</a>
            </div>
        </div>
        <{$block_element}>
HEADER;
}

/**
 * Return HTML footer as string
 * 
 * @return string
 */
function foot()
{
    global $block_element;
    
    $footer = <<<FOOTER
        </{$block_element}>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
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
function list_module($resource, $options=null, $li_class_override=null)
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
    
    $html = '<div id="' . $meta["id"] . '" class="listing">'
            . '<h2>' . ucfirst($meta["title"]) . '</h2>'
            . '<hr /><p>' . $meta["tagline"] . "</p>\n"
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


<?php

/**
 * View
 */
class View
{
    public $title;
    
    public $view = '';
    
    private $content = '';
    
    public function __construct ($title='Localhost-UI')
    {
        $this->title = $title;
    }
    
    public function __toString()
    {
        return (string) $this->view;
    }
    
    /**
     * Return HTML header as string
     * 
     * @param string $title
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
    
    public function appendContent($content)
    {
        $this->content .= $content;
    }
    
    /**
     * @param array $files
     * @param array $0ptions
     * @param string $li_class_override
     * @return string
     */
    public function titledListBlock($files, $options=null, $li_class_override=null)
    {
        $html = '<div id="' . $options["id"] . '" class="listing span4">'
                . '<h2><i class="icon-folder-open"></i>' . ucfirst($options["title"]) . '</h2>'
                . '<p>' . $options["tagline"] . "</p>\n"
                . "<ul>\n";
                
        foreach($files as $listing) {
            
            if ($li_class_override !== null) {
                $listing["type"] = $li_class_override;
            }
            $html .= '<li class="' . $listing["type"] . '">'
                     . '<a href="' . $options["slug"] . $listing["name"] . '">'
                        . '<span class="link">' . $listing["name"] . '</span>'
                     . '</a>'
                   . "</li>\n";
        }
        $html .= "</ul>\n</div>\n";
        
        $this->appendContent($html);
    }

    /**
     * Either sets a message or shows it (depends if message is set)
     * 
     * @param [string $message]
     * @param [int $weight]
     * @return bool|string
     */
    public function messenger($message=null, $weight=0)
    {
        $levels = array(
            'info',
            'notice',
            'warning',
            'error',
        );
        
        $tbicon = array(
            'icon-info-sign',
            'icon-question-sign',
            'icon-exclamation-sign',
            'icon-remove-sign',
        );
        
        if ($message !== null) {
            $_SESSION["messenger"]["message"] = $message;
            
            if (array_key_exists($weight, $levels)) {
                $class = $levels[$weight];
            } else {
                $class = $levels[3];
            }
            $_SESSION["messenger"]["level"] = $class;
            return true;
        }
        if (isset($_SESSION["messenger"])) {
            
            $class = $_SESSION["messenger"]["level"];
            $key = array_search($class, $levels);
            $icon = $tbicon[$key];
            $message = $_SESSION["messenger"]["message"];
            unset($_SESSION["messenger"]);
            
            $messenger = '<span class="' . $class . '">'
                 . '<i class="' . $icon . '"></i>'
                 . $message
                 . '</span>';
            return $messenger;
        }
        return false;
    }

    /**
     * If templates, load; if title, set; then output content. 
     * 
     * @param string
     */
    public function render($content, $template=true, $title=null)
    {
        if ($template) {
            
            if ($title === null) {
                $title = $this->title;
            }
            $this->view = $this->head($title)
                        . $this->messenger()
                        . $this->content
                        . $this->foot();
        }
        echo $this->view;
    }
}


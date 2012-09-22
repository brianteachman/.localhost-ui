<?php
namespace Localhost;

use dflydev\markdown\MarkdownExtraParser;

/**
 * Localhost
 *
 * @license s
 */
class ResourceLister
{  
    /**
     * @var array Array of files to ignore.
     */
    private $exceptions = array(
        '.localhost-ui',
        '000-default',
        'favicon.ico',
    );

    /**
     * Directory listing currently being read
     *
     * @var array Array of associative arrays
     */
    protected $files = array();

    protected $view;
    
    protected $config = null;

    /**
     * @param string URI to read
     */
    public function __construct ($view, $config=null)
    {
        $this->view = $view;
        if (null !== $config) {
            $this->config = $config;
            $this->view->setConfig($config);
        }
    }

    public function __toString()
    {
        return (string) $this->view;
    }

    /**
     *
     *
     * @param string     $directory      Path to directory
     * @param bool       $show_hidden
     * @param null|array $usr_exceptions
     */
    protected function scan($directory, $show_hidden=false, $usr_exceptions=null)
    {
        if ($usr_exceptions !== null) {
            $this->exceptions = array_merge($this->exceptions, $usr_exceptions);
        }
        unset($this->files);

        $dir = dir($directory);

        while ($result = $dir->read()) {

            if (substr($result, -1) == '~') continue;
            if ($show_hidden === false) {
                if (preg_match('/^\./', $result)) continue;
            }
            if (!in_array($result, $this->exceptions)) {
                if (is_dir($directory.'/'.$result)) {
                    $file["type"] = 'dir';
                    $file["name"] = $result;
                } else {
                    $file["type"] = 'file';
                    $file["name"] = $result;
                }
                $this->files[] = $file;
            }
        }
        $dir->close();

        sort($this->files);
    }

    /**
     * Return styled HTML list as a string
     *
     * @param array $options
     * @param string Optional list class attribute
     * @return void
     */
    protected function build($files, $options=null, $li_class_override=null)
    {
        static $module_id = 0;
        $meta = array(
            'id' => "module-" .  ++$module_id,
            'title' => 'Default Block Title',
            'tagline' => 'This block was built in a Simple Factory',
            'slug' => '',
        );
        if (isset($options) && is_array($options)) {
            $meta = array_merge($meta, $options);
        }

        $this->view->titledListBlock($files, $meta, $li_class_override);
    }

    /**
     * Loads directory, file handler
     *
     * @todo Break out a file-type finder
     *
     * @param string File or directory name
     */
    public function set($directory, $options=null, $class=null)
    {
        /**
         * @var bool Return value
         */
        $template = true;

        $listing = trim($directory);
        $path = realpath(dirname($listing));
        $subdir = basename($listing);

        if (is_dir($listing)) {
            $this->scan($listing);

            if (isset($this->files) && is_array($this->files)) {

                if (isset($subdir) && is_dir($listing.'/'.$subdir)) {
//                 if (isset($subdir) && is_dir($listing/*$listing.'/'.$subdir*/)) {
                    $options["title"] = ucfirst($subdir);
                    $options["tagline"] = "{$path}/{$subdir}/";
                    if (!isset($options["slug"])) {
                        $options["slug"] = "?list={$path}/{$subdir}/";
                    }
                }
                $this->build($this->files, $options, $class);
            }
            
        } elseif (strpos($listing, '.md') || strpos($listing, '.markdown')) {
            $markdown = file_get_contents($listing);
            $mdParser = new MarkdownExtraParser();

            $md = $mdParser->transformMarkdown($markdown);
            $this->view->appendContent($md);
            
        } elseif (strpos($listing, '.php') || strpos($listing, '.html')) {
            if ($options["slug"] != '') continue;
            $template = false;

            $bypass = str_replace($this->config['httpd'], 'http://localhost', $listing);
            header("Location: {$bypass}");
            
        } else {
            $file = file_get_contents($listing);
            $this->view->appendContent($file);
        }

        return $template;
    }

    public function view($template=true)
    {
        $this->view->render($this->view, $template);
    }
}

<?php
namespace Localhost;

use dflydev\markdown\MarkdownExtraParser;

/**
 * Localhost
 *
 * @license s
 */
class Manager
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

    /**
     * View instance
     */
    protected $view;
    
    protected $config = null;
    
    private $modules = 1;

    /**
     * @param string URI to read
     */
    public function __construct ()
    {

    }
    
    public function listDir($dir_path, $flat=true)
    {
        if ( !(is_dir($dir_path))) {
            return false;
        }
        
        $files = array();
        $iter = new \RecursiveDirectoryIterator($dir_path);
        
        foreach (new \RecursiveIteratorIterator($iter) as $item) {
            if (is_dir($item)) {
                $file["type"] = 'dir';
                $file["name"] = $item;
            } else {
                $file["type"] = 'file';
                $file["name"] = $item;
            }
            $files[] = $file;
        }
                
        for ($i=0; $i<count($files); $i++) {
            $dir = basename($files[$i]["name"]);
            if ($dir == '.' || $dir == '..') {
                $files[$i] = '';
            }
        }
        
        return array_filter($files);
    }

    /**
     * 
     *
     * @param string|array   $directory
     * @param null|array[][] $usr_exceptions
     * @param bool           $show_hidden
     * @return false|string[] Array of string directory names or false if empty(array)
     */
    public function readyResults($directory, $usr_exceptions=null, $show_hidden=false)
    {
        $results = false;
        
        if (isset($usr_exceptions) && is_array($usr_exceptions)) {
            $this->exceptions = array_merge($this->exceptions, $usr_exceptions);
        }
        
        if (@is_dir($directory)) {
            $results = true;
            $directory = $this->listDir($directory);
        }
        if (@is_file($directory)) {
            $results = true;
            $this->set($directory);
        }
        if (is_array($directory)) {
            foreach($directory as $result) {
                if (substr($result, -1) == '~') continue;
                if ($show_hidden === false) {
                    if (preg_match('/^\./', $result)) continue;
                }
                if (!in_array($result, $this->exceptions)) continue;
                
                $results[] = $result;
            }
            if (is_array($results)) {
                sort($results);
            }
        }
        
        return $results;
    }
    
    public function registerView($view)
    {
        $this->view = $view;
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
        $parse = true;

        $listing = trim($directory);
        $path_to = realpath(dirname($listing));
        $target = basename($listing);

        if (is_dir($listing)) {
        
            $directory = $this->listDir($listing);

            if (isset($directory) && is_array($directory)) {
            
                if (isset($subdir) && is_dir($listing.'/'.$subdir)) {
                    $options["title"] = ucfirst($subdir);
                    $options["tagline"] = "{$path}/{$subdir}/";
                    if (!isset($options["slug"])) {
                        $options["slug"] = "?list={$path}/{$subdir}/";
                    }
                }
                $this->view->buildModule($directory, $options, $class);
            }
            
        } elseif (strpos($listing, '.md') || strpos($listing, '.markdown')) {
            $markdown = file_get_contents($listing);
            $mdParser = new MarkdownExtraParser();

            $md = $mdParser->transformMarkdown($markdown);
            $this->view->appendContent($md);
            
        } elseif (strpos($listing, '.php') || strpos($listing, '.html')) {
//             if ($options["slug"] != '') continue;
            $parse = false;

            $bypass = str_replace($this->config['httpd'], 'http://localhost', $listing);
            header("Location: {$bypass}");
            
        } else {
            $file = file_get_contents($listing);
            $this->view->appendContent('<pre>'.$file.'</pre>');
        }

        return $parse;
    }
}

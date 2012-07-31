<?php
use dflydev\markdown\MarkdownParser;

/**
 * Localhost
 * 
 * @license s
 */
class Localhost
{
    /**
     * @var array Array of files to ignore.
     */
    private $exceptions = array(
        '.localhost',
        '000-default',
        'index.php',
        'favicon.ico',
    );
    
    /**
     * Directory listing currently being read
     * 
     * @var array Array of associative arrays
     */
    protected $files = array();
    
    protected $view;
    
    /**
     * @param string URI to read
     */
    public function __construct () {}
    
    public function __toString()
    {
        return $this->view;
    }
    
    /**
     * 
     * 
     * @param string $directory Path to directory
     * @param bool $show_hidden
     * @param null|array $usr_exceptions
     * @return string[] $files Array of file or directory listings
     */
    public function readIt($directory, $show_hidden=false, $usr_exceptions=null) 
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

        return $this->files;
    }

    /**
     * Short description
     * 
     * @param array $subject
     * @return string|array[]
     */
    public function parse($subject)
    {
        $listing = trim($subject);
        
        if (is_dir($listing)) {
            $resource = readIt($listing);
            $subdir = basename($listing);
        }
        elseif (strpos($listing, '.md') || strpos($listing, '.markdown')) {
            $markdown = file_get_contents($listing);
            
            $mdParser = new MarkdownParser();
            $resource = $mdParser->transformMarkdown($markdown);
            
            $subdir = null;
        } 
        else {
            $resource = file_get_contents($listing);
            $subdir = null;
        }
        
        return array($resource, $subdir);
    }
    
    /**
     * Return styled HTML list as a string
     * 
     * @param array $options
     * @param string Optional list class attribute
     * @return void
     */
    public function build($files, $options=null, $li_class_override=null)
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
                
        foreach($files as $listing) {
            
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
        
        $this->view .= $html;
    }
}

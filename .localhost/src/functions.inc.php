<?php
require(VENDOR.'markdown.php');

/**
 * @param string $directoryPath Path to directory
 * @param bool $show_hidden
 * @param null|array $usr_exceptions
 * @return array $files Array of file or directory listings
 */
function listIt($directory_path, $show_hidden=false, $usr_exceptions=null) {
    
    // this should only reflect files in the scope of this app (localhost).
    $exceptions = array(
        '.localhost',
        'docs',
        '000-default',
        'phpinfo.php',
        'index.php',
        'favicon.ico',
    );
    
    if ($usr_exceptions !== null) {
        $exceptions = array_merge($exceptions, $usr_exceptions);
    }
    
    $dir = dir($directory_path);
    
    $files = array();
    while ($filename = $dir->read()) {
                     
        if (substr($filename, -1) == '~') continue;
        if ($show_hidden === false) {
            if (preg_match('/^\./', $filename)) continue;
        }
        if (!in_array($filename, $exceptions)) {
            if (is_dir($filename)) {
                $file["type"] = 'dir';
                $file["name"] = $filename;
            } else {
                $file["type"] = 'file';
                $file["name"] = $filename;
            }
            $files[] = $file;
        }
    }
    $dir->close();

    sort($files);

    return $files;
}

/**
 * Short description
 * 
 * @param array $subject
 * @return string|array[]
 */
function parse($subject)
{
    $listing = trim($subject);
    
    if (is_dir($listing)) {
        $resource = listIt($listing);
        $subdir = basename($listing);
    }
    elseif (strpos($listing, '.md') || strpos($listing, '.markdown')) {
        $markdown = file_get_contents($listing);
        $resource = Markdown($markdown);
        $subdir = null;
    } 
    else {
        $resource = file_get_contents($listing);
        $subdir = null;
    }
    
    return array($resource, $subdir);
}

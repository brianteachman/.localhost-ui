<?php
/**
 * localhost interface.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://som.zoy.org/wtfpl/COPYING>
 */
include '.localhost.php';

echo head('Simple localhost Interface: Doc Files');

flash_messenger();

if (isset($_GET["list"])) {

    list($resource, $subdir) = parse($_GET["list"]);
    
    if (is_array($resource)) {

        $file_meta = array(
            'id' => 'module',
            'title' => 'Docs-file Handler',
            'tagline' => PEAR_DOC_PATH,
            'slug' => 'docs.php?list=' . PEAR_DOC_PATH,
        );
        if (isset($subdir)) {
            $file_meta["title"] = ucfirst($subdir);
            $file_meta["tagline"] .= "$subdir/";
            $file_meta["slug"] .= "$subdir/";
        }
        echo list_module($resource, $file_meta);
    } else {

        echo $resource ;
    }
    
} else {

    $files = listIt( CURRENT_DIR );
    $file_meta = array(
        'id' => 'module',
        'title' => 'Local Docs',
        'tagline' => 'Listing: ' . getcwd(),
        'slug' => 'docs.php?list=',
    );
    echo list_module($files, $file_meta);

    $pear = listIt( PEAR_DOC_PATH );
    $pear_meta = array(
        'id' => 'module',
        'title' => 'PEAR Docs',
        'tagline' => 'Listing: ' . PEAR_DOC_PATH,
        'slug' => 'docs.php?list=' . PEAR_DOC_PATH,
    );
    echo list_module($pear, $pear_meta);
}

echo foot();
?>

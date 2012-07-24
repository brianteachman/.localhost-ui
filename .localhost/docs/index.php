<?php
/**
 * localhost interface.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://som.zoy.org/wtfpl/COPYING>
 */
include '../.localhost.php';

echo head('Simple localhost Interface: Doc Files');

flash_messenger();

$files = listIt( CURRENT_DIR );
$file_meta = array(
    'id' => 'module',
    'title' => 'Local Docs',
    'tagline' => 'Listing: ' . getcwd(),
//     'slug' => 'handler.php?list=',
);
echo list_module($files, $file_meta);

$pear = listIt( PEAR_DOC_PATH );
$pear_meta = array(
    'id' => 'module',
    'title' => 'PEAR Docs',
    'tagline' => 'Listing: ' . PEAR_DOC_PATH,
    'slug' => 'handler.php?list=' . PEAR_DOC_PATH,
);
echo list_module($pear, $pear_meta);

echo foot();
?>

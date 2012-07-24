<?php
/**
 * Simple localhost interface.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://sam.zoy.org/wtfpl/COPYING>
 */
include('.localhost.php');

$files = listIt( CURRENT_DIR );
$virtual_host = listIt( VHOST );

echo head('Simple localhost interface');

$files = listIt( CURRENT_DIR );
$file_meta = array(
    'id' => 'module',
    'title' => 'localhost',
    'tagline' => 'Listing: ' . getcwd(),
//     'slug' => 'handler.php?list=',
);
echo list_module($files, $file_meta);

$vhost_meta = array(
    'id' => 'module',
    'title' => 'VirtualHost',
    'tagline' => 'Site Development',
    'slug' => 'http://',
);
echo list_module($virtual_host, $vhost_meta, 'vhost');

echo foot();
?>

<?php
/**
 * Simple localhost interface.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://sam.zoy.org/wtfpl/COPYING>
 */
include('.localhost.php');

echo head('Simple localhost interface');

flash_messenger();

$files = listIt( CURRENT_DIR );
$file_meta = array(
    'title' => 'localhost',
    'tagline' => 'Listing: ' . getcwd(),
//     'slug' => '',
);
echo list_module($files, $file_meta);

$virtual_host = listIt( VHOST );
$vhost_meta = array(
    'title' => 'VirtualHost',
    'tagline' => 'Site Development',
    'slug' => 'http://',
);
echo list_module($virtual_host, $vhost_meta, 'vhost');

echo foot();
?>

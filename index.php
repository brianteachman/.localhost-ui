<?php
/**
 * Simple localhost landing page.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://sam.zoy.org/wtfpl/COPYING>
 */
define('PAGE_TITLE', 'Simple localhost Landing Page');
define('FILE_DIR', '.');
define('VHOST', '/etc/apache2/sites-enabled');
define('PHP_INFO', 'localhost/phpinfo.php');
/**
 * @param string $directoryPath Path to directory
 * @return array $files Array of file or directory listings
 */
function getFileListing($directoryPath) {

    $dir = dir($directoryPath);

    while ($filename = $dir->read()) {
        if ($filename != '.' 
            && $filename != '..' 
            && substr($filename, -1) != '~'
            && $filename != '.assets'
            && $filename != '000-default'
            && $filename != 'phpinfo.php'
        ) {
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

$files = getFileListing( FILE_DIR );
$virtualHost = getFileListing( VHOST );
?>
<DOCTYPE html>
<html>
    <head>
        <title>localhost >> <?php echo PAGE_TITLE ?></title>
        <style>
        body { 
            background-color: #CCCCFF; 
            color: #333333; 
        }
        h1 { 
            padding: .5em 1em .25em; 
            background-color: #E6E6FF; 
        }
        a { color: #996600; }
        div.listing {
            float: left;
            margin-left: 0.5em;
        }
        .listing h2, .listing p, h1 { text-align: center; }
        .listing a { 
            display: block;
        }
        span.link {
            vertical-align: super;
        }
        li.dir { list-style-image: url("/.assets/folder.png"); }
        li.file { list-style-image: url("/.assets/paper.png"); }
        li.vhost { list-style-image: url("/.assets/glitter.png"); }
        li { 
            height: 24px;
            background-color: #FFFFCC;
            padding: .25em;
            margin: 5px 0px;
        }
        </style>
    </head>
    <body>
        <h1><?php echo PAGE_TITLE ?></h1>
        
        <div>
            <a href="http://localhost/phpmyadmin/" target="_blank">phpMyAdmin</a>
            | <a href="http://<?php echo PHP_INFO ?>" target="_blank">phpinfo()</a>
        </div>
        
        <div class="container">
            <div id="localhost" class="listing">
                <h2>localhost</h2>
                <hr>
                <p>Web root: <?php echo getcwd(); ?></p>
                <ul>
                <?php foreach($files as $listing): ?>
                    <li class="<?php echo $listing["type"] ?>">
                        <a href="<?php echo $listing["name"] ?>" target="_blank">
                            <span class="link"><?php echo $listing["name"] ?></span>
                        </a>
                    </li>
                <?php endforeach;?>
                </ul>
            </div>
            
            <div id="virtualhost" class="listing">
                <h2>VirtualHost</h2>
                <hr>
                <p>Site Development</p>
                <ul>
                <?php foreach($virtualHost as $vhost): ?>
                    <li class="vhost">
                        <a href="http://<?php echo $vhost["name"] ?>" target="_blank">
                            <span class="link"><?php echo $vhost["name"] ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </body
</html>

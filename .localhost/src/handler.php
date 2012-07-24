<?php
require('../.localhost.php');

if (isset($_GET["list"])) {

    list($resource, $subdir) = parse($_GET["list"]);
    
} else {
//     trigger_error("The handler must be provided a resource...", E_USER_WARNING);
    $_SESSION["message"] = 'The handler must be provided a resource...';
    header("Location: index.php");
}

echo head('Doc Handler');

if (is_array($resource)) {

    $file_meta = array(
        'id' => 'module',
        'title' => 'Docs-file Handler',
        'tagline' => PEAR_DOC_PATH,
        'slug' => 'handler.php?list=' . PEAR_DOC_PATH,
    );
    if(isset($subdir)) {
        $file_meta["title"] = ucfirst($subdir);
        $file_meta["tagline"] .= "$subdir/";
        $file_meta["slug"] .= "$subdir/";
    }
    echo list_module($resource, $file_meta);
} else {

    echo $resource ;
}

echo foot();
?>

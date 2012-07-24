<?php

if ($curlInfo = curl_version()) {
    echo '<pre>';
    var_dump($curlInfo);
    echo '</pre>';
} else {
    echo '<p>curl doesnt work!</p>';
}
?>

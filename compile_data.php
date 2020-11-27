<?php
$path = "/home/pi/internet-report/data/";

if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;

        $content = file_get_contents($path.$file);
        $exploded_content = explode(PHP_EOL, $content);
        $date = explode('_', $exploded_content[0]);
        unset($exploded_content[0]);
        var_dump($exploded_content);
        var_dump($date);
    }
    closedir($handle);
}
<?php
$path = "/home/pi/internet-report/data/";

if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;

        $content = file_get_contents($path.$file);
        $temp = explode(PHP_EOL, $content);
        var_dump($temp);
    }
    closedir($handle);
}
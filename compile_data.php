<?php
$path = "/home/pi/internet-report/data";

if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;

        $content = file_get_contents($file)

        var_dump($content);
    }
    closedir($handle);
}
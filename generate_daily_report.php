<?php
$path = "/home/pi/internet-report/data_json/";
$return = [];
$today = date('d-m-Y');
$i = 0;
if ($handle = opendir($path)) {
    $daily_report = [];
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        $content = json_decode(file_get_contents($path.$file));
        $upload = 0;
        $download = 0;
        $i = 0;
        $date = explode(" ", $content[0]->report->datetime)[0];
        foreach($content as $line){
            $upload += (!empty($line->report->values->upload))? $line->report->values->upload : 0;
            $download += (!empty($line->report->values->download))? $line->report->values->download : 0;
            $i++;
        }
        $upload /= $i;
        $download /= $i;
        $daily_report[] = array("date" => $date, "upload" => $upload, "download" => $download);
    }
}
file_put_contents("/home/pi/internet-report/data_daily/report_".$today.".json", json_encode($daily_report));
closedir($handle);
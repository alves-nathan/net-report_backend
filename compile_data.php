<?php
$path = "/home/pi/internet-report/data/";
$return = "";
$today = date('d-m-Y');
if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        $content = explode(PHP_EOL, file_get_contents($path.$file));
        $date = explode('_', $content[0]);
        $return = "{";
        array_splice($content, 0, 1);
        foreach($content as $line){
            $return .= "report:{";
            $return .= "datetime:'".$date[1].'/'.$date[0].'/'.$date[2].' '.$date[3].':'.$date[4]."',";
            $return .= "values:{"
            $exploded_line = explode(" ", $line);
            $type = "";
            $value = "";
            foreach ($exploded_line as $word){
                if(!empty($word)){
                    if(strpos($word, ".")){
                        $value = $word;
                    } else {
                        $type = strtolower($word);
                    }
                }
                $return .= $type.':'.$value;
            }
            $return .= "}";
        }
        $return .= "}";
        //unset($path.$file);
    }
    file_put_contents("/home/pi/internet-report/data_json/report_".$today.".json");
    closedir($handle);
}
<?php
$path = "/home/pi/internet-report/data/";
$return = [];
$today = date('d-m-Y');
$i = 0;
if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        $content = explode(PHP_EOL, file_get_contents($path.$file));
        $date = explode('_', $content[0]);
        array_splice($content, 0, 1);
        $return[$i]["report"] = [];
        $return[$i]["report"]["datetime"] = $date[1].'/'.$date[0].'/'.$date[2].' '.$date[3].':'.$date[4];
        $json_line = [];
        foreach($content as $line){
            $line = trim($line);
            if(!empty($line) && !(strpos($line, "Operadora"))){
                $exploded_line = explode(" ", $line);
                $type = "";
                $value = "";
                foreach ($exploded_line as $word){
                    if(!empty($word)){
                        if(strpos($word, ".")){
                            $value = $word;
                        } else if ($word == 'Download' || $word == 'Upload') {
                            $type = strtolower($word);
                        }
                    }
                }
            } elseif(strpos($line, "Operadora")){
                $value = "";
                $type = "";
            }
            if(!empty($type) && !empty($value)){
                $json_line[$type] = $value;
            }
        }
        $return[$i]["report"]["values"] = $json_line;
        //unset($path.$file);
        $i++;
    }

    var_dump($return);
    //file_put_contents("/home/pi/internet-report/data_json/report_".$today.".json", json_encode($return));
}
closedir($handle);
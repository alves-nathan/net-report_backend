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
        echo("<<<<<<<<<<<<<<<<<INSIDE WHILE>>>>>>>>>>>>>>>>>>".PHP_EOL);
        var_dump($content);
        $return .= "report:{";
        $return .= "datetime:'".$date[1].'/'.$date[0].'/'.$date[2].' '.$date[3].':'.$date[4]."',";
        $json_line = "values:{";
        foreach($content as $line){
            $line = trim($line);
            var_dump($line);
            echo("<><><><><><><><><><><><><><><><><><><><><><><>".PHP_EOL);
            if(!empty($line) && !(strpos($line, "Operadora"))){
                echo("<<<<<<<<<<<<<<<<<INSIDE FOREACH 1>>>>>>>>>>>>>>>>>>".PHP_EOL);
                $exploded_line = explode(" ", $line);
                $type = "";
                $value = "";
                var_dump($exploded_line);
                foreach ($exploded_line as $word){
                    var_dump($word);
                    if(!empty($word)){
                        echo("!empty(word)".PHP_EOL);
                        if(strpos($word, ".")){
                            echo("strpos(word, ".")".PHP_EOL);
                            $value = $word;
                        } else if ($word == 'Download' || $word == 'Upload') {
                            echo("word == 'Download' || word == 'Upload'".PHP_EOL);
                            $type = strtolower($word);
                        }
                        var_dump($type);
                        var_dump($value);
                    }
                }
            } elseif(strpos($line, "Operadora")){
                $json_line .= "}";
                $value = "";
                $type = "";
            }
            $json_line .= $type.':'.$value . ",";
            var_dump($json_line);
        }
        $return .= $json_line;
        $return .= "}";
        //unset($path.$file);
    }
    file_put_contents("/home/pi/internet-report/data_json/report_".$today.".json", $return);
    closedir($handle);
}
<?php

$file_path = "access.log";
$ip=array();
$p='/^(\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3})\s-\s(.*)\s\[(.*)\]\s"(.*)\"\s(\d{3})\s(\d+)\s"(.*)"\s\"(.*)\"(.*)$/u';
if (file_exists($file_path)) {
    $file_arr = file($file_path);
    for ($i = 0; $i < count($file_arr); $i++) {
        preg_match_all($p,$file_arr[$i],$acc[$i]);
        $acc[$i][9][0]=0;
        $ip[$i]=$acc[$i][1][0];
    }
}

$times = array_count_values($ip);
arsort($times);
echo "The 10 ip addresses with the most access requests:"."<br>"."<br>";
$t=0;
foreach($times as $k=>$v){
    echo $k."<br/>";
    $t++;
    if($t==10){
        echo "<br/>";
        break;
    }
}

$p1='/GET|POST/';
$p2='/HTTP.1../';
$p3='/2..|3../';
$p4='/http...trgo/';
$p5='/Mozilla|AppleWebKit|Chrome|Safari/';
for ($i = 0; $i < count($file_arr); $i++){
    if(!preg_match($p1,$acc[$i][4][0])){
        $acc[$i][9][0]++;
    }
    if(!preg_match($p2,$acc[$i][4][0])){
        $acc[$i][9][0]++;
    }
    if(!preg_match($p3,$acc[$i][5][0])){
        $acc[$i][9][0]++;
    }
    if(!preg_match($p4,$acc[$i][7][0])){
        $acc[$i][9][0]++;
    }
    if(!preg_match($p5,$acc[$i][8][0])){
        $acc[$i][9][0]++;
    }
}
for ($i = 0; $i < count($file_arr); $i++){
    if($acc[$i][9][0]>2){
        echo "Malicious access:  ".$acc[$i][0][0]."<br>";
    }
}
?>

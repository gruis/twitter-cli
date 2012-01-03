#!/usr/bin/php
<?php
date_default_timezone_set('Asia/Tokyo');
$ops = getopt("s:h::c:");

if(isset($ops["h"])){
?>
 <?php echo $argv[0] ?> [-s search] [-c count]
      -s      Specify the search query(s); seperate multiple queries with commas (,)
      -h      Print help message and exit
      -c      The number of messages to show show *default* 20
<?php
exit;
}


$rss  = array();
$os   = isset($ops["s"]) ? $ops["s"] : "javascript";
$c = isset($ops["c"]) ? $ops["c"] : 20;

foreach(explode(",",$os) as $s){
  $s  = urlencode(trim($s));
  $rs = json_decode(html_entity_decode(`curl -s http://twitter.com/search.json?q=$s&count=$c`,null,"UTF-8"), "assoc");

    if(array_key_exists("results", $rs)){
        foreach($rs["results"] as $r){
          $rss[htmlspecialchars_decode($r["text"]) . "   -- @". $r["from_user"]] = strtotime($r["created_at"]);
        }
    }

}


if(!count($rss))
  exit();


arsort($rss);
if(count($rss) < $c)
  $c = count($rss);
  
?>
===-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-===
          Twitter: <?php echo $os ?>

===-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-===
<?php
$i = 0;
foreach($rss as $m => $t){
  echo "$m\n";
  if($i >= $c)
    exit;
  $i++;
}

?>
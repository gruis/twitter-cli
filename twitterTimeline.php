#!/usr/bin/php
<?php

$ops = getopt("u:h::c:");

if(isset($ops["h"])){
?>
 <?php echo $argv[0] ?> [-u user] [-c count]
      -u      Specify the user's timeline to retrieve
      -c      The number of messages to retrieve *default* 10
      -h      Print help message and exit
<?php
exit;
}



$u = isset($ops["u"]) ? $ops["u"] : "calebcrane";
$c = isset($ops["c"]) ? $ops["c"] : 10;

$rs = json_decode(html_entity_decode(`curl -s http://twitter.com/statuses/user_timeline/$u.json?count=$c`,null,"UTF-8"), "assoc");

fwrite(fopen("php://stderr","w"), "http://twitter.com/statuses/user_timeline/$u.json?count=$c\n");

if(!count($rs))
  exit;

?>
===-==-==-==-==-==-==-==-==-==-==-==-===
          Twitter: @<?php echo $u ?>
          
===-==-==-==-==-==-==-==-==-==-==-==-===
<?php
foreach($rs as $r){
  echo  htmlspecialchars_decode($r["text"]) . "   -- @". $r["user"]["name"] ."\n";
}

?>
#!/usr/bin/php
<?php

$ops = getopt("u:h::c:p:");

if(isset($ops["h"])){
?>
 <?php echo $argv[0] ?> [-u user] [-p password] [-c count]
      -u      Specify the user's timeline to retrieve
      -p      The user's password
      -c      The number of messages to retrieve *default* 10
      -h      Print help message and exit
<?php
exit;
}



$u = isset($ops["u"]) ? $ops["u"] : "username";
$p = isset($ops["p"]) ? $ops["p"] : "password";
$c = isset($ops["c"]) ? $ops["c"] : 20;

$rs = json_decode(html_entity_decode(`curl -s --basic --user $u:$p http://twitter.com/statuses/friends_timeline.json?count=$c`,null,"UTF-8"), "assoc");

fwrite(fopen("php://stderr","w"), "$u:$p http://twitter.com/statuses/friends_timeline.json?count=$c\n");

if(!count($rs))
  exit;
?>
===-==-==-==-==-==-==-==-==-==-==-==-===
          Twitter
===-==-==-==-==-==-==-==-==-==-==-==-===
<?php
foreach($rs as $r){
  echo  htmlspecialchars_decode($r["text"]) . "   -- @". $r["user"]["name"] ."\n";
}

?>
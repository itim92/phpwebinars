#!/usr/bin/env php
<?php

$cmd_postfix = (string) ($argv[1] ?? '');

$output = [];
exec('docker-compose ps --filter "name=phpwebinars"', $output);
$output = implode("\n", $output);
$matches = [];
preg_match("/\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}:\d{3,6}/im", $output, $matches);

if (1 !== count($matches)) {
    exit('some error with docker ps info');
}

$host_and_port = $matches[0];
$host_and_port = explode(':', $host_and_port);
$host = $host_and_port[0];
$port = $host_and_port[1];


//$title_row = array_shift($output);
//$title_row = explode("        ", $title_row);
//var_dump($matches);

$dbname = 'phpwebinars';
$username = 'phpwebinars';
$user_password = '1';

$cmd = "\nmycli -u{$username} -p{$user_password} -h{$host} -P{$port} {$dbname}\n";

//if ($cmd_postfix) {
    exit($cmd);
//} else {
//    exec($cmd);
//}
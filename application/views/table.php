<?php

defined('BASEPATH') OR exit('No direct script access allowed');

echo PHP_EOL . cli_color("Table of multiplied first 10 primes:", "green") . PHP_EOL;

echo str_repeat("=", 66) . PHP_EOL;

echo "|    |";

foreach ($primes AS $p) {
    
    echo cli_color($p, 'yellow', cli_cell($p, 5, 'center')) . "|";
    
}

echo PHP_EOL;

echo str_repeat("=", 66) . PHP_EOL;

foreach ($primes AS $kr => $pr) {
    
    echo "|" . cli_color($pr, 'yellow', cli_cell($pr, 4, 'center')) . "|";
    
    foreach ($primes AS $kc => $pc) {
        
        echo (!empty($table[$kr][$kc])) ? (($kr === $kc ) ? cli_color($table[$kr][$kc], 'cyan', cli_cell($table[$kr][$kc], 5, 'center')) . "|" : cli_cell($table[$kr][$kc], 5, 'center') . "|") : cli_cell($table[$kc][$kr], 5, 'center') . "|";
        
    }
    
    echo PHP_EOL;
    
    echo str_repeat("=", 66) . PHP_EOL;
    
}


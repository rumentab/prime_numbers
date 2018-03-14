<?php

defined('BASEPATH') OR exit('No direct script access allowed');

echo PHP_EOL . cli_color("Test results:", "yellow") . PHP_EOL;

echo str_repeat("=", 117) . PHP_EOL;

echo "|" . cli_cell($header[0], 40, 'center') . "|" . cli_cell($header[1], 20, 'center');

echo "|" . cli_cell($header[2], 20, 'center') . "|" . cli_cell($header[3], 10, 'center');

echo "|" . cli_cell("Notes", 10, 'center') . "|" . cli_cell("Time", 10, 'center');

echo "|" . PHP_EOL;

echo str_repeat("=", 117) . PHP_EOL;

$notes = [];

foreach ($data AS $d) {
    
    if (!empty($d['Notes'])) {
        array_push($notes, $d['Notes']);
        $note = key(end($notes)) + 1;
    } else {
        $note = "-";
    }
    
    $test_status = ($d['Result'] === 'Failed') ? cli_color($d['Result'], 'red', cli_cell($d['Result'], 10, 'right')) : cli_color($d['Result'], 'green', cli_cell($d['Result'], 10, 'right'));

    echo "|" . cli_cell($d['Test Name'], 40) . "|" . cli_cell($d['Test Datatype'], 20, 'right');

    echo "|" . cli_cell($d['Expected Datatype'], 20, 'right') . "|" . $test_status;

    echo "|" . cli_cell($note, 10, 'center') . "|" . cli_cell(round($benchmark_data[$d['Test Name']]['time']*100, 3) . ' ms', 10, 'right');
    
    echo "|" . PHP_EOL;
    
    echo str_repeat("=", 117) . PHP_EOL;
    
}

if (!empty($notes)) {
    echo cli_color("Notes:", "cyan") . PHP_EOL;
    foreach ($notes AS $k=>$n) {
        echo cli_cell(($k+1), 3) . ". " . $n . PHP_EOL;
    }
}

echo cli_color("Total memory used for the tests: " . $benchmark_data['total_memory'] . " MB", 'cyan') . PHP_EOL;

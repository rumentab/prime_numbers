<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends CI_Controller {
    
    private $benchmark_data = [];

    public function __construct() {
        parent::__construct();

        $this->load->library(['unit_test' => 'unit', 'primeNumber' => 'prime']);
        
        $this->unit->use_strict(TRUE);
        
        $this->load->helper('cli');
        
        $this->testTest();
        
        $this->checkPrime(11);
        
        $this->checkPrime(25);
        
        $this->checkPrime(57641);
        
        $this->arrayLength(10);
        
        $this->primesArray(10, [2, 3, 5, 7, 11, 13, 17, 19, 23, 29]);
        
    }

    /**
     * display the result of tests
     * 
     * @param bool $cli CLI or browser
     */
    public function index() {
        
        if (PHP_SAPI === "cli") {

            $data = $this->unit->result();
            
            $header = array_keys($data[0]);
            
            $this->benchmark_data['total_memory'] = round(memory_get_peak_usage() / 1024**2, 2);

            $this->load->view('test_results_cli', ['data' => $data, 'header' => $header, 'benchmark_data' => $this->benchmark_data]);
            
        } else {
            
            $result = $this->unit->report();
            
            $this->load->view('test_results_html', ['result' => $result]);
        }
    }

    /**
     * test if Unit test library is working correctly
     */
    public function testTest() {
        
        $this->benchmark->mark("testTests_start");
        
        $test = 1 + 1;

        $expected_result = 2;

        $test_name = 'Test library OK';

        $this->unit->run($test, $expected_result, $test_name);
        
        $this->benchmark->mark("testTests_end");
        
        $this->benchmark_data[$test_name] = [
            'time' => $this->benchmark->elapsed_time("testTests_start", "testTests_end", 5)
        ];
        
    }
    
    /**
     * Check if an integer is prime
     * 
     * @param int $int
     */
    public function checkPrime($int) {
        
        $this->benchmark->mark("checkPrime_start");
        
        if (method_exists($this->prime, 'isPrime')) {
            
            $test = $this->prime->isPrime($int);
            
        } else {
            
            $test = 0;
            
        }
        
        $expected_result = TRUE;
        
        $test_name = "Prime ckeck for $int";
        
        $this->unit->run($test, $expected_result, $test_name);
        
        $this->benchmark->mark("checkPrime_end");
        
        $this->benchmark_data[$test_name] = [
            'time' => $this->benchmark->elapsed_time("checkPrime_start", "checkPrime_end", 6)
        ];
        
    }

    /**
     * Check array with primes length
     * 
     * @param int $length length of the array with generated primes
     */
    public function arrayLength($length) {
        
        $this->benchmark->mark("arrayLength_start");
        
        if (method_exists($this->prime, 'generatePrimes')) {
            $test = count($this->prime->generatePrimes($length));
        } else {
            $test = 0;
        }
        
        $expected_result = $length;
        
        $test_name = "Check primes array length";
        
        $this->unit->run($test, $expected_result, $test_name);
        
        $this->benchmark->mark("arrayLength_end");
        
        $this->benchmark_data[$test_name] = [
            'time' => $this->benchmark->elapsed_time("arrayLength_start", "arrayLength_end", 5)
        ];
        
    }
    
    /**
     * Check array with primes length
     * 
     * @param int $length length of the array with generated primes
     * @param array $primes expected array of primes
     */
    public function primesArray($length, array $primes) {
        
        $this->benchmark->mark("primesArray_start");

        if (method_exists($this->prime, 'generatePrimes')) {
            $test = $this->prime->generatePrimes($length);
        } else {
            $test = 0;
        }
        
        $expected_result = $primes;
        
        $test_name = "Verify primes array";
        
        $this->unit->run($test, $expected_result, $test_name);
        
        $this->benchmark->mark("primesArray_end");
        
        $this->benchmark_data[$test_name] = [
            'time' => $this->benchmark->elapsed_time("arrayLength_start", "arrayLength_end", 5)
        ];

    }

}

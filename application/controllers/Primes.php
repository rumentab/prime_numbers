<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Primes extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('primeNumber', NULL, 'primes');
        
        $this->load->helper('cli');
        
    }

    public function index($length = 10) {

        $primes = $this->primes->generatePrimes($length);
        
        $table = [];

        for ($i = 0; $i < $length; $i ++) {

            for ($j = $i; $j < $length; $j ++) {
                
                $table[$i][$j] = $primes[$i] * $primes[$j];
                
            }
            
        }
        
        $this->load->view("table", ['primes' => $primes, 'table' => $table]);
        
    }

}

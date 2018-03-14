<?php

/**
 * Description of PrimeNumber
 *
 * @author Rumen Tabakov
 */
class PrimeNumber {

    /**
     * Check if an iteger is prime
     * @param type $int
     * @return int
     */
    public function isPrime($int) {
        $this->generateFibonaciRow(($int + 1));
        // Prime numbers are bigger than 1 and 2 is the smallest and the only even prime number
        if ($int !== 2 && ($int < 2 || $int % 2 === 0)) {

            return 0;
        }

        // For numbers less than or = to 100 we use the Sieve of Eratosthenes for speed
        if ($int <= 100) {
            $primes = $this->sieveOfEratosthenes();
            return in_array($int, $primes);
        } else {

            // Optimized (6k+-1) test
            if ($int % 2 === 0 || $int % 3 === 0) {

                return FALSE;
            }

            $i = 5;

            while ($i * $i < $int) {

                if ($int % $i === 0 || $int % ($i + 2) === 0) {

                    return FALSE;
                }

                $i += 6;
            }

            return TRUE;
        }
    }

    private function sieveOfEratosthenes() {
        
        $i = 2;

        $result = array_fill(2, 99, 1); // 2-100 incl.

        for ($i; $i < 11; $i++) {

            $pow = pow($i, 2);

            if (isset($result[$pow])) {

                unset($result[$pow]);
            }

            while ($pow <= 100) {

                $pow += $i;

                if (isset($result[$pow])) {

                    unset($result[$pow]);
                }
            }
        }

        return array_keys($result);
    }

    private function generateFibonaciRow($length) {

        $row = [0, 1];

        if ($length <= 2 && $length > 0) {

            return $row[($length - 1)];
            
        } elseif ($length < 1) {

            return NULL;
            
        }

        while (count($row) <= $length) {

            end($row);

            $last = current($row);

            prev($row);

            $penult = current($row);

            array_push($row, ($penult + $last));

            reset($row);
        }

        return array_pop($row);
        
    }

    public function generatePrimes($length) {

        $erathostenes_sequence = $this->sieveOfEratosthenes();

        // Erathostenes sequence contains 25 elements for numbers <= 100
        if ($length <= 25) {

            return array_slice($erathostenes_sequence, 0, $length);
            
        }

        // 2 is the smallest prime number, 3 is next
        $result = $erathostenes_sequence;

        while (count($result) <= $length) {

            end($result);

            $last = current($result) + 2;

            while (!$this->isPrime($last)) {

                $last += 2;
            }

            array_push($result, $last);
            
        }
        
        return $result;
        
    }

}

<?php
$int_limit = 1000000;
$result = 0;
$numberOfPrimes = 0;
$data = 0;
$primes = sieve($int_limit);
array_splice($primes,0,1);
$primeSum = cummulativeSum($primes);
//array_unshift($primeSum,0);
//$primeSum =array_slice($primeSum, 0, count($primes));
$prime_number = 0;
for ($i = 0; $i < count($primeSum); $i++) {
    for ($j = $i-($numberOfPrimes+1); $j >= 0; $j--) {
        if ($primeSum[$i] - $primeSum[$j] > $int_limit) break;
        $binary = binarySearch($primes, $primeSum[$i] - $primeSum[$j]);
        if(!empty($binary) && $binary > 0){
            $data = $primeSum[$i] - $primeSum[$j];
            if($data >= $result) {
                $numberOfPrimes = $i - $j;
                $result = $primeSum[$i] - $primeSum[$j];
            }
        }
    }
}
echo 'Number of Terms : '.$numberOfPrimes.'</br>';
echo 'Prime Numbers: '.$result.'</br>';
die;

function binarySearch($array, $value) {

    $left = 0;

    $right = count($array) - 1;

    while ($left <= $right) {

        $midpoint = (int) floor(($left + $right) / 2);

        if ($array[$midpoint] < $value) {

            $left = $midpoint + 1;
        } elseif ($array[$midpoint] > $value) {

            $right = $midpoint - 1;
        } else {
            return $midpoint;
        }
    }

    return NULL;
}

function cummulativeSum($original)
{
    $total = array();
    $runningSum = 0;
    foreach ($original as $number) {
        $runningSum += $number;
        $total[] = $runningSum;
    }
    return $total;
}

function sieve($n) {
    $limit = intval(sqrt($n));
    $A = array_fill(0, $n, true);
    for ($i = 2; $i <= $limit; $i++) {
        if ($A[$i - 1]) {
            for ($j = $i * $i; $j <= $n; $j += $i) {
                $A[$j - 1] = false;
            }
        }
    }
    $result = array();
    foreach ($A as $i => $is_prime) {
        if ($is_prime) {
            $result[] = $i + 1;
        }
    }
    return $result;
}

function isPrime($num)
{
    if ($num == 2 || $num == 3) { return 1; }
    if (!($num%2) || $num<1)    { return 0; }

    for ($n = 3; $n <= $num/2; $n += 2) {
        if (!($num%$n)) {
            return 0;
        }
    }
    return 1;
}


?>
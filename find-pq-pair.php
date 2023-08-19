<?php

// find-pq-pair.php
// Find p and q suitable for use with demonstrating public/private key maths
//
//'Script to work through pairs of the earliest primes looking for those that
// will pass the Greatest Common Divisor requirement for Public/Private Key
// generation.
// These primes are far, far too low for actual security use, pairs only used
// to work through the maths involved.
//
// This script uses GMP which is not always available. You may need to visit
// https://www.php.net/manual/en/gmp.installation.php
//
// Alistair Mann 2023

// Constants

// Primes from first page on:
// http://compoasso.free.fr/primelistweb/page/prime/liste_online_en.php
define('PRIMES', [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53,
		  59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113,
		  127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181,
		  191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 251,
		  257, 263, 269, 271, 277, 281, 283, 293, 307, 311, 313, 317,
		  331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397,
		  401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463,
		  467, 479, 487, 491, 499, 503, 509, 521, 523, 541, 547, 557,
		  563, 569, 571, 577, 587, 593, 599, 601, 607, 613, 617, 619,
		  631, 641, 643, 647, 653, 659, 661, 673, 677, 683, 691, 701,
		  709, 719, 727, 733, 739, 743, 751, 757, 761, 769, 773, 787,
		  797, 809, 811, 821, 823, 827, 829, 839, 853, 857, 859, 863,
		  877, 881, 883, 887, 907, 911, 919, 929, 937, 941, 947, 953,
		  967, 971, 977, 983, 991, 997, 1009, 1013, 1019, 1021, 1031,
		  1033, 1039, 1049, 1051, 1061, 1063, 1069, 1087, 1091, 1093,
		  1097, 1103, 1109, 1117, 1123, 1129, 1151, 1153, 1163, 1171,
		  1181, 1187, 1193, 1201, 1213, 1217]);

// User input
// --
// false, true, true to get one random pair per pass
// false, false, false to get all pairs that will pass GCD
// true, false, false to get all pairs regardless of GCD
//
// if true, shows pairs that do not pass Greatest Common Divisor
$show_every_f = false;
// if true, show only one pair. If false, show every pair
$finish_early_f = true;
// if true start looking at a random point for pairs
$start_random_place = true;
// --
// if false, adds formatting and GCD result
// if true, show space-separated pair as usable in pipe
$show_just_pair = true;
//
$e = 3; // e is the public key exponent, 3 or 65537
$pidx_startfrom = 2;
$qidx_startfrom = 5;

// Handle starting at a psuedorandom place
if ($start_random_place) {
    $pidx_startfrom = rand($pidx_startfrom, sizeof(PRIMES));
    do
	$qidx_startfrom = rand($qidx_startfrom, sizeof(PRIMES));
    while ($pidx_startfrom === $qidx_startfrom);
}

// Main loop
$found = false;
$pidx = $pidx_startfrom;
$qidx = $qidx_startfrom;
do {
    // Prepare
    $pm1 = PRIMES[$pidx] - 1;
    $qm1 = PRIMES[$qidx] - 1;
    $phi = $pm1 * $qm1;

    // Get greatest common divisors
    // Note I'm choosing to cast back from GMP
    $gcd1 = intval(gmp_gcd($e, $pm1));
    $gcd2 = intval(gmp_gcd($e, $pm1));
    $gcd3 = intval(gmp_gcd($e, $phi));

    // Check if this pair acceptable for PKE
    $found = ($gcd1 === 1 && $gcd2 === 1 && $gcd3 === 1);

    // Report result
    if ($found || $show_every_f)
	if ($show_just_pair)
	    echo PRIMES[$pidx] . " " . PRIMES[$qidx];
	else
	    echo PRIMES[$pidx] . "," . PRIMES[$qidx] . ": $gcd1 $gcd2 $gcd3\n";

    // End on first match, or keep going
    if ($found && $finish_early_f)
	break;

    // Loop through all the primes
    $qidx++;
    if ($qidx === sizeof(PRIMES)) {
	$qidx = $qidx_startfrom;
	$pidx++;
	if ($pidx === sizeof(PRIMES))
	    break;
    }
} while (true);

// Exit
?>

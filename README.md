# Find-pq-pair
Find p and q suitable for use demonstrating public/private key maths

As stands will generate a psuedorandom pair of primes from 2..1217 that will pass the Greatest Common Divisor test
```
$ php find-pq-pair.php
23 1049$
```

Can be adjusted to show all pairs along with the GCD results for each.
To adjust:
```
$show_every_f = true;
$finish_early_f = false;
$start_random_place = false;
$show_just_pair = false;
```

```
$ php find-pq-pair.php 
5,13: 1 1 3
5,17: 1 1 1
5,19: 1 1 3
5,23: 1 1 1
5,29: 1 1 1
5,31: 1 1 3
...
1217,1193: 1 1 1
1217,1201: 1 1 3
1217,1213: 1 1 3
1217,1217: 1 1 1
$ 
```

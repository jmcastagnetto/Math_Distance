<?php
// m can be run after Composer have generated the autoload
require "../vendor/autoload.php";

$v1 = array(0,2,1);
$v2 = array(1,4,5);
$m = new Math\Distance($v1, $v2);

$euclidean = $m->euclidean();
echo "Euclidean distance: $euclidean\n";
$manhattan = $m->manhattan();
echo "Manhattan distance: $manhattan\n";
$chebyshev = $m->chebyshev();
echo "Chebyshev distance: $chebyshev\n";
$minkowski = $m->minkowski(3);
echo "Minkowski distance (order=3): $minkowski\n";

$m->setData('electric', 'tectonic');
$hamming = $m->hamming();
echo "Hamming distance: $hamming\n";

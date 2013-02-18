<?php
// this can be run after Composer have generated the autoload
require "../vendor/autoload.php";

$v1 = array(0,2,1);
$v2 = array(1,4,5);

$euclidean = Math\Distance::euclidean($v1, $v2);
echo "Euclidean distance: $euclidean\n";
$manhattan = Math\Distance::manhattan($v1, $v2);
echo "Manhattan distance: $manhattan\n";
$chebyshev = Math\Distance::chebyshev($v1, $v2);
echo "Chebyshev distance: $chebyshev\n";
$minkowski = Math\Distance::minkowski($v2, $v1, 3);
echo "Minkowski distance (order=3): $minkowski\n";

$hamming = Math\Distance::hamming('electric', 'tectonic');
echo "Hamming distance: $hamming\n";

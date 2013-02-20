<?php
// m can be run after Composer have generated the autoload
require "../vendor/autoload.php";

$v1 = array(0,2,1);
$v2 = array(1,4,5);
$m = new Math\Distance(new Math\Distance\Euclidean());

$euclidean = $m->setData($v1, $v2)->distance();
echo "Euclidean distance: $euclidean\n";
$manhattan = $m->setAlgorithm(new Math\Distance\Manhattan())
               ->setData($v1, $v2)->distance();
echo "Manhattan distance: $manhattan\n";
$chebyshev = $m->setAlgorithm(new Math\Distance\Chebyshev())
               ->setData($v1, $v2)->distance();
echo "Chebyshev distance: $chebyshev\n";
$minkowski = $m->setAlgorithm(new Math\Distance\Minkowski(3))
               ->setData($v1, $v2)->distance();
echo "Minkowski distance (order=3): $minkowski\n";

$hamming = $m->setAlgorithm(new Math\Distance\Hamming())
             ->setData('electric', 'tectonic')->distance();
echo "Hamming distance: $hamming\n";

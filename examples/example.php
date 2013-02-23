<?php
// m can be run after Composer have generated the autoload
require "../vendor/autoload.php";

$vector1 = array(0, 2, 1);
$vector2 = array(1, 4, 5);
$m = new Math\Distance(new Math\Distance\Euclidean());

$euclidean = $m->data($vector1, $vector2)->distance();
echo "Euclidean distance: $euclidean\n";
$manhattan = $m->algorithm(new Math\Distance\Manhattan())->data($vector1, $vector2)
->distance();
echo "Manhattan distance: $manhattan\n";
$chebyshev = $m->algorithm(new Math\Distance\Chebyshev())->data($vector1, $vector2)
->distance();
echo "Chebyshev distance: $chebyshev\n";
$minkowski = $m->algorithm(new Math\Distance\Minkowski(3))->data($vector1, $vector2)
->distance();
echo "Minkowski distance (order=3): $minkowski\n";
$minkowski = $m->algorithm(new Math\Distance\Minkowski(2))->data($vector1, $vector2)
->distance();
echo "Minkowski distance (order=2): $minkowski\n";
$minkowski = $m->algorithm(new Math\Distance\Minkowski(1))->data($vector1, $vector2)
->distance();
echo "Minkowski distance (order=1): $minkowski\n";

$hamming = $m->algorithm(new Math\Distance\Hamming())
->data('electric', 'tectonic')->distance();
echo "Hamming distance: $hamming\n";

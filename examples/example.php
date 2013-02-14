<?php
namespace PEAR2\Math;

$current_path='/home/jesus/devel/jmc/github/PEAR2_Math_Distance';
require_once $current_path.'/src/Math/Distance.php';
require_once $current_path.'/src/Math/Distance/Exception.php';

use PEAR2\Math\Distance;
use PEAR2\Math\Distance\Exception;

$v1 = array(0,2,1);
$v2 = array(1,4,5);

$euclidean = Distance::euclidean($v1, $v2);
$manhattan = Distance::manhattan($v1, $v2);
$chebyshev = Distance::chebyshev($v1, $v2);
$minkowsky = Distance::minkowsky($v1, $v2, 3);

$s1 = 'electric';
$s2 = 'tectonic';
$hamming = Distance::hamming($s1, $s2);

?>

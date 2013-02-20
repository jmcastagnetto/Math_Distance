<?php
namespace Math;
/**
 * Math_Distance
 *
 * @category  Math
 * @package   Math_Distance
 * @author    Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @copyright 2011-2013 Jesús M. Castagnetto
 * @license   http://opensource.org/licenses/bsd-license.php New BSD License
 * @version   1.0.0
 * @link      http://github.com/jmcastagnetto/Math_Distance
 * @since     File available since version 1.0.0
 */

/**
 * Class to calculate common distance metrics
 *
 * It implements methods to compute vector distance metrics
 * (Euclidean, Minkowski, Manhattan and Chebyshev) as well as
 * a string distance metric (Hamming)
 *
 * $v1 = array(0,2,4,5);
 * $v2 = array(1,4,7,2);
 * $m = new Math\Distance();
 * $e = $m->euclidean($v1, $v2);
 * $m = $m->minkowski(4, $v1, $v2);
 * $t = $m->manhattan($v1, $v2);
 * $c = $m->chebyshev($v1, $v2);
 * $s = $m->hamming('1011101','1001001');
 *
 * @category  Math
 * @package   Math_Distance
 * @author    Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @copyright 2011-2013 Jesús M. Castagnetto
 * @license   http://opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://github.com/jmcastagnetto/Math_Distance
 * @since     File available since version 1.0.0
 *
 */
class Distance
{

    protected $v1;
    protected $v2;
    protected $algo;

    public function __construct(Distance\Algorithm $algo) {
        $this->setAlgorithm($algo);
    }

    public function setAlgorithm(Distance\Algorithm $algo){
        $this->algo = $algo;
        return $this;
    }

    public function setData($v1, $v2) {
        if (!is_null($v1) && !is_null($v2)
            && $this->algo->validParameters($v1, $v2)) {
            $this->v1 = $v1;
            $this->v2 = $v2;
        }
        return $this;
    }

    public function distance() {
        return $this->algo->distance($this->v1, $this->v2);
    }

}

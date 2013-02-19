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

    private $v1;
    private $v2;

    public function __construct($v1=null, $v2=null) {
        $this->setData($v1, $v2);
    }

    public function setData($v1, $v2) {
        if (!is_null($v1) && !is_null($v2)
            && $this->_compatibleData($v1, $v2)) {
            $this->v1 = $v1;
            $this->v2 = $v2;
        }
        return $this;
    }

    /**
     * Private method to check whether we got numeric vectors or strings of identical size
     *
     * @param $v1 first numeric vector or string
     * @param $v2 second numeric vector or string
     *
     * @throws Distance\Distance\Exception if parameters are not vectors or strings
     * @throws Distance\NonNumericException if vectors are not numeric
     * @throws Distance\ImcompatibleItemsException if vectors or strings are of dissimilar size
     * @return boolean true if vectors or strings are of same size
     *
     */
    private function _compatibleData($v1, $v2)
    {
        if (is_array($v1) && is_array($v2)) {
            $f_num = function ($v, $k) {
                if (!is_numeric($v)) {
                    throw new Distance\NonNumericException(
                      'Vectors must contain numeric data, non-numeric item found: '.$v
                    );
                }
            };
            // check that each vector member is of numeric type
            array_walk($v1, $f_num);
            array_walk($v2, $f_num);

            // check it both vectors have the same size
            if (count($v1) === count($v2)) {
                return true;
            } else {
                throw new Distance\IncompatibleItemsException(
                  'Vectors must be of equal size: n1='.count($v1).', n2='.count($v2)
                );
            }
        } elseif (is_string($v1) && is_string($v2)) {
            if (strlen($v1) === strlen($v2)) {
                return true;
            } else {
                throw new Distance\IncompatibleItemsException(
                    'Expecting two strings of equal length'
                );
            }
        } else {
            throw new Distance\Exception(
                "Expecting two arrays of numbers or two strings"
            );
        }
    }

    public function validData($type='array') {
        if (isset($this->v1) && !is_null($this->v1)
            && isset($this->v2) && !is_null($this->v2)) {
            if ($type === 'array') {
                return is_array($this->v1) && is_array($this->v2);
            } elseif ($type === 'string') {
                return is_string($this->v1) && is_string($this->v2);
            } else {
                throw new Distance\Exception("Invalid data: incompatible types");
            }
        } else {
            throw new Distance\Exception("Invalid data: not set or null");
        }
    }

    /**
     * Euclidean distance metric between two vectors
     *
     * The euclidean distance between two vectors (v1, v2) is defined as
     * D = SQRT(SUM((v1(i) - v2(i))^2))  (i = 0..k)
     *
     * Refs:
     * - http://mathworld.wolfram.com/EuclideanMetric.html
     * - http://en.wikipedia.org/wiki/Euclidean_distance
     *
     * @param array $v1 first vector
     * @param array $v2 second vector
     *
     * @throws Distance\NonNumericException if vectors are not numeric
     * @throws Distance\ImcompatibleItemsException if vectors are of dissimilar size
     * @return double The Euclidean distance between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4)) throws Distance\IncompatibleItemsException
     * @assert (array(2,'a',6,7), array(4,5,1,9)) throws Distance\NonNumericException
     * @assert (array(1,2), array(3,4)) == sqrt(8)
     * @assert (array(2,4,6,7), array(4,5,1,9)) == sqrt(4+1+25+4)
     *
     */
    public function euclidean(array $v1=null, array $v2=null)
    {
        $this->setData($v1, $v2);
        if ($this->validData()) {
            $n = count($this->v1);
            $sum = 0;
            for ($i=0; $i < $n; $i++) {
                $sum += ($this->v1[$i] - $this->v2[$i])
                        * ($this->v1[$i] - $this->v2[$i]);
            }
            return sqrt($sum);
        }
    }

    /**
     * Minkowski distance metric between two vectors
     *
     * The Minkowski distance is a generalization of the a metric in
     * Euclidean space and includes as special cases the Euclidean,
     * Manhattan and Chebyshev distances.
     *
     * It is also known as the Lp metric (where p is the metric order)
     *
     * This distance is defined as
     * D = (SUM((v1(i) - v2(i))^p))^(1/p) (i = 0..k)
     * where: p = 1..n
     * when p = 1 => reduces to the Manhattan distance
     * when p = 2 => reduces to the Euclidean distance
     * when p -> infinite => reduces to the Chebyshev distance
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Minkowski_distance
     * - http://xlinux.nist.gov/dads/HTML/lmdistance.html
     * - http://goo.gl/AktXh (Article at code10.info)
     *
     * @param double $order	the Lp metric
     * @param array  $v1	first vector
     * @param array  $v2	second vector
     *
     * @throws Distance\NonNumericException if vectors are not numeric
     * @throws Distance\ImcompatibleItemsException if vectors are of dissimilar size
     * @return double The Minkowski distance of the given order between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4), 2) throws Distance\IncompatibleItemsException
     * @assert (array(0,5,6,9), array(3,4,2,1), 0) throws Distance\Distance\Exception
     * @assert (array(0,5,6,9), array(3,4,2,1), 1) == 16
     * @assert (array(0,5,6,9), array(3,4,2,1), 3) == pow(pow(3,3)+pow(-1,3)+pow(4,3)+pow(-8,3),1/3)
     * @assert (array(0,5,6,9), array(3,4,2,1), 4) == pow(pow(3,3)+pow(-1,3)+pow(4,3)+pow(-8,3),1/4)
     *
     */
    public function minkowski($order=0, array $v1=null, array $v2=null)
    {
        if (0 === $order) {
            throw new Distance\Exception('Minkowski distance order cannot be zero');
        } elseif (1 === $order) {
            return $this->manhattan($v1, $v2);
        } elseif (2 === $order) {
            return $this->euclidean($v1, $v2);
        } else {
            $order = (double) $order;
            $this->setData($v1, $v2);
            if ($this->validData()) {
                $n = count($this->v1);
                $sum = 0;
                for ($i=0; $i < $n; $i++) {
                    $sum += pow(abs($this->v1[$i] - $this->v2[$i]), $order);
                }
                return pow($sum, 1/$order);
            }
        }
    }

    /**
     * Manhattan (aka "Taxicab") distance metric between two vectors
     *
     * The Manhattan (or Taxicab) distance is defined as the sum of the
     * absolute differences between the vector coordinates, and akin to
     * the type of path that one takes when walking around a city block.
     *
     * This distance is defined as
     * D = SUM( ABS(v1(i) - v2(i)) )    (i = 0..k)
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Manhattan_distance
     * - http://xlinux.nist.gov/dads/HTML/manhattanDistance.html
     * - http://mathworld.wolfram.com/TaxicabMetric.html
     *
     * @param array $v1 first vector
     * @param array $v2 second vector
     *
     * @throws Distance\NonNumericException if vectors are not numeric
     * @throws Distance\ImcompatibleItemsException if vectors are of dissimilar size
     * @return double The Manhattan distance between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4)) throws Distance\IncompatibleItemsException
     * @assert (array(3,4,2,1), array(0,5,6,9)) == 16
     * @assert (array(-2,4), array(0,5)) == 3
     *
     */
    public function manhattan(array $v1=null, array $v2=null)
    {
        $this->setData($v1, $v2);
        if ($this->validData()) {
            $n = count($this->v1);
            $sum = 0;
            for ($i=0; $i < $n; $i++) {
                $sum += abs($this->v1[$i] - $this->v2[$i]);
            }
            return $sum;
        }
    }

    /**
     * Chebyshev distance metric between two vectors
     *
     * The Chebyshev distance aka the Maximum metric (L[inf])
     * is the greatest of their differences along any coordinate.
     *
     * This distance is defined as
     * D = MAX( ABS(v1(i) - v2(i)) )  (i = 0..k)
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Chebyshev_distance
     *
     * @param array $v1 first vector
     * @param array $v2 second vector
     *
     * @throws Distance\IncompatibleItemsException if numeric vectors are of different sizes
     * @throws Distance\NonNumericException if vectors are not numeric
     * @return double The Chebyshev distance between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4)) throws Distance\IncompatibleItemsException
     * @assert (array(3,4,2,1), array(0,5,6,9)) == 8
     * @assert (array(-2,4), array(0,5)) == 2
     *
     */
    public function chebyshev(array $v1=null, array $v2=null)
    {
        $this->setData($v1, $v2);
        if ($this->validData()) {
            $n = count($this->v1);
            $diffvals = array();
            for ($i=0; $i < $n; $i++) {
                $diffvals[$i] = abs($this->v1[$i] - $this->v2[$i]);
            }
            return max($diffvals);
        }
    }

    /**
     * Hamming distance between two strings
     *
     * The Hamming distance is defined as the number of positions
     * at which two strings of equal lenght differ
     *
     * Refs:
     * - http://mathworld.wolfram.com/HammingDistance.html
     * - http://en.wikipedia.org/wiki/Hamming_distance
     *
     * @param string $s1 first string
     * @param string $s2 second string
     *
     * @throws Distance\IncompatibleItemsException if parameters are not strings of the same length
     * @return integer the hamming length from s1 to s2
     *
     * @assert ('australopitecus', 'bird') throws Distance\IncompatibleItemsException
     * @assert ('1011101', '1001001') == 2
     * @assert ('chemistry', 'dentistry') == 4
     *
     */
    public function hamming($v1=null, $v2=null)
    {
        $this->setData($v1, $v2);
        if ($this->validData('string')) {
            $res = array_diff_assoc(str_split($this->v1), str_split($this->v2));
            return count($res);
        }
    }
}

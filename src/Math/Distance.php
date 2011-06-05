<?php
/**
 * PEAR2_Math_Distance
 *
 * @category	pear
 * @package		PEAR2_Math_Distance
 * @author		Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @license		http://opensource.org/licenses/bsd-license.php New BSD License
 * @since		File available since version 0.1.0
 * @copyright	2011 The PHP Group
 */
namespace PEAR2\Math;

/**
 * Class to calculate common distance metrics
 *
 * It implements methods to compute vector distance metrics
 * (Euclidean, Minkowski, Manhattan and Chebyshev) as well as
 * a string distance metric (Hamming)
 *
 * $v1 = array(0,2,4,5);
 * $v2 = array(1,4,7,2);
 * $e = \PEAR2\Math\Distance::euclidean($v1, $v2);
 * $m = \PEAR2\Math\Distance::minkowski($v1, $v2);
 * $t = \PEAR2\Math\Distance::manhattan($v1, $v2);
 * $c = \PEAR2\Math\Distance::chebyshev($v1, $v2);
 * $s = \PEAR2\Math\Distance::hamming('1011101','1001001');
 *
 */
class Distance
{
    /**
     * Private method to check whether we got numeric vectors of identical size
     *
     * @param array $v1 first numeric vector
     * @param array $v2 second numeric vector
     *
     * @throws \PEAR2\Math\Distance\Exception if vectors are not numeric or dissimilar size
     * @return boolean true if vectors are of same size, false if not
     *
     */
    private static function _compatibleData(array $v1, array $v2)
    {
        // check that each vector member is of numeric type
        foreach ($v1 as $item) {
            if (!is_numeric($item)) {
                throw new \PEAR2\Math\Distance\Exception('Vectors must contain numeric data, non-numeric item found: '.$item);
            }
        }
        foreach ($v2 as $item) {
            if (!is_numeric($item)) {
                throw new \PEAR2\Math\Distance\Exception('Vectors must contain numeric data, non-numeric item found: '.$item);
            }
        }
        // check it both vectors have the same size
        return (count($v1) == count($v2));
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
     * @throws \PEAR2\Math\Distance\Exception if numeric vectors are of different sizes
     * @return double The Euclidean distance between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4)) throws \PEAR2\Math\Distance\Exception
     * @assert (array(1,2), array(3,4)) == sqrt(8)
     * @assert (array(2,4,6,7), array(4,5,1,9)) == sqrt(4+1+25+4)
     *
     */
    public static function euclidean(array $v1, array $v2)
    {
        if (Distance::_compatibleData($v1, $v2)) {
            $n = count($v1);
            $sum = 0;
            for ($i=0; $i < $n; $i++) {
                $sum += ($v1[$i] - $v2[$i]) * ($v1[$i] - $v2[$i]);
            }
            return sqrt($sum);
        } else {
            throw new \PEAR2\Math\Distance\Exception('Incompatible vector sizes');
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
     * @param array  $v1	first vector
     * @param array  $v2	second vector
     * @param double $order	the Lp metric
     *
     * @throws \PEAR2\Math\Distance\Exception if numeric vectors are of different sizes
     * @return double The Minkowski distance of the given order between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4), 2) throws \PEAR2\Math\Distance\Exception
     * @assert (array(3,4,2,1), array(0,5,6,9), 3) == pow(pow(3,3)+pow(1,3)+pow(4,3)+pow(8,3),1/3)
     * @assert (array(3,4,2,1), array(0,5,6,9), 4.2) == pow(pow(3,3)+pow(1,3)+pow(4,3)+pow(8,3),1/4.2)
     *
     */
    public static function minkowski(array $v1, array $v2, $order=0)
    {
        switch ($order) {
            case 0 : // undefined
                throw new \PEAR2\Math\Distance\Exception('Minkowski distance order cannot be zero');
                break;
            case 1 : // reduces to the Manhattan distance
                return Distance::manhattan($v1, $v2);
                break;
            case 2 :
                return Distance::euclidean($v1, $v2);
                break;
            default :
                $order = (double) $order;
                if (Distance::_compatibleData($v1, $v2)) {
                    $n = count($v1);
                    $sum = 0;
                    for ($i=0; $i < $n; $i++) {
                        $sum += pow(($v1[$i] - $v2[$i]), $order);
                    }
                    return pow($sum, 1/$order);
                } else {
                    throw new \PEAR2\Math\Distance\Exception('Incompatible vector sizes');
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
     * @throws \PEAR2\Math\Distance\Exception if numeric vectors are of different sizes
     * @return double The Manhattan distance between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4)) throws \PEAR2\Math\Distance\Exception
     * @assert (array(3,4,2,1), array(0,5,6,9)) == 16
     * @assert (array(-2,4), array(0,5)) == 3
     *
     */
    public static function manhattan($v1, $v2)
    {
        if (Distance::_compatibleData($v1, $v2)) {
            $n = count($v1);
            $sum = 0;
            for ($i=0; $i < $n; $i++) {
                $sum += abs($v1[$i] - $v2[$i]);
            }
            return $sum;
        } else {
            throw new \PEAR2\Math\Distance\Exception('Incompatible vector sizes');
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
     * @throws \PEAR2\Math\Distance\Exception if numeric vectors are of different sizes
     * @return double The Chebyshev distance between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4)) throws \PEAR2\Math\Distance\Exception
     * @assert (array(3,4,2,1), array(0,5,6,9)) == 8
     * @assert (array(-2,4), array(0,5)) == 2
     *
     */
    public static function chebyshev(array $v1, array $v2)
    {
        if (Distance::_compatibleData($v1, $v2)) {
            $n = count($v1);
            $diffvals = array();
            for ($i=0; $i < $n; $i++) {
                $diffvals[$i] = abs($v1[$i] - $v2[$i]);
            }
            return max($diffvals);
        } else {
            throw new \PEAR2\Math\Distance\Exception('Incompatible vector sizes');
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
     *'
     * @param string $s1 first string
     * @param string $s2 second string
     * @throws \PEAR2\Math\Distance\Exception if parameters are not strings of the same length
     * @return integer the hamming length from s1 to s2
     *
     * @assert ('australopitecus', 'bird' throws \PEAR2\Math\Distance\Exception
     * @assert ('1011101', '1001001') == 2
     * @assert ('chemistry', 'dentistry') == 4
     *
     */
    public static function hamming($s1, $s2)
    {
        if ((is_string($s1) && is_string($s2)) && (strlen($s1) == strlen($s2))) {
            $res = array_diff_assoc(str_split($s1), str_split($s2));
            return count($res);
        } else {
            throw \PEAR2\Math\Distance\Exception('Expecting two strings of equal lenght');
        }
    }
}

?>

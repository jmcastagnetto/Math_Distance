<?php
namespace Math;
/**
 * Math\Distance
 *
 * @category  Math
 * @package   Math\Distance
 * @author    Jesus M. Castagnetto <jesus@castagnetto.com>
 * @copyright 2011-2013 Jesús M. Castagnetto
 * @license   http://opensource.org/licenses/bsd-license.php New BSD License
 * @version   1.0.0
 * @link      http://github.com/jmcastagnetto/Math_Distance
 * @since     File available since version 1.0.0
 */

/**
 * Package to calculate distance metrics
 *
 * It implements methods to compute vector distance metrics
 * (Euclidean, Minkowski, Manhattan and Chebyshev) as well as
 * string distance metric (Hamming)
 *
 * require "../vendor/autoload.php";
 *
 * $v1 = array(0,2,1);
 * $v2 = array(1,4,5);
 * $m = new Math\Distance(new Math\Distance\Euclidean());
 * $euclidean = $m->data($v1, $v2)->distance();
 * $manhattan = $m->algorithm(new Math\Distance\Manhattan())
 *                ->data($v1, $v2)->distance();
 * $chebyshev = $m->algorithm(new Math\Distance\Chebyshev())
 *                ->data($v1, $v2)->distance();
 * $minkowski = $m->algorithm(new Math\Distance\Minkowski(3))
 *                ->data($v1, $v2)->distance();
 * $hamming = $m->algorithm(new Math\Distance\Hamming())
 *              ->data('1011101', '1001001')->distance();
 *
 * @category  Math
 * @package   Math\Distance
 * @author    Jesus M. Castagnetto <jesus@castagnetto.com>
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

    /**
     * Constructor for Math\Distance
     *
     * @param Distance\Algorithm $algo
     */
    public function __construct(Distance\Algorithm $algo) {
        $this->algorithm($algo);
    }

    /**
     * Sets the distance algorithm to be used
     *
     * @param Distance\Algorithm $algo
     */
    public function algorithm(Distance\Algorithm $algo){
        $this->algo = $algo;
        return $this;
    }

    /**
     * Validates and sets the data (vectors or strings)
     *
     * @param mixed $v1
     * @param mixed $v2
     */
    public function data($v1, $v2) {
        if (!is_null($v1) && !is_null($v2)
            && $this->algo->validParameters($v1, $v2)) {
            $this->v1 = $v1;
            $this->v2 = $v2;
        }
        return $this;
    }

    /**
     * Calls the appropriate algorithm to calculate the distance metric
     *
     */
    public function distance() {
        return $this->algo->distance($this->v1, $this->v2);
    }

}

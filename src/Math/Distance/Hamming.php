<?php

namespace Math\Distance;

/**
 * Implements the Hamming distance algorithm
 *
 * @see Algorithm
 */

class Hamming extends Algorithm
{
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
     * @param string $string1 first string
     * @param string $string2 second string
     *
     * @throws Distance\IncompatibleItemsException if parameters are not strings of the same length
     * @return integer the hamming length from string1 to string2
     *
     * @assert ('australopitecus', 'bird') throws Distance\IncompatibleItemsException
     * @assert ('1011101', '1001001') == 2
     * @assert ('chemistry', 'dentistry') == 4
     *
     */

    public function distance($string1, $string2)
    {
        $res = array_diff_assoc(str_split($string1), str_split($string2));
        return count($res);
    }

    public function validParameters($string1, $string2)
    {
        if (is_string($string1) === true && is_string($string2) === true
        && strlen($string1) === strlen($string2)) {
            return true;
        } else {
            throw new IncompatibleItemsException(
            'Expecting two strings of equal length');
        }
    }
}

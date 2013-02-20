<?php

namespace Math\Distance;

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
    public function distance($s1, $s2)
    {
        $res = array_diff_assoc(str_split($s1), str_split($s2));
        return count($res);
    }

    public function validParameters($s1, $s2) {
        if (is_string($s1) === true
            && is_string($s2) === true
            && strlen($s1) === strlen($s2)) {
            return true;
        } else {
            throw new IncompatibleItemsException(
                'Expecting two strings of equal length'
            );
        }
    }
}

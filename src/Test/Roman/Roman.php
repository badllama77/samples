<?php
namespace Test\Roman;

use Test\Map\MapInterface;

/**
 * Interprets an integer into a roman numeral
 * @author Eric Myers <emyers@millisoftware.com>
 */
class Roman
{
    /**
     * Integer to be interpreted
     * @var integer
     */
    protected $number;

    /**
     * Object implementing the map interface providing a map to a roman numeral
     * @var MapInterface
     */
    protected $map;

    /**
     * Roman numeral interpreted from number
     * @var string
     */
    protected $roman;

    /**
     * Initialize object
     * @param integer $number integer to be interpreted
     * @param MapInterface $map  
     */
    public function __construct($number, MapInterface $map)
    {
        if (!is_numeric($number)) {
            throw new \Exception(sprintf('Number %s is not valid', $number));
        }
        if ($number > 3999 || $number  < 1) {
            throw new \Exception(sprintf('Number %s is not between 1 and 3999', $number));
        }
        $this->map = $map;
        $this->roman = $this->integerToRoman($number);
    }

    public function __toString()
    {
        return $this->roman;
    }

    protected function integerToRoman($number)
    {
        $roman = '';
        while ($number > 0) {
            foreach ($this->map as $mapInt => $mapRoman) {
                if ($number >= $mapInt) {
                    $number -= $mapInt;
                    $roman .= $mapRoman;
                    break;
                }
            }
        }

        return $roman;
    }
}

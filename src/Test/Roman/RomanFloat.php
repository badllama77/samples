<?php
namespace Test\Roman;

use Test\Map\MapInterface;

/**
 * Intreprets a floating point number into a roman numeral
 * @author Eric Myers <emyers@millisoftware.com>
 */
class RomanFloat extends Roman
{
    /**
     * The fractional portion of the given number
     * @var integer
     */
    protected $fraction;

    /**
     * {@inheritdoc}
     */
    public function __construct($number, MapInterface $map)
    {
        $numbers = explode('.', $number);
        parent::__construct($numbers[0], $map);
        $this->fraction = $numbers[1];
        $this->roman .= '.' . strtolower($this->integerToRoman($this->fraction));
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->roman;
    }
}

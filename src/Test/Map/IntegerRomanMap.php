<?php
namespace Test\Map;

/**
 * Defines mapping between integers and roman numerals
 */
class IntegerRomanMap implements MapInterface
{
    /**
     * Map of integers to roman numerals 
     * @var array
     */
    protected $map;

    /**
     * Default map of integers to roman numerals
     * @var array
     */
    protected $defaultMap = array(
        1000 => 'M',
        500  => 'D',
        100  => 'C',
        50   => 'L',
        10   => 'X',
        5    => 'V',
        1    => 'I'
        );

    /**
     * List of integers that are restricted from custom mapping
     * @var array
     */
    protected $invalidMap = array(1, 5);


    public function __construct()
    {
        $this->init();
    }

    /**
     * set custom map and initialize
     * @param  array  $map 
     * @return void
     */
    public function useCustomMap(array $map)
    {
        $this->init($map);
    }

    /**
     * Initialize the map
     * @param  array $map custom map from integer to roman
     * @return void
     */
    protected function init(array $map = null)
    {
        if (!is_null($map)) {
        
            if (!$this->checkValidIntegers($map)) {
                throw \Exception(sprintf(
                    'Integer not available, The available values for mapping are %s',
                    implode(',', array_keys($this->defaultMap))
                ));
            }

            if (!$this->checkAllowedMapping($map)) {
                throw new \Exception('You cannot set custom symbols for 1 and 5');
            }
            $map += $this->defaultMap;
        } else {
            $map = $this->defaultMap;
        }

        $this->map = $this->addSubtractors($map);
    }

    /**
     * check if the integers are valid for roman numeral map
     * @param  array $map
     * @return boolean
     */
    protected function checkValidIntegers($map)
    {
        $diff = array_diff_key($map, $this->defaultMap);
        if (0 < count($diff)) {
            return false;
        }
        return true;
    }

    /**
     * Check if the numbers are allowed to be mapped
     * @param  array $map 
     * @return boolean
     */
    protected function checkAllowedMapping($map)
    {
        if (0 < count(array_intersect($this->invalidMap, array_keys($map)))) {
            return false;
        }
        return true;
    }

    /**
     * Adds subtractive values for roman numerals (9 => IV)
     * @param array $map
     */
    protected function addSubtractors($map)
    {
        ksort($map);
        $subtractors = array();
        $i = 1;
        $subInt = 1;
        foreach ($map as $integer => $roman) {
            if (1 < $integer) {
                $subtractors[$integer - $subInt] = $map[$subInt].$roman;
                if ($i == 3) {
                    $subInt = $integer;
                    $i = 1;
                }
            }
            $i++;
        }
        $map = $subtractors + $map;
        krsort($map);
        return $map;
    }

    // interface implementation
    
    /**
     * {@inheritdoc }
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->map);
    }

    /**
     * {@inheritdoc }
     */
    public function keys()
    {
        return array_keys($this->map);
    }

    /**
     * {@inheritdoc }
     */
    public function values()
    {
        return array_values($this->map);
    }

    /**
     * {@inheritdoc }
     */
    public function all()
    {
        return $this->map;
    }
}

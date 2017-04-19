<?php 
namespace Test\Map;

/**
 * defines basic mapping functions
 */
interface MapInterface extends \IteratorAggregate
{
    /**
     * Array of map keys
     * @return array map keys
     */
    public function keys();

    /**
     * Array of values
     * @return array map values
     */
    public function values();

    /**
     * Map array
     * @return array complete map
     */
    public function all();
}

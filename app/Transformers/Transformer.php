<?php namespace MyFamily\Transformers;

abstract class Transformer {


    /**
     * @param array $items
     * @return array
     */
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    /**
     * @param $item
     * @return array
     */
    public abstract function transform($item);
}
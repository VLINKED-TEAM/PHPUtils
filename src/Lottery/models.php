<?php


namespace VlinkedUtils\Lottery;


class Item
{
    public $id;
    public $name;
    public $weight;

    /**
     * Item constructor.
     * @param $id
     * @param $name
     * @param $weight
     */
    public function __construct($id, $name, $weight)
    {
        $this->id = $id;
        $this->name = $name;
        $this->weight = $weight;
    }


    /**
     * @param $id
     * @param $name
     * @param $weight
     * @return Item
     */
    public static function load($id, $name, $weight)
    {
        $item = new Item($id, $name, $weight);

        return $item;
    }


}

class ItemList
{
    /**
     *
     */
    public $list;


}



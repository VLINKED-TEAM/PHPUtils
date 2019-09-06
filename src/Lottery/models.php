<?php


namespace VlinkedUtils\Lottery;


class PrizesItem
{
    public $id;
    public $name;
    public $weight;

    /**
     * Item constructor.
     * @param $id
     * @param $name
     * @param $stock
     */
    public function __construct($id, $name, $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->weight = $stock;
    }


    /**
     * @param $id
     * @param $name
     * @param $stock
     * @return PrizesItem
     */
    public static function load($id, $name, $stock)
    {
        $item = new PrizesItem($id, $name, $stock);

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



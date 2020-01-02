<?php


namespace VlinkedUtils\Lottery;


class PrizesItem
{
    public $id;
    public $name;
    public $stock;

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
        $this->stock = $stock;
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

    public $len;

    /**
     * ItemList constructor.
     */
    public function __construct()
    {
        $this->len = 0;
        $this->list = null;
    }

    /**
     *
     * @param PrizesItem $item
     */
    public function add($item)
    {
        $this->list[] = $item;
        $this->len += 1;
    }


}



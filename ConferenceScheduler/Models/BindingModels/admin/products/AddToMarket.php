<?php

namespace My\ShoppingCart\Models\BindingModels\Admin\Products;


class AddToMarket extends \My\Mvc\BaseBindingModel
{
    /**
     * [required]
     */
    public $id;
    /**
     * [required]
     */
    public $quantity;
    /**
     * [required]
     */
    public $salePrice;
}
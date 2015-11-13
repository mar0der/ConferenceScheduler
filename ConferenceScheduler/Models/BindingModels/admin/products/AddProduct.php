<?php

namespace My\ShoppingCart\models\BindingModels\admin\products;


class AddProduct extends \My\Mvc\BaseBindingModel
{
    /**
     * [minLength(2)]
     */
    public $productName;
    /**
     * [required]
     */
    public $category;
    /**
     * [required]
     */
    public $addCategory;
}
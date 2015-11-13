<?php

namespace My\ShoppingCart\Forms\Admin\Products;


use My\Mvc\ViewHelpers\Form;
use My\Mvc\ViewHelpers\Input;

class AddToMarket
{
    public static function create($id, $quantity = '', $salePrice = '')
    {
        $form = new Form();

        $quantityInput = new Input('text', 'quantity');
        $quantityInput->setAttribute('placeholder', 'Product Quantity')
            ->setAttribute('value', $quantity);

        $salePriceInput = new Input('text', 'salePrice');
        $salePriceInput->setAttribute('placeholder', 'Sale Price')
            ->setAttribute('value', $salePrice);

        $idInput = new Input('hidden', 'id');
        $idInput->setAttribute('value', $id);

        $submit = new Input('submit', 'addToMarket');
        $submit->setAttribute('value', 'Add To Market');

        $form->addElement($quantityInput)
            ->addElement($salePriceInput)
            ->addElement($idInput)
            ->addElement($submit);

        return $form->render();
    }
}
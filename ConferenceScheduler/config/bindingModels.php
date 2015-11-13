<?php
$config["My\ShoppingCart\Controllers\Admin"]["products"]["add"]["My\ShoppingCart\models\BindingModels\admin\products\AddProduct"] = ["productName" => [["minLength", "2"]], "category" => ["required"], "addCategory" => ["required"], "modelState" => [], "errors" => []];
$config["My\ShoppingCart\Controllers\Admin"]["products"]["addtomarket"]["My\ShoppingCart\Models\BindingModels\Admin\Products\AddToMarket"] = ["id" => ["required"], "quantity" => ["required"], "salePrice" => ["required"], "modelState" => [], "errors" => []];
$config["My\ShoppingCart\Controllers"]["cart"]["add"]["My\ShoppingCart\Models\BindingModels\Cart\AddProduct"] = ["quantity" => ["required"], "userProductId" => ["required"], "modelState" => [], "errors" => []];
$config["My\ShoppingCart\Controllers"]["users"]["register"]["My\ShoppingCart\Models\BindingModels\User\RegisterUser"] = ["username" => [["minLength", "2"]], "password" => [["minLength", "4"], ["matches", "{passwordAgain}"]], "email" => ["email"], "passwordAgain" => [], "modelState" => [], "errors" => []];
$config["My\ShoppingCart\Controllers"]["users"]["login"]["My\ShoppingCart\Models\BindingModels\User\LoginUser"] = ["username" => ["required", ["minLength", "2"]], "password" => ["required"], "modelState" => [], "errors" => []];

return $config;
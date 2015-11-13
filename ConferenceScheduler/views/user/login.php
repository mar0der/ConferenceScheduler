<?php /** @var My\ShoppingCart\Models\ViewModels\User\LoginUser $model */ ?>
<h1>
    Login
</h1>
<?php
     if(count($this->model->errors) > 0) {
         echo '<div  class="errors">';
         foreach ($this->model->errors as $error) {
             echo '<p>' . $error . '</p>';
         }

         echo '</div>';
     }
?>
<div class="login">
    <?= \My\Mvc\View::loginForm() ?>
</div>
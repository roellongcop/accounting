<?php

use app\helpers\Html;
use app\widgets\Checkbox;
?>
<div class="row">
    <div class="col-md-8">
        <?= Checkbox::widget([
            'data' => ['page' => 'Check All Access'],
            'inputClass' => 'checkbox',
            'options' => [
                'id' => 'check_all',
                'onclick' => 'checkAllModule(this)'
            ],
        ]) ?>
        <br>
        <div class="accordion accordion-toggle-arrow" id="module-access-accordion">
            <?= Html::foreach($controller_actions, function($actions, $controller) use ($module_access, $name) {
                return $this->render('_form_actions-content', [
                    'controller' => $controller,
                    'actions' => $actions,
                    'module_access' => $module_access,
                    'name' => $name,
                ]);
            }) ?>
        </div>
    </div>
</div>
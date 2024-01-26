<?php

use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'id' => 'main-search-form',
    'action' => $searchAction, 
    'method' => 'get'
]); ?>
    <?= $form->search($searchModel, [
        'submitOnclick' => true,
        'url' => $this->params['findByKeywordsUrl'] ?? null,
        'options' => [
            'style' => 'width: 30vw;margin-left: 10px;',
        ]
    ]) ?>
<?php ActiveForm::end(); ?>
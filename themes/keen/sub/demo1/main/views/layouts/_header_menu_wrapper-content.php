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
        'options' => [
            'style' => 'width: 30vw;margin-left: 10px;',
            'url' => $this->params['findByKeywordsUrl'] ?? null
        ]
    ]) ?>
<?php ActiveForm::end(); ?>
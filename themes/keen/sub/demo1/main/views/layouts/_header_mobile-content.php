<?php

use app\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['action' => $searchAction, 'method' => 'get']); ?>
    <?= $form->search($searchModel, [
        'submitOnclick' => true,
        'url' => $this->params['findByKeywordsUrl'] ?? null
    ]) ?>
<?php ActiveForm::end(); ?>
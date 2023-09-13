<?php

use app\helpers\Html;
?>

<tr>
    <td>
        <?= $this->render('_row-filename', [
            'model' => $model
        ]) ?>
    </td>
    <?= Html::if(
        $withAction, 
        Html::tag('td', $this->render('_row-actions', [
            'model' => $model,
        ]), ['class' => 'text-center'])
    ) ?>
</tr>
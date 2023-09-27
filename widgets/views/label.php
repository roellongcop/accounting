<?php
$this->registerCss(<<< CSS
    span.label {
        text-wrap: nowrap;
    }
CSS);
?>
<span class='label label-lg label-light-<?= $options['class'] ?? '' ?> label-inline'>
    <?= $options['label'] ?? '' ?>
</span>
<?php

use app\helpers\Html;

$this->registerWidgetCssFile('timeline');
?>

<div class="timeline timeline-3">
    <div class="timeline-items">
        <?= Html::foreach($data, fn($item) => <<< HTML
            <div class="timeline-item">
                <div class="timeline-media">
                    <img alt="Pic" src="{$item->creatorImage}"/>
                </div>
                <div class="timeline-content">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="mr-2">
                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                {$item->createdByEmail}
                            </a>
                            <span class="text-muted ml-2">
                                {$item->ago}
                            </span>
                            {$item->label}
                        </div>
                    </div>
                    <p class="p-0">
                        {$item->remarks}
                        <div>
                            {$item->filesPreview}
                        </div>
                    </p>
                </div>
            </div>
        HTML) ?>
    </div>
</div>
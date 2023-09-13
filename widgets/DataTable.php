<?php

namespace app\widgets;

class DataTable extends BaseWidget
{
    public $tableId;
    public $withAction = true;
    public $pageLength = 5;
    public $models;
    public function init()
    {
        parent::init();

        $this->tableId = $this->tableId ?: $this->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('data-table/index', [
            'tableId' => $this->tableId,
            'withAction' => $this->withAction,
            'pageLength' => $this->pageLength,
            'models' => $this->models,
        ]);
    }
}
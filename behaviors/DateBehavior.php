<?php

namespace app\behaviors;

use yii\db\ActiveRecord;

class DateBehavior extends \yii\base\Behavior
{
    public $inFormat = 'Y-m-d';
    public $outFormat = 'm/d/Y';

    public $attributes = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'eventBeforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'eventBeforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'eventBeforeUpdate',
        ];
    }

    public function formatDates($format = '', $type='in')
    {
        foreach ($this->attributes as $attribute) {
            if (is_array($attribute)) {
                $field = $attribute['field'];
                $format = ($type == 'in')? $attribute['inFormat']: $attribute['outFormat'];
            }
            else {
                $format = $format ?: $this->inFormat;
                $field = $attribute;
            }

            if ((int)$this->owner->{$field}) {
                $this->owner->{$field} = date($format, strtotime($this->owner->{$field}));
            }
        }
    }

    public function eventBeforeValidate($event)
    {
        $this->formatDates();
    }

    public function afterFind($event)
    {
        $this->formatDates($this->outFormat, 'out');
    }

    public function eventBeforeInsert($event)
    {
        $this->formatDates();
    }

    public function eventBeforeUpdate($event)
    {
        $this->formatDates();
    }
}
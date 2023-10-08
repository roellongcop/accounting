<?php

namespace app\helpers;

class FileHelper extends \yii\helpers\FileHelper
{
    public static function normalizePath($path='', $ds = DIRECTORY_SEPARATOR)
    {
        return parent::normalizePath($path, $ds);
    }
}
<?php

namespace app\models\form;

use app\helpers\App;
use app\models\File;
use app\models\User;
use app\models\CashFlow;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CashflowImportForm extends \yii\base\Model
{
    const ALLOWED_EXTENSIONS = ['xlsx', 'xls'];
    const TYPE_INCOME = 1;
    const TYPE_EXPENSE = 0;

    public $type;
    public $file_token;
    private $_file;
    private $_data;

    public function rules()
    {
        return [
            // username and password are both required
            [['file_token', 'type'], 'required'],
            [['file_token'], 'string'],
            [['type'], 'in', 'range' => [
                self::TYPE_INCOME,
                self::TYPE_EXPENSE,
            ]],
            ['file_token', 'exist', 'targetClass' => 'app\models\File', 'targetAttribute' => 'token'],
            ['file_token', 'validateFileToken'],
        ];
    }

    public function getFile()
    {
        if ($this->_file === null) {
            $this->_file = File::findByToken($this->file_token);
        }

        return $this->_file;
    }

    public function validateFileToken($attribute, $params)
    {
        $file = $this->file;

        if (!$file) {
            $this->addError('file', 'No file found');
            return;
        }

        if (!in_array($file->extension, self::ALLOWED_EXTENSIONS)) {
            $this->addError('file', 'Invalid file extension');
            return;
        }

        $spreadsheet = IOFactory::load($file->rootPath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        if (!$sheetData) {
            $this->addError($attribute, 'File no data');
            return;
        }

        $formatted_data = [];
        $header = $sheetData[1];

        $requiredHeaders = ['AMOUNT', 'INVOICE DATE', 'INVOICE NO', 'CLIENT'];

        if ($this->type === self::TYPE_EXPENSE) {
            $requiredHeaders[] = 'BILLER';
        }
        $headerValues = array_values($header);

        $hasError = false;
        foreach ($requiredHeaders as $requiredHeader) {
            if (!in_array($requiredHeader, $headerValues)) {
                $this->addError('file', "There is no {$requiredHeader} field");
                $hasError = true;
            }
        }
        if ($hasError) return;

        foreach ($sheetData as $row_value => $row) {
            if ($row_value === 1) continue;

            foreach ($header as $column => $column_value) {
                $formatted_data[$row_value][$column_value] = $row[$column];
            }
        }

        $sql_data = [];
        foreach ($formatted_data as $key => $data) {
            if (!($data['AMOUNT'] ?? '') 
                || !($data['INVOICE DATE'] ?? '')
                || !($data['INVOICE NO'] ?? '')
                || !($data['CLIENT'] ?? '')) {
                continue;
            }
            $sql_data[$key]['amount'] = (float)$data['AMOUNT'] ?? 0;
            $sql_data[$key]['date'] = date('Y-m-d', strtotime($data['INVOICE DATE'] ?? ''));
            $sql_data[$key]['name'] = $data['INVOICE NO'] ?? '';
            $sql_data[$key]['biller'] = $data['BILLER'] ?? '';

            $user = User::findOne(['username' => $data['CLIENT'] ?? '']);
            if (!$user) {
                unset($sql_data[$key]);
                continue;
            }
            $sql_data[$key]['user_id'] = $user->id;
        }
        $this->_data = $sql_data;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function import()
    {
        if (!$this->validate()) return;

        foreach ($this->data as $key => $data) {
            $cashFlow = new CashFlow($data);
            $cashFlow->type = $this->type;
            $cashFlow->status = CashFlow::STATUS_COMPLETED;
            if (!$cashFlow->save()) {
                $this->addError("Row " . ($key + 1), $cashFlow->errors);
                return;
            }
        }

        return true;
    }

    public static function income()
    {
        return new self(['type' => self::TYPE_INCOME]);
    }

    public static function expense()
    {
        return new self(['type' => self::TYPE_EXPENSE]);
    }
}
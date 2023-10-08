<?php

namespace app\widgets;

class StackChart extends BaseWidget
{
  public $data_url;
  public $date_range;
  public $user_id;
  public $additional_scripts;
  
  public function init()
  {
    parent::init();

    if (!$this->date_range) {

      $dateNow = new \DateTime();

      $firstHalfStart = new \DateTime(date('Y-01-01'));
      $firstHalfEnd = new \DateTime(date('Y-06-30'));
      $secondHalfStart = new \DateTime(date('Y-07-01'));
      $secondHalfEnd = new \DateTime(date('Y-12-31'));

      if ($dateNow >= $firstHalfStart && $dateNow <= $firstHalfEnd) {
          $dateRange = $firstHalfStart->format("Y-m-d") . " - " . $firstHalfEnd->format("Y-m-d");
      } else {
          $dateRange = $secondHalfStart->format("Y-m-d") . " - " . $secondHalfEnd->format("Y-m-d");
      }

      $this->date_range = $dateRange;
    }
  }
  /**
   * {@inheritdoc}
   */
  public function run()
  {
    return $this->render('stack-chart', [
      'data_url' => $this->data_url,
      'date_range' => $this->date_range,
      'user_id' => $this->user_id,
      'additional_scripts' => $this->additional_scripts,
    ]);
  }
}

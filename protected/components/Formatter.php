<?php
class Formatter extends CApplicationComponent
{
  public $dateFormat = 'd-m-Y';

  public function formatDate($date)
  {
    if (empty($date) || $date == '0000-00-00') {
      return '';
    }
    return date($this->dateFormat, strtotime($date));
  }
}

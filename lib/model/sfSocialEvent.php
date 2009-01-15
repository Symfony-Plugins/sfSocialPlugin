<?php

class sfSocialEvent extends BasesfSocialEvent
{

  /**
   * magic method
   * @return string
   */
  public function __toString()
  {
    return $this->getTitle();
  }

  /**
   * get start and end dates in a fancy format
   * @param  string $date date format
   * @param  string $time time format
   * @param  string $from "from" text
   * @param  string $to   "to" text
   * @return string
   */
  public function getWhen($date = 'd/m/Y', $time = 'H:i', $from = 'from', $to = 'to')
  {
    // event starts and ends in same day
    if ($this->getStart('zY') == $this->getEnd('zY'))
    {
      return $this->getStart($date) . ' ' . $from . ' ' . $this->getStart($time) .
             ' ' . $to . ' ' . $this->getEnd($time);
    }
    // event spans in more days
    return $from . ' ' . $this->getStart($date . ' ' . $time) . ' ' . $to . ' ' .
           $this->getEnd($date . ' ' . $time);
  }

}

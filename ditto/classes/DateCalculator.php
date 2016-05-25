<?php

class Ditto_DateCalculator extends \DateTime
{
	/**
	 * Constant for the day wednesday in PHP
	 */
	const WEDNESDAY = 3;

	/**
	 * Dates of payment over the next 12 months
	 * @var array
	 */
	public $paydays = [];

	/**
	 * When we intialize our custom date time object we want to calculate
	 * the correct days for payment over the next 12 months
	 */
	public function __construct()
	{
		parent::__construct();
		for ($i = 0; $i <= 11; $i++) {

			// calculate the payday
			$this->setDate(date('Y'), date('m') + $i, 1);
			$row = [$this->format('M')];
			while($this->sub(new DateInterval('P1D'))) {
				if (!$this->isWeekend($this)) {
					break;
				}
			}
			$row[] = $this->format('d/m/Y');

			// calculate the bonus payday
			$this->setDate(date('Y'), date('m') + $i, 15);
			if ($this->isWeekend($this)) {
				while($this->add(new DateInterval('P1D'))) {
					if ($this->format('w') == self::WEDNESDAY) {
						break;
					}
				}
			}

			$row[] = $this->format('d/m/Y');

			$this->paydays[] = $row;
			$row = null;
		}
	}

	/**
	 * Calculate if the given date time object is a weekend
	 * @param DateTime $date
	 * @return bool true|false
	 */
	public function isWeekend(DateTime $date)
	{
		$day = $date->format('w');
		if (in_array($day, [0,6])) {
			return true;
		}
		return false;
	}
}

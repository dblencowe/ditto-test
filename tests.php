<?php

require_once __DIR__ . '/vendor/fzaninotto/faker/src/autoload.php';
require __DIR__ . '/ditto/classes/DateCalculator.php';

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
	public function testInstanceOfDateTime()
	{
		$dateTime = new Ditto_DateCalculator;
		self::assertInstanceOf('DateTime', $dateTime);
	}

	/**
	 * Check to see that after initiating the DateTime object it contains the data we want
	 *
	 */
	public function testObjectIntializesWithCorrectData()
	{
		$faker = Faker\Factory::create();

		$dateClass = new Ditto_DateCalculator($faker->dateTime('January next year'));

		if (!is_array($dateClass->paydays)) {
			$this->fail('Paydays is not an array in dateTime object');
		}
	}

	/**
	 * Test the internal isWeekend() function is working
	 *
	 */
	public function testCanTellIfDateIsWeekend()
	{
		$faker = Faker\Factory::create();

		$dateTime = new Ditto_DateCalculator;

		$date = $faker->dateTimeBetween('next saturday', 'next sunday');
		echo($date->format('D d/m/Y'));
		$this->assertEquals(true, $dateTime->isWeekend($date));

		$date = $faker->dateTimeBetween('next monday', 'next tuesday');
		$this->assertEquals(false, $dateTime->isWeekend($date));
	}

}

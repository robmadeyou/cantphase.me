<?php

	namespace Cant\Phase\Me\Various;


use Rhubarb\Scaffolds\Authentication\LoginProvider;

class Greet
{
	public static function GetMessage()
	{
		$loggedIn = (new LoginProvider())->getLoggedInUser();
		$messages = [
			new TimeOfDayGreet(),
			"Hey",
			"Hi",
			"Hello",
			"Yo",
		];

		$execute = $messages[ rand( 0, sizeof( $messages ) ) ];
		if( $execute instanceof LogicalGreet )
		{
			return $execute->GetMessage();
		}
		else
		{
			return $execute;
		}
	}
}

abstract class LogicalGreet
{
	/**
	 * @returns String message, created programmatically.
	 */
	public abstract function GetMessage();
}

class TimeOfDayGreet extends LogicalGreet
{
	/**
	 * @returns String message, created programmatically.
	 */
	public function GetMessage()
	{
		$timeHours = date( 'G' );
		if( $timeHours >= 5 && $timeHours <= 11 )
		{
			return "Good morning.";
		}
		else if( $timeHours >= 12 && $timeHours <= 18 )
		{
			return "Good afternoon.";
		}
		else if( $timeHours >= 19 || $timeHours <= 4 )
		{
			return "Good evening.";
		}
	}
}
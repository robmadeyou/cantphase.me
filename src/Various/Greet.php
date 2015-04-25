<?php

	namespace Cant\Phase\Me\Various;


use Rhubarb\Crown\LoginProviders\Exceptions\NotLoggedInException;
use Rhubarb\Scaffolds\Authentication\LoginProvider;

class Greet
{
	public static function GetMessage()
	{
		try
		{
			$loggedIn = (new LoginProvider())->getLoggedInUser();
		}
		catch( NotLoggedInException $ex )
		{}

		$messages = [
			new TimeOfDayGreet(),
			new TimeOfDayGreet(),
			new TimeOfDayGreet(),
			"Hey",
			"Hi",
			"Hello",
			"Yo",
			"Sup"
		];

		$execute = $messages[ rand( 0, sizeof( $messages ) - 1 ) ];
		if( $execute instanceof LogicalGreet )
		{
			return $execute->GetMessage() . ( isset( $loggedIn ) ? ' ' . $loggedIn->Username : '' ) . '.';
		}
		else
		{
			return $execute . ( isset( $loggedIn ) ? ' ' . $loggedIn->Username : '' ) . '.';
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
			return "Good morning";
		}
		else if( $timeHours >= 12 && $timeHours <= 18 )
		{
			return "Good afternoon";
		}
		else if( $timeHours >= 19 || $timeHours <= 4 )
		{
			return "Good evening";
		}
	}
}
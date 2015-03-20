<?php
namespace Cant\Phase\Me\Loggers;

use Rhubarb\Crown\Logging\Log;

class PrintLog extends Log
{

	/**
	 * The logger should implement this method to perform the actual log committal.
	 *
	 * @param string $message           The text message to log
	 * @param string $category          The category of log message
	 * @param int    $indent            An indent level - if applicable this can be used to make logs more readable.
	 * @param array  $additionalData    Any number of additional key value pairs which can be understood by specific
	 *                                  logs (e.g. an API log might understand what AuthenticationToken means)
	 *
	 * @return mixed
	 */
	protected function writeEntry( $message, $indent, $category = "", $additionalData = [ ] )
	{
		echo $message;
	}
}
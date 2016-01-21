<?php
namespace Cant\Phase\Me\Layouts;

use Rhubarb\Crown\Html\ResourceLoader;
use Rhubarb\Patterns\Layouts\BaseLayout;
class DefaultLayout extends PhasedBaseLayout
{
	function __construct()
	{
		parent::__construct();
	}

	protected function printHead()
	{
		?>
			<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
			<link rel="shortcut icon" href="/static/image/spider.ico">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<?php
	}

	protected function printPageHeading()
	{
		?>
			<div id="content" class="wrapper">
				<div class="top"></div>
				<div class="top-bottom">
				</div>
		<?php
	}

	protected function printTail()
	{
		parent::printTail();
		?>
		<div class="push"></div>
		</div>
		<div class="footer">
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="/static/js/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<?php
	}
}
<?php
namespace Cant\Phase\Me\Layouts;

use Rhubarb\Crown\Html\ResourceLoader;
use Rhubarb\Patterns\Layouts\BaseLayout;
class DefaultLayout extends BaseLayout
{
	function __construct()
	{
		ResourceLoader::loadResource( "/static/css/base.css" );
	}

	protected function printHead()
	{
		?>
			<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
			<link rel="shortcut icon" href="/static/image/spider.ico">
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
		<?php
	}
}
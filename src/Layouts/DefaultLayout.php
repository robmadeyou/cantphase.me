<?php
namespace Cant\Phase\Me\Layouts;

use Rhubarb\Crown\Html\ResourceLoader;
use Rhubarb\Patterns\Layouts\BaseLayout;
class DefaultLayout extends BaseLayout
{
	function __construct()
	{
		ResourceLoader::loadResource( "/static/css/base.css" );
		ResourceLoader::loadJquery( '1.9.1' );
	}

	protected function printHead()
	{
		?>
			<link rel="shortcut icon" href="/static/image/spider.ico">
		<?php
	}

	protected function printPageHeading()
	{
		?>

		<div id="content" class="wrapper">
		<div class="top"></div>
		<div class="top-bottom">
			<?php
				parent::printPageHeading();
			?>
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
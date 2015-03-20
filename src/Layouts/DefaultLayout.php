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
	protected function printPageHeading()
	{
		?>
		<div id="top">
			<?php
				parent::printPageHeading();
			?>
		</div>
		<div id="content">
	<?php
	}
	protected function printTail()
	{
		parent::printTail();
		?>
		</div>
		<div id="tail">

		</div>
		<?php
	}
}
<?php
/**
 * How is it going yo
 */

namespace Cant\Phase\Me\Presenters\Music\Browse;


use Rhubarb\Leaf\Presenters\Application\Search\SearchPanelView;

class BrowseSearchView extends SearchPanelView
{
	public function printViewContent()
	{
		?>
			<div class="search-content">
				<div class="search-content-control">
					<?=  $this->controls[ "TextFilter" ] ?>
				</div>
			</div>
		<?php
	}
}
<?php

namespace Cant\Phase\Me\Presenters;

use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class IndexView extends HtmlView
{
	public $hasOverlay = false;

	protected function PrintViewContent()
	{
		?>
		<div class="site-wrapper">
			<div class="site-wrapper-inner">
				<div class="cover-container">
					<div class="masthead clearfix">
						<div class="inner">
							<nav>
								<ul class="nav masthead-nav">
									<li class="active"><a href="#">Home</a></li>
									<li><a href="#">Features</a></li>
									<li><a href="#">Contact</a></li>
								</ul>
							</nav>
						</div>
					</div>

					<div class="inner cover">
						<h1 class="cover-heading">Cantphase.me</h1>
						<p class="lead">A great server with an active developer and a friendly community</p>
						<p class="lead">
							<a href="#" class="btn btn-lg btn-default">Learn more</a>
						</p>
					</div>

					<div class="mastfoot">
						<div class="inner">
							<p>cantphase.me</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Override this method with the Login model to add the overlay effect.
	 */
	public function printOverlay()
	{}
}
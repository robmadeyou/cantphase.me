<?php

namespace Cant\Phase\Me\Presenters;

use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;

class IndexView extends HtmlView
{
	public $hasOverlay = false;

	use WithJqueryViewBridgeTrait;

	protected function PrintViewContent()
	{
		?>
		<div class="site-wrapper">
			<div class="site-wrapper-inner">
				<div class="cover-container">
					<div class="top-nav">
						<div class="inner">
							<nav>
								<ul class="nav masthead-nav">
									<li class="active"><a href="#">Home</a></li>
									<li><a href="#features">Features</a></li>
									<li><a href="#">Contact</a></li>
								</ul>
							</nav>
						</div>
					</div>

					<div class="inner cover">
						<h1 class="cover-heading">Cantphase.me</h1>
						<p class="lead">A great server with an active developer and a friendly community</p>
						<p class="lead">
							<a href="http://canthpase.me" class="btn btn-lg btn-default">Learn more</a>
						</p>
					</div>

					<div class="bottom-nav">
						<div class="inner">
							<p><a href="cantphase.me">cantphase.me</a></p>
						</div>
					</div>
					<div class="bottom-border"></div>
				</div>
			</div>
		</div>
		<div id="features-container">
			<h1 id="features"></h1>
			<div class="row featurette">
				<div class="col-md-7">
					<h2 class="featurette-heading">Hosted on a dedicated server</h2><h2> <span class="text-muted">Smoother than your babies bum</span></h2>
				</div>
				<div class="col-md-5">
					<img src="/static/images/torva.png">
				</div>
			</div>
			<div class="row featurette">
				<div class="col-md-5">
					<img src="/static/images/pernix.png">
				</div>
				<div class="col-md-7">
					<h2>Many items! Any many more to be added</h2>
				</div>
			</div>
			<div class="row featurette">
				<div class="col-md-7">

				</div>
				<div class="col-md-5">
					<img src="/static/images/virtus.png">
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

	public function getDeploymentPackageDirectory()
	{
		return __DIR__;
	}
}
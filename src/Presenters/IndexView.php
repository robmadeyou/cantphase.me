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
        <div>
            <h1 class="featurette-heading center-title">
                Features yo
            </h1>
        </div>
        <div class="container marketing">
            <div id="features-container">
                <h1 id="features"></h1>

                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">Hosted on a dedicated server. <span class="text-muted">It's super fast!</span></h2>
                        <p class="lead">Server located in London, with the possibility to expand to Amsterdam, Latvia or Chicago!</p>
                    </div>
                    <div class="col-md-5">
                        <img class="featurette-image img-responsive center-block" src="/static/images/torva.png">
                    </div>
                </div>
                <div class="row featurette">
                    <div class="col-md-5">
                        <img class="featurette-image img-responsive center-block" src="/static/images/pernix.png">
                    </div>
                    <div class="col-md-6">
                        <h2 class="featurette-heading"><span class="text-muted">Loads of items!</span> And many more to be added.</h2>
                        <p class="lead">With an active developer, and a creative community - the items will keep on coming!</p>
                    </div>
                </div>
                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">Solid Economy. <span class="text-muted">No spawning!</span></h2>
                        <p class="lead">With realistic boss drop rates, npc shops, and reward shops. Economy is and will be respected till the end.</p>
                    </div>
                    <div class="col-md-5">
                        <img class="featurette-image img-responsive center-block" src="/static/images/virtus.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <?php
    }

    /**
     * Override this method with the Login model to add the overlay effect.
     */
    public function printOverlay()
    {
    }

    public function getDeploymentPackageDirectory()
    {
        return __DIR__;
    }
}
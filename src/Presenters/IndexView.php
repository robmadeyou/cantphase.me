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
                                    <li><a href="#download">Download</a></li>
                                    <li><a href="http://forum.cantphase.me">Forums</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="inner cover">
                        <h1 class="cover-heading">Cantphase.me</h1>

                        <p class="lead">A great server with an active developer and a friendly community</p>
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
        <h1 id="features"></h1>
        <img src="/static/images/spacer.png">
        <div class="container marketing">
            <div id="features-container">
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
                        <h2 class="featurette-heading">Loads of items! <span class="text-muted">And many more to be added.</span></h2>
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
        <img src="/static/images/spacer.png">
        <div class="container marketing">
            <div class="row featurette">
                <div class="col-md-3">
                    <img class="featurette-image img-responsive center-block" src="/static/images/bandos.png">
                </div>
                <div class="col-md-6">
                    <h1 id="download" class="featurette-heading center-title">
                        Download me
                    </h1>
                    <p class="lead">
                        Download the launcher, and always stay up to date with the latest features
                    </p>
                    <a target="_blank" class="btn btn-lg btn-default" href="/static/PhasedClient.jar">Download now</a>
                </div>
                <div class="col-md-3">
                    <img class="featurette-image img-responsive center-block" src="/static/images/armadyl.png">
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
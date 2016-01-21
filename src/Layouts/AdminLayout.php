<?php

namespace Cant\Phase\Me\Layouts;

use Rhubarb\Crown\Html\ResourceLoader;
use Rhubarb\Patterns\Layouts\BaseLayout;

class AdminLayout extends PhasedBaseLayout
{
    function __construct()
    {
        parent::__construct();
        ResourceLoader::loadResource( '/static/css/dashboard.css' );
        ResourceLoader::loadResource( '/static/css/admin.css' );
    }

    protected function printHead()
    {
        parent::printHead();

        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Admin panel for managing your server</title>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="dashboard.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php
    }

    protected function printContent( $content )
    {
        ?>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Cantphase.me admin page</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Help</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li><a href="#" class="toPage" to="server-overview">Server overview</a></li>
                        <li><a href="#" class="toPage" to="reports">Reports</a></li>
                        <li><a href="#" class="toPage" to="statistics">Statistics</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li><a href="#" class="toPage" to="item-edit">Item Editor</a></li>
                        <li><a href="#" class="toPage" to="shop-edit">Shop Editor</a></li>
                        <li><a href="#" class="toPage" to="npc-edit">NPC Editor</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li><a href="#" class="toPage" to="config">Configuration</a></li>
                    </ul>
                </div>
                    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                        <?php parent::printContent( $content );?>
                    </div>
            </div>
        </div>
        <?php
    }


    protected function printTail()
	{
		parent::printTail();
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="/static/js/bootstrap.min.js"></script>
		<?php
	}
}
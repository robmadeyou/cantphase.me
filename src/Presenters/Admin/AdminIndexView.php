<?php

namespace Cant\Phase\Me\Presenters\Admin;

use Cant\Phase\Me\Handler\Server;
use Cant\Phase\Me\Models\Item;
use Rhubarb\Leaf\Presenters\Application\Search\SearchPanel;
use Rhubarb\Leaf\Presenters\Application\Table\Table;
use Rhubarb\Leaf\Presenters\Controls\Buttons\Button;
use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;
use Rhubarb\Patterns\Mvp\Crud\CrudView;

class AdminIndexView extends CrudView
{
    use WithJqueryViewBridgeTrait;

    /**
     * @var Server $server
     */
    public $server;

    function __construct()
    {
        $this->server = new Server();
    }

    public function createPresenters()
    {
        parent::createPresenters();

        $itemTable = new Table( Item::find(), 50, 'ItemTable' );
        $itemTable->addTableCssClass( [ 'table', 'table-striped' ] );
        $itemTable->Columns = [
            'ItemID',
            'Name',
            'Examine',
            'Price'
        ];

        $itemSearch = new AdminItemSearchPanel( 'ItemSearch' );

        $this->addPresenters(
            $itemTable,
            $itemSearch,
            new Button( 'LoadItemsSQL', 'Load Items into SQL', function()
            {
                Server::LoadItemsIntoSQL();
            }, true ),
            new Button( 'DumpItems', 'Dump items to Json', function()
            {
                ini_set('memory_limit', '512M');
                file_put_contents( './Server/items.json', Server::GetItemJson() );
            }, true ),
            new Button( 'LoadItemCost', 'Load item cost into SQL', function()
            {
                Server::LoadItemCostIntoSQL();
            }, true ),
            new Button( 'LoadNpcs', 'Load NPCs into SQL', function()
            {
                Server::LoadNpcsIntoSQL();
            }, true ),
            new Button( 'LoadNpcSpawn', 'Load npc spawn points', function()
            {
                Server::LoadNpcDetailsIntoSQL();
            }, true ),
            new Button( 'LoadNpcDrops', 'Load npc drops', function()
            {

            }, true ),
            new Button( 'DumpNpcs', 'Dump npc list' , function()
            {
                ini_set('memory_limit', '512M');
                file_put_contents( './Server/npcs.json', Server::GetItemJson() );
            }, true )
        );

        $itemSearch->bindEventsWith( $itemTable );
    }

    protected function printViewContent()
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
                    <div id="page-container">
                        <div id="server-overview" class="paged">
                            <?= $this->getServerOverview() ?>
                        </div>
                        <div id="reports" class="paged" style="display:none">
                            <?= $this->getReports() ?>
                        </div>
                        <div id="statistics" class="paged" style="display:none">
                            <?= $this->getStatistics() ?>
                        </div>
                        <div id="item-edit" class="paged" style="display:none">
                            <?= $this->getItemEditor() ?>
                        </div>


                        <div id="config" class="paged" style="display:none">
                            <?= $this->getConfig() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function getServerOverview()
    {
        $serverUptime = $this->server->getServerUptime();

        $playerList = $this->server->getPlayerList();
        $playerRows = "";
        if( $playerList ) {

            $playerRows .= <<<HTML
        <div class="online-players">
                <table class="table table-striped">
HTML;
            foreach ($playerList as $player) {
                $playerRows .= <<<HTML
            <tr>
                <td>{$player}</td>
                <td><a href="">Manage</a></td>
            </tr>
HTML;
            }
            $playerRows .= <<<HTML
            </table>
        </div>
HTML;
        }

        return <<<HTML
        <div id="server-overview" class="main-page">
            <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Server status</h4>
                    <span class="text-muted">Up: {$serverUptime}</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
            </div>
            {$playerRows}
        </div>
HTML;
    }

    public function getReports()
    {
        return <<<HTML

HTML;
    }

    public function getStatistics()
    {
        return <<<HTML

HTML;
    }

    public function getItemEditor()
    {
        return <<<HTML
        {$this->presenters[ 'ItemSearch' ]}
        {$this->presenters[ 'ItemTable' ]}
HTML;

    }

    public function getConfig()
    {
        return <<<HTML
        {$this->presenters['LoadItemsSQL']}
        {$this->presenters['DumpItems']}
        {$this->presenters['LoadItemCost']}
        {$this->presenters['LoadNpcs']}
        {$this->presenters['LoadNpcSpawn']}
HTML;

    }

    public function getDeploymentPackageDirectory()
    {
        return __DIR__;
    }
}
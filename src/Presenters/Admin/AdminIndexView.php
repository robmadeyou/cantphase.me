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
        $itemTable->addTableCssClass( [ 'table' ] );
        $itemTable->Columns = [
            'ItemID',
            'Name',
            'Examine',
            'Price',
            'LowAlch',
            'HighAlch',
            '' => '<a href="/admin/item/{ItemID}/edit/" class="btn btn-default">Edit</a>'
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
                Server::LoadNpcDropsIntoSQL();
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
        <?php
    }

    public function GetPlayerRowsHTML()
    {
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
        return $playerRows;
    }

    public function getServerOverview()
    {
        $serverUptime = $this->server->getServerUptime();

        $playerRows = $this->GetPlayerRowsHTML();

        return <<<HTML
        <div id="server-overview" class="main-page">
            <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive loading up top running" alt="Server Status">
                    <h4>Server status</h4>
                    <span class="text-muted" id="server-uptime">Up: {$serverUptime}</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive loading up right running" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive loading up bottom stopped" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive loading up left stopped" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
            </div>
            <div id="players-online-holder">
                {$playerRows}
            </div>
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
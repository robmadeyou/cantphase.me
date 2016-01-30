<?php

namespace Cant\Phase\Me\Presenters\Admin\Npc;

use Cant\Phase\Me\Models\Npc;
use Rhubarb\Leaf\Presenters\Application\Table\Table;
use Rhubarb\Patterns\Mvp\Crud\CrudView;

class NpcEditView extends CrudView
{
    public function createPresenters()
    {
        parent::createPresenters();

        $table = new Table( Npc::find(), 50, 'NpcTable' );

        $table->addTableCssClass( 'table' );
        $table->Columns = [

        ];

        $this->addPresenters(
            $table
        );
    }

    protected function printViewContent()
    {
        print $this->presenters[ 'NpcTable' ];
    }
}
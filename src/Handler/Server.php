<?php

namespace Cant\Phase\Me\Handler;

use Cant\Phase\Me\Models\Item;
use Cant\Phase\Me\Models\Npc;
use Cant\Phase\Me\Models\NpcDrop;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Repositories\MySql\MySql;

class Server
{
    public static $dataDir = './Server/Data/';
    public static $jarPath = './Server/ServerManager.jar';

    private static $uptime;

    function __construct()
    {

    }

    public function getServerUptime()
    {
        if( !isset( self::$uptime ) )
        {
            self::$uptime = $this->execute( 'uptime' );
        }
        return self::$uptime;
    }

    public function getPlayerList()
    {
        $list = self::execute( 'players' );
        return $list ? explode( ',', $list ) : false;
    }

    private function execute( $command )
    {
        $return = exec( 'java -jar ' . self::$jarPath . ' '. escapeshellarg( $command ) );
        return $return;
    }

    public static function LoadItemsIntoSQL()
    {
        $array = self::LoadCFG( 'item.cfg' );

        foreach( $array as $d )
        {
            Item::createFromCfgLine( null, $d );
        }
    }

    public static function LoadItemCostIntoSQL()
    {
        $prices = self::LoadCFG( 'prices.txt' );

        foreach( $prices as $price )
        {
            $price = explode( ' ', $price[ 0 ] );
            MySql::returnSingleValue( "UPDATE tblItem SET Price = " . $price[ 1 ] . " WHERE ItemID = " . $price[ 0 ] );
        }
    }

    public static function GetItemJson()
    {
        $items = Item::find();
        $builder = [];
        foreach( $items as $item )
        {
            $builder[] = $item->returnSerializableObject();
        }

        return json_encode( $builder, JSON_PRETTY_PRINT );
    }

    public static function LoadNpcsIntoSQL()
    {
        $array = self::LoadCFG( 'npc.cfg' );
        foreach( $array as $a )
        {
            Npc::createFromCfgLine( null, $a );
        }
        return ;
    }

    public static function LoadNpcDetailsIntoSQL()
    {
        $array = self::LoadCFG( 'spawn-config.cfg' );
        foreach( $array as $a )
        {
            $description = isset( $a[ 8 ] ) ? ", Description=" . $a[ 8 ] : "";
            Mysql::returnSingleValue( "UPDATE tblNpc SET SpawnX=" . $a[1] . ", SpawnY=" . $a[2] . ", Height=" . $a[ 3 ] . ", Walk=" . $a[ 4 ] . ", MaxHit=" . $a[ 5 ] . ", Attack = " . $a[ 6 ] . ", Defence = " . $a[7] . $description . " WHERE NpcID = " . $a[ 0 ] );
        }
    }

    public static function LoadNpcDropsIntoSQL()
    {
        $array = self::LoadCFG( 'NPCDrops.TSM' );

        $npcId = 0;
        $rarity = 0;
        foreach( $array as $a )
        {
            if( strpos( $a[0], '#' ) === 0 )
            {
                $npcId = 0;
                $rarity = 1000;
                continue;
            }
            foreach( $a as $e )
            {
                $expl = explode( ':', $e );
                if( $npcId == 0 )
                {
                    $npcId = $expl[ 0 ];
                    continue;
                }
                $drop = new NpcDrop();
                $drop->NpcID = $npcId;
                $drop->ItemID = $expl[ 0 ];
                $drop->Amount = $expl[ 1 ];
                $drop->Rarity = $rarity;
                $drop->save();

            }
            $rarity = 500;
        }
    }

    public static function GetNpcJson()
    {
        $npc = Npc::find();
        $builder = [];
        foreach( $npc as $n )
        {
            $itemDrops = [];
            foreach( NpcDrop::find( new Equals( "NpcID", $n->NpcID ) ) as $d )
            {
                $itemDrops[] = [
                    "ItemID" => $d->ItemID,
                    "Amount" => $d->Amount,
                    "Rarity" => $d->Rarity
                ];
            }

            $builder[] = [
                "NpcID" => $n->NpcID,
                "NpcName" => $n->NpcName,
                "Combat" => $n->Combat,
                "Health" => $n->Health,
                "SpawnX" => $n->SpawnX,
                "SpawnY" => $n->SpawnY,
                "Height" => $n->Height,
                "Walk" => $n->Walk,
                "MaxHit" => $n->MaxHit,
                "Attack" => $n->Attack,
                "Defence" => $n->Defence,
                "Description" => $n->Description,
                "Drops" => $itemDrops
            ];
        }

        return json_encode( $builder, JSON_PRETTY_PRINT );
    }

    public static function LoadCFG( $name )
    {
        $file = @fopen( self::$dataDir . 'cfg/' . $name, 'r' );

        if( $file )
        {
            $values = [];
            while ( $line = fgets( $file ) )
            {
                if( $line && strpos( $line, '//' ) !== 0 && $line !== "" )
                {
                    $line = preg_replace( '/(.)+\ =\ /', '', $line );
                    $values[] = explode( "\t", $line );
                }
            }
            return $values;
        }
        else
        {
            return false;
        }
    }
}
<?php

namespace Cant\Phase\Me\Handler;

use Cant\Phase\Me\Models\Item;
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
            Item::createFromCfgLine( $d );
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

    public static function LoadNpcDropsIntoSQL()
    {
        $array = self::LoadCFG( 'NPCDrops.TSM' );

        $temp = [];
        $npcId = 0;
        foreach( $array as $a )
        {
            if( strpos( $a[0], '#' ) === 0 )
            {
                $temp = [];
            }
        }
    }

    public static function LoadCFG( $name )
    {
        $file = @fopen( self::$dataDir . 'cfg/' . $name, 'r' );

        if( $file )
        {
            $values = [];
            while ( $line = fgets( $file ) )
            {
                if( strpos( $line, '//' ) !== 0 )
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
<?php

namespace Cant\Phase\Me\Handler;

use Cant\Phase\Me\Models\Item;

class Server
{
    public static $dataDir = './Server/Data/';

    function __construct()
    {

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
                    Item::createFromCfgLine( explode( "\t", $line ) );
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
<?php

namespace Cant\Phase\Me\Handler;

use Cant\Phase\Me\Models\Item;

class Server
{
    public static $dataDir = './Server/Data/';
    public static $jarPath = './Server/ServerManager.jar';

    function __construct()
    {

    }

    public function getServerUptime()
    {
        return $this->execute( 'uptime' );
    }

    private function execute( $command )
    {
        $return = exec( 'java -jar ' . self::$jarPath . ' '. escapeshellarg( $command ) );
        var_dump( $return );
        return $return;
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
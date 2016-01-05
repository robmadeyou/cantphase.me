<?php

namespace Cant\Phase\Me\Handler;

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
                if( strpos( $line, '//' ) >= 1 )
                {
                    $line = preg_replace( '/(.)+\ =\ /', '', $line );
                    $values[] = $line;
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
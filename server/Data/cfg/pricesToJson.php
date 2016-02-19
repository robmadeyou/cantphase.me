<?php

$items = file_get_contents( "./prices.txt" );

$items = explode( "\n", $items );

$builder = [];
foreach( $items as $item )
{
	$exploded = explode( " ", $item );

	$obj = new stdClass();
	$obj->ItemID = $exploded[ 0 ];
	$obj->Cost = $exploded[ 1 ];
	$builder[] = $obj;
}

file_put_contents( "prices.json", json_encode( $builder ) );
<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'search' => array(
		'type' => RPC_TYPE_THRIFT,
		'option' => array(
			'balance' => 'Rpc_Balance_RoundRobin',
			'transport' => 'TFramedTransport',		
			'protocol' => NULL,	
			'ctimeout' => 1000,
			'wtimeout' => 2000,
			'rtimeout' => 7000,
		),
		'server' => array(
			array('host' => 'searchroot.sii.sdo.com', 'port' => 9090),
		),		
	),
	'sjtu_api' => array(
		'type' => RPC_TYPE_HTTP,
		'option' => array(
			'balance' => 'Rpc_Balance_RoundRobin',
			'ctimeout' => 1000,
			'wtimeout' => 2000,
			'rtimeout' => 3000,
		),
		'server' => array(
			array('host' => 'bbs.sjtu.edu.cn'),
		),		
	),
	'fudan_api' => array(
		'type' => RPC_TYPE_HTTP,
		'option' => array(
			'balance' => 'Rpc_Balance_RoundRobin',
			'ctimeout' => 1000,
			'wtimeout' => 2000,
			'rtimeout' => 4000,
		),
		'server' => array(
			array('host' => 'bbs.fudan.sh.cn'),
		),		
	),
	'newsmth_api' => array(
		'type' => RPC_TYPE_HTTP,
		'option' => array(
			'balance' => 'Rpc_Balance_RoundRobin',
			'ctimeout' => 1000,
			'wtimeout' => 2000,
			'rtimeout' => 4000,
		),
		'server' => array(
			array('host' => 'www.newsmth.net'),
		),		
	),
);
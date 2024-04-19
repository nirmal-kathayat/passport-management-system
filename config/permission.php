<?php 

return[
	"without" =>[
		'login',
		'loginProcess',
		'logout'
	],
	"allow" =>[
		"login",
		"logout"
	],
	'guard' => 'admin',
	"guest_redirect" =>'login',
	"basePrefix" => 'admin'
];
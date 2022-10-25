<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) die("This file cannot be accessed directly");

function get_env($vars) {
	$array = ['action' => [], 'params' => []];

	if (isset($vars['cmd'])) {
		//Local API mode
		$array['action'] = $vars['cmd'];
		$array['params'] = (object) $vars['apivalues1'];
		$array['adminuser'] = $vars['adminuser'];

	} else {
		//Post CURL mode
		$array['action'] = $vars['_POST']['action'];
		unset($vars['_POST']['username']);
		unset($vars['_POST']['password']);
		unset($vars['_POST']['action']);
		$array['params'] = (object) $vars['_POST'];
	}

	return (object) $array;
}

try {
	$vars = get_defined_vars();
	$request = get_env($vars);

	$query = Capsule::table('tbldomains')->select()
// Update 13.10.2022
//		->whereRaw("status = 'Active' AND (expirydate = '0000-00-00' OR expirydate IS NULL)");
		->whereRaw("
			(`status` = 'Active' AND (DAYNAME(expirydate) IS NULL OR DATEDIFF(expirydate, nextduedate) <> 30)) OR
			(`status` NOT IN('Active', 'Cancelled'))
		");


	$domains = $query->get();
	$apiresults = [
		'result' => 'success',
		'message' => 'Success Message',
		'totalresults' => sizeof($domains),
		'domains' => [
			'domain' => $domains,
		],
	];

} catch (Exception $e) {
	$apiresults = [
		'result' => 'error',
		'message' => $e->getMessage()
	];
}

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
		$array['upgradeid'] = (int) $vars['upgradeid'];
	}

	return (object) $array;
}

try {
	$vars = get_defined_vars();
	$request = get_env($vars);

	$upgradeId = isset($request->upgradeid) ? $request->upgradeid : 0;

	$query = Capsule::table('tblupgrades')->select('relid')
		->where('id', $upgradeId); 

	$result = $query->get();

	$hostingId = isset($result[0]->relid) ? (int) $result[0]->relid : 0;


	$apiresults = [
		'result' => 'success',
		'message' => 'Success Message',
		'totalresults' => 1,
		'hostingid' => $hostingId,
	];

} catch (Exception $e) {
	$apiresults = [
		'result' => 'error',
		'message' => $e->getMessage()
	];
}

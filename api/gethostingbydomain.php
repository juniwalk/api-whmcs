<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

use Illuminate\Database\Capsule\Manager as Capsule;
use Exception;

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
		$array['domain'] = (string) $vars['domain'];
	}

	return (object) $array;
}

try {
	$vars = get_defined_vars();
	$request = get_env($vars);

	if (!$domainName = $request->domain ?? null) {
		throw new Exception('Domain name is empty');
	}

	$query = Capsule::table('tblhosting AS h')
		->join('tblclients AS c', 'h.userid', '=', 'c.id')
		->join('tblproducts AS p', 'h.packageid', '=', 'p.id')
		->join('tblproductgroups AS g', 'p.gid', '=', 'g.id')
		->select(
			'h.id AS id',
			'c.id AS clientid',
			'p.id AS pid',
			'p.name',
			'g.name AS groupname',
			'h.domain AS domain',
			'h.domainstatus AS status',
			'h.diskusage',
			'h.disklimit'
		)
		->where('p.type', 'hostingaccount')
		->where('h.domain', $domainName)
		->where('h.domainstatus', 'Active');

	if (!$product = $query->get()[0] ?? null) {
		throw new Exception('Hosting was not found for domain '.$domainName);
	}

	$apiresults = [
		'result' => 'success',
		'product' => $product,
	];

} catch (Exception $e) {
	$apiresults = [
		'result' => 'error',
		'message' => $e->getMessage()
	];
}

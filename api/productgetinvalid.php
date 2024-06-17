<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 * 
 * - služba měsíční
 * 		nextduedate	nextinvoicedate
 * Monthly	2022-10-25	2022-11-25 - před zaplacením
 * Monthly	2022-11-25	2022-11-25 - po zaplacení
 */

use Illuminate\Database\Capsule\Manager as Capsule;

defined('WHMCS') or die('This file cannot be accessed directly');

try {
	$request = get_env(get_defined_vars()); 

	$query = Capsule::table('tblhosting AS h')
		->join('tblclients AS c', 'h.userid', '=', 'c.id')
		->join('tblproducts AS p', 'h.packageid', '=', 'p.id')
		->join('tblproductgroups AS g', 'p.gid', '=', 'g.id')
		->join('tblproducts_slugs AS s', type: 'left', first: function($join) {
			$join->on('p.id', '=', 's.product_id');
			$join->on('p.gid', '=', 's.group_id');
			$join->on('s.active', '=', '1');
		})
		->select(
			'h.id AS id',
			'c.id AS clientid',
			'p.id AS pid',
			'p.gid',
			'p.type',
			'p.name',
			'p.description',
			'g.name as groupname',
			'h.domain AS domain',
			'p.paytype',
			'h.domainstatus AS status',
			'h.diskusage',
			'h.disklimit',
			'h.nextduedate',
			'h.nextinvoicedate',
		)
		->selectRaw('DATEDIFF(NOW(), h.nextduedate) AS diff')
		->whereRaw("
			h.domainstatus NOT IN ('active', 'cancelled') 
			OR (
				DATEDIFF(NOW(), h.nextduedate) > 45 
				AND DATEDIFF(h.nextinvoicedate, h.nextduedate) != 0 
				AND h.billingcycle = 'Monthly' 
				AND h.domainstatus = 'active' 
			) 
			OR (
				DATEDIFF(NOW(), h.nextduedate) > 45 
				AND DATEDIFF(h.nextinvoicedate, h.nextduedate) != 0 
				AND h.billingcycle = 'Annually' 
				AND h.domainstatus = 'active' 
			)  
		")
		->orderBy('h.nextinvoicedate', 'asc');


	$products = $query->get();
	$apiresults = [
		'result' => 'success',
		'totalresults' => sizeof($products),
		'products' => [
			'product' => $products,
		],
	];

} catch (Throwable $e) {
	$apiresults = [
		'result' => 'error',
		'message' => $e->getMessage(),
	];
}

function get_env(array $vars): object
{
	$array = ['action' => [], 'params' => []];

	if (isset($vars['cmd'])) {
		// Local API mode
		$array['action'] = $vars['cmd'];
		$array['params'] = (object) $vars['apivalues1'];
		$array['adminuser'] = $vars['adminuser'];

	} else {
		// Post CURL mode
		$array['action'] = $vars['_POST']['action'];
		unset($vars['_POST']['username']);
		unset($vars['_POST']['password']);
		unset($vars['_POST']['action']);
		$array['params'] = (object) $vars['_POST'];
	}

	return (object) $array;
}

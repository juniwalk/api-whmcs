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

/*
SELECT
	c.id AS clientId,
	p.id AS productId,
	h.id AS serviceId,
	h.domain,
	h.domainstatus AS `status`,
	p.`name` AS productName,
	h.regdate,
	h.nextduedate,
	h.nextinvoicedate,
	h.billingcycle,
	DATEDIFF( NOW(), h.nextduedate ) AS diff
FROM
	tblhosting AS h
	INNER JOIN tblclients AS c ON h.userid = c.id
	INNER JOIN tblproducts AS p ON h.packageid = p.id 
WHERE
	h.domainstatus NOT IN ( 'active', 'cancelled' ) 
	OR (
		DATEDIFF( NOW(), h.nextduedate ) > 45 
		AND DATEDIFF( h.nextinvoicedate, h.nextduedate ) != 0 
		AND h.billingcycle = 'Monthly' 
		AND h.domainstatus = 'active' 
	) 
	OR (
		DATEDIFF( NOW(), h.nextduedate ) > 45 
		AND DATEDIFF( h.nextinvoicedate, h.nextduedate ) != 0 
		AND h.billingcycle = 'Annually' 
		AND h.domainstatus = 'active' 
	) 
ORDER BY
	h.nextinvoicedate ASC;

- služba měsíční 
		nextduedate	nextinvoicedate
Monthly	2022-10-25	2022-11-25 - před zaplacením
Monthly	2022-11-25	2022-11-25 - po zaplacení

*/

	$query = Capsule::table('tblhosting AS h')
		->join('tblclients AS c', 'h.userid', '=', 'c.id')
		->join('tblproducts AS p', 'h.packageid', '=', 'p.id')
		->select(
			'c.id AS clientId',
			'p.id AS productId',
			'h.id AS serviceId',
			'h.domain AS domain',
			'h.domainstatus AS status',
			'p.name AS productName',
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
		'message' => 'Success Message',
		'totalresults' => sizeof($products),
		'products' => $products,
	];

} catch (Exception $e) {
	$apiresults = [
		'result' => 'error',
		'message' => $e->getMessage()
	];
}

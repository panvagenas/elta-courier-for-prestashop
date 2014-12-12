<?php
/**
 * eltacourier
 * Hooks.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 12/12/2014
 * Time: 10:47 πμ
 * Copyright: 2014 Panagiotis Vagenas
 */

namespace EltaCourier;

if (!defined('_PS_VERSION_'))
	exit;

class Hooks extends \XDaRk\Hooks{
	/**
	 * @param $params
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since ${VERSION}
	 */
	public function hookActionCarrierUpdate( $params ) {
		$params = end($params);
		$old_id_carrier = (int)$params['id_carrier'];
		$new_id_carrier = (int)$params['carrier']->id;
		if (\Configuration::get('ELTA_CLDE') == $old_id_carrier)
			\Configuration::updateValue('ELTA_CLDE', $new_id_carrier);
	}
} 
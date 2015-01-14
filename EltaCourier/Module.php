<?php
/**
 * eltacourier
 * ${FILE_NAME}
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 12/12/2014
 * Time: 9:48 πμ
 * Copyright: 2014 Panagiotis Vagenas
 */

namespace EltaCourier;


if (!defined('_PS_VERSION_'))
  exit;

require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'CarrierModule.php';

class Module extends \XDaRk\CarrierModule{
	/**
	 * TODO
	 * @var string Name of this plugin
	 */
	public $name = 'eltacourier';
	/**
	 * TODO
	 * @var string Description
	 */
	public $description = 'ELTA Courier Module For PrestaShop';
	/**
	 * TODO
	 * @var string
	 */
	public $tab = 'shipping_logistics';
	/**
	 * TODO
	 * @var string
	 */
	public $version = '141212';
	/**
	 * TODO
	 * @var string
	 */
	public $author = 'Panagiotis Vagenas <pan.vagenas@gmail.com>';
	/**
	 * TODO
	 * @var int
	 */
	public $need_instance = 0;
	/**
	 * TODO
	 * @var array
	 */
	public $ps_versions_compliancy = array('min' => '1.5');
	/**
	 * TODO
	 * @var array
	 */
	public $dependencies = array();
	/**
	 * TODO
	 * @var string
	 */
	public $displayName = 'ELTA Courier';
	/**
	 * TODO
	 * @var bool
	 */
	public $bootstrap = true;


	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 141110
	 */
	protected function xdGetContent()
	{
		return '';

	}

	/**
	 * @param $params
	 * @param $shipping_cost
	 *
	 * @return bool|float|int
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since ${VERSION}
	 */
	public function getOrderShippingCost($params, $shipping_cost){
		return $this->getOrderShippingCostExternal( $params );
	}

	public function getContext(){
		return $this->context;
	}

	/**
	 * @param \Cart $cart
	 *
	 * @return bool|float|int
	 * @throws \Exception
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since ${VERSION}
	 */
	public function getOrderShippingCostExternal($cart){
		$addressObj = new \Address( $cart->id_address_delivery );

		$country = mb_strtolower($addressObj->country);
		$countryChecks = array('greece', 'ελλάδα', 'ελλαδα', 'ελλας', 'ελλάς', 'el', 'el_gr', 'ellada', 'ellas', 'hellas', 'gr');
		if(!in_array($country, $countryChecks)){
			return false;
		}

		if($cart->getOrderTotal(true, \Cart::ONLY_PRODUCTS) > $this->Options->getValue('freeShippingAbove')){
			return 0;
		}

		return $this->calculatePrice($cart->getTotalWeight());
	}

	public function calculatePrice($weight){
		if($weight < 3)
			$price = 2.5;
		else
			$price = (ceil($weight) - 3) * 1 + 2.5;

		return $price;
	}
}

$GLOBALS['eltacourier'] = array(
	'root_ns' => __NAMESPACE__,
	'var_ns'  => 'elc',
	'dir'     => dirname(dirname(__FILE__))
);
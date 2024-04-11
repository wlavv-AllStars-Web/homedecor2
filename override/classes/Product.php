<?php
/**
 * 2007-2015 Leotheme
 *
 * NOTICE OF LICENSE
 *
 * ApPageBuilder is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @author    Leotheme <leotheme@gmail.com>
 *  @copyright 2007-2019 Leotheme
 *  @license   http://leotheme.com - prestashop template provider
 */
class Product extends ProductCore {
	/*
    * module: leoelements
    * date: 2024-04-08 15:08:17
    * version: 1.0.4
    */
    public $leoe_layout;
	/*
    * module: leoelements
    * date: 2024-04-08 15:08:17
    * version: 1.0.4
    */
    public $leoe_layout_mobile;
	/*
    * module: leoelements
    * date: 2024-04-08 15:08:17
    * version: 1.0.4
    */
    public $leoe_layout_tablet;
	/*
    * module: leoelements
    * date: 2024-04-08 15:08:17
    * version: 1.0.4
    */
    public $leoe_extra_1;
	/*
    * module: leoelements
    * date: 2024-04-08 15:08:17
    * version: 1.0.4
    */
    public $leoe_extra_2;
	 
	/*
    * module: leoelements
    * date: 2024-04-08 15:08:17
    * version: 1.0.4
    */
    public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null){
                self::$definition['fields']['leoe_layout'] = [
	            'type' => self::TYPE_HTML,
	            'required' => false,
	            'shop' => true,
	            'validate' => 'isCleanHtml'
	        ];
	        self::$definition['fields']['leoe_layout_mobile'] = [
	            'type' => self::TYPE_HTML,
	            'required' => false,
	            'shop' => true,
	            'validate' => 'isCleanHtml'
	        ];
	        self::$definition['fields']['leoe_layout_tablet'] = [
	            'type' => self::TYPE_HTML,
	            'required' => false,
	            'shop' => true,
	            'validate' => 'isCleanHtml'
	        ];
	 
	        self::$definition['fields']['leoe_extra_1'] = [
	            'type' => self::TYPE_HTML,
	            'lang' => true,
	            'required' => false,
	            'validate' => 'isCleanHtml'
	        ];
	        self::$definition['fields']['leoe_extra_2'] = [
	            'type' => self::TYPE_HTML,
	            'lang' => true,
	            'required' => false,
	            'validate' => 'isCleanHtml'
	        ];
	        parent::__construct($id_product, $full, $id_lang, $id_shop, $context);
	}
}
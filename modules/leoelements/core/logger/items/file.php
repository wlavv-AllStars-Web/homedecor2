<?php
/**
 * 2007-2022 Apollotheme
 *
 * NOTICE OF LICENSE
 *
 * LeoElements is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @author    Apollotheme <apollotheme@gmail.com>
 *  @copyright 2007-2022 Apollotheme
 *  @license   http://apollotheme.com - prestashop template provider
 */

namespace LeoElements\Core\Logger\Items;

use LeoElements\Leo_Helper; 

if ( ! defined( '_PS_VERSION_' ) ) {
	exit; // Exit if accessed directly
}

class File extends Base {

	const FORMAT = 'date [type X times][file:line] message [meta]';

	protected $file;
	protected $line;

	public function __construct( $args ) {
		parent::__construct( $args );

		$this->file = empty( $args['file'] ) ? '' : $args['file'];
		$this->line = empty( $args['line'] ) ? '' : $args['line'];
	}

	public function jsonSerialize() {
		$json_arr = parent::jsonSerialize();
		$json_arr['file'] = $this->file;
		$json_arr['line'] = $this->line;
		return $json_arr;
	}

	public function deserialize( $properties ) {
		parent::deserialize( $properties );
		$this->file = ! empty( $properties['file'] ) && is_string( $properties['file'] ) ? $properties['file'] : '';
		$this->line = ! empty( $properties['line'] ) && is_string( $properties['line'] ) ? $properties['line'] : '';
	}

	public function get_name() {
		return 'File';
	}
}

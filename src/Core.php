<?php

namespace Flanny\PLB;

use Flanny\PLB\Util;

/**
 * Class Core
 *
 * @package Flanny\PLB
 */
class Core {

	/**
	 * @var Core $instance
	 */
	private static $instance;

	public function __construct() {
		if ( ! empty( self::$instance ) ) {
			return;
		}

		Util\Register::hook();
	}

	/**
	 * @return Core
	 */
	public static function instance() {
		if ( ! empty( self::$instance ) ) {
			return self::$instance;
		}

		$core = new Core();
		self::$instance = $core;
		return self::$instance;
	}

}

<?php
/**
 * Basic Pantry Plugin class
 * 
 * Handles registering of the Pantry Widget.
 *  
 * @author Brian Zoetewey <Omicron7@gmail.com>
 */
class ReciPress_PantryPlugin {
	/**
	 * WordPress localization textdomain
	 * @var string
	 */
	const TEXT_DOMAIN = 'pantrywidget';

	/**
	 * Singleton instance
	 * @var ReciPress_PantryPlugin
	 */
	private static $instance;

	/**
	 * Returns the ReciPress_PantryPlugin singleton
	 *
	 * <code>$obj = ReciPress_PantryPlugin::singleton();</code>
	 * @return ReciPress_PantryPlugin
	 */
	public static function singleton() {
		if( !isset( self::$instance ) ) {
			$class = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	/**
	 * Prevent cloning of the ReciPress_PantryPlugin object
	 * @internal
	 */
	private function __clone() {
	}

	/**
	 * Pantry Plugin constructor
	 */
	private function __construct() {
		load_plugin_textdomain( self::TEXT_DOMAIN, false, 'languages' );
		
		$this->register_actions_filters();
	}

	/**
	 * Registers any necessary WordPress actions and filters
	 */
	private function register_actions_filters() {
		add_action( 'widgets_init', array( &$this, 'register_widgets' ), 10, 0 );
	}

	/**
	 * Registers the Pantry Widget with WordPress
	 * Callback for 'widgets_init' action
	 */
	public function register_widgets() {
		if( defined( 'RECIPRESS_DIR' ) )
			register_widget( 'ReciPress_PantryWidget' );
	}
}

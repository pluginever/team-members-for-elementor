<?php
namespace Pluginever\TME;

class Scripts{

	/**
	 * Constructor for the class
	 *
	 * Sets up all the appropriate hooks and actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
//		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets') );
		add_action( 'elementor/frontend/after_register_scripts', array( __CLASS__, 'load_assets') );
    }

   	/**
	 * Add all the assets required by the plugin
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function load_assets(){
		$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';
		wp_register_style('team-members-for-elementor', TME_ASSETS."/css/team-members-for-elementor{$suffix}.css", [], date('i'));
		wp_enqueue_style('team-members-for-elementor');
	}



}

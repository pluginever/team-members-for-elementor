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
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets') );
		add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'load_assets') );
    }

   	/**
	 * Add all the assets required by the plugin
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function load_assets(){
		$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';
		wp_register_style('team-members-for-elementor', TME_ASSETS."/css/team-members-for-elementor{$suffix}.css", [], date('i'));
//		wp_register_script('team-members-for-elementor', TME_ASSETS.'/js/team-members-for-elementor{$suffix}.js', ['jquery'], date('i'), true);
//		wp_localize_script('team-members-for-elementor', 'jsobject', ['ajaxurl' => admin_url( 'admin-ajax.php' )]);
		wp_enqueue_style('team-members-for-elementor');
//		wp_enqueue_script('team-members-for-elementor');
	}



}

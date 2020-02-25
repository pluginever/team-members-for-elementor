<?php
/**
 * Plugin Name: Team Members for Elementor
 * Plugin URI:  http://pluginever.com
 * Description: Elementor extension fow showing team members profile
 * Version:     1.0.4
 * Author:      pluginever
 * Author URI:  https://www.pluginever.com
 * Donate link: https://www.pluginever.com
 * License:     GPLv2+
 * Text Domain: ever_team_members
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2019 PluginEver (email : support@pluginever.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main initiation class
 *
 * @since 1.0.0
 */
class Team_Members_For_Elementor {

    /**
     * Add-on Version
     *
     * @since 1.0.0
     * @var  string
     */
    public $version = '1.0.4';

    /**
     * Minimum PHP version required
     *
     * @var string
     */
    private $min_php = '5.4.0';


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
        // dry check on older PHP versions, if found deactivate itself with an error
        register_activation_hook( __FILE__, array( $this, 'auto_deactivate' ) );

        if ( ! $this->is_supported_php() ) {
            return;
        }

        // Define constants
        $this->define_constants();

        // Include required files
        $this->includes();

        // instantiate classes
        $this->instantiate();

        // Initialize the action hooks
        $this->init_hooks();

    }

    /**
     * Initializes the class
     *
     * Checks for an existing instance
     * and if it does't find one, creates it.
     *
     * @since 1.0.0
     *
     * @return object Class instance
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define constants
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function define_constants() {

        define( 'TME_VERSION', $this->version );
        define( 'TME_FILE', __FILE__ );
        define( 'TME_PATH', dirname( TME_FILE ) );
        define( 'TME_INCLUDES', TME_PATH . '/includes' );
        define( 'TME_URL', plugins_url( '', TME_FILE ) );
        define( 'TME_ASSETS', TME_URL . '/assets' );
        define( 'TME_VIEWS', TME_PATH . '/views' );
        define( 'TME_TEMPLATES_DIR', TME_PATH . '/templates' );
    }

    /**
     * Include required files
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function includes() {
        require TME_INCLUDES . '/functions.php';
        require TME_INCLUDES . '/class-element.php';
        require TME_INCLUDES . '/class-scripts.php';
    }



    /**
     * Init Hooks
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function init_hooks() {
        // Localize our plugin
        add_action( 'init', [ $this, 'localization_setup' ] );

        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
    }

    /**
     * Initialize plugin for localization
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function localization_setup() {
        load_plugin_textdomain( 'ever_team_members', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Instantiate classes
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function instantiate() {
        new \Pluginever\TME\Element();
        new \Pluginever\TME\Scripts();
    }

    /**
     * Plugin action links
     *
     * @param  array $links
     *
     * @return array
     */
    function plugin_action_links( $links ) {

        //$links[] = '<a href="' . admin_url( 'admin.php?page=' ) . '">' . __( 'Settings', '' ) . '</a>';

        return $links;
    }



    /**
     * Check if the PHP version is supported
     *
     * @return bool
     */
    public function is_supported_php( $min_php = null ) {

        $min_php = $min_php ? $min_php : $this->min_php;

        if ( version_compare( PHP_VERSION, $min_php, '<=' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Show notice about PHP version
     *
     * @return void
     */
    function php_version_notice() {

        if ( $this->is_supported_php() || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $error = __( 'Your installed PHP Version is: ', 'ever_team_members' ) . PHP_VERSION . '. ';
        $error .= __( 'The <strong>Team Members for Elementor</strong> plugin requires PHP version <strong>', 'ever_team_members' ) . $this->min_php . __( '</strong> or greater.', 'ever_team_members' );
        ?>
        <div class="error">
            <p><?php printf( $error ); ?></p>
        </div>
        <?php
    }

    /**
     * Bail out if the php version is lower than
     *
     * @return void
     */
    function auto_deactivate() {
        if ( $this->is_supported_php() ) {
            return;
        }

        deactivate_plugins( plugin_basename( __FILE__ ) );

        $error = __( '<h1>An Error Occured</h1>', 'ever_team_members' );
        $error .= __( '<h2>Your installed PHP Version is: ', 'ever_team_members' ) . PHP_VERSION . '</h2>';
        $error .= __( '<p>The <strong>Team Members for Elementor</strong> plugin requires PHP version <strong>', 'ever_team_members' ) . $this->min_php . __( '</strong> or greater', 'ever_team_members' );
        $error .= __( '<p>The version of your PHP is ', 'ever_team_members' ) . '<a href="http://php.net/supported-versions.php" target="_blank"><strong>' . __( 'unsupported and old', 'ever_team_members' ) . '</strong></a>.';
        $error .= __( 'You should update your PHP software or contact your host regarding this matter.</p>', 'ever_team_members' );

        wp_die( $error, __( 'Plugin Activation Error', 'ever_team_members' ), array( 'back_link' => true ) );
    }


}

/**
 * Initialize the plugin
 *
 * @return object
 */
function team_members_for_elementor() {
    return Team_Members_For_Elementor::init();
}

// kick-off
team_members_for_elementor();

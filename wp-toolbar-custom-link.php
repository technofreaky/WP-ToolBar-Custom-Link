<?php
/**
 * Plugin Name:       WP ToolBar Custom Link
 * Plugin URI:        https://wordpress.org/plugins/woocommerce-plugin-boiler-plate/
 * Description:       This plugin allows you to add custom links and menus to the WordPress ToolBar
 * Version:           0.1
 * Author:            Varun Sridharan
 * Author URI:        http://varunsridharan.in 
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt 
 * GitHub Plugin URI: https://github.com/technofreaky/WP-ToolBar-Custom-Link
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WordPress_ToolBar_Custom_Link{

    public function __construct() {
        register_activation_hook( __FILE__,  array($this,'welcome_screen_activate') );
        add_action( 'admin_init',  array($this,'welcome_screen_do_activation_redirect') ); 
        add_action( 'admin_head',  array($this,'welcome_screen_remove_menus') );
        
        add_action('admin_bar_menu', array($this,'custom_toolbar_link'), 999);
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_filter( 'plugin_row_meta', array($this, 'plugin_row_links' ), 10, 2 );
    }
    
    public function welcome_screen_activate() {
        set_transient( '_wp_tcl_welcome_screen_activation_redirect', true, 30 );
    }
    
    
    public function welcome_screen_do_activation_redirect() {
        if ( ! get_transient( '_wp_tcl_welcome_screen_activation_redirect' ) ) { return; }
        delete_transient( '_wp_tcl_welcome_screen_activation_redirect' );
        if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) { return; }
        wp_safe_redirect( add_query_arg( array( 'page' => 'wc-tcl-welcome-screen-about' ), admin_url( 'index.php' ) ) );

    }
    
     
    
    function welcome_screen_remove_menus() {
        remove_submenu_page( 'index.php', 'wc-tcl-welcome-screen-about' );
    }
    
    
    public function welcome_screen_content(){
        include('welcome.php');
    }
    
    public function admin_menu(){
        add_options_page('WP ToolBar Custom Link','WP ToolBar Link', 'manage_options',    'wp_toolbar_custom_link',array($this,'settings_page'));
        add_dashboard_page('Welcome To WP ToolBar Custom Link','Welcome To WP ToolBar Custom Link',
        'read', 'wc-tcl-welcome-screen-about', array($this,'welcome_screen_content')
        );
    }
    
    
    public function custom_toolbar_link($wp_admin_bar){
        $options = get_option('wptbcl_links');
        
        if(! empty($options)){
            foreach($options as $option){
                $args = array(
                    'id' => $option['slug'],
                    'title' => $option['name'], 
                    'href' => $option['link'], 
                    'meta' => array(
                    'class' => $option['class'], 
                    'title' => $option['title']
                    )
                ); 
                if(!empty($option['parentid'])){
                    $args['parent'] = $option['parentid'];
                }
                $wp_admin_bar->add_node($args);
                unset($args);
            }
        }
        return $wp_admin_bar;    
    }
    
    
    
    public function settings_page(){
        echo '<div class="wrap">';
        echo '<h1>WordPress ToolBar Custom Link</h1>';
        $this->save_settings();
        include('template.php');
        echo '</div>';
    }
    
    public function save_settings(){
        
        
        
            
        if(isset($_POST['wptbcl_save'])){
            $value = $this->array_filter_recursive($_POST['wptbcl']);
            update_option('wptbcl_links',$value);
        }
    }
    
    public function array_filter_recursive($input){
    foreach ($input as &$value){
        if (is_array($value)){
            $value = $this->array_filter_recursive($value);
        }
    }
    return array_filter($input);
    }
    
    
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) { 
		if ( 'wp-toobar-custom-link/wp-toobar-custom-link.php' == $plugin_file ) {
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 
                                     admin_url('options-general.php?page=wp_toolbar_custom_link')
                                     , __('Settings') );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', '#', __('F.A.Q') );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/technofreaky/WP-ToolBar-Custom-Link/', __('View On Github') );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/technofreaky/WP-ToolBar-Custom-Link/issues', __('Report Issue') );
            $plugin_meta[] = sprintf('&hearts; <a href="%s">%s</a>', 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4ENCKPZYWWSEL', __('Donate') );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'http://varunsridharan.in/plugin-support/', __('Contact Author') );
		}
		return $plugin_meta;
	}	
    
}
new WordPress_ToolBar_Custom_Link;

?>
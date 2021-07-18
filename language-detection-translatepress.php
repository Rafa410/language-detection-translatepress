<?php 
/**
 * @wordpress-plugin
 * Plugin Name:       Language detection for TranslatePress
 * Plugin URI:        https://github.com/Rafa410/language-detection-translatepress
 * Description:       Automatic language detection and redirection for TranslatePress
 * Version:           1.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Rafa Soler
 * Author URI:        https://github.com/Rafa410
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       language-detection-translatepress
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or die;

define( 'LDT_DIR', plugin_dir_path( __FILE__ ) );

add_action( 'init', 'wpdocs_load_textdomain' );
function wpdocs_load_textdomain() {
  load_plugin_textdomain( 'language-detection-translatepress', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

if ( is_admin() ) {
    require_once LDT_DIR . 'admin/language-detection-translatepress-admin.php';
} else {
    require_once LDT_DIR . 'includes/main.php';
}

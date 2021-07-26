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
define( 'LDT_VERSION' , '1.0.0');

require_once LDT_DIR . 'includes/class-ldt-main.php';

function run_ldt() {
  $ldt = new LDT_Main();
}
run_ldt();

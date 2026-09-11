<?php
/**
 * Plugin Name: SapyensDev Skeleton
 * Description: Skeleton de plugin WordPress de ejemplo para arrancar nuevos desarrollos.
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Author: SapyensDev
 * Author URI: https://sapyensdev.com
 * License: MIT
 * Text Domain: sapyensdev-skeleton
 */

if (!defined('ABSPATH')) {
    exit;
}

define('SAPYENSDEVSKELETON_VERSION', '1.0.0');
define('SAPYENSDEVSKELETON_PATH', plugin_dir_path(__FILE__));
define('SAPYENSDEVSKELETON_URL', plugin_dir_url(__FILE__));

require_once SAPYENSDEVSKELETON_PATH . 'includes/class-sapyensdevskeleton-item.php';
require_once SAPYENSDEVSKELETON_PATH . 'includes/class-sapyensdevskeleton-admin.php';
require_once SAPYENSDEVSKELETON_PATH . 'includes/class-sapyensdevskeleton-settings.php';
require_once SAPYENSDEVSKELETON_PATH . 'public/class-sapyensdevskeleton-public.php';

register_activation_hook(__FILE__, 'sapyensdevskeleton_activar');
register_deactivation_hook(__FILE__, 'sapyensdevskeleton_desactivar');
add_action('plugins_loaded', 'sapyensdevskeleton_cargar_textdomain');

/**
 * Carga las traducciones del plugin desde la carpeta languages/, con el
 * mismo Text Domain declarado en la cabecera.
 */
function sapyensdevskeleton_cargar_textdomain()
{
    load_plugin_textdomain(
        'sapyensdev-skeleton',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
}

/**
 * Se ejecuta al activar el plugin, valida los requisitos mínimos, crea la
 * tabla propia y los valores de configuración por defecto. Corta la
 * activación con un mensaje claro si algo falla, en vez de dejar el
 * plugin activo a medias.
 */
function sapyensdevskeleton_activar()
{
    global $wpdb, $wp_version;

    if (version_compare(PHP_VERSION, '7.4', '<')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            esc_html__('SapyensDev Skeleton requiere PHP 7.4 o superior, tu servidor tiene una versión más antigua.', 'sapyensdev-skeleton')
        );
    }

    if (version_compare($wp_version, '5.0', '<')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            esc_html__('SapyensDev Skeleton requiere WordPress 5.0 o superior, actualizá tu instalación antes de activarlo.', 'sapyensdev-skeleton')
        );
    }

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset_collate = $wpdb->get_charset_collate();
    $tabla = $wpdb->prefix . 'sapyensdevskeleton_items';

    $sql = "CREATE TABLE {$tabla} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(255) NOT NULL,
        fecha_alta DATETIME NOT NULL,
        PRIMARY KEY  (id)
    ) {$charset_collate};";

    dbDelta($sql);

    if (!empty($wpdb->last_error)) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            esc_html__('SapyensDev Skeleton no pudo crear su tabla en la base de datos, revisa los permisos del usuario de MySQL.', 'sapyensdev-skeleton')
        );
    }

    add_option('sapyensdevskeleton_mensaje', 'Hola desde SapyensDev');
}

/**
 * Se ejecuta al desactivar el plugin. No borra datos propios, WordPress
 * espera que la desactivación sea reversible, la limpieza real de la
 * tabla y las opciones vive en uninstall.php.
 */
function sapyensdevskeleton_desactivar()
{
    flush_rewrite_rules();
}

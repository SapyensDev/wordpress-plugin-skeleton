<?php
/**
 * Se ejecuta solo cuando el usuario borra el plugin desde el admin de
 * WordPress, nunca en una simple desactivación. Aquí va toda la limpieza
 * real, tabla propia y opciones.
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

$tabla = $wpdb->prefix . 'sapyensdevskeleton_items';

$wpdb->query("DROP TABLE IF EXISTS {$tabla}");

delete_option('sapyensdevskeleton_mensaje');

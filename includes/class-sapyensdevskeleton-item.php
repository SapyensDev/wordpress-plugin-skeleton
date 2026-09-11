<?php
/**
 * Modelo de ejemplo sobre la tabla propia del plugin.
 * Usar como base para cualquier entidad con CRUD en el admin.
 */

if (!defined('ABSPATH')) {
    exit;
}

class SapyensDevSkeleton_Item
{
    /**
     * Nombre completo de la tabla propia, con el prefijo de la instalación.
     */
    public static function tabla()
    {
        global $wpdb;

        return $wpdb->prefix . 'sapyensdevskeleton_items';
    }

    /**
     * Devuelve todos los elementos, ordenados por fecha de alta descendente.
     */
    public static function todos()
    {
        global $wpdb;

        $tabla = self::tabla();

        return $wpdb->get_results("SELECT * FROM {$tabla} ORDER BY fecha_alta DESC");
    }

    /**
     * Devuelve un elemento por su ID, o null si no existe.
     */
    public static function obtener($id)
    {
        global $wpdb;

        $tabla = self::tabla();

        return $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$tabla} WHERE id = %d", $id)
        );
    }

    /**
     * Crea un elemento nuevo, sella la fecha de alta automáticamente.
     * Devuelve el ID insertado, o false si falla.
     */
    public static function crear($nombre)
    {
        global $wpdb;

        $tabla = self::tabla();

        $insertado = $wpdb->insert(
            $tabla,
            [
                'nombre' => sanitize_text_field($nombre),
                'fecha_alta' => current_time('mysql'),
            ],
            ['%s', '%s']
        );

        return $insertado ? (int) $wpdb->insert_id : false;
    }

    /**
     * Actualiza el nombre de un elemento existente.
     */
    public static function actualizar($id, $nombre)
    {
        global $wpdb;

        $tabla = self::tabla();

        return $wpdb->update(
            $tabla,
            ['nombre' => sanitize_text_field($nombre)],
            ['id' => (int) $id],
            ['%s'],
            ['%d']
        );
    }

    /**
     * Elimina un elemento por su ID.
     */
    public static function eliminar($id)
    {
        global $wpdb;

        $tabla = self::tabla();

        return $wpdb->delete($tabla, ['id' => (int) $id], ['%d']);
    }
}

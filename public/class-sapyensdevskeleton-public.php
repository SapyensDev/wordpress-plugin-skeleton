<?php
/**
 * Parte pública del plugin, carga de assets del front y shortcode de
 * ejemplo que muestra el mensaje configurado.
 */

if (!defined('ABSPATH')) {
    exit;
}

class SapyensDevSkeleton_Public
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'cargar_assets']);
        add_shortcode('sapyensdevskeleton_mensaje', [$this, 'renderizar_shortcode']);
    }

    /**
     * Carga el CSS y el JS del plugin en el front, equivalente al hook
     * displayHeader de PrestaShop.
     */
    public function cargar_assets()
    {
        wp_enqueue_style(
            'sapyensdevskeleton-front',
            SAPYENSDEVSKELETON_URL . 'assets/css/front.css',
            [],
            SAPYENSDEVSKELETON_VERSION
        );

        wp_enqueue_script(
            'sapyensdevskeleton-front',
            SAPYENSDEVSKELETON_URL . 'assets/js/front.js',
            [],
            SAPYENSDEVSKELETON_VERSION,
            true
        );
    }

    /**
     * Shortcode [sapyensdevskeleton_mensaje], imprime el mensaje guardado
     * en los ajustes del plugin.
     */
    public function renderizar_shortcode()
    {
        $mensaje = get_option('sapyensdevskeleton_mensaje', 'Hola desde SapyensDev');

        return '<div class="sapyensdevskeleton-mensaje">' . esc_html($mensaje) . '</div>';
    }
}

new SapyensDevSkeleton_Public();

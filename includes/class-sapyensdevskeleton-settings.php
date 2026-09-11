<?php
/**
 * Página de ajustes del plugin, registrada bajo Ajustes del admin de
 * WordPress usando la Settings API estándar.
 */

if (!defined('ABSPATH')) {
    exit;
}

class SapyensDevSkeleton_Settings
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'registrar_menu']);
        add_action('admin_init', [$this, 'registrar_ajustes']);
    }

    /**
     * Añade la página de ajustes dentro del menú Ajustes de WordPress.
     */
    public function registrar_menu()
    {
        add_options_page(
            __('SapyensDev Skeleton', 'sapyensdev-skeleton'),
            __('SapyensDev Skeleton', 'sapyensdev-skeleton'),
            'manage_options',
            'sapyensdevskeleton-settings',
            [$this, 'renderizar_pagina']
        );
    }

    /**
     * Registra el ajuste, la sección y el campo del formulario.
     */
    public function registrar_ajustes()
    {
        register_setting('sapyensdevskeleton_ajustes', 'sapyensdevskeleton_mensaje', [
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 'Hola desde SapyensDev',
        ]);

        add_settings_section(
            'sapyensdevskeleton_seccion_principal',
            __('Ajustes generales', 'sapyensdev-skeleton'),
            '__return_false',
            'sapyensdevskeleton-settings'
        );

        add_settings_field(
            'sapyensdevskeleton_mensaje',
            __('Mensaje a mostrar', 'sapyensdev-skeleton'),
            [$this, 'renderizar_campo_mensaje'],
            'sapyensdevskeleton-settings',
            'sapyensdevskeleton_seccion_principal'
        );
    }

    /**
     * Renderiza el campo de texto del ajuste.
     */
    public function renderizar_campo_mensaje()
    {
        $valor = get_option('sapyensdevskeleton_mensaje', 'Hola desde SapyensDev');
        ?>
        <input
            type="text"
            name="sapyensdevskeleton_mensaje"
            value="<?php echo esc_attr($valor); ?>"
            class="regular-text"
        >
        <?php
    }

    /**
     * Renderiza la página completa de ajustes.
     */
    public function renderizar_pagina()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Ajustes de SapyensDev Skeleton', 'sapyensdev-skeleton'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('sapyensdevskeleton_ajustes');
                do_settings_sections('sapyensdevskeleton-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

new SapyensDevSkeleton_Settings();

<?php
/**
 * Pantalla de administración con listado y formulario (CRUD) sobre
 * SapyensDevSkeleton_Item.
 */

if (!defined('ABSPATH')) {
    exit;
}

class SapyensDevSkeleton_Admin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'registrar_menu']);
        add_action('admin_post_sapyensdevskeleton_guardar', [$this, 'guardar']);
        add_action('admin_post_sapyensdevskeleton_eliminar', [$this, 'eliminar']);
        add_action('admin_enqueue_scripts', [$this, 'cargar_assets_admin']);
    }

    /**
     * Registra la página del plugin en el menú de administración.
     */
    public function registrar_menu()
    {
        add_menu_page(
            __('SapyensDev Skeleton', 'sapyensdev-skeleton'),
            __('SapyensDev Skeleton', 'sapyensdev-skeleton'),
            'manage_options',
            'sapyensdevskeleton',
            [$this, 'renderizar_pagina'],
            'dashicons-admin-generic'
        );
    }

    /**
     * Carga CSS propio solo en la pantalla del plugin, equivalente al hook
     * displayBackOfficeHeader de PrestaShop.
     */
    public function cargar_assets_admin($hook)
    {
        if ($hook !== 'toplevel_page_sapyensdevskeleton') {
            return;
        }

        wp_enqueue_style(
            'sapyensdevskeleton-admin',
            SAPYENSDEVSKELETON_URL . 'assets/css/admin.css',
            [],
            SAPYENSDEVSKELETON_VERSION
        );
    }

    /**
     * Guarda un elemento nuevo, procesa el formulario de alta.
     */
    public function guardar()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('No tienes permisos para realizar esta acción.', 'sapyensdev-skeleton'));
        }

        check_admin_referer('sapyensdevskeleton_guardar');

        $nombre = isset($_POST['nombre']) ? sanitize_text_field(wp_unslash($_POST['nombre'])) : '';

        if ('' !== $nombre) {
            SapyensDevSkeleton_Item::crear($nombre);
        }

        wp_safe_redirect(admin_url('admin.php?page=sapyensdevskeleton'));
        exit;
    }

    /**
     * Elimina un elemento existente.
     */
    public function eliminar()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('No tienes permisos para realizar esta acción.', 'sapyensdev-skeleton'));
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        check_admin_referer('sapyensdevskeleton_eliminar_' . $id);

        if ($id > 0) {
            SapyensDevSkeleton_Item::eliminar($id);
        }

        wp_safe_redirect(admin_url('admin.php?page=sapyensdevskeleton'));
        exit;
    }

    /**
     * Renderiza el listado y el formulario de alta.
     */
    public function renderizar_pagina()
    {
        $elementos = SapyensDevSkeleton_Item::todos();
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('SapyensDev Skeleton', 'sapyensdev-skeleton'); ?></h1>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="sapyensdevskeleton_guardar">
                <?php wp_nonce_field('sapyensdevskeleton_guardar'); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="nombre"><?php esc_html_e('Nombre', 'sapyensdev-skeleton'); ?></label></th>
                        <td><input type="text" id="nombre" name="nombre" class="regular-text" required></td>
                    </tr>
                </table>
                <?php submit_button(__('Añadir elemento', 'sapyensdev-skeleton')); ?>
            </form>

            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('ID', 'sapyensdev-skeleton'); ?></th>
                        <th><?php esc_html_e('Nombre', 'sapyensdev-skeleton'); ?></th>
                        <th><?php esc_html_e('Fecha de alta', 'sapyensdev-skeleton'); ?></th>
                        <th><?php esc_html_e('Acciones', 'sapyensdev-skeleton'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($elementos)) : ?>
                        <tr>
                            <td colspan="4"><?php esc_html_e('Todavía no hay elementos.', 'sapyensdev-skeleton'); ?></td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($elementos as $elemento) : ?>
                            <tr>
                                <td><?php echo esc_html($elemento->id); ?></td>
                                <td><?php echo esc_html($elemento->nombre); ?></td>
                                <td><?php echo esc_html($elemento->fecha_alta); ?></td>
                                <td>
                                    <a href="<?php echo esc_url(wp_nonce_url(
                                        admin_url('admin-post.php?action=sapyensdevskeleton_eliminar&id=' . $elemento->id),
                                        'sapyensdevskeleton_eliminar_' . $elemento->id
                                    )); ?>" onclick="return confirm('<?php echo esc_js(__('¿Eliminar este elemento?', 'sapyensdev-skeleton')); ?>')">
                                        <?php esc_html_e('Eliminar', 'sapyensdev-skeleton'); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}

new SapyensDevSkeleton_Admin();

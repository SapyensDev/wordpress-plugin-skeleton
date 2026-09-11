# WordPress Plugin Skeleton

Boilerplate de plugin WordPress listo para producción. Pensado como punto de partida limpio para arrancar un plugin nuevo sin reescribir lo básico cada vez.

Mantenido por [SapyensDev](https://sapyensdev.com).

## Qué incluye

- Estructura estándar de plugin (`includes/`, `public/`, `assets/`)
- Activación con `register_activation_hook`, valida la versión mínima de PHP y WordPress, crea la tabla propia con `dbDelta` y los valores de configuración por defecto, corta la activación con `wp_die` si algo falla
- Carga de traducciones con `load_plugin_textdomain` desde `languages/`, usando el mismo Text Domain declarado en la cabecera del plugin
- `uninstall.php` con la limpieza real de datos, tabla propia y opciones, solo se ejecuta al borrar el plugin, nunca al desactivarlo
- **Modelo genérico** (`SapyensDevSkeleton_Item`) sobre la tabla propia, con consultas preparadas vía `$wpdb`
- **Pantalla de admin con CRUD** (`SapyensDevSkeleton_Admin`), listado, alta y eliminación de elementos, con nonces y `current_user_can` en cada acción
- **Página de ajustes** (`SapyensDevSkeleton_Settings`) con la Settings API estándar, bajo el menú Ajustes
- **Shortcode de ejemplo** `[sapyensdevskeleton_mensaje]` que imprime el mensaje configurado
- Carga de CSS y JS en el front vía `wp_enqueue_scripts`, y CSS propio solo en la pantalla del plugin vía `admin_enqueue_scripts`
- Seguridad estándar, sanitización de entradas, escaping de salidas, nonces en cada formulario y acción
- Licencia MIT

## Estructura

```
sapyensdev-skeleton.php                          # Archivo principal, activación y desactivación
uninstall.php                                     # Limpieza real al borrar el plugin
includes/
  class-sapyensdevskeleton-item.php               # Modelo sobre la tabla propia
  class-sapyensdevskeleton-admin.php              # Pantalla de admin con CRUD
  class-sapyensdevskeleton-settings.php           # Página de ajustes
public/
  class-sapyensdevskeleton-public.php             # Shortcode y assets del front
assets/
  css/front.css                                    # Estilos del front
  css/admin.css                                     # Estilos de la pantalla de admin
  js/front.js                                       # Script del front
languages/
  sapyensdev-skeleton.pot                           # Plantilla de traducción, punto de partida para .po/.mo
```

## Instalación

1. Clona o descarga este repositorio dentro de `wp-content/plugins/` de tu instalación de WordPress
2. Busca y reemplaza `sapyensdevskeleton` / `SapyensDevSkeleton` / `sapyensdev-skeleton` en todo el proyecto por el nombre de tu plugin
3. Activa el plugin desde el admin de WordPress (Plugins → Activar)

## Compatibilidad

Este skeleton usa `dbDelta`, la Settings API y los hooks `admin_post`, disponibles sin cambios desde WordPress 5.0. Requiere WordPress 5.0 o superior y PHP 7.4 o superior.

## Convenciones

Este skeleton sigue el ciclo de vida estándar de WordPress, distinto al de PrestaShop. La activación no borra datos al desactivar, solo `uninstall.php` lo hace, y solo cuando el usuario borra el plugin desde el admin. Todas las funciones y clases usan el prefijo `sapyensdevskeleton` / `SapyensDevSkeleton_` para evitar colisiones con otros plugins.

## Licencia

MIT, ver [LICENSE](LICENSE).

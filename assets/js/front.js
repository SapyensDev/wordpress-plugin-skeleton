/* Script de ejemplo del plugin, front */
document.addEventListener('DOMContentLoaded', function () {
    var mensaje = document.querySelector('.sapyensdevskeleton-mensaje');

    if (mensaje) {
        mensaje.addEventListener('click', function () {
            console.log('SapyensDev Skeleton, mensaje del front clickeado');
        });
    }
});

# Tema 421 — 421 Sound Experience

Tema de WordPress one-page. Cliente: 421 Sound Experience. Autor: Himno Estudio.

## Datos del tema
- Text Domain: `s421`
- Requires PHP: 8.2
- Entorno local: Local (LocalWP), sitio `421`

## Estructura
- `assets/css/main.css`, `assets/js/main.js` — encolados en `functions.php` con versión por `filemtime`
- `assets/img`, `assets/fonts` — recursos estáticos
- `inc/` — archivos PHP auxiliares (se incluyen desde `functions.php`)
- `front-page.php` — la one-page; `index.php` — respaldo

## Reglas
- **Prefijo `s421_`** en todas las funciones, hooks y handles propios (PHP no permite nombres que empiecen por número). Constantes: `S421_`.
- **No escribir markup de secciones.** El usuario maqueta el HTML a mano; no generar secciones, bloques ni contenido en las plantillas salvo que lo pida explícitamente.
- Strings traducibles con el text domain `s421`.
- Código compatible con PHP 8.2.

# 421 Theme — 421 Sound Experience

One-page WordPress theme. Client: 421 Sound Experience. Author: Himno Estudio.

## Theme info
- Text Domain: `s421`
- Requires PHP: 8.2
- Local environment: Local (LocalWP), site `421`

## Structure
- `config.php` — theme constants (`S421_VERSION`, `S421_DIR`, `S421_URI`)
- `assets/css/` — `base.css` → `layout.css` → `components.css` (+ `home.css` on the front page if it exists), versioned with `filemtime`
- `assets/js/` — `main.js`, `fade.js`, `scroll.js`, `fit-text.js`, `accordion.js`; each is enqueued only if the file exists
- `assets/img`, `assets/fonts` — static assets
- `inc/` — `cpt.php`, `taxonomies.php`, `helpers.php` (loaded from `functions.php` only if they exist)
- No Embla carousel in this theme.
- `front-page.php` — the one-page; `index.php` — fallback

## Rules
- **Everything in English.** Code comments, docblocks, file content, commit messages and docs are always written in English (conversation with the user may be in Spanish).
- **`s421_` prefix** on every custom function, hook and handle (PHP doesn't allow names starting with a number). Constants: `S421_`.
- **Don't write section markup.** The user hand-codes the HTML; don't generate sections, blocks or content in templates unless explicitly asked.
- Translatable strings use the `s421` text domain.
- Code must be PHP 8.2 compatible.

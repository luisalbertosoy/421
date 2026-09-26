<?php
$header_page = get_page_by_path('header');
$header      = $header_page ? ( get_fields( $header_page->ID ) ?: [] ) : [];
$menu_items  = $header['menu'] ?? [];
$cta         = $header['cta_button'] ?? [];
$cta_label   = $cta['label'] ?? '';
$cta_url     = $cta['url'] ?? '#';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="preloader">
    <div class="loader"></div>
</div>

<header class="header-wrapper">
    <div class="header-cont">

        <!-- Logo -->
        <div class="logo-header">
            <a href="<?php echo esc_url( home_url('/') ); ?>" aria-label="421 Sound Experience">
                <!-- Reemplazar con SVG del logo de 421 -->
                <span class="txt-btn">421</span>
            </a>
        </div>

        <!-- Nav + CTA -->
        <div class="header-nav">

            <nav class="menu" aria-label="<?php esc_attr_e('Menú principal', 's421'); ?>">

                <!-- Desktop menu -->
                <ul class="menu-list hidemob">
                    <?php foreach ( $menu_items as $item ) :
                        $has_sub = ! empty( $item['submenu'] );
                        $target  = $item['link_type'] ?? '_self';
                    ?>
                    <li>
                        <a href="<?php echo esc_url( $item['url'] ?? '#' ); ?>"
                           class="txt-btn"
                           <?php if ( $target === '_blank' ) : ?>target="_blank" rel="noopener"<?php endif; ?>>
                            <?php echo esc_html( $item['label'] ?? '' ); ?>
                            <?php if ( $has_sub ) : ?>
                                <svg class="icon" width="24" height="24" aria-hidden="true">
                                    <use href="#chevron-down"></use>
                                </svg>
                            <?php endif; ?>
                        </a>

                        <?php if ( $has_sub ) : ?>
                        <div class="dropdown-menu">
                            <ul class="dd-menu-list">
                                <?php foreach ( $item['submenu'] as $sub ) :
                                    $sub_target = $sub['link_type'] ?? '_self';
                                ?>
                                <li>
                                    <a href="<?php echo esc_url( $sub['url'] ?? '#' ); ?>"
                                       class="txt-btn drpdwn"
                                       <?php if ( $sub_target === '_blank' ) : ?>target="_blank" rel="noopener"<?php endif; ?>>
                                        <?php echo esc_html( $sub['label'] ?? '' ); ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Mobile menu -->
                <ul class="menu-list showmob" id="mobile-menu">
                    <?php foreach ( $menu_items as $item ) :
                        $has_sub = ! empty( $item['submenu'] );
                        $target  = $item['link_type'] ?? '_self';
                    ?>
                    <li>
                        <a href="<?php echo esc_url( $item['url'] ?? '#' ); ?>"
                           class="txt-btn mainmob"
                           <?php if ( $target === '_blank' ) : ?>target="_blank" rel="noopener"<?php endif; ?>>
                            <?php echo esc_html( $item['label'] ?? '' ); ?>
                            <?php if ( $has_sub ) : ?>
                                <svg class="icon" width="24" height="24" aria-hidden="true">
                                    <use href="#chevron-down"></use>
                                </svg>
                            <?php endif; ?>
                        </a>

                        <?php if ( $has_sub ) : ?>
                        <div class="dropdown-menu mob">
                            <ul class="dd-menu-list">
                                <?php foreach ( $item['submenu'] as $sub ) :
                                    $sub_target = $sub['link_type'] ?? '_self';
                                ?>
                                <li>
                                    <a href="<?php echo esc_url( $sub['url'] ?? '#' ); ?>"
                                       class="txt-btn drpdwn"
                                       <?php if ( $sub_target === '_blank' ) : ?>target="_blank" rel="noopener"<?php endif; ?>>
                                        <?php echo esc_html( $sub['label'] ?? '' ); ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>

                    <?php if ( $cta_label ) : ?>
                    <!-- CTA móvil -->
                    <li>
                        <a href="<?php echo esc_url( $cta_url ); ?>" class="main-btn capsule">
                            <?php echo esc_html( $cta_label ); ?>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>

                <!-- Mobile toggle -->
                <button class="menu-toggle"
                        aria-label="<?php esc_attr_e('Abrir menú', 's421'); ?>"
                        aria-expanded="false"
                        aria-controls="mobile-menu">
                    <svg class="icon menu-btn" width="48" height="48" aria-hidden="true">
                        <use href="#menu-btn-mob"></use>
                    </svg>
                </button>
            </nav>

            <?php if ( $cta_label ) : ?>
            <!-- CTA desktop -->
            <a href="<?php echo esc_url( $cta_url ); ?>" class="txt-btn geor text-items-center hidemob">
                <span class="dot"></span>
                <?php echo esc_html( $cta_label ); ?>
            </a>
            <?php endif; ?>

        </div>
    </div>
</header>
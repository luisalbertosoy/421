<?php
get_header();

// Only <br> is allowed in the textarea fields.
$s421_br = array( 'br' => array() );

// All landing sections are edited on the page with slug "home".
$home_page = get_page_by_path( 'home' );
$home_id   = $home_page ? $home_page->ID : 0;

// Intro (ACF group "Home — Intro"). Fallbacks match the field defaults.
$intro            = ( $home_id && function_exists( 'get_field' ) ) ? ( get_field( 'intro', $home_id ) ?: array() ) : array();
$intro_bg         = ( $intro['background'] ?? '' ) ?: 'https://himnoestudio.com/421/wp-content/uploads/2026/09/section_1_bg.webp';
$intro_title      = $intro['title'] ?? 'STEP INSIDE<br>THE EXPERIENCE';
$intro_body       = $intro['body_text'] ?? '421 creates immersive sound<br>experiences designed to<br>turn listening into<br>something beyond.';
$intro_secondary1 = $intro['secondary_text_one'] ?? 'ENTER THE SOUND.';
$intro_secondary2 = $intro['secondary_text_two'] ?? 'WELCOME TO THE INSIDE OF SOUND.';
$intro_closing    = $intro['closing_text'] ?? 'SOMETHING THAT<br>BECOMES<br>PART OF YOU';
$intro_scroll     = $intro['scroll_label'] ?? 'SCROLL DOWN';

// About (ACF group "Home — About"). Fallbacks match the field defaults.
$about            = ( $home_id && function_exists( 'get_field' ) ) ? ( get_field( 'about', $home_id ) ?: array() ) : array();
$about_bg         = ( $about['background'] ?? '' ) ?: 'https://himnoestudio.com/421/wp-content/uploads/2026/09/section_2_bg.webp';
$about_small1     = $about['small_text_one'] ?? 'Who we are';
$about_small2     = $about['small_text_two'] ?? 'and';
$about_small3     = $about['small_text_three'] ?? 'WHAT IS 421?';
$about_title      = $about['title'] ?? 'SOUND AS A LIVING FORCE.';
$about_body       = $about['body_text'] ?? '421 is a sound experience company<br>exploring the relationship between:';
$about_secondary1 = $about['secondary_text_one'] ?? '421 CREATES IMMERSIVE EXPERIENCES<br>WHERE SOUND BECOMES PRESENCE.';
$about_secondary2 = $about['secondary_text_two'] ?? 'IT SHAPES THE SPACE. SHIFTS PERSPECTIVE.';
$about_list       = $about['list_text'] ?? 'SOUND<br><br>BODY<br><br>SPACE<br><br>PERCEPTION<br><br>TECHNOLOGY';
$about_scroll     = $about['scroll_label'] ?? 'SCROLL DOWN';

// Experience (ACF group "Home — Experience"). Fallbacks match the field defaults.
$experience       = ( $home_id && function_exists( 'get_field' ) ) ? ( get_field( 'experience', $home_id ) ?: array() ) : array();
$experience_bg    = ( $experience['background'] ?? '' ) ?: 'https://himnoestudio.com/421/wp-content/uploads/2026/09/section_3_bg.webp';
$experience_title = $experience['title'] ?? 'THE EXPERIENCE';
$experience_body  = $experience['body_text'] ?? 'SOME EXPERIENCES CATCH YOUR EYE.OURS MOVE THROUGH YOU.';
$experience_items = array_key_exists( 'items', $experience )
	? ( is_array( $experience['items'] ) ? array_column( $experience['items'], 'text' ) : array() )
	: s421_experience_default_items();
$experience_scroll = $experience['scroll_label'] ?? 'SCROLL DOWN';
?>

<main id="main">

    <!-- ============ INTRO ============ -->
    <section id="intro" class="herospace-wrapper just-center">
        <img src="<?php echo esc_url( $intro_bg ); ?>"
             class="h-herospace-img single-img fit-fill">
        <div class="column xl-gap just-center wdth-m">
            <div class="row spcbtwn">
                <p class="text-m-alt text-medium text-uppers"><?php echo wp_kses( $intro_title, $s421_br ); ?></p>
                <p class="text-end"><?php echo wp_kses( $intro_body, $s421_br ); ?></p>
            </div>
            <div class="row spcbtwn items-end">
                <p class="text-xxs text-uppers"><?php echo wp_kses( $intro_secondary1, $s421_br ); ?></p>
                <p class="text-xxs text-uppers"><?php echo wp_kses( $intro_secondary2, $s421_br ); ?></p>
                <p class="text-m-xnormal text-medium text-end text-uppers"><?php echo wp_kses( $intro_closing, $s421_br ); ?></p>
            </div>
        </div>
        <div class="row just-center items-centered herospace-bottom">
            <div class="column items-centered scroll-next" role="button" tabindex="0" aria-label="<?php esc_attr_e('Scroll to next section', 's421'); ?>">
                <svg class="icon" width="24" height="24"> <use xlink:href="#arrow-down"></use> </svg>
                <p class="text-xxs text-white"><?php echo wp_kses( $intro_scroll, $s421_br ); ?></p>
            </div>
        </div>
    </section>

    <!-- ============ ABOUT ============ -->
    <section id="about" class="herospace-wrapper just-center">
        <img src="<?php echo esc_url( $about_bg ); ?>"
             class="h-herospace-img single-img fit-fill">
        <div class="column pddng-m m-gap just-center">
            <div class="row spcbtwn">
                <div class="row wdth-s spcbtwn">
                    <p class="text-xxs text-uppers text-black"><?php echo wp_kses( $about_small1, $s421_br ); ?></p>
                    <p class="text-xxs text-uppers text-black"><?php echo wp_kses( $about_small2, $s421_br ); ?></p>
                    <p class="text-xxs text-uppers text-black"><?php echo wp_kses( $about_small3, $s421_br ); ?></p>
                </div>
                <p class="text-m-alt text-medium text-uppers text-black"><?php echo wp_kses( $about_title, $s421_br ); ?></p>
                <p class="text-end text-uppers text-black"><?php echo wp_kses( $about_body, $s421_br ); ?></p>
            </div>
            <div class="row spcbtwn items-end">
                <p class="text-uppers text-black"><?php echo wp_kses( $about_secondary1, $s421_br ); ?></p>
                <p class="text-m-xnormal text-medium text-uppers text-black"><?php echo wp_kses( $about_secondary2, $s421_br ); ?></p>
                <p class="text-m-xnormal text-medium text-end text-uppers text-black"><?php echo wp_kses( $about_list, $s421_br ); ?></p>
            </div>
        </div>
        <div class="row just-center items-centered herospace-bottom">
            <div class="column items-centered scroll-next" role="button" tabindex="0" aria-label="<?php esc_attr_e('Scroll to next section', 's421'); ?>">
                <svg class="icon black" width="24" height="24"> <use xlink:href="#arrow-down"></use> </svg>
                <p class="text-xxs text-black"><?php echo wp_kses( $about_scroll, $s421_br ); ?></p>
            </div>
        </div>
    </section>

    <!-- ============ EXPERIENCE ============ -->
    <section id="experience" class="herospace-wrapper pages just-center">
        <img src="<?php echo esc_url( $experience_bg ); ?>"
             class="h-herospace-img single-img fit-fill">
        <div class="column pddng-m pages m-gap just-center">
            <div class="row spcbtwn items-end">
                <p class="text-xxxl alt text-uppers"><?php echo wp_kses( $experience_title, $s421_br ); ?></p>
                <p class="text-m-xnormal text-uppers text-end"><?php echo wp_kses( $experience_body, $s421_br ); ?></p>
            </div>
            <div class="column">
                <?php foreach ( $experience_items as $i => $item_text ) : ?>
                <div class="row spcbtwn border-down">
                    <p class="text-m-normal text-uppers"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
                    <p class="text-m-normal text-uppers wdt-s"><?php echo wp_kses( (string) $item_text, $s421_br ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row just-center items-centered herospace-bottom">
            <div class="column items-centered scroll-next" role="button" tabindex="0" aria-label="<?php esc_attr_e('Scroll to next section', 's421'); ?>">
                <svg class="icon" width="24" height="24"> <use xlink:href="#arrow-down"></use> </svg>
                <p class="text-xxs"><?php echo wp_kses( $experience_scroll, $s421_br ); ?></p>
            </div>
        </div>
    </section>

    <!-- ============ DATES ============ -->
    <section id="book" class="herospace-wrapper pages just-center">
        <img src="https://himnoestudio.com/421/wp-content/uploads/2026/09/section_4_bg.webp"
             class="h-herospace-img single-img fit-fill">
        <div class="column pddng-m pages-m l-gap just-center">
            <div class="column">
                <div class="row spcbtwn items-end">
                    <p class="text-xxxl mob text-uppers">EXPERIENCE.</p>
                    <p class="text-xxxl mob text-uppers text-end">PRECISELY DESIGNED.</p>
                </div>
                <div class="row spcbtwn items-end">
                    <p class="text-xxs text-uppers">We create moments you can enter.</p>
                    <p class="text-xxs text-uppers text-end">BOOK A JOURNEY</p>
                </div>
            </div>
            <div class="column">
                <div class="row grid-4-2-2-2-2-2 border-down alt">
                    <p class="text-m-normal text-uppers">Vinyl BootleG AlbuM</p>
                    <p class="text-m-normal text-uppers">white label</p>
                    <div class="column no-gap ">
                        <p class="text-end pddng-bttm-s text-uppers">AGOSTO 25.2026</p>
                        <p class="text-end pddng-rght-m">7PM</p>
                        <p class="text-end pddng-rght-m">8:15PM</p>
                        <p class="text-end pddng-rght-m">9:30PM</p>
                    </div>
                    <div class="column no-gap ">
                        <p class="text-end pddng-bttm-s text-uppers">AGOSTO 25.2026</p>
                        <p class="text-end pddng-rght-m">7PM</p>
                        <p class="text-end pddng-rght-m">8:15PM</p>
                        <p class="text-end pddng-rght-m">9:30PM</p>
                    </div>
                    <div class="column no-gap ">
                        <p class="text-end pddng-bttm-s text-uppers">AGOSTO 25.2026</p>
                        <p class="text-end pddng-rght-m">7PM</p>
                        <p class="text-end pddng-rght-m">8:15PM</p>
                        <p class="text-end pddng-rght-m">9:30PM</p>
                    </div>
                    <a href="#" class="book-btn text-uppers">BOOK NOW <svg class="icon" width="24" height="24"> <use xlink:href="#arrow-forward"></use> </svg></a>
                </div>

                <div class="row grid-4-2-2-2-2-2 border-down alt">
                    <p class="text-m-normal text-uppers">Rarities & oddities</p>
                    <p class="text-m-normal text-uppers">A selection that is not revealed before it plays.</p>
                    <div class="column no-gap ">
                        <p class="text-end pddng-bttm-s text-uppers">AGOSTO 25.2026</p>
                        <p class="text-end pddng-rght-m">7PM</p>
                        <p class="text-end pddng-rght-m">8:15PM</p>
                        <p class="text-end pddng-rght-m">9:30PM</p>
                    </div>
                    <div class="column no-gap ">
                        <p class="text-end pddng-bttm-s text-uppers">AGOSTO 25.2026</p>
                        <p class="text-end pddng-rght-m">7PM</p>
                        <p class="text-end pddng-rght-m">8:15PM</p>
                        <p class="text-end pddng-rght-m">9:30PM</p>
                    </div>
                    <div class="column no-gap ">
                        <p class="text-end pddng-bttm-s text-uppers">AGOSTO 25.2026</p>
                        <p class="text-end pddng-rght-m">7PM</p>
                        <p class="text-end pddng-rght-m">8:15PM</p>
                        <p class="text-end pddng-rght-m">9:30PM</p>
                    </div>
                    <a href="#" class="book-btn text-uppers">BOOK NOW <svg class="icon" width="24" height="24"> <use xlink:href="#arrow-forward"></use> </svg></a>
                </div>

                <div class="row grid-4-2-2-2-2-2 border-down alt">
                    <p class="text-m-normal text-uppers">Rarities & oddities</p>
                    <p class="text-m-normal text-uppers">A selection that is not revealed before it plays.</p>
                    <div class="column no-gap ">
                        <p class="text-end pddng-bttm-s text-uppers">AGOSTO 25.2026</p>
                        <p class="text-end pddng-rght-m">7PM</p>
                        <p class="text-end pddng-rght-m">8:15PM</p>
                        <p class="text-end pddng-rght-m">9:30PM</p>
                    </div>
                    <div class="column no-gap ">
                        <p class="text-end pddng-bttm-s text-uppers">AGOSTO 25.2026</p>
                        <p class="text-end pddng-rght-m">7PM</p>
                        <p class="text-end pddng-rght-m">8:15PM</p>
                        <p class="text-end pddng-rght-m">9:30PM</p>
                    </div>
                    <div class="column no-gap ">
                        <p class="text-end pddng-bttm-s text-uppers">AGOSTO 25.2026</p>
                        <p class="text-end pddng-rght-m">7PM</p>
                        <p class="text-end pddng-rght-m">8:15PM</p>
                        <p class="text-end pddng-rght-m">9:30PM</p>
                    </div>
                    <a href="#" class="book-btn text-uppers">BOOK NOW <svg class="icon" width="24" height="24"> <use xlink:href="#arrow-forward"></use> </svg></a>
                </div>
            </div> 
        </div>
        <div class="row just-center items-centered herospace-bottom">
            <div class="column items-centered scroll-next" role="button" tabindex="0" aria-label="<?php esc_attr_e('Scroll to next section', 's421'); ?>">
                <svg class="icon" width="24" height="24"> <use xlink:href="#arrow-down"></use> </svg>
                <p class="text-xxs">SCROLL DOWN</p>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->
    <section id="footer" class="herospace-wrapper just-center">
        <img src="https://himnoestudio.com/421/wp-content/uploads/2026/09/section_5_bg.webp"
             class="h-herospace-img single-img fit-fill">
        <div class="column xl-gap just-center items-centered wdth-m">
            <img src="https://himnoestudio.com/421/wp-content/uploads/2026/09/Footer.svg"
             alt="LET YOUR BODY LISTEN AGAIN."
             class="single-img svg">
        </div>
        <div class="row spcbtwn items-centered herospace-bottom pddng-m">
            <p class="text-xxs text-uppers">Powered by LPS Spatial HiFi Systems</p>
            <p class="text-xxs text-uppers">MEXICO CITY</p>
            <a href="https://www.instagram.com/" class="text-xxs text-items-center text-gap-xs text-uppers txt-hover" target="_blank" rel="noopener">INSTAGRAM <svg class="icon dark" width="24" height="24"> <use xlink:href="#arrow-forward"></use> </svg></a>
        </div>
    </section>

</main>

<?php get_footer(); ?>
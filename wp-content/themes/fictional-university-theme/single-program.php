<?php
get_header();
while (have_posts()) {
    the_post();
    
    pageBanner();
    ?>
    <!-- <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title() ?></h1>
            <div class="page-banner__intro">
                <p>Learn how the school of your dreams got started.</p>
            </div>
        </div>
    </div> -->
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo site_url('/programs') ?>"><i class="fa fa-home" aria-hidden="true"></i> Program Home</a> <span class="metabox__main">Posted by <?php the_author_posts_link() ?> on <?php the_time( 'n.j.y' ); ?> in <?php echo get_the_category_list(', ') ?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content() ?>
        </div>
        <?php
        $relatedProfessors = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'related_program',
                    'compare' => 'LIKE',
                    'value' =>'"'. get_the_ID() . '"',
                    
                )
            )
        ));
        if ($relatedProfessors->have_posts()) {
            echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">'. get_the_title() .'  Professors</h2>';

        echo '<ul class="professor-cards" >';
        while ($relatedProfessors->have_posts()) {
            $relatedProfessors->the_post(); ?>
            <li class="professor-card__list-item">
                <a class="professor-card" href="<?php the_permalink()?>">
                    <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>" alt="">
                    <span class="professor-card__name"><?php the_title() ?></span>
                </a>
            </li>
        <?php }
        echo '</ul>'; 
        }

        wp_reset_postdata();

        $today = date('Ymd') ;
        $homepageEvents = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric',
                ),
                array(
                    'key' => 'related_program',
                    'compare' => 'LIKE',
                    'value' =>'"'. get_the_ID() . '"',
                    
                )
            )
        ));
        if ($homepageEvents->have_posts()) {
            echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Upcoming '. get_the_title() .' Events </h2>';
        while ($homepageEvents->have_posts()) {
            $homepageEvents->the_post();
                get_template_part( 'temp-files/event');

            }
        }

        ?>
    </div>


<?php
}

get_footer();
?>
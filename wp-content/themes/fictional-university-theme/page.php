<?php
get_header();
while (have_posts()) {
    the_post(); 
    
    pageBanner(array(
        'title' => 'Hello Every One',
        // 'subtitle' => 'Islam Bahaa',
        // 'photo' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Funsplash.com%2Fs%2Fphotos%2Fimage&psig=AOvVaw3EB7ruT6FLyy0JgO8bU0wQ&ust=1681470249191000&source=images&cd=vfe&ved=0CBEQjRxqFwoTCNDI3fjapv4CFQAAAAAdAAAAABAE'
    ));
    ?>

    

    <div class="container container--narrow page-section">
        <?php
        $theParent = wp_get_post_parent_id(get_the_ID());
        if ($theParent) { ?>

            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent) ?></a> <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
        <?php } ?>


        <?php

            $testArray =  get_pages(array(
                'child_of' => get_the_ID()
            ));

        if($theParent or $testArray){?>
            <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent);?>"><?php echo get_the_title($theParent); ?></a></h2>
            <ul class="min-list">
                <?php

                if($theParent){
                    $findChilderOf = $theParent;
                }else {
                    $findChilderOf = get_the_ID();
                }

                wp_list_pages(array(
                    'title_li' => NULL,
                    'child_of'  => $findChilderOf,
                    'sort_column' => 'menu_order',
                ));
                
                ?>
            </ul>
        </div>
        <?php }
        
        
        ?>

        <div class="generic-content">
            <?php the_content();  ?>
        </div>
    </div>

<?php
}
get_footer();
?>
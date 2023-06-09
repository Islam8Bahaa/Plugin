<?php

function pageBanner($args = NULL)
{
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }

    if(!$args['subtitle']){
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$args['photo']) {
        if(get_field('page_banner_background_image')){
            $args['photo'] = get_field('page_banner_background_image') ['sizes'] ['pageBanner'];
        }else{
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args ['photo'] ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle'] ?></p>
            </div>
        </div>
    </div> 
<?php }



function university_files()
{
    // The following code is using a function called "wp_enqueue_script" in PHP to add an external Javascript file to the current WordPress page. 
    
    wp_enqueue_script(
        // The first parameter is a unique name that identifies this script (in this case, "main-university-js").
        'main-university-js', 
        // The second parameter is the location of the Javascript file relative to the theme's root directory (in this case, "/js/index.js").
        get_theme_file_uri( '/js/index.js'),
        // The third parameter is an optional array of dependencies (in this case, NULL).
        NULL,
        // The fourth parameter is the version number of the script (in this case, "1.0").
        '1.0', 
        // The fifth parameter indicates whether the script should be placed in the footer (set to "true" in this case).
        true
    );
    
    // wp_enqueue_script( 'module-js' , get_theme_file_uri( '/src/index.js' ) ,NULL,'1.0', true);
    wp_enqueue_block_style('custom-google-fonts' , '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
    wp_enqueue_style('font-awsome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles' , get_stylesheet_uri());
    wp_enqueue_style('university_styles', get_template_directory_uri() . '/index.css');
}

add_action('wp_enqueue_scripts' , 'university_files');


function university_features()
{   // This is Used To make The Header links & Footer Links Dynamic
    // register_nav_menu( 'headerMenuLocation' , 'Header Menu Location' );
    // register_nav_menu( 'footerLocationOne' , 'Footer Location One' );
    // register_nav_menu( 'footerLocationTwo' , 'Footer Location Two' );
    add_theme_support( 'title-tag');

    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape' , 400 , 260 , true);
    add_image_size('professorPortrait' , 480 , 650 , true );
    add_image_size('pageBanner' , 1500 , 350 , true );
}

add_action( 'after_setup_theme', 'university_features');


function university_adjust_queries($query){
    if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
        $query->set('orderby' , 'title' ); 
        $query->set('order' , 'ASC' ); 
        $query->set('posts_per_page' , -1 ); 
    }


    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $today = date('Ymd') ;
        $query->set('meta_key' , 'event_date' );
        $query->set('orderby' , 'meta_value_num' );
        $query->set('order' , 'ASC' );
        $query->set('meta_query', array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric',
            )
        );
    }
}

add_action('pre_get_posts' , 'university_adjust_queries');



function universityMapKey($api){
    $api['Key'] ='AIzaSyDA1me6xx-y9tSe16bZyMrAGcw4jWK1Rok';
    return $api; 
}

add_filter('acf/fields/google_map/api', 'universityMapKey');



<?php
get_header();


pageBanner(array(
    'title' => 'All Evenst',
    'subtitle' => 'See what happens in the world',

));
?>

<!-- <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"> All Evenst</h1>
        <div class="page-banner__intro">
            <p>See what happens in the world</p>
        </div>
    </div>
</div> -->
<div class="container container--narrow page-section">
    <?php
    while(have_posts()){
        the_post();
    
        get_template_part( 'temp-files/event');
    
    }
    echo paginate_links()
    ?>
    <hr class="section-brak" >
    <p>Looking for a recap of past events ? <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive</a></p>
</div>



<?php
get_footer();
?>
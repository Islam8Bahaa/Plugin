<footer class="site-footer">
    <div class="site-footer__inner container container--narrow">
        <div class="group">
            <div class="site-footer__col-one">
                <h1 class="school-logo-text school-logo-text--alt-color">
                    <a href="<?php echo site_url() ?>"><strong>Fictional</strong> University</a>
                </h1>
                <p><a class="site-footer__link" href="#">555.555.5555</a></p>
            </div>

            <div class="site-footer__col-two-three-group">
                <div class="site-footer__col-two">
                    <h3 class="headline headline--small">Explore</h3>
                    <nav class="nav-list">
                        <ul>
                            <li><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
                            <li><a href="#">Programs</a></li>
                            <li><a href="#">Events</a></li>
                            <li><a href="#">Campuses </a></li>
                            <li><?php echo do_shortcode('[my_custom_shortcode message="Hello Every One"]'); ?></li>

                            <!-- <?php 
                            wp_nav_menu(array (
                                'theme_location' => 'footerLocationOne',
                            ))
                            
                            ?> -->
                        </ul>
                    </nav>
                </div>

                <div class="site-footer__col-three">
                    <h3 class="headline headline--small">Learn</h3>
                    <nav class="nav-list">
                        <ul>
                            <li><a href="#">Legal</a></li>
                            <li><a href="<?php echo site_url('/privacy-policy') ?>">Privacy</a></li>
                            <li><a href="#">Careers</a></li>

                            <!-- <?php 
                            wp_nav_menu(array (
                                'theme_location' => 'footerLocationTwo',
                            ))
                            
                            ?> -->
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="site-footer__col-four">
                <h3 class="headline headline--small">Connect With Us</h3>
                <nav>
                    <ul class="min-list social-icons-list group">
                        <li>
                            <a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>



<!-- // function csv_replacer_add_menu_icon() {
//     add_menu_page('CSV Replacer',
//     'CSV Replacer',
//     'manage_options', 
//     'csv-replacer', 
//     'csv_replacer_options_page', 
//     'dashicons-format-aside'
// );
// }
// add_action('admin_menu', 'csv_replacer_add_menu_icon');


// function csv_replacer_options_page() {
//     // Check if the form is submitted
//     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//         // Process the uploaded CSV file and store the data in the WordPress options table
//         csv_replacer_process_csv();
//     }
    // ?> -->
    <!-- // <div class="wrap">
    //     <h1>CSV Replacer</h1>
    //     <form method="post" enctype="multipart/form-data">
    //         <table class="form-table">
    //             <tr valign="top">
    //                 <th scope="row">Upload CSV File</th>
    //                 <td><input type="file" name="csv_file" /></td>
    //             </tr>
    //         </table>
    //         <?php submit_button('Save Changes', 'primary', 'submit', true); ?>
    //     </form>
    // </div> -->
    // <?php
// }


// function csv_replacer_process_csv() {
//     // Check if the CSV file is uploaded
//     if (isset($_FILES['csv_file']) && $_FILES['csv_file']['size'] > 0) {
//         // Get the uploaded CSV file
//         $csv_file = $_FILES['csv_file'];

//         // Loop through the CSV data and store it in an array
//         $csv_data = array_map('str_getcsv', file($csv_file['tmp_name']));
//         array_shift($csv_data); // Remove the header row

//         // Store the CSV data in the WordPress options table
//         update_option('csv_replacer_data', $csv_data);
//     }
// }





function csv_replacer_display_content($content) {
    // Get the configured text from the options page
    $configured_text = get_option('csv_replacer_config_text');
    
    // Get the CSV data for the current post or page
    $csv_data = csv_replacer_get_csv_data();
    
    // If there is no CSV data, return the original content
    if (!$csv_data) {
        return $content;
    }
    
    // Create a div to wrap the content
    $output = '<div class="csv-replacer-content">';
    
    // Loop through the CSV data and add each match to the output
    foreach ($csv_data as $match) {
        $output .= '<div class="csv-replacer-match">';
        $output .= '<h3>' . $match['business'] . '</h3>';
        $output .= '<div class="csv-replacer-map">' . csv_replacer_get_map_html($match['locality'], $match['address']) . '</div>';
        $output .= '<div class="csv-replacer-details">' . csv_replacer_get_details_html($match['address'], $match['phone'], $match['hours']) . '</div>';
        $output .= '</div>';
    }
    
    // Add the configured text and button to the output
    $output .= '<div class="csv-replacer-text">' . $configured_text . '</div>';
    $output .= csv_replacer_get_button_html();
  
    // Close the content div
    $output .= '</div>';
    
    // Replace the [@] text in the original content with the updated output
    $updated_content = str_replace('[@]', $output, $content);
    
    // Return the updated content
    return $updated_content;
}
add_filter('the_content', 'csv_replacer_display_content');

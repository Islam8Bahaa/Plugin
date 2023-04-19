<?php
/**
 * Plugin Name: Simple Plugin
 * Description: Uploads a CSV file and replaces [csvnull] in the content with the CSV data.
 * Version: 1.0.0
 * Author: Islam Bahaa
 * Author URI: https://your-website.com/
 */
// put this plugin in new tab in wordpress admin area called CSV Upload and Replace
// create a new table in the database called csv_data_table
use function PHPSTORM_META\type;

// add a new menu item in wordpress admin area called CSV Upload and Replace


// Add a settings page to the WordPress admin area
add_action( 'admin_menu', 'csv_upload_replace_add_menu' );
function csv_upload_replace_add_menu() {
    // add_media_page( $page_title:string, $menu_title:string, $capability:string, $menu_slug:string, $callback:callable, $position:integer|null );
    // add menu page to the admin area
add_menu_page( 'CSV Upload', 'CSV Upload ', 'manage_options', 'csv-upload-replace', 'csv_upload_replace_settings_page','dashicons-format-aside' );
// add csv_get_data_settings_page as a submenu page to the csv_upload_replace_settings_page
add_submenu_page( 'csv-upload-replace', 'CSV Data', 'CSV Data', 'manage_options', 'csv-get-data', 'csv_get_data_settings_page','dashicons-format-aside' );
}   
// create table in database called csv_data_table with 4 columns title, locality, address, phone
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'csv_data_table';
$sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    title text NOT NULL,
    locality text NOT NULL,
    address text NOT NULL,
    phone text NOT NULL,
    cordi1 decimal(11,8) NOT NULL,
    cordi2 decimal(11,8) NOT NULL,
    link1 text null,
    link2 text null,
    despcription text null,
    hour text null,
    Provincia text null,
    UNIQUE KEY id (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );



// Display the settings page form
function csv_upload_replace_settings_page() {

    if (isset($_POST['submit']) && $_POST['submit'] != 'Update') {
        $file = $_FILES['csv-file'];
        if ($file['type'] !== 'text/csv') {
            echo '<div class="error"><p>Invalid file type. Please upload a CSV file.</p></div>';
        } else {
            $www = array_map('str_getcsv', file($file['tmp_name']));
            $fields = $www[0];
            // get the index of Nombre in the array $fields
            $title_index = array_search('Nombre', $fields);
            // get the index of locality in the array $fields
            $locality_index = array_search('Localidad', $fields);
            // get the index of Nombre in the array $fields
            $address_index = array_search('Dirección', $fields);
            // get the index of Nombre in the array $fields
            $phone_index = array_search('Teléfono', $fields);
            // get the index of Nombre in the array $fields
            $cord1_index = array_search('Coordenadas 1', $fields);
            // get the index of Nombre in the array $fields
            $cord2_index = array_search('Coordenadas 2', $fields);
            // get the index of Nombre in the array $fields
            $link1_index = array_search('link1', $fields);
            // get the index of Nombre in the array $fields
            $link2_index = array_search('link2', $fields);
            // get the index of Nombre in the array $fields
            $desc_index = array_search('desc', $fields);
            // get the index of Nombre in the array $fields
            $hours_index = array_search('hours', $fields);
            $Provincia_index = array_search('Provincia', $fields);

            // display success message
            echo '<div class="updated"><p>CSV file uploaded successfully.</p></div>';
            // get the csv file title column data
            $csv_title = array_map('str_getcsv', file($file['tmp_name']));
            $csv_title = array_column($csv_title, $title_index);
            // get the csv file locality column data
            $csv_locality = array_map('str_getcsv', file($file['tmp_name']));
            $csv_locality = array_column($csv_locality, $locality_index);
            // get the csv file third address data
            $csv_address = array_map('str_getcsv', file($file['tmp_name']));
            $csv_address = array_column($csv_address, $address_index);
            // get the csv file fourth phone data
            $csv_phone = array_map('str_getcsv', file($file['tmp_name']));
            $csv_phone = array_column($csv_phone, $phone_index);
            // cordin1
            $csv_cord1 = array_map('str_getcsv', file($file['tmp_name']));
            $csv_cord1 = array_column($csv_cord1, $cord1_index);
            // cordin2
            $csv_cord2 = array_map('str_getcsv', file($file['tmp_name']));
            $csv_cord2 = array_column($csv_cord2, $cord2_index);
            // link1
            if ($link1_index != null) {
                $csv_link1 = array_map('str_getcsv', file($file['tmp_name']));
                $csv_link1 = array_column($csv_link1, $link1_index);
            }
            // link2
            if ($link2_index != null) {
                $csv_link2 = array_map('str_getcsv', file($file['tmp_name']));
                $csv_link2 = array_column($csv_link2, $link2_index);
            }
            // description
            if ($desc_index != null) {
                $csv_descrip = array_map('str_getcsv', file($file['tmp_name']));
                $csv_descrip = array_column($csv_descrip, $desc_index);
            }

            // hours
            if ($hours_index != null) {
                $csv_hours = array_map('str_getcsv', file($file['tmp_name']));
                $csv_hours = array_column($csv_hours, $hours_index);
            }
            if ($Provincia_index != null) {
                $csv_Provincia = array_map('str_getcsv', file($file['tmp_name']));
                $csv_Provincia = array_column($csv_Provincia, $Provincia_index);
            }

            // put each row title, locality, address, phone in an array
            $csv_data = [];
            for ($i = 0; $i < count($csv_title); $i++) {
                if (!isset($csv_title[$i])) {
                    $csv_title[$i] = null;
                }
                if (!isset($csv_locality[$i])) {
                    $csv_locality[$i] = null;
                }
                if (!isset($csv_address[$i])) {
                    $csv_address[$i] = null;
                }
                if (!isset($csv_phone[$i])) {
                    $csv_phone[$i] = null;
                }
                if (!isset($csv_cord1[$i])) {
                    $csv_cord1[$i] = null;
                }
                if (!isset($csv_cord2[$i])) {
                    $csv_cord2[$i] = null;
                }

                if (!isset($csv_hours[$i])) {
                    $csv_hours[$i] = null;
                }
                if (!isset($csv_link1[$i])) {
                    $csv_link1[$i] = null;
                }
                if (!isset($csv_link2[$i])) {
                    $csv_link2[$i] = null;
                }
                if (!isset($csv_descrip[$i])) {
                    $csv_descrip[$i] = null;
                }
                if (!isset($csv_Provincia[$i])) {
                    $csv_Provincia[$i] = null;
                }
                // if the link1 does't contain http:// or https:// add it
                if (!preg_match('/^(http|https):\/\//', $csv_link1[$i]) && !empty($csv_link1[$i])) {
                    $csv_link1[$i] = 'https://' . $csv_link1[$i];
                }
                // if the link2 does't contain http:// or https:// add it
                if (!preg_match('/^(http|https):\/\//', $csv_link2[$i]) && !empty($csv_link2[$i])) {
                    $csv_link2[$i] = 'https://' . $csv_link2[$i];
                }

                $csv_data[$i] = [
                    'title' => $csv_title[$i],
                    'locality' => $csv_locality[$i],
                    'address' => $csv_address[$i],
                    'phone' => $csv_phone[$i],
                    'cordi1' => $csv_cord1[$i],
                    'cordi2' => $csv_cord2[$i],
                    'link1' => $csv_link1[$i],
                    'link2' => $csv_link2[$i],
                    'descrip' => $csv_descrip[$i],
                    'hour' => $csv_hours[$i],
                    'Provincia' => $csv_Provincia[$i],
                ];
            }
            //remove the first index of the array because it is the header
            array_shift($csv_data);
            // print_r($csv_data);
            // insert the data into the database
            global $wpdb;
            $table_name = $wpdb->prefix . 'csv_data_table';
            foreach ($csv_data as $data) {
                $title = $data['title'];
                $title_escaped = addslashes($title); // escape the single quote
                $locality = $data['locality'];
                $locality_escaped = addslashes($locality); // escape the single quote
                $rows = $wpdb->get_results("SELECT * FROM $table_name WHERE title = '$title_escaped' And locality = '$locality_escaped'");
                // if theres rows with the same title and locality then dont insert it

                if (count($rows) == 0) {
                    $wpdb->insert($table_name, [
                        'title' => $data['title'],
                        'locality' => $data['locality'],
                        'address' => $data['address'],
                        'phone' => $data['phone'],
                        'cordi1' => $data['cordi1'],
                        'cordi2' => $data['cordi2'],
                        'link1' => $data['link1'],
                        'link2' => $data['link2'],
                        'despcription' => $data['descrip'],
                        'hour' => $data['hour'],
                        'Provincia' => $data['Provincia'],
                    ]);
                }
            }
        }
    }
    // Display the form

    ?>
    <div style="margin: 20px auto; margin-right:20px ; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
        <h2 style="font-size: 24px; margin-bottom: 20px;">CSV Upload</h2>
        <form method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column;">

            <input type="file" name="csv-file" id="csv-file"
                style="padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">
            <input type="submit" name="submit" value="Upload"
                style="padding: 10px; background-color:#0d6efd; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
            <!-- <?php echo '<a href="?page=csv-upload-replace&action=edit" style="margin-top:30px;">Edit defult data </a>';
            ?> -->
        </form>
    </div>



    <?php
}

    function csv_get_data_settings_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'csv_data_table';
        //add search to the table to search for the data by locality
        echo '<form method="post" action="?page=csv-get-data"style="margin-right: 20px;" >';
        echo '<input type="text" name="search" placeholder="Search by locality or title" style="width:50%; margin:15px; margin-left:0px;">';
        echo '<input type="submit" name="submit" value="Search">';
        echo '</form>';
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
            // condition check if there is result for the search or title

            if ($wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE locality = '$search'") == 0 ) {
            
            } else {
                $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE locality = '$search'" );

                echo '<table class="wp-list-table widefat fixed striped posts" >';
                echo '<thead >';
                echo '<tr>';
                echo '<th class="manage-column column-title column-primary">Title</th>';
                echo '<th class="manage-column column-title column-primary">Locality</th>';
                echo '<th class="manage-column column-title column-primary">Address</th>';
                echo '<th class="manage-column column-title column-primary">Phone</th>';
                echo '<th class="manage-column column-title column-primary">Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($results as $result) {
                    echo '<tr>';
                    echo '<td class="manage-column column-title column-primary">' . $result->title . '</td>';
                    echo '<td class="manage-column column-title column-primary">' . $result->locality . '</td>';
                    echo '<td class="manage-column column-title column-primary">' . $result->address . '</td>';
                    echo '<td class="manage-column column-title column-primary">' . $result->phone . '</td>';
                    echo '<td class="manage-column column-title column-primary"><a href="?page=csv-get-data&action=edit&id=' . $result->id . '">Edit</a> <a href="?page=csv-get-data&action=delete&id=' . $result->id . '">Delete</a></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>'; 
                
            }
            // add search by title
            if ($wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE title = '$search'") == 0 ) {
            
            } else {
                // add % to the search to search for the title
                $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE title = '$search'" );

                echo '<table class="wp-list-table widefat fixed striped posts" >';
                echo '<thead>';
                echo '<tr>';
                echo '<th class="manage-column column-title column-primary">Title</th>';
                echo '<th class="manage-column column-title column-primary">Locality</th>';
                echo '<th class="manage-column column-title column-primary">Address</th>';
                echo '<th class="manage-column column-title column-primary">Phone</th>';
                echo '<th class="manage-column column-title column-primary">Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($results as $result) {
                    echo '<tr>';
                    echo '<td class="manage-column column-title column-primary">' . $result->title . '</td>';
                    echo '<td class="manage-column column-title column-primary">' . $result->locality . '</td>';
                    echo '<td class="manage-column column-title column-primary">' . $result->address . '</td>';
                    echo '<td class="manage-column column-title column-primary">' . $result->phone . '</td>';
                    echo '<td class="manage-column column-title column-primary"><a href="?page=csv-get-data&action=edit&id=' . $result->id . '">Edit</a> <a href="?page=csv-get-data&action=delete&id=' . $result->id . '">Delete</a></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>'; 
                
            }
        
        }
        
        else{
                
        // make pagination
        $page = isset($_GET['cpage']) ? abs((int)$_GET['cpage' ]) : 1;
        $limit = 15; // number of rows in page
        $offset = ($page * $limit) - $limit;
        $total = $wpdb->get_var("SELECT COUNT(`id`) FROM $table_name");
        $num_of_pages = ceil($total / $limit);



        $results = $wpdb->get_results("SELECT * FROM $table_name LIMIT $offset, $limit");
        echo '<form method="post" style="margin-right: 20px;">';
        echo '<table class="wp-list-table widefat fixed striped posts" >';
        echo '<thead>';
        echo '<tr>';
        echo '<th class="manage-column column-title column-primary">Title</th>';
        echo '<th class="manage-column column-title column-primary">Locality</th>';
        echo '<th class="manage-column column-title column-primary">Address</th>';
        echo '<th class="manage-column column-title column-primary">Phone</th>';
        echo '<th class="manage-column column-title column-primary">Actions</th>';
        echo '<th class="manage-column column-cb check-column" style="padding: 8px 10px"><input type="checkbox" id="cb-select-all"/></th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($results as $result) {
            echo '<tr>';
            echo '<td class="manage-column column-title column-primary">' . $result->title . '</td>';
            echo '<td class="manage-column column-title column-primary">' . $result->locality . '</td>';
            echo '<td class="manage-column column-title column-primary">' . $result->address . '</td>';
            echo '<td class="manage-column column-title column-primary">' . $result->phone . '</td>';
            echo '<td class="manage-column column-title column-primary"><a href="?page=csv-get-data&action=edit&id=' . $result->id . '">Edit </a> </td>';
            echo '<th class="check-column"><input type="checkbox" name="ids[]" value="' . $result->id . '"/></th>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '<p class="submit" style="text-align: right; margin-top: 5px;
        "><input type="submit" name="delete_selected" class="button" value="Delete Selected"/></p>';
        echo '</form>';
        // if the action is delete_selected then delete the data from the database 
        if (isset($_POST['delete_selected'])) {
            $ids = $_POST['ids'];
            foreach ($ids as $id) {
                $wpdb->delete($table_name, array('id' => $id));
            }
            echo '<script>alert("Data deleted successfully");</script>';
        
            echo '<script>window.location.href = "?page=csv-get-data";</script>';

            


        }
        // add another input type submit to delete all data from the database
        echo '<form method="post">';
        echo '<p class="submit" style="text-align: right; margin-right:20px; margin-top: 5px;"><input type="submit" name="delete_all" class="button" value="Delete All"/></p>';
        echo '</form>';
        // if the action is delete_all then delete the data from the database
        if (isset($_POST['delete_all'])) {
            $wpdb->query("TRUNCATE TABLE $table_name");
            echo '<div class="updated"><p>All data deleted</p></div>';
            echo '<script>window.location.href = "?page=csv-get-data";</script>';
        }

        // create next and previous button for pagination
        echo '</tbody>';
        echo '</table>';
        echo '<div class="tablenav bottom">';
        echo '<div class="tablenav-pages" style="text-align: center;width: 100%;">';
        echo '<span class="displaying-num">' . $total . ' items</span>';
        echo '<span class="pagination-links">';
        echo paginate_links(array(
            'base' => add_query_arg('cpage', '%#%'),
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => $num_of_pages,
            'current' => $page
        ));
        echo '</span>';
        echo '</div>';
        echo '</div>';

        }

        // if the action is delete then delete the data from the database
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            $id = $_GET['id'];
            
            $wpdb->delete( $table_name, array( 'id' => $id ) );
        }
        // if the action is edit display popup to edit the data
        if (isset($_GET['action']) && $_GET['action'] === 'edit') {
            // disable scroll on body
            echo '<style>body{overflow: hidden;}</style>';
            $id = $_GET['id'];
            $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = '$id'" );
            foreach ($results as $result) {
                $title = $result->title;
                $locality = $result->locality;
                $address = $result->address;
                $phone = $result->phone;
                $cord1 = $result->cordi1;
                $cord2 = $result->cordi2;
                $link1 = $result->link1;
                $link2 = $result->link2;
                $description = $result->despcription;
                $hours = $result->hour;
                $Provincia = $result->Provincia;
            }
            ?>
<div class=""
    style="position:absolute; height: 100vh; top: 0%; width: 96%; padding: 20px; background-color:#f6f7f7; ">
    <div class="bx" style="display:flex; justify-content: space-between; align-items:center;">
        <h2 style="color: black;">Edit Data</h2>
        <a href="?page=csv-get-data" style=" color: black; font-size: 20px; text-decoration: none;">X</a>
    </div>

    <form method="post" style="color: black; display: flex; justify-content: space-between; flex-wrap: wrap; "
        action="?page=csv-get-data&action=update&id=<?php echo $id; ?>">
        <div class="box1" style="flex-basis: 50%;">
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="title">Title:</label>
                <br>
                <input type="text" name="title" style=" margin-top: 5px;  width: 80%;" id="title"
                    value="<?php echo $title; ?>">
            </div>
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="locality">Locality:</label>
                <br>
                <input type="text" name="locality" style=" margin-top: 5 px; width: 80%;" id="locality"
                    value="<?php echo $locality; ?>">
            </div>
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="address">Address:</label>
                <br>
                <input type="text" name="address" style=" margin-top: 5p x; width: 80%;" id="address"
                    value="<?php echo $address; ?>">
            </div>
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="link1">Link1:</label>
                <br>
                <input type="text" name="link1" style=" margin-top: 5px;  width: 80%;" id="cordi2"
                    value="<?php echo $link1; ?>">
            </div>
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="Provincia">Provincia:</label>
                <br>
                <input type="text" name="Provincia" style=" margin-top:  5px; width: 80%;" id="cordi2"
                    value="<?php echo $Provincia; ?>">
            </div>
        </div>
        <div class="box2" style="flex-basis: 50%;">
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="phone">Phone:</label>
                <br>
                <input type="text" name="phone" style=" margin-top: 5px;  width: 80%;" id="phone"
                    value="<?php echo $phone; ?>">
            </div>
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="cordi1">Cordi1:</label>
                <br>
                <input type="text" name="cordi1" style=" margin-top: 5px ; width: 80%;" id="cordi1"
                    value="<?php echo $cord1; ?>">
            </div>
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="cordi2">Cordi2:</label>
                <br>
                <input type="text" name="cordi2" style=" margin-top: 5px ; width: 80%;" id="cordi2"
                    value="<?php echo $cord2; ?>">
            </div>

            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="link2">Link2:</label>
                <br>
                <input type="text" name="link2" style=" margin-top: 5px;  width: 80%;" id="cordi2"
                    value="<?php echo $link2; ?>">
            </div>
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="hours">hours:</label>
                <br>
                <input type="text" name="hours" style=" margin-top: 5px;  width: 80%;" id="cordi2"
                    value="<?php echo $hours; ?>">
            </div>

        </div>
        <div class="box3" style="flex-basis: 100%;">
            <div class="box" style="padding-bottom: 15px;">
                <label style="font-weight:bold;" for="description">Description:</label>
                <br>
                <textarea style="width: 90%;" name="description" id="" cols="95" rows="5"><?php echo $description; ?></textarea>
            </div>
        </div>
        <br>

        <input type="submit" name="submit" value="Update"
            style="background-color: rgb(13, 157, 235) ; border: none; padding: 10px 30px; color: white; border-radius: 5px;">
    </form>

</div>
<?php
            // if the action is update then update the data in the database and if there is a change in the data then update the data

        } elseif (isset($_GET['action']) && $_GET['action'] === 'update') {
            $id = $_GET['id'];
            $title = $_POST['title'];
            $locality = $_POST['locality'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $cord1 = $_POST['cordi1'];
            $cord2 = $_POST['cordi2'];
            $description = $_POST['description'];
            $link1 = $_POST['link1'];
            $link2 = $_POST['link2'];
            $hours = $_POST['hours'];
            $Provincia = $_POST['Provincia'];
            // if link1 does't have http:// or https:// then add it
            if (strpos($link1, 'http://') === false && strpos($link1, 'https://') === false && $link1 != '') {
                $link1 = 'https://' . $link1;
            }
            // if link2 does't have http:// or https:// then add it
            if (strpos($link2, 'http://') === false && strpos($link2, 'https://') === false && $link2 != '') {
                $link2 = 'https://' . $link2;
            }
            $wpdb->update( $table_name, array(
                'title' => $title,
                'locality' => $locality,
                'address' => $address,
                'phone' => $phone,
                'cordi1' => $cord1,
                'cordi2' => $cord2,
                'despcription' => $description,
                'link1' => $link1,
                'link2' => $link2,
                'hour' => $hours,
                'Provincia' => $Provincia,

            ), array( 'id' => $id ) );
        }

}





//////////// 

?>

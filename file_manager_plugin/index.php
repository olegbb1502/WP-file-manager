<?php
/*
Plugin Name: File Manager plugin
Description: A File Manager plugin for Wordpress that helps to operate with files and render them on the page
Author: Anastasia Taran
Version: 0.1
*/
add_action('admin_menu', 'file_manager_plugin_setup_menu');
 
function file_manager_plugin_setup_menu(){
    add_menu_page( 'File Manager Page', 'File Manager Plugin', 'manage_options', 'file_manager_plugin', 'file_manager_init' );
}
 
function file_manager_init(){
    test_handle_post();
?>
    <h1>Hello World!</h1>
    <h2>Upload a File</h2>
    <!-- Form to handle the upload - The enctype value here is very important -->
    <form  method="post" enctype="multipart/form-data">
        <input type='file' id='test_upload_pdf' name='test_upload_pdf'></input>
        <?php submit_button('Upload') ?>
    </form>
<?php
}
 
function test_handle_post(){
    // First check if the file appears on the _FILES array
    if(isset($_FILES['test_upload_pdf'])){
        $pdf = $_FILES['test_upload_pdf'];
 
        // Use the wordpress function to upload
        // test_upload_pdf corresponds to the position in the $_FILES array
        // 0 means the content is not associated with any other posts
        $uploaded=media_handle_upload('test_upload_pdf', 0);
        // Error checking using WP functions
        if(is_wp_error($uploaded)){
            echo "Error uploading file: " . $uploaded->get_error_message();
        }else{
            echo "File upload successful!";
        }
    }
}
 
?>
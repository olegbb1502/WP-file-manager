<?php
/*
Plugin Name: File Manager plugin
Description: A File Manager plugin to demonstrate wordpress functionality
Author: Anastasia Taran
Version: 0.1
*/
add_action('admin_menu', 'file_manager_plugin_setup_menu');
 
function file_manager_plugin_setup_menu(){
    add_menu_page( 'File Manager Page', 'File Manager Plugin', 'manage_options', 'file_manager_plugin', 'file_manager_init' );
}
 

function file_manager_init(){
    global $wpdb;
    // пример: add_action ('init', 'my_init_function');
    $table_name = $wpdb->prefix . "diploms_archive";
    if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
       
       $sql = "CREATE TABLE " . $table_name . " (
       id mediumint(9) NOT NULL AUTO_INCREMENT,
       year year(4) NOT NULL,
       category varchar(255) NOT NULL,
       autor varchar(255) NOT NULL,
       file varchar(255) NOT NULL,
       UNIQUE KEY id (id)
     );";
 
     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
       dbDelta($sql);
    }
    test_handle_post();
?>


 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
 <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
 <style>
     select{
        background: #fff!important;
     }

     #filter-btn {
        background-color: #00d1b2;
        border-color: transparent;
        color: #fff;
        margin-left: 50px;
        height: 40px;
        width: 150px;
        cursor: pointer;
        border-radius: 4px;
     }
     #filter-btn:hover {
        background-color: #00c4a7;
     }
     .fa-upload:before {
        content: "\f093";
    }
    .row {
        display: flex;
        align-items: flex-end;
        justify-content: flex-start;
    }
    .col {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
    }
    .row .control:first-child {
        margin-right: 20px;
    }
    .form-filter {
        margin-bottom: 30px;
        display: flex;
        align-content: flex-start;
        justify-content: flex-start;
    }
    .margin-bottom {
        margin-bottom: 1.5rem;
    }
    .autor-field {
        width: 400px;
    }
    .file.is-primary {
        margin-left: 50px;
    }
 </style>    
 <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
   <?php 
global $wpdb;

$table_name = "wp_diploms_archive";
$myrows = $wpdb->get_results( "SELECT `id`,`year`,`category`,`autor`,`file` FROM ".$table_name);

?>
<h2 class="title">Filter records</h2>
<form method="post" id="filter-wrapper" class="form-filter">
    <div class="col">    
        <div class="control">
            <div class="select">
                <select id="filterByYear" onchange="filter()">
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022" selected>2022</option>
                </select>
            </div>
        </div>
    </div>
    <button id="filter-btn" onclick="btnClick(event)">filter</button>
    <!-- <button id="reset-btn" onclick="btnReset(event)">Reset</button> -->
</form>
<script>
    function filter() {
        var e = document.getElementById("filterByYear");
        var strUser = e.value;
        // console.log(strUser); 
        return strUser;   
    };


    function btnClick(e) {
        e.preventDefault();
        var frm = $('#filter-wrapper');
        var formData = frm.serializeArray();
        var year = filter();
        $.ajax({
            method: 'POST',
            type: 'POST',
            data: { 
                action: 'filter',
                data: year,  
            },
            url: '/wp-admin/admin-ajax.php',
            dataType: "html",
            success: function (data) {
                // var d = JSON.parse(data);
                let elem = document.querySelector('.table');
                elem.innerHTML = data;
                // console.log(data);
                }
        });
    }
</script>
<table class="table">
  <thead>
  <tr>
     <th>ID </th>
     <th>Year </th>
     <th>Category </th>
     <th>Autor </th>
     <th>File </th>
  </tr>
  </thead>
<tbody>
<?php 
$total = 0;
foreach ($myrows as $details) :?>
  <tr class="item_row">
        <td><?php echo $details->id; ?></td>
        <td> <?php echo $details->year; ?></td>
        <td> <?php echo $details->category; ?></td>
        <td> <?php echo $details->autor;?></td>
        <td> <?php echo $details->file; ?></td>
  </tr>
<?php endforeach;?>
</tbody>
</table>
    <form  method="post" enctype="multipart/form-data">
        <h2 class="title">Add new records</h2>
        <div class="row margin-bottom">
            <div class="control">
                <div class="select">
                    <select name="year"> 
                        <option value="2005">2005</option>
                        <option value="2006">2006</option>
                        <option value="2007">2007</option>
                        <option value="2008">2008</option>
                        <option value="2009">2009</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022" selected>2022</option>
                    </select>
                </div>
            </div>
            <div class="control">
                <div class="select">
                    <select name="category">
                        <option value="bachelor" selected>Бакалавр</option>
                        <option value="master">Магістр</option>
                        <option value="postgraduate">Аспірант</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="margin-bottom row">
            <div class="col">
                <label class="label">Autor</label>
                <div class="control autor-field">
                    <input class="input" type="text" placeholder="Autor name" name="autor">
                </div> 
            </div>
            <div class="file is-primary">
                <label class="file-label">
                    <input class="file-input" type="file" id='test_upload_pdf' name='test_upload_pdf'>
                    <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Primary file…
                    </span>
                    </span>
                </label>
            </div>
        </div>
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
        function wpse_custom_upload_dir( $dir_data ) {
            // $dir_data already you might want to use
            $custom_dir = 'diploms';
            return [
                'path' => $dir_data[ 'basedir' ] . '/' . $custom_dir,
                'url' => $dir_data[ 'url' ] . '/' . $custom_dir,
                'subdir' => '/' . $custom_dir,
                'basedir' => $dir_data[ 'error' ],
                'error' => $dir_data[ 'error' ],
            ];
        }

        add_filter( 'upload_dir', 'wpse_custom_upload_dir' );

        $uploaded=media_handle_upload('test_upload_pdf', 0);
        // Error checking using WP functions
        if(is_wp_error($uploaded)){
            echo "Error uploading file: " . $uploaded->get_error_message();
        }else{
            global $wpdb;
                $year = $_POST['year'];
                $category = $_POST['category']; 
                $autor = $_POST['autor'];
                $file = $_FILES['test_upload_pdf']['name']; 

            $sql = "INSERT INTO `wp_diploms_archive`
          (`year`,`category`,`autor`,`file`) 
   values ('$year', '$category', '$autor', '$file')";
// print_r($sql);
        $wpdb->query($sql);

            // print_r($_POST);
            // print_r($_FILES);
            // print_r($uploaded);
            // echo "File upload successful!";
        }
    }
}

function filterDiploms(){
    global $wpdb;
    $year = $_POST['data'];

    $table_name = "wp_diploms_archive";
    $myrows = $wpdb->get_results( "SELECT `id`,`year`,`category`,`autor`,`file` FROM ".$table_name." WHERE `year`='$year'");
    
    echo '<table class="table">
    <thead>
        <tr>
            <th>ID </th>
            <th>Year </th>
            <th>Category </th>
            <th>Autor </th>
            <th>File </th>
        </tr>
    </thead>
        <tbody>';
             
            foreach ($myrows as $details){
                echo'<tr class="item_row">
                        <td>'.$details->id.'</td>
                        <td>'.$details->year.'</td>
                        <td>'.$details->category.'</td>
                        <td>'.$details->autor.'</td>
                        <td>'.$details->file.'</td>
                </tr>';
                }
       echo '</tbody>
    </table>';        
    die();
}

add_action('wp_ajax_nopriv_filter','filterDiploms');
add_action('wp_ajax_filter','filterDiploms');

?>
<?php
header("Access-Control-Allow-Origin: http://www.jakerevans.com/");
header("Access-Control-Allow-Origin: *");
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: WordPress Film List- A Forward Creation
Plugin URI: https://www.jakerevans.com
Description: A plugin that allows you to create an online movie library! Simply paste this shortcode on a page or post to get started: <strong>[wpfilmlist_shortcode]</strong>. Upgrade to the <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/"><strong>WPFilmList Premium Version</strong></a> to add your Amazon Affiliate ID, Get Additional Display Options, and more! 
Version: 1.2
Author: Jake Evans - Forward Creation
Author URI: https://www.jakerevans.com
License: GPL2
*/ 
// Registering all the functions and whatnot
add_shortcode('wpfilmlist_shortcode', 'wpfilmlist_jre_plugin_dynamic_shortcode_function');
add_shortcode('showfilmcover', 'filmCoverShortcode');
add_filter('language_attributes', 'wpfilmlist_jre_add_opengraph_nameser');
register_activation_hook( __FILE__, 'wpfilmlist_jre_create_tables' );
register_deactivation_hook( __FILE__, 'wpfilmlist_jre_delete_tables' );
// Adding Ajax library
add_action( 'wp_head', 'wpfilmlist_jre_add_ajax_library' );

// For the widget
add_action( 'widgets_init', 'wpfilmlist_jre_for_widget_functionality' );

add_action( 'init', 'wpfilmlist_jre_register_table_name', 1 );
add_action( 'admin_menu', 'wpfilmlist_jre_my_admin_menu' );
add_action('wp_enqueue_scripts', 'wpfilmlist_jre_plugin_front_style' );
add_action('admin_enqueue_scripts', 'wpfilmlist_jre_plugin_admin_style' );
add_action( 'wp_footer', 'wpfilmlist_jre_various_libraries' );
add_action( 'wp_footer', 'wpfilmlist_form_checks_javascript' );
add_action( 'wp_footer', 'wpfilmlist_homepage_pretties' );
add_action( 'wp_footer', 'wpfilmlist_jre_sort_selection_javascript' );
add_action( 'wp_footer', 'wpfilmlist_jre_search_javascript' );
add_action( 'wp_footer', 'wpfilmlist_jre_page_control_javascript' );
add_action( 'in_admin_footer', 'wpfilmlist_jre_fancybox_library' );
add_action( 'in_admin_footer', 'wpfilmlist_jre_admin_clear_javascript' );
add_action( 'in_admin_footer', 'wpfilmlist_jre_display_options_javascript' );

// For displaying film info in colorbox
add_action( 'wp_footer', 'wpfilmlist_savedfilm_action_javascript' );
add_action( 'wp_ajax_savedfilm_action', 'wpfilmlist_savedfilm_action_callback' );
add_action( 'wp_ajax_nopriv_savedfilm_action', 'wpfilmlist_savedfilm_action_callback' );

// For deleting an entry
add_action( 'wp_footer', 'wpfilmlist_delete_entry_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_delete_entry_action', 'wpfilmlist_delete_entry_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_delete_entry_action', 'wpfilmlist_delete_entry_action_callback' );

// For setting display options
add_action( 'admin_footer', 'wpfilmlist_display_options_action_javascript' );
add_action( 'wp_ajax_wpfilmlist_display_options_action', 'wpfilmlist_display_options_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_display_options_action', 'wpfilmlist_display_options_action_callback' );

// For Editing a film
add_action( 'wp_footer', 'wpfilmlist_film_edit_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_film_edit_action', 'wpfilmlist_film_edit_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_film_edit_action', 'wpfilmlist_film_edit_action_callback' );

// For saving film edits to DB
add_action( 'wp_footer', 'wpfilmlist_save_film_edit_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_save_film_edit_action', 'wpfilmlist_save_film_edit_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_save_film_edit_action', 'wpfilmlist_save_film_edit_action_callback' );

// For creating/deleting custom libraries
add_action( 'admin_footer', 'wpfilmlist_new_lib_shortcode_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_new_lib_shortcode_action', 'wpfilmlist_new_lib_shortcode_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_new_lib_shortcode_action', 'wpfilmlist_new_lib_shortcode_action_callback' );

// For saving/restoring spreadsheet
add_action( 'admin_footer', 'wpfilmlist_restore_from_spreadsheet_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_restore_from_spreadsheet_action', 'wpfilmlist_restore_from_spreadsheet_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_restore_from_spreadsheet_action_action', 'wpfilmlist_restore_from_spreadsheet_action_callback' );

//For creating spreadsheet
add_action( 'admin_footer', 'wpfilmlist_jre_create_excel_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_jre_create_excel_action', 'wpfilmlist_jre_create_excel_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_jre_create_excel_action', 'wpfilmlist_jre_create_excel_action_callback' );

//For creating spreadsheet
add_action( 'wp_footer', 'wpfilmlist_jre_upload_excel_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_jre_create_upload_action', 'wpfilmlist_jre_create_upload_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_jre_create_upload_action', 'wpfilmlist_jre_create_upload_action_callback' );

//For loading in new film form
add_action( 'wp_footer', 'wpfilmlist_jre_film_addition_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_jre_film_addition_action', 'wpfilmlist_jre_film_addition_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_jre_film_addition_action', 'wpfilmlist_jre_film_addition_action_callback' );

//For loading in film deletion form
add_action( 'wp_footer', 'wpfilmlist_jre_film_delete_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_jre_film_delete_action', 'wpfilmlist_jre_film_delete_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_jre_film_delete_action', 'wpfilmlist_jre_film_delete_action_callback' );

//For uploading new stylepak file
add_action( 'admin_footer', 'wpfilmlist_jre_stylepak_file_upload_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_jre_stylepak_file_upload_action', 'wpfilmlist_jre_stylepak_file_upload_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_jre_stylepak_file_upload_action', 'wpfilmlist_jre_stylepak_file_upload_action_callback' );

//For setting stylepak file
add_action( 'admin_footer', 'wpfilmlist_jre_stylepak_selection_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_jre_stylepak_selection_action', 'wpfilmlist_jre_stylepak_selection_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_jre_stylepak_selection_action', 'wpfilmlist_jre_stylepak_selection_action_callback' );

//For adding shows and movies
add_action( 'wp_footer', 'wpfilmlist_add_movies_and_tv_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_add_movies_and_tv_action', 'wpfilmlist_add_movies_and_tv_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_add_movies_and_tv_action', 'wpfilmlist_add_movies_and_tv_action_callback' );

//For dismissing notice
add_action( 'admin_footer', 'wpfilmlist_jre_dismiss_notice_forever_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_jre_dismiss_notice_forever_action', 'wpfilmlist_jre_dismiss_notice_forever_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_jre_dismiss_notice_forever_action', 'wpfilmlist_jre_dismiss_notice_forever_action_callback' );

// For adding user's amazon affiliate ID
add_action( 'admin_footer', 'wpfilmlist_id_amazon_affiliate_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_id_amazon_affiliate_action', 'wpfilmlist_id_amazon_affiliate_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_id_amazon_affiliate_action', 'wpfilmlist_id_amazon_affiliate_action_callback' );

// For bulk deleting entries
add_action( 'admin_footer', 'wpfilmlist_bulk_delete_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_bulk_delete_action', 'wpfilmlist_bulk_delete_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_bulk_delete_action', 'wpfilmlist_bulk_delete_action_callback' );

// For bulk rating entries
add_action( 'admin_footer', 'wpfilmlist_bulk_rate_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_bulk_rate_action', 'wpfilmlist_bulk_rate_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_bulk_rate_action', 'wpfilmlist_bulk_rate_action_callback' );

// For bulk notes
add_action( 'admin_footer', 'wpfilmlist_bulk_notes_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpfilmlist_bulk_notes_action', 'wpfilmlist_bulk_notes_action_callback' );
add_action( 'wp_ajax_nopriv_wpfilmlist_bulk_notes_action', 'wpfilmlist_bulk_notes_action_callback' );

add_action( 'admin_footer', 'wpfilmlist_bulk_edit_form_checks_action_javascript' ); // Write our JS below here


function wpfilmlist_jre_for_reviews_and_wpfilmlist_admin_notice__success() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'wpfilmlist_jre_user_options';
  $options_row = $wpdb->get_results("SELECT * FROM $table_name");
  $dismiss = $options_row[0]->admindismiss;
  if($dismiss == 1){
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( "<span style='font-weight:bold; font-size: 15px; font-style:italic;'>Happy with WPFilmList are ya?</span> Then you'll be thrilled with the <span style='font-weight:bold; font-size: 15px; font-style:italic;'><a href='https://www.jakerevans.com/product/wordpress-film-list-premium/'>premium version of WPFilmList!</a></span> Add your own Amazon affiliate ID, Receive Cast and Crew Images and data, display entertaining and thought-provoking Movie quotes, and more! <a href='https://www.jakerevans.com/product/wordpress-film-list-premium/'>Try it today!</a> Also, if you're happy with WPFilmList, then please consider <a href='https://wordpress.org/support/plugin/wpfilmlist/reviews/'>leaving me a 5-star review</a>.<p><a href='https://www.jakerevans.com/shop/'>StylePaks</a> are now avaliable! Quickly and easily change the <a href='https://www.jakerevans.com/shop/'>look and feel of WPFilmList Now!</a></p><p>-Jake</p><div id='wpfilmlist-my-notice-dismiss-forever'>Dismiss Forever</div>", 'sample-text-domain' ); ?></p>
    </div>
    <?php
  }
}
add_action( 'admin_notices', 'wpfilmlist_jre_for_reviews_and_wpfilmlist_admin_notice__success' );

/*
 * Adds the WordPress Ajax Library to the frontend.
*/
function wpfilmlist_jre_add_ajax_library() {
 
    $html = '<script type="text/javascript">';

    // checking $protocol in HTTP or HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        // this is HTTPS
        $protocol  = "https";
    } else {
        // this is HTTP
        $protocol  = "http";
    }
    $tempAjaxPath = admin_url( 'admin-ajax.php' );
    $goodAjaxUrl = $protocol.strchr($tempAjaxPath,':');

    $html .= 'var ajaxurl = "' . $goodAjaxUrl . '"';
    $html .= '</script>';
    echo $html;
    
} // End add_ajax_library

//facebook and Open Graph nameservers
function wpfilmlist_jre_add_opengraph_nameser( $output ) {
  return $output . '
  xmlns:og="https://opengraphprotocol.org/schema/"
  xmlns:fb="https://www.facebook.com/2008/fbml"';
}

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
global $wpdb;
global $charset_collate; 
    
// Function to allow users to specify which table they want displayed by passing as an argument in the shortcode
function wpfilmlist_jre_plugin_dynamic_shortcode_function($atts){
  global $wpdb;
  extract(shortcode_atts(array(
          'table' => $wpdb->prefix."saved_film_log",
  ), $atts));
  $which_table = $wpdb->prefix . 'wpfilmlist_jre_'.$table;
  if($atts == null){
    $which_table = $wpdb->prefix.'wpfilmlist_jre_saved_film_log';
  }
  $GLOBALS['a'] = $which_table;
  // To output ui.php where the shortcode is placed on the page and not push displace other content
  ob_start();
  include_once( plugin_dir_path( __FILE__ ) . 'ui.php');
  return ob_get_clean();
}

// Shortcode function for displaying film cover image/link
function filmCoverShortcode($atts) {
  global $wpdb;

  extract(shortcode_atts(array(
          'table' => $wpdb->prefix."saved_film_log",
          'title' => '',
          'width' => '100',
          'align' => 'left',
          'margin' => '5px'
  ), $atts));
  $table = $wpdb->prefix.'wpfilmlist_jre_saved_film_log';
  $table_name_options = $wpdb->prefix . 'wpfilmlist_jre_user_options';
  $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table  LIMIT %d",1));
  $options_results = $wpdb->get_row("SELECT * FROM $table_name_options");
  $amazonaff = filter_var($options_results->amazonaff, FILTER_SANITIZE_STRING);
  if(sizeof($options_row) > 0){

    if($atts == null){
      $table = $wpdb->prefix.'wpfilmlist_jre_saved_film_log';
      $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table  LIMIT %d",1));
      $title = $options_row[0]->title;
      $width = '100';
      echo '1';
      //echo 'table: '.$table.PHP_EOL.'isbn: '.$isbn;
    }

    if(!isset($atts['title']) && !isset($atts['table']) ){
      $table = $wpdb->prefix.'wpfilmlist_jre_saved_film_log';
      $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table LIMIT %d",1));
      $title = $options_row[0]->title;
    }

    if(!isset($atts['title']) && isset($atts['table']) ){
      $table = $wpdb->prefix.'wpfilmlist_jre_'.$atts['table'];
      $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table  LIMIT %d",1));
      $title = $options_row[0]->title;

    }

    if(isset($atts['title']) && !isset($atts['table']) ){
      $table = $wpdb->prefix.'wpfilmlist_jre_saved_film_log';
    }

    if(isset($atts['title']) && isset($atts['table'])){
      $table = $wpdb->prefix.'wpfilmlist_jre_'.$atts['table'];
    }

    $title = addslashes($title);
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $title = str_replace('&#0','&#',$title);

    $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE title = %s", $title));
    if(sizeof($options_row) == 0){
      echo "This film isn't in your Library! Please check the title and/or library name you provided.";
    } else {
      $image = $options_row[0]->coverurl;

      //Build amazon link
      $link = '';
      $amazontitle = preg_replace('/[^a-z]+/i', ' ', $title);
      $amazontitle = str_replace(" s", "s", $amazontitle);
      $amazontitle = str_replace("Marvels", "", $amazontitle);

      $postdata = http_build_query(
          array(
              'associate_tag' => $amazonaff,
              'title' => $amazontitle
          )
      );


      $opts = array('http' =>
          array(
              'method'  => 'POST',
              'header'  => 'Content-type: application/x-www-form-urlencoded',
              'content' => $postdata
          )
      );

      $context = stream_context_create($opts);
        // Begin Amazon Data Grab Use file_get_contents if we can
      if (ini_get("allow_url_fopen") == 1) {
        $result = file_get_contents('https://jakerevans.com/awsapiconfigfilm.php', false, $context);
        $xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($xml);
        $amazon_array = json_decode($json,TRUE);
      } else {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $url = 'https://jakerevans.com/awsapiconfiggames.php';
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = array('title' => $name, 'associate_tag' => $options_results->amazonaff);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($xml);
        $amazon_array = json_decode($json,TRUE);
      }

      if(!empty($amazon_array['Items']['Item'])){
        foreach($amazon_array['Items']['Item'] as $result){
          if($result["ItemAttributes"]['Binding'] == 'Amazon Video'){
              if($link == null){
                  $link = $result["DetailPageURL"];
              }
          }
        }
      }

      if($link == null){
        if(!empty($amazon_array['Items']['Item']["DetailPageURL"])){
          $link = $amazon_array['Items']['Item']["DetailPageURL"];
        }
      }

      if($link == null){
          $link = 'https://www.amazon.com/s/ref=nb_sb_ss_c_1_9?url=search-alias%3Dinstant-video&field-keywords='.urlencode($title).'&sprefix='.urlencode($title).'%2Cinstant-video%2C171&crid=3RMSQOZ9YRJ9R';
      }

      ob_start();
      if((isset($atts['amazon'])) && ($atts['amazon'] == 'true')){
        $amazon = 'true';
      } else{
        $amazon = 'false';
      }

      if( (isset($atts['showtitle'])) && ($atts['showtitle'] == 'true')){
        $showtitle = 'true';
      } else{
        $showtitle = 'false';
      }

        if(($amazon == 'true') && ($showtitle == 'false')  ){
           return '<div style="width:'.$width.'px; float:'.$align.';" class="wpfilmlist-indiv-film-container-div"><a class="wpfilmlist_jre_film_cover_shortcode_link" target="_blank" href="'.$link.'"><img width='.$width.' src="'.$image.'"/></a></div>';
        }

        if(($amazon == 'true') && ($showtitle == 'true')){
           return '<div style="width:'.$width.'px; float:'.$align.';" class="wpfilmlist-indiv-film-container-div"><a class="wpfilmlist_jre_film_cover_shortcode_link" target="_blank" href="'.$link.'"><img width='.$width.' src="'.$image.'"/></a><p style="width:'.$width.'px; display:inline-table;">'.htmlspecialchars_decode(stripslashes($options_row[0]->title)).'</p></div>';
        } 




        if(($amazon == 'false') && ($showtitle == 'true')){
          if($image == null){
            ?><div style="width:<?php echo $width ?>px; float:<?php echo $align ?>;" class="wpfilmlist-indiv-film-container-div"> <img width="<?php echo $width ?>" data-table="<?php echo $table ?>" data-backdrop="<?php echo $options_row[0]->backdropurl; ?>" class="wpfilmlist_cover_image_class wpfilmlist-cover-image-class-widget" id="wpfilmlist_cover_image_indiv_id" src="<?php echo plugins_url( '/assets/img/image_unavaliable.png', __FILE__ ); ?>"/><span class="hidden_id_title"><?php echo $options_row[0]->ID; ?></span><p style="width:<?php echo $width ?>px;display:inline-table;" data-table="<?php echo $table ?>" data-backdrop="<?php echo $options_row[0]->backdropurl; ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($options_row[0]->title)); ?><span class="hidden_id_title"><?php echo $options_row[0]->ID;?></span></p></div><?php
          } else {
            ?><div style="width:<?php echo $width ?>px; float:<?php echo $align ?>;" class="wpfilmlist-indiv-film-container-div"><img width="<?php echo $width ?>" data-table="<?php echo $table ?>" data-backdrop="<?php echo $options_row[0]->backdropurl; ?>" class="wpfilmlist_cover_image_class wpfilmlist-cover-image-class-widget" id="wpfilmlist_cover_image_indiv_id" src=<?php echo '"'. $options_row[0]->coverurl.'"'; ?> /><span class="hidden_id_title"><?php echo $options_row[0]->ID ?></span><p style="width:<?php echo $width ?>px;display:inline-table;" data-table="<?php echo $table ?>" data-backdrop="<?php echo $options_row[0]->backdropurl ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($options_row[0]->title)); ?><span class="hidden_id_title"><?php echo $options_row[0]->ID?></span></p></div><?php
          }

        }

        if(($amazon == 'false') && ($showtitle == 'false')){
          if($image == null){
            ?><div style="width:<?php echo $width ?>px; float:<?php echo $align ?>;" class="wpfilmlist-indiv-film-container-div"> <img width="<?php echo $width ?>" data-table="<?php echo $table ?>" data-backdrop="<?php echo $options_row[0]->backdropurl; ?>" class="wpfilmlist_cover_image_class wpfilmlist-cover-image-class-widget" id="wpfilmlist_cover_image_indiv_id" src="<?php echo plugins_url( '/assets/img/image_unavaliable.png', __FILE__ ); ?>"/><span class="hidden_id_title"><?php echo $options_row[0]->ID; ?></span><p style="width:<?php echo $width ?>px;display:none;" data-table="<?php echo $table ?>" data-backdrop="<?php echo $options_row[0]->backdropurl; ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($options_row[0]->title)); ?><span class="hidden_id_title"><?php echo $options_row[0]->ID;?></span></p></div><?php
          } else {
            ?><div style="width:<?php echo $width ?>px; float:<?php echo $align ?>;" class="wpfilmlist-indiv-film-container-div"><img width="<?php echo $width ?>" data-table="<?php echo $table ?>" data-backdrop="<?php echo $options_row[0]->backdropurl; ?>" class="wpfilmlist_cover_image_class wpfilmlist-cover-image-class-widget" id="wpfilmlist_cover_image_indiv_id" src=<?php echo '"'. $options_row[0]->coverurl.'"'; ?> /><span class="hidden_id_title"><?php echo $options_row[0]->ID ?></span><p style="width:<?php echo $width ?>px;display:none;" data-table="<?php echo $table ?>" data-backdrop="<?php echo $options_row[0]->backdropurl ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($options_row[0]->title)); ?><span class="hidden_id_title"><?php echo $options_row[0]->ID?></span></p></div><?php
          }

        }
    }
  }
}

function wpfilmlist_jre_my_admin_menu() {
  add_menu_page( 'WP Film List Options', 'WP Film List', 'manage_options', 'WP-Film-List-Options', 'wpfilmlist_jre_admin_page_function', plugins_url('/assets/img/wpfilmlistdashboardicon.png', __FILE__ ), 6  );
}

function wpfilmlist_jre_admin_page_function(){
  // calling file that handles all options page stuff
  include 'backend.php';
}

// Function to add table name to the global $wpdb
function wpfilmlist_jre_register_table_name() {
    global $wpdb;
    $wpdb->wpfilmlist_jre_saved_film_log = "{$wpdb->prefix}wpfilmlist_jre_saved_film_log";
    $wpdb->wpfilmlist_jre_user_options = "{$wpdb->prefix}wpfilmlist_jre_user_options";
    $wpdb->wpfilmlist_jre_list_dynamic_db_names = "{$wpdb->prefix}wpfilmlist_jre_list_dynamic_db_names";
    $wpdb->wpfilmlist_jre_saved_film_for_widget = "{$wpdb->prefix}wpfilmlist_jre_saved_film_for_widget";
    $wpdb->wpfilmlist_jre_movie_quotes = "{$wpdb->prefix}wpfilmlist_jre_movie_quotes";
}    

// Runs once upon plugin activation
function wpfilmlist_jre_create_tables() {
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  global $wpdb;
  global $charset_collate;  
  // Call this manually as we may have missed the init hook
  wpfilmlist_jre_register_table_name();
  //Creating the table
  $sql_create_table1 = "CREATE TABLE {$wpdb->wpfilmlist_jre_saved_film_log} 
  (
        ID bigint(255) auto_increment,
        title varchar(255),
        mediaid bigint(255),
        creators varchar(255),
        releasefirstairdate varchar(255),
        coverurl varchar(255),
        imdbid varchar(255),
        overview MEDIUMTEXT,
        revenue bigint(255),
        runtime varchar(255),
        tagline varchar(255),
        networks varchar(255),
        video varchar(255),
        budget bigint(255),
        backdropurl varchar(255),
        homepageurl varchar(255),
        language varchar(255),
        productioncountry varchar(255),
        productioncompany varchar(255),
        genres varchar(255),
        originaltitle varchar(255),
        popularity bigint(255),
        belongstocollection varchar(255),
        seasons MEDIUMTEXT,
        numofseasons bigint(255),
        numofepisodes bigint(255),
        episoderuntime varchar(255),
        videostring MEDIUMTEXT,
        inproduction varchar(255),
        notes varchar(255),
        watched varchar(255),
        status varchar(255),
        caststring MEDIUMTEXT,
        crewstring MEDIUMTEXT,
        type varchar(255),
        myfilmrating bigint(255),
        uberepisodestring MEDIUMTEXT,
        reviewstars bigint(255),
        PRIMARY KEY  (ID),
          KEY title (title)
  ) $charset_collate; ";
  dbDelta( $sql_create_table1 );

  $sql_create_table_widget = "CREATE TABLE {$wpdb->wpfilmlist_jre_saved_film_for_widget} 
  (
        ID bigint(255) auto_increment,
        title varchar(255),
        mediaid bigint(255),
        creators varchar(255),
        releasefirstairdate varchar(255),
        coverurl varchar(255),
        imdbid varchar(255),
        overview MEDIUMTEXT,
        revenue bigint(255),
        runtime varchar(255),
        tagline varchar(255),
        networks varchar(255),
        video varchar(255),
        budget bigint(255),
        backdropurl varchar(255),
        homepageurl varchar(255),
        language varchar(255),
        productioncountry varchar(255),
        productioncompany varchar(255),
        genres varchar(255),
        originaltitle varchar(255),
        popularity bigint(255),
        belongstocollection varchar(255),
        seasons MEDIUMTEXT,
        numofseasons bigint(255),
        numofepisodes bigint(255),
        episoderuntime varchar(255),
        videostring MEDIUMTEXT,
        inproduction varchar(255),
        notes varchar(255),
        watched varchar(255),
        status varchar(255),
        caststring MEDIUMTEXT,
        crewstring MEDIUMTEXT,
        type varchar(255),
        myfilmrating bigint(255),
        uberepisodestring MEDIUMTEXT,
        reviewstars bigint(255),
        PRIMARY KEY  (ID),
          KEY title (title)
  ) $charset_collate; ";
  dbDelta( $sql_create_table_widget );
    
  $sql_create_table2 = "CREATE TABLE {$wpdb->wpfilmlist_jre_user_options} 
  (
        ID bigint(255) auto_increment,
        username varchar(255),
        amazonaff varchar(255) NOT NULL DEFAULT 'wpbooklistid-20',
        barnesaff varchar(255),
        itunesaff varchar(255) NOT NULL DEFAULT '1010lnPx',
        facebookinfo varchar(255),
        twitterinfo varchar(255),
        goodreadsinfo varchar(255),
        hideaddfilm bigint(255),
        hidestats bigint(255),
        hideeditdelete bigint(255),
        hidesortby bigint(255),
        hidesearch bigint(255),
        hidefacebook bigint(255),
        hidemessenger bigint(255),
        hidetwitter bigint(255),
        hidegoogleplus bigint(255),
        hidepinterest bigint(255),
        hideemail bigint(255),
        hidebackupdownload bigint(255),
        hidedescription bigint(255),
        hidevideos bigint(255),
        hideimages bigint(255),
        hidetoppurchase bigint(255),
        hidebottompurchase bigint(255),
        hidetagline bigint(255),
        hidequote bigint(255) NOT NULL DEFAULT 1,
        hidequotefilm bigint(255),
        hidereview bigint(255) NOT NULL DEFAULT 1,
        hidereviewfilm bigint(255) NOT NULL DEFAULT 1,
        hidelinks bigint(255),
        hidecast bigint(255) NOT NULL DEFAULT 1,
        hidecrew bigint(255) NOT NULL DEFAULT 1,
        hidenotes bigint(255),
        sortoption varchar(255),
        filmsonpage bigint(255) NOT NULL DEFAULT 12,
        email varchar(255),
        accountcreation varchar(255),
        stylepak varchar(255) NOT NULL DEFAULT 'Default',
        admindismiss bigint(255) NOT NULL DEFAULT 1,
        PRIMARY KEY  (ID),
          KEY username (username)
  ) $charset_collate; ";
  dbDelta( $sql_create_table2 );

  $sql_create_table3 = "CREATE TABLE {$wpdb->wpfilmlist_jre_list_dynamic_db_names} 
  (
        ID bigint(255) auto_increment,
        user_table_name varchar(255) NOT NULL,
        PRIMARY KEY  (ID),
          KEY user_table_name (user_table_name)
  ) $charset_collate; ";
  dbDelta( $sql_create_table3 ); 

  $sql_create_table4 = "CREATE TABLE {$wpdb->wpfilmlist_jre_movie_quotes} 
  (
        ID bigint(255) auto_increment,
        placement varchar(255),
        quote varchar(255),
        PRIMARY KEY  (ID),
          KEY quote (quote)
  ) $charset_collate; ";
  dbDelta( $sql_create_table4 );

    $quote_string = '"With WPFilmList Premium, you can add your Amazon Affiliate ID to each entry on your site! <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>";"With WPFilmList Premium, you can display Cast & Crew Images for each movie and TV Show! <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>";"With WPFilmList Premium, you can bulk-edit Movies and TV Shows. <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>";<a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>;<a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>;With WPFilmList Premium, you can display famous movie quotes! <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>;With WPFilmList Premium, you can set the default sorting site-wide! <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>;With WPFilmList Premium, you can rate titles with 1-5 stars! <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>;Like Books? Then <a href="https://wordpress.org/plugins/wpbooklist/">check out WPBookList now!</a>;Like Video Games? Then <a href="https://wordpress.org/plugins/wpgamelist/">check out WPGameList now!</a>;Display books on your site with your Amazon Affiliate ID! <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPBookList Premium now!</a>;Display video games on your site with your Amazon Affiliate ID! <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>';

  $quote_array = explode(';', $quote_string);
  $table_name = $wpdb->prefix . 'wpfilmlist_jre_movie_quotes';
  foreach($quote_array as $quote){
      $placement = 'film';
    if(strlen($quote) > 1){
      $wpdb->insert( $table_name, array('quote' => $quote, 'placement' => $placement)); 
    }
  }

  $table_name = $wpdb->prefix . 'wpfilmlist_jre_user_options';
  $wpdb->insert( $table_name, array('ID' => 1)); 
}

// Code for deleting wpfilmlist_jre_saved_text_log table upon deactivation of plugin
function wpfilmlist_jre_delete_tables() {
    global $wpdb;
    $table1 = $wpdb->prefix."wpfilmlist_jre_saved_film_log";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table1", $table1));
    
    $table2 = $wpdb->prefix."wpfilmlist_jre_user_options";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table2", $table2));
    
    $table3 = $wpdb->prefix."wpfilmlist_jre_list_dynamic_db_names";

    $table4 = $wpdb->prefix."wpfilmlist_jre_saved_film_for_widget";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table4", $table4));

    $table5 = $wpdb->prefix."wpfilmlist_jre_movie_quotes";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table5", $table5));
    
    $user_created_tables = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table3", $table3), $table3);
    foreach($user_created_tables as $utable){
      $table = $wpdb->prefix."wpfilmlist_jre_".$utable->user_table_name;
      $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table", $table));
    }
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table3", $table3));
}

// Code for adding the CSS file
function wpfilmlist_jre_plugin_front_style() {
    global $wpdb;
    $table_name_options = $wpdb->prefix . 'wpfilmlist_jre_user_options';
    $options_results = $wpdb->get_row("SELECT * FROM $table_name_options");
    $stylepak = $options_results->stylepak;
    $uploads = wp_upload_dir();

    if($stylepak == 'Default'){
      wp_register_style( 'uiwpfilmlist', plugins_url('/css/uiwpfilmlist.css', __FILE__ ) );
      wp_enqueue_style('uiwpfilmlist');
    }

    if($stylepak == 'StylePak1WPFilmList'){
      wp_register_style( 'StylePak1WPFilmList', $uploads['baseurl'].'/wpfilmlist/stylepak-exports/StylePak1WPFilmList.css');
      wp_enqueue_style('StylePak1WPFilmList');
    }

    if($stylepak == 'StylePak2WPFilmList'){
      wp_register_style( 'StylePak2WPFilmList', $uploads['baseurl'].'/wpfilmlist/stylepak-exports/StylePak2WPFilmList.css');
      wp_enqueue_style('StylePak2WPFilmList');
    }
} 

// Code for adding the CSS file that is displayed if the admin is logged in
function wpfilmlist_jre_plugin_admin_style() {
    if(current_user_can( 'administrator' )){
        wp_register_style( 'adminwpfilmlist', plugins_url('/css/adminwpfilmlist.css', __FILE__ ) );
        wp_enqueue_style('adminwpfilmlist');
    }
}

// Adds various js libraries and CSS to the footer
function wpfilmlist_jre_various_libraries(){
  ?>
  <script type="text/javascript" >
  var host = window.location.host;
  var colorboxJsUrl = '<?php echo esc_url(plugins_url("/assets/js/colorbox/jquery.colorbox.js?v=2.1.8", __FILE__)); ?>';
  var addthisJsUrl = '<?php echo esc_url(plugins_url("/assets/js/addthis.js", __FILE__)); ?>';
  var colorboxCssUrl = '<?php echo esc_url(plugins_url("/assets/css/colorbox.css", __FILE__)); ?>';
  document.write('<link rel="stylesheet" href="'+colorboxCssUrl+'" type="text/css" media="screen" />');
  document.write('<script type="text/javascript" src="'+colorboxJsUrl+'"><\/script>');
  document.write('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5767e677eed08743"><\/script>');

  var switchTo5x=true
  </script>
  <?php
}


// Adds fancybox library to the admin footer
function wpfilmlist_jre_fancybox_library(){
  ?>
  <script type="text/javascript" >
  var host = window.location.host;
  var colorboxJsUrl = '<?php echo esc_url(plugins_url("/assets/js/colorbox/jquery.colorbox.js?v=2.1.5", __FILE__)); ?>';
  var colorboxCssUrl = '<?php echo esc_url(plugins_url("/assets/css/colorbox.css", __FILE__)); ?>';
  document.write('<link rel="stylesheet" href="'+colorboxCssUrl+'" type="text/css" media="screen" />');
  document.write('<script type="text/javascript" src="'+colorboxJsUrl+'"><\/script>');
  document.write('<script type="text/javascript" src="https://malsup.github.com/jquery.form.js"><\/script>');

  </script>
  <?php
}

function wpfilmlist_savedfilm_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).ready(function($) {
      function wpfilmlist_jre_initAddThis() {
      addthis.init()
    }

    // After the DOM has loaded...
    wpfilmlist_jre_initAddThis();

    var color = jQuery('#hidden_link_for_styling').css("color");
    jQuery('.wpfilmlist_edit_entry_link,.wpfilmlist_delete_entry_link, .wpfilmlist_saved_title_link, .wpfilmlist_saved_title_link0, .wpfilmlist_saved_title_link1, .wpfilmlist_saved_title_link2,.wpfilmlist_saved_title_link3').css('color', color);
    jQuery('.wpfilmlist_edit_entry_link, .wpfilmlist_delete_entry_link, .wpfilmlist_saved_title_link, .wpfilmlist_saved_title_link0, .wpfilmlist_saved_title_link1, .wpfilmlist_saved_title_link2,.wpfilmlist_saved_title_link3').css('color', color);
    jQuery(".wpfilmlist_cover_image_class, .wpfilmlist_saved_title_link, #wpfilmlist_cover_image_indiv_id").click(function(){
      if((jQuery(this).attr('id') == 'wpfilmlist_cover_image') || (jQuery(this).attr('id') == 'wpfilmlist_cover_image_indiv_id')  ){
        var title_id = jQuery(this).siblings('span');
        var title = title_id.html();
        console.log(title_id);
      } else {
        var title_id = jQuery(this).find("span");
        var title = title_id.html();
      }

      var quote = jQuery('#wpfilmlist-ui-quote-area-hidden').html();
      var show = jQuery('#wpfilmlist-hidden-quote-indicator').html();
      if(show == 'hide'){
        quote = '';
      }
      console.log(quote);

      if((quote == null) && (jQuery(this).attr('data-quoteshow') == 'true')){
        quote = jQuery(this).attr('data-quote');
        //attribution = jQuery(this).attr('data-attribution');
        //quote = quote+attribution;
        //attribution = attribution.replace(/####/g,'"');
        //attribution = attribution.replace(/###/g,"'");
        quote = quote.replace(/####/g,'"');
        quote = quote.replace(/###/g,"'");
      }

      var backdropurl = jQuery(this).attr('data-backdrop');
      var table = jQuery(this).attr('data-table');
      console.log(quote);
      var data = {
        'action': 'savedfilm_action',
        'img_path': "<?php echo esc_url(plugins_url( '/assets/img/', __FILE__)) ?>",
        'wpfilmlist-session': table,
        'title': title,
        'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-savedfilm" ); ?>'
      };

      jQuery.post(ajaxurl, data, function(response) {
        console.log(response);
        jQuery.colorbox({
          title: quote,
          open: true,
          scrolling: true,
          width:'80%',
          height:'80%',
          html: response,
          data : data,
          onClosed:function(){
              jQuery('.cboxContentForWpFilmList').css({'opacity':'0'});
          },
          onComplete:function(){
            jQuery("#cboxLoadedContent").addClass("cboxLoadedContentForWpFilmList");
            jQuery("#cboxContent").addClass("cboxContentForWpFilmList");
            currentHeight = jQuery('.cboxLoadedContentForWpFilmList').css('height');
            currentHeight = (parseInt(currentHeight, 10) + 5);

            num = Math.floor(Math.random() * 8);
            jQuery('.cboxContentForWpFilmList').css({'background':'transparent','background-attachment':'fixed','background-image':'url('+backdropurl+')'});
            jQuery('.cboxLoadedContentForWpFilmList').css({'margin-bottom':'0px!important','min-height':currentHeight+'px'});

            color = '#4AB6FE';
            if(num == 0){
              path = "<?php echo plugins_url( '/assets/img/backdropexport0.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery(this).remove(); // prevent memory leaks as @benweet suggested
                jQuery('#wpfilmlist-background-color-image-div').css({'overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }
            if(num == 1){
              path = "<?php echo plugins_url( '/assets/img/backdropexport1.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery(this).remove(); // prevent memory leaks as @benweet suggested
                jQuery('#wpfilmlist-background-color-image-div').css({'overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }
            if(num == 2){
              path = "<?php echo plugins_url( '/assets/img/backdropexport2.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery(this).remove(); // prevent memory leaks as @benweet suggested
                jQuery('#wpfilmlist-background-color-image-div').css({'overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }
            if(num == 3){
             path = "<?php echo plugins_url( '/assets/img/backdropexport3.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery(this).remove(); // prevent memory leaks as @benweet suggested
                jQuery('#wpfilmlist-background-color-image-div').css({'overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }
            if(num == 4){
             path = "<?php echo plugins_url( '/assets/img/backdropexport4.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery(this).remove(); // prevent memory leaks as @benweet suggested
                jQuery('#wpfilmlist-background-color-image-div').css({'overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }
            if(num == 5){
              path = "<?php echo plugins_url( '/assets/img/backdropexport5.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery(this).remove(); // prevent memory leaks as @benweet suggested
                jQuery('#wpfilmlist-background-color-image-div').css({'overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }
            if(num == 6){
              path = "<?php echo plugins_url( '/assets/img/backdropexport6.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery(this).remove(); // prevent memory leaks as @benweet suggested
                jQuery('#wpfilmlist-background-color-image-div').css({'overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }
            if(num == 7){
             path = "<?php echo plugins_url( '/assets/img/backdropexport7.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery(this).remove(); // prevent memory leaks as @benweet suggested
                jQuery('#wpfilmlist-background-color-image-div').css({'overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            addthis.toolbox(
              jQuery(".addthis_sharing_toolbox").get()
            );
            addthis.toolbox(
              jQuery(".addthis_sharing_toolbox").get()
            );
            addthis.counter(
              jQuery(".addthis_counter").get()
            );

          },
          onClosed:function(){
            jQuery('.cboxContentForWpFilmList').css({'opacity':'0'});
          }
        });
      });
    });
  });

  // If clicking anywhere on the page, and if either the page info or category info popup is displayed, close one or both.
  jQuery(document).click(function() {
    if(((jQuery("#wpfilmlist_missing_pages_dynamic").css('display')) == 'block') || (jQuery("#wpfilmlist_missing_cat_dynamic").css('display'))){
      jQuery("#wpfilmlist_missing_pages_dynamic").css({'display':'none'});
      jQuery("#wpfilmlist_missing_cat_dynamic").css({'display':'none'});
    }
  });
  // If any clicks are registered INSIDE the page or category info popup, do NOT close the popup
  jQuery("#wpfilmlist_missing_pages_dynamic, #wpfilmlist_missing_cat_dynamic").click(function(e) {
    e.stopPropagation();
    return false;
  });
  //Display the page and category info popups on hover
  jQuery('#wpfilmlist_missing_pages_id').hover(function(){
    jQuery('#wpfilmlist_missing_pages_dynamic').css({'display':'block'});
  });
  jQuery('#wpfilmlist_missing_cat_id').hover(function(){
    jQuery('#wpfilmlist_missing_cat_dynamic').css({'display':'block'});
  });
  </script> <?php
}

function wpfilmlist_savedfilm_action_callback() {
  global $wpdb; // this is how you get access to the database
  $table = $GLOBALS["a"];
  $title = sanitize_text_field($_POST['title']);
  $table_name = sanitize_text_field($_POST['wpfilmlist-session']);
  if (!filter_var($_POST['img_path'], FILTER_VALIDATE_URL) === false) {
    // valid url
    $img_path = $_POST['img_path'];
  } else {
    return;
  }
 
  $table_name_options = $wpdb->prefix . 'wpfilmlist_jre_user_options';
  $saved_film = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE ID = $title", $table_name));
  $options_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name_options", $table_name_options));

  $mediaid = $saved_film->mediaid;
  if((($saved_film->caststring == null) || ($saved_film->crewstring == null)) && ($saved_film->type == 'Movie')){

    // Getting credits
    $res = file_get_contents('https://api.themoviedb.org/3/movie/'.$mediaid.'/credits?api_key=06704b70c2a5b0d53730316cca8c3e7a
');
    $tmdb_movie_array_creds = json_decode($res, true);

    // Make request to tmdb with cUrl if file_get_contents fails
    if($tmdb_movie_arraycreds == null){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $url = 'https://api.themoviedb.org/3/movie/'.$mediaid.'/credits?api_key=06704b70c2a5b0d53730316cca8c3e7a';
      curl_setopt($ch, CURLOPT_URL, $url);
      $result = curl_exec($ch);
      curl_close($ch);
      $tmdb_movie_array_creds = json_decode($result,TRUE);
    }

    $cast = '';
    foreach($tmdb_movie_array_creds['cast'] as $ca){
      if($ca !=null){
        $cast = $cast.$ca['character'].','.$ca['name'].','.$ca['profile_path'].',';
      }
    }

    $crew = '';
    foreach($tmdb_movie_array_creds['crew'] as $cr){
      if($cr !=null){
        $crew = $crew.$cr['job'].','.$cr['name'].','.$cr['profile_path'].',';
      }
    }

    $data = array(
        'caststring' => $cast
    );
    $format = array( '%s'); 
    $where = array( 'ID' => $saved_film->ID );
    $where_format = array( '%d' );
    $wpdb->update( $table_name, $data, $where, $format, $where_format );

    $data = array(
        'crewstring' => $crew
    );
    $format = array( '%s'); 
    $where = array( 'ID' => $saved_film->ID );
    $where_format = array( '%d' );
    $wpdb->update( $table_name, $data, $where, $format, $where_format );
  }

  if((($saved_film->caststring == null) || ($saved_film->crewstring == null)) && ($saved_film->type == 'TV Show')){
    // Getting credits
    $res = file_get_contents('https://api.themoviedb.org/3/tv/'.$mediaid.'/credits?api_key=06704b70c2a5b0d53730316cca8c3e7a
');
    $tmdb_movie_array_creds = json_decode($res, true);

    // Make request to tmdb with cUrl if file_get_contents fails
    if($tmdb_movie_array_creds == null){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $url = 'https://api.themoviedb.org/3/tv/'.$mediaid.'/credits?api_key=06704b70c2a5b0d53730316cca8c3e7a';
      curl_setopt($ch, CURLOPT_URL, $url);
      $result = curl_exec($ch);
      curl_close($ch);
      $tmdb_movie_array_creds = json_decode($result,TRUE);
    }
    //var_dump($tmdb_movie_array_creds);

    $caststring = '';
    foreach($tmdb_movie_array_creds['cast'] as $ca){
      if($ca !=null){
        $caststring = $caststring.$ca['character'].','.$ca['name'].','.$ca['profile_path'].',';
      }
    }

    $crewstring = '';
    foreach($tmdb_movie_array_creds['crew'] as $cr){
      if($cr !=null){
        $crewstring = $crewstring.$cr['job'].','.$cr['name'].','.$cr['profile_path'].',';
      }
    }

    $data = array(
        'caststring' => $caststring
    );
    $format = array( '%s'); 
    $where = array( 'ID' => $saved_film->ID );
    $where_format = array( '%d' );
    $wpdb->update( $table_name, $data, $where, $format, $where_format );

    $data = array(
        'crewstring' => $crewstring
    );

    $format = array( '%s'); 
    $where = array( 'ID' => $saved_film->ID );
    $where_format = array( '%d' );
    $wpdb->update( $table_name, $data, $where, $format, $where_format );
  }
  
 // Getting/creating quotes
  $table_name_quotes = $wpdb->prefix . 'wpfilmlist_jre_movie_quotes';
  $quote_results = $wpdb->get_results("SELECT * FROM $table_name_quotes WHERE placement = 'film'");
  $count = ($wpdb->get_var("SELECT COUNT(*) FROM $table_name_quotes WHERE placement = 'film'")-1);
  $quote_num = rand(0,$count);
  $quote_actual = $quote_results[$quote_num]->quote;
  $pos = strpos($quote_actual,'" - ');
  $attribution = substr($quote_actual, $pos);
  $quote = substr($quote_actual, 0, $pos);

  include_once( plugin_dir_path( __FILE__ ) . 'savedfilmactions.php');
  wpfilmlist_jre_savedfilmactions($saved_film, $img_path, $options_results, $quote, $attribution);
  wp_die(); // this is required to terminate immediately and return a proper response
}

// Function to handle certain logic within the edit and add a film forms, such as the animation of the 'year finished' section and the checkboxes
function wpfilmlist_form_checks_javascript(){ ?>
  <script type="text/javascript" >
  // Checks for the Edit Film Form
  jQuery(document).on("change","#wpfilmlist_finished_yes_edit", function(event){
    if (this.checked){
      jQuery(".wpfilmlist_year_finished_text_edit_class").animate({opacity:1});
      jQuery(".wpfilmlist_year_finished_label_edit_class").animate({opacity:1});
      jQuery("#wpfilmlist_year_finished_edit").attr("disabled", false);
      jQuery(".wpfilmlist_year_finished_text_edit_class").attr("disabled", false);
      jQuery("#wpfilmlist_year_finished_edit").attr("value", '<?php echo esc_attr(date("Y")); ?>');
      jQuery("#wpfilmlist_year_finished_edit").animate({opacity:1});
      jQuery('#wpfilmlist_finished_no_edit').prop('checked', false);
    } else {
      jQuery("#wpfilmlist_year_finished_edit").attr("value", '');
      jQuery(".wpfilmlist_year_finished_text_edit_class").attr("disabled", true);
      jQuery(".wpfilmlist_year_finished_text_edit_class").animate({opacity:0.5});
      jQuery(".wpfilmlist_year_finished_label_edit_class").animate({opacity:0.5});
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpfilmlist_finished_no_edit", function(event){
    if (this.checked) {
      jQuery(".wpfilmlist_year_finished_text_edit_class").attr("disabled", true);
      jQuery(".wpfilmlist_year_finished_text_edit_class").attr("value", '');
      jQuery(".wpfilmlist_year_finished_text_edit_class").animate({opacity:0.5});
      jQuery(".wpfilmlist_year_finished_label_edit_class").animate({opacity:0.5});
      jQuery('#wpfilmlist_finished_yes_edit').prop('checked', false);
    }else {
      jQuery("#wpfilmlist_year_finished_edit").animate({opacity:0.5});
      jQuery("#wpfilmlist_year_finished_label_edit").animate({opacity:0.5});
    }
  });
  jQuery(document).on("change","#wpfilmlist_film_signed_yes_edit", function(event){
    if (this.checked) {
      jQuery('#wpfilmlist_film_signed_no_edit').prop('checked', false);
    }else {
      jQuery('#wpfilmlist_film_signed_yes_edit').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpfilmlist_film_signed_no_edit", function(event){
    if (this.checked) {
      jQuery('#wpfilmlist_film_signed_yes_edit').prop('checked', false);
    }else {
      jQuery('#wpfilmlist_film_signed_no_edit').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpfilmlist_film_first_edition_yes_edit", function(event){
    if (this.checked) {
      jQuery('#wpfilmlist_film_first_edition_no_edit').prop('checked', false);
    }else {
      jQuery('#wpfilmlist_film_first_edition_yes_edit').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpfilmlist_film_first_edition_no_edit", function(event){
    if (this.checked) {
      jQuery('#wpfilmlist_film_first_edition_yes_edit').prop('checked', false);
    }else {
      jQuery('#wpfilmlist_film_first_edition_no_edit').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  // Checks for the Add Film Form
  jQuery(document).on("change"," #wpfilmlist_finished_yes", function(event){
    if (this.checked) {
      jQuery(" #wpfilmlist_year_finished").attr("disabled", false);
      jQuery(" #wpfilmlist_year_finished").attr("value", '<?php echo esc_attr(date("Y")); ?>');
      jQuery(" #wpfilmlist_year_finished").animate({opacity:1});
      jQuery(" #wpfilmlist_year_finished_label").animate({opacity:1});
      jQuery(' #wpfilmlist_finished_no').prop('checked', false);
    } else {
      jQuery(" #wpfilmlist_year_finished").attr("disabled", true);
      jQuery(" #wpfilmlist_year_finished").attr("value", '');
      jQuery(" #wpfilmlist_year_finished").animate({opacity:0.5});
      jQuery(" #wpfilmlist_year_finished_label").animate({opacity:0.5});
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpfilmlist_finished_no", function(event){
    if (this.checked) {
      jQuery(" #wpfilmlist_year_finished").animate({opacity:0.5});
      jQuery(" #wpfilmlist_year_finished_label").animate({opacity:0.5});
      jQuery(" #wpfilmlist_year_finished").attr("disabled", true);
      jQuery(" #wpfilmlist_year_finished").attr("value", '');
      jQuery(' #wpfilmlist_finished_yes').prop('checked', false);
    }else {
      jQuery(" #wpfilmlist_year_finished").attr("value", '');
      jQuery(" #wpfilmlist_year_finished").animate({opacity:0.5});
      jQuery(" #wpfilmlist_year_finished_label").animate({opacity:0.5});
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change"," #wpfilmlist_film_signed_yes", function(event){
    if (this.checked) {
      jQuery(' #wpfilmlist_film_signed_no').prop('checked', false);
    }else {
      jQuery(' #wpfilmlist_film_signed_yes').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpfilmlist_film_signed_no", function(event){
    if (this.checked) {
      jQuery(' #wpfilmlist_film_signed_yes').prop('checked', false);
    }else {
      jQuery(' #wpfilmlist_film_signed_no').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpfilmlist_film_first_edition_yes", function(event){
    if (this.checked) {
      jQuery(' #wpfilmlist_film_first_edition_no').prop('checked', false);
    }else {
      jQuery(' #wpfilmlist_film_first_edition_yes').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpfilmlist_film_first_edition_no", function(event){
    if (this.checked) {
      jQuery(' #wpfilmlist_film_first_edition_yes').prop('checked', false);
    }else {
      jQuery(' #wpfilmlist_film_first_edition_no').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  </script>
  <?php
}

// Controls the fade-in and movement of the images and link elements upon page load
function wpfilmlist_homepage_pretties(){?>
  <script type="text/javascript" >
  jQuery(document).ready(function() {
    setTimeout(function(){
      jQuery(".wpfilmlist_cover_image_class").animate({opacity:1})
    }, 1000);
    setTimeout(function(){
      jQuery(".wpfilmlist_saved_title_link").animate({opacity:1})
    }, 1600);
    setTimeout(function(){
      jQuery(".wpfilmlist_edit_entry_link").animate({opacity:1})
    }, 1600);
    setTimeout(function(){
      jQuery(".wpfilmlist_delete_entry_link").animate({opacity:1})
    }, 1600);
    setTimeout(function(){
      jQuery(".wpfilmlist-rating-image").animate({opacity:1})
    }, 1600);
  });
  </script>
  <?php
}   

// Handles the way things are displayed based on the sort selection the user makes
function wpfilmlist_jre_sort_selection_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).ready(function() {
    jQuery('#wpfilmlist_sort_select_box').change(function() {
      if(window.location.href.indexOf("?update") != -1){
        var currentUrl = window.location.href.substring(0, window.location.href.indexOf("?update"));
        window.location = currentUrl+"?update=control&update_id=" + encodeURIComponent(jQuery(this).val());
      }else {
        window.location = window.location.href+"?update=control&update_id=" + encodeURIComponent(jQuery(this).val());
      }
    });
    jQuery(document).on("change","#wpfilmlist_sort_select_box", function(event){
      var sortSubmitUrl = window.location.href;
      var e = document.getElementById("wpfilmlist_sort_select_box");
      var sortSelection = e.options[e.selectedIndex].text;
      // The ajax call that reloads the current page with the sort selection applied
      jQuery.ajax({
        type    : "POST",
        url     : sortSubmitUrl,
        data    : 'sortSelection='+sortSelection,
        success : function(data) {
        }
      });
      event.preventDefault ? event.preventDefault() : event.returnValue = false;
    });
  });
  </script>
  <?php
}

// Handles the search functionality. If neither author nor title slection is checked, the search will execute for both title and author.
function wpfilmlist_jre_search_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).ready(function() {
    jQuery('#wpfilmlist_search_sub_button').click(function() {
      var str = jQuery('#wpfilmlist_search_text').val();
      str = str.replace(/[^a-z0-9áéíóúñü \.,_-]/gim,"");
      str.trim();
      var str2 = document.getElementById("wpfilmlist_film_title_search").checked;
      var str3 = document.getElementById("wpfilmlist_author_search").checked;
      if(window.location.href.indexOf("?update") != -1){
        var currentUrl = window.location.href.substring(0, window.location.href.indexOf("?update"));
        window.location = currentUrl+"?update=wpfilmlist_search_sub_button&search_query=" + str +"&title_query=" + str2 +"&author_query=" +str3;
      }else {
        window.location = window.location.href+"?update=wpfilmlist_search_sub_button&search_query=" + str +"&title_query=" + str2 +"&author_query=" +str3;
      }
    });
    jQuery('#wpfilmlist_search_text').one('click', function() {
      jQuery(this).val("");
    });
  });
  </script>
  <?php
}

// This function controls the functionality of the page links at the bottom of the page
function wpfilmlist_jre_page_control_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).ready(function() {
    jQuery('.wpfilmlist_page_control_link_class').click(function() {
      var table = "&wpfilmlist-session="+"<?php echo esc_html($GLOBALS['a']); ?>";
      var currentUrl = window.location.href;
      if(currentUrl.indexOf("update_id") != -1){
        var startPos = (currentUrl.search("update_id"))+10;
        var sortId = currentUrl.slice(startPos);
        var currentStrippedUrl = currentUrl.substring(0, window.location.href.indexOf("?update"));
        var pagenum = parseInt(jQuery(this).html())-1;
        if(currentUrl.indexOf("search_query") != -1){ 
          var searchTerm = currentUrl.substring(window.location.href.indexOf("search_query"));
          window.location = currentStrippedUrl+"?update=control&sort_id=" + sortId +"&page_control=" + pagenum +"&update_id="+sortId+table + '&' + searchTerm;
        } else {
          window.location = currentStrippedUrl+"?update=control&sort_id=" + sortId +"&page_control=" + pagenum +"&update_id="+sortId+table;
        }
      } else {
        var currentStrippedUrl = currentUrl.substring(0, window.location.href.indexOf("?update"));
        if(currentUrl.indexOf("search_query") != -1){ 
          var searchTerm = currentUrl.substring(window.location.href.indexOf("search_query"));
          var pagenum = parseInt(jQuery(this).html())-1; 
          window.location = currentStrippedUrl+"?update=control&page_control=" + pagenum + '&' + searchTerm;
        } else {
          var pagenum = parseInt(jQuery(this).html())-1; 
          window.location = currentStrippedUrl+"?update=control&page_control=" + pagenum;
        }
      }
    });
  });
  </script>
  <?php
}

function wpfilmlist_jre_display_options_javascript(){
  ?>
  <script>
  jQuery(document).ready(function() {
    jQuery('#wpfilmlist-film-control').change(function(){
      var value = jQuery('#wpfilmlist-film-control').val();
      if((value == null) || (value == 0)){
        jQuery('#wpfilmlist-save-backend').attr("disabled", "true");
      } else {
        jQuery('#wpfilmlist-save-backend').removeAttr("disabled");
      }
    });
  });
  </script>
  <?php
}

function wpfilmlist_jre_admin_clear_javascript(){
  ?>
  <script>
  jQuery(document).ready(function() {
    jQuery(".wpfilmlist-dynamic-input, .wpfilmlist-amazon-affiliate-input, #wpfilmlist-edit-notes-bulk-textarea").one("click", function(){
      jQuery(this).val("")
      jQuery(this).css({'color' : 'black'})
    });
    jQuery("#wpfilmlist-feedback").one("click", function(){
      jQuery(this).val("")
    });
  });
  </script>
  <?php
}

function wpfilmlist_delete_entry_action_javascript(){
  ?>
  <script>
  jQuery(document).ready(function() {
    jQuery('body').on('click', '#wpfilmlist_delete_film_submit_button', function () {
      var id = jQuery(this).attr("data-deleteid");
      var table = "<?php echo esc_html($GLOBALS['a']); ?>";

      var data = {
        'action': 'wpfilmlist_delete_entry_action',
        'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-delete" ); ?>',
        'delete_id': id,
        'table':table
      }; 

      jQuery.post(ajaxurl, data, function(response) {
        document.location.reload(true);
      });
 
    });
  });
  </script>
  <?php
}



function wpfilmlist_delete_entry_action_callback() {
  global $wpdb;
  check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-delete', 'security' );
  // Grabbing the ID of the film for deletion that is hidden in a span element. This ID was sent from wpfilmlist.php.
  $id = intval(addslashes(($_POST['delete_id'])));
  $table_name = sanitize_text_field($_POST['table']);
  // Deleting row
  $wpdb->delete( $table_name, array( 'ID' => $id ) );
  // Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name MODIFY ID BIGINT(255) NOT NULL", $table_name));
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name DROP PRIMARY KEY", $table_name));
  // Adjusting ID values of remaining entries in database
  $my_query = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name", $table_name ));
  $title_count = $wpdb->num_rows;    
  // Adding primary key back to database 
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name ADD PRIMARY KEY (`ID`)", $table_name));    
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name MODIFY ID BIGINT(255) AUTO_INCREMENT", $table_name));
  // Setting the AUTO_INCREMENT value based on number of remaining entries
  $title_count++;
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name AUTO_INCREMENT=$title_count", $table_name));
  wp_die(); // this is required to terminate immediately and return a proper response
}



function wpfilmlist_display_options_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery('#wpfilmlist-save-backend').click(function(){
    var opt1 = jQuery('[name=hide-add-a-film]').prop('checked');
    var opt2 = jQuery('[name= hide-search]').prop('checked');
    var opt3 = jQuery('[name=hide-stats-area]').prop('checked');
    var opt4 = jQuery('[name=hide-edit-delete]').prop('checked');
    var opt5 = jQuery('[name=hide-sort-by]').prop('checked');
    var opt6 = jQuery('[name=hide-backup-download]').prop('checked');
    var opt7 = jQuery('[name=hide-facebook]').prop('checked');
    var opt8 = jQuery('[name=hide-messenger]').prop('checked');
    var opt9 = jQuery('[name=hide-twitter]').prop('checked');
    var opt10 = jQuery('[name=hide-googleplus]').prop('checked');
    var opt11 = jQuery('[name=hide-pinterest]').prop('checked');
    var opt12 = jQuery('[name=hide-email]').prop('checked');
    var opt13 = jQuery('[name=hide-review-film]').prop('checked');
    var opt14 = jQuery('[name=hide-description]').prop('checked');
    var opt15 = jQuery('[name=hide-review]').prop('checked');
    var opt16 = jQuery('[name=hide-notes]').prop('checked');
    var opt17 = jQuery('[name=hide-quote]').prop('checked');
    var opt18 = jQuery('[name=hide-quote-film]').prop('checked');
    var opt19 = jQuery('[name=hide-links]').prop('checked');
    var opt20 = jQuery('[name=hide-cast]').prop('checked');
    var opt21 = jQuery('[name=hide-crew]').prop('checked');
    var opt22 = jQuery('[name=hide-videos]').prop('checked');
    var opt23 = jQuery('[name=hide-images]').prop('checked');
    var opt24 = jQuery('[name=hide-top-purchase]').prop('checked');
    var opt25 = jQuery('[name=hide-bottom-purchase]').prop('checked');
    var opt26 = jQuery('[name=hide-tagline]').prop('checked');
    var sel = document.getElementById('wpfilmlist-jre-sorting-select');
    var opt27 = sel.value;
    var opt28 = jQuery('[name=films-per-page]').val();

    // Avoiding the 'division by zero' error
    if(opt28 < 1){
      opt28 = 1;
    }

    var optsArray = [
      opt1,opt2,opt3,opt4,opt5,opt6,opt7,opt8,opt9,opt10,opt11,opt12,opt13,opt14,opt15,opt16,opt17,opt18,opt19,opt20,opt21,opt22,opt23,opt24,opt25,opt26,opt27,opt28
    ];

    var data = {
      'action': 'wpfilmlist_display_options_action',
      'optsArray': optsArray,
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-displayops" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
  });
  </script> <?php
}


function wpfilmlist_display_options_action_callback() {
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-displayops', 'security' );
  $table_name = $wpdb->prefix . 'wpfilmlist_jre_user_options';
  function wpfilmlist_arrayMod($v){
    if($v == "false"){
      return NULL;
    } else{
      return $v;
    }
  }
  $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $opts_array = $_POST['optsArray'];
  $opts_array = array_map('wpfilmlist_arrayMod', $opts_array);

  $hide_add =  $opts_array[0];
  $hide_search = $opts_array[1];
  $hide_stats = $opts_array[2];
  $hide_edit_delete = $opts_array[3];
  $hide_sort_by = $opts_array[4];
  $hide_backup_download = $opts_array[5];
  $hide_facebook = $opts_array[6];
  $hide_messenger = $opts_array[7];
  $hide_twitter = $opts_array[8];
  $hide_googleplus = $opts_array[9];
  $hide_pinterest = $opts_array[10];
  $hide_email = $opts_array[11];
  $hide_review_film = $opts_array[12];
  $hide_description = $opts_array[13];
  $hide_review = $opts_array[14];
  $hide_notes = $opts_array[15];
  $hide_quote = $opts_array[16];
  $hide_quote_film = $opts_array[17];
  $hide_links = $opts_array[18];
  $hide_cast = $opts_array[19];
  $hide_crew = $opts_array[20];
  $hide_videos = $opts_array[21];
  $hide_images = $opts_array[22];
  $hide_top_purchase = $opts_array[23];
  $hide_bottom_purchase = $opts_array[24];
  $hide_tagline = $opts_array[25];
  $sortoption = $opts_array[26];
  $films_per_page = $opts_array[27];

  $hide_review_film = 1;
  $hide_review = 1;
  $hide_quote  = 1;

   $data = array(
          'hideaddfilm' => $hide_add,
          'hidesearch' => $hide_search,
          'hidestats' => $hide_stats,
          'hideeditdelete' => $hide_edit_delete,
          'hidesortby' => $hide_sort_by,
          'hidebackupdownload' => $hide_backup_download,
          'hidefacebook' => $hide_facebook,
          'hidemessenger' => $hide_messenger,
          'hidetwitter' => $hide_twitter,
          'hidegoogleplus' => $hide_googleplus,
          'hidepinterest' => $hide_pinterest,
          'hideemail' => $hide_email,
          'hidedescription' => $hide_description,
          'hidenotes' => $hide_notes,
          'hidequote' => $hide_quote,
          'hidequotefilm' => $hide_quote_film,
          'filmsonpage' => $films_per_page,
          'hidelinks' => $hide_links,
          'hidecast' => $hide_cast,
          'hidecrew' => $hide_crew,
          'hidereview' => $hide_review,
          'hidereviewfilm' => $hide_review_film,
          'hidevideos' => $hide_videos,
          'hideimages' => $hide_images,
          'hidetoppurchase' => $hide_top_purchase,
          'hidebottompurchase' => $hide_bottom_purchase,
          'hidetagline' => $hide_tagline,
          'sortoption' => $sortoption
    );
  $format = array( '%d', '%d', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s');   
  $where = array( 'ID' => 1 );
  $where_format = array( '%d' );
  $wpdb->update( $table_name, $data, $where, $format, $where_format );

  wp_die(); // this is required to terminate immediately and return a proper response
}

function wpfilmlist_film_edit_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery('.wpfilmlist_edit_entry_link').click(function(){
    var title = jQuery(this).find("span");
    var currentTable = '<?php echo esc_html($GLOBALS["a"]); ?>';
    title = title.html();

    // If theme adds in extra html for whatever reason
    if((title.includes('<')) || (title.includes('>'))){
      title = jQuery(title).text();
    }

    var data = {
      'action': 'wpfilmlist_film_edit_action',
      'title': title,
      'table': currentTable,
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-edit" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      jQuery.colorbox({
        open: true,
        scrolling: true,
        width:'50%',
        height:'80%',
        html: response,
        data: data,
        onClosed:function(){
            jQuery('.cboxContentForWpFilmList').css({'opacity':'0'});
        },
        onComplete:function(){
          jQuery("#cboxLoadedContent").addClass("cboxLoadedContentForWpFilmList");
          jQuery("#cboxContent").addClass("cboxContentForWpFilmList");
          currentHeight = jQuery('.cboxLoadedContentForWpFilmList').css('height');
          currentHeight = (parseInt(currentHeight, 10) + 5);
          jQuery('.cboxLoadedContentForWpFilmList').css({'min-height':currentHeight+'px','margin':'0px'});
          jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
        }
        });
    });
  });
  </script> <?php
}

function wpfilmlist_film_edit_action_callback() {
  global $wpdb; // this is how you get access to the database
  include_once( plugin_dir_path( __FILE__ ) . 'editentry.php');

  $id = intval($_POST['title']);
  $table = sanitize_text_field($_POST['table']);
  $saved_film = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE ID = $id", $table));
  //$saved_film = json_encode($saved_film);

  //echo $saved_film;
  wpfilmlist_jre_editentry($saved_film);
  wp_die(); // this is required to terminate immediately and return a proper response
}


 

function wpfilmlist_save_film_edit_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).on("click","#wpfilmlist_edit_film_submit_button", function(event){
    var opt1 = jQuery('#wpfilmlist_film_title_edit').val();
    var opt2 = jQuery('#wpfilmlist_language_edit').val();
    var opt3 = jQuery('#wpfilmlist_episoderuntime_edit').val();
    var opt4 = jQuery('#wpfilmlist_runtime_edit').val();
    var opt5 = jQuery('#wpfilmlist_creators_edit').val();
    var opt6 = jQuery('#wpfilmlist_networks_edit').val();
    var opt7 = jQuery('#wpfilmlist_numofseasons_edit').val();
    var opt8 = jQuery('#wpfilmlist_numofepisodes_edit').val();
    var opt9 = jQuery('#wpfilmlist_productioncompany_edit').val();
    var opt10 = jQuery('#wpfilmlist_productioncountry_edit').val();
    var opt11 = jQuery('#wpfilmlist_releasefirstairdate_edit').val();
    var opt12 = jQuery('#wpfilmlist_budget_edit').val();
    var opt13 = jQuery('#wpfilmlist_revenue_edit').val();
    var opt14 = jQuery('#wpfilmlist_status_edit').val();
    var opt15 = jQuery('#wpfilmlist_desc_edit').val();
    var opt16 = jQuery('#wpfilmlist_notes_edit').val();
    var opt17 = jQuery('[name=hidden_id_input]').val();
    var opt18 = jQuery('#wpfilmlist_genres_edit').val();
    var opt19 = jQuery('#wpfilmlist-ratings-select-edit').val();
    var table = '<?php echo esc_html($GLOBALS["a"]); ?>';

    var optsArray = [
      opt1,opt2,opt3,opt4,opt5,opt6,opt7,opt8,opt9,opt10,opt11,opt12,opt13,opt14,opt15,opt16,opt17,opt18,opt19,table
    ];
    var data = {
      'action': 'wpfilmlist_save_film_edit_action',
      'optsArray': optsArray,
      'table':table,
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-saveedit" ); ?>'
    };
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  </script> <?php
}


function wpfilmlist_save_film_edit_action_callback() {
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-saveedit', 'security' );
  $table_name = sanitize_text_field($_POST['table']);

    function wpfilmlist_arrayMod($v){
    if($v == "false"){
      return 'NULL';
    } else if($v == 'true'){
      return 'yes';
    } else {
      return $v;
    }
  }

  $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $optsArray = $_POST['optsArray'];
  $optsArray = array_map('wpfilmlist_arrayMod', $optsArray);

  // Handling the input from the 'edit film' form 
  $title = htmlspecialchars($optsArray[0], ENT_QUOTES);
  $language = htmlspecialchars(addslashes($optsArray[1]));
  $episoderuntime = htmlspecialchars(addslashes($optsArray[2]));
  $runtime = htmlspecialchars(addslashes($optsArray[3]));
  $creators = htmlspecialchars(addslashes($optsArray[4]));
  $networks = htmlspecialchars(addslashes($optsArray[5]));
  $numofseasons = htmlspecialchars(addslashes($optsArray[6]));
  $numofepisodes = htmlspecialchars(addslashes($optsArray[7]));
  $productioncompany = htmlspecialchars(addslashes($optsArray[8]));
  $productioncountry = htmlspecialchars(addslashes($optsArray[9]));
  $releasefirstairdate = htmlspecialchars(addslashes($optsArray[10]));
  $budget = htmlspecialchars(addslashes($optsArray[11]));
  $revenue = htmlspecialchars($optsArray[12]);
  $status = htmlspecialchars($optsArray[13]);
  $desc = htmlspecialchars($optsArray[14]);
  $notes = htmlspecialchars(addslashes($optsArray[15]));
  $key_id = htmlspecialchars(addslashes($optsArray[16]));
  $genres = htmlspecialchars(addslashes($optsArray[17]));
  $myfilmrating = htmlspecialchars(addslashes($optsArray[18]));

  $revenue = str_replace(',', '', $revenue);
  $revenue = str_replace('$', '', $revenue);
  $revenue = str_replace('.', '', $revenue);
  $budget = str_replace(',', '', $budget);
  $budget = str_replace('$', '', $budget);
  $budget = str_replace('.', '', $budget);


  $data = array(
      'title' => $title,
      'language' => $language,
      'episoderuntime' => $episoderuntime,
      'runtime' => $runtime,
      'creators' => $creators,
      'networks' => $networks,
      'numofseasons' => $numofseasons,
      'numofepisodes' => $numofepisodes,
      'productioncompany' => $productioncompany,
      'productioncountry' => $productioncountry,
      'releasefirstairdate' => $releasefirstairdate,
      'budget' => $budget,
      'revenue' => $revenue,
      'status' => $status,
      'overview' => $desc,
      'notes' => $notes,
      'genres' => $genres,
      'myfilmrating' => $myfilmrating,
  );

var_dump($data);

  $format = array( '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s','%s');
  
  $where = array( 'ID' => $key_id );
  $where_format = array( '%d' );
  $wpdb->update( $table_name, $data, $where, $format, $where_format );
 
  wp_die(); // this is required to terminate immediately and return a proper response

}


function wpfilmlist_new_lib_shortcode_action_javascript() { ?>
 <script type="text/javascript" >
  jQuery(".wpfilmlist-dynamic-input").bind('input', function() { 
        currentVal = jQuery(".wpfilmlist-dynamic-input").val();
        if((currentVal.length > 0) && (currentVal != 'Create a New Library Here...')){
          jQuery("#wpfilmlist-dynamic-shortcode-button").attr('disabled', false);
        }
    });
  jQuery(document).on("click","#wpfilmlist-dynamic-shortcode-button", function(event){
    var currentVal;
    currentVal = (jQuery("#wpfilmlist-dynamic-input-library").val()).toLowerCase();
    console.log(currentVal);
    var data = {
      'action': 'wpfilmlist_new_lib_shortcode_action',
      'currentval': currentVal,
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-newlib" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
  });

  jQuery(document).on("click",".wpfilmlist_delete_custom_lib", function(event){
    var table = jQuery(this).attr('id');
    console.log(table);
    var data = {
      'action': 'wpfilmlist_new_lib_shortcode_action',
      'table': table,
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-newlib" ); ?>'
    };
    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
  });
  </script> <?php
}


function wpfilmlist_new_lib_shortcode_action_callback() {
  // Grabbing the existing options from DB
  global $wpdb;
  check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-newlib', 'security' );
  $table_name_dynamic = $wpdb->prefix . 'wpfilmlist_jre_list_dynamic_db_names';
  $db_name;

  function wpfilmlist_clean($string) {
      $string = str_replace(' ', '_', $string); // Replaces all spaces with underscores.
      $string = str_replace('-', '_', $string);
      return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }
 
  // Create a new custom table
  if(isset($_POST['currentval'])){
      $db_name = sanitize_text_field($_POST['currentval']);
      error_log('table:'.$db_name);

      $db_name = wpfilmlist_clean($db_name);
  }

  // Delete the table
  if(isset($_POST['table'])){ 
      $table = $wpdb->prefix."wpfilmlist_jre_".sanitize_text_field($_POST['table']);
      $pos = strripos($table,"_");
      $table = substr($table, 0, $pos);
      echo $table;
      $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table", $table));

      $delete_from_list = sanitize_text_field($_POST['table']);
      $pos2 = strripos($delete_from_list,"_");
      $delete_id = substr($delete_from_list, ($pos2+1));
      $wpdb->delete( $table_name_dynamic, array( 'ID' => $delete_id ), array( '%d' ) );
         
      // Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
      $table_name_dynamic = str_replace('\'', '`', $table_name_dynamic);
      $wpdb->query($wpdb->prepare("ALTER TABLE %s MODIFY ID bigint(255) NOT NULL" , $table_name_dynamic));

      $query2 = $wpdb->prepare( "ALTER TABLE %s DROP PRIMARY KEY", $table_name_dynamic);
      $query2 = str_replace('\'', '`', $query2);
      $wpdb->query($wpdb->prepare($query2));

      // Adjusting ID values of remaining entries in database
      $my_query = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name_dynamic", $table_name_dynamic ));
      $title_count = $wpdb->num_rows;

      for ($x = $delete_id ; $x <= $title_count; $x++) {
        $data = array(
            'ID' => $delete_id 
        );
        $format = array( '%s'); 
        $delete_id ++;  
        $where = array( 'ID' => ($delete_id ) );
        $where_format = array( '%d' );
        $wpdb->update( $table_name_dynamic, $data, $where, $format, $where_format );
      }  
        
      // Adding primary key back to database 
      $query3 = $wpdb->prepare( "ALTER TABLE %s ADD PRIMARY KEY (`ID`)", $table_name_dynamic);
      $query3 = str_replace('\'', '`', $query3);
      $wpdb->query($wpdb->prepare($query3));    

      $query4 = $wpdb->prepare( "ALTER TABLE %s MODIFY ID bigint(255) AUTO_INCREMENT", $table_name_dynamic);
      $query4 = str_replace('\'', '`', $query4);
      $wpdb->query($wpdb->prepare($query4));

      // Setting the AUTO_INCREMENT value based on number of remaining entries
      $title_count++;
      $query5 = $wpdb->prepare( "ALTER TABLE %s AUTO_INCREMENT=%d", $table_name_dynamic,$title_count);
      $query5 = str_replace('\'', '`', $query5);
      $wpdb->query($wpdb->prepare($query5));
      
  }

  if(isset($db_name)){
      if(($db_name != "")  ||  ($db_name != null)){
          $wpdb->wpfilmlist_jre_dynamic_db_name = "{$wpdb->prefix}wpfilmlist_jre_{$db_name}";
          $wpdb->wpfilmlist_jre_list_dynamic_db_names = "{$wpdb->prefix}wpfilmlist_jre_list_dynamic_db_names";
         

          $sql_create_table = "CREATE TABLE {$wpdb->wpfilmlist_jre_dynamic_db_name} 
          (
            ID bigint(255) auto_increment,
            title varchar(255),
            mediaid bigint(255),
            creators varchar(255),
            releasefirstairdate varchar(255),
            coverurl varchar(255),
            imdbid varchar(255),
            overview MEDIUMTEXT,
            revenue bigint(255),
            runtime varchar(255),
            tagline varchar(255),
            networks varchar(255),
            video varchar(255),
            budget bigint(255),
            backdropurl varchar(255),
            homepageurl varchar(255),
            language varchar(255),
            productioncountry varchar(255),
            productioncompany varchar(255),
            genres varchar(255),
            originaltitle varchar(255),
            popularity bigint(255),
            belongstocollection varchar(255),
            seasons MEDIUMTEXT,
            numofseasons bigint(255),
            numofepisodes bigint(255),
            episoderuntime varchar(255),
            videostring MEDIUMTEXT,
            inproduction varchar(255),
            notes varchar(255),
            watched varchar(255),
            status varchar(255),
            caststring MEDIUMTEXT,
            crewstring MEDIUMTEXT,
            type varchar(255),
            myfilmrating bigint(255),
            uberepisodestring MEDIUMTEXT,
            reviewstars bigint(255),
              PRIMARY KEY  (ID),
                KEY title (title)
          ) $charset_collate; ";
          dbDelta( $sql_create_table );
          $wpdb->insert( $table_name_dynamic, array('user_table_name' => $db_name ));
      }
  }
      
  wp_die(); // this is required to terminate immediately and return a proper response
}


function wpfilmlist_jre_create_excel_action_javascript() { ?>
  <script type="text/javascript" >

  jQuery(document).on("change","#wpfilmlist-table-select-backup-dropdown", function(event){
    jQuery('#wpfilmlist-backup-download-link').css({'pointer-events':'all'});
    jQuery('#wpfilmlist-backup-download-link').addClass('wpfilmlist-backup-download-link-for-hover');
  });

  jQuery(document).on("click","#wpfilmlist-backup-download-link", function(event){
    var table = jQuery('#wpfilmlist-table-select-backup-dropdown').val();
    var link = jQuery(this).attr("href");
    var data = {
      'action': 'wpfilmlist_jre_create_excel_action',
      'table':table,
      'link':link,
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-spreadtwo" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      console.log(response);
      var backupFilename = response;
      backupFilename = backupFilename.replace(" ", '_');
      window.location.replace('<?php $upload_path = wp_upload_dir(); $upload_path = $upload_path["baseurl"]; echo esc_url($upload_path); ?>'+'/wpfilmlist/backups/'+backupFilename);
          
      setTimeout(function(){
        document.location.reload(true)
      }, 3000);

      
    });
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });

  </script> <?php
}

function wpfilmlist_jre_create_excel_action_callback() {
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-spreadtwo', 'security' );
  $table_name = filter_var($_POST['table'], FILTER_SANITIZE_STRING);
  $count = $wpdb->query($wpdb->prepare("SELECT * FROM $table_name", $table_name));
  if($table_name == $wpdb->prefix."wpfilmlist_jre_saved_film_log"){
    $tabletext = 'Default';
  } else{
    $tabletext = ucfirst(substr($table_name, strrpos($table_name, '_') + 1));
  }
  

  // Getting all entries from the database
  $my_query = $wpdb->get_results( "SELECT * FROM $table_name");
  $upload_path = wp_upload_dir();
  $upload_path = $upload_path['baseurl'];
  //$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
  if (!file_exists($upload_path.'/wpfilmlist/backups')) {
      mkdir($upload_path.'/wpfilmlist/backups', 0777, true);
  }
  // Including PHPExcel Library files
  include_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
  include_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
  require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

  PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

  // Create new PHPExcel object
  $objPHPExcel = new PHPExcel();

  // Set properties
  $objPHPExcel->getProperties()->setCreator("WordPress Film List");
  $objPHPExcel->getProperties()->setLastModifiedBy("Jake Evans");
  $objPHPExcel->getProperties()->setTitle("WordPress Film List Library Export");
  $objPHPExcel->getProperties()->setSubject("WordPress Film List Library Export");
  $objPHPExcel->getProperties()->setDescription("A WordPress Film List Library Export");

  // Add default data (column Headings)
  $objPHPExcel->setActiveSheetIndex(0);
  $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'ID');
  $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Film Title');
  $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Media Id');
  $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Creators');
  $objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Release Date/First Air Date');
  $objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Cover URL');
  $objPHPExcel->getActiveSheet()->SetCellValue('G2', 'IMDB ID');
  $objPHPExcel->getActiveSheet()->SetCellValue('H2', 'Description');
  $objPHPExcel->getActiveSheet()->SetCellValue('I2', 'Revenue');
  $objPHPExcel->getActiveSheet()->SetCellValue('J2', 'Runtime');
  $objPHPExcel->getActiveSheet()->SetCellValue('K2', 'Tagline');
  $objPHPExcel->getActiveSheet()->SetCellValue('L2', 'Networks');
  $objPHPExcel->getActiveSheet()->SetCellValue('M2', 'Video');
  $objPHPExcel->getActiveSheet()->SetCellValue('N2', 'Budget');
  $objPHPExcel->getActiveSheet()->SetCellValue('O2', 'Backdrop URL');
  $objPHPExcel->getActiveSheet()->SetCellValue('P2', 'Homepage URL');
  $objPHPExcel->getActiveSheet()->SetCellValue('Q2', 'Language');
  $objPHPExcel->getActiveSheet()->SetCellValue('R2', 'Production Country');
  $objPHPExcel->getActiveSheet()->SetCellValue('S2', 'Production Company');
  $objPHPExcel->getActiveSheet()->SetCellValue('T2', 'Genres');
  $objPHPExcel->getActiveSheet()->SetCellValue('U2', 'Original Title');
  $objPHPExcel->getActiveSheet()->SetCellValue('V2', 'Popularity');
  $objPHPExcel->getActiveSheet()->SetCellValue('W2', 'Belongs to Collection');
  $objPHPExcel->getActiveSheet()->SetCellValue('X2', 'Seasons');
  $objPHPExcel->getActiveSheet()->SetCellValue('Y2', 'Number of Seasons');
  $objPHPExcel->getActiveSheet()->SetCellValue('Z2', 'Number of Episodes');
  $objPHPExcel->getActiveSheet()->SetCellValue('AA2', 'Episode Runtime');

  $objPHPExcel->getActiveSheet()->SetCellValue('AB2', 'Video String');
  $objPHPExcel->getActiveSheet()->SetCellValue('AC2', 'In Production');
  $objPHPExcel->getActiveSheet()->SetCellValue('AD2', 'Notes');
  $objPHPExcel->getActiveSheet()->SetCellValue('AE2', 'Watched');
  $objPHPExcel->getActiveSheet()->SetCellValue('AF2', 'Status');
  $objPHPExcel->getActiveSheet()->SetCellValue('AG2', 'Cast String');
  $objPHPExcel->getActiveSheet()->SetCellValue('AH2', 'Crew String');
  $objPHPExcel->getActiveSheet()->SetCellValue('AI2', 'Type');
  $objPHPExcel->getActiveSheet()->SetCellValue('AJ2', 'My Rating');



  // For loop that sets each cell value to it's appropriate value from the database
  for($i = 0; $i < $count; $i++){
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.($i+3), $my_query[$i]->ID );
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.($i+3), $my_query[$i]->title );
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.($i+3), $my_query[$i]->mediaid );
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.($i+3), $my_query[$i]->creators );
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.($i+3), $my_query[$i]->releasefirstairdate );
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.($i+3), $my_query[$i]->coverurl );
      $objPHPExcel->getActiveSheet()->SetCellValue('G'.($i+3), $my_query[$i]->imdbid );
      $objPHPExcel->getActiveSheet()->SetCellValue('H'.($i+3), $my_query[$i]->overview );
      $objPHPExcel->getActiveSheet()->SetCellValue('I'.($i+3), $my_query[$i]->revenue );
      $objPHPExcel->getActiveSheet()->SetCellValue('J'.($i+3), $my_query[$i]->runtime );
      $objPHPExcel->getActiveSheet()->SetCellValue('K'.($i+3), $my_query[$i]->tagline );
      $objPHPExcel->getActiveSheet()->SetCellValue('L'.($i+3), $my_query[$i]->networks );
      $objPHPExcel->getActiveSheet()->SetCellValue('M'.($i+3), $my_query[$i]->video );
      $objPHPExcel->getActiveSheet()->SetCellValue('N'.($i+3), $my_query[$i]->budget );
      $objPHPExcel->getActiveSheet()->SetCellValue('O'.($i+3), $my_query[$i]->backdropurl );
      $objPHPExcel->getActiveSheet()->SetCellValue('P'.($i+3), $my_query[$i]->homepageurl );
      $objPHPExcel->getActiveSheet()->SetCellValue('Q'.($i+3), $my_query[$i]->language );
      $objPHPExcel->getActiveSheet()->SetCellValue('R'.($i+3), $my_query[$i]->productioncountry );
      $objPHPExcel->getActiveSheet()->SetCellValue('S'.($i+3), $my_query[$i]->productioncompany);
      $objPHPExcel->getActiveSheet()->SetCellValue('T'.($i+3), $my_query[$i]->genres );   
      $objPHPExcel->getActiveSheet()->SetCellValue('U'.($i+3), $my_query[$i]->originaltitle );
      $objPHPExcel->getActiveSheet()->SetCellValue('V'.($i+3), $my_query[$i]->popularity);
      $objPHPExcel->getActiveSheet()->SetCellValue('W'.($i+3), $my_query[$i]->belongstocollection);

      $objPHPExcel->getActiveSheet()->SetCellValue('X'.($i+3), $my_query[$i]->seasons );
      $objPHPExcel->getActiveSheet()->SetCellValue('Y'.($i+3), $my_query[$i]->numofseasons );
      $objPHPExcel->getActiveSheet()->SetCellValue('Z'.($i+3), $my_query[$i]->numofepisodes );
      $objPHPExcel->getActiveSheet()->SetCellValue('AA'.($i+3), $my_query[$i]->episoderuntime );
      $objPHPExcel->getActiveSheet()->SetCellValue('AB'.($i+3), $my_query[$i]->videostring );
      $objPHPExcel->getActiveSheet()->SetCellValue('AC'.($i+3), $my_query[$i]->inproduction);
      $objPHPExcel->getActiveSheet()->SetCellValue('AD'.($i+3), $my_query[$i]->notes );   
      $objPHPExcel->getActiveSheet()->SetCellValue('AE'.($i+3), $my_query[$i]->watched );
      $objPHPExcel->getActiveSheet()->SetCellValue('AF'.($i+3), $my_query[$i]->status);
      $objPHPExcel->getActiveSheet()->SetCellValue('AG'.($i+3), $my_query[$i]->caststring);

      $objPHPExcel->getActiveSheet()->SetCellValue('AH'.($i+3), $my_query[$i]->crewstring);
      $objPHPExcel->getActiveSheet()->SetCellValue('AI'.($i+3), $my_query[$i]->type );   
      $objPHPExcel->getActiveSheet()->SetCellValue('AJ'.($i+3), $my_query[$i]->myfilmrating );
  }

  // Worksheet Stylings array
  $styleArray1 = array(
      'font'  => array(
          'bold'  => true,
          'color' => array('rgb' => '349ed6'),
          'size'  => 18,
          'name'  => 'Verdana'
      ));

  // Applying that style array
  $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);

  // More cell formatting/styling
  $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
  $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'WordPress Film List');

  $styleArray2 = array(
      'font'  => array(
          'bold'  => true,
          'color' => array('rgb' => '000000'),
          'size'  => 12,
          'name'  => 'Verdana'
      ));

  // Formatting/styling the column headings
  foreach(range('a','z') as $letter) 
  { 
     $objPHPExcel->getActiveSheet()->getStyle($letter.'2')->applyFromArray($styleArray2);
     $objPHPExcel->getActiveSheet()->getStyle($letter.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
     $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
  }  

  $objPHPExcel->getActiveSheet()->getStyle('D2:D256')->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet()->getStyle('D2:N256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  // Renaming, saving, writing out and actually creating the Excel document
  // Rename sheet
  $objPHPExcel->getActiveSheet()->setTitle('WordPress Film List');
      
  // Save Excel 2007 file
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

  // GEtting total number of currently stored backups
  $file_count = 1;
  $upload_path = wp_upload_dir();
  $upload_path = $upload_path['basedir'];
  foreach(glob($upload_path.'/wpfilmlist/backups/*.*') as $filename){
      $file_count++;
  }

  if($file_count == 11){

      
      $file_to_create = glob( $upload_path.'/wpfilmlist/backups/*.*' );
      array_multisort(array_map( 'filemtime', $file_to_create ),SORT_NUMERIC,SORT_DESC,$file_to_create);
      $file_count = $file_to_create[0];

      $file_count = substr($file_count, (strrpos($file_count, '_')+1), (strrpos($file_count, '.')) );
      

      
      $file_to_delete = glob( $upload_path.'/wpfilmlist/backups/*.*' );
      array_multisort(array_map( 'filemtime', $file_to_delete ),SORT_NUMERIC,SORT_ASC,$file_to_delete);
      unlink($file_to_delete[0]);

      $file_count = intval($file_count)+1;
  }

  if (!file_exists($upload_path.'/wpfilmlist/backups')) {
    mkdir($upload_path.'/wpfilmlist/backups', 0777, true);
  }

  // Creating final filename and saving the spreadsheet
  $mydate=getdate(date("U"));
  $filename = $tabletext."_Library_$mydate[month]_$mydate[mday]_$mydate[year]_".$file_count;
  $objWriter->save($upload_path.'/wpfilmlist/backups/'.$filename.'.xlsx');


  $first_file;
  $file_control = 0;
  $files = glob($upload_path.'/wpfilmlist/backups/*'); // get all file names




  // Response to ajax call
  echo $filename.'.xlsx';
  wp_die(); 

}


function wpfilmlist_restore_from_spreadsheet_action_javascript() { ?>
  <script type="text/javascript" >

  jQuery(document).on("change","#wpfilmlist_select_backup_box", function(event){
    if(jQuery('#wpfilmlist-table-select-backup-dropdown-restore').val() != 'notyet'){
      jQuery('#wpfilmlist-backup-restore-link').css({'pointer-events':'all'});
      jQuery('#wpfilmlist-backup-restore-link').addClass('wpfilmlist-backup-restore-link-hover');
    }
  });

  jQuery(document).on("change","#wpfilmlist-table-select-backup-dropdown-restore", function(event){
    if(jQuery('#wpfilmlist_select_backup_box').val() != 'notyet'){
      jQuery('#wpfilmlist-backup-restore-link').css({'pointer-events':'all'});
      jQuery('#wpfilmlist-backup-restore-link').addClass('wpfilmlist-backup-restore-link-hover');
    }
  });  



  jQuery(document).on("click","#wpfilmlist-backup-restore-link", function(event){
      var e = document.getElementById("wpfilmlist_select_backup_box");
      var table = jQuery('#wpfilmlist-table-select-backup-dropdown-restore').val();
      var backupSelection = 'backups/'+e.options[e.selectedIndex].text;
      backupSelection = backupSelection.replace(/ /g, "_")+'.xlsx';
      backupSelection = backupSelection.substring(backupSelection.lastIndexOf("/") + 1);
      console.log(backupSelection);


      var data = {
        'action': 'wpfilmlist_restore_from_spreadsheet_action',
        'table': table,
        'backupSelection': backupSelection,
        'security': '<?php echo wp_create_nonce( "wpfilmlist_restore_from_spreadsheet_action" ); ?>'

      };
      jQuery.post(ajaxurl, data, function(response) {
       document.location.reload(true);
      });
      event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  </script> <?php
}

function wpfilmlist_restore_from_spreadsheet_action_callback() {
  global $wpdb;
  check_ajax_referer( 'wpfilmlist_restore_from_spreadsheet_action', 'security' );
  include_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
  include_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
  require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

  $table_name = sanitize_text_field($_POST['table']);
  $upload_path = wp_upload_dir();
  $upload_path = $upload_path['basedir'];
  // The particular backup the user selected from the drop-down menu
  $backupSelection = sanitize_text_field($_POST['backupSelection']);
  $fileType = 'Excel2007';
  $fileName = $upload_path.'/wpfilmlist/backups/'.$backupSelection;
  
  $objReader = PHPExcel_IOFactory::createReader($fileType);
  $objPHPExcel = $objReader->load($fileName);

  //Get worksheet dimensions
  $sheet = $objPHPExcel->getSheet(0); 
  $highestRow = $sheet->getHighestRow(); 
  $highestColumn = 'AL';

  // Delete all data in DB
  $delete = $wpdb->query($wpdb->prepare("TRUNCATE TABLE $table_name", $table_name));
      
  //Loop through each row of the worksheet in turn
  for ($row = 3; $row <= $highestRow; $row++){ 
      //  Read a row of data into an array
      $row_data = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
      if($row_data[0][0] != "") {
        $n = $row_data[0][4];
        $dateTime = new DateTime("1899-12-30 + $n days");
        $release = $dateTime->format("Y-m-d");
        $wpdb->insert( $table_name, array(
            'ID' => $row_data[0][0],
            'title' => $row_data[0][1],                  
            'mediaid' => $row_data[0][2],
            'creators' => $row_data[0][3],
            'releasefirstairdate' => $release,
            'coverurl' => $row_data[0][5],
            'imdbid' => $row_data[0][6], 
            'overview' => $row_data[0][7],
            'revenue' => $row_data[0][8],
            'runtime' => $row_data[0][9],
            'tagline' => $row_data[0][10],
            'networks' => $row_data[0][11],
            'video' => $row_data[0][12],
            'budget' => $row_data[0][13],
            'backdropurl' => $row_data[0][14],
            'homepageurl' => $row_data[0][15],
            'language' => $row_data[0][16],
            'productioncountry' => htmlspecialchars($row_data[0][17]),
            'productioncompany' => $row_data[0][18],
            'genres' => $row_data[0][19], 
            'originaltitle' => $row_data[0][20],
            'popularity' => $row_data[0][21],
            'belongstocollection' => $row_data[0][22],
            'seasons' => $row_data[0][23],
            'numofseasons' => $row_data[0][24],
            'numofepisodes' => $row_data[0][25],
            'episoderuntime' => $row_data[0][26],
            'videostring' => $row_data[0][27],
            'inproduction' => $row_data[0][28],
            'notes' => $row_data[0][29],
            'watched' => $row_data[0][30],
            'status' => htmlspecialchars($row_data[0][31]),
            'caststring' => $row_data[0][32],
            'crewstring' => $row_data[0][33], 
            'type' => $row_data[0][34],
            'myfilmrating' => $row_data[0][35]
          ),  array(
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d'
              )
          );
      }
  }



              



  $row_data = $sheet->rangeToArray('A3' . ':' . 'AL3', NULL, TRUE, FALSE);
  wp_die(); // this is required to terminate immediately and return a proper response

}


function wpfilmlist_jre_upload_excel_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).on("click","#wpfilmlist_upload_link", function(event){
    var uploadDir = '<?php $upload_path = wp_upload_dir(); $upload_path = $upload_path["basedir"]; echo $upload_path; ?>'

    var data = {
      'action': 'wpfilmlist_jre_create_upload_action',
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-uploadexcel" ); ?>',
      'uploadDir': uploadDir
    };

    jQuery.post(ajaxurl, data, function(response) {
      jQuery.colorbox({
        open: true,
        scrolling: true,
        width:'50%',
        height:'50%',
        html: response,
        data: data,
        onClosed:function(){
            jQuery('.cboxContentForWpFilmList').css({'opacity':'0'});
        },
        onComplete:function(){
          jQuery("#cboxLoadedContent").addClass("cboxLoadedContentForWpFilmList");
          jQuery("#cboxContent").addClass("cboxContentForWpFilmList");
          currentHeight = jQuery('.cboxLoadedContentForWpFilmList').css('height');
          currentHeight = (parseInt(currentHeight, 10) + 5);
          jQuery('.cboxLoadedContentForWpFilmList').css({'margin-bottom':'0px!important','min-height':currentHeight+'px'});
          jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});

          // Sets color of the link inside the fancybox to the default theme link color
          var color = jQuery('#wpfilmlist_edit_film_link').css("color");
          jQuery('#cboxLoadedContent a').css('color', color);
        }
        });
    });

    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  </script> <?php
}


function wpfilmlist_jre_create_upload_action_callback() {
  global $wpdb;
  $upload_path = filter_var($_POST['uploadDir'], FILTER_SANITIZE_STRING);
  include_once( plugin_dir_path( __FILE__ ) . 'uploadlist_ui.php');
  wpfilmlist_jre_uploadlist_ui($upload_path);
  wp_die(); 
}

function wpfilmlist_jre_film_addition_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).on("click","#wpfilmlist_add_film_link", function(event){

  rotate(1, false);
  jQuery('#wpbooklist-movie-proj-animate-div').animate({'opacity':'1'},1000)

  function rotate(degree, stop) {
    if(stop != true){
      jQuery(".wpfilmlist-projector-reel-image").css({
      '-webkit-transform': 'rotate(' + degree + 'deg)',
      '-moz-transform': 'rotate(' + degree + 'deg)',
      '-o-transform': 'rotate(' + degree + 'deg)',
      '-ms-transform': 'rotate(' + degree + 'deg)',
      'transform': 'rotate(' + degree + 'deg)'
      });
      if (degree < 10000) {
      timer = setTimeout(function() {
          rotate(++degree)
      }, 1);
    } else {
      return;
    }
  }}


    mediaselect = jQuery('#wpfilmlist-movie-tv-selection').val();
    var control = 0;
    searchterm = jQuery('#wpfilmlist_title_search').val();

    var data = {
      'action': 'wpfilmlist_jre_film_addition_action',
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-addfilm" ); ?>',
      'searchterm': searchterm,
      'mediaselect': mediaselect
    };

    jQuery.post(ajaxurl, data, function(response) {
      if(mediaselect == 'Movie'){
        console.log(response);
        jQuery('#wpbooklist-movie-proj-animate-div').css({'opacity':'0'})
          jQuery.colorbox({
          open: true,
          scrolling: true,
          width:'70%',
          height:'70%',
          html: response,
          data: data,
          title: '<p id="wpfilmlist-add-titles-button">Add Selected Movies</p>',
          onClosed:function(){
              jQuery('.cboxContentForWpFilmList').css({'opacity':'0'});
          },
          onComplete:function(){
            jQuery("#cboxLoadedContent").addClass("cboxLoadedContentForWpFilmList");
            jQuery("#cboxContent").addClass("cboxContentForWpFilmList");
            currentHeight = jQuery('.cboxLoadedContentForWpFilmList').css('height');
            currentHeight = (parseInt(currentHeight, 10) + 5);

            num = Math.floor(Math.random() * 8);
            jQuery('.cboxLoadedContentForWpFilmList').css({'margin-bottom':'0px!important','min-height':currentHeight+'px'});

            if(num == 0){
              path = "<?php echo plugins_url( '/assets/img/backdropexport0.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 1){
              path = "<?php echo plugins_url( '/assets/img/backdropexport1.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 2){
              path = "<?php echo plugins_url( '/assets/img/backdropexport2.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 3){
              path = "<?php echo plugins_url( '/assets/img/backdropexport3.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 4){
              path = "<?php echo plugins_url( '/assets/img/backdropexport4.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 5){
              path = "<?php echo plugins_url( '/assets/img/backdropexport5.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 6){
              path = "<?php echo plugins_url( '/assets/img/backdropexport6.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
               jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 7){
              path = "<?php echo plugins_url( '/assets/img/backdropexport7.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }


            
          } 
        });
      } else {
        jQuery('#wpbooklist-movie-proj-animate-div').css({'opacity':'0'})
        console.log(response);
          jQuery.colorbox({
          open: true,
          scrolling: true,
          width:'70%',
          height:'70%',
          html: response,
          data: data,
          title: '<p id="wpfilmlist-add-titles-button">Add Selected TV Shows</p>',
          onClosed:function(){
              //Do something on close.
          },
          onComplete:function(){
            jQuery("#cboxLoadedContent").addClass("cboxLoadedContentForWpFilmList");
            jQuery("#cboxContent").addClass("cboxContentForWpFilmList");
            currentHeight = jQuery('.cboxLoadedContentForWpFilmList').css('height');
            currentHeight = (parseInt(currentHeight, 10) + 5);

            num = Math.floor(Math.random() * 8);
            jQuery('.cboxLoadedContentForWpFilmList').css({'margin-bottom':'0px!important','min-height':currentHeight+'px'});

            if(num == 0){
              path = "<?php echo plugins_url( '/assets/img/backdropexport0.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 1){
              path = "<?php echo plugins_url( '/assets/img/backdropexport1.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 2){
              path = "<?php echo plugins_url( '/assets/img/backdropexport2.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 3){
              path = "<?php echo plugins_url( '/assets/img/backdropexport3.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 4){
              path = "<?php echo plugins_url( '/assets/img/backdropexport4.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 5){
              path = "<?php echo plugins_url( '/assets/img/backdropexport5.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 6){
              path = "<?php echo plugins_url( '/assets/img/backdropexport6.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }

            if(num == 7){
              path = "<?php echo plugins_url( '/assets/img/backdropexport7.png', __FILE__) ?>";
              jQuery('#wpfilmlist-hidden-image-img').attr('src', path).load(function() {
                jQuery('#wpfilmlist-background-color-image-div-add').css({'min-height':currentHeight+'px','overflow':'hidden','background-image':'url('+path+')','background-repeat':'no-repeat','background-size':'cover'  });
                jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
              });
            }
          }
        });
      } 
    });
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });

  </script> <?php
}

function wpfilmlist_jre_film_addition_action_callback() {
  global $wpdb;
  $tmdb_array = null;
  $searchterm = urlencode(filter_var($_POST['searchterm'], FILTER_SANITIZE_STRING));
  $mediaselect = filter_var($_POST['mediaselect'], FILTER_SANITIZE_STRING);

  echo ' <div id="wpfilmlist-background-color-image-div-add"><div class="wpfilmlist-image-selection-div">';
  echo '<img id="wpfilmlist-hidden-image-img" style="display:none" /><div style="margin-left: auto; margin-right: auto; padding-bottom: 20px; padding-top: 20px; font-size: 24px; font-style: italic; color: white; margin-bottom: 10px;" id="wpfilmlist-title">Select One of the Titles Below:</div></div>';
  if($mediaselect == 'Movie'){
    $searchterm = str_replace('%5C%26%2339%3B',"'",$searchterm);
    // Make request to tmdb with file_get_contents
    if($tmdb_array == null){
      $res = file_get_contents('https://api.themoviedb.org/3/search/multi?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US&query='.$searchterm.'&page=1&include_adult=false');
      $tmdb_array = json_decode($res, true);  
    }

    // Make request to tmdb with cUrl if file_get_contents fails
    if($tmdb_array == null){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $url = 'https://api.themoviedb.org/3/search/multi?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US&query='.$searchterm.'&page=1&include_adult=false';
      curl_setopt($ch, CURLOPT_URL, $url);
      $result = curl_exec($ch);
      curl_close($ch);
      $tmdb_array = json_decode($result,TRUE);
    }


    foreach($tmdb_array as $key=>$item){
      foreach($item as $key2=>$item2){
        $mediaid = $item2['id'];

        $res = file_get_contents('https://api.themoviedb.org/3/movie/'.$mediaid.'?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US');
        $tmdb_movie_array2 = json_decode($res, true);

        // Make request to tmdb with cUrl if file_get_contents fails
        if($tmdb_movie_array2 == null){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $url = 'https://api.themoviedb.org/3/movie/'.$mediaid.'?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US';
          curl_setopt($ch, CURLOPT_URL, $url);
          $result = curl_exec($ch);
          curl_close($ch);
          $tmdb_movie_array2 = json_decode($result,TRUE);
        }

        // Make request to tmdb with cUrl if file_get_contents fails
        if($tmdb_movie_array2 == null){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $url = 'https://api.themoviedb.org/3/movie/'.$mediaid.'?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US';
          curl_setopt($ch, CURLOPT_URL, $url);
          $result = curl_exec($ch);
          curl_close($ch);
          $tmdb_movie_array2 = json_decode($result,TRUE);
        }

        $imdbid = $tmdb_movie_array2['imdb_id'];
        $revenue = $tmdb_movie_array2['revenue'];
        $tagline = str_replace('"', '\'', addslashes($tmdb_movie_array2['tagline']));
        $title = $tmdb_movie_array2['title'];
        $video = $tmdb_movie_array2['video'];
        $runtime = $tmdb_movie_array2['runtime'];
        $budget = $tmdb_movie_array2['budget'];
        $homepage = $tmdb_movie_array2['homepage'];
        $originaltitle = $tmdb_movie_array2['original_title'];
        $overview = str_replace('"', '\'', addslashes($tmdb_movie_array2['overview']));
        $popularity = $tmdb_movie_array2['popularity'];
        $releasedate = $tmdb_movie_array2['release_date'];
        $status = $tmdb_movie_array2['status'];

        $cover_url = 'https://image.tmdb.org/t/p/w185_and_h278_bestv2'.$tmdb_movie_array2['poster_path'];
        $backdrop = 'https://image.tmdb.org/t/p/original'.$tmdb_movie_array2['backdrop_path'];
        $genresstring = '';
        foreach($tmdb_movie_array2['genres'] as $genre){
          if($genre !=null){
            $genresstring = $genresstring.$genre['name'].',';
          }
        }
        $prodcomp = '';
        foreach($tmdb_movie_array2['production_companies'] as $comp){
          if($comp !=null){
            $prodcomp = $prodcomp.$comp['name'].',';
          }
        }
        $prodcountry = '';
        foreach($tmdb_movie_array2['production_countries'] as $country){
          if($country !=null){
            $prodcountry = $prodcountry.$country['name'].',';
          }
        }
        $lang = '';
        foreach($tmdb_movie_array2['spoken_languages'] as $l){
          if($l !=null){
            $lang = $lang.$l['name'].',';
          }
        }
        //var_dump($tmdb_movie_array2);
        $belongstocollection = $tmdb_movie_array2['belongs_to_collection']['poster_path'].','.$tmdb_movie_array2['belongs_to_collection']['poster_path'];

        // Getting videos
        $res = file_get_contents('https://api.themoviedb.org/3/movie/'.$mediaid.'/videos?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US');
        $tmdb_movie_array = json_decode($res, true);

        // Make request to tmdb with cUrl if file_get_contents fails
        if($tmdb_movie_array == null){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $url = 'https://api.themoviedb.org/3/tv/'.$mediaid.'/videos?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US';
          curl_setopt($ch, CURLOPT_URL, $url);
          $result = curl_exec($ch);
          curl_close($ch);
          $tmdb_movie_array = json_decode($result,TRUE);
        }

        $vidmoviestring = '';
        foreach( $tmdb_movie_array['results'] as $vid){
          $vidmoviestring = $vidmoviestring.$vid['key'].','.$vid['name'].','.$vid['site'].',';
        }
        if($cover_url == 'https://image.tmdb.org/t/p/w185_and_h278_bestv2'){
          $cover_url = plugins_url( '/assets/img/noposterimage.jpg', __FILE__);
        }

        if(($title == '') || ($title == null)){
          $title = "Title Unavailable";
        }

        echo '<div class="wpfilmlist_entry_div"> <div class="wpfilmlist_inner_main_display_div wpfilmlist_inner_main_display_div_for_search wpfilmlist_search_colorbox"> <img class="wpfilmlist-select-film-by-img-class" id="wpfilmlist-select-by-image-'.$key.'" src="'.$cover_url.'" /><p style="opacity: 1;" class="wpfilmlist_saved_title_link_bulk">'.$title.'</p><label class="wpfilmlist-label-entry-search">Add Movie</label><input id="wpfilmlist-checkbox-bulk-add-id-'.$key.'" class="wpfilmlist-checkbox-bulk-add-class" type="checkbox" data-title="'.$title.'" data-overview="'.$overview.'" data-imdb="'.$imdbid.'" data-revenue="'.$revenue.'" data-tagline="'.$tagline.'" data-video="'.$video.'" data-runtime="'.$runtime.'" data-budget="'.$budget.'" data-homepage="'.$homepage.'" data-originaltitle="'.$originaltitle.'" data-popularity="'.$popularity.'" data-releasedate="'.$releasedate.'" data-status="'.$status.'" data-backdrop="'.$backdrop.'" data-genres="'.$genresstring.'" data-prodcomp="'.$prodcomp.'" data-prodcountry="'.$prodcountry.'" data-lang="'.$lang.'" data-vidmoviestring="'.$vidmoviestring.'" data-coverurl="'.$cover_url.'" data-mediaid="'.$mediaid.'" data-belongstocollection="'.$belongstocollection.'" data-mediatype="Movie"></input> </div></div>';
      }
    }
  }

  if($mediaselect == 'TV'){
    $searchterm = str_replace('%5C%26%2339%3B',"'",$searchterm);
    // Make request to tmdb with file_get_contents
    if($tmdb_array == null){
      $res = file_get_contents('https://api.themoviedb.org/3/search/multi?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US&query='.$searchterm.'&page=1&include_adult=false');
      $tmdb_array = json_decode($res, true);  
    }

    // Make request to tmdb with cUrl if file_get_contents fails
    if($tmdb_array == null){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $url = 'https://api.themoviedb.org/3/search/multi?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US&query='.$searchterm.'&page=1&include_adult=false';
      curl_setopt($ch, CURLOPT_URL, $url);
      $result = curl_exec($ch);
      curl_close($ch);
      $tmdb_array = json_decode($result,TRUE);
    }

    foreach($tmdb_array as $key=>$item){
      foreach($item as $key2=>$item2){
        $mediaid = $item2['id'];

        $res = file_get_contents('https://api.themoviedb.org/3/tv/'.$mediaid.'?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US');
        $tmdb_tv_array = json_decode($res, true);

        // Make request to tmdb with cUrl if file_get_contents fails
        if($tmdb_tv_array == null){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $url = 'https://api.themoviedb.org/3/tv/'.$mediaid.'?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US';
          curl_setopt($ch, CURLOPT_URL, $url);
          $result = curl_exec($ch);
          curl_close($ch);
          $tmdb_tv_array = json_decode($result,TRUE);
        }

        $cover_url = 'https://image.tmdb.org/t/p/w185_and_h278_bestv2'.$tmdb_tv_array['poster_path'];
        $backdrop = 'https://image.tmdb.org/t/p/original'.$tmdb_tv_array['backdrop_path'];
        $homepage = $tmdb_tv_array['homepage'];
        $name = $tmdb_tv_array['name'];
        $overview = str_replace('"', '\'', addslashes($tmdb_tv_array['overview']));
        $originalname = $tmdb_tv_array['original_name'];
        $inproduction = $tmdb_tv_array['in_production'];
        $popularity = $tmdb_movie_array2['popularity'];
        $numofepisodes = $tmdb_tv_array['number_of_episodes'];
        $numofseasons = $tmdb_tv_array['number_of_seasons'];
        $firstairdate = $tmdb_tv_array['first_air_date'];

        // Getting show creators
        $creatorstring = '';
        foreach($tmdb_tv_array['created_by'] as $item3){
          if($item3 != null){
            $creatorstring = $creatorstring.$item3['name'].',';
          }
        }

        $episoderuntime = '';
        foreach($tmdb_tv_array['episode_run_time'] as $item4){
          if($item4 != null){
            $episoderuntime = $episoderuntime.$item4.',';
          }
        }

        $genresstring = '';
        foreach($tmdb_tv_array['genres'] as $genre){
          if($genre !=null){
            $genresstring = $genresstring.$genre['name'].',';
          }
        }

        $lang = '';
        foreach($tmdb_tv_array['languages'] as $key=>$l){
          if($l !=null){
            $lang = $lang.$l.',';
          }
        }
        
        $networks = '';
        foreach($tmdb_tv_array['networks'] as $net){
          if($net !=null){
            $networks = $networks.$net['name'].',';
          }
        }

        $origcountry = '';
        foreach($tmdb_tv_array['origin_countries'] as $country){
          if($country !=null){
            $origcountry = $origcountry.$country['name'].',';
          }
        }

        $prodcomp = '';
        foreach($tmdb_tv_array['production_companies'] as $comp){
          if($comp !=null){
            $prodcomp = $prodcomp.$comp['name'].',';
          }
        }

        $seasons = '';
        
        foreach($tmdb_tv_array['seasons'] as $sea){
          if($sea !=null){
            $seasons = $seasons.$sea['poster_path'].',';
          }
        }
        $numofseasons = (int)$numofseasons;
        $uberepisodestring = '';
        /*
        for($i = 1; $i <= $numofseasons; $i++){
          $res = file_get_contents('https://api.themoviedb.org/3/tv/'.$mediaid.'/season/'.$i.'?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US');
          $tmdb_season_array = json_decode($res, true);

          // Make request to tmdb with cUrl if file_get_contents fails
          if($tmdb_season_array == null){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $url = 'https://api.themoviedb.org/3/tv/'.$mediaid.'/season/'.$i.'?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US';
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            curl_close($ch);
            $tmdb_season_array = json_decode($result,TRUE);
          }

          foreach($tmdb_season_array['episodes'] as $episode){
            $uberepisodestring = $uberepisodestring.$episode['episode_number'].','.$episode['name'].','.$episode['overview'].','.$episode['still_path'].',';
          }
        } */

        $uberepisodestring = str_replace('"', '\'', addslashes($uberepisodestring));

        $res = file_get_contents('https://api.themoviedb.org/3/tv/'.$mediaid.'/videos?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US');
        $tmdb_vid_array = json_decode($res, true);

        // Make request to tmdb with cUrl if file_get_contents fails
        if($tmdb_vid_array == null){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $url = 'https://api.themoviedb.org/3/tv/'.$mediaid.'/videos?api_key=06704b70c2a5b0d53730316cca8c3e7a&language=en-US';
          curl_setopt($ch, CURLOPT_URL, $url);
          $result = curl_exec($ch);
          curl_close($ch);
          $tmdb_vid_array = json_decode($result,TRUE);
        }

        $vidtvstring = '';
        foreach( $tmdb_vid_array['results'] as $vid){
          $vidtvstring = $vidtvstring.$vid['key'].','.$vid['name'].','.$vid['site'].',';
        }

        if($cover_url == 'https://image.tmdb.org/t/p/w185_and_h278_bestv2'){
          $cover_url =  plugins_url( '/assets/img/noposterimage.jpg', __FILE__);
        }

        if(($name == '') || ($name == null)){
          $name = "Title Unavailable";
        }

          echo '<div class="wpfilmlist_entry_div"> <div class="wpfilmlist_inner_main_display_div wpfilmlist_inner_main_display_div_for_search wpfilmlist_search_colorbox"> <img class="wpfilmlist-select-film-by-img-class" id="wpfilmlist-select-by-image-'.$key.'" src="'.$cover_url.'"/><p style="opacity: 1;" class="wpfilmlist_saved_title_link_bulk">'.$name.'</p><label class="wpfilmlist-add-show-label">Add Show</label><input id="wpfilmlist-checkbox-bulk-add-id-'.$key.'" class="wpfilmlist-checkbox-bulk-add-class" type="checkbox" data-name="'.$name.'" data-originalname="'.$originalname.'" data-mediaid="'.$mediaid.'" data-overview="'.$overview.'" data-networks="'.$networks.'" data-creatorstring="'.$creatorstring.'" data-tagline="'.$tagline.'" data-seasons="'.$seasons.'" data-homepage="'.$homepage.'" data-episoderuntime="'.$episoderuntime.'" data-firstairdate="'.$firstairdate.'" data-backdrop="'.$backdrop.'" data-genres="'.$genresstring.'" data-prodcomp="'.$prodcomp.'" data-origcountry="'.$origcountry.'" data-numofseasons="'.$numofseasons.'" data-numofepisodes="'.$numofepisodes.'" data-lang="'.$lang.'" data-inproduction="'.$inproduction.'" data-vidtvstring="'.$vidtvstring.'" data-uberepisodestring="'.$uberepisodestring.'" data-popularity="'.$popularity.'" data-coverurl="'.$cover_url.'" data-mediatype="TV Show" ></input> </div></div>';
      }
    }
  }

  wp_die(); 
}



function wpfilmlist_jre_film_delete_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).on("click","#wpfilmlist_delete_film_link", function(event){

    var id = jQuery(this).find("span");
    id = id.html();
    var data = {
      'action': 'wpfilmlist_jre_film_delete_action',
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-deletefilm" ); ?>',
      'id': id
    };
    jQuery.post(ajaxurl, data, function(response) {
          jQuery.colorbox({
          open: true,
          scrolling: true,
          width:'30%',
          height:'30%',
          html: response,
          data: data,
          onClosed:function(){
              //Do something on close.
          }, 
          onComplete:function(){
            jQuery("#cboxLoadedContent").addClass("cboxLoadedContentForWpFilmList");
            jQuery("#cboxContent").addClass("cboxContentForWpFilmList");
            currentHeight = jQuery('.cboxLoadedContentForWpFilmList').css('height');
            currentHeight = (parseInt(currentHeight, 10) + 5);
            jQuery('.cboxLoadedContentForWpFilmList').css({'margin-bottom':'0px!important','min-height':currentHeight+'px'});
            jQuery('.cboxContentForWpFilmList').css({'opacity':'1'});
            jQuery('.cboxContentForWpFilmList').css({'background':'#fff!important'});
          }
      });
    });
    event.preventDefault ? event.preventDefault() : event.returnValue = false;

  });
  </script> <?php
}

function wpfilmlist_jre_film_delete_action_callback() {
  global $wpdb;
  check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-deletefilm', 'security' );
  include_once( plugin_dir_path( __FILE__ ) . 'deleteentry.php');
  $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
  wpfilmlist_jre_deleteentry($id);
  wp_die(); 
}

function wpfilmlist_jre_stylepak_file_upload_action_javascript(){
?>
<script>
function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object
    theFile = files[0];
    // Open Our formData Object
    var formData = new FormData();
    formData.append('action', 'wpfilmlist_jre_stylepak_file_upload_action');
    formData.append('my_uploaded_file', theFile);
    var nonce = '<?php echo wp_create_nonce( "from_wpfilmlist_jre_stylepak_file_upload_action_javascript" );  ?>';
    formData.append('security', nonce);

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      data: formData,
      contentType:false,
      processData:false,
      success: function(response){
        document.location.reload();
      }
    }); 
    
    var working = jQuery('#wpfilmlist-backend-stylepak-progress');
    var control = 0;
    wpfilmliststylepakProgress(working);
    function wpfilmliststylepakProgress(working){
      if(control < 10000){
        working.animate({opacity: '1'}, 1000);
        working.animate({opacity: '0'}, 1000);
        control = control+1;
        wpfilmliststylepakProgress(working);
      }
    }
    
  }

  document.getElementById('wpfilmlist-add-new-stylepak-file').addEventListener('change', handleFileSelect, false);
</script>
}
<?php
}

function wpfilmlist_jre_stylepak_file_upload_action_callback() {
  global $wpdb; // this is how you get access to the database
  var_dump($_POST);
  $nonce = $_POST["_wpnonce"];
  check_ajax_referer( 'from_wpfilmlist_jre_stylepak_file_upload_action_javascript', 'security' );
  if (!file_exists($_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/wpfilmlist")) {
    mkdir($_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/wpfilmlist", 0777, true);
  }

  if (!file_exists($_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/wpfilmlist/stylepak-exports")) {
    mkdir($_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/wpfilmlist/stylepak-exports", 0777, true);
  }

  move_uploaded_file ($_FILES['my_uploaded_file'] ['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/wpfilmlist/stylepak-exports/{$_FILES['my_uploaded_file'] ['name']}");




  wp_die(); // this is required to terminate immediately and return a proper response

}

function wpfilmlist_jre_stylepak_selection_action_javascript(){
?>
<script>

  jQuery("#wpfilmlist_select_stylepak_box").change(function(){
    var fileSelect = jQuery("#wpfilmlist_select_stylepak_box").val();

    var data = {
      'action': 'wpfilmlist_jre_stylepak_selection_action',
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-stylepak" ); ?>',
      'stylepak': fileSelect
    };

    console.log(data);

    jQuery.post(ajaxurl, data, function(response) {   
      document.location.reload();
    });

  });

</script>
}
<?php
}


function wpfilmlist_jre_stylepak_selection_action_callback(){
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-stylepak', 'security' );
  $stylepak = $_POST["stylepak"];
  $stylepak = str_replace('.css', '', $stylepak);
  echo $stylepak;
  $table_name = $wpdb->prefix . 'wpfilmlist_jre_user_options';
  $data = array(
    'stylepak' => $stylepak
  );
  $format = array( '%s');   
  $where = array( 'ID' => 1 );
  $where_format = array( '%d' );
  $wpdb->update( $table_name, $data, $where, $format, $where_format );
  wp_die(); // this is required to terminate immediately and return a proper response
}

function wpfilmlist_add_movies_and_tv_action_javascript(){
?>
<script>
jQuery('body').on('click', '#wpfilmlist-add-titles-button', function () {
  boxes = jQuery('.wpfilmlist-checkbox-bulk-add-class');
  reloadInt = 0;
  indexer = 0;
  boxes.each(function(){
    if(jQuery(this).prop('checked') == true){
      reloadInt = reloadInt+1;
    }
  });
  boxes.each(function(index){
    choosentitle = jQuery(this);
    if(jQuery(this).prop('checked') == true){
      mediatype = choosentitle.attr('data-mediatype');

      if(mediatype == 'Movie'){
        coverurl = choosentitle.attr('data-coverurl');
        mediaid = choosentitle.attr('data-mediaid');
        title = choosentitle.attr('data-title');
        overview = choosentitle.attr('data-overview');
        imdbid = choosentitle.attr('data-imdb');
        revenue = choosentitle.attr('data-revenue');
        tagline = choosentitle.attr('data-tagline');
        video = choosentitle.attr('data-video');
        runtime = choosentitle.attr('data-runtime');
        budget = choosentitle.attr('data-budget');
        homepageurl = choosentitle.attr('data-homepage');
        originaltitle = choosentitle.attr('data-originaltitle');
        popularity = choosentitle.attr('data-popularity');
        releasefirstairdate = choosentitle.attr('data-releasedate');
        backdropurl = choosentitle.attr('data-backdrop');
        genres = choosentitle.attr('data-genres');
        productioncompany = choosentitle.attr('data-prodcomp');
        productioncountry = choosentitle.attr('data-prodcountry');
        language = choosentitle.attr('data-lang');
        videostring = choosentitle.attr('data-vidmoviestring');
        belongstocollection = choosentitle.attr('data-belongstocollection');
        status = choosentitle.attr('data-status');
        episoderuntime = null;
        numofseasons = null;
        numofepisodes = null;
        inproduction = null;
        creators = null;
        networks = null;
        uberepisodestring = null;
        seasons = null;
        notes = null;
        watched = 'true';
      }

      if(mediatype == 'TV Show'){
        coverurl = choosentitle.attr('data-coverurl');
        title = choosentitle.attr('data-name');
        originaltitle = choosentitle.attr('data-originalname');
        mediaid = choosentitle.attr('data-mediaid');
        overview = choosentitle.attr('data-overview');
        networks = choosentitle.attr('data-networks');
        creators = choosentitle.attr('data-creatorstring');
        overview = choosentitle.attr('data-overview');
        tagline = choosentitle.attr('data-tagline');
        seasons = choosentitle.attr('data-seasons');
        homepageurl = choosentitle.attr('data-homepage');
        episoderuntime = choosentitle.attr('data-episoderuntime');
        releasefirstairdate = choosentitle.attr('data-firstairdate');
        backdropurl = choosentitle.attr('data-backdrop');
        genres = choosentitle.attr('data-genres');
        productioncompany = choosentitle.attr('data-prodcomp');
        productioncountry = choosentitle.attr('data-origcountry');
        numofseasons = choosentitle.attr('data-numofseasons');
        numofepisodes = choosentitle.attr('data-numofepisodes');
        language = choosentitle.attr('data-lang');
        inproduction = choosentitle.attr('data-inproduction');
        videostring = choosentitle.attr('data-vidtvstring');
        uberepisodestring = choosentitle.attr('data-uberepisodestring');
        popularity = choosentitle.attr('data-popularity');
        belongstocollection = null;
        imdbid = null;
        revenue = null;
        runtime = null;
        budget = null;
        video = null;
        notes = null;
        watched = 'true';
        status = null;
      }

      var table = '<?php echo esc_html($GLOBALS["a"]); ?>';

      var data = {
        'action': 'wpfilmlist_add_movies_and_tv_action',
        'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-add-titles" ); ?>',
        'table':table,
        'mediaid':mediaid,
        'type':mediatype,
        'coverurl':coverurl,
        'title':title,
        'overview':overview,
        'imdbid':imdbid,
        'revenue':revenue,
        'tagline':tagline,
        'video':video,
        'runtime':runtime,
        'budget':budget,
        'homepageurl':homepageurl,
        'originaltitle':originaltitle,
        'popularity':popularity,
        'releasefirstairdate':releasefirstairdate,
        'backdropurl':backdropurl,
        'genres':genres,
        'productioncompany':productioncompany,
        'productioncountry':productioncountry,
        'language':language,
        'videostring':videostring,
        'episoderuntime':episoderuntime,
        'numofseasons':numofseasons,
        'numofepisodes':numofepisodes,
        'inproduction':inproduction,
        'creators':creators,
        'networks':networks,
        'uberepisodestring':uberepisodestring,
        'seasons':seasons,
        'watched':watched,
        'status':status,
        'notes':notes,
        'belongstocollection':belongstocollection
      };

      indexer++;
      jQuery.post(ajaxurl, data, function(response) { 
        if(reloadInt == indexer){
          //console.log(response);
          document.location.reload();
        }
        
      });

    }
  })

  });

 </script>
<?php
}

function wpfilmlist_add_movies_and_tv_action_callback(){
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-add-titles', 'security' );
  $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
  $table = filter_var($_POST['table'], FILTER_SANITIZE_STRING);
  $notes = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);
  $watched = filter_var($_POST['watched'], FILTER_SANITIZE_STRING);
  $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
  $coverurl = filter_var($_POST['coverurl'], FILTER_SANITIZE_URL);
  $mediaid = filter_var($_POST['mediaid'], FILTER_SANITIZE_STRING);
  $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
  $overview = filter_var($_POST['overview'], FILTER_SANITIZE_STRING);
  $imdbid = filter_var($_POST['imdbid'], FILTER_SANITIZE_STRING);
  $revenue = filter_var($_POST['revenue'], FILTER_SANITIZE_STRING);
  $tagline = filter_var($_POST['tagline'], FILTER_SANITIZE_STRING);
  $video = filter_var($_POST['video'], FILTER_SANITIZE_STRING);
  $runtime = filter_var($_POST['runtime'], FILTER_SANITIZE_STRING);
  $budget = filter_var($_POST['budget'], FILTER_SANITIZE_STRING);
  $homepageurl = filter_var($_POST['homepageurl'], FILTER_SANITIZE_URL);
  $originaltitle = filter_var($_POST['originaltitle'], FILTER_SANITIZE_STRING);
  $popularity = filter_var($_POST['popularity'], FILTER_SANITIZE_STRING);
  $releasefirstairdate = filter_var($_POST['releasefirstairdate'], FILTER_SANITIZE_STRING);
  $backdropurl = filter_var($_POST['backdropurl'], FILTER_SANITIZE_URL);
  $genres = filter_var($_POST['genres'], FILTER_SANITIZE_STRING);
  $productioncompany = filter_var($_POST['productioncompany'], FILTER_SANITIZE_STRING);
  $productioncountry = filter_var($_POST['productioncountry'], FILTER_SANITIZE_STRING);
  $language = filter_var($_POST['language'], FILTER_SANITIZE_STRING);
  $videostring = filter_var($_POST['videostring'], FILTER_SANITIZE_STRING);
  $episoderuntime = filter_var($_POST['episoderuntime'], FILTER_SANITIZE_STRING);
  $numofseasons = filter_var($_POST['numofseasons'], FILTER_SANITIZE_STRING);
  $numofepisodes = filter_var($_POST['numofepisodes'], FILTER_SANITIZE_STRING);
  $inproduction = filter_var($_POST['inproduction'], FILTER_SANITIZE_STRING);
  $creators = filter_var($_POST['creators'], FILTER_SANITIZE_STRING);
  $networks = filter_var($_POST['networks'], FILTER_SANITIZE_STRING);
  $uberepisodestring = filter_var($_POST['uberepisodestring'], FILTER_SANITIZE_STRING);
  $seasons = filter_var($_POST['seasons'], FILTER_SANITIZE_STRING);
  $belongstocollection = filter_var($_POST['belongstocollection'], FILTER_SANITIZE_STRING);
  // Inserting final values into the WordPress database

 echo $wpdb->insert( $table, array(
  'mediaid'=>$mediaid,
  'coverurl'=>$coverurl,
  'title'=>$title,
  'overview'=>$overview,
  'imdbid'=>$imdbid,
  'revenue'=>$revenue,
  'tagline'=>$tagline,
  'video'=>$video,
  'runtime'=>$runtime,
  'budget'=>$budget,
  'homepageurl'=>$homepageurl,
  'originaltitle'=>$originaltitle,
  'popularity'=>$popularity,
  'releasefirstairdate'=>$releasefirstairdate,
  'backdropurl'=>$backdropurl,
  'genres'=>$genres,
  'productioncompany'=>$productioncompany,
  'productioncountry'=>$productioncountry,
  'language'=>$language,
  'videostring'=>$videostring,
  'episoderuntime'=>$episoderuntime,
  'numofseasons'=>$numofseasons,
  'numofepisodes'=>$numofepisodes,
  'inproduction'=>$inproduction,
  'creators'=>$creators,
  'networks'=>$networks,
  'uberepisodestring'=>$uberepisodestring,
  'seasons'=>$seasons,
  'notes'=>$notes,
  'watched'=>$watched,
  'type'=>$type,
  'belongstocollection'=>$belongstocollection,
  'status'=>$status
  ),
                   array(
                          '%d',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%d',
                          '%s',
                          '%s',
                          '%s',
                          '%d',
                          '%s',
                          '%s',
                          '%d',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%d',
                          '%d',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s'
                      )   
              );

  wp_die();
}

function wpfilmlist_jre_dismiss_notice_forever_action_javascript(){
?>
<script>

  jQuery("#wpfilmlist-my-notice-dismiss-forever").click(function(){

    var data = {
      'action': 'wpfilmlist_jre_dismiss_notice_forever_action',
      'security': '<?php echo wp_create_nonce( "wpfilmlist_jre_dismiss_notice_forever_action" ); ?>',
    };

    jQuery.post(ajaxurl, data, function(response) {   
      document.location.reload();
    });
  });

  </script> <?php
}

function wpfilmlist_jre_dismiss_notice_forever_action_callback(){
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpfilmlist_jre_dismiss_notice_forever_action', 'security' );
  $table_name = $wpdb->prefix . 'wpfilmlist_jre_user_options';

  $data = array(
      'admindismiss' => 0
  );
  $where = array( 'ID' => 1 );
  $format = array( '%d');  
  $where_format = array( '%d' );
  $wpdb->update( $table_name, $data, $where, $format, $where_format );
  wp_die();
}

function wpfilmlist_id_amazon_affiliate_action_javascript() { ?>
 <script type="text/javascript" >
  var amazonAff;
  jQuery("#wpfilmlist-amazon-affiliate-library").bind('input', function() { 
    amazonAff = (jQuery("#wpfilmlist-amazon-affiliate-library").val()).toLowerCase();
      if((amazonAff.length > 0) && (amazonAff != 'Create a New Library Here...')){
            jQuery("#wpfilmlist-amazon-affiliate-button").attr('disabled', false);
    }
  });

  jQuery(document).on("click","#wpfilmlist-amazon-affiliate-button", function(event){
    var data = {
      'action': 'wpfilmlist_id_amazon_affiliate_action',
      'amazonAff': amazonAff,
      'security': '<?php echo wp_create_nonce( "wpfilmlist-jre-ajax-nonce-amazon-affiliate" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
  });
  </script> <?php
}


function wpfilmlist_id_amazon_affiliate_action_callback() {
  // Grabbing the existing options from DB
  global $wpdb;
  check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-amazon-affiliate', 'security' );
  $table_name_options = $wpdb->prefix . 'wpfilmlist_jre_user_options';
  $amazonAff = 'wpfilmlistid-20';
  $amazonAff = $_POST['amazonAff'];
  $data = array(
        'amazonaff' => $amazonAff
  );
  $format = array( '%s'); 
  $where = array( 'ID' => 1 );
  $where_format = array( '%d' );
  $wpdb->update( $table_name_options, $data, $where, $format, $where_format );
  
  wp_die(); // this is required to terminate immediately and return a proper response
}



function wpfilmlist_bulk_delete_action_javascript() { ?>
 <script type="text/javascript" >
 
  jQuery(document).on("click","#wpfilmlist-bulk-delete-button", function(event){
    var table;
    var id;
    boxes = jQuery('.wpfilmlist-bulk-edit-checkbox');
    reloadInt = 0;
    indexer = 0;
    boxes.each(function(){
      if(jQuery(this).prop('checked') == true){
        reloadInt = reloadInt+1;
      }
    });

    boxes.each(function(){
      if(jQuery(this).prop('checked') == true){
        table = jQuery(this).attr('data-table');
        id = jQuery(this).val();

        var data = {
          'action': 'wpfilmlist_bulk_delete_action',
          'id': id,
          'table':table,
          'security': '<?php echo wp_create_nonce( "wpfilmlist_bulk_delete_action" ); ?>'
        };

        indexer++;
        jQuery.post(ajaxurl, data, function(response) {
          if(reloadInt == indexer){
            document.location.reload();
          }
        });
      }
    });
  });
  </script> <?php
}

function wpfilmlist_bulk_delete_action_callback() {
  // Grabbing the existing options from DB
  global $wpdb;
  check_ajax_referer( 'wpfilmlist_bulk_delete_action', 'security' );
  $table_name = filter_var($_POST['table'], FILTER_SANITIZE_STRING);
  $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
  $wpdb->delete( $table_name, array( 'ID' => $id ) );
  // Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name MODIFY ID BIGINT(255) NOT NULL", $table_name));
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name DROP PRIMARY KEY", $table_name));
  // Adjusting ID values of remaining entries in database
  $my_query = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name", $table_name ));
  $title_count = $wpdb->num_rows;    
  // Adding primary key back to database 
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name ADD PRIMARY KEY (`ID`)", $table_name));    
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name MODIFY ID BIGINT(255) AUTO_INCREMENT", $table_name));
  // Setting the AUTO_INCREMENT value based on number of remaining entries
  $title_count++;
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name AUTO_INCREMENT=$title_count", $table_name));
  wp_die(); // this is required to terminate immediately and return a proper response
}

function wpfilmlist_bulk_rate_action_javascript() { ?>
 <script type="text/javascript" >
 
  jQuery(document).on("change","#wpfilmlist-ratings-select-bulk-edit", function(event){
    var table;
    var id;
    var rating;
    boxes = jQuery('.wpfilmlist-bulk-edit-checkbox');
    reloadInt = 0;
    indexer = 0;
    boxes.each(function(){
      if(jQuery(this).prop('checked') == true){
        reloadInt = reloadInt+1;
      }
    });

    boxes.each(function(){
      if(jQuery(this).prop('checked') == true){
        table = jQuery(this).attr('data-table');
        id = jQuery(this).val();
        rating = jQuery('#wpfilmlist-ratings-select-bulk-edit').val();

        var data = {
          'action': 'wpfilmlist_bulk_rate_action',
          'id': id,
          'table':table,
          'rating':rating,
          'security': '<?php echo wp_create_nonce( "wpfilmlist_bulk_rate_action" ); ?>'
        };

        indexer++;
        jQuery.post(ajaxurl, data, function(response) {
          if(reloadInt == indexer){
            document.location.reload();
          }
        });
      }
    });
  });
  </script> <?php
}

function wpfilmlist_bulk_rate_action_callback() {
  // Grabbing the existing options from DB
  global $wpdb;
  check_ajax_referer( 'wpfilmlist_bulk_rate_action', 'security' );
  $table_name = filter_var($_POST['table'], FILTER_SANITIZE_STRING);
  $rating = filter_var($_POST['rating'], FILTER_SANITIZE_STRING);
  $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);

  $data = array(
        'myfilmrating' => $rating
  );
  $format = array( '%d'); 
  $where = array( 'ID' => $id );
  $where_format = array( '%d' );
  $wpdb->update( $table_name, $data, $where, $format, $where_format );


  echo $rating;
  wp_die(); // this is required to terminate immediately and return a proper response
}


function wpfilmlist_bulk_notes_action_javascript() { ?>
 <script type="text/javascript" >
 
  jQuery(document).on("click","#wpfilmlist-notes-select-bulk-edit", function(event){
    var table;
    var id;
    var rating;
    var append;
    boxes = jQuery('.wpfilmlist-bulk-edit-checkbox');
    reloadInt = 0;
    indexer = 0;
    boxes.each(function(){
      if(jQuery(this).prop('checked') == true){
        reloadInt = reloadInt+1;
      }
    });

    boxes.each(function(){
      if(jQuery(this).prop('checked') == true){
        table = jQuery(this).attr('data-table');
        id = jQuery(this).val();
        notes = jQuery('#wpfilmlist-notes-select-bulk-textarea').val();
        if(jQuery('#wpfilmlist-notes-select-bulk-textarea-append').prop('checked') == true){
          append = 'true';
        }

        var data = {
          'action': 'wpfilmlist_bulk_notes_action',
          'id': id,
          'table':table,
          'notes':notes,
          'append':append,
          'security': '<?php echo wp_create_nonce( "wpfilmlist_bulk_notes_action" ); ?>'
        };

        indexer++;
        jQuery.post(ajaxurl, data, function(response) {
          if(reloadInt == indexer){
            document.location.reload();
          }
        });
      }
    });
  });
  </script> <?php
}

function wpfilmlist_bulk_notes_action_callback() {
  // Grabbing the existing options from DB
  global $wpdb;
  check_ajax_referer( 'wpfilmlist_bulk_notes_action', 'security' );
  $table_name = filter_var($_POST['table'], FILTER_SANITIZE_STRING);
  $notes = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);
  $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
  $append = filter_var($_POST['append'], FILTER_SANITIZE_STRING);

  if($append == 'true'){
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", $id ));
    $notes = $results[0]->notes.' '.$notes;
  }

  $data = array(
        'notes' => $notes
  );
  $format = array( '%s'); 
  $where = array( 'ID' => $id );
  $where_format = array( '%d' );
  echo $wpdb->update( $table_name, $data, $where, $format, $where_format );


  //echo $append;
  wp_die(); // this is required to terminate immediately and return a proper response
}

function wpfilmlist_bulk_edit_form_checks_action_javascript() { ?>
 <script type="text/javascript" >
 
  jQuery(document).on("change",".wpfilmlist-bulk-edit-checkbox", function(event){
    jQuery('#wpfilmlist-bulk-delete-button').prop("disabled", false);
    jQuery('#wpfilmlist-ratings-select-bulk-edit').prop("disabled", false);
    jQuery('#wpfilmlist-edit-notes-bulk-textarea').prop("disabled", false);
  });

  jQuery(document).on("change paste keyup","#wpfilmlist-edit-notes-bulk-textarea", function(event){
    if(jQuery('#wpfilmlist-edit-notes-bulk-textarea').val() != 'Enter Notes About your Entries Here'){
      jQuery('#wpfilmlist-notes-select-bulk-textarea-append').prop("disabled", false);
      jQuery('#wpfilmlist-notes-select-bulk-edit').prop("disabled", false);
    }
  });
  </script> <?php
}

// Creating the widget 
class wpfilmlist_jre_film_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpfilmlist_jre_film_widget', 

// Widget name will appear in UI
__('WPFilmList Widget', 'wpfilmlist_jre_film_widget_domain'), 

// Widget description
array( 'description' => __( 'A Widget for the WPFilmList Plugin', 'wpfilmlist_jre_film_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
//echo $args['before_widget'];
if ( ! empty( $title ) )
//echo $args['before_title'] . $title . $args['after_title'];
// This is where you run the code and display the output
//echo __( '', 'wpfilmlist_jre_film_widget_domain' );
//echo $args['after_widget'];

global $wpdb;
include_once( plugin_dir_path( __FILE__ ) . 'savedfilmactions.php');
$path = esc_url(plugins_url( '/assets/img/', __FILE__));

// Getting/creating quotes
$table_name_quotes = $wpdb->prefix . 'wpfilmlist_jre_movie_quotes';
$quote_results = $wpdb->get_results("SELECT * FROM $table_name_quotes WHERE placement = 'film'");
$count = ($wpdb->get_var("SELECT COUNT(*) FROM $table_name_quotes WHERE placement = 'film'")-1);
$table_name_options = $wpdb->prefix . 'wpfilmlist_jre_user_options';
$options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name_options WHERE ID = %d", 1));
$hidequotefilm = $options_row[0]->hidequotefilm;
if($hidequotefilm == null){
  $hidequotefilm = 'true';
} else {
  $hidequotefilm = 'false';
}
$quote_num = rand(0,$count);
$quote_actual = $quote_results[$quote_num]->quote;
$pos = strpos($quote_actual,'" - ');
$attribution = substr($quote_actual, $pos);
$quote = substr($quote_actual, 0, $pos);

$quote = str_replace('"','####', $quote);
$quote = str_replace("'",'###', $quote);

$attribution = str_replace('"','####', $attribution);
$attribution = str_replace("'",'###', $attribution);

$table_name = $wpdb->prefix."wpfilmlist_jre_saved_film_log";
$saved_film = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE title = %s", $title));
if(sizeof($saved_film) > 0){
  $filmcoverimage = $saved_film->coverurl;
  $film_title = $saved_film->title;
  ?> <div id="wpfilmlist_widget_container_div"> <?php
  if($filmcoverimage == null){
    ?><img data-quoteshow="<?php echo $hidequotefilm; ?>" data-quote="<?php echo $quote ?>" data-attribution="<?php echo $attribution; ?>" data-table="<?php echo $table_name ?>" data-backdrop="<?php echo $saved_film->backdropurl; ?>" class="wpfilmlist_cover_image_class" id="wpfilmlist_cover_image" src="<?php echo plugins_url( '/assets/img/image_unavaliable.png', __FILE__ ); ?>"/><span class="hidden_id_title"><?php echo $saved_film->ID; ?></span><p data-quoteshow="<?php echo $hidequotefilm; ?>" data-quote="<?php echo $quote ?>" data-attribution="<?php echo $attribution; ?>" data-table="<?php echo $table_name ?>" data-backdrop="<?php echo $saved_film->backdropurl; ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($saved_film->title)); ?><span class="hidden_id_title"><?php echo $saved_film->ID;?></span></p><?php
  } else {
    ?><img data-quoteshow="<?php echo $hidequotefilm; ?>" data-quote="<?php echo $quote ?>" data-attribution="<?php echo $attribution; ?>" data-table="<?php echo $table_name ?>" data-backdrop="<?php echo $saved_film->backdropurl; ?>" class="wpfilmlist_cover_image_class" id="wpfilmlist_cover_image" src=<?php echo '"'. $saved_film->coverurl.'"'; ?> /><span class="hidden_id_title"><?php echo $saved_film->ID ?></span><p data-quoteshow="<?php echo $hidequotefilm; ?>" data-quote="<?php echo $quote ?>" data-attribution="<?php echo $attribution; ?>" data-table="<?php echo $table_name ?>" data-backdrop="<?php echo $saved_film->backdropurl ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($saved_film->title)); ?><span class="hidden_id_title"><?php echo $saved_film->ID?></span></p><?php
  } ?>
  <span style="display:none;"><?php echo $saved_film->ID; ?></span>
  </div>
  <?php
} else {
  $table_name2 = $wpdb->prefix . 'wpfilmlist_jre_list_dynamic_db_names';
  $dynamictables = $wpdb->get_results("SELECT * FROM $table_name2");
  foreach($dynamictables as $dtab){
    $table_name3 = $wpdb->prefix . 'wpfilmlist_jre_'.$dtab->user_table_name;
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name3 ORDER BY title ASC");
    if($count > 0){
      $saved_film = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name3 WHERE title = %s", $title));
      ?> <div id="wpfilmlist_widget_container_div"> <?php
      $filmcoverimage = $saved_film->coverurl;
      $film_title = $saved_film->title;
      if($filmcoverimage == null){
        ?> <img data-quoteshow="<?php echo $hidequotefilm; ?>" data-quote="<?php echo $quote ?>" data-attribution="<?php echo $attribution; ?>" data-table="<?php echo $table_name3 ?>" data-backdrop="<?php echo $saved_film->backdropurl; ?>" class="wpfilmlist_cover_image_class" id="wpfilmlist_cover_image" src="<?php echo plugins_url( '/assets/img/image_unavaliable.png', __FILE__ ); ?>"/><span class="hidden_id_title"><?php echo $saved_film->ID; ?></span><p data-quoteshow="<?php echo $hidequotefilm; ?>" data-quote="<?php echo $quote ?>" data-attribution="<?php echo $attribution; ?>" data-table="<?php echo $table_name3 ?>" data-backdrop="<?php echo $saved_film->backdropurl; ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($saved_film->title)); ?><span class="hidden_id_title"><?php echo $saved_film->ID;?></span></p><?php
      } else {
        ?><img data-quoteshow="<?php echo $hidequotefilm; ?>" data-quote="<?php echo $quote ?>" data-attribution="<?php echo $attribution; ?>" data-table="<?php echo $table_name3 ?>" data-backdrop="<?php echo $saved_film->backdropurl; ?>" class="wpfilmlist_cover_image_class" id="wpfilmlist_cover_image" src=<?php echo '"'. $saved_film->coverurl.'"'; ?> /><span class="hidden_id_title"><?php echo $saved_film->ID ?></span><p data-quoteshow="<?php echo $hidequotefilm; ?>" data-quote="<?php echo $quote ?>" data-attribution="<?php echo $attribution; ?>" data-table="<?php echo $table_name3 ?>" data-backdrop="<?php echo $saved_film->backdropurl ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($saved_film->title)); ?><span class="hidden_id_title"><?php echo $saved_film->ID?></span></p><?php
      } ?>
      <span style="display:none;"><?php echo $saved_film->ID; ?></span>
      </div>
      <?php
    }
  }
}

}
    
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpfilmlist_jre_film_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<select class="wpfilmlist-widget-drop-down-box-class" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>">
<?php
global $wpdb;
$table_name = $wpdb->prefix."wpfilmlist_jre_saved_film_log";
$count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name ORDER BY title ASC");
$alltitles = $wpdb->get_results("SELECT * FROM $table_name ORDER BY title ASC");
$table_name2 = $wpdb->prefix . 'wpfilmlist_jre_list_dynamic_db_names';
$dynamictables = $wpdb->get_results("SELECT * FROM $table_name2");

if($count > 0){
  echo '<optgroup label="From the Default Library  ">';
  foreach($alltitles as $dtab){
    $displayname = ucfirst($dtab->user_table_name);
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY title ASC");
    if(stripslashes($dtab->title) == $title){
      echo '<option selected data-id="'.$dtab->ID.'">'.stripslashes($dtab->title).'</option>';
    } else {
      echo '<option data-id="'.$dtab->ID.'">'.stripslashes($dtab->title).'</option>';
    }
  }
}

foreach($dynamictables as $dtab){
  $table_name3 = $wpdb->prefix . 'wpfilmlist_jre_'.$dtab->user_table_name;
  $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name3 ORDER BY title ASC");
  if($count > 0){
    $displayname = ucfirst($dtab->user_table_name);
    echo '<optgroup label="From the \''.$displayname.'\' Library  ">';
    $results = $wpdb->get_results("SELECT * FROM $table_name3 ORDER BY title ASC");
    foreach($results as $key=>$r){
      if(stripslashes($r->title) == $title){
        echo '<option selected data-id="'.$r->ID.'">'.stripslashes($r->title).'</option>';
      } else {
        echo '<option data-id="'.$r->ID.'">'.stripslashes($r->title).'</option>';
      }
    }
  }
}
?>
</select>
</p>
<?php 
}
  
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
} // Class wpfilmlist_jre_film_widget ends here

// Register and load the widget
function wpfilmlist_jre_for_widget_functionality() {
  register_widget( 'wpfilmlist_jre_film_widget' );
}
















?>
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( is_user_logged_in() ) {
    
} else {
    exit;
}
function page_tabs($current = 'first') {
    $tabs = array(
        'first'   => __("General Settings", 'plugin-textdomain'), 
        'second'  => __("Bulk Editing", 'plugin-textdomain'),
        'third'  => __("WPFilmList Premium", 'plugin-textdomain'),
        'fourth'  => __("StylePaks", 'plugin-textdomain'),
        'fifth'  => __("Other Plugins", 'plugin-textdomain'),
        'sixth'  => __("Donate", 'plugin-textdomain'),
        'seventh'  => __("Review & Get Involved!", 'plugin-textdomain')
    );
    $html =  '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ($tab == $current) ? 'nav-tab-active' : '';
        $html .=  '<a class="nav-tab ' . $class . '" href="?page=WP-Film-List-Options&tab=' . $tab . '">' . $name . '</a>';
    }
    $html .= '</h2>';
    echo $html;
}

// Code displayed before the tabs (outside)
// Tabs
$tab = (!empty($_GET['tab']))? esc_attr($_GET['tab']) : 'first';
page_tabs($tab);

switch ($tab) {
    case "first":
         // Grabbing the existing options from DB
      global $wpdb;
      $table_name2 = $wpdb->prefix . 'wpfilmlist_jre_list_dynamic_db_names';
      $db_row = $wpdb->get_results("SELECT * FROM $table_name2");
      $check_table_name = 'wpfilmlist_jre_list_dynamic_db_names';
      $table_name = $wpdb->prefix . 'wpfilmlist_jre_user_options';
      $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", 1));
      ?>
      <div id="wpfilmlist-top-backend-div">
      <form class="wpfilmlist-backend-form-style" id="wpfilmlist-jre-display-options" action="">
      <div id="wpfilmlist-jre-backend-display-options">
        <p><span id="wpfilmlist-display-title">Display Options</span></p>
        <table id="wpfilmlist-jre-backend-options-table">
          <tbody>
            <tr>
              <td><label>Hide 'Search for Title' Area</label></td>
              <td><input type="checkbox" name="hide-add-a-film"<?php if($options_row[0]->hideaddfilm != null){echo esc_attr('checked="checked"');}?> ></input></td>
              <td><label>Hide the Search area</label></td>
              <td><input type="checkbox" name="hide-search"<?php if($options_row[0]->hidesearch != null){echo esc_attr('checked="checked"');}?> ></input></td>
            </tr>
            <tr>
              <td><label>Hide the Statistics Area</label></td>
              <td><input type="checkbox" name="hide-stats-area"<?php if($options_row[0]->hidestats != null){echo esc_attr('checked="checked"');}?> ></input></td>
              <td><label>Hide the 'Edit' and 'Delete' options</label></td>
              <td><input type="checkbox" name="hide-edit-delete"<?php if($options_row[0]->hideeditdelete != null){echo esc_attr('checked="checked"');}?> ></input></td>
            </tr>
            <tr style="display:none;">
              <td><label>Hide the 'Sort By...' drop-down box</label></td>
              <td><input type="checkbox" name="hide-sort-by"<?php if($options_row[0]->hidesortby != null){echo esc_attr('checked="checked"');}?> ></input></td>
              <td><label>Hide 'Backup and Download Film List'</label></td>
              <td><input type="checkbox" name="hide-backup-download"<?php if($options_row[0]->hidebackupdownload != null){echo esc_attr('checked="checked"');}?> ></input></td>
            </tr>
            <tr>
          <td><label>Hide the Facebook Share Button</label></td>
          <td><input type="checkbox" name="hide-facebook"<?php if($options_row[0]->hidefacebook != null){echo esc_attr('checked="checked"');}?> ></input></td>
           <td><label>Hide the Facebook Messenger Button</label></td>
          <td><input type="checkbox" name="hide-messenger"<?php if($options_row[0]->hidemessenger != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
          <td><label>Hide the Google+ Share Button</label></td>
          <td><input type="checkbox" name="hide-googleplus"<?php if($options_row[0]->hidegoogleplus != null){echo esc_attr('checked="checked"');}?> ></input></td>
          <td><label>Hide the Pinterest Share Button</label></td>
          <td><input type="checkbox" name="hide-pinterest"<?php if($options_row[0]->hidepinterest != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
           <td><label>Hide the Twitter Share Button</label></td>
          <td><input type="checkbox" name="hide-twitter"<?php if($options_row[0]->hidetwitter != null){echo esc_attr('checked="checked"');}?> ></input></td>
          <td><label>Hide the Film Notes</label></td>
          <td><input type="checkbox" name="hide-notes"<?php if($options_row[0]->hidenotes != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
          <td><label>Hide the Images area</label></td>
          <td><input type="checkbox" name="hide-images"<?php if($options_row[0]->hideimages != null){echo esc_attr('checked="checked"');}?> ></input></td>
          <td><label>Hide the Film Description</label></td>
          <td><input type="checkbox" name="hide-description"<?php if($options_row[0]->hidedescription != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
         <td><label>Hide the Email Share Button</label></td>
          <td><input type="checkbox" name="hide-email"<?php if($options_row[0]->hideemail != null){echo esc_attr('checked="checked"');}?> ></input></td>
        <td><label>Hide the Advertisment Area</label></td>
        <td><input type="checkbox" name="hide-quote-film"<?php if($options_row[0]->hidequotefilm!= null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr style="display:none;">
               <td><label>Hide the Top Purchase Links</label></td>
        <td><input type="checkbox" name="hide-top-purchase"<?php if($options_row[0]->hidetoppurchase != null){echo esc_attr('checked="checked"');}?> ></input></td>
        <td><label>Hide the Cast area</label></td>
        <td><input type="checkbox" name="hide-cast"<?php if($options_row[0]->hidecast!= null){echo esc_attr('checked="checked"');}?> ></input></td>
        <td><label>Hide the Crew area</label></td>
        <td><input type="checkbox" name="hide-crew"<?php if($options_row[0]->hidecrew != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
         <td><label>Hide the Links area</label></td>
          <td><input type="checkbox" name="hide-links"<?php if($options_row[0]->hidelinks != null){echo esc_attr('checked="checked"');}?> ></input></td>
        <td><label>Hide the Bottom Purchase Links</label></td>
        <td><input type="checkbox" name="hide-bottom-purchase"<?php if($options_row[0]->hidebottompurchase != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
        <td><label>Hide the Videos area</label></td>
        <td><input type="checkbox" name="hide-videos"<?php if($options_row[0]->hidevideos != null){echo esc_attr('checked="checked"');}?> ></input></td>
        <td><label>Hide the Tagline</label></td>
        <td><input type="checkbox" name="hide-tagline"<?php if($options_row[0]->hidetagline != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
        <td><label>Set Films Per Page</label></td>
        <td><input class="wpfilmlist-dynamic-input" id="wpfilmlist-film-control" type="text" name="films-per-page" value="<?php echo esc_attr($options_row[0]->filmsonpage); ?>"></input></td>
      </tr>
      <tr style="display:none;">
      <td><label>Set Default Sorting</label></td>
        <td>
          <select name="sort-value" id="wpfilmlist-jre-sorting-select">
            <option <?php if ($options_row[0]->sortoption == 'default'){ echo 'selected="selected"'; }   ?> value="default">Default</option>
            <option <?php if ($options_row[0]->sortoption == 'alphabetically'){ echo 'selected="selected"'; }   ?> value="alphabetically">Alphabetically</option>
            <option <?php if ($options_row[0]->sortoption == 'year_released'){ echo 'selected="selected"'; }   ?> value="year_released">Year Released</option>
          </selct>
        </td>
      </tr>
          </tbody>
        </table>
        <button id="wpfilmlist-save-backend" name="save-backend" type="button">Save Changes</button>
      </div>
      </form> 

      <form class="wpfilmlist-backend-form-style" id="wpfilmlist-dynamic-shortcode-db" action="">
        <div class="wpfilmlist-only-with-premium">Only Available With WPFilmList Premium. <br><a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium Now!</a></div>
        <div style="opacity:0.2;" id="wpfilmlist-dynamic-shortcode-div">
          <p id="wpfilmlist-use-shortcodes">Add Your Amazon Affiliate ID</p>
          <table style="width: 100%;">
          <tbody>
          <?php if($options_row[0]->amazonaff == 'wpfilmlistid-20'){ ?>
          <tr><td><input disabled type="text" value="Add Your Affiliate ID Here..." class="wpfilmlist-amazon-affiliate-input" id="wpfilmlist-amazon-affiliate-library" name="wpfilmlist-affiliate-input"></input></td><td><button id="wpfilmlist-amazon-affiliate-button" type="button" disabled="true">Add Affiliate ID</button></td></tr>
          <?php } else {
            ?>
            <tr><td><input disabled type="text" value=" <?php echo $options_row[0]->amazonaff; ?>" class="wpfilmlist-amazon-affiliate-input" id="wpfilmlist-amazon-affiliate-library" name="wpfilmlist-affiliate-input"></input></td><td><button id="wpfilmlist-amazon-affiliate-button" type="button" disabled="true">Add Affiliate ID</button></td></tr>
            <?php
          } ?>
          </tbody>
          </table>
        </div>
      </form>

      <form class="wpfilmlist-backend-form-style" id="wpfilmlist-dynamic-shortcode-db" action="">
        <div id="wpfilmlist-dynamic-shortcode-div">
          <p id="wpfilmlist-use-shortcodes">Use these Shortcodes below to display your different libraries, or create a new Library</p>
          <table>
          <tbody>
          <tr colspan="2"><td colspan="2"><p><span class="wpfilmlist-jre-cover-shortcode-class">[wpfilmlist_shortcode]</span> - default shortcode for displaying the default library with default options</p></td></tr>
          <tr colspan="2"><td colspan="2" style="width: 100%;"><p><span class="wpfilmlist-jre-cover-shortcode-class">[showfilmcover]</span> - Shortcode for displaying an individual entry. The options below only apply to the [showfilmcover] shortcode, and not the [wpfilmlist_shortcode] shortcode.</p>
            <ul style="list-style: disc; margin-left: 20px;">
              <li><span class="wpfilmlist-jre-cover-shortcode-class">Specify a movie/tv show:</span> title="xxxxxxxxxxxxx"</li>
              <li><span class="wpfilmlist-jre-cover-shortcode-class">Set alignment:</span> align="left"  <span style="font-style:italic;">or </span>align="right"</li>
              <li><span class="wpfilmlist-jre-cover-shortcode-class">Specify library:</span> table="nameoflibrary" (leave out completely to use default library)</li>
              <li><span class="wpfilmlist-jre-cover-shortcode-class">Set the size:</span> width="100"</li>
              <li><span class="wpfilmlist-jre-cover-shortcode-class">Set as Amazon Image link:</span> amazon="true"</li>
              <li><span class="wpfilmlist-jre-cover-shortcode-class">Display the title:</span> showtitle="true"</li>
            </ul>
          </td></tr>
          <tr colspan="2"><td colspan="2" style="text-align:left;"><strong>Example One:</strong> To display a just an entry (without the title) from your custom 'fantasy' library on the left side of a page or post, with a size of 150, this shortcode would do the trick: </br></br><span style="text-align:center;" class="wpfilmlist-jre-cover-shortcode-class">[showfilmcover title="Harry Potter and the Sorcerer's Stone" align="left" width="150" table="fantasy"]</span></td></tr>
          <tr colspan="2"><td colspan="2" style="text-align:left; top:15px; position:relative;"><strong>Example Two:</strong> To display an entry from the default library, as an Amazon Image link, on the right side of a page or post, with a size of 200, with the title displayed below the image, this shortcode would do the trick: </br></br><span style="text-align:center;" class="wpfilmlist-jre-cover-shortcode-class">[showfilmcover title="Harry Potter and the Sorcerer's Stone" align="right" width="200" amazon="true" showtitle="true"]</span></td></tr>
          <tbody>
          <tr colspan="2"><td colspan="2"><p id="wpfilmlist-use-shortcodes"></p></td></tr>
          
          <?php
          $counter = 0;
          
          foreach($db_row as $db){
            $counter++;
            ?><tr><td><p><?php if(($db->user_table_name != "") || ($db->user_table_name != null)){ echo esc_html('[' .'wpfilmlist_shortcode table="'.$db->user_table_name.'"]');?></p></td><td><button id="<?php echo esc_attr($db->user_table_name.'_'.$counter);?>" class="wpfilmlist_delete_custom_lib" type="button" >Delete Library</button></td></tr><?php }
          }
          
          ?>
          <tr><td><input type="text" value="Create a New Library Here..." class= "wpfilmlist-dynamic-input" id="wpfilmlist-dynamic-input-library" name="wpfilmlist-dynamic-input"></input></td><td><button id="wpfilmlist-dynamic-shortcode-button" type="button" disabled="true">Create New Library</button></td></tr>
          </tbody>
          </table>
        </div>
      </form>
      <form class="wpfilmlist-backend-form-style">
        <p id="wpfilmlist-use-shortcodes">Backup & Restore Your Movie & TV Show Libraries</p>
        <p class="wpfilmlist-backup-restore-subhead">Create a Backup</p>
          <select id="wpfilmlist-table-select-backup-dropdown">
            <option disabled selected>Select a Library to Backup & Download...</option>
            <option data-tabletext="Default" value="<?php echo $wpdb->prefix; ?>wpfilmlist_jre_saved_film_log">Default</option>
            <?php 
            $table_name = $wpdb->prefix . 'wpfilmlist_jre_list_dynamic_db_names';
            $db_row = $wpdb->get_results("SELECT * FROM $table_name");
            $actual_link = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $upload_path = wp_upload_dir(); 
            $upload_path = $upload_path["basedir"]; 
            foreach($db_row as $key=>$dyn_table){
              echo '<option data-tabletext="'.$dyn_table->user_table_name.'" value="'.$wpdb->prefix.'wpfilmlist_jre_'.$dyn_table->user_table_name.'">'.ucfirst($dyn_table->user_table_name).'</option>';
            }
            ?>
          </select>
          <a id="wpfilmlist-backup-download-link" style="pointer-events:none" href="<?php echo $actual_link; ?>" id="wpfilmlist_export_link">Backup and Download Selected Library</a>
          <p class="wpfilmlist-backup-restore-subhead">Restore From a Backup</p>
          <p id="wpfilmlist_download_id_p">First choose a backup, and then choose the Library to apply that backup to. Note that this will completely erase the selected Library and replace it with the information contained within the backup. There is no undoing this action.</p>
          <select id="wpfilmlist_select_backup_box" name="cars">    
            <option value="notyet">Choose a Backup...</option><?php
            $file_to_create = glob( $upload_path.'/wpfilmlist/backups/*.*' );
            array_multisort(array_map( 'filemtime', $file_to_create ),SORT_NUMERIC,SORT_ASC,$file_to_create);
                foreach($file_to_create as $filename){
                    $filename = substr($filename,10);
                    $filename = str_replace('_', " ", $filename);
                    $filename = str_replace('.xlsx', "", $filename);
                    $filename = trim(substr($filename, strrpos($filename, '/') + 1));
                    ?><option id="<?php echo htmlspecialchars($filename); ?>" value="<?php echo htmlspecialchars($filename); ?>"><?php echo $filename; ?></option><?php
                } ?>
          </select>
          <select id="wpfilmlist-table-select-backup-dropdown-restore">
            <option value="notyet">Select Which Library to Restore...</option>
            <option data-tabletext="Default" value="<?php echo $wpdb->prefix; ?>wpfilmlist_jre_saved_film_log">Default</option>
            <?php
            foreach($db_row as $key=>$dyn_table){
              echo '<option data-tabletext="'.$dyn_table->user_table_name.'" value="'.$wpdb->prefix.'wpfilmlist_jre_'.$dyn_table->user_table_name.'">'.ucfirst($dyn_table->user_table_name).'</option>';
            }
            ?>
          </select>
          <a id="wpfilmlist-backup-restore-link" style="pointer-events:none" href="<?php echo $actual_link; ?>" id="wpfilmlist_export_link">Restore Selected Library from Selected Backup File</a>

      </form>
      <form class="wpfilmlist-backend-form-style">
        <div id="wpfilmlist-forward-creation-logo">
        <div id="wpfilmlist-visit-me">Visit Me At:</div>
        <a target="_blank" id="wpfilmlist-jakes-site" href="http://www.jakerevans.com"><img src="<?php echo plugins_url('/assets/img/JakesSite.png', __FILE__); ?>" /></a>
        </div>
        <p id="email-me">E-mail me with questions, issues, concerns, suggestions, or anything else at <a href="mailto:jake@jakerevans.com">Jake@Jakerevans.com</a></p>
        </div>
      </form>

      <?php         
    break;
    case "second":
      global $wpdb;

      $table_name = $wpdb->prefix."wpfilmlist_jre_saved_film_log";
      $alltitles = $wpdb->get_results("SELECT * FROM $table_name ORDER BY title ASC");
      $table_name2 = $wpdb->prefix . 'wpfilmlist_jre_list_dynamic_db_names';
      $dynamictables = $wpdb->get_results("SELECT * FROM $table_name2");
      ?>
      <form class="wpfilmlist-backend-form-style" id="wpfilmlist-bulk-edit-top-form" action="">
        <div class="wpfilmlist-only-with-premium">Only Available With WPFilmList Premium. <br><a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium Now!</a></div>
        <div style="opacity:0.2" id="wpfilmlist-dynamic-shortcode-div">
          <p id="wpfilmlist-use-shortcodes">Check the boxes next to the titles you'd like to edit, then select the type of edit below</p>
          <p class="wpfilmlist-bulk-edit-header">Entries from the Default library:</p>
          <table class="wpfilmlist-bulk-edit-table">
          <tbody>
            <tr>
            <?php
            foreach($alltitles as $key=>$indiv){
              echo '<td class="wpfilmlist-bulk-edit-checkboxes-td"><input disabled class="wpfilmlist-bulk-edit-checkbox" type="checkbox" value="'.$indiv->ID.'" data-table="'.$table_name.'" />'.stripslashes($indiv->title).'  </td><td>     </td>';
              if($key%2 == 0){
                echo '</tr><tr>';
              }
            }

            ?></tbody></table><?php

            foreach($dynamictables as $dtab){
              $table_name3 = $wpdb->prefix . 'wpfilmlist_jre_'.$dtab->user_table_name;
              $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name3 ORDER BY title ASC");
              if($count > 0){
                echo "<p class='wpfilmlist-bulk-edit-header'>Entries from the '".$dtab->user_table_name."' library:</p>";
                ?><table class="wpfilmlist-bulk-edit-table"><tbody><?php
                $results = $wpdb->get_results("SELECT * FROM $table_name3 ORDER BY title ASC");
                ?> <tr> <?php
                foreach($results as $key=>$r){
                   echo '<td class="wpfilmlist-bulk-edit-checkboxes-td"><input disabled class="wpfilmlist-bulk-edit-checkbox" type="checkbox" value="'.$r->ID.'" data-table="'.$table_name3.'" />'.stripslashes($r->title).'  </td><td>     </td>';
                  if($key%2 == 0){
                    echo '</tr><tr>';
                  }
                } ?>
                </tbody>
                </table> <?php
              }
            }
            ?>
            <p id="wpfilmlist-bulk-edit-actions">Bulk Edit Actions</p>
            <div class="wpfilmlist-bulk-edit-actions-div">
              <div>
                <input disabled type="button" value="Permanently Delete all Checked Entries" id="wpfilmlist-bulk-delete-button" />
              </div>
              <div>
                <select disabled id="wpfilmlist-ratings-select-bulk-edit">
                  <option selected disabled="disabled">Rate Checked Entries</option>
                  <option disabled value="5">5 Stars</option>
                  <option disabled value="4">4 Stars</option>
                  <option disabled value="3">3 Stars</option>
                  <option disabled value="2">2 Stars</option>
                  <option disabled value="1">1 Star</option>
                </select>
              </div>
              <div>
                <input disabled id="wpfilmlist-edit-notes-bulk-textarea" value="Enter Notes About Your Entries Here" type="textarea" id="wpfilmlist-notes-select-bulk-textarea"   /><br>
                <input disabled id="wpfilmlist-notes-select-bulk-textarea-append" type="checkbox" /><label>Add to Existing Notes?</label><br>
                <input disabled type="button" value="Edit Notes" id="wpfilmlist-notes-select-bulk-edit" />
              </div>
            </div>
        </div>
      </form>
      <form style="width:700px;" class="wpfilmlist-backend-form-style">
      <div id="wpfilmlist-forward-creation-logo">
      <div id="wpfilmlist-visit-me">Visit Me At:</div>
      <a target="_blank" id="wpfilmlist-jakes-site" href="http://www.jakerevans.com"><img src="<?php echo plugins_url('/assets/img/JakesSite.png', __FILE__); ?>" /></a>
      </div>
      <p id="email-me">E-mail me with questions, issues, concerns, suggestions, or anything else at <a href="mailto:jake@jakerevans.com">Jake@Jakerevans.com</a></p>
      </form>
     <?php
    break;
    case "third":
        ?>
        <div id="wpfilmlist-top-app-notice" class="wpfilmlist-backend-form-style">
        <p id="wpfilmlist-top-app-p"><span id="wpfilmlist-display-title">Get wpfilmlist Premium now and receive these features:</span></p>
        <div id="wpfilmlist-premium-features-div1">
          <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/" target="_blank"><img width="175" style="position:relative; float:left;" src="<?php echo plugins_url('/assets/img/wpfilmlistPremium.png', __FILE__); ?>" /></a>
        </div>
        <div id="wpfilmlist-premium-features-div2">
          <ul id="wpfilmlist-premium-features-list">
            <li>- Add your Amazon Affiliate ID to each Film & TV Show you display</li>
            <li>- Display famous quotes from films and industry insiders</li>
            <li>- Edit multiple entries at once, saving you time and effort </li>
            <li>- Rate each title and display your rating with attractive rating stars</li>
            <li>- Set the default sorting method site-wide</li>
            <li>- Receive Additional Display Options</li>
          </ul>
        </div>
        <div>

          
        </div>
        <div id="wpfilmlist-purchase-line"></div>
        <div id="wpfilmlist-premium-features-div3">
          <p>Get all of the awesome functionality of the free version, plus the features listed above <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/" target="_blank"> right now for <span id="wpfilmlist-purchase-money">just $5 Dollars!</span></a> That's only 2 cups of coffee!</p>
        </div>
        <div id="wpfilmlist-premium-features-div4">
          <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/" target="_blank"><img style="width: 200px; margin:10px;" src="<?php echo plugins_url( '/assets/img/wpfilmlistPremPurchase.png', __FILE__ ); ?>"/></a>

        </div>
      </div>
      <form class="wpfilmlist-backend-form-style">
        <div id="wpfilmlist-forward-creation-logo">
        <div id="wpfilmlist-visit-me">Visit Me At:</div>
        <a target="_blank" id="wpfilmlist-jakes-site" href="http://www.jakerevans.com"><img src="<?php echo plugins_url('/assets/img/JakesSite.png', __FILE__); ?>" /></a>
        </div>
        <p id="email-me">E-mail me with questions, issues, concerns, suggestions, or anything else at <a href="mailto:jake@jakerevans.com">Jake@Jakerevans.com</a></p>
      </form>
      <?php
    break;
    case 'fifth':
      ?>
      <div style="float:left" id="wpfilmlist-top-app-notice-wpbooklistfree-advert" class="wpfilmlist-backend-form-style-wpbooklistfree-advert">
      <p id="wpfilmlist-top-app-p-others"><span id="wpfilmlist-display-title">Like Books? Then Check Out WPBookList!</span><br><a href="https://wordpress.org/plugins/wpbooklist/" target="_blank"><img width="175" src="<?php echo plugins_url('/assets/img/WPBooklistIcon.png', __FILE__); ?>" /></a></p>
      <div id="wpfilmlist-premium-features-div1">
      </div>
      <div id="wpfilmlist-purchase-line-20"></div>
      <div id="wpfilmlist-premium-features-div2">
        <p class="wpfilmlist-how-work-other-plugs">How does WPBookList Work?</p>
        <p style="margin: 0px;">Simply plug in the ISBN number of your book and let WordPress Book List scour the internet for all information possible about the title, including:</p>
        <ul style="margin-top: 0px;" id="wpfilmlist-premium-features-list">
          <li>- Cover Image & Amazon Reviews -</li>
          <li>- Editor's Descriptions -</li>
          <li>- Author, Publisher, and Publication dates -</li>
          <li>- Total Pages and Genres -</li>
          <li>- Year you read it, & whether it's signed or a first edition -</li>
        </ul>
        <div id="wpfilmlist-free-wpbooklist-advert-button"><a href="https://wordpress.org/plugins/wpbooklist/">Try It Now!</a></div>
      </div>
      <div>        
      </div>
      <div id="wpfilmlist-purchase-line-2"></div>
      <div id="wpfilmlist-premium-features-div3">
        <p id="wpfilmlist-top-app-p-others" class="wpfilmlist-advert-wpbooklist-prem"><span id="wpfilmlist-display-title">Tried It? Liked It? Want More? Then Get WPBookList Premium!</span><br><a href="https://www.jakerevans.com/product/wordpress-book-list-premium/" target="_blank"><img style="position: relative; top: 15px;" width="175" src="<?php echo plugins_url('/assets/img/WPBookListPremium.png', __FILE__); ?>" /></a></p>
      <div id="wpfilmlist-premium-features-div1">
      </div>
      <div id="wpfilmlist-purchase-line-20"></div>
        <p class="wpfilmlist-how-work-other-plugs">With WPBookList Premium, You Can:</p>
        <ul id="wpfilmlist-premium-features-list-2">
          <li>- Add your Amazon Affiliate ID to each book you display -</li>
          <li>- Import your entire Goodreads library -</li>
          <li>- Get access to the WPBookList Mobile App! -</li>
          <li>- Randomly display classic & famous literary quotes -</li>
          <li>- Rate each title and display the rating for all to see -</li>
          <li>- Display Amazon reviews based on country -</li>
          <li>- Set the default sorting option site-wide -</li>
        </ul>
        <p style="font-weight:bold;">Get all of the awesome functionality of the free version, plus the features listed above <a href="https://www.jakerevans.com/product/wordpress-book-list-premium/" target="_blank"> right now for <span id="wpfilmlist-purchase-money">just $5 Dollars!</span></a> That's only 2 cups of coffee!</p>
        <div id="wpfilmlist-free-wpbooklist-advert-button"><a href="https://www.jakerevans.com/product/wordpress-book-list-premium/">Get It Now!</a></div>
      </div>
      <div id="wpfilmlist-premium-features-div4">
        <a href="https://www.jakerevans.com/product/wordpress-book-list-premium/" target="_blank"><img style="width: 200px; margin:10px;" src="<?php echo plugins_url( '/assets/img/WPBooklistPremPurchase.png', __FILE__ ); ?>"/></a>
        <a href="https://www.jakerevans.com/product/wordpress-book-list-premium/" target="_blank"><img style="width: 200px;" src="<?php echo plugins_url( '/assets/img/WPBookListUpgradeBadges.png', __FILE__ ); ?>"/></a>
      </div>
    </div>



















      <div id="wpfilmlist-top-app-notice-wpgamelistfree-advert" class="wpfilmlist-backend-form-style-wpgamelistfree-advert">
      <p id="wpfilmlist-top-app-p-others"><span id="wpfilmlist-display-title">Like Video Games? Then Check Out WPGameList!</span><br><a href="https://wordpress.org/plugins/wpgamelist/" target="_blank"><img style="width: 140px; margin-top: 10px;" width="140" src="<?php echo plugins_url('/assets/img/WPGamelistIcon.png', __FILE__); ?>" /></a></p>
      <div id="wpfilmlist-premium-features-div1">
      </div>
      <div id="wpfilmlist-purchase-line-20"></div>
      <div id="wpfilmlist-premium-features-div2">
        <p class="wpfilmlist-how-work-other-plugs">How does WPGameList Work?</p>
        <p style="margin: 0px;">Simply plug in the name of your video game and let WordPress Game List scour the internet for all information possible about the title, including:</p>
        <ul style="margin-top: 0px;" id="wpfilmlist-premium-features-list">
          <li>- Cover Images & Screenshots -</li>
          <li>- Trailers & Videos -</li>
          <li>- Summaries & Genres -</li>
          <li>- Release Dates -</li>
          <li>- Publishers & Developers -</li>
        </ul>
        <div style=" position: relative; bottom: 20px;" id="wpfilmlist-free-wpgamelist-advert-button"><a href="https://wordpress.org/plugins/wpgamelist/">Try It Now!</a></div>
      </div>
      <div>        
      </div>
      <div id="wpfilmlist-purchase-line-2"></div>
      <div id="wpfilmlist-premium-features-div3">
        <p id="wpfilmlist-top-app-p-others" class="wpfilmlist-advert-wpbooklist-prem"><span id="wpfilmlist-display-title">Tried It? Liked It? Want More? Then Get WPGameList Premium!</span><br><a href="https://www.jakerevans.com/product/wordpress-game-list-premium/" target="_blank"><img style="position: relative; top: 15px;" width="175" src="<?php echo plugins_url('/assets/img/wpgamelistpremium.png', __FILE__); ?>" /></a></p>
      <div id="wpfilmlist-premium-features-div1">
      </div>
      <div id="wpfilmlist-purchase-line-20"></div>
        <p class="wpfilmlist-how-work-other-plugs">With WPGameList Premium, You Can:</p>
        <ul id="wpfilmlist-premium-features-list-2">
          <li>- Add your Amazon Affiliate ID to each game you display -</li>
          <li>- Add you XBox Live Gamertag to display Achievements -</li>
          <li>- Display a continuously-updated news feed for nearly every title -</li>
          <li>- Display entertaining, random quotes from famous video games and prominent names in the industry -</li>
          <li>- Rate each title and display the rating for all to see -</li>
          <li>- List the alternative names for each title, including foreign languages (Japanese, Chinese, German, Russian, etc.) -</li>
          <li>- ESRB Images are displayed per title -</li>
        </ul>
        <p style="font-weight:bold;">Get all of the awesome functionality of the free version, plus the features listed above <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/" target="_blank"> right now for <span id="wpfilmlist-purchase-money">just $5 Dollars!</span></a> That's only 2 cups of coffee!</p>
        <div id="wpfilmlist-free-wpgamelist-advert-button"><a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get It Now!</a></div>
      </div>
      <div id="wpfilmlist-premium-features-div4">
        <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/" target="_blank"><img style="width: 200px; margin:10px;" src="<?php echo plugins_url( '/assets/img/WPGamelistPremPurchase.png', __FILE__ ); ?>"/></a>
      </div>
    </div>

















    <?php
    break;
    case "fourth":
      global $wpdb;
      $table_name = $wpdb->prefix . 'wpfilmlist_jre_user_options';
      $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", 1));
      ?>
      <form class="wpfilmlist-backend-form-style" id="wpfilmlist-jre-upload-stylepak-form" enctype="multipart/form-data" action="">
        <div id="wpfilmlist-stylepak-top-backend-div">
          <div id="wpfilmlist-jre-backend-display-options">
            <p><span id="wpfilmlist-display-title">wpfilmlist StylePaks</span></p>
            <p style="font-style:italic;">What's a StylePak you ask? StylePaks are the best way to customize the look and feel of your wpfilmlist plugin! Simply head to <a href="https://www.jakerevans.com/shop/">JakeREvans.com</a>, select the StylePak you want, upload it here, and watch as your wpfilmlist plugin is automatically transformed!</br></br><a id="wpfilmlist-stylepaks-purchase-button" href="https://www.jakerevans.com/shop/">Get Your StylePaks Here!</a></br></br></p>
            <select id="wpfilmlist_select_stylepak_box" name="cars">    
                  <option selected disabled>Select a StylePak...</option>
                  <?php if($options_row[0]->stylepak == 'Default'){
                    echo "<option selected='selected'>Default</option>";
                  } else{ echo "<option>Default</option>"; }  ?>
                  
                  <?php 
                    foreach(glob($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/wpfilmlist/stylepak-exports/*.*') as $filename){
                       $pos = strripos($filename, 'exports');
                       $filename = substr($filename,($pos+8));
                       $temp = str_replace('.css', '', $filename); 
                          ?><option id="<?php echo $filename; ?>" <?php if ($options_row[0]->stylepak == $temp){ echo 'selected="selected"'; } ?> value="<?php echo $filename; ?>"><?php echo $temp; ?></option><?php
                       
                    } ?>
              </select>

          </div>
        </div>
        <div style="margin:10px; font-weight:bold; text-align: center; font-style:italic;"> Or </div>
        <input id="wpfilmlist-add-new-stylepak-file" style="display:none;" type="file" id="files" name="files[]" multiple />
        <button id="wpfilmlist-add-new-stylepak-button" onclick="document.getElementById('wpfilmlist-add-new-stylepak-file').click();" name="add-stylepak-file" type="button">Add a New StylePak</button>
        <output id="wpfilmlist-jre-stylepak-list"></output>
      </form>
      <form class="wpfilmlist-backend-form-style">
      <div id="wpfilmlist-forward-creation-logo">
      <div id="wpfilmlist-visit-me">Visit Me At:</div>
      <a target="_blank" id="wpfilmlist-jakes-site" href="http://www.jakerevans.com"><img src="<?php echo plugins_url('/assets/img/JakesSite.png', __FILE__); ?>" /></a>
      </div>
      <p id="email-me">E-mail me with questions, issues, concerns, suggestions, or anything else at <a href="mailto:jake@jakerevans.com">Jake@Jakerevans.com</a></p>
      </form>
      <?php
    break;
    case 'sixth'
      ?>
      <div style="text-align:center;" class="wpfilmlist-backend-form-style">
      <p style="    border-top: 0px;
          border-right: 0px;
          border-left: 0px;
          border-bottom: 1px;
          border-style: solid;" id="wpfilmlist-donate-title"><span id="wpfilmlist-display-title">Donate to WordPress Film List</span></p>
      <p>Development of WordPress Film List is fun, but hard work! Any and all donations are greatly appreciated!</p>
      <p>Half of all donations go straight to educational charities in the US (and the other half pretty much ends up going to Starbucks...)</p>
      <div id="money-links">
      <form style="display:inline-block;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="UWUNZ82VFCAWY">
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
      </form>
      <a target="_blank" id="patreon-link" href="http://patreon.com/user?u=3614120"><img id="wpfilmlist-patreon-img" src="<?php echo plugins_url( '/assets/img/patreon.png', __FILE__ ); ?>" /></a>
      <a href='https://ko-fi.com/A8385C9' target='_blank'><img height='34' style='border:0px;height:34px;' src='<?php echo plugins_url( '/assets/img/kofi1.png', __FILE__ ); ?>' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a>
      <p>And be sure to <a target="_blank" href="https://wordpress.org/support/plugin/wpfilmlist/reviews/">leave a 5-star review of wpfilmlist!</a></p>
      </div>
      </div>
      <form class="wpfilmlist-backend-form-style">
      <div id="wpfilmlist-forward-creation-logo">
      <div id="wpfilmlist-visit-me">Visit Me At:</div>
      <a target="_blank" id="wpfilmlist-jakes-site" href="http://www.jakerevans.com"><img src="<?php echo plugins_url('/assets/img/JakesSite.png', __FILE__); ?>" /></a>
      </div>
      <p id="email-me">E-mail me with questions, issues, concerns, suggestions, or anything else at <a href="mailto:jake@jakerevans.com">Jake@Jakerevans.com</a></p>
      </form>
      <?php
      break;
    case 'seventh':
      ?>
      <div style="text-align:center;" class="wpfilmlist-backend-form-style">
      <p style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 1px; border-style: solid;" id="wpfilmlist-donate-title"><span id="wpfilmlist-display-title">Happy with WPFilmList? Have Suggestions to Make It Even Better?</span></p>
      <p></p>
      <p>If you're happy with WPFilmList, It'd be absolutely fantastic if you could <a href="https://wordpress.org/support/plugin/wpfilmlist/reviews/">leave a 5-star review!</a> It only takes a minute of your time, and it goes a long way towards more downloads and spreading the greatness that is WPFilmList with as many people as possible!  </p>
      <div id="money-links">
      <a href="https://wordpress.org/support/plugin/wpfilmlist/reviews/"><img width="500" src='<?php echo plugins_url( '/assets/img/review-screenshot.png', __FILE__ ); ?>' /></a>
      <a href=""><img  /></a>
      </div>

      <div id="wpfilmlist-purchase-line-2"></div>
      <p id="wpfilmlist-donate-title"><span id="wpfilmlist-display-title">Let your voice be heard on the official WPFilmList Trello Board!</span></p>
      <a target="_blank" href="https://trello.com/invite/b/h7t2LRA5/801c42eda6e5af9f0cf8701c9d379723/wpfilmlist-backlog"><img style="margin-right: auto;margin-left: auto;display: block;" width="300" src='<?php echo plugins_url( '/assets/img/trello.png', __FILE__ ); ?>' /></a>
      <a target="_blank" href=""><img  /></a>
      <a href="https://trello.com/invite/b/h7t2LRA5/801c42eda6e5af9f0cf8701c9d379723/wpfilmlist-backlog">Get Access to the WPFilmList Trello Board!</a>
      </div>
      <form class="wpfilmlist-backend-form-style">
      <div id="wpfilmlist-forward-creation-logo">
      <div id="wpfilmlist-visit-me">Visit Me At:</div>
      <a target="_blank" id="wpfilmlist-jakes-site" href="http://www.jakerevans.com"><img src="<?php echo plugins_url('/assets/img/JakesSite.png', __FILE__); ?>" /></a>
      </div>
      <p id="email-me">E-mail me with questions, issues, concerns, suggestions, or anything else at <a href="mailto:jake@jakerevans.com">Jake@Jakerevans.com</a></p>
      </form>
      <?php
    break;
    default:
}
?>

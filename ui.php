<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Setting up wordpress database queries and variables to be used throughout this file.
// This file controls all the behavior of the main page the user sees their films at.
global $wpdb;
$table_name = filter_var($GLOBALS['a'], FILTER_SANITIZE_STRING);
$genres_count;
$count;
$table_name_options = $wpdb->prefix . 'wpfilmlist_jre_user_options';
$options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name_options WHERE ID = %d", 1));
$hide_edit_delete = $options_row[0]->hideeditdelete;
$hidereview = $options_row[0]->hidereview;
$films_on_page = intval($options_row[0]->filmsonpage);
$sort_id = ''; 
$count = 0;
$persistent_count = 0;
$result = 0;
$tvcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE type = %s", 'TV Show'));
$moviecount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE type = %s", 'Movie'));
$temp = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY ID DESC LIMIT %d", 1));
$table_name_quotes = $wpdb->prefix . 'wpfilmlist_jre_movie_quotes';
$num_of_quotes = ($wpdb->get_var("SELECT COUNT(*) FROM $table_name_quotes")-1);
$quote_results = $wpdb->get_results("SELECT * FROM $table_name_quotes");
$num_of_quotes_film = ($wpdb->get_var("SELECT COUNT(*) FROM $table_name_quotes WHERE placement = 'film'")-1);
$quote_results_film = $wpdb->get_results("SELECT * FROM $table_name_quotes WHERE placement = 'film'");
$hidequotefilm = $options_row[0]->hidequotefilm;
$sort_option = filter_var($options_row[0]->sortoption, FILTER_SANITIZE_STRING);
$sort_id = ''; 

if($hidequotefilm == null){
    $hidequotefilm = 'show';
} else {
    $hidequotefilm = 'hide';
}
if(!empty($temp)){
    $result = filter_var($temp[0]->ID, FILTER_SANITIZE_NUMBER_INT);
    if($result != false){
        $count = $result;
        $persistent_count = $result;
    } else {
    $count = null;
    $persistent_count = null;
    }
}
$sort_id = '';
$hide_edit_delete = $options_row[0]->hideeditdelete;

?>

<div class="wpfilmlist_top_container">
    <div class="gfd"></div>
    <div class="wpfilmlist-table-for-app"><?php echo $table_name; ?></div><p id="specialcaseforappid"></p>
<a id="hidden_link_for_styling" style="display:none"></a>
    <div class="wpfilmlist_sort_box_top_container">
        <div class="wpfilmlist_sort_box_container">
            <div id="wpfilmlist_control_panel_tdiv">
                <div class="wpfilmlist_control_links_and_sort">
                    <?php
                    $genres_count = wpfilmlist_top_three_options($wpdb, $table_name, $count, $options_row);
                    wpfilmlist_search_area($options_row);   
                    wpfilmlist_stat_area($wpdb, $result, $count, $options_row, $tvcount, $moviecount);
                    wpfilmlist_missing_cats($wpdb, $count, $table_name, $genres_count, $options_row, $persistent_count);
                    ?></div></div><?php 
                    if($options_row[0]->hidequotefilm == null){
                        wpfilmlist_quote_area($quote_results, $num_of_quotes, $quote_results_film, $num_of_quotes_film, $hidequotefilm);
                    }
                    wpfilmlist_sort_and_call_films($wpdb, $hide_edit_delete, $sort_id, $count, $films_on_page, $table_name, $sort_option, $hidereview, $options_row);
                    ?></div></div><?php
  function wpfilmlist_top_three_options($wpdb, $table_name, $count, $options_row){
    $genres_count = 0;
                    if($options_row[0]->hideaddfilm == null){
                        if($options_row[0]->hidequotefilm == null){
                            ?> <div class="wpfilmlist-jre-add-film-div"> <?php
                        } else {
                            ?> <div style="height:160px" class="wpfilmlist-jre-add-film-div"> <?php
                        }
                        ?>
                            <input type="text" id="wpfilmlist_title_search" name="isbn" placeholder="Add New Movies & TV Shows Here" />
                            <select id="wpfilmlist-movie-tv-selection">
                                <option>Movie</option>
                                <option>TV</option>
                            </select>
                            <div>
                                <p style="float:left;"><a class="wpfilmlist_control_panel_button" id="wpfilmlist_add_film_link" >Search for Title</a></p>
                                <div id="wpbooklist-movie-proj-animate-div"><img class="wpfilmlist-projector-reel-image" id="wpfilmlist-projector-reel-1" src="<?php echo plugins_url( '/assets/img/moviereel2.png', __FILE__ ); ?>"/>
                                </div>
                            </div>
                        </div>
<!--
                        <div>
                            <a class="wpfilmlist_control_panel_button" id="wpfilmlist_upload_link" >Backup & Download Movie List</a>
                            <select id="wpfilmlist_sort_select_box" name="cars">    
                                <option selected disabled>Sort By...</option>
                                <option value="default">Default</option>
                                <option value="alphabetically">Alphabetically</option>
                                <option value="year_released">Year Released</option>
                                <optgroup label="Genre"><?php
                                    // Code below dynamically adds all the categories that exist into the "sort by" drop-down box, making sure that case of the text ins't an issue and that there aren't duplicate entries
                                $offset = 0;
                                while($count > 0){
                                        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY genres ASC LIMIT {$offset},%d", 100), ARRAY_A);
                                        $genre_array = array();
                                    foreach($results as $b){
                                        $broken_genre = rtrim($b['genres'], ',');
                                        $broken_genre = explode(',', $broken_genre);
                                        foreach($broken_genre as $item2){
                                            if($item2 != ''){
                                                array_push($genre_array, $item2);
                                            }
                                        }
                                        $genre_array = array_unique($genre_array);
                                    }
                                    foreach($genre_array as $indivgenre){
                                        echo '<option value="cat'.esc_attr($indivgenre).'">'.esc_attr($indivgenre).'</option>';
                                        $genres_count++;
                                    }
                                        $new_array = null;
                                        unset($new_array);
                                        $results = null;
                                        unset($results);
                                    $offset = $offset+100;
                                    $count = $count-100;
                                }
                                $count = $persistent_count;
                               ?>
                                </optgroup> 
                            </select>
                        </div>
-->
                        <?php
                    }?><?php
                    if($options_row[0]->hidebackupdownload == null){
                      
                    }
                    ?>
                    
                    <?php
                    if($options_row[0]->hidesortby == null){
                    ?>
                    <form id="wpfilmlist_select_sort_form" method="post" action="ui.php">
                        
                    </form>
                    <?php
                    } 
return $genres_count;
}


function wpfilmlist_search_area($options_row){
    if($options_row[0]->hidesearch== null){
        ?><div id="wpfilmlist_search_tdiv"><div id="wpfilmlist_search_checkboxes"></div><div><input id="wpfilmlist_search_text" type="text" name="search_query" value="Search..."></div><div id="wpfilmlist_search_submit"><input id="wpfilmlist_search_sub_button" type="button" name="search_button" value="Search"></input></div></div><?php
    }
}



function wpfilmlist_stat_area($wpdb, $result, $count, $options_row, $tvcount, $moviecount){
if($options_row[0]->hidestats == null){
                    ?>
                <div class="wpfilmlist_stats_tdiv">
                    <p class="wpfilmlist_control_panel_stat">Movies: <?php echo number_format($moviecount);?></p>
                    <p class="wpfilmlist_control_panel_stat">TV Shows: <?php echo number_format($tvcount);?></p>
                    <p class="wpfilmlist_control_panel_stat">Total Entries: <?php echo number_format($moviecount + $tvcount);?></p>
                    <?php
}


                  
                                  
             
}

function wpfilmlist_missing_cats($wpdb, $count, $table_name, $genres_count, $options_row, $persistent_count){
if($options_row[0]->hidestats == null){
$offset = 0;
$initial_alert_set = 'false';
?>
<p class="wpfilmlist_control_panel_stat" id="wpfilmlist_missing_cat_id">Genres: <?php echo $genres_count;
while($count > 0){

    
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE genres is NULL OR genres = '' LIMIT {$offset},%d", 100), ARRAY_A);
        if((sizeof($results) > 0) && ($initial_alert_set == 'false')){ 
            ?><span class="wpfilmlist_alert_hover">!!!</span>
            <div class="wpfilmlist_cat_class" id="wpfilmlist_missing_cat_dynamic">
                <p class="wpfilmlist_cat_alert_text">The films below have no genres information!<br/>Click on the titles below to add a genres.</p></br><?php
            $initial_alert_set = 'true';
        }
        
        if(sizeof($results) > 0){
            foreach($results as $b){
                ?>
                <p style="opacity:0" class="wpfilmlist_edit_entry_link" id="wpfilmlist_missing_cat_link" ><?php echo htmlspecialchars_decode($b['title']); ?><span class="hidden_id_title"><?php echo $b['ID'] ?></span></p><?php
            }
    }
    
        $results = null;
        unset($results);
    $offset = $offset+100;
    $count = $count-100;
}
$count = $persistent_count;


?></p>
<?php
}
}

function wpfilmlist_quote_area($quote_results, $num_of_quotes, $quote_results_film, $num_of_quotes_film, $hidequotefilm){

    $quote_num = rand(0,$num_of_quotes);
    $quote_actual = $quote_results[$quote_num]->quote;
    $pos = strpos($quote_actual,'" - ');
    $attribution = substr($quote_actual, $pos);
    $quote = substr($quote_actual, 0, $pos);
    echo '<p style="display:none;" class="wpfilmlist-ui-quote-area"><span style="font-style:italic;">'.$quote.'</span><span style="font-weight:bold;">'.$attribution.'</span></p>';

    $quote_num2 = rand(0,$num_of_quotes_film);
    $quote_actual2 = $quote_results_film[$quote_num2]->quote;
    $pos2 = strpos($quote_actual2,'" - ');
    $attribution2 = substr($quote_actual2, $pos2);
    $quote2 = substr($quote_actual2, 0, $pos2);
    echo '<p style="display:none;" id="wpfilmlist-ui-quote-area-hidden"><span style="font-style:italic;">'.$quote2.'</span><span style="font-weight:bold;">'.$attribution2.'</span></p>';    

    echo '<p id="wpfilmlist-hidden-quote-indicator" style="display:none;">'.$hidequotefilm.'</p>';
}


function wpfilmlist_sort_and_call_films($wpdb, $hide_edit_delete, $sort_id, $count, $films_on_page, $table_name,$sort_option, $hidereview, $options_row){
if(isset($_GET['search_query'])){

    $searchquery = filter_var($_GET['search_query'], FILTER_SANITIZE_STRING);
    $titlequery = filter_var($_GET['title_query'], FILTER_SANITIZE_STRING);
    $authorquery = filter_var($_GET['author_query'], FILTER_SANITIZE_STRING);
    if(isset($_GET['update_id'])){
        $updateid = filter_var($_GET['update_id'], FILTER_SANITIZE_STRING);
    }
    if(isset($_GET['page_control'])){
        $pagecontrol = filter_var($_GET['page_control'], FILTER_SANITIZE_NUMBER_INT);
    }

        $title_query = $titlequery;
                $author_query = $authorquery;
                if(($title_query == 'false') && ($author_query == 'false') || ($title_query == 'true') && ($author_query == 'true')){
                    $my_query = '%'.$searchquery.'%';
                    $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE author LIKE '%s' OR title LIKE '%s'",$my_query, $my_query ));
                    $search_count = $result;
            ?> <div id="wpfilmlist-search-count"> <?php echo $search_count.' results found'; ?> </div> <?php
                } elseif(($title_query == 'true') && ($author_query == 'false')){
                    $my_query = '%'.$searchquery.'%';
                    $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE title LIKE '%s'", $my_query));
                    $search_count = $result;
            ?> <div id="wpfilmlist-search-count"> <?php echo $search_count.' results found'; ?> </div> <?php
                } else{
                    $my_query = '%'.$searchquery.'%';
                    $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE author LIKE '%s'", $my_query));
                    $search_count = $result;
            ?> <div id="wpfilmlist-search-count"> <?php echo $search_count.' results found'; ?> </div> <?php
                }
    }


if(isset($_GET['update_id'])){
                $sort_id = filter_var($_GET['update_id'], FILTER_SANITIZE_STRING);
            } else if(isset($sortid)) {
                $sort_id = filter_var($_GET['update_id'], FILTER_SANITIZE_STRING);
            } else {
                
            }
            $genres_case;
            $genres_actual;
                if(substr($sort_id, 0, 3) == 'cat'){
                    $genres_actual = substr($sort_id, 3);
                    $genres_actual_for_echo = htmlspecialchars($genres_actual);
                    $sort_id = 'cat';?> 
                    <p id="wpfilmlist_cat_report"><?php echo $genres_actual; ?>: <?php  echo $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE genres LIKE '%%%s%%'", $genres_actual_for_echo)) ?> Entries Found</p> <?php
                }
            // Switch statement handles logic for which 'sort by' the user selected, creates a database query, and passes the query and the actual user selection to the wpfilmlist_display_films function   
            if($sort_id != ''){
                $sorter = $sort_id;
            } else {
                $sorter = $sort_option;
            }
        if(!isset($_GET['search_query'])){
            switch ($sorter) {
                case "first_edition":
                    $my_query = "SELECT * FROM $table_name WHERE firsteditionyes = 'yes' ORDER BY title ASC";
                    wpfilmlist_display_films($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $films_on_page, $table_name, $hidereview, $options_row);
                    break;
                case "alphabetically":
                    $my_query = "SELECT * FROM $table_name ORDER BY title ASC";
                    wpfilmlist_display_films($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $films_on_page, $table_name, $hidereview, $options_row);
                    break;
                case "year_released":
                    $my_query = "SELECT * FROM $table_name WHERE (releasefirstairdate <> 0 OR releasefirstairdate IS NULL) ORDER BY releasefirstairdate ASC";
                    wpfilmlist_display_films($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $films_on_page, $table_name, $hidereview, $options_row);
                    break;
                case "reader":
                    break;
                case "signed":
                    $my_query = "SELECT * FROM $table_name WHERE filmsignedyes = 'yes' ORDER BY title ASC";
                    wpfilmlist_display_films($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $films_on_page, $table_name, $hidereview, $options_row);
                    break;
                case "cat":
                    $my_query = "SELECT * FROM $table_name WHERE genres LIKE "."'%".htmlspecialchars($genres_actual)."%'";
                    wpfilmlist_display_films($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $films_on_page, $table_name, $hidereview, $options_row);
                    break;
                default:
                    if(empty($searchquery)){
                        $my_query = "SELECT * FROM $table_name";
                        wpfilmlist_display_films($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $films_on_page, $table_name, $hidereview, $options_row);
                    }
            }//end switch 
        }      

            // Handles the search function. Determines if title and/or author are checked, creates a query, calls wpfilmlist_display_films function
            if(!empty($searchquery)){
                $title_query = $titlequery;
                $author_query = $authorquery;
                if(($title_query == 'false') && ($author_query == 'false') || ($title_query == 'true') && ($author_query == 'true')){
                    $my_query = $searchquery;
                    $my_query = "SELECT * FROM $table_name WHERE author LIKE '%$my_query%' OR title LIKE '%$my_query%'";
                    wpfilmlist_display_films($wpdb, $count, $my_query, 'search_requested', $hide_edit_delete, $films_on_page, $table_name, $hidereview);
                } elseif(($title_query == 'true') && ($author_query == 'false')){
                    $my_query = $searchquery;
                    $my_query = "SELECT * FROM $table_name WHERE title LIKE '%$my_query%'";
                    wpfilmlist_display_films($wpdb, $count, $my_query, 'search_requested', $hide_edit_delete, $films_on_page, $table_name, $hidereview );
                } else{
                    $my_query = $searchquery;
                    $my_query = "SELECT * FROM $table_name WHERE author LIKE '%$my_query%'";
                    wpfilmlist_display_films($wpdb, $count, $my_query, 'search_requested', 'placeholder', $films_on_page, $table_name, $hidereview);
                }
            }

}



function wpfilmlist_display_films($wpdb, $count, $my_query, $sort_id, $hide_edit_delete, $films_on_page, $table_name, $hidereview, $options_row){

    
$start_with = 0;

    if(isset($_GET['page_control'])){
        $start_with = filter_var($_GET['page_control'], FILTER_SANITIZE_NUMBER_INT);
        $start_with = (intval($start_with) * intval($films_on_page)); 
    }
        
        $query = $my_query.' LIMIT '.$start_with.','.$films_on_page;
        $results = $wpdb->get_results($query, ARRAY_A);
    
 ?> 
                <div id="wpfilmlist_main_display_tdiv"><?php
            if($results == null){
                ?><div id="wpfilmlist-nofilms-app-notice">
                    <p id="wpfilmlist-nofilms-app-notice-p">Uh-oh, no movies! Well, since you're here, why not take a second to check out the other fantastic plugins in the 'WordPress List' series, <a style="font-size:16px;" href="https://www.jakerevans.com/shop/"><span id="wpfilmlist-mobile-app-span">WPBookList</span></a> and <a style="font-size:16px;" href="https://www.jakerevans.com/shop/"><span id="wpfilmlist-mobile-app-span">WPGameList!</span></a> They work just like WPFilmList, but for Books and Video Games!</p>

<p id="wpfilmlist-nofilms-app-notice-p">If you just happen to be thrilled beyond belief with WPFilmList, then please, feel free to <a style="font-size:16px;" href="https://wordpress.org/support/plugin/wpfilmlist/reviews/">leave a 5-star review here!</a></p>
                    </p><?php
            }
           foreach($results as $b){
                $column_control = 0;
                // Controls how many films are displayed per page. Changing the '12' value below will change how many films appear. 
                    $start_num = 0;
                    $end_num = 0;
                        // This if else statement controls the placement/logic of the image, the title, and the 'edit' and 'delete' links
                        if($b['coverurl'] == null){
                            ?><div class="wpfilmlist_entry_div"><div class="wpfilmlist_inner_main_display_div"><img data-table="<?php echo $table_name ?>" data-backdrop="<?php echo $b['backdropurl']; ?>" class="wpfilmlist_cover_image_class" id="wpfilmlist_cover_image" src="<?php echo plugins_url( '/assets/img/image_unavaliable.png', __FILE__ ); ?>"/><span class="hidden_id_title"><?php echo $b['ID']; ?></span><p data-table="<?php echo $table_name ?>" data-backdrop="<?php echo $b['backdropurl']; ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($b['title'])); ?><span class="hidden_id_title"><?php echo $b['ID'];?></span></p><div class="wpfilmlist_line_under_image"></div><?php if(($hide_edit_delete != '0') && (current_user_can( 'administrator' ))){?><p id="wpfilmlist-edit-delete-p-id"><a style="opacity:0"  class="wpfilmlist_edit_entry_link" id="wpfilmlist_edit_film_link">Edit<span class="hidden_id"><?php echo $b['ID']; ?></span></a><a style="opacity:0"  class="wpfilmlist_delete_entry_link" id="wpfilmlist_delete_film_link">Delete<span class="hidden_id"><?php echo $b['ID']; ?></span></a></p><?php
                                    }                                
                                if($hidereview == null){
                                    if($b['myfilmrating'] == 5){
                                    ?>
                                        <p class="wpfilmlist-review-star-p"><img style="opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/5star.png', __FILE__); ?>" /></p>
                                    <?php
                                    } 
                                    if($b['myfilmrating'] == 4){
                                    ?>
                                        <p class="wpfilmlist-review-star-p"><img style="opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/4star.png', __FILE__); ?>" /></p>
                                    <?php
                                    }
                                    if($b['myfilmrating'] == 3){
                                    ?>
                                        <p class="wpfilmlist-review-star-p"><img style="opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/3star.png', __FILE__); ?>" /></p>
                                    <?php
                                    }
                                    if($b['myfilmrating'] == 2){
                                    ?>
                                        <p class="wpfilmlist-review-star-p"><img style="opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/2star.png', __FILE__); ?>" /></p>
                                    <?php
                                    }
                                    if($b['myfilmrating'] == 1){
                                    ?>
                                        <p class="wpfilmlist-review-star-p"><img style="opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/1star.png', __FILE__); ?>" /></p>
                                    <?php
                                    }
                                }
                                ?>               
                                 </div>
                            </div><?php
                            $column_control++;
                        } else {
                            if($options_row[0]->stylepak == 'Default'){

                            } else {
                                $b['coverurl'] = str_replace('185','300',$b['coverurl']);
                                $b['coverurl'] = str_replace('278','450',$b['coverurl']);
                            }
                            ?>
                            <div class="wpfilmlist_entry_div"><div class="wpfilmlist_inner_main_display_div"><img data-table="<?php echo $table_name ?>" data-backdrop="<?php echo $b['backdropurl']; ?>" class="wpfilmlist_cover_image_class" id="wpfilmlist_cover_image" src=<?php echo '"'. $b['coverurl'].'"'; ?> /><span class="hidden_id_title"><?php echo $b['ID']; ?></span><p data-table="<?php echo $table_name ?>" data-backdrop="<?php echo $b['backdropurl']; ?>" style="opacity:0" class="wpfilmlist_saved_title_link" id="wpfilmlist_saved_title_link" ><?php echo htmlspecialchars_decode(stripslashes($b['title'])); ?><span class="hidden_id_title"><?php echo $b['ID'];?></span></p><div class="wpfilmlist_line_under_image"></div><?php if(($hide_edit_delete != '0') && (current_user_can( 'administrator' ))){?><p id="wpfilmlist-edit-delete-p-id"><a style="opacity:0" class="wpfilmlist_edit_entry_link" id="wpfilmlist_edit_film_link">Edit<span class="hidden_id"><?php echo $b['ID']; ?></span></a><a style="opacity:0" class="wpfilmlist_delete_entry_link" id="wpfilmlist_delete_film_link">Delete<span class="hidden_id"><?php echo $b['ID']; ?></span></a></p><?php
                                    }
                                    if($hidereview == null){
                                        if($b['myfilmrating'] == 5){
                                        ?>
                                            <p class="wpfilmlist-review-star-p"><img style="opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/5star.png', __FILE__); ?>" /></p>
                                        <?php
                                        } 
                                        if($b['myfilmrating'] == 4){
                                        ?>
                                            <p class="wpfilmlist-review-star-p"><img style="opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/4star.png', __FILE__); ?>" /></p>
                                        <?php
                                        }
                                        if($b['myfilmrating'] == 3){
                                        ?>
                                            <p class="wpfilmlist-review-star-p"><img style=" width: 30px; opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/3star.png', __FILE__); ?>" /></p>
                                        <?php
                                        }
                                        if($b['myfilmrating'] == 2){
                                        ?>
                                            <p class="wpfilmlist-review-star-p"><img style="width: 25px; opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/2star.png', __FILE__); ?>" /></p>
                                        <?php
                                        }
                                        if($b['myfilmrating'] == 1){
                                        ?>
                                            <p class="wpfilmlist-review-star-p"><img style="width: 13px; opacity:0;" class="wpfilmlist-rating-image" style="width: 50px;" src="<?php echo plugins_url('/assets/img/1star.png', __FILE__); ?>" /></p>
                                        <?php
                                        }
                                    }
                                    ?></div></div><?php
                            $column_control++;
                        }  
                    

            } 
            $results = null;
            unset($results); 
wpfilmlist_page_control($films_on_page, $count, $table_name);
}


function wpfilmlist_page_control($films_on_page, $count, $table_name){
 
    $page_num = $count/$films_on_page;
    $remainder = $count%$films_on_page;
    
    if(isset($_GET['page_control'])){
        $current_page = filter_var($_GET['page_control'], FILTER_SANITIZE_NUMBER_INT);
    } else {
        $current_page = null;
    }
    

       if($page_num >= 1){
        if($remainder == 0){
           $page_num--;
        }?>
        <div id="wpfilmlist_page_control_div"><?php
        for($i = 0; $i <= $page_num; $i++){
            ?>
            <a class="wpfilmlist_page_control_link_class" <?php if($current_page == $i){ echo 'id="wpfilmlist-active-page"'; }else{echo 'id="wpfilmlist_page_control_link_id"';}  ?> ><?php echo $i+1; ?></a><?php
        } 
    
    }

    ?>
      </div><?php
      }

?>
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-edit', 'security' );

function wpfilmlist_jre_editentry($saved_film){
    $id = filter_var($saved_film->ID, FILTER_SANITIZE_NUMBER_INT);
    $mediaid = filter_var($saved_film->mediaid, FILTER_SANITIZE_NUMBER_INT);
    $title = stripslashes(filter_var($saved_film->title, FILTER_SANITIZE_STRING));
    $originaltitle = stripslashes(filter_var($saved_film->originaltitle, FILTER_SANITIZE_STRING));
    $amazonaff = filter_var($options_results->amazonaff, FILTER_SANITIZE_STRING);
    $coverurl = filter_var($saved_film->coverurl, FILTER_SANITIZE_URL);
    $homepageurl = filter_var($saved_film->homepageurl, FILTER_SANITIZE_URL);
    $backdropurl = filter_var($saved_film->backdropurl, FILTER_SANITIZE_URL);  
    $overview = stripslashes(filter_var($saved_film->overview, FILTER_SANITIZE_STRING));  
    $creators = stripslashes(filter_var($saved_film->creators, FILTER_SANITIZE_STRING)); 
    $genres = filter_var($saved_film->genres, FILTER_SANITIZE_STRING); 
    $runtime = filter_var($saved_film->runtime, FILTER_SANITIZE_NUMBER_INT);
    $productioncompany = stripslashes(filter_var($saved_film->productioncompany, FILTER_SANITIZE_STRING));
    $productioncountry = filter_var($saved_film->productioncountry, FILTER_SANITIZE_STRING); 
    $releasefirstairdate = filter_var($saved_film->releasefirstairdate, FILTER_SANITIZE_STRING);
    $watched = filter_var($saved_film->watched, FILTER_SANITIZE_STRING);  
    $imdbid = filter_var($saved_film->imdbid, FILTER_SANITIZE_STRING);
    $budget = filter_var($saved_film->budget, FILTER_SANITIZE_STRING);
    $revenue = filter_var($saved_film->revenue, FILTER_SANITIZE_STRING);  
    $tagline = stripslashes(stripslashes(filter_var($saved_film->tagline, FILTER_SANITIZE_STRING)));  
    $networks = filter_var($saved_film->networks, FILTER_SANITIZE_STRING); 
    $video = filter_var($saved_film->video, FILTER_SANITIZE_STRING); 
    $notes = filter_var($saved_film->notes, FILTER_SANITIZE_STRING);
    $popularity = filter_var($saved_film->popularity, FILTER_SANITIZE_STRING); 
    $seasons = filter_var($saved_film->seasons, FILTER_SANITIZE_STRING); 
    $numofseasons = filter_var($saved_film->numofseasons, FILTER_SANITIZE_STRING); 
    $numofepisodes = filter_var($saved_film->numofepisodes, FILTER_SANITIZE_STRING);
    $episoderuntime = filter_var($saved_film->episoderuntime, FILTER_SANITIZE_STRING);
    $videostring = filter_var($saved_film->videostring, FILTER_SANITIZE_STRING);
    $inproduction = filter_var($saved_film->inproduction, FILTER_SANITIZE_STRING);
    $uberepisodestring = filter_var($saved_film->uberepisodestring, FILTER_SANITIZE_INT);
    $type = filter_var($saved_film->type, FILTER_SANITIZE_STRING);
    $status = filter_var($saved_film->status, FILTER_SANITIZE_STRING);
    $crewstring = filter_var($saved_film->crewstring, FILTER_SANITIZE_STRING);
    $caststring = filter_var($saved_film->caststring, FILTER_SANITIZE_STRING);
    $language = filter_var($saved_film->language, FILTER_SANITIZE_STRING);
    $belongstocollection = filter_var($saved_film->belongstocollection, FILTER_SANITIZE_STRING);
    $myfilmrating = filter_var($saved_film->myfilmrating, FILTER_SANITIZE_NUMBER_INT);

    $language = rtrim($language, ', ');
    $language = str_replace(',',', ', $language);

    $genres = str_replace(',',', ', $genres);
    $genres = rtrim($genres, ', ');

    $episoderuntime = str_replace(',',', ', $episoderuntime );
    $episoderuntime  = rtrim($episoderuntime , ', ');
    $episoderuntime = preg_replace("/,([^,]+)$/", " and$1", $episoderuntime);

    $creators = str_replace(',',', ', $creators);
    $creators = rtrim($creators, ', ');

    $networks = str_replace(',',', ', $networks);
    $networks = rtrim($networks, ', ');

    $productioncompany = str_replace(',',', ', $productioncompany);
    $productioncompany = rtrim($productioncompany, ', ');

    $productioncountry = str_replace(',',', ', $productioncountry);
    $productioncountry = rtrim($productioncountry, ', ');

    setlocale(LC_MONETARY,"en_US");
    $budget = money_format('$%!i',$budget);
    $revenue = money_format('$%!i',$revenue);


    ?>

    <!--Form for editing saved film-->
    <div class="wpfilmlist_edit_film_form_top_container">
        <form id="wpfilmlist_edit_film_form" method="post" action="">
            <p>
                <label for="film_title">Title: </label>
                <input type="text" id="wpfilmlist_film_title_edit" name="film_title" size="30" value="<?php echo htmlspecialchars_decode($title) ?>" />
            </p>
            <p>
                <label for="genres">Genres (seperate each genre with a comma): </label>
                <input type="text" id="wpfilmlist_genres_edit" name="genres" size="30" value="<?php echo htmlspecialchars($genres); ?>"/>
            </p>
            <p>
                <label for="language">Languages: </label>
                <input type="text" id="wpfilmlist_language_edit" name="language" size="30" value="<?php echo htmlspecialchars($language); ?>"/>
            </p> 
            <?php if($episoderuntime != null){   ?>
            <p>
                <label for="episoderuntime">Runtime/Episode Runtime: (In Minutes) </label>
                <input type="text" id="wpfilmlist_episoderuntime_edit" name="episoderuntime" size="30" value="<?php echo htmlspecialchars( $episoderuntime ) ?>"/>
            </p> 
            <?php } 
            if(($runtime != null) ){   ?>
            <p>
                <label for="runtime">Runtime/Episode Runtime: (In Minutes) </label>
                <input type="text" id="wpfilmlist_runtime_edit" name="runtime" size="30" value="<?php echo htmlspecialchars( $runtime ) ?>"/>
            </p>
            <?php } ?>
            <p>
                <label for="creators">Creator(s): </label>
                <input type="text" id="wpfilmlist_creators_edit" name="creators" size="30" value="<?php echo htmlspecialchars_decode( $creators) ?>"/>
            </p>
            <p>
                <label for="networks">Networks(s): </label>
                <input type="text" id="wpfilmlist_networks_edit" name="networks" size="30" value="<?php echo htmlspecialchars_decode( $networks) ?>"/>
            </p>
            <p>
                <label for="numofseasons">Seasons: </label>
                <input type="text" id="wpfilmlist_numofseasons_edit" name="numofseasons" size="30" value="<?php echo htmlspecialchars_decode( $numofseasons) ?>"/>
            </p>
            <p>
                <label for="numofepisodes">Number of Episodes: </label>
                <input type="text" id="wpfilmlist_numofepisodes_edit" name="numofepisodes" size="30" value="<?php echo htmlspecialchars_decode( $numofepisodes) ?>"/>
            </p>
            <p>
                <label for="productioncompany">Production Company(s): </label>
                <input type="text" id="wpfilmlist_productioncompany_edit" name="productioncompany" size="30" value="<?php echo htmlspecialchars_decode( $productioncompany) ?>"/>
            </p>
            <p>
                <label for="productioncountry">Production Country(s): </label>
                <input type="text" id="wpfilmlist_productioncountry_edit" name="productioncountry" size="30" value="<?php echo htmlspecialchars_decode( $productioncountry) ?>"/>
            </p>
            <p>
                <label for="releasefirstairdate">Release Date/First Air Date: </label>
                <input type="text" id="wpfilmlist_releasefirstairdate_edit" name="releasefirstairdate" size="30" value="<?php echo htmlspecialchars_decode( $releasefirstairdate) ?>"/>
            </p>
            <p>
                <label for="budget">Budget: </label>
                <input type="text" id="wpfilmlist_budget_edit" name="budget" size="30" value="<?php echo htmlspecialchars_decode( $budget) ?>"/>
            </p>
            <p>
                <label for="revenue">Revenue: </label>
                <input type="text" id="wpfilmlist_revenue_edit" name="revenue" size="30" value="<?php echo htmlspecialchars_decode( $revenue) ?>"/>
            </p>
            <p>
                <label for="status">Status: </label>
                <input type="text" id="wpfilmlist_status_edit" name="status" size="30" value="<?php echo htmlspecialchars_decode( $status) ?>"/>
            </p>
            <p>
                <label for="description">Description: </label>
                <textarea id="wpfilmlist_desc_edit" name="description" rows="3" size="30" value="<?php echo stripslashes($overview)  ?>"><?php echo stripslashes($overview);?></textarea>
            </p>
            <p>
                <label for="notes">Notes: </label>
                <textarea id="wpfilmlist_notes_edit" name="notes" rows="3" size="30" value="<?php echo htmlspecialchars($notes) ?>"><?php echo htmlspecialchars_decode(strip_tags($notes)); ?></textarea>
            </p>
            <p>
                <select id="wpfilmlist-ratings-select-edit">
                    <option <?php if($myfilmrating == 0){ echo 'selected="selected"'; } ?> disabled="disabled">Rate This Title</option>
                    <option <?php if($myfilmrating == 5){ echo 'selected="selected"'; } ?> value="5">5 Stars</option>
                    <option <?php if($myfilmrating == 4){ echo 'selected="selected"'; } ?> value="4">4 Stars</option>
                    <option <?php if($myfilmrating == 3){ echo 'selected="selected"'; } ?> value="3">3 Stars</option>
                    <option <?php if($myfilmrating == 2){ echo 'selected="selected"'; } ?> value="2">2 Stars</option>
                    <option <?php if($myfilmrating == 1){ echo 'selected="selected"'; } ?> value="1">1 Star</option>
                </select>
            </p>
                <input type="button" value="Edit Entry" id="wpfilmlist_edit_film_submit_button" />
                <p style="display:none;">
                    <input style="display:none;" type="text"  name="hidden_id_input" value="<?php echo htmlspecialchars( $id ) ?>"/>
                </p>
        </form>
    </div>
    <?php
}
?>
<?php
//if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-savedbook', 'security' );

function wpfilmlist_jre_savedfilmactions($saved_film, $img_path, $options_results, $quote, $attribution){
      
    $mediaid = filter_var($saved_film->mediaid, FILTER_SANITIZE_NUMBER_INT);
    $title = stripslashes(filter_var($saved_film->title, FILTER_SANITIZE_STRING));
    $originaltitle = stripslashes(filter_var($saved_film->originaltitle, FILTER_SANITIZE_STRING));
    $amazonaff = filter_var($options_results->amazonaff, FILTER_SANITIZE_STRING);
    $path = $img_path;
  
    $hidefacebook = filter_var($options_results->hidefacebook, FILTER_SANITIZE_NUMBER_INT);
    $hidetwitter = filter_var($options_results->hidetwitter, FILTER_SANITIZE_NUMBER_INT);
    $hidegoogleplus = filter_var($options_results->hidegoogleplus, FILTER_SANITIZE_NUMBER_INT);
    $hidemessenger = filter_var($options_results->hidemessenger, FILTER_SANITIZE_NUMBER_INT);
    $hidepinterest = filter_var($options_results->hidepinterest, FILTER_SANITIZE_NUMBER_INT);
    $hideemail = filter_var($options_results->hideemail, FILTER_SANITIZE_NUMBER_INT);
    $hidetagline = filter_var($options_results->hidetagline, FILTER_SANITIZE_NUMBER_INT);
    $hidegoodreadswidget = filter_var($options_results->hidegoodreadswidget, FILTER_SANITIZE_NUMBER_INT);
    $hideamazonreview = filter_var($options_results->hideamazonreview, FILTER_SANITIZE_NUMBER_INT);
    $hidedescription = filter_var($options_results->hidedescription, FILTER_SANITIZE_NUMBER_INT);
    $hideimages = filter_var($options_results->hideimages, FILTER_SANITIZE_NUMBER_INT);
    $hidevideos = filter_var($options_results->hidevideos, FILTER_SANITIZE_NUMBER_INT);
    $hidenotes = filter_var($options_results->hidenotes, FILTER_SANITIZE_NUMBER_INT);
    $hideratingbackend = filter_var($options_results->hidereviewfilm, FILTER_SANITIZE_NUMBER_INT);
    $hidequotefilm = filter_var($options_results->hidequotefilm, FILTER_SANITIZE_NUMBER_INT);
    $hidetoppurchase = filter_var($options_results->hidetoppurchase, FILTER_SANITIZE_NUMBER_INT);
    $hidebottompurchase = filter_var($options_results->hidebottompurchase, FILTER_SANITIZE_NUMBER_INT);
    $hidelinks = filter_var($options_results->hidelinks, FILTER_SANITIZE_NUMBER_INT);
    $hidecast = filter_var($options_results->hidecast, FILTER_SANITIZE_NUMBER_INT);
    $hidecrew = filter_var($options_results->hidecrew, FILTER_SANITIZE_NUMBER_INT);
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



    //$amazon_link = 'https://www.amazon.com/s/ref=nb_sb_ss_c_1_9?url=search-alias%3Dinstant-video&field-keywords='.urlencode($title).'&sprefix='.urlencode($title).'%2Cinstant-video%2C171&crid=3RMSQOZ9YRJ9R';
    $bestbuyurl = 'http://www.bestbuy.com/site/searchpage.jsp?st='.$title.'&_dyncharset=UTF-8&id=pcat17071&type=page&sc=Global&cp=1&nrp=&sp=&qp=&list=n&af=true&iht=y&usc=All+Categories&ks=960&keys=keys';
    $temptitle = str_replace(' ','', $title);
    $temptitle = preg_replace("/[^a-zA-Z 0-9]+/", "", $temptitle);
    $itunes_link = 'https://search.itunes.apple.com/WebObjects/MZContentLink.woa/wa/link?path='.$temptitle.'&partnerId=11&at=1010lnPx';
    //$ebayurl = 'http://www.ebay.com/sch/Video-Games-Consoles/1249/i.html?_from=R40&_nkw='.$tempname;
    $genres = str_replace(',',', ', $genres);
    $genres = rtrim($genres, ', ');
    $creators = str_replace(',',', ', $creators);
    $creators = rtrim($creators, ', ');
    $productioncompany = str_replace(',',', ', $productioncompany);
    $productioncompany = rtrim($productioncompany, ', ');
    $productioncountry = str_replace(',',', ', $productioncountry);
    $productioncountry = rtrim($productioncountry, ', ');
    $networks = str_replace(',',', ', $networks);
    $networks = rtrim($networks, ', ');
    $language = str_replace(',',', ', $language);
    $language = rtrim($language, ', ');
    $episoderuntime = str_replace(',',', ', $episoderuntime );
    $episoderuntime  = rtrim($episoderuntime , ', ');
    $episoderuntime = preg_replace("/,([^,]+)$/", " and $1", $episoderuntime);

    setlocale(LC_MONETARY,"en_US");
    $budget = money_format('$%!i',$budget);
    $revenue = money_format('$%!i',$revenue);

    $amazontitle = preg_replace('/[^a-z]+/i', ' ', $title);
    $amazontitle = str_replace(" s", "s", $amazontitle);
    $amazontitle = str_replace("Marvels", "", $amazontitle);

    $postdata = http_build_query(
        array(
            'associate_tag' => 'wpbooklistid-20',
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
            if($result["ItemAttributes"]['ProductGroup'] == 'DVD'){
                if($link_dvd == null){
                    $link_dvd = $result["DetailPageURL"];
                }
            }
        }

        foreach($amazon_array['Items']['Item'] as $result){
            if($result["ItemAttributes"]['Binding'] == 'Amazon Video'){
                if($link == null){
                    $link = $result["DetailPageURL"];
                }
            }
        }
    }

    if($link == null){
        $link = $amazon_array['Items']['Item']["DetailPageURL"];
    }

    if($link == null){
        $link = 'https://www.amazon.com/s/ref=nb_sb_ss_c_1_9?url=search-alias%3Dinstant-video&field-keywords='.urlencode($title).'&sprefix='.urlencode($title).'%2Cinstant-video%2C171&crid=3RMSQOZ9YRJ9R';
    }
          

 ?>
 <div id="wpfilmlist-background-color-image-div">
    <div id="wpfilmlist_top_top_div">
        <img id="wpfilmlist-hidden-image-img" style="display:none;"  />
    <div></div>
    <div id="wpfilmlist_top_display_container">
        <table>
            <tbody>
                <tr>
                    <td id="wpfilmlist_image_saved_border">
                        <div id="wpfilmlist_display_image_container"><?php
                            // Determine which image to use (if one was found in the API calls, or if we resort to default 'not avaliable' image)
                            if($coverurl == null){
                            ?><img id="wpfilmlist_cover_image_popup" src="<?php echo $path.'image_unavaliable.png'; ?>" /> <?php
                            } else {
                                ?><img id="wpfilmlist_cover_image_popup" src="<?php echo $coverurl?>" /> <?php if(($tagline != null) && ($hidetagline == null)){ echo'<span id="wpfilmlist-tagline-span">"'.$tagline.'"</span>'; }
                            }?>
      
                            <input type="submit" id="wpfilmlist_desc_button" value="Description, Notes & Reviews"></input>


                 <?php 
                 $description = $overview;

            ?>
            <?php if( ($hideratingbackend == null) && ($myfilmrating != 0)){ ?>
            <p id="wpfilmlist-share-text">My Rating</p>
            <div class="wpfilmlist-line-4"></div>
            <?php if($myfilmrating == 5){
                    ?>
                    <img style="width: 70px; position:relative; bottom:1px;" src="<?php echo plugins_url('/assets/img/5star.png', __FILE__); ?>" />
                    <?php
                  }    
            ?>
            <?php if($myfilmrating == 4){
                    ?>
                    <img style="width: 50px; position:relative; bottom:1px;" src="<?php echo plugins_url('/assets/img/4star.png', __FILE__); ?>" />
                    <?php
                  }    
            ?>
            <?php if($myfilmrating == 3){
                    ?>
                    <img style="width: 40px; position:relative; bottom:1px;" src="<?php echo plugins_url('/assets/img/3star.png', __FILE__); ?>" />
                    <?php
                  }    
            ?>
            <?php if($myfilmrating == 2){
                    ?>
                    <img style="width: 30px; position:relative; bottom:1px;" src="<?php echo plugins_url('/assets/img/2star.png', __FILE__); ?>" />
                    <?php
                  }    
            ?>
            <?php if($myfilmrating == 1){
                    ?>
                    <img style="width: 20px; position:relative; bottom:1px;" src="<?php echo plugins_url('/assets/img/1star.png', __FILE__); ?>" />
                    <?php
                  }    
            }

           if(($homepageurl == null) && ($imdbid == null) && ($mediaid == null)){  
               
                } else {
                    if($hidelinks == null){   
                    ?><p id="wpfilmlist-share-text">Links</p>
                    <div class="wpfilmlist-line-4"></div>
                    <?php 
                    if($mediaid != null){ 
                        if($type == 'Movie'){
                            echo '<a target="_blank" href="https://www.themoviedb.org/movie/'.$mediaid.'">The Movie DB</a><br>';
                        } else{
                            echo '<a target="_blank" href="https://www.themoviedb.org/tv/'.$mediaid.'">The Movie DB</a><br>';
                        }
                    } 
                    if($homepageurl != null){ 
                        echo '<a target="_blank" href="'.$homepageurl.'">Official Site</a> <br>';
                    }
                    if($imdbid != null){ 
                        echo '<a target="_blank" href="http://www.imdb.com/title/'.$imdbid.'">IMDB</a>';
                    }
                }
            }
           
           if(($hidefacebook == null) || ($hidetwitter == null) || ($hidegoogleplus == null) || ($hidemessenger == null) || ($hidepinterest == null) || ($hideemail == null)){ ?>
                <p id="wpfilmlist-share-text">Share This <?php echo $type; ?></p>
                <div class="wpfilmlist-line-4"></div>
                <?php if($hidefacebook == null){ ?>
                <div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="<?php echo $title;?>" addthis:description="<?php echo $description;?>"addthis:url="<?php echo $amazondetpage;?>" class="addthis_button_facebook"> </a></div> <?php } ?>
                  <?php if($hidetwitter == null){ ?>
                <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $title;?>" addthis:description="<?php echo $description;?>"addthis:url="<?php echo $amazondetpage;?>" class="addthis_button_twitter"> </a></div> <?php } ?>
                <?php if($hidegoogleplus == null){ ?>
        <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $title;?>" addthis:description="<?php echo $description;?>"addthis:url="<?php echo $amazondetpage;?>" class="addthis_button_google_plusone_share"> </a></div><?php } ?>
        <?php if($hidepinterest == null){ ?>
        <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $title;?>" addthis:description="<?php echo $description;?>"addthis:url="<?php echo $amazondetpage;?>" class="addthis_button_pinterest_share"> </a></div><?php } ?>
        <?php if($hidemessenger == null){ ?>
        <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $title;?>" addthis:description="<?php echo $description;?>" addthis:url="<?php echo $amazondetpage;?>" class="addthis_button_messenger"> </a></div><?php } ?>
        <?php if($hideemail == null){ ?>
        <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $title;?>" addthis:description="<?php echo $description;?>" addthis:url="<?php echo$amazondetpage;?>" class="addthis_button_gmail"> </a></div><?php } ?>


                <?php 
            }

            ?>
            </div>
                        </div>
                    </td>
                  
                            </table>
                            
                        </div>
                    </td>
                </tr>
            </tbody>
            <a name="desc_scroll"></a>
        </table>
     
                        <div  id="wpfilmlist_display_table">
                            <!-- Table to display book info on the right-hand side of UI, with controls for null/empty values-->
                            <table id="wpfilmlist_display_table_2">
                                <tr>
                                    <td id="wpfilmlist_title"><?php echo htmlspecialchars_decode($title); ?></td>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <td><?php 
                                        if($title != $originaltitle){
                                            ?><span id="wpfilmlist_bold"><?php echo'Original Title: ' ?></span><?php echo $originaltitle;
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php 
                                        if(($language != null) && (strlen($language) > 2)){
                                            ?><span id="wpfilmlist_bold"><?php echo'Language(s): ' ?></span><?php echo $language;
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php 
                                        if($genres == null){
                                            ?><span id="wpfilmlist_bold"><?php echo'Genre(s): ' ?></span><?php echo 'Not Avaliable';
                                        } else {
                                            ?><span id="wpfilmlist_bold"><?php echo'Genre(s): ' ?></span><?php echo $genres;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php
                                        if((($runtime != null) && ($runtime != 0)) && ($type == 'Movie')){
                                            ?><span id="wpfilmlist_bold"><?php echo'Runtime: ' ?></span><?php echo $runtime.' Minutes'; 
                                        } 
                                        if(($episoderuntime != null) && ($type == 'TV Show')) {
                                            ?><span id="wpfilmlist_bold"><?php echo'Episode Runtime(s): ' ?></span><?php echo $episoderuntime.' Minutes'; 
                                        }?>
                                    </td>   
                                </tr>
                                <tr>
                                    <td><?php
                                        if(($type == 'TV Show')  &&  ($creators != null)){
                                            ?><span id="wpfilmlist_bold"><?php echo'Creators: ' ?></span><?php echo $creators; 
                                        } ?>
                                    </td>   
                                </tr>
                                <tr>
                                    <td><?php 
                                        if($productioncompany != null){
                                            ?><span id="wpfilmlist_bold"><?php echo'Production Company(s): ' ?></span><?php echo $productioncompany;   
                                        } 
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php 
                                        if($productioncountry != null){
                                            ?><span id="wpfilmlist_bold"><?php echo'Production Country(s): ' ?></span><?php echo $productioncountry;   
                                        } 
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php  
                                        if(($releasefirstairdate != null) && ($type == 'Movie')  ){
                                            ?><span id="wpfilmlist_bold"><?php echo'Release Date:   ' ?></span><?php echo $releasefirstairdate;
                                        } 
                                        if(($releasefirstairdate != null) && ($type == 'TV Show')  ){
                                            ?><span id="wpfilmlist_bold"><?php echo'First Aired On: ' ?></span><?php echo $releasefirstairdate;   
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php  
                                        if(($budget != null) && ($budget != '$0.00')  ){
                                            ?><span id="wpfilmlist_bold"><?php echo'Budget:   ' ?></span><?php echo $budget;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php  
                                        if(($revenue != null) && ($revenue != '$0.00')  ){
                                            ?><span id="wpfilmlist_bold"><?php echo'Revenue:   ' ?></span><?php echo $revenue;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php  
                                        if(($status != null) && ($status != 'null')){
                                            ?><span id="wpfilmlist_bold"><?php echo'Status:   ' ?></span><?php echo $status;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php  
                                        if(($networks != null) && (strlen($networks) > 1)  ){
                                            ?><span id="wpfilmlist_bold"><?php echo'Network(s):   ' ?></span><?php echo htmlspecialchars_decode($networks);
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php  
                                        if(($numofseasons != null) && ($type == 'TV Show')  ){
                                            ?><span id="wpfilmlist_bold"><?php echo'Seasons:   ' ?></span><?php echo $numofseasons;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php  
                                        if(( ($numofepisodes != null) || ($numofepisodes != 0) ) && ($type == 'TV Show')  ){
                                            ?><span id="wpfilmlist_bold"><?php echo'Total Episodes:   ' ?></span><?php echo $numofepisodes;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php  
                                        if(($inproduction != null) && ($inproduction == 1) && ($type == 'TV Show')  ){
                                            ?><span id="wpfilmlist_bold"><?php echo'In Production?   ' ?></span><?php echo 'Yes';
                                        } 
                                        if(($inproduction != null) && ($inproduction == 0) && ($type == 'TV Show')  ){
                                            ?><span id="wpfilmlist_bold"><?php echo'In Production?   ' ?></span><?php echo 'No';
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                                if($hidetoppurchase == null){
                                ?>
                                <tr>
                                    <td><div class="wpfilmlist-line-2"></div></td>
                                </tr>
                                <tr>
                                    <td class="wpfilmlist-purchase-title" colspan="2">Watch or Purchase This <?php echo $type; ?> At:</td>
                                </tr>
                                <tr>
                                    <td><div class="wpfilmlist-line"></div></td>
                                </tr>
                                <tr>
                                    <td> 
                                        <a class="wpfilmlist-purchase-img" href="<?php echo $link;?>" target="_blank"><img src="<?php echo $path.'amazonvideo.jpg'; ?>" /></a><a class="wpfilmlist-purchase-img" href="<?php echo $link_dvd;?>" target="_blank"><img src="<?php echo $path.'amazon.png'; ?>" /></a>
                    <a class="wpfilmlist-purchase-img" target="_blank" href="<?php echo $bestbuyurl; ?>"><img src="<?php echo $path.'bestbuy.png'; ?>" /></a>
                    <a <?php if ($googlepreview == null){echo ' style="display:none;"';}?>class="wpfilmlist-purchase-img" target="_blank" href="<?php echo $googlepreview; ?>"><img src="<?php echo $path.'googlebooks.png'; ?>" /></a>
                    <a class="wpfilmlist-purchase-img wpfilmist-itunes-adjust" target="_blank" href="<?php echo $itunes_link; ?>"><img src="<?php echo $path.'itunes.ico'; ?>" /></a>
                    <a style="display:none;" href="http://www.ulrichmierendorff.com/"></a>
                                    </td>   
                                </tr>
                                <tr>
                                    <td><div class="wpfilmlist-line-3"></div></td>
                                </tr>
                                <?php
                            }
                            ?>
    </table>
    </div>
        </div>
        <?php 
        if($hidecast == null){    
             if($caststring != null){    ?>
             <p class="wpfilmlist_description_p wpfilmlist-cast-crew-title-p">Cast</p>
             <div class="wpfilmlist-line-50"></div>
             <div class="wpfilmlist-cast-pics">
                <?php 
                    $caststring = explode(',', $caststring);
                    $caststring = array_slice($caststring, 0, 21);
                    for($i = 0; $i < (sizeof($caststring)); $i+=3){
                        if(  ($caststring[$i] != null) || ($caststring[$i+1] != null) || ($caststring[$i+2] != null)   ){
                            ?> <div class="wpfilmlist-indiv-cast-div"><div class="wpfilmlist-cast-image-div"> <?php
                            if($caststring[$i+2] != ''){
                                echo '<img class="wpfilmlist-cast-images" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2'.$caststring[$i+2].'"" />';
                            } else {
                                echo '<img class="wpfilmlist-cast-images" src="'.plugins_url("/assets/img/nocastcrewimage.jpg", __FILE__).'" />'; 
                            }
                            ?> </div> <?php
                            if($caststring[$i] != ''){
                                echo '<p class="wpfilmlist-cast-character-name"> "'.$caststring[$i].'" </p>';
                            }
                            echo '<p class="wpfilmlist-cast-character-realname"> '.$caststring[$i+1].' </p>';
                            ?> </div> <?php
                        }
                    }

     
                ?>
            </div>
            <?php } 
        }?>
         <?php 
        if($hidecrew == null){   
             if($crewstring != null){    ?>
             <p class="wpfilmlist_description_p wpfilmlist-cast-crew-title-p">Crew</p>
             <div class="wpfilmlist-line-50"></div>
             <div class="wpfilmlist-cast-pics">
                    <?php 
                    $crewstring = explode(',', $crewstring);
                    $crewstring = array_slice($crewstring, 0, 21);
                    for($i = 0; $i < (sizeof($crewstring)); $i+=3){
                        if(  ($crewstring[$i] != null) || ($crewstring[$i+1] != null) || ($crewstring[$i+2] != null)   ){
                            ?> <div class="wpfilmlist-indiv-cast-div"><div class="wpfilmlist-cast-image-div"> <?php
                            if($crewstring[$i+2] != ''){
                                echo '<img class="wpfilmlist-cast-images" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2'.$crewstring[$i+2].'"" />';
                            } else {
                                echo '<img class="wpfilmlist-cast-images" src="'.plugins_url("/assets/img/nocastcrewimage.jpg", __FILE__).'" />'; 
                            }
                            ?> </div> <?php
                            if($crewstring[$i] != ''){
                                echo '<p class="wpfilmlist-cast-character-job"> "'.$crewstring[$i].'" </p>';
                            }
                            echo '<p class="wpfilmlist-cast-character-realname"> '.$crewstring[$i+1].' </p>';
                            ?> </div> <?php
                        }
                    }

     
                ?>
             </div>
             <?php } 
        }?>


        <div id="wpfilmlist_desc_id">
    <?php 
    if($hidedescription == null){ ?>
         <p class="wpfilmlist_description_p wpfilmlist-cast-crew-title-p">Description:</p> <?php
            if(($overview == null) || ($overview == ' ') || ($overview == '')){
                ?> <p class="wpfilmlist_desc_p_class"> <?php echo 'Not Avaliable'; ?> </p> <?php
            } else {
                ?> <div class="wpfilmlist_desc_p_class"> <?php echo htmlspecialchars_decode(stripslashes($overview)); ?></div> <?php
            } }?>

    <?php 
    if($hideimages == null){ ?>
         <p class="wpfilmlist_description_p">Images:</p> <?php
            if($overview == null){
                ?> <p class="wpfilmlist_desc_p_class"> <?php echo 'Not Avaliable'; ?> </p> <?php
            } else {
                ?> <div class="wpfilmlist_desc_p_class"> <?php 
                $pos = strpos($belongstocollection ,',');
                $belongstocollection = substr($belongstocollection, $pos);
                $belongstocollection = explode(',', $belongstocollection);
                array_shift($belongstocollection);

                $pos = strpos($seasons ,',');
                $seasons = substr($seasons, $pos);
                $seasons = explode(',', $seasons);
                array_shift($seasons);
                array_pop($seasons);
                //var_dump($belongstocollection);
                echo '<img class="wpquiz-image-collection" src="'.$coverurl.'" />';
                foreach($belongstocollection as $image){
                    if( (strlen($image) > 1)){
                        echo '<img class="wpquiz-image-collection" src="https://image.tmdb.org/t/p/original'.$image.'" />';
                    }

                }

                foreach($seasons as $sea){
                    if((strlen($sea) > 1) && (($sea != ',') || ($sea != ''))){
                        echo '<img class="wpquiz-image-collection" src="https://image.tmdb.org/t/p/original'.$sea.'" />';
                    }
                }
                if(($backdropurl != null) && (strlen($backdropurl) > 35)){
                    ?><div class="wpfilmlist-backdrop-image"> <?php
                    echo '<p class="wpfilmlist_backdrop_image_class">Backdrop Image </p><div class="wpfilmlist-line-30"></div><img class="wpquiz-image-collection-backdrop" src="'.$backdropurl.'" />'
                    ?></div><?php
                }
                ?> </div> <?php
                
            } }?>

            <?php 
    if($hidevideos == null){ ?>
         <p class="wpfilmlist_description_p">Videos:</p> <?php
            if($videostring == null){
                ?> <p class="wpfilmlist_desc_p_class"> <?php echo 'Not Avaliable'; ?> </p> <?php
            } else {
                $videostring = explode(',', $videostring);
                //var_dump($videostring);


                ?> <div class="wpfilmlist_desc_p_class"> <?php 
                for($i = 0; $i < sizeof($videostring); $i++){
                    if($i <= (sizeof($videostring) - 2 )){
                        if((strlen($videostring[$i]) == 11) && ($videostring[$i+2] == 'YouTube')){
                            echo '<iframe class="wpquiz-video-iframes" width="320" height="180" src="https://www.youtube.com/embed/'.$videostring[$i].'" frameborder="0" allowfullscreen></iframe>';
                        }
                    }
                }
               
                ?> </div> <?php
                
            } 
    }?>
           

     <?php  if($hidenotes == null){ ?>
         <p style="margin-top:20px;" class="wpfilmlist_description_p">Notes:</p> <?php
            if($notes == null){
                ?> <p class="wpfilmlist_desc_p_class"> <?php echo 'None Provided'; ?> </p> <?php
            } else {
                ?> <p class="wpfilmlist_desc_p_class"> <?php echo htmlspecialchars_decode(stripslashes($notes)); ?></p> <?php
            } 
        } ?> 
        <?php if ($hidebottompurchase != null){echo '<div style="display:none;" >';}?>
            <div class="wpfilmlist-line-5"></div>
            <p class="wpfilmlist-purchase-title">
                Watch or Purchase This <?php echo $type; ?> At:
            </p>
            <div class="wpfilmlist-line-6"></div>
        <a class="wpfilmlist-purchase-img" href="<?php echo $link;?>" target="_blank"><img src="<?php echo $path.'amazonvideo.jpg'; ?>" /></a>          
                    <a <?php if ($isbn == null){echo ' style="display:none;"';}?>class="wpfilmlist-purchase-img" target="_blank" href="http://www.barnesandnoble.com/s/<?php echo $isbn; ?>"><img src="<?php echo $path.'bn.png'; ?>" /></a>
                    <a class="wpfilmlist-purchase-img" target="_blank" href="<?php echo $bestbuyurl; ?>"><img src="<?php echo $path.'bestbuy.png'; ?>" /></a>
                    <a <?php if ($googlepreview == null){echo ' style="display:none;"';}?>class="wpfilmlist-purchase-img" target="_blank" href="<?php echo $googlepreview; ?>"><img src="<?php echo $path.'googlebooks.png'; ?>" /></a>
                    <a class="wpfilmlist-purchase-img wpfilmist-itunes-adjust" target="_blank" href="<?php echo $itunes_link; ?>"><img src="<?php echo $path.'itunes.ico'; ?>" /></a>
    <?php if ($hidebottompurchase == null){echo '</div>';}?>
    </div>
</div>
    <?php
}
?>
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-deletefilm', 'security' ); // Nonce check

function wpfilmlist_jre_deleteentry($id){
	?>
	<!--Form that appears for deleting a film when user clicks on the 'delete' link-->
	<div class="wpfilmlist_delete_film_form_top_container">
		<form id="wpfilmlist_delete_film_form" method="post" action="">
			<p>
				<label for="your_name">Are you sure you want to delete this title?</label>
			</p>
			<p style="display:none;">
	        	<input  type="text"  id="delete_id" name="delete_id" value="<?php echo $id; ?>"/>
	        </p>
			<p id="wpfilmlist_delete_film_submit">
				<input data-deleteid="<?php echo $id; ?>" type="button" value="Delete Title" id="wpfilmlist_delete_film_submit_button" />	
			</p>
		</form>
	</div>
	<?php
}
?>
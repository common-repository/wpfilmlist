<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
check_ajax_referer( 'wpfilmlist-jre-ajax-nonce-addbook', 'security' ); // Nonce check
function wpfilmlist_jre_addbookform(){
?>
<!--Form for adding a new book-->
    <div class="wpfilmlist_add_book_form_top_container" >
        <form id="wpfilmlist_add_book_form" method="post" action="">
           
                <label for="isbn">ISBN (10 or 13) - <span style="color:red">Required Field</span></label>
                <input type="text" id="wpfilmlist_isbn" name="isbn" />
            </p>
            <p>
                <label for="notes">Notes (optional): </label>
                <textarea  id="wpfilmlist_notes" name="notes"></textarea>
            </p>
            <div id="form_movement">
                <p>
                    <table id="wpfilmlist_signed_first_table">
                        <tr>
                            <td><label for="year_finished">Have You Finished This Book?</label></td>
                            <td><label for="book_signed">Is it Signed?</label></td>
                            <td><label for="book_signed">Is it a First Edition?</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="wpfilmlist_finished_yes" name="finished_yes" value="yes">Yes
                                &nbsp&nbsp&nbsp
                                <input type="checkbox" id="wpfilmlist_finished_no" name="finished_no" value="no">Not Yet</td>
                            <td>
                                <input type="checkbox" id="wpfilmlist_book_signed_yes" name="book_signed_yes" value="yes">Yes&nbsp&nbsp&nbsp
                                <input type="checkbox" id="wpfilmlist_book_signed_no" name="book_signed_no" value="no">No</td>
                            <td>
                                <input type="checkbox" id="wpfilmlist_book_first_edition_yes" name="first_edition_yes" value="yes">Yes&nbsp&nbsp&nbsp
                                <input type="checkbox" id="wpfilmlist_book_first_edition_no" name="first_edition_no" value="no">No</td>
                        </tr>
                    </table>
                </p>
                <p>
                    <label id="wpfilmlist_year_finished_label" for="year_finished">Year this Book Was Finished: </label>
                    <input type="text" id="wpfilmlist_year_finished" disabled="true" name="year_finished" value="" size="30" />
                </p>
                <p id="wpfilmlist_add_book_submit">
                    <input type="button" value="Add Book" id="wpfilmlist_add_book_submit_button" />
                </p>
            </div>
        </form>
    </div>
<?php
}
?>
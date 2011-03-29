
<?php

$messagelang=new object();
$messagelang->user=$USER->firstname.' '.$USER->lastname;
if (empty($description)) {
	$messagelang->description=$name;
} else {
    $messagelang->description=$description;
}
$messagelang->room=$room_name;
$messagelang->datetime=$start_date;
$messagelang->href=$CFG->wwwroot.'/blocks/mrbs/web/edit_entry.php?id='.$id;
$message="$USER->firstname $USER->lastname requests that you move $description from room $room_name, $start_date. Please contact them to discuss this.\n\n[Give a reason]";

 if (has_capability('block/mrbs:editmrbs', get_context_instance(CONTEXT_SYSTEM))or has_capability('block/mrbs:administermrbs', get_context_instance(CONTEXT_SYSTEM))) {
    echo'<br><br><a href=# onClick="requestVacate.style.visibility=\'visible\';">'.get_string('requestvacate','block_mrbs').'</a>
        <form id="editing" method="post" target="_blank" action="'.$CFG->wwwroot.'/message/send.php">
        <div id="request_vacate">
        <input type="hidden" name="id" value="'.$row[12].'" />
        <input type="hidden" name="sesskey" value="'.$USER->sesskey.'" />';
        $usehtmleditor = (can_use_html_editor());
        if ($usehtmleditor) {
            echo '<table><tr><td class="fixeditor" align="center">';
            print_textarea($usehtmleditor, 15, 350, 0, 0, 'message', get_string('requestvacatemessage_html','block_mrbs',$messagelang));
            echo '</td></tr></table>';
            use_html_editor('message', 'formatblock subscript superscript copy cut paste clean undo redo justifyleft justifycenter justifyright justifyfull lefttoright righttoleft insertorderedlist insertunorderedlist outdent indent inserthorizontalrule createanchor nolink inserttable');
            echo '<input type="hidden" name="format" value="'.FORMAT_HTML.'" />';
        } else {
            print_textarea(false, 5, 34, 0, 0, 'message', get_string('requestvacatemessage','block_mrbs',$messagelang));
            echo '<input type="hidden" name="format" value="'.FORMAT_MOODLE.'" />';
        }
        //<textarea name = "message" cols=50 rows=10>'.get_string('requestvacatemessage','block_mrbs',$messagelang).'</textarea>
    echo'<input type="hidden" name="format" value="'.FORMAT_MOODLE.'" />
        <br /><input type="submit" value="'.get_string('sendmessage', 'message').'" />
        </div>
        </form>

        <SCRIPT LANGUAGE="JavaScript">
        requestVacate=document.getElementById(\'request_vacate\');
        requestVacate.style.visibility=\'hidden\';
        </SCRIPT>';
}
?>
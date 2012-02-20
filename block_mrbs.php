<?php // $Id: block_mrbs.php,v 1.11 2010/01/16 13:08:16 arborrow Exp $

class block_mrbs extends block_base {

    function init() {
        $this->title = get_string('blockname','block_mrbs');
        $this->content_type = BLOCK_TYPE_TEXT;
        $this->version = 2009061900;
        $this->cron=300;
    }
    function has_config() {return true;}

    /*
     * function applicable_formats() {
        return array('site' => true,'my' => true);
    }
    */

    function get_content () {
        global $USER, $CFG;
        $cfg_mrbs=get_config('block/mrbs');
        if ($this->content !== NULL) {
        return $this->content;
        }
        $context = get_context_instance(CONTEXT_SYSTEM, SITEID);
//        $context = get_context_instance(CONTEXT_BLOCK, $this->instance->id));
//        Not sure which context to use... Should this be defined site level or course level?
//        Defining as Site level        
        if ( has_capability('block/mrbs:viewmrbs', $context) or has_capability('block/mrbs:editmrbs', $context) or has_capability('block/mrbs:administermrbs', $context)) {
            if (isset($CFG->block_mrbs_serverpath)) {
                $serverpath = $CFG->block_mrbs_serverpath;
            } else {
                $serverpath = $CFG->wwwroot.'/blocks/mrbs/web';
            }
            $go = get_string('accessmrbs', 'block_mrbs');
            if ($cfg_mrbs->newwindow) {
                $this->content->text = '<a href="'.$serverpath.'/index.php" target="_blank">'.'<img src="' . $CFG->pixpath . '/f/web.gif" height="16" width="16" alt="" /> &nbsp;' . $go . ' </a>';
                $this->content->footer = '';
            } else {
                $this->content->text = '<a href="'.$serverpath.'/index.php">'.'<img src="' . $CFG->pixpath . '/f/web.gif" height="16" width="16" alt="" /> &nbsp;' . $go . ' </a>';
                $this->content->footer = '';
            }
            return $this->content;
        }
    }

    function cron(){
        global $CFG;
        include($CFG->dirroot.'/blocks/mrbs/import.php');
        
        //doesn't seem to update this automatically?
        $mrbsblock=get_record('block','name','mrbs');
        $mrbsblock->lastcron=mktime();
        update_record('block',$mrbsblock);
    }
}

?>

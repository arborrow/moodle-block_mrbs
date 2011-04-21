<?php
/**
 * This file imports bookings via CSV flatfile; it is intended to allow mrbs to be
 * populated with bookings from any other timetable sytem. It is intended to run
 *  regularly, it will replace any non-edited imported bookings with a new copy but
 * not any that have been edited.
 *
 * It is included by the blocks cron() function each time it runs
 */

//TODO:maybe set it up like tutorlink etc so that it can take uploaded files directly?

//record time for time taken stat
$script_start_time=time();

$cfg_mrbs = get_config('block/mrbs'); //get Moodle config settings for the MRBS block
$output='';
if (file_exists($cfg_mrbs->cronfile)) {
    if ($mrbs_sessions = fopen($cfg_mrbs->cronfile,'r')) {
        $output.= get_string('startedimport','block_mrbs')."\n";
        set_field_select('mrbs_entry', 'type', 'M', 'type=\'K\' and start_time > unix_timestamp()'); // Change old imported (type K) records to temporary type M
        $now = time();
        while ($array = fgetcsv($mrbs_sessions)) { //import timetable into mrbs
            $csvrow=new object;
            $csvrow->start_time=clean_param($array[0],PARAM_TEXT);
            $csvrow->end_time=clean_param($array[1],PARAM_TEXT);
            $csvrow->first_date=clean_param($array[2],PARAM_TEXT);
            $csvrow->weekpattern=clean_param($array[3],PARAM_TEXT);
            $csvrow->room_name=clean_param($array[4],PARAM_TEXT);
            $csvrow->username=clean_param($array[5],PARAM_TEXT);
            $csvrow->name=clean_param($array[6],PARAM_TEXT);
            $csvrow->description=clean_param($array[7],PARAM_TEXT);

            list($year, $month, $day) = split('[/]', $csvrow->first_date);
            $date = mktime(12,00,00,$month,$day,$year);
            $room = room_id_lookup($csvrow->room_name);
            $weeks =str_split($csvrow->weekpattern);
            foreach ($weeks as $week) {
                if (($week==1) and ($date > $now)) {
                    $start_time = time_to_datetime($date,$csvrow->start_time);
                    $end_time = time_to_datetime($date,$csvrow->end_time);
                    if (!is_timetabled($csvrow->name,$start_time)) { ////only timetable class if it isn't already timetabled elsewhere (class been moved)
                        $entry->start_time=$start_time;
                        $entry->end_time=$end_time;
                        $entry->room_id=$room;
                        $entry->timestamp=$now;
                        $entry->create_by=$csvrow->username;
                        $entry->name=$csvrow->name;
                        $entry->type='K';
                        $entry->description=$csvrow->description;
                        $newentryid=insert_record('mrbs_entry',$entry);

                        //If there is another non-imported booking there, send emails. It is assumed that simultanious imported classes are intentional
                        $sql = "SELECT *
                                FROM {$CFG->prefix}mrbs_entry
                                WHERE
                                    (({$CFG->prefix}mrbs_entry.start_time<$start_time AND {$CFG->prefix}mrbs_entry.end_time>$start_time)
                                  OR ({$CFG->prefix}mrbs_entry.start_time<$end_time AND {$CFG->prefix}mrbs_entry.end_time>$end_time)
                                  OR ({$CFG->prefix}mrbs_entry.start_time>=$start_time AND {$CFG->prefix}mrbs_entry.end_time<=$end_time ))
                                AND mdl_mrbs_entry.room_id = $room AND type<>'K'";

                        //limit to 1 to keep this simpler- if there is a 3-way clash it will be noticed by one of the 2 teachers notified
                        if ($existingclass=get_record_sql($sql,true)) {
                            $hr_start_time=date("j F, Y",$start_time) . ", " . to_hr_time($start_time);
                            $a = new object;
                            $a->oldbooking=$existingclass->description.'('.$existingclass->id.')';
                            $a->newbooking=$csvrow->description.'('.$newentryid.')';
                            $a->time=$hr_start_time;
                            $a->room=$csvrow->room_name;
                            $a->admin=$cfg_mrbs->admin.' ('.$cfg_mrbs->admin_email.')';
                            $output.= get_string('clash','block_mrbs',$a);

                            $existingteacher=get_record('user','username',$existingclass->create_by);
                            $newteacher=get_record('user','username',$csvrow->username);

                            $body = get_string('clashemailbody','block_mrbs',$a);

                            if (email_to_user($existingteacher,$newteacher,get_string('clashemailsub','block_mrbs',$a),$body)) {
                                $output.=', '.get_string('clashemailsent','block_mrbs').' '.$existingteacher->firstname.' '.$existingteacher->lastname.'<'.$existingteacher->email.'>';}else{$output.=get_string('clashemailnotsent','block_mrbs').$existingclass->description.'('.$existingclass->id.')';
                            }
                            if (email_to_user($newteacher,$existingteacher,get_string('clashemailsub','block_mrbs',$a),$body)){
                                $output.=', '.get_string('clashemailsent','block_mrbs').' '.$newteacher->firstname.' '.$newteacher->lastname.'<'.$newteacher->email.'>';
                            } else {
                                $output.=get_string('clashemailnotsent','block_mrbs').$csvrow->description.'('.$newentryid.')';
                            }
                            $output.="\n";
                        }
                    }
                }
                $date += 604800;

                //checks for being an hour out due to BST/GMT change and corrects
                if (date('G',$date)==01) {
                    $date = $date + 3600;
                }
                if (date('G',$date)==23) {
                    $date = $date - 3600;
                }
            }
        }

        // any remaining type M records are no longer in the import file, so delete
        delete_records_select('mrbs_entry', 'type=\'M\'');

        //move the processed file to prevent wasted time re-processing TODO: option for how long to keep these- I've found them useful for debugging but obviously can't keep them for ever
        $date=date('Ymd');
        if (rename($cfg_mrbs->cronfile,$cfg_mrbs->cronfile.'.'.$date)) {
            $output.=$cfg_mrbs->cronfile.get_string('movedto','block_mrbs').$cfg_mrbs->cronfile.'.'.$date."\n";
        }
        $script_time_taken = time() - $script_start_time;
        $output.=get_string('finishedimport','block_mrbs',$script_time_taken);

        
        echo $output; //will only show up if being run via apache

        //email output to admin
        if ($mrbsadmin=get_record('user','email',$cfg_mrbs->admin_email)) {
            email_to_user($mrbsadmin,$mrbsadmin,get_string('importlog','block_mrbs'),$output);
        }
    }
}
//==========================================FUNCTIONS==============================================================

//looks up the room id from the name
function room_id_lookup($name) {
    if (!$room=get_record('mrbs_room','room_name',$name)) {
        $error = "ERROR: failed to return id from database (room $name probably doesn't exist)";
        $output.= $error . "\n";
        return 'error';
    } else {
        return $room->id;
    }
}

/**
  * Checks if a class already has a timetable entry. If a previous imported entry exists,
  * and was edited, leave it. If it wasn't edited (flagged by type M), change it's type back to
  * K (to show it's an imported record), and return true. If there's no record for the class, or
  * updating the type back to K fails, return false.
  *
  * @param $name string name of the booking
  * @param $time int start time of the booking in unix timestamp format
  * @return bool does a previous booking exist?
  */
function is_timetabled($name,$time) {
    global $CFG;
    if (get_record_sql('select * from '.$CFG->prefix.'mrbs_entry where name=\''.$name.'\' and start_time = '.$time.' and type=\'L\'', true)) {
        return true;
    } else if($record = get_record_sql('select * from '.$CFG->prefix.'mrbs_entry where name=\''.$name.'\' and start_time = '.$time.' and type=\'M\'', true)) {
        $record->type = 'K';
        if (update_record('mrbs_entry', $record)) {
            return true;
        } else {
           return false;
        }
    } else {
        return false;
    }
}

 /**
  * Adds together a date (unixtime) and a time (hh:mm)
  *
  * @param $date integer date in seconds since epoch
  * @param $time string time in hh:mm format
  * @return integer date/time in seconds since epoch
  */
function time_to_datetime($date,$time) {
    list($hours,$mins)=explode(':',$time);
    return $date + 60*$mins + 3600*$hours;
}

 /**
  * Returns a human readable mrbs time from a unix timestamp.
  * If periods are enabled then gives the name of the period starting at this time
  * Will probably break is some idiot has more than 59 periods per day (seems very unlikely though)
  *
  * @param $time integer unix timestamp
  * @return string either the time formatted as hh:mm or the name of the period starting at this time
  */
function to_hr_time($time) {
    $cfg_mrbs = get_config('block/mrbs');
    if ($cfg_mrbs->enable_periods) {
        $periods=explode("\n",$cfg_mrbs->periods);
        $period=intval(date('i',$time));
        return trim($periods[$period]);
    } else {
        return date('G:i',$time);
    }
}

?>
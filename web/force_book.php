<?php

function mrbsForceMove($room_id, $starttime, $endtime,$name,$id=null){

    global $CFG;
    global $USER;
    global $DB;
    global $enable_periods;
    global $periods;

    $cfg_mrbs = get_config('block/mrbs');

    $output='';

//    # Select any meetings which overlap ($starttime,$endtime) for this room:
//    $sql = 'SELECT '.$CFG->prefix.'mrbs_entry.id AS entryid, '.$CFG->prefix.'mrbs_entry.name as entryname, '.$CFG->prefix.'mrbs_entry.description, type,'.$CFG->prefix.'mrbs_entry.create_by, '.$CFG->prefix.'mrbs_room.room_name, '.$CFG->prefix.'mrbs_entry.name, '.$CFG->prefix.'mrbs_entry.start_time, '.$CFG->prefix.'mrbs_entry.end_time, '.$CFG->prefix.'mrbs_room.description, area_id
//              FROM '.$CFG->prefix.'mrbs_entry join '.$CFG->prefix.'mrbs_room on '.$CFG->prefix.'mrbs_entry.room_id = '.$CFG->prefix.'mrbs_room.id
//             WHERE (('.$CFG->prefix.'mrbs_entry.start_time>='.$starttime.' AND '.$CFG->prefix.'mrbs_entry.end_time<'.$endtime.')
//             OR ('.$CFG->prefix.'mrbs_entry.start_time<'.$starttime.' AND '.$CFG->prefix.'mrbs_entry.end_time>'.$starttime.')
//             OR ('.$CFG->prefix.'mrbs_entry.start_time<'.$endtime.' AND '.$CFG->prefix.'mrbs_entry.end_time>='.$endtime.'))';
//
//    //this is so that if a booking is being edited (normally extended) and forcing the booking a confusing email doesn't get sent to the force booker
//    if(!empty($id)){
//        $sql.= ' AND '.$CFG->prefix.'mrbs_entry.id!='.$id;
//    }
//    $sql.=' AND room_id = '.$room_id.' ORDER BY start_time';

    # Select any meetings which overlap ($starttime,$endtime) for this room:
    $sql = 'SELECT e.id AS entryid,
        e.name as entryname,
        e.description as description,
        e.type as type,
        e.create_by,
        e.room_id,
        e.name,
        e.start_time,
        e.end_time,
        r.room_name,
        r.description,
        r.area_id
              FROM {mrbs_entry} AS e
              JOIN {mrbs_room} AS r
              ON e.room_id = r.id
             WHERE ((e.start_time >= ? AND e.end_time < ?)
             OR (e.start_time < ? AND e.end_time > ?)
             OR (e.start_time < ? AND e.end_time >= ?))';

    //this is so that if a booking is being edited (normally extended) and forcing the booking a confusing email doesn't get sent to the force booker
    if(!empty($id)){
        $sql.= ' AND e.id!=?';
    }
    $sql.=' AND e.room_id = ? ORDER BY e.start_time';

    if(!empty($id)) {
        $oldbookings = $DB->get_records_sql($sql,array($starttime,$endtime,$starttime,$starttime,$endtime,$endtime,$id,$room_id));
    } else {
        $oldbookings = $DB->get_records_sql($sql,array($starttime,$endtime,$starttime,$starttime,$endtime,$endtime,$room_id));
    }


//    if ($oldbookings=get_records_sql($sql)){
    if($oldbookings) {
        foreach($oldbookings as $oldbooking){

            $today=mktime(0,0,0,date('n'),date('j'),date('Y'));
            $hrstarttime=to_hr_time($oldbooking->start_time-($today));

            //Work out how many students so they don't get put in a tiny classroom
//            $sizequery='select count(*) as count
//                        from '.$CFG->prefix.'context
//                            join '.$CFG->prefix.'role_assignments on '.$CFG->prefix.'role_assignments.contextid = '.$CFG->prefix.'context.id and '.$CFG->prefix.'role_assignments.roleid=5
//                            join '.$CFG->prefix.'course on '.$CFG->prefix.'context.contextlevel = 50 and '.$CFG->prefix.'context.instanceid = '.$CFG->prefix.'course.id
//                        where '.$CFG->prefix.'course.shortname  =\''.clean_param($oldbooking->entryname,PARAM_TEXT).'\'';
            //TODO: THIS NEEDS TO BE REWRITTEN TO SUPPORT NEW ENROLLMENTS
            $sizequery='SELECT count(*) as count
                        FROM {context} AS c
                            JOIN {role_assignments} AS ra
                                ON ra.contextid = c.id AND ra.roleid = ?
                            JOIN {course} AS co 
                                ON c.contextlevel = ? and c.instanceid = co.id
                        WHERE co.shortname  = ?';
            $shortname = clean_param($oldbooking->entryname,PARAM_TEXT);

//            if ($result=get_record_sql($sizequery)){
            if ($result=$DB->get_record_sql($sizequery, array('5','50', $shortname))){
                $class_size=$result->count;
            }else{
                $class_size=0;
            }
//            $findroomquery = 'SELECT DISTINCT '.$CFG->prefix.'mrbs_room.id, '.$CFG->prefix.'mrbs_room.room_name, '.$CFG->prefix.'mrbs_area.area_name,
//                                 CONCAT(IF('.$CFG->prefix.'mrbs_room.description = \''.$oldbooking->description.'\',1,0),IF('.$CFG->prefix.'mrbs_area.id= \''.$oldbooking->area_id.'\',1,0)) as sort
//                             FROM '.$CFG->prefix.'mrbs_room JOIN '.$CFG->prefix.'mrbs_area on '.$CFG->prefix.'mrbs_room.area_id='.$CFG->prefix.'mrbs_area.id join '.$CFG->prefix.'mrbs_entry on '.$CFG->prefix.'mrbs_room.id='.$CFG->prefix.'mrbs_entry.room_id
//                             WHERE ( SELECT COUNT(*) FROM '.$CFG->prefix.'mrbs_entry
//                                 WHERE (('.$CFG->prefix.'mrbs_entry.start_time>='.$oldbooking->start_time.' AND '.$CFG->prefix.'mrbs_entry.end_time<'.$oldbooking->end_time.')
//                                 OR ('.$CFG->prefix.'mrbs_entry.start_time<'.$oldbooking->start_time.' AND '.$CFG->prefix.'mrbs_entry.end_time>'.$oldbooking->start_time.')
//                                 OR ('.$CFG->prefix.'mrbs_entry.start_time<'.$oldbooking->end_time.' AND '.$CFG->prefix.'mrbs_entry.end_time>='.$oldbooking->end_time.'))
//                                 AND mdl_mrbs_entry.room_id = mdl_mrbs_room.id ) < 1
//                             AND '.$CFG->prefix.'mrbs_room.description like \'%teaching%\'
//                             AND '.$CFG->prefix.'mrbs_room.capacity >='.$class_size.'
//                             AND ('.$CFG->prefix.'mrbs_room.description not like \'%special%\' OR '.$CFG->prefix.'mrbs_area.id=\''.$oldbooking->area_id.'\')
//                             ORDER BY sort DESC';

            $findroomquery = 'SELECT DISTINCT
                                r.id,
                                r.room_name,
                                a.area_name,
                                CONCAT(IF(r.description = ?,1,0),
                                IF(a.id= ?,1,0)) AS sort
                             FROM {mrbs_room} AS r
                             JOIN {mrbs_area} AS a
                                ON r.area_id = a.id
                             JOIN {mrbs_entry} AS e
                                ON r.id= e.room_id
                             WHERE ( SELECT COUNT(*) FROM {mrbs_entry} AS e2
                                 WHERE ((e2.start_time >= ? AND e2.end_time < ?)
                                 OR (e2.start_time < ? AND e2.end_time > ?)
                                 OR (e2.start_time < ? AND e2.end_time >= ?))
                                 AND e2.room_id = r.id ) < 1
                             AND r.description like ?
                             AND r.capacity >= ?
                             AND (r.description not like ?
                             OR r.id= ?)
                             ORDER BY sort DESC';

            //dump them in first room on the list
//            $findroomresult=get_record_sql($findroomquery,true);
            $params = array($oldbooking->description,
                            $oldbooking->area_id,
                            $oldbooking->start_time,
                            $oldbooking->end_time,
                            $oldbooking->start_time,
                            $oldbooking->start_time,
                            $oldbooking->end_time,
                            $oldbooking->end_time,
                            '%teaching%',
                            $class_size,
                            '%special%',
                            $oldbooking->area_id);

            $findroomresult=$DB->get_record_sql($findroomquery,$params);

            $subject=get_string('bookingmoved','block_mrbs');
            $langvars=new object();
            $langvars->name=$oldbooking->entryname;
            $langvars->id=$oldbooking->entryid;
            $langvars->oldroom=$oldbooking->room_name;
            $langvars->newroom=$findroomresult->room_name;
            $langvars->area=$findroomresult->area_name;
            $langvars->date=date('d/m/Y',$oldbooking->start_time);
            $langvars->starttime=$hrstarttime;
            $langvars->newbookingname=$name;
            
            $booking = new object;
            $booking->id=$oldbooking->entryid;
            $booking->room_id=$findroomresult->id;
            
            //If it is an imported booking, mark it as edited
            if($oldbooking->type=='K'){
                $booking->type='L';
            }else{
                $booking->type=$oldbooking->type;
            }
            if($findroomresult and update_record('mrbs_entry',$booking) and $oldbookingowner=$DB->get_record('user',array('username'=>$oldbooking->create_by))){
                $message=get_string('bookingmovedmessage','block_mrbs',$langvars);
                $output.= '<br>'.get_string('bookingmovedshort','block_mrbs',$langvars);
                email_to_user($oldbookingowner,$USER,$subject,$message);
            }else{
                $output.= '<br>'.get_string('bookingmoveerrorshort','block_mrbs',$langvars);
                mail($cfg_mrbs->admin_email,get_string('bookingmoveerror','block_mrbs'),get_string('bookingmoveerrormessage','block_mrbs',$langvars));
            }
        }
    }
    return $output;
}
?>
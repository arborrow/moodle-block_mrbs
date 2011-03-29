<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:13 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a Chinese (zh-tw Big5) file.
//
//
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname']          = 'Booking system';
$string['accessmrbs']         = 'Schedule a Resource';

// Used in style.inc
$string["mrbs"]               = "會議室預約系統";

// Used in functions.inc
$string["report"]             = "報表";
$string["admin"]              = "系統管理";
$string["help"]               = "說明";
$string["search"]             = "搜尋";
$string["not_php3"]           = "WARNING: This probably doesn't work with PHP3";

// Used in day.php
$string["bookingsfor"]        = "預約";
$string["bookingsforpost"]    = "";
$string["areas"]              = "區域";
$string["daybefore"]          = "查看前一天";
$string["dayafter"]           = "查看後一天";
$string["gototoday"]          = "查看今天";
$string["goto"]               = "goto";
$string["highlight_line"]     = "加強顯示這行";
$string["click_to_reserve"]   = "點選格子進行預約登記";

// Used in trailer.inc
$string["viewday"]            = "查看日期 ";
$string["viewweek"]           = "週顯示";
$string["viewmonth"]          = "月顯示";
$string["ppreview"]           = "預覽列印";

// Used in edit_entry.php
$string["addentry"]           = "新增";
$string["editentry"]          = "修改";
$string["editseries"]         = "整批修改";
$string["namebooker"]         = "預約人姓名";
$string["fulldescription"]    = "說明:<br>&nbsp;&nbsp;(聯約電話,部門,,<br>&nbsp;&nbsp;會議主題 等)";
$string["date"]               = "日期";
$string["start_date"]         = "起始時間";
$string["end_date"]           = "結束時間";
$string["time"]               = "時間";
$string["period"]             = "Period";
$string["duration"]           = "持續時間";
$string["seconds"]            = "秒";
$string["minutes"]            = "分";
$string["hours"]              = "小時";
$string["days"]               = "天";
$string["weeks"]              = "星期";
$string["years"]              = "年";
$string["periods"]            = "periods";
$string["all_day"]            = "整天";
$string["type"]               = "種類";
$string["internal"]           = "內部使用";
$string["external"]           = "外部使用";
$string["save"]               = "儲存";
$string["rep_type"]           = "重覆預約";
$string["rep_type_0"]         = "不重覆";
$string["rep_type_1"]         = "每天";
$string["rep_type_2"]         = "每週";
$string["rep_type_3"]         = "每月";
$string["rep_type_4"]         = "每年";
$string["rep_type_5"]         = "每月對應的日期";
$string["rep_type_6"]         = "(每週)";
$string["rep_end_date"]       = "結束重覆的日期";
$string["rep_rep_day"]        = "重覆的星期";
$string["rep_for_weekly"]     = "(每週)";
$string["rep_freq"]           = "頻率";
$string["rep_num_weeks"]      = "重覆幾週";
$string["rep_for_nweekly"]    = "(每週)";
$string["ctrl_click"]         = "用Control+滑鼠右鍵可以重覆選擇";
$string["entryid"]            = "登記序號 ";
$string["repeat_id"]          = "重覆序號 "; 
$string["you_have_not_entered"] = "你沒有輸入";
$string["you_have_not_selected"] = "你沒有選";
$string["valid_room"]         = "會議室/設備.";
$string["valid_time_of_day"]  = "可以預約的時間.";
$string["brief_description"]  = "簡要說明.";
$string["useful_n-weekly_value"] = "可以提供預約的星期.";

// Used in view_entry.php
$string["description"]        = "說明";
$string["room"]               = "會議室/設備";
$string["createdby"]          = "預約人";
$string["lastupdate"]         = "最後更新";
$string["deleteentry"]        = "刪除";
$string["deleteseries"]       = "整批刪除";
$string["confirmdel"]         = "你確定要刪除此記錄??\\n";
$string["returnprev"]         = "回前一頁";
$string["invalid_entry_id"]   = "預約序號錯誤.";
$string["invalid_series_id"]  = "序列號錯誤.";

// Used in edit_entry_handler.php
$string["error"]              = "錯誤";
$string["sched_conflict"]     = "時段衝突";
$string["conflict"]           = "此時段已被預約";
$string["too_may_entrys"]     = "這個選擇造成太多輸入.<br>請重新選擇!";
$string["returncal"]          = "查看日程表";
$string["failed_to_acquire"]  = "無法存取資料庫"; 

// Authentication stuff
$string["accessdenied"]       = "限制存取";
$string["norights"]           = "您無權利修改此筆記錄!!";
$string["please_login"]       = "請先登入";
$string["user_name"]          = "名稱";
$string["user_password"]      = "密碼";
$string["unknown_user"]       = "使用者不存在或密碼錯誤";
$string["you_are"]            = "您是";
$string["login"]              = "登入";
$string["logoff"]             = "登出";

// Authentication database
$string["user_list"]          = "使用者清單";
$string["edit_user"]          = "編輯使用者";
$string["delete_user"]        = "刪除使用者";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Email address";
$string["password_twice"]     = "If you wish to change the password, please type the new password twice";
$string["passwords_not_eq"]   = "Error: The passwords do not match.";
$string["add_new_user"]       = "新增使用者";
$string["rights"]             = "權限";
$string["action"]             = "動作";
$string["user"]               = "使用者";
$string["administrator"]      = "管理者";
$string["unknown"]            = "未知的";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "顯示全部我的預約";

// Used in search.php
$string["invalid_search"]     = "空的或不合法的搜尋字串.";
$string["search_results"]     = "搜尋結果";
$string["nothing_found"]      = "找不到.";
$string["records"]            = "紀錄";
$string["through"]            = "經由";
$string["of"]                 = " of ";
$string["previous"]           = "前一個";
$string["next"]               = "下一個";
$string["entry"]              = "登錄";
$string["view"]               = "顯示";
$string["advanced_search"]    = "進階搜尋";
$string["search_button"]      = "搜尋";
$string["search_for"]         = "搜尋";
$string["from"]               = "From";

// Used in report.php
$string["report_on"]          = "會議室報表";
$string["report_start"]       = "報表起始日";
$string["report_end"]         = "報表結束日";
$string["match_area"]         = "符合的種類";
$string["match_room"]         = "符合的會議室";
$string["match_type"]         = "符合的類型";
$string["ctrl_click_type"]    = "使用Control-Click選取一個以上的類型";
$string["match_entry"]        = "符合部份的簡述";
$string["match_descr"]        = "符合全部簡述";
$string["include"]            = "包含";
$string["report_only"]        = "只要明細";
$string["summary_only"]       = "只要加總";
$string["report_and_summary"] = "明細和加總";
$string["summarize_by"]       = "加總項目";
$string["sum_by_descrip"]     = "簡述";
$string["sum_by_creator"]     = "預約人";
$string["entry_found"]        = "找到預約";
$string["entries_found"]      = "找到預約";
$string["summary_header"]     = "總共預約(小時)";
$string["summary_header_per"] = "總共預約(次)";
$string["total"]              = "全部";
$string["submitquery"]        = "產生報表";
$string["sort_rep"]           = "排序";
$string["sort_rep_time"]      = "起始日/時";
$string["rep_dsp"]            = "顯示在報表";
$string["rep_dsp_dur"]        = "持續時間";
$string["rep_dsp_end"]        = "結束時間";

// Used in week.php
$string["weekbefore"]         = "前一週";
$string["weekafter"]          = "後一週";
$string["gotothisweek"]       = "這一週";

// Used in month.php
$string["monthbefore"]        = "上一月";
$string["monthafter"]         = "下一月";
$string["gotothismonth"]      = "這個月";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "這個種類沒有定義會議室/設備";

// Used in admin.php
$string["edit"]               = "編輯";
$string["delete"]             = "刪除";
$string["rooms"]              = "會議室/設備";
$string["in"]                 = "在";
$string["noareas"]            = "沒有種類";
$string["addarea"]            = "新增種類";
$string["name"]               = "名稱";
$string["noarea"]             = "還沒選擇種類";
$string["browserlang"]        = "你的瀏覽器設為";
$string["addroom"]            = "新增會議室/設備";
$string["capacity"]           = "容量";
$string["norooms"]            = "沒有會議室/設備.";
$string["administration"]     = "管理者";

// Used in edit_area_room.php
$string["editarea"]           = "新增種類";
$string["change"]             = "改變";
$string["backadmin"]          = "回到管理首頁";
$string["editroomarea"]       = "修改描述";
$string["editroom"]           = "修改會議室/設備";
$string["update_room_failed"] = "更新失敗: ";
$string["error_room"]         = "錯誤: 會議室/設備 ";
$string["not_found"]          = "找不到";
$string["update_area_failed"] = "更新區域失敗: ";
$string["error_area"]         = "錯誤: 區域 ";
$string["room_admin_email"]   = "會議室管理者email";
$string["area_admin_email"]   = "區域管理者email";
$string["invalid_email"]      = "不合法的email!";

// Used in del.php
$string["deletefollowing"]    = "這個動作會刪除相關的預約紀錄";
$string["sure"]               = "確定嗎?";
$string["YES"]                = "YES";
$string["NO"]                 = "NO";
$string["delarea"]            = "你必須先刪除所屬的會議室<p>";

// Used in help.php
$string["about_mrbs"]         = "關於MRBS";
$string["database"]           = "資料庫";
$string["system"]             = "系統";
$string["please_contact"]     = "請聯絡";
$string["for_any_questions"]  = ",關於任何在這裡找不到答案的問題.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Fatal Error: 無法連上資料庫";

?>

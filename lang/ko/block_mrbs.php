<?php // -*-mode: PHP; coding:utf-8;-*-
// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:13 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a Korean file.
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
$string["mrbs"]               = "회의실 예약 시스템";

// Used in functions.inc
$string["report"]             = "보고서";
$string["admin"]              = "관리자";
$string["help"]               = "도움말";
$string["search"]             = "검색";
$string["not_php3"]           = "주의: PHP3에서는 동작하지 않습니다.";

// Used in day.php
$string["bookingsfor"]        = "Bookings for";
$string["bookingsforpost"]    = "의 예약입니다.";
$string["areas"]              = "지역";
$string["daybefore"]          = "이전으로";
$string["dayafter"]           = "다음으로";
$string["gototoday"]          = "오늘의 예약";
$string["goto"]               = "바로가기";
$string["highlight_line"]     = "Highlight this line";
$string["click_to_reserve"]   = "Click on the cell to make a reservation.";

// Used in trailer.inc
$string["viewday"]            = "일 단위";
$string["viewweek"]           = "주 단위";
$string["viewmonth"]          = "월 단위";
$string["ppreview"]           = "인쇄용 미리보기";

// Used in edit_entry.php
$string["addentry"]           = "예약 등록";
$string["editentry"]          = "예약 수정";
$string["editseries"]         = "예약(Series) 수정";
$string["namebooker"]         = "예약자명";
$string["fulldescription"]    = "상세정보(인원,내부/외부회의 등)";
$string["date"]               = "날짜";
$string["start_date"]         = "시작일";
$string["end_date"]           = "종료일";
$string["time"]               = "시간";
$string["period"]             = "기간";
$string["duration"]           = "회의 시간";
$string["seconds"]            = "초";
$string["minutes"]            = "분";
$string["hours"]              = "시간";
$string["days"]               = "일";
$string["weeks"]              = "주";
$string["years"]              = "년";
$string["periods"]            = "기간";
$string["all_day"]            = "하루종일";
$string["type"]               = "회의 종류";
$string["internal"]           = "내부회의";
$string["external"]           = "외부회의";
$string["save"]               = "보존";
$string["rep_type"]           = "반복 타입";
$string["rep_type_0"]         = "없음";
$string["rep_type_1"]         = "일간";
$string["rep_type_2"]         = "주간";
$string["rep_type_3"]         = "월간";
$string["rep_type_4"]         = "연간";
$string["rep_type_5"]         = "월간, 해당일";
$string["rep_type_6"]         = "몇주간";
$string["rep_end_date"]       = "반복 종료일";
$string["rep_rep_day"]        = "반복일";
$string["rep_for_weekly"]     = "(몇 주간용)";
$string["rep_freq"]           = "빈도";
$string["rep_num_weeks"]      = "몇 주";
$string["rep_for_nweekly"]    = "(몇 주간용)";
$string["ctrl_click"]         = "2개 이상을 선택하기 위해서는 Control-Click을 사용하세요";
$string["entryid"]            = "엔트리 ID ";
$string["repeat_id"]          = "반복 ID "; 
$string["you_have_not_entered"] = "You have not entered a";
$string["you_have_not_selected"] = "You have not selected a";
$string["valid_room"]         = "room.";
$string["valid_time_of_day"]  = "valid time of day.";
$string["brief_description"]  = "간략 설명";
$string["useful_n-weekly_value"] = "useful n-weekly value.";

// Used in view_entry.php
$string["description"]        = "설명";
$string["room"]               = "회의실명";
$string["createdby"]          = "예약자";
$string["lastupdate"]         = "최종 갱신일";
$string["deleteentry"]        = "예약 취소";
$string["deleteseries"]       = "예약(Series) 취소";
$string["confirmdel"]         = "예약을 취소하시겠습니까?";
$string["returnprev"]         = "이전 페이지로";
$string["invalid_entry_id"]   = "무효한 엔트리 ID.";
$string["invalid_series_id"]  = "무효한 Serires ID.";

// Used in edit_entry_handler.php
$string["error"]              = "에러";
$string["sched_conflict"]     = "스케쥴 중복";
$string["conflict"]           = "이미 다른 예약이 되어있습니다.";
$string["too_may_entrys"]     = "선택한 옵션은 너무 많은 엔트리를 작성하게 됩니다.<br>다른 옵션을 선택해 주세요.";
$string["returncal"]          = "달력 화면으로 돌아감";
$string["failed_to_acquire"]  = "데이타베이스 접근에 실패하였습니다."; 

// Authentication stuff
$string["accessdenied"]       = "접근이 거부됨";
$string["norights"]           = "수정할 수 있는 권한이 없습니다.";
$string["please_login"]       = "로그인 하여 주십시오";
$string["user_name"]          = "아이디";
$string["user_password"]      = "비밀번호";
$string["unknown_user"]       = "권한없는 사용자";
$string["you_are"]            = "아이디: ";
$string["login"]              = "로그인";
$string["logoff"]             = "로그아웃";

// Authentication database
$string["user_list"]          = "사용자 리스트";
$string["edit_user"]          = "사용자 수정";
$string["delete_user"]        = "사용자 삭제";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "메일 주소";
$string["password_twice"]     = "비밀번호를 변경하시려면, 새로운 비밀번호를 2회 입력하세요.";
$string["passwords_not_eq"]   = "에러: 비밀번호가 바르지 않습니다.";
$string["add_new_user"]       = "사용자 추가";
$string["rights"]             = "권한";
$string["action"]             = "동작";
$string["user"]               = "사용자";
$string["administrator"]      = "관리자";
$string["unknown"]            = "Unknown";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "Click to display all my upcoming entries";

// Used in search.php
$string["invalid_search"]     = "잘못된 검색어를 입력했음.";
$string["search_results"]     = "검색 결과";
$string["nothing_found"]      = "검색 결과가 없습니다.";
$string["records"]            = "Records ";
$string["through"]            = " through ";
$string["of"]                 = " of ";
$string["previous"]           = "이전";
$string["next"]               = "이후";
$string["entry"]              = "Entry";
$string["view"]               = "View";
$string["advanced_search"]    = "상세 검색";
$string["search_button"]      = "검색";
$string["search_for"]         = "Search For";
$string["from"]               = "From";

// Used in report.php
$string["report_on"]          = "회의에 관한 보고서 작성";
$string["report_start"]       = "시작일";
$string["report_end"]         = "종료일";
$string["match_area"]         = "검색할 지역";
$string["match_room"]         = "검색할 회의실";
$string["match_type"]         = "회의 타입";
$string["ctrl_click_type"]    = "2개 이상을 선택할 경우는 Control-Click을 사용하세요.";
$string["match_entry"]        = "검색할 설명";
$string["match_descr"]        = "검색할 상세 정보";
$string["include"]            = "포함";
$string["report_only"]        = "보고서만";
$string["summary_only"]       = "요약정보만";
$string["report_and_summary"] = "보고서 및 요약정보";
$string["summarize_by"]       = "다음에 의해 요약됨";
$string["sum_by_descrip"]     = "간략 설명";
$string["sum_by_creator"]     = "작성자";
$string["entry_found"]        = "entry found";
$string["entries_found"]      = "entries found";
$string["summary_header"]     = "Summary of (Entries) Hours";
$string["summary_header_per"] = "Summary of (Entries) Periods";
$string["total"]              = "전체";
$string["submitquery"]        = "보고서 실행";
$string["sort_rep"]           = "정렬 순서";
$string["sort_rep_time"]      = "시작 일/시간";
$string["rep_dsp"]            = "Display in report";
$string["rep_dsp_dur"]        = "기간";
$string["rep_dsp_end"]        = "종료 시간";

// Used in week.php
$string["weekbefore"]         = "저번 주로";
$string["weekafter"]          = "다음 주로";
$string["gotothisweek"]       = "이번 주로";

// Used in month.php
$string["monthbefore"]        = "저번 달로";
$string["monthafter"]         = "다음 달로";
$string["gotothismonth"]      = "이번 달로";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "등록된 회의실이 없습니다.";

// Used in admin.php
$string["edit"]               = "수정";
$string["delete"]             = "삭제";
$string["rooms"]              = "회의실";
$string["in"]                 = "in";
$string["noareas"]            = "등록된 지역가 없음";
$string["addarea"]            = "지역 추가";
$string["name"]               = "이름";
$string["noarea"]             = "지역이 선택되지 않았음";
$string["browserlang"]        = "당신의 브라우저는 다음 언어를 사용하도록 설정되어 있음: ";
$string["addroom"]            = "회의실 추가";
$string["capacity"]           = "수용가능 인원";
$string["norooms"]            = "등록된 회의실이 없음";
$string["administration"]     = "지역 및 회의실 관리";

// Used in edit_area_room.php
$string["editarea"]           = "지역 수정";
$string["change"]             = "수정";
$string["backadmin"]          = "돌아가기";
$string["editroomarea"]       = "지역 또는 회의실 수정";
$string["editroom"]           = "회의실 수정";
$string["update_room_failed"] = "회의실 수정 실패: ";
$string["error_room"]         = "에러: 회의실  ";
$string["not_found"]          = "이(가) 발견되지 않음";
$string["update_area_failed"] = "지역 수정 실패: ";
$string["error_area"]         = "에러: 지역  ";
$string["room_admin_email"]   = "회의실 관리자 메일주소";
$string["area_admin_email"]   = "지역 관리자 메일주소";
$string["invalid_email"]      = "잘못된 메일주소입니다!";

// Used in del.php
$string["deletefollowing"]    = "다음의 예약들이 삭제됩니다.";
$string["sure"]               = "삭제하시겠습니까?";
$string["YES"]                = "예";
$string["NO"]                 = "아니오";
$string["delarea"]            = "지우기 전에 이 지역안에 있는 모든 회의실을 지워야 합니다.<p>";

// Used in help.php
$string["about_mrbs"]         = "About MRBS";
$string["database"]           = "Database";
$string["system"]             = "System";
$string["please_contact"]     = "자세한 사항은 다음 관리자에게 연락주십시오: ";
$string["for_any_questions"]  = " ";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "심각한 에러: 데이터베이스에 접속할 수 없습니다.";

?>

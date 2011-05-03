<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:12 arborrow Exp $

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
$string["mrbs"]               = "会议室预订管理系统";

// Used in functions.inc
$string["report"]             = "报表";
$string["admin"]              = "系统管理";
$string["help"]               = "说明";
$string["search"]             = "查找";
$string["not_php3"]           = "警告: 无法运行于PHP3环境";

// Used in day.php
$string["bookingsfor"]        = "预订:";
$string["bookingsforpost"]    = "";
$string["areas"]              = "区域";
$string["daybefore"]          = "查看前一天";
$string["dayafter"]           = "查看后一天";
$string["gototoday"]          = "查看今天";
$string["goto"]               = "跳转";
$string["highlight_line"]     = "加强显示这行";
$string["click_to_reserve"]   = "点击格子进行预订";

// Used in trailer.inc
$string["viewday"]            = "查看日期 ";
$string["viewweek"]           = "周显示";
$string["viewmonth"]          = "月显示";
$string["ppreview"]           = "打印预览";

// Used in edit_entry.php
$string["addentry"]           = "新增";
$string["editentry"]          = "修改";
$string["editseries"]         = "批量修改";
$string["namebooker"]         = "预订人姓名";
$string["fulldescription"]    = "说明:<br>&nbsp;&nbsp;(联系电话,部门,,<br>&nbsp;&nbsp;会议主题 等)";
$string["date"]               = "日期";
$string["start_date"]         = "起始时间";
$string["end_date"]           = "结束时间";
$string["time"]               = "时间";
$string["period"]             = "Period";
$string["duration"]           = "持续时间";
$string["seconds"]            = "秒";
$string["minutes"]            = "分";
$string["hours"]              = "小时";
$string["days"]               = "天";
$string["weeks"]              = "星期";
$string["years"]              = "年";
$string["periods"]            = "periods";
$string["all_day"]            = "整天";
$string["type"]               = "种类";
$string["internal"]           = "内部使用";
$string["external"]           = "外部使用";
$string["save"]               = "保存";
$string["rep_type"]           = "重复预订";
$string["rep_type_0"]         = "不重复";
$string["rep_type_1"]         = "每天";
$string["rep_type_2"]         = "每周";
$string["rep_type_3"]         = "每月";
$string["rep_type_4"]         = "每年";
$string["rep_type_5"]         = "每月对应的日期";
$string["rep_type_6"]         = "(每周)";
$string["rep_end_date"]       = "结束重复的日期";
$string["rep_rep_day"]        = "重复的星期";
$string["rep_for_weekly"]     = "(每周)";
$string["rep_freq"]           = "频率";
$string["rep_num_weeks"]      = "重复几周";
$string["rep_for_nweekly"]    = "(每周)";
$string["ctrl_click"]         = "用Ctrl+鼠标右键可以重复选择";
$string["entryid"]            = "登记序号 ";
$string["repeat_id"]          = "重复序号 "; 
$string["you_have_not_entered"] = "你没有输入";
$string["you_have_not_selected"] = "你没有选择";
$string["valid_room"]         = "会议室/设备.";
$string["valid_time_of_day"]  = "可以预订的时间.";
$string["brief_description"]  = "简要说明.";
$string["useful_n-weekly_value"] = "可以提供预订的星期.";

// Used in view_entry.php
$string["description"]        = "说明";
$string["room"]               = "会议室/设备";
$string["createdby"]          = "预订人";
$string["lastupdate"]         = "最后更新";
$string["deleteentry"]        = "删除";
$string["deleteseries"]       = "整批删除";
$string["confirmdel"]         = "你确定要删除此记录??\\n";
$string["returnprev"]         = "回前一页";
$string["invalid_entry_id"]   = "预订序号错误.";
$string["invalid_series_id"]  = "序列号错误.";

// Used in edit_entry_handler.php
$string["error"]              = "错误";
$string["sched_conflict"]     = "时段冲突";
$string["conflict"]           = "此时段已被预订";
$string["too_may_entrys"]     = "这个选择造成太多输入.<br>请重新选择!";
$string["returncal"]          = "查看日程表";
$string["failed_to_acquire"]  = "无法读取资料库"; 

// Authentication stuff
$string["accessdenied"]       = "限制读取";
$string["norights"]           = "您无权限修改此笔记录!!";
$string["please_login"]       = "请先登录";
$string["user_name"]          = "名称";
$string["user_password"]      = "密码";
$string["unknown_user"]       = "用户不存在或密码错误";
$string["you_are"]            = "您是";
$string["login"]              = "登录";
$string["logoff"]             = "注销";

// Authentication database
$string["user_list"]          = "用户清单";
$string["edit_user"]          = "编辑用户";
$string["delete_user"]        = "删除用户";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Email 地址";
$string["password_twice"]     = "如果需要修改密码，请输入两次新密码";
$string["passwords_not_eq"]   = "错误: 密码不匹配.";
$string["add_new_user"]       = "新增用户";
$string["rights"]             = "权限";
$string["action"]             = "动作";
$string["user"]               = "用户";
$string["administrator"]      = "管理员";
$string["unknown"]            = "未知的";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "显示全部我的预订";

// Used in search.php
$string["invalid_search"]     = "空的或不合法的查找字串.";
$string["search_results"]     = "查找结果:";
$string["nothing_found"]      = "找不到.";
$string["records"]            = "记录";
$string["through"]            = "经过";
$string["of"]                 = " of ";
$string["previous"]           = "前一个";
$string["next"]               = "下一个";
$string["entry"]              = "登录";
$string["view"]               = "显示";
$string["advanced_search"]    = "高级查找";
$string["search_button"]      = "查找";
$string["search_for"]         = "查找";
$string["from"]               = "从";

// Used in report.php
$string["report_on"]          = "会议室报表";
$string["report_start"]       = "报表起始日";
$string["report_end"]         = "报表结束日";
$string["match_area"]         = "符合的区域";
$string["match_room"]         = "符合的会议室";
$string["match_type"]         = "符合的类型";
$string["ctrl_click_type"]    = "使用Ctrl键选取一个以上的类型";
$string["match_entry"]        = "符合部份描述";
$string["match_descr"]        = "符合全部描述";
$string["include"]            = "包含";
$string["report_only"]        = "只要明细";
$string["summary_only"]       = "只要汇总";
$string["report_and_summary"] = "明细和汇总";
$string["summarize_by"]       = "汇总项目";
$string["sum_by_descrip"]     = "简述";
$string["sum_by_creator"]     = "预订人";
$string["entry_found"]        = "找到预订";
$string["entries_found"]      = "找到预订";
$string["summary_header"]     = "总共预订(小时)";
$string["summary_header_per"] = "总共预订(次)";
$string["total"]              = "全部";
$string["submitquery"]        = "产生报表";
$string["sort_rep"]           = "排序";
$string["sort_rep_time"]      = "起始日/时";
$string["rep_dsp"]            = "显示在报表";
$string["rep_dsp_dur"]        = "持续时间";
$string["rep_dsp_end"]        = "结束时间";

// Used in week.php
$string["weekbefore"]         = "前一周";
$string["weekafter"]          = "后一周";
$string["gotothisweek"]       = "这一周";

// Used in month.php
$string["monthbefore"]        = "上一月";
$string["monthafter"]         = "下一月";
$string["gotothismonth"]      = "这个月";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "这个区域没有定义会议室/设备";

// Used in admin.php
$string["edit"]               = "编辑";
$string["delete"]             = "删除";
$string["rooms"]              = "会议室/设备";
$string["in"]                 = "在";
$string["noareas"]            = "没有区域";
$string["addarea"]            = "新增区域";
$string["name"]               = "名称";
$string["noarea"]             = "还没选择区域";
$string["browserlang"]        = "你的浏览器设为";
$string["addroom"]            = "新增会议室/设备";
$string["capacity"]           = "容纳人数";
$string["norooms"]            = "没有会议室/设备.";
$string["administration"]     = "管理者";

// Used in edit_area_room.php
$string["editarea"]           = "修改区域";
$string["change"]             = "改变";
$string["backadmin"]          = "回到管理首页";
$string["editroomarea"]       = "修改描述";
$string["editroom"]           = "修改会议室/设备";
$string["update_room_failed"] = "更新失败: ";
$string["error_room"]         = "错误: 会议室/设备 ";
$string["not_found"]          = "找不到";
$string["update_area_failed"] = "更新区域信息失败: ";
$string["error_area"]         = "错误: 区域 ";
$string["room_admin_email"]   = "会议室管理员email";
$string["area_admin_email"]   = "区域管理员email";
$string["invalid_email"]      = "无效的email!";

// Used in del.php
$string["deletefollowing"]    = "这个操作会删除相关的预订纪录";
$string["sure"]               = "确定吗?";
$string["YES"]                = "YES";
$string["NO"]                 = "NO";
$string["delarea"]            = "你必须先删除所属的会议室<p>";

// Used in help.php
$string["about_mrbs"]         = "关于MRBS";
$string["database"]           = "数据库";
$string["system"]             = "操作系统";
$string["please_contact"]     = "请联系";
$string["for_any_questions"]  = ",关于任何无法在此解决的问题.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Fatal Error: 无法连接数据库";

?>

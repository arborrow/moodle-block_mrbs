<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:12 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a Japanese file.
//
//
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "UTF-8";

// Used for Moodle
$string['blockname'] = 'Booking system';
$string['accessmrbs'] = 'Schedule a Resource';

// Used in style.inc
$string["mrbs"]               = "会議室予約システム";

// Used in functions.inc
$string["report"]             = "報告";
$string["admin"]              = "管理";
$string["help"]               = "ヘルプ";
$string["search"]             = "検索";
$string["not_php3"]           = "警告: 本ソフトウェアは、PHP3ではおそらく動作しません。";

// Used in day.php
$string["bookingsfor"]        = "";
$string["bookingsforpost"]    = "の予約です";
$string["areas"]              = "部署";
$string["daybefore"]          = "前の日に移動";
$string["dayafter"]           = "次の日移動";
$string["gototoday"]          = "本日に移動";
$string["goto"]               = "移動";
$string["highlight_line"]     = "この行を強調";
$string["click_to_reserve"]   = "予約を入れたいセルをクリックしてください。";

// Used in trailer.inc
$string["viewday"]            = "日で表示";
$string["viewweek"]           = "週で表示";
$string["viewmonth"]          = "月で表示";
$string["ppreview"]           = "印刷プレビュー";

// Used in edit_entry.php
$string["addentry"]           = "予約を追加";
$string["editentry"]          = "予約を編集";
$string["copyentry"]          = "予約をコピー";
$string["editseries"]         = "定例予約を編集";
$string["copyseries"]         = "定例予約をコピー";
$string["namebooker"]         = "概要";
$string["fulldescription"]    = "詳細な説明<br>(人数,<br>内部会議/外部会議 等)";
$string["date"]               = "日付";
$string["start_date"]         = "開始時刻";
$string["end_date"]           = "終了時刻";
$string["time"]               = "時間";
$string["period"]             = "期間";
$string["duration"]           = "所要時間";
$string["seconds"]            = "秒";
$string["minutes"]            = "分";
$string["hours"]              = "時間";
$string["days"]               = "日";
$string["weeks"]              = "週";
$string["years"]              = "年";
$string["periods"]            = "期間";
$string["all_day"]            = "終日";
$string["type"]               = "種別";
$string["internal"]           = "内部会議";
$string["external"]           = "外部会議";
$string["save"]               = "保存";
$string["rep_type"]           = "繰り返しの様式";
$string["rep_type_0"]         = "なし";
$string["rep_type_1"]         = "毎日";
$string["rep_type_2"]         = "毎週";
$string["rep_type_3"]         = "毎月";
$string["rep_type_4"]         = "毎年";
$string["rep_type_5"]         = "毎月同じ日";
$string["rep_type_6"]         = "n週毎";
$string["rep_end_date"]       = "繰り返しの終了日";
$string["rep_rep_day"]        = "繰り返しの曜日";
$string["rep_for_weekly"]     = "((毎週/n週毎 選択時)";
$string["rep_freq"]           = "頻度";
$string["rep_num_weeks"]      = "繰り返し周期";
$string["rep_for_nweekly"]    = "(n週毎 選択時)";
$string["ctrl_click"]         = "複数の部屋を選択するときは、<br>Controlキーを押しながらクリックしてください。";
$string["entryid"]            = "予約ID ";
$string["repeat_id"]          = "定例予約ID "; 
$string["you_have_not_entered"] = "以下の項目が入力されていません:";
$string["you_have_not_selected"] = "以下の項目が選択されていません:";
$string["valid_room"]         = "部屋";
$string["valid_time_of_day"]  = "valid time of day.";
$string["brief_description"]  = "簡単な説明";
$string["useful_n-weekly_value"] = "useful n-weekly value.";

// Used in view_entry.php
$string["description"]        = "説明";
$string["room"]               = "部屋";
$string["createdby"]          = "予約者";
$string["lastupdate"]         = "最終更新";
$string["deleteentry"]        = "予約を削除";
$string["deleteseries"]       = "定例予約を削除";
$string["confirmdel"]         = "このエントリを削除してもよろしいですか?";
$string["returnprev"]         = "前のページに戻る";
$string["invalid_entry_id"]   = "不正な予約IDです。";
$string["invalid_series_id"]  = "不正な定例予約IDです。";

// Used in edit_entry_handler.php
$string["error"]              = "エラー";
$string["sched_conflict"]     = "予定の重複";
$string["conflict"]           = "新しい予約は、以下の登録と重複しています:";
$string["too_may_entrys"]     = "選択されたオプションは大量のエントリーを作成します。<br>別のオプションを使用して下さい!";
$string["returncal"]          = "カレンダー表示に戻る";
$string["failed_to_acquire"]  = "データベースへの排他的なアクセスの確保に失敗しました"; 
$string["invalid_booking"]    = "不正な予約";
$string["must_set_description"] = "予約のための簡単な説明を設定する必要があります。戻って入力してください。";
$string["mail_subject_entry"] = "$mrbs_company MRBSエントリの追加/変更";
$string["mail_body_new_entry"] = "新規エントリが予約されました。詳細は以下のとおりです:";
$string["mail_body_del_entry"] = "エントリが削除されました。詳細は以下のとおりです:";
$string["mail_body_changed_entry"] = "エントリが変更されました。詳細は以下のとおりです:";
$string["mail_subject_delete"] = "$mrbs_company MRBSエントリの削除";

// Authentication stuff
$string["accessdenied"]       = "アクセスが拒否されました";
$string["norights"]           = "この項目を変更するアクセス権がありません。";
$string["please_login"]       = "ログインしてください";
$string["user_name"]          = "名前";
$string["user_password"]      = "パスワード";
$string["unknown_user"]       = "未知のユーザ";
$string["you_are"]            = "あなたは";
$string["login"]              = "ログイン";
$string["logoff"]             = "ログオフ";

// Authentication database
$string["user_list"]          = "ユーザリスト";
$string["edit_user"]          = "ユーザを編集";
$string["delete_user"]        = "このユーザを削除";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Eメールアドレス";
$string["password_twice"]     = "パスワードを変更したい場合は、新しいパスワードを2回入力してください";
$string["passwords_not_eq"]   = "エラー: パスワードが一致しません。";
$string["add_new_user"]       = "新しいユーザを追加";
$string["rights"]             = "権限";
$string["action"]             = "処置";
$string["user"]               = "ユーザ";
$string["administrator"]      = "管理者";
$string["unknown"]            = "不明";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "クリックして、今後のエントリを表示する";
$string["no_users_initial"]   = "初期のユーザを作成可能なユーザが、データベースに存在しません。";
$string["no_users_create_first_admin"] = "管理者権限を持つユーザを作成すると、管理者権限ユーザでログインして、他ユーザを作成することが可能になります。";

// Used in search.php
$string["invalid_search"]     = "検索語が空または不正です。";
$string["search_results"]     = "検索結果:";
$string["nothing_found"]      = "一致するエントリは見つかりませんでした。";
$string["records"]            = "履歴";
$string["through"]            = "から";
$string["of"]                 = ", 該当件数";
$string["previous"]           = "前";
$string["next"]               = "次";
$string["entry"]              = "エントリ";
$string["view"]               = "表示";
$string["advanced_search"]    = "高度な検索";
$string["search_button"]      = "検索";
$string["search_for"]         = "検索語";
$string["from"]               = "始点";

// Used in report.php
$string["report_on"]          = "会合の報告";
$string["report_start"]       = "報告開始日";
$string["report_end"]         = "報告終了日";
$string["match_area"]         = "部署の一致";
$string["match_room"]         = "部屋の一致";
$string["match_type"]         = "形態の一致";
$string["ctrl_click_type"]    = "複数の形態を選択するときは、Controlキーを押しながらクリックしてください。";
$string["match_entry"]        = "簡単な説明との一致";
$string["match_descr"]        = "詳細な説明との一致";
$string["include"]            = "報告内容";
$string["report_only"]        = "報告のみ";
$string["summary_only"]       = "要約のみ";
$string["report_and_summary"] = "報告と要約";
$string["summarize_by"]       = "要約のまとめ方";
$string["sum_by_descrip"]     = "簡単な説明";
$string["sum_by_creator"]     = "予約者";
$string["entry_found"]        = "個のエントリーが見つかりました";
$string["entries_found"]      = "個のエントリーが見つかりました";
$string["summary_header"]     = "予約時間数の要約 (括弧内はエントリー数)";
$string["summary_header_per"] = "予約時間帯数の要約 (括弧内はエントリー数)";
$string["total"]              = "計";
$string["submitquery"]        = "報告の作成";
$string["sort_rep"]           = "報告の並べ方";
$string["sort_rep_time"]      = "開始日時";
$string["rep_dsp"]            = "報告の表示";
$string["rep_dsp_dur"]        = "使用期間";
$string["rep_dsp_end"]        = "終了時刻";

// Used in week.php
$string["weekbefore"]         = "前の週に移動";
$string["weekafter"]          = "次の週に移動";
$string["gotothisweek"]       = "今週に移動";

// Used in month.php
$string["monthbefore"]        = "前の月に移動";
$string["monthafter"]         = "次の月に移動";
$string["gotothismonth"]      = "今月に移動";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "この部署には部屋が設定されていません";

// Used in admin.php
$string["edit"]               = "編集";
$string["delete"]             = "削除";
$string["rooms"]              = "部屋";
$string["in"]                 = "-";
$string["noareas"]            = "部署がありません。";
$string["addarea"]            = "部署を追加";
$string["name"]               = "名称";
$string["noarea"]             = "部署が選択されていません";
$string["browserlang"]        = "お使いのブラウザの言語設定は、次の順序で設定されています。";
$string["addroom"]            = "部屋を追加";
$string["capacity"]           = "収容人数";
$string["norooms"]            = "部屋がありません。";
$string["administration"]     = "管理";

// Used in edit_area_room.php
$string["editarea"]           = "部署を編集";
$string["change"]             = "変更";
$string["backadmin"]          = "管理画面に戻る";
$string["editroomarea"]       = "部署や部屋の説明";
$string["editroom"]           = "部屋を編集";
$string["update_room_failed"] = "部屋の更新に失敗しました: ";
$string["error_room"]         = "エラー: 部屋 ";
$string["not_found"]          = "は見つかりませんでした";
$string["update_area_failed"] = "部署の更新に失敗しました: ";
$string["error_area"]         = "エラー: 部署 ";
$string["room_admin_email"]   = "部屋の管理者のEメール";
$string["area_admin_email"]   = "部署の管理者のEメール";
$string["invalid_email"]      = "不正ななEメールです!";

// Used in del.php
$string["deletefollowing"]    = "以下の予約を削除します";
$string["sure"]               = "よろしいですか?";
$string["YES"]                = "はい";
$string["NO"]                 = "いいえ";
$string["delarea"]            = "削除する前に、この部署に属する全ての部屋を削除しなければなりません。<p>";

// Used in help.php
$string["about_mrbs"]         = "MRBSについて";
$string["database"]           = "データベース";
$string["system"]             = "システム";
$string["servertime"]         = "サーバ時間";
$string["please_contact"]     = "ここに答えがない質問は、";
$string["for_any_questions"]  = "にお尋ねください。";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "致命的なエラー: データベースに接続できません。";

?>

<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:13 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a TR Turkish file.
//
//  Translations provided by: Ahmet YILDIZ ahmetyildizmail@yahoo.com
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname']          = 'Booking system';
$string['accessmrbs']         = 'Schedule a Resource';

// Used in style.inc
$string["mrbs"]               = "Toplantı Odası Ayırtma Sistemi";

// Used in functions.inc
$string["report"]             = "Rapor";
$string["admin"]              = "Yönetici";
$string["help"]               = "Yardım";
$string["search"]             = "Arama";
$string["not_php3"]           = "UYARI: Yüksek ihtimalle PHP3 ile çalışmaz";

// Used in day.php
$string["bookingsfor"]        = "Yer ayırtmak için";
$string["bookingsforpost"]    = "";
$string["areas"]              = "Alanlar";
$string["daybefore"]          = "Dün";
$string["dayafter"]           = "Yarın";
$string["gototoday"]          = "Bugün";
$string["goto"]               = "Git";
$string["highlight_line"]     = "Satırı belirgin hale getir";
$string["click_to_reserve"]   = "Yer ayırtmak için bu hücreye tıklayın.";

// Used in trailer.inc
$string["viewday"]            = "Günlük gösterim";
$string["viewweek"]           = "Haftalık gösterim";
$string["viewmonth"]          = "Aylık gösterim";
$string["ppreview"]           = "Önizleme";

// Used in edit_entry.php
$string["addentry"]           = "Kayıt Ekle";
$string["editentry"]          = "Kayıt Düzelt";
$string["copyentry"]          = "Kayıt Kopyala";
$string["editseries"]         = "Seri Düzenle";
$string["copyseries"]         = "Serileri Kopyala";
$string["namebooker"]         = "Kısa Tanım";
$string["fulldescription"]    = "Tam Tanım:<br>&nbsp;&nbsp;(Kişi sayısı,<br>&nbsp;&nbsp;İç/Dış/Karma vb.)";
$string["date"]               = "Tarih";
$string["start_date"]         = "Başlama Zamanı";
$string["end_date"]           = "Bitiş Zamanı";
$string["time"]               = "Zaman";
$string["period"]             = "Dönem";
$string["duration"]           = "Devam Süresi";
$string["seconds"]            = "saniye";
$string["minutes"]            = "dakika";
$string["hours"]              = "saat";
$string["days"]               = "gün";
$string["weeks"]              = "hafta";
$string["years"]              = "yıl";
$string["periods"]            = "dönem";
$string["all_day"]            = "Tüm Gün";
$string["type"]               = "Tip";
$string["internal"]           = "İç";
$string["external"]           = "Dış";
$string["Mix"]                = "Karma İç+Dış";
$string["save"]               = "Kaydet";
$string["rep_type"]           = "Tekrar Tipi";
$string["rep_type_0"]         = "Hiçbiri";
$string["rep_type_1"]         = "Günlük";
$string["rep_type_2"]         = "Haftalık";
$string["rep_type_3"]         = "Aylık";
$string["rep_type_4"]         = "Yıllık";
$string["rep_type_5"]         = "Aylık, denk gelen gün";
$string["rep_type_6"]         = "n-Haftalık";
$string["rep_end_date"]       = "Tekrarın solanma tarihi";
$string["rep_rep_day"]        = "Tekrar Eden Gün";
$string["rep_for_weekly"]     = "((n-)Haftalık için)";
$string["rep_freq"]           = "Sıklık";
$string["rep_num_weeks"]      = "Hafta sayısı";
$string["rep_for_nweekly"]    = "(n-haftalık)";
$string["ctrl_click"]         = "Klavyede Ctrl tuşuna basılı iken fare ile tıklıyarak birden fazla oda seçebilirsiniz.";
$string["entryid"]            = "Kayıt ID ";
$string["repeat_id"]          = "Tekrar ID ";
$string["you_have_not_entered"] = "Girmediniz";
$string["you_have_not_selected"] = "Seçmediniz";
$string["valid_room"]         = "Yer.";
$string["valid_time_of_day"]  = "Günün geçerli zamanı.";
$string["brief_description"]  = "Kısa Tanım.";
$string["useful_n-weekly_value"] = "faydali n-haftalık değer.";

// Used in view_entry.php
$string["description"]        = "Tanım";
$string["room"]               = "Yer";
$string["createdby"]          = "Ayırtan kişi";
$string["lastupdate"]         = "Son güncelleme zamanı";
$string["deleteentry"]        = "Kayıt Sil";
$string["deleteseries"]       = "Seri Sil";
$string["confirmdel"]         = "Emin misiniz?\\nistiyormusunuz\\nBu kaydı sil\\n\\n";
$string["returnprev"]         = "Önceki sayfaya dön";
$string["invalid_entry_id"]   = "Geçersiz kayıt id.";
$string["invalid_series_id"]  = "Geçersiz seri id.";

// Used in edit_entry_handler.php
$string["error"]              = "Hata";
$string["sched_conflict"]     = "Program çakışması";
$string["conflict"]           = "Yeni ayırtma işlemi önceki kayıt(lar) ile uyuşmazlık yapacak";
$string["too_may_entrys"]     = "Seçili seçenek çok fazla kayıt girişi yaratacak!";
$string["returncal"]          = "Takvim görünümüne dönün";
$string["failed_to_acquire"]  = "VeriTabanına erişim hatası";
$string["invalid_booking"]    = "Geçersiz YerAyırtma";
$string["must_set_description"] = "Yer ayırtma için kısa tanımlama yapmalısınız. Geri dönün ve bir kayıt ekleyiniz.";
$string["mail_subject_entry"] = "konu";
$string["mail_body_new_entry"] = "yeni kayıt";
$string["mail_body_del_entry"] = "sil kayıt";
$string["mail_body_changed_entry"] = "değiştir kayıt";
$string["mail_subject_delete"] = "konu sil";

// Authentication stuff
$string["accessdenied"]       = "Erişim Engellendi";
$string["norights"]           = "Bunu değiştirecek giriş haklarınız yoktur.";
$string["please_login"]       = "Lütfen girin";
$string["user_name"]          = "Ad";
$string["user_password"]      = "Şifre";
$string["unknown_user"]       = "Bilinmeyen kullanıcı";
$string["you_are"]            = "Siz";
$string["login"]              = "Giriş";
$string["logoff"]             = "Çıkış";

// Authentication database
$string["user_list"]          = "Kullanıcı listesi";
$string["edit_user"]          = "Kullanıcı düzenle";
$string["delete_user"]        = "Bu kullanıcıyı sil";
//$string["user_name"]         = Tutarlılık için yukardaki ayarın aynısını kullan.
//$string["user_password"]     = Tutarlılık için yukardaki ayarın aynısını kullan.
$string["user_email"]         = "Eposta adresi";
$string["password_twice"]     = "Eğer şifremnizi değiştirmek istiyorsanız, lütfen yeni şifrenizi iki kez giriniz.";
$string["passwords_not_eq"]   = "Hata: Şifreler uyuşmadı.";
$string["add_new_user"]       = "Yeni kullanıcı ekle";
$string["rights"]             = "Haklar";
$string["action"]             = "Faaliyet";
$string["user"]               = "Kullanıcı";
$string["administrator"]      = "Yönetici";
$string["unknown"]            = "Bilinmeyen";
$string["ok"]                 = "Tamam";
$string["show_my_entries"]    = "Tüm kayıtlarımı Göster";
$string["no_users_initial"]   = "VeriTabanında kullanıcı tanımlı değil, ilk kullanıcı oluşturmaya izin ver";
$string["no_users_create_first_admin"] = "Yönetici olarak bir kullanıcı tanımla ve giriş yaparak yeni kullanıcılar oluşturunuz.";

// Used in search.php
$string["invalid_search"]     = "Boş yada geçersiz arama kelimesi .";
$string["search_results"]     = "Arama sonuçları";
$string["nothing_found"]      = "Aranan kayıt bulunamadı.";
$string["records"]            = "Kayıtlar ";
$string["through"]            = " nedeniyle ";
$string["of"]                 = " da ";
$string["previous"]           = "Önceki";
$string["next"]               = "Sonraki";
$string["entry"]              = "Kayıt";
$string["view"]               = "Görünüm";
$string["advanced_search"]    = "Detaylı arama";
$string["search_button"]      = "Arama";
$string["search_for"]         = "Anahtar kelime";
$string["from"]               = "den";

// Used in report.php
$string["report_on"]          = "Toplantıların Raporları";
$string["report_start"]       = "Rapor Başlama Tarihi";
$string["report_end"]         = "Rapor Bitiş Tarihi";
$string["match_area"]         = "Uygun bölge";
$string["match_room"]         = "Uygun Toplantı Salonu";
$string["match_type"]         = "Uygun tip";
$string["ctrl_click_type"]    = "Klavyede Ctrl tuşuna basılı iken fare ile tıklıyarak birden fazla tip seçebilirsiniz.";
$string["match_entry"]        = "Uygun kısa tanım";
$string["match_descr"]        = "Uygun tam tanım";
$string["include"]            = "Kapsam";
$string["report_only"]        = "Sadece Rapor";
$string["summary_only"]       = "Sadece Özet";
$string["report_and_summary"] = "Rapor ve Özet";
$string["summarize_by"]       = "Özetleyen";
$string["sum_by_descrip"]     = "Kısa tanım";
$string["sum_by_creator"]     = "Oluşturan";
$string["entry_found"]        = "kayıt bulundu";
$string["entries_found"]      = "kayıtlar bulundu";
$string["summary_header"]     = "Kayıtların saatlik özeti.";
$string["summary_header_per"] = "Kayıtların dönemlik özeti.";
$string["total"]              = "Toplam";
$string["submitquery"]        = "Raporu Çalıştır";
$string["sort_rep"]           = "Rapora göre sırala";
$string["sort_rep_time"]      = "Başlama Zamanı";
$string["rep_dsp"]            = "Raporda Görüntüle";
$string["rep_dsp_dur"]        = "Devam Süresi";
$string["rep_dsp_end"]        = "Bitiş Zamanı";

// Used in week.php
$string["weekbefore"]         = "Önceki Haftaya Git";
$string["weekafter"]          = "Sonraki Haftaya Git";
$string["gotothisweek"]       = "Bu Haftaya Git";

// Used in month.php
$string["monthbefore"]        = "Bir önceki ayı görüntüle";
$string["monthafter"]         = "Bir sonraki ayı görüntüle";
$string["gotothismonth"]      = "Bu ayı görüntüle";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Bu bölge için Toplantı Salonu tanımlı değil.";

// Used in admin.php
$string["edit"]               = "Düzenle";
$string["delete"]             = "Sil";
$string["rooms"]              = "Salonlar";
$string["in"]                 = "da";
$string["noareas"]            = "Bölge yok";
$string["addarea"]            = "Bölge ekle";
$string["name"]               = "Ad";
$string["noarea"]             = "Seçili bölge yok";
$string["browserlang"]        = "Tarayıcınız kullanım için kurulu değil.";
$string["addroom"]            = "Toplantı Salonu Ekle";
$string["capacity"]           = "Kapasite";
$string["norooms"]            = "Toplantı Salonu Yok.";
$string["administration"]     = "Yönetici";

// Used in edit_area_room.php
$string["editarea"]           = "Bölge düzenle";
$string["change"]             = "Değiştir";
$string["backadmin"]          = "Yönetim'e git";
$string["editroomarea"]       = "Bölge düzenle veya Toplantı Salonu tanımı.";
$string["editroom"]           = "Toplantı Salonu Düzenle";
$string["update_room_failed"] = "Toplantı Salonu güncelleme hatası: ";
$string["error_room"]         = "Hata: Toplantı Salonu ";
$string["not_found"]          = " bulunamadı";
$string["update_area_failed"] = "Bölge güncelleme hatası: ";
$string["error_area"]         = "Hata: Bölge ";
$string["room_admin_email"]   = "Toplantı Salonu yönetici epostası";
$string["area_admin_email"]   = "Bölge yönetici epostası";
$string["invalid_email"]      = "Geçersiz eposta!";

// Used in del.php
$string["deletefollowing"]    = "Bu hareket rezervasyonu silecek";
$string["sure"]               = "Emin misiniz?";
$string["YES"]                = "Evet";
$string["NO"]                 = "Hayır";
$string["delarea"]            = "Silmeden önce bu bölgedeki tüm Toplantı Salonlarını silmelisiniz.<p>";

// Used in help.php
$string["about_mrbs"]         = "MRBS hakkında";
$string["database"]           = "VeriTabanı";
$string["system"]             = "Sistem";
$string["servertime"]         = "Sunucu zamanı";
$string["please_contact"]     = "Lütfen bağlantıya geçiniz ";
$string["for_any_questions"]  = "henüz cevaplanmamış her bir soru için.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Ciddi Hata: VeriTabanına bağlanılamadı.";

?>

<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Polish Language File

	********************************/

	$language['which'] = 'pl';

	$language['core'][0] = 'TeamSpeak3 bot stworzony przez';
	$language['core'][1] = 'Wersja';
	$language['core'][2] = 'Wczytywanie funkcji';
	$language['core'][3] = 'Wczytywanie pliku konfiguracyjnego';
	$language['core'][4] = 'Wczytywanie klasy TS3 Admin Class';
	$language['core'][5] = 'Pomyślnie wczytano: ';
	$language['core']['plugins'][1] = ' plugin';
	$language['core']['plugins'][2] = ' pluginy';
	$language['core']['plugins'][3] = ' pluginów';
	$language['core']['events'][1] = ' event';
	$language['core']['events'][2] = ' eventy';
	$language['core']['events'][3] = ' eventów';
	$language['core']['misconfigured'] = ' został źle skonfigurowany';
	$language['core']['console'] = 'Konsola:';

	
	$language['logs']['core']['error']['login'] = 'Xbot nie mógł zalogować się do server admin query';
	$language['logs']['core']['error']['port'] = 'Xbot nie mógł wejść przez określony port';
	$language['logs']['core']['error']['bot_name'] = 'Xbot nie mógł zmienić swojego nicku';
	$language['logs']['core']['error']['default_channel'] = 'Xbot nie mógł zmienić kanału';
	$language['logs']['start'] = 'Bot wystartował';
	$language['logs']['cant_connect'] = 'Bot nie mógł nawiązać połączenia z serwerem!';
	$language['logs']['functions'] = 'Wykonywanie funkcji ';
	$language['logs']['groups_security']['ban'] = ' został zbanowany za posiadanie rangi: ';
	$language['logs']['groups_security']['kick'] = ' został zkickowany za posiadanie rangi: ';
	$language['logs']['groups_security']['nothing'] = " został zpoke'owany i pozbawiony rangi: ";


	$language['function']['down_desc'] = "[hr][right][b]Wszelkie prawa zastrzeżone![/b]\nWygenerowane przez [b][COLOR=#0055ff]XBOT Standard ".VERSION."[/COLOR][/b][/right] ";	

	$language['function']['get_vip_channel']['message'] = "Właśnie otrzymałeś kanał VIP o numerze: ";
	$language['function']['get_vip_channel']['desc_owner'] = "Właściciel kanału: ";
	$language['function']['get_vip_channel']['desc_date'] = "Stworzony dnia:  ";
	$language['function']['get_vip_channel']['error_people'] = " Zbyt mała liczba osób, aby dostać kanał VIP";
	$language['function']['get_vip_channel']['error_owner'] = " Brak właściciela kanału. W nicku musi posiadać: ";
	$language['function']['get_vip_channel']['error_ip'] = " Ktoś posiada taki sam adres IP";
	$language['function']['get_vip_channel']['error_has_vip'] = " Ktoś już posiada rangę VIP";
	$language['function']['get_vip_channel']['error_not_empty'] = " Niestety wybrany kanał jest już zajęty";
	$language['function']['get_vip_channel']['succes'] = " Nadano kanal vip osobie: ";

	$language['function']['warning_ban']['user_banned'] = "Użytkownik został zbanowany: ";

	$language['function']['twitch_yt']['info'] = "Informacje: ";
	$language['function']['twitch_yt']['subs'] = "Subskrybujących: ";

	$language['function']['admins_meetin']['moved'] = " adminów zostało pomyślnie przeniesionych na kanał zebrania.";
	$language['admins_meeting']['information'] = " , pamiętaj o zbliżającym się zebraniu Administracji";

	$language['function']['groups_assigner']['has_rang'] = "Masz już rangę rejestracyjną!";
	$language['function']['groups_assigner']['received_rang'] = "Właśnie otrzymałeś rangę rejestracyjną!";

	$language['function']['get_private_channel']['hasnt_rang'] = "Nie masz odpowiedniej rangi!";
	$language['function']['get_private_channel']['has_channel'] = "Masz już u nas kanał!";
	$language['function']['get_private_channel']['get_channel'] = "Właśnie otrzymałeś prywatny kanał!";
	$language['function']['get_private_channel']['no_empty'] = "Aktualnie brak wolnych kanałów!";
	$language['function']['get_private_channel']['channel_name'] = "Kanał prywatny - ";
	$language['function']['get_private_channel']['created'] = "Data założenia: ";
	$language['function']['get_private_channel']['sub_channel'] = " Podkanał";

	$language['function']['poke_admins']['wants_help'] = "oczekuje na twoją pomoc!";

	$language['function']['one_day'] = "dzień";
	$language['function']['2_days'] = "dni";
	$language['function']['other_days'] = "dni";
	$language['function']['one_hour'] = "godzinę";
	$language['function']['2_hours'] = "godziny";
	$language['function']['other_hours'] = "godzin";
	$language['function']['one_minute'] = "minutę";
	$language['function']['2_minutes'] = "minuty";
	$language['function']['other_minutes'] = "minut";
	$language['function']['seconds'] = "sekund";

	$language['function']['ban_list'] = array
	(
		'header' => "Lista banów.\nWszystkich: ",
		'permament' => "permamentnie",
		'user' => "Osoba",
		'time' => "Czas trwania",
		'reason' => "Powód",
		'invoker' => "Twórca bana",
		'date' => "Dnia",
	);

	$language['function']['admins_time_spent']['time_spent'] = '[center][B][size=11]Admin:[/B] [size=11][client][/size][/center][b][size=10] Spędzony czas: [/size][/b]\n\n [size=9]W dniu dzisiejszym: [B][today][/B].[/size]\n [size=9]W obecnym tygodniu: [B][weekly][/B].[/size]\n [size=9]W obecnym miesiącu: [B][monthly][/B].[/size]\n [size=9]Łączny spędzony czas: [B][total][/B][/size]';

	$language['function']['channels_guard']['private_channel'] = "Kanał prywatny nr: ";
	$language['function']['channels_guard']['empty'] = " [WOLNY]";
	$language['function']['channels_guard']['how_to_get'] = "Aby go otrzymać udaj się na odpowiedni kanał";

?>
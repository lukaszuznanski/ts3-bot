<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Config File

	********************************/

$config['instance']['1']['connection'] = array
(
	/*****************************************************

	 		LOGIN TO TEAMSPEAK3 SERVER 

	******************************************************/
		
	//TeamSpeak3 Server IP Adress

		'IP' 			=> '127.0.0.1',
		

	//TeamSpeak3 Server Query Port

		'query_port'		=> '10011',


	//TeamSpeak3 Server Port

		'port' 			=> '9987',


	//TeamSpeak3 Server Query Login

		'login' 		=> 'serveradmin',


	//TeamSpeak3 Server Query Password

		'password' 		=> '',


	//Bot Nickname

		'bot_name' 		=> 'Razor Meister',


	//Bot Default Channel

		'default_channel' 	=> '2', 


	//Bot interval (in seconds)
		
		'interval' => 1,

);



$config['instance']['1']['logs_system'] = array
(


	'logs' => array
	(
		'enabled' => true,  		// true or false (logs system)
	),


);



$config['instance']['1']['functions'] = array
(


	'all_functions' => array('change_channel','warning_ban','multi_function','support_channels','get_vip_channel','admins_meeting','groups_security','twitch_yt','ddos_information','afk_group','ban_list','generate_banner','anty_vpn','visitors','client_on_channel'), 
	// All functions 'change_channel','warning_ban','groups_security','multi_function','support_channels','get_vip_channel','admins_meeting','twitch_yt','ddos_information','afk_group','ban_list','generate_banner','anty_vpn','visitors','client_on_channel'




	/*************************************

			PLUGINS

	*************************************/



	//Server groups security
	'groups_security' => array
	(
		'enabled' => false,
		'info' => array
		(
			/*'0' => array 				// growing number for example 1, 2, 3...
			(
				'groupsId' => 209,		// groups Id
				'ignoredId' => array(10,16,42),	// privellege client DATABASE id's
				'give_back' => true,		// give the rang back for peoples in ignoredId
				'type' => 'nothing', 		// `ban`, `kick`, `nothing` (just group delete and poke)
				'message' => '',		// message to the client if `ban` or `kick` it's reason, if `nothing` it's poke message
				'time' => 5, 			// ban timeout
			), */

		
			'0' => array
			(
				'groupsId' => 209,					
				'ignoredId' => array(0),
				'give_back' => false,					
				'type' => 'nothing', 					
				'message' => 'Nie mozesz miec rangi Root!',		
				'time' => 5, 						
			),
			'1' => array
			(
				'groupsId' => 208,					
				'ignoredId' => array(0),
				'give_back' => false,					
				'type' => 'nothing', 					
				'message' => 'Nie mozesz miec rangi Head Admin!',	
				'time' => 5, 						
			),
			'2' => array
			(
				'groupsId' => 207,					
				'ignoredId' => array(270),
				'give_back' => true,					
				'type' => 'nothing', 					
				'message' => 'Nie mozesz miec rangi Super Admin!',	
				'time' => 5, 						
			),

			'3' => array
			(
				'groupsId' => 206,					
				'ignoredId' => array(0),
				'give_back' => false,					
				'type' => 'nothing', 					
				'message' => 'Nie mozesz miec rangi Admin!',	
				'time' => 5, 						
			),

			'4' => array
			(
				'groupsId' => 204,					
				'ignoredId' => array(877,25),
				'give_back' => true,					
				'type' => 'nothing', 					
				'message' => 'Nie mozesz miec rangi Junior Admin!',	
				'time' => 5, 						
			),
		),
		'type' => 'every_client',	//Do not change
	),


	//Baning for having warning rangs
	'warning_ban' => array
	(
		'enabled' => false,
		'ban_time' => '1200', // in seconds
		'ban_message' => 'Za duzo ostrzezen!',
		'with_rang' => 212, // the last warning id for example Warning #3 (if u have 3 warnings)
		'warning_id' => array
		(
			212, // the last warning id for example Warning #3 (if u have 3 warnings)
			146,
			144,
		),	
	),

	
	//informing admins about coming meeting
	'admins_meeting' => array
	(
		'enabled' => false,
		'info' => array
		(
			'admins_server_groups' => array(2,209,208,207,206,204),	//all admins server groups
			'channel_id' => 1,					//meeting channel id
			'channel_name' => '╠═➤ Zebranie Adminów [x]', 	//[x] - meeting date (in format: dd.mm.yyyy hh:mm for example 18.02.2017 18:00) !important
			'information_before' => true, 				//informing admins `time_to_meeting` seconds before meeting
			'time_to_meeting' => 900, 				//in seconds
			'move_admins' => true,					//move admins to meeting channel on time
		),
		'type' => 'before_clients',	//Do not change
	),

	//Give afk group
	'afk_group' => array
	(
		'enabled' => false,
		'afk_group_id' => 237,		//afk group id
		'idle_time' => 1800,		//in seconds 
		'set_group_if_away' => true, 	//set afk group if client has away status
		'ignored_groups' => array(52,180),
		'type' => 'every_client',	//Do not change
	),


	//Anty vpn
	'anty_vpn' => array
	(
		'enabled' => false,
		'X-Key' => 'MjgyOnpTc3BrWHA1ZTlod2J6c1dtME5sdFFWQUJsOFIxRUlS', // You can change at website `https://iphub.info/pricing`
		'ignored_groups' => array(1177,28,29, 1253),
		'message_to_client' => "Używasz VPN'a!",
		'type' => 'every_client',	//Do not change
	),




	/*************************************

			EVENTS

	*************************************/



	//Change channel name
	'change_channel' => array
	(
		'enabled' => false, 	
		'channel_id' => '20615',
		'channel_name' => array
		(
			'[cspacer] » Informacja «',
			'[cspacer] » Nasze IP sie nie zmienia «',
			'[cspacer] » Witaj na 4names.pl «',
		),	
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
		'data' => '1970-01-01 00:00:00', //Do not change
	),


	//Multifunction
	'multi_function' => array
	(
		'enabled' => false,
		'content' => array
		(
			'total_ping' => array //server total ping on channel
			(
				'enabled' => false,
				'channel_id' => '21022',
				'channel_name' => '» Średni ping wynosi: %ping', 		// %ping = ping
				'integer' => true, 						// true or false (ping in integer)
			),
			'packet_loss' => array //server packet loss on channel
			(
				'enabled' => false,
				'channel_id' => '21023',
				'channel_name' => '» Packetloss wynosi: %packetloss%', 	// %packetloss = packetloss
				'integer' => true, 						// true or false (packetloss in integer)
			),		
		),	
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),


	//support channels
	'support_channels' => array
	(
		'enabled' => true,
		'content' => array
		(
			'0' => array						// growing number for example 1, 2, 3...
			(
				'channelId' => 56,				//channel id				
				'time_open' => '10:00',				//time open				
				'time_close' => '20:30',			//time close				
				'channel_name_open' => '» Biuro Spraw do Administracji [ON]',	//channel name when open	
				'channel_name_close' => '» Biuro Spraw do Administracji [OFF]',	//channel name when close	
			),
			'1' => array
			(
				'channelId' => 19950,				
				'time_open' => '12:00',				
				'time_close' => '20:00',				
				'channel_name_open' => 'Centrum pomocy [ON]',	
				'channel_name_close' => 'Centrum pomocy [OFF]',
			),



		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
		'data' => '1970-01-01 00:00:00',  //Do not change

	),

	
	//get vip channel
	'get_vip_channel' => array
	(
		'enabled' => false,
		'if_client_on_channel' => array(21341), 		//all checking channels id
		'info' => array
		(
			/*'0' => array 				// growing number for example 1, 2, 3...
			(
				'channel_id' => 209,		//channel id when peoples must come in	
				'owner_nick' => 'hvip',		//phrase which the owner must have  [x] - number of vip channel
				'nicks' => 'vip', 			//phrase which the people from vip must have  [x] - number of vip channel
				'how_many_peoples' => 2,	//how many peoples must come in to get vip channel (with the owner)	
				'vip_channel_group' => 5,	//main vip channel group id
				'vip_server_group' => 25,	//main vip server group id which gets only the owner
				'sub_channels' => 5,		//number of subchannels
				'empty_channels_names' => 'Główny Vip #[x]', // [x] - number of vip channel
				'topic' => '#empty',   		//topic in emtpy channels
			), */
			'0' => array 				
			(
				'channel_id' => 21341,			
				'owner_nick' => 'hvip',		
				'nicks' => 'vip', 			
				'how_many_peoples' => 5,		
				'vip_channel_group' => 12,
				'vip_server_group' => 25,
				'sub_channels' => 5,
				'empty_channels_names' => 'Główny Vip #[x]', 
				'topic' => '#empty', 
			),

		
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 15),
		'data' => '1970-01-01 00:00:00', //Do not change
	),

	
	//information on channel about twitch channel
	'twitch_yt' => array
	(
		'enabled' => false,
		'info' => array
		(
			'twitch_api_key' => 'oaocbf2zpmv6807kp9jcxkwmcjvq5a', //if u want u can change https://www.twitch.tv/settings/connections
			'twitch' => array
			(
				
				21354 => 'izakooo',	//channel_id => twitch channel name,
				21374 => 'tangyd',

			),
			'youtube_api_key' => 'AIzaSyAEQeDyRwJxVHw_m8wCD-P7oT_ufy4waX0',
			'youtube' => array
			(
				22024 => 'UCWHjaa4T5PLmvyKW9EXLPLQ',
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
		'data' => '1970-01-01 00:00:00', //Do not change
	),

	//Ddos information
	'ddos_information' => array
	(
		'enabled' => false,
		'file' => 'include/cache/ddos_information.txt',
		'packet_loss' => 10,		//from what packet loss%(numeric) send global information
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),

	//Ban list
	'ban_list' => array
	(
		'enabled' => false,
		'channel_id' => 30,
		'how_many' => 2,
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),

	//Generate banner
	'generate_banner' => array
	(
		/****************************************

		font - 'arial', 'calibri', 'inconsolata', 'tahoma' 
		color - in RGB array(x, x, x) you can check colors on https://www.w3schools.com/colors/colors_rgb.asp 
		co-ordinates - array(size, rotation, x, y)		

		****************************************/

		'enabled' => false,
		'admins_online' => array
		(
			'enabled' => true,
			'admins_server_groups' => array(1177,979,1239,682,683,686,685,684),	//admins server groups
			'font' => 'arial',
			'color' => array(255,255,255),
			'co-ordinates' => array(30,0,170,115),
		),
		'clients_online' => array
		(
			'enabled' => true,
			'font' => 'arial',
			'color' => array(255,255,255),
			'co-ordinates' => array(30,0,830,115),
		),
		'record_online' => array
		(
			'enabled' => true,
			'font' => 'arial',
			'color' => array(255,255,255),
			'co-ordinates' => array(30,0,830,325),
		),
		'clock' => array
		(
			'enabled' => true,
			'font' => 'arial',
			'color' => array(255,255,255),
			'co-ordinates' => array(30,0,140,325),
		),

		'image_file' => 'include/cache/bg.png',		//Must be png!
		'target_image_file' => '/var/www/image.png',	//Must be png!
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),


	//Visitors
	'visitors' => array //(Pomysłodawca: zmechu[PL])
	(
		'enabled' => false,
		'channel_id' =>20671,
		'channel_name' => "Odwiedziło nas: [VISITS] osób",	//[VISITS] - number of visitors
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),


	// ENG [Informing about client in channel name]  #  PL [Status użytkownika w nazwie kanalu]
	'client_on_channel' => array
	(
		'enabled' => true,
		'server_groups_id' => array(1573,979,1239,682,683,686,685,684),	//all checking client's server groups
		'format' => '[RANG]*[NICK] - [STATUS]',	//[RANG] - rang name, [NICK] - client nickname, [STATUS] - ONLNIE/OFFLINE
		'info' => array
		(
			/***************************************************************

				(you can copy this to use this function many times)
			
			// client dbid => channel_id
			      10       =>    20907,

			***************************************************************/

			35834 => 20906,		// client uid => channel_id
			35833 => 20907,


		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),


);






$config['instance']['2']['connection'] = array
(	
	/****************************************************

	 		LOGIN TO TEAMSPEAK3 SERVER 

	*****************************************************/
		
	//TeamSpeak3 Server IP Adress

		'IP' 			=> '127.0.0.1',
		

	//TeamSpeak3 Server Query Port

		'query_port'		=> '10011',


	//TeamSpeak3 Server Port

		'port' 			=> '9987',


	//TeamSpeak3 Server Query Login

		'login' 		=> 'serveradmin',


	//TeamSpeak3 Server Query Password

		'password' 		=> '',


	//Bot Nickname

		'bot_name' 		=> 'Razor Meister #2',


	//Bot Default Channel

		'default_channel' 	=> '2',


	//Bot interval (in seconds)
		
		'interval' => 1,


);



$config['instance']['2']['logs_system'] = array
(

	'logs' => array
	(
		'enabled' => true,  		// true or false (logs system)
	),
);


$config['instance']['2']['functions'] = array
(


	'all_functions' => array('online_users','record_online','admin_list','groups_assigner','connect_message','advertisement_message','clock_date','change_server_name','get_private_channel','online_from_server_group','poke_admins','get_server_group','admins_time_spent','channels_checker'), // All functions
	//'online_users','record_online','admin_list','groups_assigner','connect_message','advertisement_message','clock_date','change_server_name','get_private_channel','online_from_server_group','poke_admins','get_server_group','admins_time_spent','channels_checker'



	/*************************************

			PLUGINS

	*************************************/


	//connect message
	'connect_message' => array
	(
		'enabled' => true,
		'to_groups' => array(-1), 	//connect message to specified server_groups / set -1 to all server groups / set gorups_id separated by comma
		
		/************************************

		[CLIENT_IP] =  Client nickname
		[CLIENT_NICK] = Client nickname
		[CLIENT_COUNTRY] = Client country
		[CLIENT_DBID] = Client databse id
		[SERVER_NAME] = Server name
		[SERVER_VERSION] = Server version
		[RECORD_ONLINE] = Record online

		*************************************/

		'file' => 'include/cache/connect_message.txt',
		'type' => 'clients_different',	//Do not change
	),


	//register groups assigner
	'groups_assigner' => array
	(
		'enabled' => false,
		'if_client_on_channel' => array(21354,21374), 		//all checking channels id
		'register_groups' => array(49,50),				//all register groups
		'info' => array
		(	
			21354 => 49,	//channel_id => server group id,
			21374 => 50,
		),
	),



	/*************************************

			EVENTS

	*************************************/



	//online users
	'online_users' => array
	(
		'enabled' => false,
		'channel_id' => 21354,
		'channel_name' => 'Online: [ONLINE]', //[ONLINE] - online users
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
		'data' => '1970-01-01 00:00:00', //Do not change
	),


	//record clients online
	'record_online' => array
	(
		'enabled' => false,
		'channel_id' => 21374,
		'channel_name' => 'Record: [RECORD]', //[RECORD] - record online users
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
		'data' => '1970-01-01 00:00:00', //Do not change
	),


	//admin list
	'admin_list' => array
	(
		'enabled' => false,
		'channel_id' => 17281,						//channel id
		'admins_server_groups' => array(1573,682,683,686,685,684),				//admins server groups
		'top_description' => 'Lista Administracji ONLINE',
		'channel_name' => 'Adminow online: [ONLINE]', 			//[ONLINE] - Admins online
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
		'data' => '1970-01-01 00:00:00', //Do not change
	),

	
	//advertisement_message
	'advertisement_message' => array
	(
		'enabled' => false,
		'file' => 'include/cache/advertisement_message.txt',
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 30,'seconds' => 0),
		'data' => '1970-01-01 00:00:00', //Do not change
	),


	//clok_date
	'clock_date' => array
	(
		'enabled' => false,
		'content' => array
		(
			'clock' => array //server packet loss on channel
			(
				'enabled' => true,
				'channel_id' => '21388',
				'channel_name' => '» Godzina : %clock', 		// %clock = clock
				'format' => 'G:i', 					// format G: hours, i: minutes, s: seconds
			),
			'date' => array //server packet loss on channel
			(
				'enabled' => true,
				'channel_id' => '21389',
				'channel_name' => '» Data wynosi: %date', 		// %date = date
				'format' => 'd-m-Y', 					// format m: month numeric, M: month in words, d: day numeric, D: day in world, Y: year
			),		
		),	
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 60),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),

	
	//change server name
	'change_server_name' => array
	(
		'enabled' => false,
		'server_name' => 'Test 4pancernych.pl [ONLINE]/[MAX_CLIENTS]', //[ONLINE] - online users, [MAX_CLIENTS] - max clients, 
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),

		
	//get ptivate channel
	'get_private_channel' => array
	(
		'enabled' => false,
		'if_client_on_channel' => array(20908), //checking channel id
		'needed_server_group' => array(26,23),  //you need one rang from array() to get private channel
		'channels_zone' => 20908,
		'head_channel_admin' => 5,		//head channel admin group
		'sub_channels' => 2,			//sub channels number
		'empty_channel_topic' => '#free',	//topic in free channels
		'send_messages' => 'poke',		// poke or message
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),


	//clients online from server group
	'online_from_server_group' => array
	(
		'enabled' => false,
		
		'info' => array
		(
			20117 => array	//channelId => array
			(
				'server_group' => 1108,
				'channel_name' => 'DEAL [ONLINE]/[MAX]', 		//[ONLINE] - online users from server group, [MAX] - all users from server group
			),
			20118 => array	//channelId => array
			(
				'server_group' => 1573,
				'channel_name' => 'CEO [ONLINE]/[MAX]', 		//[ONLINE] - online users from server group, [MAX] - all users from server group
			),	
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),


	//poke admin
	'poke_admins' => array
	(
		'enabled' => false,
		'if_client_on_channel' => array(12847),
		'ignored_groups' => array(501),
		'info' => array
		(
			12847 => array(1177),
		),

		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 15),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),

	
	//get server group
	'get_server_group' => array
	(
		'enabled' => false,
		'if_client_on_channel' => array(20906,20907), //all channels' id
		'info' => array
		(
			//21410 => 227,	//channel id => server group id
			20906 => 933,
			20907 => 934,
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 15),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),

	
	//admins time spent
	'admins_time_spent' => array
	(
		'enabled' => false,
		'admins_groups' => array(1573,979,682,683,686,685,684),
		'top_description' => '[size=14][b]Statystyki administracji[/b][/size][size=13][b]\nSpędzony czas[/b][/size]',
		'channelid' => 12687,
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 15),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),

	
	//channels' checker
	'channels_checker' => array
	(
		'enabled' => false,
		'channels_zone' => 20908,				//parent channel id
		'empty_channel_topic' => '#free',			//topic in empty channels
		'free_channel_name' => 'Prywatny Kanał - Wolny',
		'head_channel_admin_group' => 5,			//main head channel admin group id
		'time_interval_delete' => 7,			//days after which the channel will be deleted	
		'new_date_if_user' => true,			//set current date if someone is on channel
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),


);



?>
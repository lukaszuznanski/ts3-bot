<?php
	/********************************************************************************

	-----      ------    ---------------      ----------------    -----------------
	------     ------    ----------------     ----------------    -----------------
	 ------   ------     -----------------    ----------------        ---------    
	  ------ ------      ------    --------   ------    ------         -------     
	   -----------       ------    --------   ------    ------          -----      
	    ---------        ------    -------    ------    ------           ---       
	     -------         ----------------     ------    ------           ---        
	     -------         ---------------      ------    ------           ---        
	    ---------        ----------------     ------    ------           ---        
	   -----------       ------    -------    ------    ------           ---        
	  ------ ------      ------    --------   ------    ------           ---        
	 ------   ------     -----------------    ----------------           ---        
	------     ------    ----------------     ----------------           ---        
	-----       -----    ---------------      ----------------           ---        


	Author: Tymoteusz `Razor Meister` Bartnik

	Graphics: Zuqu
 
	Contact: battnik90@gmail.com
 
	Function: core.php
 
	License: GNU GPL
		
	**********************************************************************************/


	date_default_timezone_set('Europe/Warsaw');
	ini_set('default_charset', 'UTF-8');
	setlocale(LC_ALL, 'UTF-8');
	define('OWNER', ' Tymoteusz `Razor Meister` Bartnik');
	define('VERSION', ' [0.4.2]');
	define('PREFIX', ':: ');
	define('END', "\n");
	$instance = getopt("i:");
	$error = false;
	$name = " [SYSTEM] ";


	require "include/configs/language.php";
	switch($config['bot_language'])
	{
		case 'pl':
			require "include/language_file/pl.php";
			break;
		case 'eng':
			require "include/language_file/eng.php";
			break;
	}

	echo PREFIX.$language['core'][0].OWNER.END;
	echo PREFIX."XBot Standard".END;
	echo PREFIX.$language['core'][1].VERSION.END.END;	

	echo PREFIX.$language['core'][3].END;
	require "include/configs/config.php";
	$cfg = $config['instance'][$instance['i']]['functions'];
	$connect = $config['instance'][$instance['i']]['connection'];
	$logs_system = $config['instance'][$instance['i']]['logs_system']['logs'];

	echo PREFIX.$language['core'][2].END;
	require "include/functions/functions.php";
	$plugins = array();
	$events = array();
	$file = search_instance_folder($instance['i']);
	foreach($cfg['all_functions'] as $function)
	{
		if($cfg[$function]['enabled'])
		{
			if(!array_key_exists("time_interval", $cfg[$function]))
			{
				require "include/functions/".$file."/".$function.".php";
				array_push($plugins, $function);
			}
			else
			{
				require "include/functions/".$file."/".$function.".php";
				array_push($events, $function);
			}
		}
	}
	
	echo PREFIX.$language['core'][5].count($plugins).write_loaded_functions(count($plugins), 1).END;
	echo PREFIX.$language['core'][5].count($events).write_loaded_functions(count($events), 2).END;

	echo PREFIX.$language['core'][4].END;
	include 'include/lib/ts3admin.class.php';

	language_file($config['bot_language']); //creating language_file for starter.sh
	if($logs_system['enabled'])
		$logs = logs_create($connect['bot_name']);

	if(check_numeric_connect($connect, $name))
	{	
		echo END.$language['core']['console'].END;
		$query = new ts3admin($connect['IP'], $connect['query_port']);

		if(success($query->connect()))
		{
			if(!success($query->login($connect['login'],$connect['password']))) die(write_info($name.$language['logs']['core']['error']['login']));
			
			if(!success($query->selectServer($connect['port']))) die(write_info($name.$language['logs']['core']['error']['port']));
			
			if(!success($query->setName($connect['bot_name']))) write_info($name.$language['logs']['core']['error']['bot_name']);

			$whoAmI = $query->getElement('data',$query->whoAmI());

			if(!success($query->clientMove($whoAmI['client_id'],$connect['default_channel']))) write_info($name.$language['logs']['core']['error']['default_channel']);

			if($logs_system['enabled'])
			{
				$logs_date = date('d-m-Y');
				fwrite($logs, date('d-m-Y G:i:s')." ".$name.$language['logs']['start'].END);
				echo date('d-m-Y G:i:s')." ".$name.$language['logs']['start'].END;
			}
			sleep(3);


			if(in_array("change_channel", $events))
				$cache = 1;
			if(in_array("admins_meeting", $plugins))
			{
				$cache_poked = 0;
				$cache_moved = 0;
			}
			if(in_array("connect_message", $plugins))
			{
				$old_clients = array();

				$clients = $query->getElement('data', $query->clientList("-uid -groups"));
				foreach($clients as $client)
				{
					if($client['clid'] != $whoAmI['client_id'] && $client['client_database_id'] != 1)
						array_push($old_clients, $client['clid']);
				}
			}
			
			while(true)
			{	
				sleep($connect['interval']);
				$query->runtime['debug'] = array();
				if(@$logs_date != date('d-m-Y') && $logs_system)
				{
					$logs = logs_create($connect['bot_name']);
					$logs_date = date('d-m-Y');
				}
				
				$loop_date = date('Y-m-d G:i:s');
				$clients = $query->getElement('data', $query->clientList("-uid -groups -ip"));
				foreach($plugins as $plugin)
				{
					if(array_key_exists('type', $cfg[$plugin]) && $cfg[$plugin]['type'] == 'before_clients')
						$plugin($cfg);
					elseif(array_key_exists('type', $cfg[$plugin]) && $cfg[$plugin]['type'] == 'clients_different')
						$plugin($cfg);
				}
				foreach($clients as $client)
				{
					if($client['clid'] != $whoAmI['client_id'] && $client['client_database_id'] != 1)
					{
						foreach($plugins as $plugin)
						{
							if(array_key_exists('type', $cfg[$plugin]) && $cfg[$plugin]['type'] == 'every_client')
								$plugin($cfg, $client);
							

							elseif(array_key_exists('with_rang', $cfg[$plugin]))
							{
								$client_groups = explode(',', $client['client_servergroups']);
								if(in_array($cfg[$plugin]['with_rang'], $client_groups))
									$plugin($cfg, $client);
							}
							elseif(array_key_exists('if_client_on_channel', $cfg[$plugin]))
							{				
								if(in_array($client['cid'], $cfg[$plugin]['if_client_on_channel']))
									$plugin($cfg, $client);	
								
							}
						}
						
						foreach($events as $event)
						{
							if(if_can($loop_date, $cfg[$event]['data'], convert_to_seconds($cfg[$event]['time_interval'])))
							{
								if(array_key_exists('if_client_on_channel', $cfg[$event]))
								{				
									if(in_array($client['cid'], $cfg[$event]['if_client_on_channel']))
									{
										$event($cfg, $client);	
										$cfg[$event]['data'] = $loop_date;
									}
								}
								else
								{
										$event($cfg, $client);	
										$cfg[$event]['data'] = $loop_date;
								}
						
							
							}
						}

					}
				}
			}
		}
		else write_info($name.$language['logs']['cant_connect']);
	}
?>
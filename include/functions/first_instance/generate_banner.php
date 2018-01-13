<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: generate_banner()

	********************************/

	function generate_banner($cfg)
	{
		$cfg = $cfg['generate_banner'];	
		
		global $connect, $name;
		if(strpos($connect['bot_name'], "(XBOT)") === false)
			die(write_info($name."Bot musi mieć w nazwie frazę (XBOT)"));
		
		$image = ImageCreateFromPng($cfg['image_file']);
		imagealphablending($image, true);
		
		if($cfg['admins_online']['enabled'])
			admins_online($image, $cfg['admins_online']);

		if($cfg['clients_online']['enabled'])
			clients_online($image, $cfg['clients_online']);

		if($cfg['record_online']['enabled'])
			record_online($image, $cfg['record_online']);

		if($cfg['clock']['enabled'])
			clock($image, $cfg['clock']);


   	 	imagepng($image, $cfg['target_image_file']); 
    		imagedestroy($image);
	}

	function admins_online(&$img, $cf)
	{
		global $query, $clients;

		$groups_list = $query->getElement('data', $query->serverGroupList());
		$count = 0;
		
		foreach($cf['admins_server_groups'] as $admin_group)
		{			
			$clients_from_group = $query->getElement('data', $query->serverGroupClientList($admin_group));

			if($clients_from_group != NULL)
				foreach($clients_from_group as $client_from_group)
					if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
						foreach($clients as $client)
							if(isset($client['client_database_id']) && $client['client_database_id'] != 1 && $client['client_database_id'] == $client_from_group['cldbid'])
								$count++;
		}

		ImageTTFText($img, $cf['co-ordinates'][0], $cf['co-ordinates'][1], $cf['co-ordinates'][2], $cf['co-ordinates'][3], 
		ImageColorAllocate($img, $cf['color'][0], $cf['color'][1], $cf['color'][2]), "include/cache/fonts/".$cf['font'].".ttf", $count);

	}

	function clients_online(&$img, $cf)
	{
		global $query;

		$server_info = $query->getElement('data', $query->serverInfo());
		
		$online = $server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'];

		ImageTTFText($img, $cf['co-ordinates'][0], $cf['co-ordinates'][1], $cf['co-ordinates'][2], $cf['co-ordinates'][3], 
		ImageColorAllocate($img, $cf['color'][0], $cf['color'][1], $cf['color'][2]), "include/cache/fonts/".$cf['font'].".ttf", $online);
	}

	function record_online(&$img, $cf)
	{
		$fp = fopen("include/cache/record_online.txt", "r");
		$record = fread($fp, filesize("include/cache/record_online.txt"));
		$tab = explode(";", $record);
		$record_online = $tab[0];	

		ImageTTFText($img, $cf['co-ordinates'][0], $cf['co-ordinates'][1], $cf['co-ordinates'][2], $cf['co-ordinates'][3], 
		ImageColorAllocate($img, $cf['color'][0], $cf['color'][1], $cf['color'][2]), "include/cache/fonts/".$cf['font'].".ttf", $record_online);
	}

	function clock(&$img, $cf)
	{	
		$clock = date('H:i');
 
		ImageTTFText($img, $cf['co-ordinates'][0], $cf['co-ordinates'][1], $cf['co-ordinates'][2], $cf['co-ordinates'][3], 
		ImageColorAllocate($img, $cf['color'][0], $cf['color'][1], $cf['color'][2]), "include/cache/fonts/".$cf['font'].".ttf", $clock);
	}
?>
<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Functions


	********************************/
	
	global $logs_system;	

	function search_instance_folder($instance)
	{
		switch($instance)
		{
			case 1:
				return "first_instance";
				break;
			case 2:
				return "second_instance";
				break;
			case 3:
				return "third_instance";
				break;
		}
	}
	

	function write_loaded_functions($count, $switch)
	{
		global $language;

		if($count == 1)
		{
			if($switch == 1)
				return $language['core']['plugins'][1];
			else
				return $language['core']['events'][1];
		}
		elseif(($count>=5 || $count == 0) && $language['which'] != 'eng')
		{
			if($switch == 1)
				return $language['core']['plugins'][3];
			else
				return $language['core']['events'][3];
		}
		else
		{
			if($switch == 1)
				return $language['core']['plugins'][2];
			else
				return $language['core']['events'][2];
		}
	}


	function check_numeric_connect($cfg, $name)
	{
		global $language;
		$good = true;
	
		if(!is_numeric($cfg['query_port']))
		{
			write_info($name."Query port".$language['core']['misconfigured']);
			$good = false;
		}
		
		if(!is_numeric($cfg['port']))
		{
			write_info($name."Port".$language['core']['misconfigured']);
			$good = false;
		}

		if(!is_numeric($cfg['default_channel']))
		{
			write_info($name."Bot default channel".$language['core']['misconfigured']);
			$good = false;
		}

		return $good;
	}


	function success(array $output)
	{
		return $output['success'];
	}


	function convert_to_seconds($interval) 
	{
		$interval['days'] = $interval['days'] + $interval['weeks']*7;
		$interval['hours'] = $interval['hours'] + $interval['days']*24;
		$interval['minutes'] = $interval['minutes'] + $interval['hours']*60;
		return $interval['seconds'] + $interval['minutes']*60;
	}


	function if_can($date1, $date2, $interval) 
	{
		
		$time2 = strtotime($date2);
		$time1 = strtotime($date1);
		$sum = $time1 - $time2;
		
		if($interval <= $sum)
			return true;
		else 
			return false;
	}


	function language_file($language)
	{
		if($language == 'pl')
		{
			if(!file_exists("include/language_file/pl.txt"))
			{
				$fp = fopen("include/language_file/pl.txt", "a");
				fclose($fp);
				
				if(file_exists("include/language_file/eng.txt"))
					unlink("include/language_file/eng.txt");
			}
		}
		else if($language == 'eng')
		{
			if(!file_exists("include/language_file/eng.txt"))
			{
				$fp = fopen("include/language_file/eng.txt", "a");
				fclose($fp);

				if(file_exists("include/language_file/pl.txt"))
					unlink("include/language_file/pl.txt");
			}
		}
	}
	


	function logs_create($name)
	{
		$data = date('d-m-Y');

		if(!is_dir("include/logs/$name/"))
			mkdir("include/logs/$name/");
		
		$logs = fopen("include/logs/$name/$data.log", "a");
		return $logs;
	}
	
	
	function write_info($text)
	{
		global $logs;
		global $logs_system;

		$data = date('d-m-Y G:i:s');
		echo $data." ".$text."\n";

		if($logs_system['enabled'])
			fwrite($logs, $data." ".$text."\n");	


		unset($logs);
		unset($logs_system);

	}


?>
<?php
	/********************************

	Author: Tymoteusz `Razor Meister` Bartnik

	Contact: battnik90@gmail.com

	Function: ddos_information()

	********************************/

function ddos_information($cfg)
{
	global $query;

	$cfg = $cfg['ddos_information'];
	$server_info = $query->getElement('data', $query->serverInfo());

	if($server_info['virtualserver_total_packetloss_total'] > $cfg['packet_loss'])
		$query->sendMessage(3, $server_info['virtualserver_id'], fread(fopen($cfg['file'], "r"), filesize($cfg['file'])));
}
?>
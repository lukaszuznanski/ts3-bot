#!/bin/bash
# Colors
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"

echo "TS3 BOT"
instances=2


if [[ "$1" == "start" ]]; then
	if [[ -f include/language_file/eng.txt || "$2" == "eng" ]]; then
		echo
		echo "You started `basename $0`"
		echo Your choice: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			if  ! screen -list | grep -q "Xbot_instance_$i" ; then
				sudo screen -dmS Xbot_instance_$i php core.php -i $i
				echo -e "XBot instance $i $COL_GREEN is ON! $COL_RESET"
			else
				echo -e "XBot instance $i $COL_GREEN is already ON! $COL_RESET"
			fi
		done
	else
		echo
		echo "Uruchomiles program `basename $0`"
		echo Wybrales: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			if  ! screen -list | grep -q "Xbot_instance_$i" ; then
				sudo screen -dmS Xbot_instance_$i php core.php -i $i
				echo -e "XBot instancja $i $COL_GREEN została włączona! $COL_RESET"
			else
				echo -e "XBot instancja $i $COL_GREEN jest już włączony! $COL_RESET"
			fi
		done
	fi

elif [[ "$1" == "stop" ]]; then
	if [[ -f include/language_file/eng.txt || "$2" == "eng" ]]; then
		echo
		echo "You started `basename $0`"
		echo Your choice: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			screen -S Xbot_instance_$i -X quit
		done
		echo -e "XBot $COL_RED is OFF! $COL_RESET"
	else
		echo
		echo "Uruchomiles program `basename $0`"
		echo Wybrales: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			screen -S Xbot_instance_$i -X quit
		done
		echo -e "XBot $COL_RED został wyłączony! $COL_RESET"
	fi

elif [[ "$1" == "restart" ]]; then
	if [[ -f include/language_file/eng.txt || "$2" == "eng" ]]; then
		echo
		echo "You started `basename $0`"
		echo Your choice: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			screen -S Xbot_instance_$i -X quit
			screen -dmS Xbot_instance_$i php core.php -i $i
		done
		echo -e "XBot $COL_GREEN has been restarted successfully! $COL_RESET"
	else
		echo
		echo "Uruchomiles program `basename $0`"
		echo Wybrales: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			screen -S Xbot_instance_$i -X quit
			screen -dmS Xbot_instance_$i php core.php -i $i	
		done
		echo -e "XBot $COL_GREEN został zrestartowany pomyślnie! $COL_RESET"
	fi

else 
	if [[ -f include/language_file/eng.txt || "$2" == "eng" ]]; then
		echo
		echo -e "$COL_GREEN USAGE: ${0} {start/stop/restart} $COL_RESET"	
	else
		echo
		echo -e "$COL_GREEN UŻYCIE: ${0} {start/stop/restart} $COL_RESET"	
	fi

	
fi
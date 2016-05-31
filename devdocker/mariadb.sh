#!/bin/bash

DATADIR="/var/lib/mysql"
MYSQL_DATABASE="$1"
MYSQL_USER="$2"
MYSQL_PASSWORD="$3"
MYSQL_ROOT_PASSWORD="password"

if [ ! -d "$DATADIR/mysql" ]; then 1
	
	echo 'Running mysql_install_db ...'
	mysql_install_db --user=mysql --ldata="$DATADIR" --basedir=/usr
	echo 'Finished mysql_install_db'
	
	# These statements _must_ be on individual lines, and _must_ end with
	# semicolons (no line breaks or comments are permitted).
	# TODO proper SQL escaping on ALL the things D:
	
	tempSqlFile='/tmp/mysql-first-time.sql'
	cat > "$tempSqlFile" <<-EOSQL
		DELETE FROM mysql.user ;
		CREATE USER 'root'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}' ;
		GRANT ALL ON *.* TO 'root'@'%' WITH GRANT OPTION ;
		DROP DATABASE IF EXISTS test ;
	EOSQL
	
	
	echo "CREATE DATABASE IF NOT EXISTS beyond_game;" >> "$tempSqlFile"
	
	
	if [ "$MYSQL_USER" -a "$MYSQL_PASSWORD" ]; then
		echo "CREATE USER '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD' ;" >> "$tempSqlFile"
		
		echo "GRANT ALL ON *.* TO '$MYSQL_USER'@'%' ;" >> "$tempSqlFile"
	fi
	
	echo 'FLUSH PRIVILEGES ;' >> "$tempSqlFile"

fi

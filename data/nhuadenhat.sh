#!/usr/bin/env bash
now="$(date +'%d_%m_%Y_%H_%M_%S')"
fileName="nhuadenhat_$now".gz
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
fullPathFile="$DIR/$fileName"
logfile="$DIR/"backup_log_"$(date +'%Y_%m')".txt
echo "mysqldump started at $(date +'%d-%m-%Y %H:%M:%S')" >> "$logfile"
mysqldump -u root -p'tranvanhop' nhuadenhat | gzip > "$fullPathFile"
echo "mysqldump finished at $(date +'%d-%m-%Y %H:%M:%S')" >> "$logfile"
chown myuser "$fullPathFile"
chown myuser "$logfile"
echo "file permission changed" >> "$logfile"
find "$DIR" -name db_backup_* -mtime +8 -exec rm {} \;
echo "old files deleted" >> "$logfile"
echo "operation finished at $(date +'%d-%m-%Y %H:%M:%S')" >> "$logfile"
echo "*****************" >> "$logfile"

exit 0

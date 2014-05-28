Simple PHP Website Backup Script
=========================

Simple php script for backing up PHP sites. It will backup site files, site database, delete backups that are older than the allowed time, and email you the links to the backup zips. 
<br/><br/>
<hr/>
<br/>
<br/>
<p>Out of the box, the script will backup the site files and store backups that are up to 2 months old. If a backup zip is older than 2 months and the script is run, it will get deleted.</p>

<p>For basic backups, drop the "/backups" folder into the root of your website. The URL to run the script is yourdomain.com/backups/.backup.php . The URL to see the current backups is yourdomain.com/backups/?password .

<h2>Customizations</h2>
<p>You can (should) customize the .config.php and tailor it for your site.</p>

<p><strong>DIRPASS</strong>: The query string to access the directory. e.g. "password", "superstrongpassword"</p>

<p><strong>ERROR_URL</strong>: The URL where you want unauthorized users to be redirected. Must be a valid url or site path. e.g. "http://www.google.com", "/404.php"</p>

<p><strong>BACKUP_DB</strong>: Do you need database backups? e.g. "true", "false"</p>

<p><strong>DB_HOST</strong>: Database host. e.g. "localhost", "127.0.0.1"</p>

<p><strong>DB_USER</strong>: Database user. e.g. "root", "mydatabase_user"</p>

<p><strong>DB_PASS</strong>: Database pass. e.g. "", "2309sdunk1309r"</p>

<p><strong>DB_NAME</strong>: Database name. e.g. "mydatabase_name"</p>

<p><strong>BACKUP_DIR_PATH</strong>: Relative path to the directory that will be backed up. e.g. "../", "../../../"</p>

<p><strong>DELETE_OLD_BACKUPS</strong>: Do you want to delete older backups? e.g. "true", "false"</p>

<p><strong>DELETE_BACKUPS_OLDER_THAN</strong>: Set the day that will mark the oldest possible backup. It can be a date or a dynamic value. The script uses strtotime() to figure this one out. e.g. "2 months ago", "-2 months", "05/15/2013"</p>

<p><strong>EMAIL_BACKUP</strong>: Do you want to email links to the backups? e.g. "true", "false"</p>

<p><strong>EMAIL_ADDRESS</strong>: The email address where you want the links emailed. e.g. "johnsmith@yahoo.com"</p>

<h2>How to run</h2>
<p>You can run the script manually but accessing the script URL, or you can setup up cron jobs to occasionally ping the script.</p>
<hr>

<h2>Issues</h2>
<p>If you need absolute bullet proof security, this script might not be for you. The backups are kept on the server, and although they can't be publicly listed in the directory (need a query password string), they can be downloaded if the link is guessed. Be careful what you use this for. </p>

<p>The script might not work locally on some OSX machines.</p>
<?
  // page access
  define(DIRPASS, 'password'); // valid query string. E.g.: www.path-to-backups/backups/?password
  define(ERROR_URL, '/'); // valid redirect. E.g.: "/", "http://www.domain.com"


  // db info
  define(BACKUP_DB, false); // true or false
  define(DB_HOST, '127.0.0.1');
  define(DB_USER, 'root');
  define(DB_PASS, '');
  define(DB_NAME, 'dbname');


  // backups setup
  define(BACKUP_DIR_PATH, "../"); // relative path to directory that needs to be backed up. If this script is in /extra/backups, the relative root directory is 2 folders back: "../../"
  define(DELETE_OLD_BACKUPS, true); // true or false
  define(DELETE_BACKUPS_OLDER_THAN, "-2 months"); // uses strtotime() function. Examples of valid values: "2 months ago", "-2 months", "2 years ago today", etc.
  define(EMAIL_BACKUP, false); // true or false
  define(EMAIL_ADDRESS, "your@email.com");
?>
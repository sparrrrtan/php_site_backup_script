<?php
  require_once("./.config.php");

  echo "Starting.<br/><br/>";
  $date = date('m-d-Y' . '_' . 'h-i-s'); 
  
  // delete old files
  if (DELETE_OLD_BACKUPS) {
    $dir = './';
    if (is_dir($dir)) {
      if ($dh = opendir($dir)) {
        while ($file = readdir($dh)) {
          if(!is_dir($dir . $file)) {
            if (filemtime($dir . $file) < strtotime(DELETE_BACKUPS_OLDER_THAN)) { 
              if ($file != '.htaccess' && $file != '.index.php' && $file != '.backup.php' && $file != '.sorttable.js' && $file != '.style.css' && $file != '.config.php') {
                echo "Deleting " . $dir . $file . " (old): ";
                echo "(date->" . date('Y-m-d', filemtime($dir . $file)) . ")<br/>";
                unlink($dir . $file);
              } 
            }
          }
        }
      } else {
        echo "ERROR. Could not open directory: $dir/n";
        die();
      }
    } else {
      echo "ERROR. Specified path is not a directory: $dir<br/>";
      die();
    }
    closedir($dh);
    echo "No more deletions..<br/><br/>";
  }

  // database dump
  $db_name = "";
  if (BACKUP_DB) {
    $db_dir = "./.db";
    if (is_dir($db_dir)) {
      $db_name = $date . "_DB.sql.gz";
      echo "Backing up database: $db_name<br/>";
      
      $cm_db_dump = "cd .db/; mysqldump -h".DB_HOST." -u".DB_USER." -p".DB_PASS." ".DB_NAME." | gzip > ".$db_name;
      shell_exec($cm_db_dump);
      echo "Database backup complete.<br/><br/>";
    } else {
      echo "ERROR. Database directory does not exist. Please create a /.db directory.<br/>";
      die();
    }
  }

  // backup site files
  echo "Backing up site files.<br/>";
  $zip_name = $date . '_FILES.zip';
  if (file_exists($zip_name)) {
    unlink($zip_name);
  }
  $cm_files_zip = "zip -9 -r ".$zip_name." ".BACKUP_DIR_PATH." ".BACKUP_DIR_PATH.".[^.]* -x \*backups\* \*.git\* \*.cache\* \*.tmp\*";
  $output_files_zip = system($cm_files_zip);

  if(strpos((string)$output_files_zip, "error") == null) {
    echo "<br/>Backup complete.<br/><br/>";
  } else {
    echo "<br/>Error in backup. Please try again.<br/><br/>";
    die();
  }

  // email backup
  if(EMAIL_BACKUP) {
    echo "Emailing backup links<br/>";

    $download_link_folder = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";

    $headers = "From: ".EMAIL_ADDRESS."\r\n";
    $headers .= "Content-type: text/html\r\n";

    $subject = "Website Backup for ".$_SERVER['HTTP_HOST'];

    $body = "<hr><hr><hr><br/><br/>";
    $body .= "<h2>Good Day!<h2><br/>";
    $body .= "<p>Your website ran a backup. You can download the backups here:</p><br/>";
    $body .= "<strong>Site Files Backup:</strong> <a href='$download_link_folder$zip_name' >$zip_name</a><br/>";
    if (BACKUP_DB) {
      $body .= "<strong>Database Backup:</strong> <a href='$download_link_folder.db/$db_name' >$db_name</a><br/>";
    }
    $body .= "<p>Please download the files and store in a secure location.</p><br/>";
    $body .= "<p>Have an awesome day!</p><br/>";
    $body .= "<hr><hr><hr>";

    $email_sent = mail(EMAIL_ADDRESS, $subject, $body, $headers);

    if($email_sent) {
      echo "Email with backup links sent!<br/><br/>";
    } else {
      echo "Error sending email.<br/><br/>";
      die();
    }
  }
?>
<?
  require_once('./.config.php');

  if ($_SERVER['QUERY_STRING'] != DIRPASS . "&hidden" && $_SERVER['QUERY_STRING'] != DIRPASS) {
    header("Location: " . ERROR_URL);
  }
?>

<!doctype html>
<html>
  <head>
     <meta charset="UTF-8">
     <link rel="shortcut icon" href="../.favicon.ico">
     <title>Backup List</title>
     <link rel="stylesheet" href="./.style.css">
     <script src="./.sorttable.js"></script>
  </head>

  <body>
    <div id="container">
      <h1>Directory Contents</h1>
      <table class="sortable">
        <thead>
          <tr>
            <th>Filename</th>
            <th>Type</th>
            <th>Size</th>
            <th>Date Modified</th>
           </tr>
        </thead>
        <tbody>
          <?php
            function pretty_filesize($file) {
              $size = filesize($file);
              if ($size < 1024) {
                $size = $size . " Bytes";
              } elseif (($size < 1048576) && ($size > 1023)) {
                $size = round($size / 1024, 1) . " KB";
              } elseif (($size < 1073741824) && ($size > 1048575)) {
                $size = round($size / 1048576, 1) . " MB";
              } else {
                $size = round($size / 1073741824, 1) . " GB";
              }
              return $size;
            }

            if($_SERVER['QUERY_STRING'] == DIRPASS . "&hidden") {
              $hide = "";
              $ahref = "./?" . DIRPASS;
              $atext = "Hide";
            } else { 
              $hide = ".";
              $ahref = "./?" . DIRPASS . "&hidden";
              $atext = "Show";
            }

            $my_directory = opendir(".");
            while ($entry_name = readdir($my_directory)) {
              $dir_array[] = $entry_name;
            }
            closedir($my_directory);

            $index_count = count($dir_array);
            sort($dir_array);
            for ($index=0; $index<$index_count; $index++) : 
          ?>
            <? if (substr("$dir_array[$index]", 0, 1) != $hide) : ?>
              <?
                $favicon = "";
                $class = "file";
                $name = $dir_array[$index];
                $namehref = $dir_array[$index];
                $modtime = date("M j Y g:i A", filemtime($dir_array[$index]));
                $timekey = date("YmdHis", filemtime($dir_array[$index]));
                if (is_dir($dir_array[$index])) {
                  $extn = "&lt;Directory&gt;";
                  $size = "&lt;Directory&gt;";
                  $sizekey = "0";
                  $class = "dir";
                  if (file_exists("$namehref/favicon.ico")) {
                    $favicon = " style='background-image:url($namehref/favicon.ico);'";
                    $extn = "&lt;Website&gt;";
                  }
                  if ($name == ".") {
                    $name = ". (Current Directory)"; 
                    $extn = "&lt;System Dir&gt;"; 
                    $favicon = " style='background-image:url($namehref/.favicon.ico);'";
                  }
                  if ($name == "..") {
                    $name=".. (Parent Directory)"; 
                    $extn="&lt;System Dir&gt;";
                  }
                } else {
                  $extn=pathinfo($dir_array[$index], PATHINFO_EXTENSION);

                  switch ($extn){
                    case "png": $extn="PNG Image"; break;
                    case "jpg": $extn="JPEG Image"; break;
                    case "jpeg": $extn="JPEG Image"; break;
                    case "svg": $extn="SVG Image"; break;
                    case "gif": $extn="GIF Image"; break;
                    case "ico": $extn="Windows Icon"; break;

                    case "txt": $extn="Text File"; break;
                    case "log": $extn="Log File"; break;
                    case "htm": $extn="HTML File"; break;
                    case "html": $extn="HTML File"; break;
                    case "xhtml": $extn="HTML File"; break;
                    case "shtml": $extn="HTML File"; break;
                    case "php": $extn="PHP Script"; break;
                    case "js": $extn="Javascript File"; break;
                    case "css": $extn="Stylesheet"; break;

                    case "pdf": $extn="PDF Document"; break;
                    case "xls": $extn="Spreadsheet"; break;
                    case "xlsx": $extn="Spreadsheet"; break;
                    case "doc": $extn="Microsoft Word Document"; break;
                    case "docx": $extn="Microsoft Word Document"; break;

                    case "zip": $extn="ZIP Archive"; break;
                    case "htaccess": $extn="Apache Config File"; break;
                    case "exe": $extn="Windows Executable"; break;

                    default: if($extn!=""){$extn=strtoupper($extn)." File";} else{$extn="Unknown";} break;
                  }

                  $size = pretty_filesize($dir_array[$index]);
                  $sizekey = filesize($dir_array[$index]);
                }
              ?>

              <tr class="<?= $class ?>">
                <td><a href="./<?= $namehref ?>" <?= $favicon ?> class="name"><?= $name ?></a></td>
                <td><a href="./<?= $namehref ?>"><?= $extn ?></a></td>
                <td sorttable_customkey="<?= $sizekey ?>"><a href="./<?= $namehref ?>"><?= $size ?></a></td>
                <td sorttable_customkey="<?= $timekey ?>"><a href="./<?= $namehref ?>"><?= $modtime ?></a></td>
              </tr>
            <? endif; ?>
          <? endfor; ?>
        </tbody>
      </table>
      <h2><a href="<?= $ahref ?>"><?= $atext ?> hidden files</a></h2>
    </div>
  </body>
</html>
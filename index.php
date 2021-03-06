<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=750">
  	<title>Pawe&#322 Szczurko</title>
  	<meta name="description" content="">
  	<meta name="author" content="Pawel Szczurko">
  	<link rel="icon" href="includes/favicon.ico" type="image/x-icon" />

    <!--ubuntu mono font from google-->
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Mono:700' rel='stylesheet' type='text/css'>

    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
    <link href="includes/normalize.css" rel="stylesheet" type="text/css">
    <link href="includes/styles.css" rel="stylesheet" type="text/css">

    <!-- latest jQuery direct from googles CDN -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

  </head>
<body>

<div class="banner">~$ The Terminal Site</div>
<div class="mainContent">
This is a way to browse my <a href="http://www.pawel.pw" target="_blank">website</a> through this JavaScript simulated terminal.<br><br>
<b>Disclaimer</b>: Typing speed (in the terminal) may vary between browers due to varying usage of 'onkeypress' vs 'onkeyup' events. 
The reason for the spilt usage is the fact that not all browsers trigger 'onkeypress' event when the backspace button is pressed.
<br><br>
<u>Supported commands</u>: cat, pwd, ls, clear
<br>
<u>Commands that give a message</u>: cd, mkdir, vim, vi

<br><br>
<u>Usage</u><br>
Type 'ls' to see all of the pages available. Type 'cat "page"', for example 'cat index.php' in order to see the contents of the page.
<br><br>

<div class="window">
  <div class="topbar">
    <div class="topbarImg">
      <img src="includes/buttons.png">
    </div>
    <div class="topbarContent">
      guest@pawel.pw:~$
    </div>  
  </div>
    
  <div class="scrollableWindow" id="scrollableWindow">
    <div id="output"></div>
    <!--inputWrapper is just for cmdInput usage-->
    <div class="inputWrapper">
      <div class="cmdCover" id="cmdCover">guest@pawel.pw~$</div><div class="fakeCursor"></div>
      <input type="text" name="cmd" id="cmd">
    </div>

  </div>

</div>

</div>
<div class="footer">
  <?php echo date("Y"); ?> Pawel Szczurko
</div>

<script>
<?php

//not firefox
if(strlen(strstr($_SERVER['HTTP_USER_AGENT'],"Firefox")) <= 0 )
{
  echo "var fire=false;";
}
else //firefox
{
  echo "var fire=true;";
}
?>
//This script can't be moved outside since it is dynamically generated with PHP

<?php 
$outVar = "var pgContent = [";

//read in all of the files from the website and input them into the pgContent array
$pages = array("contact.txt","index.txt","projects.txt", "work.txt");
$break = 0;

for($j=0 ; $j< count($pages); $j++)
{
  $content = file_get_contents("http://www.pawel.pw/text/".$pages[$j]);
  $content = str_replace("'", "\'", $content); //escape quotes
  $content = str_replace("\n", " ", $content); //get rid of new lines

  $subCats = true;
  if($pages[$j]=="index.txt" || $pages[$j]=="contact.txt")
  {
    $subCats=false;
  }

  $lines = explode("===", $content);  

  $outVar .= "[";
  for($i=0; $i<count($lines); $i++)
  {
    $break++;
    $outVar .= "'".$lines[$i]."'";
    if($i!= (count($lines)-1))
    {
      $outVar .=",";
    }
  }
  $outVar .= "]";
  if($j!= (count($pages)-1))
  {
    $outVar .=",";
  }
}
$outVar .= "];";

echo $outVar;

?>
</script>
<script src="includes/script.js"></script>
</body>
</html>

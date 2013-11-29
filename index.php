<!DOCTYPE html>
<!---->
<html>
  <head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=750">
  	<title>Pawe&#322 Szczurko</title>
  	<meta name="description" content="">
  	<meta name="author" content="Pawel Szczurko">
  	<link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
    <!--link href="../includes/normalize.css" rel="stylesheet" type="text/css"-->

    <!--ubuntu mono font from google-->
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Mono:700' rel='stylesheet' type='text/css'>

    <!-- styles needed by jScrollPane -->
    <link type="text/css" href="jquery.jscrollpane.css" rel="stylesheet" media="all" />

    <!-- latest jQuery direct from google's CDN -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <!-- the mousewheel plugin - optional to provide mousewheel support -->
    <script type="text/javascript" src="jquery.mousewheel.js"></script>

    <!-- the jScrollPane script -->
    <script type="text/javascript" src="jquery.jscrollpane.min.js"></script>

    <!--script type="text/javascript" id="sourcecode">
      $(function()
      {
        $('.scroll-pane').jScrollPane();
      });
    </script-->
  </head>
<body>
<style>
#output
{
  /*width:200px;
  height:200px;*/
  background: transparent;
  position: relative;
  color:#FFFFFF;
}
#cmd
{
  border:none;
  width:100%;
  background: transparent;
  position: relative;
  bottom: 20px;
  z-index: -1;
  /* 
   *im hiding the inputbox behind the 'terminal' so that 
   *i can emulate my own flashing cursor
   */
}
.window
{
  font-family: 'Ubuntu Mono', sans-serif;
  margin-left: auto;
  margin-right: auto;
  width:700px;
  height:400px;
  background-color: #300A24;
  border:1px solid #000000;
  box-shadow: 10px 10px 5px #888888;
}
.topbar
{
  background-color: #44433F;
  color:#FFFFFF;
  height:30px;
  width:100%;
}
.topbarContent
{
  height: 100%;
  position: relative;
  top: -4px;
  display: inline;
}
.topbarImg
{
  height: 100%;
  position: relative;
  top: 4px;
  padding-left: 5px;
  display: inline;
}
.cmdCover
{
  width:100%;
  height:100%;
  background:transparent;
  color:#FFFFFF;
  z-index: 2;
}
.scrollableWindow/*#scrollableWindow*/
{
  width: 700px;
  height: 370px;
  overflow: auto;

}
</style>


  <div class="window">
    <div class="topbar">
      <div class="topbarImg">
        <img src="buttons.png">
      </div>
      <div class="topbarContent">
        guest@pawel.pw:~$
      </div>  
    </div>
      
      <div class="scrollableWindow" id="scrollableWindow">
        <div id="output"></div>
        <!--inputWrapper is just for cmdInput usage-->
        <div class="inputWrapper">
          <div class="cmdCover" id="cmdCover">guest@pawel.pw~$</div>
          <input type="text" name="cmd" id="cmd">
        </div>

      </div>

  </div>

</body>
<script>
<?php 
  //echo "var myTest = 'global stuff here yo';";
$outVar = "var pgContent = [";

//read in index.txt

$pages = array("contact.txt","index.txt","projects.txt", "work.txt");
$break = 0;

for($j=0 ; $j< count($pages); $j++)
{
  $content = file_get_contents("http://www.pawel.pw/text/".$pages[$j]);
  $content = str_replace("'", "\'", $content);
  $content = str_replace("\n", " ", $content);

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
/*for(i =0; i<pgContent.length; i++)
{
  console.log(pgContent[i][0]);
}*/

</script>
<script>
function createOutput( out, preText, outText)
{
  if((out.innerHTML).length==0 )
  {
    return preText+ outText ;
  }
  else 
  {
    return out.innerHTML + '<br>'+preText+ outText;
  }
}
function errorOutput(out, preText, outText, msg, includePreText)
{
  if(!includePreText)
  {
    return '<br>'+outText+msg;
  }

  if((out.innerHTML).length==0 )
  {
    return preText+ outText + '<br>'+outText+msg;
  }
  else 
  {
    return out.innerHTML + '<br>'+preText+ outText + '<br>'+outText+msg;
  }
}
function errorNotSupportedCommands(out, preText, originalCMD, baseCMD, msg)
{
  if((out.innerHTML).length==0 )
  {
    return preText+ originalCMD + '<br>'+baseCMD+msg;
  }
  else 
  {
    return out.innerHTML + '<br>'+preText+ originalCMD + '<br>'+baseCMD+msg;
  }
}

var preText = 'guest@pawel.pw~$ ';
var pages = new Array("contact.php","index.php","projects.php", "work.php", "resume.pdf");

document.onclick = function()
{
  document.getElementById("cmd").focus();
};
//get focus to cmd textbox
window.onload = function() 
{
  document.getElementById("cmd").focus();
};

document.getElementById('cmd').onkeypress = function(e) 
{
    var user = document.getElementById('cmd');    

    var event = e || window.event;
    var charCode = event.which || event.keyCode;
    var cmdCover = document.getElementById('cmdCover');

    if( charCode=='8')//backspace
    {
      if( (user.value).length==0)
      {
        cmdCover.innerHTML=preText;
      }
      else
      {
        cmdCover.innerHTML=preText+(user.value).substring(0,(user.value).length -1 );
      }
    }
    else//value of textbox + current key pressed
    {
      cmdCover.innerHTML=preText+user.value+String.fromCharCode(charCode);
    }

    //the below happens if user hits 'enter' key
    if ( charCode == '13' ) 
    {
      var out = document.getElementById('output');
      var args = user;

      if( (user.value).trim().substring(0,5) == "clear")
      {
        /*******DESCRIPTION*********
         basic clear command
         **************************/
        out.innerHTML="";
      }
      else if((user.value).trim().substring(0,2)=="ls")
      {
        /*******DESCRIPTION***********
         list files in the 'directory'
         *****************************/
        out.innerHTML = createOutput(out, preText, user.value);

        args = args.value.match(/\S+/g);

        /*if no extra files do listing of everything*/
        if(args.length==1)
        {
          out.innerHTML = out.innerHTML + "<br>";
          for(i =0; i<pages.length; i++)
          {
            out.innerHTML = out.innerHTML + pages[i] + "&nbsp;&nbsp;";
          }
        }
        else /*list the specific file*/
        {
          var correctFiles = "";
          for(i=1; i<args.length; i++)
          {
            if( ($.inArray(args[i], pages)) !=-1 )
            {
              /*file exists add to list*/
              correctFiles += args[i] + "&nbsp;&nbsp;";
            }
            else
            {
              /*print out error that file does not exist*/
              out.innerHTML = out.innerHTML + errorOutput(out, preText, "ls: cannot access "+args[i]+": No such file or directory", "", false);
            }
          }
          if(correctFiles != "")
          {
            /*print out the correct files*/
            out.innerHTML = out.innerHTML + "<br>";
            out.innerHTML = out.innerHTML + correctFiles;
          }
        }
        
      }
      else if((user.value).trim().substring(0,3)=="cat")
      {
        /*******DESCRIPTION*********
         view pages WOOO!
         **************************/
        out.innerHTML = createOutput(out, preText, user.value);

        args = args.value.match(/\S+/g);


        if(args.length !=1)
        {
          var validOutput = "";
          for(i=1; i<args.length; i++)
          {
            var pgIndex = $.inArray(args[i], pages);
            if( pgIndex !=-1 )
            {
              //Array("contact.php","index.php","projects.php", "work.php", "resume.pdf");
            /*file exists add to list*/
              validOutput += args[i]+"<br>-------------------<br>";
              if(pgIndex==4)
              {
                validOutput += "My current resume can be found <a href=\"http://www.pawel.pw/szczurko_res2.pdf\" target=\"_blank\">here</a>.<br>";
              }
              else
              {

                for(j=0; j<pgContent[pgIndex].length; j++)
                {
                  //validOutput += pgContent[pgIndex][j];
                  var entry = pgContent[pgIndex][j].split(";;");
                  for(k=0; k<entry.length; k++)
                  {
                    if(pgIndex==2)
                    {
                      if(k==0)
                      {
                        validOutput += "<a href=\""+entry[1]+"\" target=\"_blank\">"+entry[k]+"</a>";
                      }
                      else if(k==2)
                      {
                        validOutput += "<u>Details</u>: "+entry[k];
                      }
                      else if(k==3)
                      {
                        validOutput += "<u>Description</u>: "+entry[k];
                      }
                    }
                    else if(pgIndex==3 )
                    {
                      if(k==2)
                      {
                        validOutput += "<a href=\""+entry[1]+"\" target=\"_blank\">"+entry[k]+"</a>";
                      }
                      else if(k==3)
                      {
                        validOutput += "<u>Position</u>: "+entry[k];
                      }
                      else if(k==4)
                      {
                        validOutput += "<u>Description</u>: "+entry[k];
                      }
                    }
                    else
                    {
                      validOutput += entry[k];
                    }
                    if(k != entry.length-1)
                    {
                      validOutput += "<br>";
                    }
                  }

                if(j != pgContent[pgIndex].length-1)
                {
                  validOutput += "<br>";
                }
                }
              }
            
            }
            else
            {
              /*print out error that file does not exist*/
              out.innerHTML = out.innerHTML + errorOutput(out, preText, "cat: "+args[i]+": No such file or directory", "", false);
            }
          }
          if(validOutput != "")
          {
            /*print out the correct files*/
            out.innerHTML = out.innerHTML + "<br>";
            out.innerHTML = out.innerHTML + validOutput;
          }
        }
        
      }
      else if( ((user.value).trim()).substring(0,3) == "pwd")
      {
        /*******DESCRIPTION*********
         current 'path'
         **************************/
        out.innerHTML = createOutput(out, preText, user.value);

        out.innerHTML = out.innerHTML+"<br>http://terminal.pawel.pw";
      }
      else if( ((user.value).trim()).substring(0,3) == "vim")
      {
        /*******DESCRIPTION*********
         NON supported vim
         **************************/
        var directoryCMD = (user.value).trim().substring(0,3);

        out.innerHTML = errorNotSupportedCommands(out, preText, user.value, directoryCMD, ": No way I'm recreating vim in JavaScript...");
      }
      else if( ((user.value).trim()).substring(0,2) == "vi")
      {
        /*******DESCRIPTION*********
         NON supported vi
         **************************/
        var directoryCMD = (user.value).trim().substring(0,2);

        out.innerHTML = errorNotSupportedCommands(out, preText, user.value, directoryCMD, ": No way I'm recreating vim in JavaScript...");
      }
      else if( ((user.value).trim()).substring(0,2) == "cd")
      {
        /**********DESCRIPTION***********
         NON supported directory commands
         ********************************/
        var directoryCMD = (user.value).trim().substring(0,2);

        out.innerHTML = errorNotSupportedCommands(out, preText, user.value, directoryCMD, ": directory commands not supported.");
      }
      else if( ((user.value).trim()).substring(0,5) == "mkdir")
      {
        /**********DESCRIPTION***********
         NON supported directory commands
         ********************************/
        var directoryCMD = (user.value).trim().substring(0,5);

        out.innerHTML = errorNotSupportedCommands(out, preText, user.value, directoryCMD, ": directory commands not supported.");
      }
      else if(user.value.length==0 || user.value.trim().length==0)
      {
        /**************DESCRIPTION***************
         no command enered
         ****************************************/
        out.innerHTML = createOutput(out, preText, user.value);
      }
      else
      {
        /**************DESCRIPTION***************
         default message for command not existing
         ****************************************/
        out.innerHTML = errorOutput (out, preText, user.value, ': command not found', true);
      }
      
      //clears the hidden inputbox
      user.value= "";

      //refills the cover with the normal expected preText as defined at top
      cmdCover.innerHTML=preText;

      //scroll to bottom of overflow
      var scrollWin = document.getElementById('scrollableWindow');
      scrollWin.scrollTop=scrollWin.scrollHeight;
      return false;
    }
}
</script>
</html>
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
    <link href="../includes/normalize.css" rel="stylesheet" type="text/css">

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
}
.topbar
{
  background-color: #44433F;
  color:#FFFFFF;
  height:30px;
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
    <div class="topbar">guest@pawel.pw:~$</div>
      
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
var preText = 'guest@pawel.pw~$ ';
var pages = new Array("aboutme.txt", "contact.txt", "projects.txt", "resume.pdf", "work.txt");

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
      if( (user.value).trim() == "clear")
      {
        out.innerHTML="";

      }
      else if((user.value).trim()=="ls")
      {
        if((out.innerHTML).length==0 )
        {
          out.innerHTML =preText+ user.value ;
        }
        else 
        {
          out.innerHTML =out.innerHTML + '<br>'+preText+ user.value;
        }

        out.innerHTML = out.innerHTML + "<br>";

        for(i =0; i<pages.length; i++)
        {
          out.innerHTML = out.innerHTML + pages[i] + "&nbsp;&nbsp;";
        }
        
      }
      else if((user.value).trim() == "cd")
      {
        if((out.innerHTML).length==0 )
        {
          out.innerHTML =preText+ user.value;
        }
        else 
        {
          out.innerHTML =out.innerHTML + '<br>'+preText+ user.value;
        }
      }
      else
      {
        if((out.innerHTML).length==0 )
        {
          out.innerHTML =preText+ user.value + '<br>'+user.value+': command not found';
        }
        else 
        {
          out.innerHTML =out.innerHTML + '<br>'+preText+ user.value + '<br>'+user.value+': command not found';
        }
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
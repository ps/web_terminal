/*used for cursor blinking*/
function blinks(hide) 
{
  if (hide === 1) {
      $('.fakeCursor').show();
      hide = 0;
  }
  else {
      $('.fakeCursor').hide();
      hide = 1;
  }
  setTimeout("blinks("+hide+")", 700);
}

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

window.onload = function() 
{
  //get focus to cmd textbox
  document.getElementById("cmd").focus();
  $("#cmd").val("");

  //initiate brlinking cursor
  blinks(1);
};

//this change is because Chrome interprets keystrokes
//different from Firefox. 'onkeyup' reads all keys including
//backspace on both browers while 'onkeypress' is not trigerred
//when backspace is pressed
//
//onkeyup is slower, keypress is faster but only
//supported by firefox so Im just using a boolean 
//that is set via PHP on the index.php page
document.getElementById('cmd').onkeyup = function(e) 
{

    //do this only if not Firefox browser
    if(!fire)
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
          //Old code with bugs, keeping it for now
          //cmdCover.innerHTML=preText+(user.value).substring(0,(user.value).length -1 );
          cmdCover.innerHTML=preText+(user.value);
        }
      }
      else//value of textbox + current key pressed
      {
        //Old code that was erroneous, keeping it for now
        //cmdCover.innerHTML=preText+user.value+String.fromCharCode(charCode);   
        cmdCover.innerHTML=preText+user.value;
      }
    }
    return false;
}
document.getElementById('cmd').onkeypress = function(e) 
{
    var user = document.getElementById('cmd');    

    var event = e || window.event;
    var charCode = event.which || event.keyCode;
    var cmdCover = document.getElementById('cmdCover');

    //do this only for firefox since
    //keypress is faster
    if(fire)
    {
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
              validOutput += args[i]+"<br>-------------------<br>";

              /*special just for resume page since there is no text file*/
              if(pgIndex==4)
              {
                validOutput += "My current resume can be found <a href=\"http://www.pawel.pw/szczurko_res2.pdf\" target=\"_blank\">here</a>.<br>";
              }
              else
              {

                for(j=0; j<pgContent[pgIndex].length; j++)
                {
                  var entry = pgContent[pgIndex][j].split(";;");
                  for(k=0; k<entry.length; k++)
                  {
                    /*format for projects page*/
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
                      else
                      {
                        continue;
                      }
                    }
                    else if(pgIndex==3 )/*format for work page*/
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
                      else
                      {
                        continue;
                      }
                    }
                    else
                    {
                      validOutput += entry[k];
                    }

                    /*add new lines*/
                    if(k != entry.length-1)
                    {
                      validOutput += "<br>";
                    }
                  }

                /*add new lines*/
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

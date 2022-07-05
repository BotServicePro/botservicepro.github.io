function AddLogin()

{ 

  var o = window.event.srcElement;
  if (o.tagName == "SPAN") {
    var login=o.innerText;
    if (o.alt != null && o.alt.length>0) login=o.alt;
    var i1,i2;
    if ((i1 = login.indexOf('['))>=0 && (i2 = login.indexOf(']'))>0) login=login.substring(i1+1, i2);
    if (o.className == "p") { 
       AddToPrivate(login, false) 
       
    }
    else { 
        AddTo(login)
    }
  }
}

function ClipBoard(text)
{
  holdtext.innerText = text;
  var Copied = holdtext.createTextRange();
  Copied.execCommand("RemoveFormat");
  Copied.execCommand("Copy");
}

function OpenMenu() {
  var el, x, y, login, login2;
  el = document.all("oMenu");
  var o = window.event.srcElement;
  if (o.tagName != "SPAN") return true;
  x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - 3;
  y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop;

  if (window.event.clientY + 72 > document.body.clientHeight) { y-=68 } else { y-=2 }
  login = o.innerText;
  window.event.returnValue=false;

  var i1, i2;
  if ((i1 = login.indexOf('['))>=0 && (i2 = login.indexOf(']'))>0) login=login.substring(i1+1, i2);

  var login2 = login;
  login2 = login2.replace('%', '%25');
  while (login2.indexOf('+')>=0) login2 = login2.replace('+', '%2B');
  while (login2.indexOf('#')>=0) login2 = login2.replace('#', '%23');
  while (login2.indexOf('?')>=0) login2 = login2.replace('?', '%3F');

  el.innerHTML = '<A class=menuItem HREF="javascript:AddTo(\''+login+'\');cMenu()">TO</A>'+
  '<A class=menuItem HREF="javascript:AddToPrivate(\''+login+'\');cMenu()">PRIVATE</A>'+
  '<A class=menuItem HREF="/inf.pl?login='+login2+'" target=_blank onclick="cMenu();return true;">INFO</A>'+
  '<A class=menuItem HREF="javascript:ClipBoard(\''+login+'\');cMenu()">COPY</A>';

  el.style.left = x + "px";
  el.style.top  = y + "px";
  el.style.visibility = "visible";
}

function cMenu() {
  document.all("oMenu").style.visibility = "hidden";
  document.all("oMenu").style.top="0px";
  top.frames['bottom'].F1.text.focus();
}

function closeMenu(event) {
  if (window.event && window.event.toElement) {
    var cls = window.event.toElement.className;
    if (cls=='menuItem' || cls=='menu') return;
  }
  document.all("oMenu").style.visibility = "hidden";
  document.all("oMenu").style.top="0px";
  return false;
}

function AddToPrivate(login, nolookCtrl){
              top.frames['bottom'].F1.text.value = 'private ['+login+'] '+top.frames['bottom'].F1.text.value; 
}

function AddTo(login){
      top.frames['bottom'].F1.text.focus();
                        top.frames['bottom'].F1.text.value='to ['+login+'] '+top.frames['bottom'].F1.text.value; 
}

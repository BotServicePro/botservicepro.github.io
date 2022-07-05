document.onmousedown = Down;
function Down() {top.CtrlPress = window.event.ctrlKey}

// Разрешенные смайлики
var sm = new Array("smile",18,18,  "laugh",15,15,  "fingal",22,15,  "eek",15,15,  "smoke",20,20,  "hi",31,28,  "bye",15,15,
"king",21,22, "king2",28,24, "boks2",28,21, "boks",62,28,  "gent",15,21,  "lady",15,19,  "tongue",15,15,  "smil",16,16,  "rotate",15,15,
"ponder",21,15,  "bow",15,21,  "angel",42,23, "angel2",26,25,  "hello",25,27,  "dont",26,26,  "idea",26,27,  "mol",27,22,  "super",26,28,
"beer",15,15,  "drink",19,17,  "baby",15,18,  "tongue2",15,15,  "sword",49,18,  "agree",37,15,
"loveya",27,15,  "kiss",15,15,  "kiss2",15,15,  "kiss3",15,15,  "kiss4",37,15,  "rose",15,15,  "love",27,28,
"love2", 55,24, 
"confused",15,22,  "yes",15,15,  "no",15,15,  "shuffle",15,20,  "nono",22,19,  "maniac",70,25,  "privet",27,29,  "ok",22,16,  "ninja",15,15,
"pif",46,26,  "smash",30,26,  "alien",13,15,  "pirate",23,19,  "gun",40,18,  "trup",20,20,
"mdr",56,15,  "sneeze",15,20,  "mad",15,15,  "friday",57,28,  "cry",16,16,  "grust",15,15,  "rupor",38,18,
"fie",15,15,  "nnn",82,16,  "row",36,15,  "red",15,15,  "lick",15,15,
"help",23,15,  "wink",15,15, "jeer",26,16, "tease",33,19, "nunu",43,19,
"inv",80,20,  "duel",100,34,  "susel",70,34,  "nun",40,28,  "kruger",34,27, "flowers",28,29, "horse",60,40, "hug",48,20, "str",35,25,
"alch",39,26, "pal", 25, 21, "mag", 37, 37, "sniper", 37,37, "vamp", 27,27,  "doc", 37,37, "doc2", 37,37, "sharp", 37,37, 
"naem", 37,37, "naem2", 37,37, "naem3", 37,37, "invis", 32,23,  "chtoza", 33, 37,
"beggar", 33,27, "sorry", 25,25, "sorry2", 25,25,
"creator", 39, 25, "grace", 39, 25, "dustman", 30, 21, "carreat", 40, 21, "lordhaos", 30, 21,
"ura", 31, 36, "elix", 30, 35, "dedmoroz", 32,32, "snegur", 45,45, "showng", 50, 35, "superng", 45,41,
"podz", 31,27, "sten", 44, 30, "devil", 29, 20, "cat", 29, 27, "owl", 29,20, "lightfly", 29,20, "snowfight", 51, 24,
"rocket", 43,35, "dance1", 45,23, "radio1", 36, 24, "victory", 51, 35, "dance2", 41, 31, "radio2", 29, 29, 
"nail", 32, 26, "rev", 40, 25, "obm", 37, 22, "yar", 40, 36, "rom", 38, 33, "sad", 23, 23
);
                  
function AddLogin()
{	var o = window.event.srcElement;
	if (o.tagName == "SPAN") {
		var login=o.innerText;
		if (o.alt != null && o.alt.length>0) login=o.alt;
		var i1,i2;
		if ((i1 = login.indexOf('['))>=0 && (i2 = login.indexOf(']'))>0) login=login.substring(i1+1, i2);
		if (o.className.substr(0,1) == "p") { top.AddToPrivate(login, false) }
		else if (o.className == "s") {top.AddToSms(login, false) }
		else { top.AddTo(login) }
	}
}

function ClipBoard(text)
{
	holdtext.innerText = text;
	var Copied = holdtext.createTextRange();
	Copied.execCommand("RemoveFormat");
	Copied.execCommand("Copy");
}

function OpenMenu(th) {
	var el, x, y, login, login2;
	el = document.all("oMenu");
	var o = window.event.srcElement;
	if (o.tagName != "SPAN") return true;
	x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - 3;
	y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop;

	if (window.event.clientY + 72 > document.body.clientHeight) { y-=68 } else { y-=2 }
	login = o.innerText;
	if (o.alt != null && o.alt.length>0) login = o.alt;
	window.event.returnValue=false;
	var i1, i2;
	if ((i1 = login.indexOf('['))>=0 && (i2 = login.indexOf(']'))>0) login=login.substring(i1+1, i2);
	var login2 = login;
	login2 = login2.replace('%', '%25');
	while (login2.indexOf('+')>=0) login2 = login2.replace('+', '%2B');
	while (login2.indexOf('#')>=0) login2 = login2.replace('#', '%23');
	while (login2.indexOf('?')>=0) login2 = login2.replace('?', '%3F');

	el.innerHTML = '<A class=menuItem HREF="javascript:top.AddTo(\''+login+'\');cMenu()">TO</A>'+
	'<A class=menuItem HREF="javascript:top.AddToPrivate(\''+login+'\');cMenu()">PRIVATE</A>'+
	'<A class=menuItem HREF="" target=_blank onclick="OpenInfo(\''+login2+'\');return false;">INFO</A>'+
	'<A class=menuItem HREF="javascript:ClipBoard(\''+login+'\');cMenu()">COPY</A>';

	el.style.left = x + "px";
	el.style.top  = y + "px";
	el.style.visibility = "visible";
}

function OpenInfo(login) {
    var lar = login.split(/,/g);
    for (i=0;i<lar.length;i++) {
	if (lar[i].match(/^(k|c)lan$/i)) {
	    window.open('http://capitalcity.combats.ru/encicl/clans.html');
	} else {
	    window.open('/inf.pl?login='+top.trim(lar[i])); 
	}
    }

}

function cMenu() {
  document.all("oMenu").style.visibility = "hidden";
  document.all("oMenu").style.top="0px";
  top.frames['bottom'].window.document.F1.text.focus();
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

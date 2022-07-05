function GetElemById(id){
	if (document.getElementById) {
		return (document.getElementById(id));
	} else if (document.all) {
		return (document.all[id]);
	} else {
		if ((navigator.appname.indexOf("Netscape") != -1) && parseInt(navigator.appversion == 4)) {
			return (document.layers[id]);
		}
	}
}
function getStyle(id){
	if (GetElemById(id).style) {return(GetElemById(id).style)}
	else {return (GetElemById(id))}
}
function getCord(obj) {
var x=0, y=0, tg=obj;
while(obj) {
   x+=obj.offsetLeft;
   y+=obj.offsetTop;
   obj=obj.offsetParent;
}
return  {target: tg, x: x, y:y};
}

function Change(idCell, clName)
{
	GetElemById(idCell).className=clName;
}
function hiddenLayer(elem)
{
	getStyle(elem).visibility = 'hidden';
}
function showLayer(elem)
{
	var divProducts = GetElemById('products');
	var cord = getCord(divProducts);
	getStyle(elem).left=cord.x - 1 + 'px';
	getStyle(elem).top=cord.y + 13 + 'px';
	getStyle(elem).visibility='visible';
} 
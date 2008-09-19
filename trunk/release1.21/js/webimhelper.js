//************************************************
//*Base
//************************************************
function $(a)
{
	return typeof(a) == "string"?document.getElementById(a):a;
}
function $F(a)
{
	if(!$(a))return "";
	var tag = $(a).tagName.toUpperCase();
	if(tag=="INPUT"||tag=="TEXTAREA"||tag=="SELECT")
	{
		return $(a).value;
	}
	else
	{
		return $(a).innerHTML;
	}
}
function $T(o)
{
	if(arguments.length==1)
	{
		return $T(document,o);
	}
	if(!$(o))return null;
	return $(o).getElementsByTagName(arguments[1]);
}
//**********************************
//*dom
//**********************************
var Elem = {
	New:function(a,d,c,i)
	{
		var o = document.createElement(a);
		if(d)o.id = d;
		if(c)o.className = c;
		if(i)o.innerHTML = i;
		return o;
	},
	Add:function(o)
	{
		if(arguments.length==1)
		{
			Elem.Add(document.body,o);
			return;
		}
		var o = $(o);
		if(!o)return;
		for (var i = 1; i < arguments.length; i++)
		{
			o.appendChild($(arguments[i]));
		}
		return o;
	},
	Del:function()
	{
		for (var i = 0; i < arguments.length; i++)
		{
			if($(arguments[i]))
				$(arguments[i]).parentNode.removeChild($(arguments[i]));
		}
	},
	Hid:function()
	{
		for (var i = 0; i < arguments.length; i++)
		{
			if($(arguments[i]))
				$(arguments[i]).style.display="none";
		}
	},
	Show:function()
	{
		for (var i = 0; i < arguments.length; i++)
		{
			if($(arguments[i]))
				$(arguments[i]).style.display="block";
		}
	},
	Value:function(o,s)
	{
		s=s?s:"";
		if(!$(o))return;
		var tag = $(o).tagName.toUpperCase();
		if(tag=="INPUT"||tag=="TEXTAREA"||tag=="SELECT")
		{
			$(o).value = s;
		}
		else
		{
			$(o).innerHTML = s;
		}
	},
	Append:function(o,s)
	{
		var tag = $(o).tagName.toUpperCase();
		if(tag=="INPUT"||tag=="TEXTAREA")
		{
			$(o).value += s;
		}
		else
		{
			$(o).innerHTML += s;
		}
	},
	Toggle:function()
	{
		for (var i = 0; i < arguments.length; i++)
		{
			if($(arguments[i]))
				$(arguments[i]).style.display=$(arguments[i]).style.display=="none"?"block":"none";
		}
	},
	Enable:function()
	{
		for (var i = 0; i < arguments.length; i++)
		{
			$(arguments[i]).disabled="";
		}
	},
	Disable:function()
	{
		for (var i = 0; i < arguments.length; i++)
		{
			$(arguments[i]).disabled="disabled";
		}
	},
	Child:function(o)
	{
		return $(o).childNodes;
	},
	GetX:function(o,po)
	{
		for (var lx=0;o!=po;lx+=o.offsetLeft,o=o.offsetParent);
		return lx;
	},
	GetY:function(o,po)
	{
		for (var ly=0;o!=po;ly+=o.offsetTop,o=o.offsetParent);
		return ly;
	},
	Top:function()
	{
		if(typeof(window.pageYOffset)!='undefined')
		{
			return window.pageYOffset;
		}
		else if(typeof(document.compatMode)!='undefined'&&document.compatMode!='BackCompat')
		{
			return document.documentElement.scrollTop;
		}
		else if(typeof(document.body)!='undefined')
		{
			return document.body.scrollTop;
		}
	},
	Left:function()
	{
		if(typeof(window.pageXOffset)!='undefined')
		{
			return window.pageXOffset;
		}
		else if(typeof(document.compatMode)!='undefined'&&document.compatMode!='BackCompat')
		{
			return document.documentElement.scrollLeft;
		}
		else if(typeof(document.body)!='undefined')
		{
			return document.body.scrollLeft;
		}
	},
	Width:function()
	{
		if(typeof(document.compatMode)!='undefined'&&document.compatMode!='BackCompat')
		{
			return document.documentElement.clientWidth;
		}
		else if(typeof(document.body)!='undefined')
		{
			return document.body.clientWidth;
		}
	},
	Height:function()
	{
		if(typeof(document.compatMode)!='undefined'&&document.compatMode!='BackCompat')
		{
			return document.documentElement.clientHeight;
		}
		else if(typeof(document.body)!='undefined')
		{
			return document.body.clientHeight;
		}
	}
}
//*****************************************
//*Event
//*****************************************
var Evt = {
	NoBubble:function(e)
	{
		e&&e.stopPropagation?e.stopPropagation():event.cancelBubble=true;
	},
	Top:function(e)
	{
		return (e||event).clientY;
	},
	Left:function(e)
	{
		return (e||event).clientX;
	}
}
//******************************************
//*xml
//******************************************
var Xml = {
	First:function(o,key)
	{
		return $T(o,key)[0]&&$T(o,key)[0].firstChild?$T(o,key)[0].firstChild.nodeValue:"";
	}
}
//******************************************
//other
//******************************************
var Other = {
	Even:function(n)
	{
		return parseInt((parseInt(n))/2)*2;
	},
	Break:function(o,len)
	{
		var strContent=$F(o);
		var strTemp="";
		while(strContent.length>len)
		{
			strTemp+=strContent.substr(0,len)+"&#10;";
			strContent=strContent.substr(len,strContent.length);
		}
		strTemp+="&#10;"+strContent;
		return strTemp;
	},
	Browser:function()
	{
		if(!!window.opera)
		{
			return "opera";
		}
		else if(navigator.userAgent.toLowerCase().indexOf("safari")>0)
		{
			return "safari";
		}
		else if(navigator.userAgent.toLowerCase().indexOf("gecko")>0)
		{
			return "firefox";
		}
		else
		{
			return "ie";
		}
	},
	GetCookie:function(key)
	{
		var search=key+"=";
		if(document.cookie.length>0)
		{
			var offset=document.cookie.indexOf(search);
			if(offset!=-1)
			{
				offset+=search.length;
				var end=document.cookie.indexOf(";",offset);
				if(end==-1)end=document.cookie.length;
				return unescape(document.cookie.substring(offset,end));
			}
			return "";
		}
		return "";
	},
	SetCookie:function(key,value)
	{
		var today=new Date();
		var expires=new Date();
		value = value.toString();
		expires.setTime(today.getTime()+1000*60*60*24*365);
		document.cookie=key+"="+escape(value)+";path=/; expires="+expires.toGMTString();
	},
	TestCookie:function()
	{
		Other.SetCookie("test","");
		var t = "test";
		Other.SetCookie("test",t);
		return Other.GetCookie("test")==t;
	}
}

//******************************************
//String
//******************************************
String.prototype.trim = function()
{
	var str = this;
	var m = str.match(/^\s*(\S+(\s+\S+)*)\s*$/);
	return (m == null) ? "" : m[1];
}
String.prototype.strip = function()
{
    return this.replace(/<\/?[^>]+>/gi, '').trim();
}
String.prototype.escapeHTML = function()
{
    var div = document.createElement('div');
    var text = document.createTextNode(this);
    div.appendChild(text);
    return div.innerHTML;
}
String.prototype.unescapeHTML = function()
{
    var div = document.createElement('div');
    div.innerHTML = this.stripTags();
    return div.childNodes[0].nodeValue;
}
String.prototype.escapeEx = function()
{
    return encodeURIComponent(this).replace(/\+/g,"%2b");
}
String.prototype.replaceAll = function(a,b)
{
	return this.replace(new RegExp(a.replace(/([\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\/\\])/g,"\\$1"),"g"),b);
}
String.prototype.indexOfEx = function()
{
	var bi = arguments[arguments.length - 1];
	var thisObj = this;
	var idx = 0;
	if(typeof(arguments[arguments.length - 2]) == 'number')
	{
		idx = arguments[arguments.length - 2];
		thisObj = this.substr(idx);
	}
	var re = new RegExp(arguments[0],bi?'i':'');
	var r = thisObj.match(re);
	return r==null?-1:r.index + idx;
}
String.prototype.padLeft = function(str,n)
{
	var result = this;
	if(this.length<n)
	for(var i=0;i<n-this.length;i++)
		result = str+result;
	return result;
}
//******************************************
//Array
//******************************************
Array.prototype.indexOf = function(obj)
{
    var result = -1;
    for(var i = 0; i < this.length; i++)
	{
        if(this[i] == obj)
		{
            result = i;
            break;
        }
    }
    return result;
}
Array.prototype.contains = function(obj)
{
    return this.indexOf(obj) > -1;
}
Array.prototype.add = function(obj)
{
    if(!(this.contains(obj)))
	{
        this[this.length] = obj;
    }
}
Array.prototype.remove = function(obj)
{
    if(this.contains(obj))
	{
        var index = this.indexOf(obj);
        for(var i = index; i < this.length - 1; i++)
		{
            this[i] = this[i + 1];
        }
        this.length--;
    }
}
Array.prototype.clear = function()
{
	this.splice(0,this.length);
}
Array.prototype.value = function(s,l)
{
	if(l)this.length=l;
	for(var i = 0; i < this.length; i++)
	{
		this[i] = s;
	}
}
//**********************************************************
//*StringBuilder
//**********************************************************
function StringBuilder()
{
	this._arr = new Array();
	this.add = function()
	{
		for(var i = 0;i<arguments.length;i++)
			this._arr.push(arguments[i]);
	}
	this.toString = function()
	{
		return this._arr.join("");
	}
}
//**********************************************************
//*Ajax
//**********************************************************
function Ajax()
{
	var _req = !!0;
	try{_req=new XMLHttpRequest;}catch(e){try {_req=new ActiveXObject("MSXML2.XMLHTTP");}catch(e2){try {_req=new ActiveXObject("Microsoft.XMLHTTP");}catch(e3){_req=false;}}}
	if (!_req) return;
	this.req = _req;
	this.send = function(_url,_content,_callback,_method,_isasync)
	{
		var Url      = _url||"";
		var Content  = _content||"";
		var Callback = _callback;
		var Method   = _method||"GET";
		var IsAsync  = _isasync==null?true:_isasync;
		_req.open (Method,Url,IsAsync);
		if(Method=="POST")_req.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		_req.onreadystatechange = function()
		{
			if(_req.readyState==4&&Callback)
			{
				Callback(_req.status==200?_req:null);
			}
		};
		_req.send(Method=="POST"?Content:"");
	}
	this.get = function(_url,_callback)
	{
		this.send(_url,"",_callback,"GET");
	}
	this.post = function(_url,_content,_callback)
	{
		this.send(_url,_content,_callback,"POST");
	}
}

//**********************************
//*
//**********************************
window.zIndex = 100;
window.cWindow = "winMain0";
function WebForm()
{
	this.Type = 1;             
	this.UserID = 0;           
	this.Top = 20;
	this.Left = 40;
	this.Width = 500;
	this.Height = 300;
	this.Icon = "";
	this.Title = "***";
	this.Content = "";           
	this.ContentUrl = "";        
	this.MinWidth = 150;         
	this.MinHeight = 150;        
	this.RepaintMethod   = null; 
	this.ClosingCallback = null; 
	this.CloseCallback   = null; 
	this.LoadedCallback  = null; 
	this.Resizeable = !0;        
	this.Moveable   = !0;        
	this.CanControl = !0;        
	this.ShowCorner = !0;        
	var _div = null;
	var _me = this;
	this._minStatus = !!0;
	this.Show = function()
	{
		if(!$("windowContainer")) 
		{
			var divCover = Elem.New("div","windowCover","w-window-cover");
			divCover.oncontextmenu = function(){return !!0};
			Elem.Add(Elem.Add(Elem.New("div","windowContainerBorder","w-container-border"),
				Elem.Add(Elem.New("div","windowContainer","w-container"),
				Elem.New("input","inputHack","w-elem-hidden"),
				Elem.New("div","divSound","w-elem-hidden"),
				Elem.New("div","windowBorder","w-window-border"),divCover)));
			WinManage.IntWinManage();
		}
		_me.TypeStr = WinManage.GetWindowType(this.Type);
		if(this.Content==""&&this.ContentUrl=="")
		{
			this.ContentUrl = "layout/win"+_me.TypeStr+".htm";
		}
		_div = Elem.New("div","win"+_me.TypeStr+this.UserID,"w-"+_me.TypeStr);
		_div.oncontextmenu = function(){return !!0;};
		_div.onmousedown = function(){_me.Focus();};
		var oDivCon = Elem.New("div","","w-content");
		var oDivTitle = Elem.New("div",_div.id+"Title","w-"+_me.TypeStr+"-title");
		oDivTitle.onselectstart = function(){return !!0;};
		var oDivIcon = Elem.New("div","win"+_me.TypeStr+"Icon"+this.UserID,"w-icon","<img src=\"images/"+this.Icon+"\" />");
		var oDivText = Elem.New("div","win"+_me.TypeStr+"Text"+this.UserID,"w-text",this.Title);
		if(this.Moveable)
		{
			oDivText.style.cursor = "move";
			oDivText.onmousedown = function (e)
			{
				if(_me.Type!=3&&_me._minStatus)return;
				var bs = $("windowBorder").style;
				bs.top = _me.Top+"px";
				bs.left = _me.Left+"px";
				bs.width = _me._minStatus?"166px":_me.Width+"px";
				bs.height = _me._minStatus?"24px":_me.Height+"px";
				Elem.Show("windowBorder");
				_me.chaLeft = Evt.Left(e) - _me.Left;
				_me.chaTop = Evt.Top(e) - _me.Top;
				document.body.style.cursor = "move";
				document.onmousemove = function(e)
				{
					bs.left = (_me.Left=Evt.Left(e)-_me.chaLeft)+"px";
					bs.top = (_me.Top=(Evt.Top(e)-_me.chaTop)<0?0:Evt.Top(e)-_me.chaTop)+"px";
				};
				document.onmouseup = function()
				{
					_div.style.left = bs.left;
					_div.style.top = bs.top;
					document.body.style.cursor = "";
					document.onmousemove = document.onmouseup = null;
					Elem.Hid("windowBorder");
				};
			};
		}
		Elem.Add(oDivTitle,oDivIcon,oDivText);
		if(this.CanControl)
		{
			var oDivControl = Elem.New("div","win"+_me.TypeStr+"Control"+this.UserID,"w-control", "<div class=\"w-control-min\" onmouseover=\"this.scrollTop='17'\" onmouseout=\"this.scrollTop='0'\"><img src=\"images/"+_me.TypeStr+"controlmin.gif\" title=\"Minimize\"/></div><div class=\"w-control-close\" onmouseover=\"this.scrollTop='17'\" onmouseout=\"this.scrollTop='0'\"><img src=\"images/"+_me.TypeStr+"controlclose.gif\" title=\"Close\"/></div>");
			Elem.Add(oDivTitle,oDivControl);
			var btnControls = $T(oDivControl,"div");
			btnControls[0].onclick = function(){_me.Minimize();};
			btnControls[1].onclick = function(){_me.Close();};
		}
		var oDivMainContent = Elem.New("div","winMainContentId"+this.UserID+"Type"+this.Type,"w-window-content");
		_me.MainContent = oDivMainContent.id;
		oDivMainContent.style.backgroundColor = "#efefef";
		oDivMainContent.style.height = (this.Height-24)+"px";
		Elem.Add(oDivCon,oDivTitle,oDivMainContent);
		if(this.ShowCorner)
		{
			Elem.Add(_div,
				_div.appendChild(Elem.New("div","","w-round-lt")),
				_div.appendChild(Elem.New("div","","w-round-rt")),
				_div.appendChild(Elem.New("div","","w-round-lb")),
				_div.appendChild(Elem.New("div","","w-round-rb")));
		}
		if(this.Resizeable)
		{
			var oDiv5 = Elem.New("div","","w-resize");
			oDiv5.onmousedown = function(e)
			{
				if(_me._minStatus)return;
				var bs = $("windowBorder").style;
				bs.top = _me.Top+"px";
				bs.left = _me.Left+"px";
				bs.width = _me.Width+"px";
				bs.height = _me.Height+"px";
				Elem.Show("windowBorder");
				document.body.style.cursor = "SE-resize";
				document.onmousemove = function(e)
				{
					if((Evt.Top(e)-_me.Top)>_me.MinHeight)bs.height = (Evt.Top(e)-_me.Top)+"px";
					if((Evt.Left(e)-_me.Left)>_me.MinWidth)bs.width = (Evt.Left(e)-_me.Left)+"px";
				};
				document.onmouseup = function()
				{
					_me.Height= Other.Even(bs.height);
					_me.Width = Other.Even(bs.width);
					$(_me.MainContent).style.height = (_me.Height-24)+"px";
					if(_me.RepaintMethod)_me.RepaintMethod(_me.Width,_me.Height-24,_me.UserID,_me.Type);
					_div.style.height= _me.Height +"px";
					_div.style.width = _me.Width+"px";
					document.body.style.cursor = "";
					document.onmousemove = document.onmouseup = null;
					Elem.Hid("windowBorder");
				};
			};
			Elem.Add(_div,oDiv5);
		}
		var oDivLoading = Elem.New("div","win"+_me.TypeStr+"Loading"+this.UserID,"w-loading", "loading...");
		Elem.Add(_div,oDivCon,oDivLoading);

		var ds = _div.style;
		ds.position = "absolute";
		ds.left = this.Left+"px";
		ds.top = this.Top+"px";
		ds.width = Other.Even(this.Width)+"px";
		ds.height = Other.Even(this.Height)+"px";
		ds.zIndex = ++window.zIndex;
		if(window.cWindow!=_div.id)oDivTitle.style.color = "#999";
		Elem.Add("windowContainer",_div);
		WinManage.WindowsList.add({
				id : this.UserID,
				type : this.Type,
				isMin : this._minStatus,
				win : _me
			});
		WinManage.ListWindows();
		WinManage.ScrollWindows();

		if(this.ContentUrl!="")
		{
			this.ShowLoading();
			new Ajax().get(this.ContentUrl,function(o)
			{
				oDivMainContent.innerHTML = o.responseText.replace(/\[id\]/img,_me.UserID).replace(/\[type\]/img,_me.Type);
				_me.HideLoading();
				if(_me.RepaintMethod)_me.RepaintMethod(_me.Width,_me.Height-24,_me.UserID,_me.Type);
				if(_me.LoadedCallback)_me.LoadedCallback(_me.UserID,_me.Type);
			});
		}
		else
		{
			oDivMainContent.innerHTML = this.Content.replace(/\[id\]/img,this.UserID).replace(/\[type\]/img,this.Type);
			if(this.RepaintMethod)this.RepaintMethod(this.Width,this.Height-24,this.UserID,this.Type);
			if(this.LoadedCallback)this.LoadedCallback(this.UserID,this.Type);
		}
	};
	this.Minimize = function()
	{
		var ds = _div.style;
		if(!_me._minStatus)
		{
			Elem.Hid("winMainContentId"+this.UserID+"Type"+this.Type);
			$T("win"+_me.TypeStr+"Control"+this.UserID,"img")[0].title="Restore";
			ds.height = "24px";
			ds.width = "166px";
		}
		else
		{
			Elem.Show("winMainContentId"+this.UserID+"Type"+this.Type);
			$T("win"+_me.TypeStr+"Control"+this.UserID,"img")[0].title="Minimize";
			ds.height = _me.Height+"px";
			ds.width = _me.Width+"px";
			ds.top = _me.Top+"px";
			ds.left = _me.Left+"px";
		}
		_me._minStatus = !_me._minStatus;
		WinManage.GetWindow(_me.UserID,_me.Type).isMin = _me._minStatus;
		WinManage.ListWindows();
	};

	this.Close = function(p)
	{
		if(this.ClosingCallback)
		{
			if(!this.ClosingCallback())return;
		}
		WinManage.WindowsList.remove(WinManage.GetWindow(_me.UserID,_me.Type));
		Elem.Del(_div);//close
		delete _me;
		if(this.CloseCallback)this.CloseCallback(this.UserID,this.Type,p);
		WinManage.ListWindows();
		if($("inputHack"))$("inputHack").select();
	};
	this.Focus = function()
	{
		if (window.cWindow!=_div.id)
		{
			$(window.cWindow+"Title")&&($(window.cWindow+"Title").style.color = "#999");
			_div.style.zIndex = ++window.zIndex;
		}
		window.cWindow = _div.id;
		$(_div.id+"Title").style.color = "#000";
	};
	this.ShowLoading = function()
	{
		if(this._minStatus)return;
		Elem.Show("win"+_me.TypeStr+"Loading"+this.UserID);
	};
	this.HideLoading = function()
	{
		Elem.Hid("win"+_me.TypeStr+"Loading"+this.UserID);
	};
	this.Flash = function()
	{
		if (window.cWindow!=_div.id||_me._minStatus)
		{
			var oTitle = $("win"+_me.TypeStr+"Text"+this.UserID);
			var times = 15;
			var flag = !0;
			var intId = setInterval(function()
			{
				oTitle.innerHTML = flag?_me.Title:"<span style='color:red;font-weight:bold'>"+_me.Title+"</span>";
				flag=!flag;
				times-=1;
				if(times<1)
				{
					clearInterval(intId);
					oTitle.innerHTML = _me.Title;
				}
			},500);
		}
	};
}

//**********************************
//*Windows Manager
//**********************************
var WinManage = {
	WindowsList : new Array(), 

	GetWindow:function(id,type)
	{
		var obj = null;
		for(var i = 0 ;i < WinManage.WindowsList.length;i++)
		{
			if(WinManage.WindowsList[i].id==id&&WinManage.WindowsList[i].type==type)
			{
				obj = WinManage.WindowsList[i];
				break;
			}
		}
		return obj;
	},

	GetLastWindow:function(t)
	{
		var obj = null;
		for(var i = 0 ;i < WinManage.WindowsList.length;i++)
		{
			if(WinManage.WindowsList[i].type==t)
			{
				obj = WinManage.WindowsList[i];
			}
		}
		return obj;
	},

	GetMinWindowNum:function()
	{
		var num = 0 ;
		for(var i = 0 ;i < WinManage.WindowsList.length;i++)
		{
			WinManage.WindowsList[i].isMin&&num++;
		}
		return num;
	},

	GetObjByWindow:function(w)
	{
		return $("win"+WinManage.GetWindowType(w.type)+w.id);
	},

	GetWindowType:function(n)
	{
		return ["chat","main","other"][n-1];
	},
	FlashWindow:function(w)
	{
		var oWin = WinManage.GetObjByWindow(w);
		var times = 32;
		var flag = !0;
		var x = parseInt(oWin.style.left);
		var y = parseInt(oWin.style.top);
		var intId = setInterval(function()
		{
			oWin.style.left = (x+(flag?4:0))+"px";
			oWin.style.top = (y+(flag?4:0))+"px";
			flag=!flag;
			times-=1;
			times<1&&clearInterval(intId);
		},100);
	},

	ScrollWindows:function() 
	{
		$("windowContainerBorder").style.top = Elem.Top()+"px";
		$("windowContainerBorder").style.left = Elem.Left()+"px";
	},
	ListWindows:function() 
	{
		var t1=0,t2=0;
		var t1Max = parseInt((Elem.Width()-5)/167);
		for(var i = 0 ;i < WinManage.WindowsList.length;i++)
		{
			var w = WinManage.WindowsList[i];
			if(w.type==1&&w.isMin)
			{
				var t1row = parseInt(t1/t1Max);
				var t1col = t1 - t1Max*t1row;
				var olem = $("win"+WinManage.GetWindowType(w.type)+w.id);
				olem.style.top = (Elem.Height()-t1row*25-26)+"px";
				olem.style.left = t1col*167+1+"px";
				t1++;
			}
			if(w.type==2&&w.isMin)
			{
				var olem = $("win"+WinManage.GetWindowType(w.type)+w.id);
				olem.style.top ="1px";
				olem.style.left = t2*167+1+"px";
				t2++;
			}
		}
	},
	IntWinManage:function()
	{
		window.onscroll = this.ScrollWindows;
		window.onresize = this.ListWindows;
	}
}
//******************************
//*Menu
//******************************
function sysMenu(_id)
{
	var _me = this;
	this.Id = _id;
	this.E = null;
	this.Top = null;
	this.Left = null;
	this.Data = new Array();
	this.HasIcon = !!0;
	this.Width = 100;
	this.Show = function()
	{
		this.Left = this.Left||Evt.Left(this.E);
		this.Top = this.Top||Evt.Top(this.E);
		this.Top = this.Top>(Elem.Height()-height-10)?(this.Top-height-6):this.Top;
		this.Left = this.Left>(Elem.Width()-this.Width-10)?(this.Left-this.Width-6):this.Left;
		$(this.Id)&&Elem.Del($(this.Id));
		var height = 0;
		var sb = new StringBuilder();
		for(var f=0;f<this.Data.length;f++)
		{
			sb.add("<div onselectstart=\"return false;\" ");
			if(this.Data[f]!="")
			{
				var arrT=this.Data[f].split('|');
				var itemClassName=this.HasIcon?"sys-menu-item-with-icon":"sys-menu-item";
				sb.add("class=\""+itemClassName+"\" ");
				if(arrT.length>3)
				{
					sb.add("onmouseover=\"this.className='"+itemClassName+" sys-menu-item-hover';this.style.backgroundImage='url("+arrT[3]+")'\" onmouseout=\"this.className='"+itemClassName+"';this.style.backgroundImage='url("+arrT[2]+")'\"");
				}
				else
				{
					sb.add("onmouseover=\"this.className='"+itemClassName+" sys-menu-item-hover'\" onmouseout=\"this.className='"+itemClassName+"'\"");
				}
				if(arrT.length>2)sb.add("style=\"background-image:url("+arrT[2]+")\"");
				sb.add(" onclick=\"Evt.NoBubble(event);Elem.Hid('"+this.Id+"');"+arrT[1]+"\" ");
				height+=19;
				sb.add(">"+arrT[0]+"</div>");
			}
			else
			{
				sb.add("class=\"sys-menu-item-disabled\"></div>");
				height+=7;
			}
		}
		_me.Height = height;
		var divMenu = Elem.New("div",this.Id,"sys-menu",sb.toString());
		Elem.Add("windowContainer",divMenu);
		var ms = divMenu.style;
		ms.width = this.Width+"px";
		ms.height = height+"px";
		ms.top = this.Top+"px";
		ms.left = this.Left+"px";
		Elem.Show(divMenu);
		Evt.NoBubble(this.E);
		divMenu.oncontextmenu = function(){return !!0;};
		document.onmousedown = function(e)
		{
			var ex = Evt.Left(e);
			var ey = Evt.Top(e);
			if(!(ex>_me.Left&&ex<_me.Left+_me.Width+6&&ey>_me.Top&&ey<_me.Top+_me.Height+6))
			{
				Elem.Hid(_me.Id);
				document.onmousedown = null;
			}
		};
	};
}
//******************************
//*Check box
//******************************
function CheckBox(_checkobj,_text)
{
	this.checkObj = _checkobj.value?_checkobj:$(_checkobj);
	this.text = _text;
	var _me = this;
	this.Render = function()
	{
		Elem.Hid(this.checkObj);
		var oImg = Elem.New("div","",this.checkObj.checked?"c-check-box-checked":"c-check-box");
		ois = oImg.style;
		ois.cursor = "pointer";
		Elem.Add(this.checkObj.parentNode,oImg);
		oImg.onclick = this.checkedChanged;
		_me.objImg = oImg;
		if(this.text)
		{
			var oSpan = Elem.New("span","","",this.text);
			oss = oSpan.style;
			oss.paddingLeft = "5px";
			oss.cursor = "pointer";
			oss.fontSize = "12px";
			oSpan.onclick = this.checkedChanged;
			oSpan.onselectstart = function (){return false;};
			Elem.Add(this.checkObj.parentNode,oSpan);
		}
	}
	this.checkedChanged = function()
	{
		_me.objImg.className=_me.objImg.className.indexOf("checked")>0?"c-check-box":"c-check-box-checked";
		_me.checkObj.checked=!_me.checkObj.checked;
	}
}
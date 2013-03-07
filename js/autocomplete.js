(function(d){"function"===typeof define&&define.amd?define(["jquery"],d):d(jQuery)})(function(d){function f(a,b){var c=function(){},c={autoSelectFirst:!1,appendTo:"body",serviceUrl:null,lookup:null,onSelect:null,width:"auto",minChars:1,maxHeight:300,deferRequestBy:0,params:{},formatResult:f.formatResult,delimiter:null,zIndex:9999,type:"GET",noCache:!1,onSearchStart:c,onSearchComplete:c,containerClass:"autocomplete-suggestions",tabDisabled:!1,lookupFilter:function(a,b,c){return-1!==a.value.toLowerCase().indexOf(c)},
paramName:"query",transformResult:function(a){return a.suggestions}};this.element=a;this.el=d(a);this.suggestions=[];this.badQueries=[];this.selectedIndex=-1;this.currentValue=this.element.value;this.intervalId=0;this.cachedResponse=[];this.onChange=this.onChangeInterval=null;this.isLocal=this.ignoreValueChange=!1;this.suggestionsContainer=null;this.options=d.extend({},c,b);this.classes={selected:"autocomplete-selected",suggestion:"autocomplete-suggestion"};this.initialize();this.setOptions(b)}var h=
{extend:function(a,b){return d.extend(a,b)},addEvent:function(a,b,c){if(a.addEventListener)a.addEventListener(b,c,!1);else if(a.attachEvent)a.attachEvent("on"+b,c);else throw Error("Browser doesn't support addEventListener or attachEvent");},removeEvent:function(a,b,c){a.removeEventListener?a.removeEventListener(b,c,!1):a.detachEvent&&a.detachEvent("on"+b,c)},createNode:function(a){var b=document.createElement("div");b.innerHTML=a;return b.firstChild}};f.utils=h;d.Autocomplete=f;f.formatResult=function(a,
b){var c="("+b.replace(RegExp("(\\/|\\.|\\*|\\+|\\?|\\||\\(|\\)|\\[|\\]|\\{|\\}|\\\\)","g"),"\\$1")+")";return a.value.replace(RegExp(c,"gi"),"<strong>$1</strong>")};f.prototype={killerFn:null,initialize:function(){var a=this,b="."+a.classes.suggestion,c=a.classes.selected,e=a.options,g;a.element.setAttribute("autocomplete","off");a.killerFn=function(b){0===d(b.target).closest("."+a.options.containerClass).length&&(a.killSuggestions(),a.disableKillerFn())};if(!e.width||"auto"===e.width)e.width=a.el.outerWidth();
a.suggestionsContainer=f.utils.createNode('<div class="'+e.containerClass+'" style="position: absolute; display: none;"></div>');g=d(a.suggestionsContainer);g.appendTo(e.appendTo).width(e.width);g.on("mouseover",b,function(){a.activate(d(this).data("index"))});g.on("mouseout",function(){a.selectedIndex=-1;g.children("."+c).removeClass(c)});g.on("click",b,function(){a.select(d(this).data("index"))});a.fixPosition();if(window.opera)a.el.on("keypress",function(b){a.onKeyPress(b)});else a.el.on("keydown",
function(b){a.onKeyPress(b)});a.el.on("keyup",function(b){a.onKeyUp(b)});a.el.on("blur",function(){a.onBlur()});a.el.on("focus",function(){a.fixPosition()})},onBlur:function(){this.enableKillerFn()},setOptions:function(a){var b=this.options;h.extend(b,a);if(this.isLocal=d.isArray(b.lookup))b.lookup=this.verifySuggestionsFormat(b.lookup);d(this.suggestionsContainer).css({"max-height":b.maxHeight+"px",width:b.width+"px","z-index":b.zIndex})},clearCache:function(){this.cachedResponse=[];this.badQueries=
[]},disable:function(){this.disabled=!0},enable:function(){this.disabled=!1},fixPosition:function(){var a;"body"===this.options.appendTo&&(a=this.el.offset(),d(this.suggestionsContainer).css({top:a.top+this.el.outerHeight()+"px",left:a.left+"px"}))},enableKillerFn:function(){d(document).on("click",this.killerFn)},disableKillerFn:function(){d(document).off("click",this.killerFn)},killSuggestions:function(){var a=this;a.stopKillSuggestions();a.intervalId=window.setInterval(function(){a.hide();a.stopKillSuggestions()},
300)},stopKillSuggestions:function(){window.clearInterval(this.intervalId)},onKeyPress:function(a){if(!this.disabled&&!this.visible&&40===a.keyCode&&this.currentValue)this.suggest();else if(!this.disabled&&this.visible){switch(a.keyCode){case 27:this.el.val(this.currentValue);this.hide();break;case 9:case 13:if(-1===this.selectedIndex){this.hide();return}this.select(this.selectedIndex);if(9===a.keyCode&&!1===this.options.tabDisabled)return;break;case 38:this.moveUp();break;case 40:this.moveDown();
break;default:return}a.stopImmediatePropagation();a.preventDefault()}},onKeyUp:function(a){var b=this;if(!b.disabled){switch(a.keyCode){case 38:case 40:return}clearInterval(b.onChangeInterval);if(b.currentValue!==b.el.val())if(0<b.options.deferRequestBy)b.onChangeInterval=setInterval(function(){b.onValueChange()},b.options.deferRequestBy);else b.onValueChange()}},onValueChange:function(){var a;clearInterval(this.onChangeInterval);this.currentValue=this.element.value;a=this.getQuery(this.currentValue);
this.selectedIndex=-1;this.ignoreValueChange?this.ignoreValueChange=!1:""===a||a.length<this.options.minChars?this.hide():this.getSuggestions(a)},getQuery:function(a){var b=this.options.delimiter;if(!b)return d.trim(a);a=a.split(b);return d.trim(a[a.length-1])},getSuggestionsLocal:function(a){var b=a.toLowerCase(),c=this.options.lookupFilter;return{suggestions:d.grep(this.options.lookup,function(d){return c(d,a,b)})}},getSuggestions:function(a){var b,c=this,e=c.options;(b=c.isLocal?c.getSuggestionsLocal(a):
c.cachedResponse[a])&&d.isArray(b.suggestions)?(c.suggestions=b.suggestions,c.suggest()):c.isBadQuery(a)||(e.onSearchStart.call(c.element,a),e.params[e.paramName]=a,d.ajax({url:e.serviceUrl,data:e.params,type:e.type,dataType:"text"}).done(function(b){c.processResponse(b);e.onSearchComplete.call(c.element,a)}))},isBadQuery:function(a){for(var b=this.badQueries,c=b.length;c--;)if(0===a.indexOf(b[c]))return!0;return!1},hide:function(){this.visible=!1;this.selectedIndex=-1;d(this.suggestionsContainer).hide()},
suggest:function(){if(0===this.suggestions.length)this.hide();else{var a=this.options.formatResult,b=this.getQuery(this.currentValue),c=this.classes.suggestion,e=this.classes.selected,g=d(this.suggestionsContainer),f="";d.each(this.suggestions,function(d,e){f+='<div class="'+c+'" data-index="'+d+'">'+a(e,b)+"</div>"});g.html(f).show();this.visible=!0;this.options.autoSelectFirst&&(this.selectedIndex=0,g.children().first().addClass(e))}},verifySuggestionsFormat:function(a){return a.length&&"string"===
typeof a[0]?d.map(a,function(a){return{value:a,data:null}}):a},processResponse:function(a){a=d.parseJSON(a);a.suggestions=this.verifySuggestionsFormat(this.options.transformResult(a));this.options.noCache||(this.cachedResponse[a[this.options.paramName]]=a,0===a.suggestions.length&&this.badQueries.push(a[this.options.paramName]));a[this.options.paramName]===this.getQuery(this.currentValue)&&(this.suggestions=a.suggestions,this.suggest())},activate:function(a){var b=this.classes.selected,c=d(this.suggestionsContainer),
e=c.children();c.children("."+b).removeClass(b);this.selectedIndex=a;return-1!==this.selectedIndex&&e.length>this.selectedIndex?(a=e.get(this.selectedIndex),d(a).addClass(b),a):null},select:function(a){var b=this.suggestions[a];b&&(this.el.val(b),this.ignoreValueChange=!0,this.hide(),this.onSelect(a))},moveUp:function(){-1!==this.selectedIndex&&(0===this.selectedIndex?(d(this.suggestionsContainer).children().first().removeClass(this.classes.selected),this.selectedIndex=-1,this.el.val(this.currentValue)):
this.adjustScroll(this.selectedIndex-1))},moveDown:function(){this.selectedIndex!==this.suggestions.length-1&&this.adjustScroll(this.selectedIndex+1)},adjustScroll:function(a){var b=this.activate(a),c,e;b&&(b=b.offsetTop,c=d(this.suggestionsContainer).scrollTop(),e=c+this.options.maxHeight-25,b<c?d(this.suggestionsContainer).scrollTop(b):b>e&&d(this.suggestionsContainer).scrollTop(b-this.options.maxHeight+25),this.el.val(this.getValue(this.suggestions[a].value)))},onSelect:function(a){var b=this.options.onSelect;
a=this.suggestions[a];this.el.val(this.getValue(a.value));d.isFunction(b)&&b.call(this.element,a)},getValue:function(a){var b=this.options.delimiter,c;if(!b)return a;c=this.currentValue;b=c.split(b);return 1===b.length?a:c.substr(0,c.length-b[b.length-1].length)+a}};d.fn.autocomplete=function(a,b){return this.each(function(){var c=d(this),e;if("string"===typeof a){if(e=c.data("autocomplete"),"function"===typeof e[a])e[a](b)}else e=new f(this,a),c.data("autocomplete",e)})}});
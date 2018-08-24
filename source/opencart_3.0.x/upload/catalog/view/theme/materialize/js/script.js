!function(t,e){"object"==typeof exports&&"object"==typeof module?module.exports=e():"function"==typeof define&&define.amd?define([],e):"object"==typeof exports?exports.SimpleBar=e():t.SimpleBar=e()}(this,function(){return function(t){function e(r){if(n[r])return n[r].exports;var i=n[r]={i:r,l:!1,exports:{}};return t[r].call(i.exports,i,i.exports,e),i.l=!0,i.exports}var n={};return e.m=t,e.c=n,e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=27)}([function(t,e,n){var r=n(23)("wks"),i=n(12),o=n(1).Symbol,s="function"==typeof o;(t.exports=function(t){return r[t]||(r[t]=s&&o[t]||(s?o:i)("Symbol."+t))}).store=r},function(t,e){var n=t.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=n)},function(t,e){var n={}.hasOwnProperty;t.exports=function(t,e){return n.call(t,e)}},function(t,e){var n=t.exports={version:"2.5.1"};"number"==typeof __e&&(__e=n)},function(t,e,n){var r=n(5),i=n(11);t.exports=n(7)?function(t,e,n){return r.f(t,e,i(1,n))}:function(t,e,n){return t[e]=n,t}},function(t,e,n){var r=n(6),i=n(33),o=n(34),s=Object.defineProperty;e.f=n(7)?Object.defineProperty:function(t,e,n){if(r(t),e=o(e,!0),r(n),i)try{return s(t,e,n)}catch(t){}if("get"in n||"set"in n)throw TypeError("Accessors not supported!");return"value"in n&&(t[e]=n.value),t}},function(t,e,n){var r=n(10);t.exports=function(t){if(!r(t))throw TypeError(t+" is not an object!");return t}},function(t,e,n){t.exports=!n(16)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},function(t,e){var n=Math.ceil,r=Math.floor;t.exports=function(t){return isNaN(t=+t)?0:(t>0?r:n)(t)}},function(t,e){t.exports=function(t){if(void 0==t)throw TypeError("Can't call method on  "+t);return t}},function(t,e){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},function(t,e){t.exports=function(t,e){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:e}}},function(t,e){var n=0,r=Math.random();t.exports=function(t){return"Symbol(".concat(void 0===t?"":t,")_",(++n+r).toString(36))}},function(t,e){t.exports={}},function(t,e,n){var r=n(23)("keys"),i=n(12);t.exports=function(t){return r[t]||(r[t]=i(t))}},function(t,e,n){var r=n(1),i=n(3),o=n(4),s=n(18),c=n(19),a=function(t,e,n){var l,u,h,f,d=t&a.F,p=t&a.G,v=t&a.S,b=t&a.P,y=t&a.B,m=p?r:v?r[e]||(r[e]={}):(r[e]||{}).prototype,g=p?i:i[e]||(i[e]={}),E=g.prototype||(g.prototype={});p&&(n=e);for(l in n)u=!d&&m&&void 0!==m[l],h=(u?m:n)[l],f=y&&u?c(h,r):b&&"function"==typeof h?c(Function.call,h):h,m&&s(m,l,h,t&a.U),g[l]!=h&&o(g,l,f),b&&E[l]!=h&&(E[l]=h)};r.core=i,a.F=1,a.G=2,a.S=4,a.P=8,a.B=16,a.W=32,a.U=64,a.R=128,t.exports=a},function(t,e){t.exports=function(t){try{return!!t()}catch(t){return!0}}},function(t,e,n){var r=n(10),i=n(1).document,o=r(i)&&r(i.createElement);t.exports=function(t){return o?i.createElement(t):{}}},function(t,e,n){var r=n(1),i=n(4),o=n(2),s=n(12)("src"),c=Function.toString,a=(""+c).split("toString");n(3).inspectSource=function(t){return c.call(t)},(t.exports=function(t,e,n,c){var l="function"==typeof n;l&&(o(n,"name")||i(n,"name",e)),t[e]!==n&&(l&&(o(n,s)||i(n,s,t[e]?""+t[e]:a.join(String(e)))),t===r?t[e]=n:c?t[e]?t[e]=n:i(t,e,n):(delete t[e],i(t,e,n)))})(Function.prototype,"toString",function(){return"function"==typeof this&&this[s]||c.call(this)})},function(t,e,n){var r=n(35);t.exports=function(t,e,n){if(r(t),void 0===e)return t;switch(n){case 1:return function(n){return t.call(e,n)};case 2:return function(n,r){return t.call(e,n,r)};case 3:return function(n,r,i){return t.call(e,n,r,i)}}return function(){return t.apply(e,arguments)}}},function(t,e,n){var r=n(41),i=n(9);t.exports=function(t){return r(i(t))}},function(t,e){var n={}.toString;t.exports=function(t){return n.call(t).slice(8,-1)}},function(t,e,n){var r=n(8),i=Math.min;t.exports=function(t){return t>0?i(r(t),9007199254740991):0}},function(t,e,n){var r=n(1),i=r["__core-js_shared__"]||(r["__core-js_shared__"]={});t.exports=function(t){return i[t]||(i[t]={})}},function(t,e){t.exports="constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf".split(",")},function(t,e,n){var r=n(5).f,i=n(2),o=n(0)("toStringTag");t.exports=function(t,e,n){t&&!i(t=n?t:t.prototype,o)&&r(t,o,{configurable:!0,value:e})}},function(t,e,n){var r=n(9);t.exports=function(t){return Object(r(t))}},function(t,e,n){"use strict";function r(t){return t&&t.__esModule?t:{default:t}}function i(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,n(28);var o=r(n(53)),s=r(n(54)),c=r(n(56));n(57),Object.assign=n(58);var a=function(){function t(e,n){(function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")})(this,t),this.el=e,this.flashTimeout,this.contentEl,this.scrollContentEl,this.dragOffset={x:0,y:0},this.isVisible={x:!0,y:!0},this.scrollOffsetAttr={x:"scrollLeft",y:"scrollTop"},this.sizeAttr={x:"offsetWidth",y:"offsetHeight"},this.scrollSizeAttr={x:"scrollWidth",y:"scrollHeight"},this.offsetAttr={x:"left",y:"top"},this.globalObserver,this.mutationObserver,this.resizeObserver,this.currentAxis,this.isRtl,this.options=Object.assign({},t.defaultOptions,n),this.classNames=this.options.classNames,this.scrollbarWidth=(0,o.default)(),this.offsetSize=20,this.flashScrollbar=this.flashScrollbar.bind(this),this.onDragY=this.onDragY.bind(this),this.onDragX=this.onDragX.bind(this),this.onScrollY=this.onScrollY.bind(this),this.onScrollX=this.onScrollX.bind(this),this.drag=this.drag.bind(this),this.onEndDrag=this.onEndDrag.bind(this),this.onMouseEnter=this.onMouseEnter.bind(this),this.recalculate=(0,s.default)(this.recalculate,100,{leading:!0}),this.init()}return e=t,r=[{key:"initHtmlApi",value:function(){this.initDOMLoadedElements=this.initDOMLoadedElements.bind(this),"undefined"!=typeof MutationObserver&&(this.globalObserver=new MutationObserver(function(e){e.forEach(function(e){Array.from(e.addedNodes).forEach(function(e){1===e.nodeType&&(e.hasAttribute("data-simplebar")?!e.SimpleBar&&new t(e,t.getElOptions(e)):Array.from(e.querySelectorAll("[data-simplebar]")).forEach(function(e){!e.SimpleBar&&new t(e,t.getElOptions(e))}))}),Array.from(e.removedNodes).forEach(function(t){1===t.nodeType&&(t.hasAttribute("data-simplebar")?t.SimpleBar&&t.SimpleBar.unMount():Array.from(t.querySelectorAll("[data-simplebar]")).forEach(function(t){t.SimpleBar&&t.SimpleBar.unMount()}))})})}),this.globalObserver.observe(document,{childList:!0,subtree:!0})),"complete"===document.readyState||"loading"!==document.readyState&&!document.documentElement.doScroll?window.setTimeout(this.initDOMLoadedElements.bind(this)):(document.addEventListener("DOMContentLoaded",this.initDOMLoadedElements),window.addEventListener("load",this.initDOMLoadedElements))}},{key:"getElOptions",value:function(e){return Object.keys(t.htmlAttributes).reduce(function(n,r){var i=t.htmlAttributes[r];return e.hasAttribute(i)&&(n[r]=JSON.parse(e.getAttribute(i)||!0)),n},{})}},{key:"removeObserver",value:function(){this.globalObserver.disconnect()}},{key:"initDOMLoadedElements",value:function(){document.removeEventListener("DOMContentLoaded",this.initDOMLoadedElements),window.removeEventListener("load",this.initDOMLoadedElements),Array.from(document.querySelectorAll("[data-simplebar]")).forEach(function(e){e.SimpleBar||new t(e,t.getElOptions(e))})}},{key:"defaultOptions",get:function(){return{autoHide:!0,forceVisible:!1,classNames:{content:"simplebar-content",scrollContent:"simplebar-scroll-content",scrollbar:"simplebar-scrollbar",track:"simplebar-track"},scrollbarMinSize:25}}},{key:"htmlAttributes",get:function(){return{autoHide:"data-simplebar-auto-hide",forceVisible:"data-simplebar-force-visible",scrollbarMinSize:"data-simplebar-scrollbar-min-size"}}}],(n=[{key:"init",value:function(){this.el.SimpleBar=this,this.initDOM(),this.scrollbarX=this.trackX.querySelector(".".concat(this.classNames.scrollbar)),this.scrollbarY=this.trackY.querySelector(".".concat(this.classNames.scrollbar)),this.isRtl="rtl"===getComputedStyle(this.contentEl).direction,this.scrollContentEl.style[this.isRtl?"paddingLeft":"paddingRight"]="".concat(this.scrollbarWidth||this.offsetSize,"px"),this.scrollContentEl.style.marginBottom="-".concat(2*this.scrollbarWidth||this.offsetSize,"px"),this.contentEl.style.paddingBottom="".concat(this.scrollbarWidth||this.offsetSize,"px"),0!==this.scrollbarWidth&&(this.contentEl.style[this.isRtl?"marginLeft":"marginRight"]="-".concat(this.scrollbarWidth,"px")),this.recalculate(),this.initListeners()}},{key:"initDOM",value:function(){var t=this;if(Array.from(this.el.children).filter(function(e){return e.classList.contains(t.classNames.scrollContent)}).length)this.trackX=this.el.querySelector(".".concat(this.classNames.track,".horizontal")),this.trackY=this.el.querySelector(".".concat(this.classNames.track,".vertical")),this.scrollContentEl=this.el.querySelector(".".concat(this.classNames.scrollContent)),this.contentEl=this.el.querySelector(".".concat(this.classNames.content));else{for(this.scrollContentEl=document.createElement("div"),this.contentEl=document.createElement("div"),this.scrollContentEl.classList.add(this.classNames.scrollContent),this.contentEl.classList.add(this.classNames.content);this.el.firstChild;)this.contentEl.appendChild(this.el.firstChild);this.scrollContentEl.appendChild(this.contentEl),this.el.appendChild(this.scrollContentEl)}if(!this.trackX||!this.trackY){var e=document.createElement("div"),n=document.createElement("div");e.classList.add(this.classNames.track),n.classList.add(this.classNames.scrollbar),e.appendChild(n),this.trackX=e.cloneNode(!0),this.trackX.classList.add("horizontal"),this.trackY=e.cloneNode(!0),this.trackY.classList.add("vertical"),this.el.insertBefore(this.trackX,this.el.firstChild),this.el.insertBefore(this.trackY,this.el.firstChild)}this.el.setAttribute("data-simplebar","init")}},{key:"initListeners",value:function(){var t=this;this.options.autoHide&&this.el.addEventListener("mouseenter",this.onMouseEnter),this.scrollbarY.addEventListener("mousedown",this.onDragY),this.scrollbarX.addEventListener("mousedown",this.onDragX),this.scrollContentEl.addEventListener("scroll",this.onScrollY),this.contentEl.addEventListener("scroll",this.onScrollX),"undefined"!=typeof MutationObserver&&(this.mutationObserver=new MutationObserver(function(e){e.forEach(function(e){(t.isChildNode(e.target)||e.addedNodes.length)&&t.recalculate()})}),this.mutationObserver.observe(this.el,{attributes:!0,childList:!0,characterData:!0,subtree:!0})),this.resizeObserver=new c.default(this.recalculate.bind(this)),this.resizeObserver.observe(this.el)}},{key:"removeListeners",value:function(){this.options.autoHide&&this.el.removeEventListener("mouseenter",this.onMouseEnter),this.scrollbarX.removeEventListener("mousedown",this.onDragX),this.scrollbarY.removeEventListener("mousedown",this.onDragY),this.scrollContentEl.removeEventListener("scroll",this.onScrollY),this.contentEl.removeEventListener("scroll",this.onScrollX),this.mutationObserver.disconnect(),this.resizeObserver.disconnect()}},{key:"onDragX",value:function(t){this.onDrag(t,"x")}},{key:"onDragY",value:function(t){this.onDrag(t,"y")}},{key:"onDrag",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"y";t.preventDefault();var n="y"===e?this.scrollbarY:this.scrollbarX,r="y"===e?t.pageY:t.pageX;this.dragOffset[e]=r-n.getBoundingClientRect()[this.offsetAttr[e]],this.currentAxis=e,document.addEventListener("mousemove",this.drag),document.addEventListener("mouseup",this.onEndDrag)}},{key:"drag",value:function(t){var e,n,r;t.preventDefault(),"y"===this.currentAxis?(e=t.pageY,n=this.trackY,r=this.scrollContentEl):(e=t.pageX,n=this.trackX,r=this.contentEl);var i=(e-n.getBoundingClientRect()[this.offsetAttr[this.currentAxis]]-this.dragOffset[this.currentAxis])/n[this.sizeAttr[this.currentAxis]]*this.contentEl[this.scrollSizeAttr[this.currentAxis]];r[this.scrollOffsetAttr[this.currentAxis]]=i}},{key:"onEndDrag",value:function(){document.removeEventListener("mousemove",this.drag),document.removeEventListener("mouseup",this.onEndDrag)}},{key:"resizeScrollbar",value:function(){var t,e,n,r,i,o=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"y";"x"===o?(t=this.trackX,e=this.scrollbarX,n=this.contentEl[this.scrollOffsetAttr[o]],r=this.contentSizeX,i=this.scrollbarXSize):(t=this.trackY,e=this.scrollbarY,n=this.scrollContentEl[this.scrollOffsetAttr[o]],r=this.contentSizeY,i=this.scrollbarYSize);var s=i/r,c=n/(r-i),a=Math.max(~~(s*i),this.options.scrollbarMinSize),l=~~((i-a)*c);this.isVisible[o]=i<r,this.isVisible[o]||this.options.forceVisible?(t.style.visibility="visible",this.options.forceVisible?e.style.visibility="hidden":e.style.visibility="visible","x"===o?(e.style.left="".concat(l,"px"),e.style.width="".concat(a,"px")):(e.style.top="".concat(l,"px"),e.style.height="".concat(a,"px"))):t.style.visibility="hidden"}},{key:"onScrollX",value:function(){this.flashScrollbar("x")}},{key:"onScrollY",value:function(){this.flashScrollbar("y")}},{key:"onMouseEnter",value:function(){this.flashScrollbar("x"),this.flashScrollbar("y")}},{key:"flashScrollbar",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"y";this.resizeScrollbar(t),this.showScrollbar(t)}},{key:"showScrollbar",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"y";this.isVisible[t]&&("x"===t?this.scrollbarX.classList.add("visible"):this.scrollbarY.classList.add("visible"),this.options.autoHide&&("number"==typeof this.flashTimeout&&window.clearTimeout(this.flashTimeout),this.flashTimeout=window.setTimeout(this.hideScrollbar.bind(this),1e3)))}},{key:"hideScrollbar",value:function(){this.scrollbarX.classList.remove("visible"),this.scrollbarY.classList.remove("visible"),"number"==typeof this.flashTimeout&&window.clearTimeout(this.flashTimeout)}},{key:"recalculate",value:function(){this.contentSizeX=this.contentEl[this.scrollSizeAttr.x],this.contentSizeY=this.contentEl[this.scrollSizeAttr.y]-(this.scrollbarWidth||this.offsetSize),this.scrollbarXSize=this.trackX[this.sizeAttr.x],this.scrollbarYSize=this.trackY[this.sizeAttr.y],this.resizeScrollbar("x"),this.resizeScrollbar("y"),this.options.autoHide||(this.showScrollbar("x"),this.showScrollbar("y"))}},{key:"getScrollElement",value:function(){return"y"===(arguments.length>0&&void 0!==arguments[0]?arguments[0]:"y")?this.scrollContentEl:this.contentEl}},{key:"getContentElement",value:function(){return this.contentEl}},{key:"unMount",value:function(){this.removeListeners(),this.el.SimpleBar=null}},{key:"isChildNode",value:function(t){return null!==t&&(t===this.el||this.isChildNode(t.parentNode))}}])&&i(e.prototype,n),r&&i(e,r),t;var e,n,r}();e.default=a,a.initHtmlApi()},function(t,e,n){n(29),n(46),t.exports=n(3).Array.from},function(t,e,n){"use strict";var r=n(30)(!0);n(31)(String,"String",function(t){this._t=String(t),this._i=0},function(){var t,e=this._t,n=this._i;return n>=e.length?{value:void 0,done:!0}:(t=r(e,n),this._i+=t.length,{value:t,done:!1})})},function(t,e,n){var r=n(8),i=n(9);t.exports=function(t){return function(e,n){var o,s,c=String(i(e)),a=r(n),l=c.length;return a<0||a>=l?t?"":void 0:(o=c.charCodeAt(a))<55296||o>56319||a+1===l||(s=c.charCodeAt(a+1))<56320||s>57343?t?c.charAt(a):o:t?c.slice(a,a+2):s-56320+(o-55296<<10)+65536}}},function(t,e,n){"use strict";var r=n(32),i=n(15),o=n(18),s=n(4),c=n(2),a=n(13),l=n(36),u=n(25),h=n(45),f=n(0)("iterator"),d=!([].keys&&"next"in[].keys()),p=function(){return this};t.exports=function(t,e,n,v,b,y,m){l(n,e,v);var g,E,O,_=function(t){if(!d&&t in A)return A[t];switch(t){case"keys":case"values":return function(){return new n(this,t)}}return function(){return new n(this,t)}},x=e+" Iterator",w="values"==b,S=!1,A=t.prototype,k=A[f]||A["@@iterator"]||b&&A[b],j=k||_(b),M=b?w?_("entries"):j:void 0,L="Array"==e&&A.entries||k;if(L&&(O=h(L.call(new t)))!==Object.prototype&&O.next&&(u(O,x,!0),r||c(O,f)||s(O,f,p)),w&&k&&"values"!==k.name&&(S=!0,j=function(){return k.call(this)}),r&&!m||!d&&!S&&A[f]||s(A,f,j),a[e]=j,a[x]=p,b)if(g={values:w?j:_("values"),keys:y?j:_("keys"),entries:M},m)for(E in g)E in A||o(A,E,g[E]);else i(i.P+i.F*(d||S),e,g);return g}},function(t,e){t.exports=!1},function(t,e,n){t.exports=!n(7)&&!n(16)(function(){return 7!=Object.defineProperty(n(17)("div"),"a",{get:function(){return 7}}).a})},function(t,e,n){var r=n(10);t.exports=function(t,e){if(!r(t))return t;var n,i;if(e&&"function"==typeof(n=t.toString)&&!r(i=n.call(t)))return i;if("function"==typeof(n=t.valueOf)&&!r(i=n.call(t)))return i;if(!e&&"function"==typeof(n=t.toString)&&!r(i=n.call(t)))return i;throw TypeError("Can't convert object to primitive value")}},function(t,e){t.exports=function(t){if("function"!=typeof t)throw TypeError(t+" is not a function!");return t}},function(t,e,n){"use strict";var r=n(37),i=n(11),o=n(25),s={};n(4)(s,n(0)("iterator"),function(){return this}),t.exports=function(t,e,n){t.prototype=r(s,{next:i(1,n)}),o(t,e+" Iterator")}},function(t,e,n){var r=n(6),i=n(38),o=n(24),s=n(14)("IE_PROTO"),c=function(){},a=function(){var t,e=n(17)("iframe"),r=o.length;for(e.style.display="none",n(44).appendChild(e),e.src="javascript:",(t=e.contentWindow.document).open(),t.write("<script>document.F=Object<\/script>"),t.close(),a=t.F;r--;)delete a.prototype[o[r]];return a()};t.exports=Object.create||function(t,e){var n;return null!==t?(c.prototype=r(t),n=new c,c.prototype=null,n[s]=t):n=a(),void 0===e?n:i(n,e)}},function(t,e,n){var r=n(5),i=n(6),o=n(39);t.exports=n(7)?Object.defineProperties:function(t,e){i(t);for(var n,s=o(e),c=s.length,a=0;c>a;)r.f(t,n=s[a++],e[n]);return t}},function(t,e,n){var r=n(40),i=n(24);t.exports=Object.keys||function(t){return r(t,i)}},function(t,e,n){var r=n(2),i=n(20),o=n(42)(!1),s=n(14)("IE_PROTO");t.exports=function(t,e){var n,c=i(t),a=0,l=[];for(n in c)n!=s&&r(c,n)&&l.push(n);for(;e.length>a;)r(c,n=e[a++])&&(~o(l,n)||l.push(n));return l}},function(t,e,n){var r=n(21);t.exports=Object("z").propertyIsEnumerable(0)?Object:function(t){return"String"==r(t)?t.split(""):Object(t)}},function(t,e,n){var r=n(20),i=n(22),o=n(43);t.exports=function(t){return function(e,n,s){var c,a=r(e),l=i(a.length),u=o(s,l);if(t&&n!=n){for(;l>u;)if((c=a[u++])!=c)return!0}else for(;l>u;u++)if((t||u in a)&&a[u]===n)return t||u||0;return!t&&-1}}},function(t,e,n){var r=n(8),i=Math.max,o=Math.min;t.exports=function(t,e){return(t=r(t))<0?i(t+e,0):o(t,e)}},function(t,e,n){var r=n(1).document;t.exports=r&&r.documentElement},function(t,e,n){var r=n(2),i=n(26),o=n(14)("IE_PROTO"),s=Object.prototype;t.exports=Object.getPrototypeOf||function(t){return t=i(t),r(t,o)?t[o]:"function"==typeof t.constructor&&t instanceof t.constructor?t.constructor.prototype:t instanceof Object?s:null}},function(t,e,n){"use strict";var r=n(19),i=n(15),o=n(26),s=n(47),c=n(48),a=n(22),l=n(49),u=n(50);i(i.S+i.F*!n(52)(function(t){Array.from(t)}),"Array",{from:function(t){var e,n,i,h,f=o(t),d="function"==typeof this?this:Array,p=arguments.length,v=p>1?arguments[1]:void 0,b=void 0!==v,y=0,m=u(f);if(b&&(v=r(v,p>2?arguments[2]:void 0,2)),void 0==m||d==Array&&c(m))for(e=a(f.length),n=new d(e);e>y;y++)l(n,y,b?v(f[y],y):f[y]);else for(h=m.call(f),n=new d;!(i=h.next()).done;y++)l(n,y,b?s(h,v,[i.value,y],!0):i.value);return n.length=y,n}})},function(t,e,n){var r=n(6);t.exports=function(t,e,n,i){try{return i?e(r(n)[0],n[1]):e(n)}catch(e){var o=t.return;throw void 0!==o&&r(o.call(t)),e}}},function(t,e,n){var r=n(13),i=n(0)("iterator"),o=Array.prototype;t.exports=function(t){return void 0!==t&&(r.Array===t||o[i]===t)}},function(t,e,n){"use strict";var r=n(5),i=n(11);t.exports=function(t,e,n){e in t?r.f(t,e,i(0,n)):t[e]=n}},function(t,e,n){var r=n(51),i=n(0)("iterator"),o=n(13);t.exports=n(3).getIteratorMethod=function(t){if(void 0!=t)return t[i]||t["@@iterator"]||o[r(t)]}},function(t,e,n){var r=n(21),i=n(0)("toStringTag"),o="Arguments"==r(function(){return arguments}());t.exports=function(t){var e,n,s;return void 0===t?"Undefined":null===t?"Null":"string"==typeof(n=function(t,e){try{return t[e]}catch(t){}}(e=Object(t),i))?n:o?r(e):"Object"==(s=r(e))&&"function"==typeof e.callee?"Arguments":s}},function(t,e,n){var r=n(0)("iterator"),i=!1;try{var o=[7][r]();o.return=function(){i=!0},Array.from(o,function(){throw 2})}catch(t){}t.exports=function(t,e){if(!e&&!i)return!1;var n=!1;try{var o=[7],s=o[r]();s.next=function(){return{done:n=!0}},o[r]=function(){return s},t(o)}catch(t){}return n}},function(t,e,n){var r,i,o;i=[],void 0!==(o="function"==typeof(r=function(){"use strict";return function(){if("undefined"==typeof document)return 0;var t,e=document.body,n=document.createElement("div"),r=n.style;return r.position="absolute",r.top=r.left="-9999px",r.width=r.height="100px",r.overflow="scroll",e.appendChild(n),t=n.offsetWidth-n.clientWidth,e.removeChild(n),t}})?r.apply(e,i):r)&&(t.exports=o)},function(t,e,n){(function(e){function n(t){var e=typeof t;return!!t&&("object"==e||"function"==e)}function r(t){if("number"==typeof t)return t;if("symbol"==typeof(e=t)||(r=e)&&"object"==typeof r&&v.call(e)==s)return o;var e,r;if(n(t)){var i="function"==typeof t.valueOf?t.valueOf():t;t=n(i)?i+"":i}if("string"!=typeof t)return 0===t?t:+t;t=t.replace(c,"");var f=l.test(t);return f||u.test(t)?h(t.slice(2),f?2:8):a.test(t)?o:+t}var i="Expected a function",o=NaN,s="[object Symbol]",c=/^\s+|\s+$/g,a=/^[-+]0x[0-9a-f]+$/i,l=/^0b[01]+$/i,u=/^0o[0-7]+$/i,h=parseInt,f="object"==typeof e&&e&&e.Object===Object&&e,d="object"==typeof self&&self&&self.Object===Object&&self,p=f||d||Function("return this")(),v=Object.prototype.toString,b=Math.max,y=Math.min,m=function(){return p.Date.now()};t.exports=function(t,e,o){function s(e){var n=h,r=f;return h=f=void 0,E=e,p=t.apply(r,n)}function c(t){var n=t-g;return void 0===g||n>=e||n<0||_&&t-E>=d}function a(){var t,n,r=m();if(c(r))return l(r);v=setTimeout(a,(n=e-((t=r)-g),_?y(n,d-(t-E)):n))}function l(t){return v=void 0,x&&h?s(t):(h=f=void 0,p)}function u(){var t,n=m(),r=c(n);if(h=arguments,f=this,g=n,r){if(void 0===v)return t=g,E=t,v=setTimeout(a,e),O?s(t):p;if(_)return v=setTimeout(a,e),s(g)}return void 0===v&&(v=setTimeout(a,e)),p}var h,f,d,p,v,g,E=0,O=!1,_=!1,x=!0;if("function"!=typeof t)throw new TypeError(i);return e=r(e)||0,n(o)&&(O=!!o.leading,d=(_="maxWait"in o)?b(r(o.maxWait)||0,e):d,x="trailing"in o?!!o.trailing:x),u.cancel=function(){void 0!==v&&clearTimeout(v),E=0,h=g=f=v=void 0},u.flush=function(){return void 0===v?p:l(m())},u}}).call(e,n(55))},function(t,e){var n;n=function(){return this}();try{n=n||Function("return this")()||(0,eval)("this")}catch(t){"object"==typeof window&&(n=window)}t.exports=n},function(t,e,n){"use strict";function r(t){return parseFloat(t)||0}function i(t){return Array.prototype.slice.call(arguments,1).reduce(function(e,n){return e+r(t["border-"+n+"-width"])},0)}function o(t){var e=t.clientWidth,n=t.clientHeight;if(!e&&!n)return y;var o=getComputedStyle(t),s=function(t){for(var e={},n=0,i=["top","right","bottom","left"];n<i.length;n+=1){var o=i[n],s=t["padding-"+o];e[o]=r(s)}return e}(o),a=s.left+s.right,l=s.top+s.bottom,u=r(o.width),h=r(o.height);if("border-box"===o.boxSizing&&(Math.round(u+a)!==e&&(u-=i(o,"left","right")+a),Math.round(h+l)!==n&&(h-=i(o,"top","bottom")+l)),t!==document.documentElement){var f=Math.round(u+a)-e,d=Math.round(h+l)-n;1!==Math.abs(f)&&(u-=f),1!==Math.abs(d)&&(h-=d)}return c(s.left,s.top,u,h)}function s(t){return l?m(t)?c(0,0,(e=t.getBBox()).width,e.height):o(t):y;var e}function c(t,e,n,r){return{x:t,y:e,width:n,height:r}}Object.defineProperty(e,"__esModule",{value:!0});var a=function(){function t(t,e){var n=-1;return t.some(function(t,r){return t[0]===e&&(n=r,!0)}),n}return"undefined"!=typeof Map?Map:function(){function e(){this.__entries__=[]}var n={size:{}};return n.size.get=function(){return this.__entries__.length},e.prototype.get=function(e){var n=t(this.__entries__,e),r=this.__entries__[n];return r&&r[1]},e.prototype.set=function(e,n){var r=t(this.__entries__,e);~r?this.__entries__[r][1]=n:this.__entries__.push([e,n])},e.prototype.delete=function(e){var n=this.__entries__,r=t(n,e);~r&&n.splice(r,1)},e.prototype.has=function(e){return!!~t(this.__entries__,e)},e.prototype.clear=function(){this.__entries__.splice(0)},e.prototype.forEach=function(t,e){void 0===e&&(e=null);for(var n=0,r=this.__entries__;n<r.length;n+=1){var i=r[n];t.call(e,i[1],i[0])}},Object.defineProperties(e.prototype,n),e}()}(),l="undefined"!=typeof window&&"undefined"!=typeof document&&window.document===document,u="function"==typeof requestAnimationFrame?requestAnimationFrame:function(t){return setTimeout(function(){return t(Date.now())},1e3/60)},h=2,f=["top","right","bottom","left","width","height","size","weight"],d="undefined"!=typeof navigator&&/Trident\/.*rv:11/.test(navigator.userAgent),p="undefined"!=typeof MutationObserver&&!d,v=function(){this.connected_=!1,this.mutationEventsAdded_=!1,this.mutationsObserver_=null,this.observers_=[],this.onTransitionEnd_=this.onTransitionEnd_.bind(this),this.refresh=function(t,e){function n(){o&&(o=!1,t()),s&&i()}function r(){u(n)}function i(){var t=Date.now();if(o){if(t-c<h)return;s=!0}else o=!0,s=!1,setTimeout(r,e);c=t}var o=!1,s=!1,c=0;return i}(this.refresh.bind(this),20)};v.prototype.addObserver=function(t){~this.observers_.indexOf(t)||this.observers_.push(t),this.connected_||this.connect_()},v.prototype.removeObserver=function(t){var e=this.observers_,n=e.indexOf(t);~n&&e.splice(n,1),!e.length&&this.connected_&&this.disconnect_()},v.prototype.refresh=function(){this.updateObservers_()&&this.refresh()},v.prototype.updateObservers_=function(){var t=this.observers_.filter(function(t){return t.gatherActive(),t.hasActive()});return t.forEach(function(t){return t.broadcastActive()}),t.length>0},v.prototype.connect_=function(){l&&!this.connected_&&(document.addEventListener("transitionend",this.onTransitionEnd_),window.addEventListener("resize",this.refresh),p?(this.mutationsObserver_=new MutationObserver(this.refresh),this.mutationsObserver_.observe(document,{attributes:!0,childList:!0,characterData:!0,subtree:!0})):(document.addEventListener("DOMSubtreeModified",this.refresh),this.mutationEventsAdded_=!0),this.connected_=!0)},v.prototype.disconnect_=function(){l&&this.connected_&&(document.removeEventListener("transitionend",this.onTransitionEnd_),window.removeEventListener("resize",this.refresh),this.mutationsObserver_&&this.mutationsObserver_.disconnect(),this.mutationEventsAdded_&&document.removeEventListener("DOMSubtreeModified",this.refresh),this.mutationsObserver_=null,this.mutationEventsAdded_=!1,this.connected_=!1)},v.prototype.onTransitionEnd_=function(t){var e=t.propertyName;f.some(function(t){return!!~e.indexOf(t)})&&this.refresh()},v.getInstance=function(){return this.instance_||(this.instance_=new v),this.instance_},v.instance_=null;var b=function(t,e){for(var n=0,r=Object.keys(e);n<r.length;n+=1){var i=r[n];Object.defineProperty(t,i,{value:e[i],enumerable:!1,writable:!1,configurable:!0})}return t},y=c(0,0,0,0),m="undefined"!=typeof SVGGraphicsElement?function(t){return t instanceof SVGGraphicsElement}:function(t){return t instanceof SVGElement&&"function"==typeof t.getBBox},g=function(t){this.broadcastWidth=0,this.broadcastHeight=0,this.contentRect_=c(0,0,0,0),this.target=t};g.prototype.isActive=function(){var t=s(this.target);return this.contentRect_=t,t.width!==this.broadcastWidth||t.height!==this.broadcastHeight},g.prototype.broadcastRect=function(){var t=this.contentRect_;return this.broadcastWidth=t.width,this.broadcastHeight=t.height,t};var E=function(t,e){var n,r,i,o,s,c,a,l=(r=(n=e).x,i=n.y,o=n.width,s=n.height,c="undefined"!=typeof DOMRectReadOnly?DOMRectReadOnly:Object,a=Object.create(c.prototype),b(a,{x:r,y:i,width:o,height:s,top:i,right:r+o,bottom:s+i,left:r}),a);b(this,{target:t,contentRect:l})},O=function(t,e,n){if("function"!=typeof t)throw new TypeError("The callback provided as parameter 1 is not a function.");this.activeObservations_=[],this.observations_=new a,this.callback_=t,this.controller_=e,this.callbackCtx_=n};O.prototype.observe=function(t){if(!arguments.length)throw new TypeError("1 argument required, but only 0 present.");if("undefined"!=typeof Element&&Element instanceof Object){if(!(t instanceof Element))throw new TypeError('parameter 1 is not of type "Element".');var e=this.observations_;e.has(t)||(e.set(t,new g(t)),this.controller_.addObserver(this),this.controller_.refresh())}},O.prototype.unobserve=function(t){if(!arguments.length)throw new TypeError("1 argument required, but only 0 present.");if("undefined"!=typeof Element&&Element instanceof Object){if(!(t instanceof Element))throw new TypeError('parameter 1 is not of type "Element".');var e=this.observations_;e.has(t)&&(e.delete(t),e.size||this.controller_.removeObserver(this))}},O.prototype.disconnect=function(){this.clearActive(),this.observations_.clear(),this.controller_.removeObserver(this)},O.prototype.gatherActive=function(){var t=this;this.clearActive(),this.observations_.forEach(function(e){e.isActive()&&t.activeObservations_.push(e)})},O.prototype.broadcastActive=function(){if(this.hasActive()){var t=this.callbackCtx_,e=this.activeObservations_.map(function(t){return new E(t.target,t.broadcastRect())});this.callback_.call(t,e,t),this.clearActive()}},O.prototype.clearActive=function(){this.activeObservations_.splice(0)},O.prototype.hasActive=function(){return this.activeObservations_.length>0};var _="undefined"!=typeof WeakMap?new WeakMap:new a,x=function(t){if(!(this instanceof x))throw new TypeError("Cannot call a class as a function");if(!arguments.length)throw new TypeError("1 argument required, but only 0 present.");var e=v.getInstance(),n=new O(t,e,this);_.set(this,n)};["observe","unobserve","disconnect"].forEach(function(t){x.prototype[t]=function(){return(e=_.get(this))[t].apply(e,arguments);var e}});var w="undefined"!=typeof ResizeObserver?ResizeObserver:x;e.default=w},function(t,e){},function(t,e,n){"use strict";var r=Object.getOwnPropertySymbols,i=Object.prototype.hasOwnProperty,o=Object.prototype.propertyIsEnumerable;t.exports=function(){try{if(!Object.assign)return!1;var t=new String("abc");if(t[5]="de","5"===Object.getOwnPropertyNames(t)[0])return!1;for(var e={},n=0;n<10;n++)e["_"+String.fromCharCode(n)]=n;if("0123456789"!==Object.getOwnPropertyNames(e).map(function(t){return e[t]}).join(""))return!1;var r={};return"abcdefghijklmnopqrst".split("").forEach(function(t){r[t]=t}),"abcdefghijklmnopqrst"===Object.keys(Object.assign({},r)).join("")}catch(t){return!1}}()?Object.assign:function(t,e){for(var n,s,c=function(t){if(null===t||void 0===t)throw new TypeError("Object.assign cannot be called with null or undefined");return Object(t)}(t),a=1;a<arguments.length;a++){n=Object(arguments[a]);for(var l in n)i.call(n,l)&&(c[l]=n[l]);if(r){s=r(n);for(var u=0;u<s.length;u++)o.call(n,s[u])&&(c[s[u]]=n[s[u]])}}return c}}]).default});

function getURLVar(key) {
	var value = [];
	var query = String(document.location).split('?');
	if (query[1]) {
		var part = query[1].split('&');
		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

var buttonCart = $('#cart'),
	totalCart = $('#cart-total'),
	modalCartContent = $('#modal-cart-content');

var cart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}
				if (json['success']) {
					M.toast({html: '<span><i class="material-icons left">check</i>' + json['success'] + '</span>', classes: 'toast-success'});
					setTimeout(function () {
						totalCart.html(json['total']);
					}, 100);
					buttonCart.addClass('pulse');
					totalCart.addClass('pulse');
					modalCartContent.load('index.php?route=common/cart/info #modal-cart-list');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'update': function(key, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					modalCartContent.load('index.php?route=common/cart/info #modal-cart-list');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function(key, product_id, quantity, message, cancel) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			success: function(json) {
				setTimeout(function() {
					totalCart.html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					modalCartContent.load('index.php?route=common/cart/info #modal-cart-list');

					M.toast({html: '<span class="toast-undo-remove__text">' + message + '</span><button id="toast-undo-remove__' + key + '" class="btn-flat waves-effect toast-action toast-undo-remove__action cyan-text text-accent-3">' + cancel + '</button>', classes: 'no-padding'});

					$('#toast-undo-remove__' + key + '').click(function() {
						cart.add(product_id, quantity);
						var toastElement = $(this).parent();
						var toastInstance = M.Toast.getInstance(toastElement);
						toastInstance.dismiss();
					});
				}

				if (json['total'] == 0) {
					buttonCart.removeClass('pulse');
					totalCart.removeClass('pulse');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}
var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			success: function(json) {
				setTimeout(function () {
					totalCart.html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					modalCartContent.load('index.php?route=common/cart/info #modal-cart-list');
				}
				if (json['total'] == 0) {
					buttonCart.removeClass('pulse');
					totalCart.removeClass('pulse');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}
var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}
				if (json['success']) {
					M.toast({html: '<span><i class="material-icons left">info</i>' + json['success'] + '</span>', classes: 'toast-info'});
				}
				$('#wishlist-total span').html(json['total']);
				$('#wishlist-total').attr('title', json['total']);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function() {
	}
}
var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					M.toast({html: '<span><i class="material-icons left">check</i>' + json['success'] + '</span>', classes: 'toast-success'});
					$('#compare-btn').removeClass('scale-out');
					$('#compare-total').html(json['total']);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function() {
	}
}

$(document).ready(function() {
	var mobileMenu = $('#mobilemenu'),
		cart = $('#cart'),
		btnFixed = $('.fixed-btn-floating__wrapper'),
		lastScroll = 0;

	$(window).scroll(function() {
		var scrollTop = $(this).scrollTop();

		if (scrollTop > lastScroll) {
			cart.addClass('cart-mobilemenu-scroll');
			mobileMenu.addClass('mobilemenu-scroll');
			btnFixed.addClass('fixed-btn-floating__wrapper--scroll');
		} else {
			cart.removeClass('cart-mobilemenu-scroll');
			mobileMenu.removeClass('mobilemenu-scroll');
			btnFixed.removeClass('fixed-btn-floating__wrapper--scroll');
		}

		lastScroll = scrollTop;
	});

	var superfish = $('.sf-menu');

	superfish.superfish({
		hoverClass: 'active',
		delay: 200,
		speed: 'fast',
		cssArrows: false,
		onShow: function() {
			$('.megamenu-slideshow').slick('setPosition');
		}
	});

	var collapsible = $('.collapsible'),
		collapsibleExpandable = $('.collapsible.expandable'),
		tabs = $('.tabs'),
		modal = $('.modal'),
		tooltipped = $('.tooltipped'),
		dropdown = $('.dropdown-trigger'),
		select = $('select');

	collapsible.collapsible();
	collapsibleExpandable.collapsible({
		accordion: false
	});
	tabs.tabs();
	modal.modal();
	tooltipped.tooltip();
	dropdown.dropdown();
	select.formSelect();
	M.updateTextFields();

	var btnSideMenu = $('#btn-side-menu'),
		sideMenu = $('#slide-out'),
		dropdownLk = $('#dropdown-lk');

	btnSideMenu.on('click', function() {
		sideMenu.sidenav();
		sideMenu.load('index.php?route=extension/materialize/common/sidenav');
	});

	dropdownLk.dropdown({
		hover: true,
		coverTrigger: false,
		constrainWidth: false
	});

	var offset = 300,
		scrollTopDuration = 700,
		backToTop = $('#back-to-top');

	$(window).scroll(function(){
		$(this).scrollTop() > offset ? backToTop.removeClass('scale-out') : backToTop.addClass('scale-out');
	});

	backToTop.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({scrollTop:0}, scrollTopDuration);
	});

	var headerNavigation = $('#header-navigation'),
		fixedNavWrapper = $('#fixed-nav-wrapper');

	fixedNavWrapper.height(headerNavigation.outerHeight());

	$(window).resize(function() {
		fixedNavWrapper.height(headerNavigation.outerHeight());
	});

	if (headerNavigation.length) {
		headerNavigation.pushpin({
			top: headerNavigation.offset().top
		});
	}

	// Product List
	var productsList = $('.products-list'),
		contentCards = $('#content .col'),
		contentCard = $('#content .col > .card'),
		btnListView = $('#list-view'),
		btnGridView = $('#grid-view');

	btnListView.click(function() {
		productsList.each(function(e) {
			e += 1;

			var productId = $(this).attr('id'),
				imageId = $('#image-' + productId),
				imageSrc = imageId.data('thumb'),
				imageThumb = imageId.data('hor-image');

			imageId.attr('src',imageThumb);
		});

		contentCard.attr('class', 'card horizontal hoverable');

		$('#grid-view').removeClass('active');
		$('#list-view').addClass('active');

		localStorage.setItem('display', 'list');
	});

	// Product Grid
	btnGridView.click(function() {
		productsList.each(function(e) {
			e += 1;

			var productId = $(this).attr('id'),
				imageId = $('#image-' + productId),
				imageSrc = imageId.data('thumb'),
				imageThumb = imageId.data('hor-image');

			imageId.attr('src',imageSrc);
		});

		contentCard.attr('class', 'card hoverable');

		$('#list-view').removeClass('active');
		$('#grid-view').addClass('active');

		localStorage.setItem('display', 'grid');
	});

	if (localStorage.getItem('display') == 'list') {
		btnListView.trigger('click');
	} else {
		btnGridView.trigger('click');
	}

	var inputSearchHeader = $('#input-search');

	inputSearchHeader.parent().find('label').on('click', function() {
		var url = $('base').attr('href') + 'index.php?route=product/search',
			value = inputSearchHeader.val();
		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}
		location = url;
	});

	inputSearchHeader.on('keydown', function(e) {
		if (e.keyCode == 13) {
			inputSearchHeader.parent().find('label').trigger('click');
		}
	});

	var searchClear = $('.search-buttons__clear');

	searchClear.click(function() {searchClear.parent().find('input').val('');});

	$(document).on('keydown', '#collapse-checkout-option input[name=\'email\'], #collapse-checkout-option input[name=\'password\']', function(e) {
		if (e.keyCode == 13) {
			$('#collapse-checkout-option #button-login').trigger('click');
		}
	});

	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;

			$.extend(this, option);

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27:
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Hide
			this.hide = function() {
				$(this).siblings('.autocomplete-content.dropdown-content').css({
					'opacity': '0',
					'display': 'none'
				});
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, $(this).attr('data-delay'), this);
			}
		});
	}

	$(document).delegate('.agree', 'click', function(e) {
		e.preventDefault();

		$('#modal-agree').remove();

		var element = this;

		$.ajax({
			url: $(element).attr('href'),
			type: 'get',
			dataType: 'html',
			success: function(data) {
				html  = '<div id="modal-agree" class="modal">';
				html += 	'<div class="modal-content">';
				html += 		'<i class="material-icons modal-action modal-close waves-effect waves-circle close-icon">close</i>';
				html += 		'<h4>' + $(element).text() + '</h4>';
				html += 		'<p>' + data + '</p>';
				html +=		'</div>';
				html += '</div>';
				$('body').append(html);
				$('#modal-agree').modal();
				$('#modal-agree').modal('open');
			}
		});
	});
});
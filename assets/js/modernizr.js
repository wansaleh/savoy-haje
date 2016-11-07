!function(e,n,t){function r(e,n){return typeof e===n}function o(){var e,n,t,o,s,i,a;for(var l in C)if(C.hasOwnProperty(l)){if(e=[],n=C[l],n.name&&(e.push(n.name.toLowerCase()),n.options&&n.options.aliases&&n.options.aliases.length))for(t=0;t<n.options.aliases.length;t++)e.push(n.options.aliases[t].toLowerCase());for(o=r(n.fn,"function")?n.fn():n.fn,s=0;s<e.length;s++)i=e[s],a=i.split("."),1===a.length?w[a[0]]=o:(!w[a[0]]||w[a[0]]instanceof Boolean||(w[a[0]]=new Boolean(w[a[0]])),w[a[0]][a[1]]=o),g.push((o?"":"no-")+a.join("-"))}}function s(e){var n=b.className,t=w._config.classPrefix||"";if(S&&(n=n.baseVal),w._config.enableJSClass){var r=new RegExp("(^|\\s)"+t+"no-js(\\s|$)");n=n.replace(r,"$1"+t+"js$2")}w._config.enableClasses&&(n+=" "+t+e.join(" "+t),S?b.className.baseVal=n:b.className=n)}function i(e){return e.replace(/([a-z])-([a-z])/g,function(e,n,t){return n+t.toUpperCase()}).replace(/^-/,"")}function a(e,n){return!!~(""+e).indexOf(n)}function l(){return"function"!=typeof n.createElement?n.createElement(arguments[0]):S?n.createElementNS.call(n,"http://www.w3.org/2000/svg",arguments[0]):n.createElement.apply(n,arguments)}function f(e,n){return function(){return e.apply(n,arguments)}}function u(e,n,t){var o;for(var s in e)if(e[s]in n)return t===!1?e[s]:(o=n[e[s]],r(o,"function")?f(o,t||n):o);return!1}function d(e){return e.replace(/([A-Z])/g,function(e,n){return"-"+n.toLowerCase()}).replace(/^ms-/,"-ms-")}function p(){var e=n.body;return e||(e=l(S?"svg":"body"),e.fake=!0),e}function c(e,t,r,o){var s,i,a,f,u="modernizr",d=l("div"),c=p();if(parseInt(r,10))for(;r--;)a=l("div"),a.id=o?o[r]:u+(r+1),d.appendChild(a);return s=l("style"),s.type="text/css",s.id="s"+u,(c.fake?c:d).appendChild(s),c.appendChild(d),s.styleSheet?s.styleSheet.cssText=e:s.appendChild(n.createTextNode(e)),d.id=u,c.fake&&(c.style.background="",c.style.overflow="hidden",f=b.style.overflow,b.style.overflow="hidden",b.appendChild(c)),i=t(d,e),c.fake?(c.parentNode.removeChild(c),b.style.overflow=f,b.offsetHeight):d.parentNode.removeChild(d),!!i}function m(n,r){var o=n.length;if("CSS"in e&&"supports"in e.CSS){for(;o--;)if(e.CSS.supports(d(n[o]),r))return!0;return!1}if("CSSSupportsRule"in e){for(var s=[];o--;)s.push("("+d(n[o])+":"+r+")");return s=s.join(" or "),c("@supports ("+s+") { #modernizr { position: absolute; } }",function(e){return"absolute"==getComputedStyle(e,null).position})}return t}function v(e,n,o,s){function f(){d&&(delete z.style,delete z.modElem)}if(s=!r(s,"undefined")&&s,!r(o,"undefined")){var u=m(e,o);if(!r(u,"undefined"))return u}for(var d,p,c,v,h,y=["modernizr","tspan","samp"];!z.style&&y.length;)d=!0,z.modElem=l(y.shift()),z.style=z.modElem.style;for(c=e.length,p=0;c>p;p++)if(v=e[p],h=z.style[v],a(v,"-")&&(v=i(v)),z.style[v]!==t){if(s||r(o,"undefined"))return f(),"pfx"!=n||v;try{z.style[v]=o}catch(e){}if(z.style[v]!=h)return f(),"pfx"!=n||v}return f(),!1}function h(e,n,t,o,s){var i=e.charAt(0).toUpperCase()+e.slice(1),a=(e+" "+k.join(i+" ")+i).split(" ");return r(n,"string")||r(n,"undefined")?v(a,n,o,s):(a=(e+" "+P.join(i+" ")+i).split(" "),u(a,n,t))}function y(e,n,r){return h(e,t,t,n,r)}var g=[],C=[],x={_version:"3.3.1",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,n){var t=this;setTimeout(function(){n(t[e])},0)},addTest:function(e,n,t){C.push({name:e,fn:n,options:t})},addAsyncTest:function(e){C.push({name:null,fn:e})}},w=function(){};w.prototype=x,w=new w;var b=n.documentElement,S="svg"===b.nodeName.toLowerCase(),_="Moz O ms Webkit",k=x._config.usePrefixes?_.split(" "):[];x._cssomPrefixes=k;var E=function(n){var r,o=prefixes.length,s=e.CSSRule;if("undefined"==typeof s)return t;if(!n)return!1;if(n=n.replace(/^@/,""),r=n.replace(/-/g,"_").toUpperCase()+"_RULE",r in s)return"@"+n;for(var i=0;o>i;i++){var a=prefixes[i],l=a.toUpperCase()+"_"+r;if(l in s)return"@-"+a.toLowerCase()+"-"+n}return!1};x.atRule=E;var P=x._config.usePrefixes?_.toLowerCase().split(" "):[];x._domPrefixes=P;var T={elem:l("modernizr")};w._q.push(function(){delete T.elem});var z={style:T.elem.style};w._q.unshift(function(){delete z.style}),x.testAllProps=h;var N=x.prefixed=function(e,n,t){return 0===e.indexOf("@")?E(e):(-1!=e.indexOf("-")&&(e=i(e)),n?h(e,n,t):h(e,"pfx"))};w.addTest("backgroundblendmode",N("backgroundBlendMode","text")),x.testAllProps=y,w.addTest("backdropfilter",y("backdropFilter")),o(),s(g),delete x.addTest,delete x.addAsyncTest;for(var j=0;j<w._q.length;j++)w._q[j]();e.Modernizr=w}(window,document);
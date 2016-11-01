!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e("object"==typeof exports?require("jquery"):jQuery)}(function($){function e(){var e=this._type,t=arguments.length,r=window[e],i=arguments,o=i[0],n,s,a;if(t<1)throw new Error("Minimum 1 argument must be given");if($.isArray(o)){s={};for(var l in o){n=o[l];try{s[n]=JSON.parse(r.getItem(n))}catch(e){s[n]=r.getItem(n)}}return s}if(1!=t){try{s=JSON.parse(r.getItem(o))}catch(e){throw new ReferenceError(o+" is not defined in this storage")}for(var l=1;l<t-1;l++)if(s=s[i[l]],void 0===s)throw new ReferenceError([].slice.call(i,1,l+1).join(".")+" is not defined in this storage");if($.isArray(i[l])){a=s,s={};for(var f in i[l])s[i[l][f]]=a[i[l][f]];return s}return s[i[l]]}try{return JSON.parse(r.getItem(o))}catch(e){return r.getItem(o)}}function t(){var e=this._type,t=arguments.length,r=window[e],i=arguments,o=i[0],n=i[1],s,a=isNaN(n)?{}:[],l,f;if(t<1||!$.isPlainObject(o)&&t<2)throw new Error("Minimum 2 arguments must be given or first parameter must be an object");if($.isPlainObject(o)){for(var c in o)s=o[c],$.isPlainObject(s)||this.alwaysUseJson?r.setItem(c,JSON.stringify(s)):r.setItem(c,s);return o}if(2==t)return"object"==typeof n||this.alwaysUseJson?r.setItem(o,JSON.stringify(n)):r.setItem(o,n),n;try{f=r.getItem(o),null!=f&&(a=JSON.parse(f))}catch(e){}f=a;for(var c=1;c<t-2;c++)s=i[c],l=isNaN(i[c+1])?"object":"array",(!f[s]||"object"==l&&!$.isPlainObject(f[s])||"array"==l&&!$.isArray(f[s]))&&("array"==l?f[s]=[]:f[s]={}),f=f[s];return f[i[c]]=i[c+1],r.setItem(o,JSON.stringify(a)),a}function r(){var e=this._type,t=arguments.length,r=window[e],i=arguments,o=i[0],n,s;if(t<1)throw new Error("Minimum 1 argument must be given");if($.isArray(o)){for(var a in o)r.removeItem(o[a]);return!0}if(1==t)return r.removeItem(o),!0;try{n=s=JSON.parse(r.getItem(o))}catch(e){throw new ReferenceError(o+" is not defined in this storage")}for(var a=1;a<t-1;a++)if(s=s[i[a]],void 0===s)throw new ReferenceError([].slice.call(i,1,a).join(".")+" is not defined in this storage");if($.isArray(i[a]))for(var l in i[a])delete s[i[a][l]];else delete s[i[a]];return r.setItem(o,JSON.stringify(n)),!0}function i(e){var t=s.call(this);for(var i in t)r.call(this,t[i]);if(e)for(var i in $.namespaceStorages)a(i)}function o(){var t=arguments.length,r=arguments,i=r[0];if(0==t)return 0==s.call(this).length;if($.isArray(i)){for(var n=0;n<i.length;n++)if(!o.call(this,i[n]))return!1;return!0}try{var a=e.apply(this,arguments);$.isArray(r[t-1])||(a={totest:a});for(var n in a)if(!($.isPlainObject(a[n])&&$.isEmptyObject(a[n])||$.isArray(a[n])&&!a[n].length)&&a[n])return!1;return!0}catch(e){return!0}}function n(){var t=arguments.length,r=arguments,i=r[0];if(t<1)throw new Error("Minimum 1 argument must be given");if($.isArray(i)){for(var o=0;o<i.length;o++)if(!n.call(this,i[o]))return!1;return!0}try{var s=e.apply(this,arguments);$.isArray(r[t-1])||(s={totest:s});for(var o in s)if(void 0===s[o]||null===s[o])return!1;return!0}catch(e){return!1}}function s(){var t=this._type,r=arguments.length,i=window[t],o=arguments,n=[],s={};if(s=r>0?e.apply(this,o):i,s&&s._cookie)for(var a in Cookies.get())""!=a&&n.push(a.replace(s._prefix,""));else for(var l in s)s.hasOwnProperty(l)&&n.push(l);return n}function a(e){if(!e||"string"!=typeof e)throw new Error("First parameter must be a string");h?(window.localStorage.getItem(e)||window.localStorage.setItem(e,"{}"),window.sessionStorage.getItem(e)||window.sessionStorage.setItem(e,"{}")):(window.localCookieStorage.getItem(e)||window.localCookieStorage.setItem(e,"{}"),window.sessionCookieStorage.getItem(e)||window.sessionCookieStorage.setItem(e,"{}"));var t={localStorage:$.extend({},$.localStorage,{_ns:e}),sessionStorage:$.extend({},$.sessionStorage,{_ns:e})};return"object"==typeof Cookies&&(window.cookieStorage.getItem(e)||window.cookieStorage.setItem(e,"{}"),t.cookieStorage=$.extend({},$.cookieStorage,{_ns:e})),$.namespaceStorages[e]=t,t}function l(e){var t="jsapi";try{return!!window[e]&&(window[e].setItem(t,t),window[e].removeItem(t),!0)}catch(e){return!1}}var f="ls_",c="ss_",h=l("localStorage"),u={_type:"",_ns:"",_callMethod:function(e,t){var r=[],t=Array.prototype.slice.call(t),i=t[0];return this._ns&&r.push(this._ns),"string"==typeof i&&i.indexOf(".")!==-1&&(t.shift(),[].unshift.apply(t,i.split("."))),[].push.apply(r,t),e.apply(this,r)},alwaysUseJson:!1,get:function(){return this._callMethod(e,arguments)},set:function(){var e=arguments.length,r=arguments,i=r[0];if(e<1||!$.isPlainObject(i)&&e<2)throw new Error("Minimum 2 arguments must be given or first parameter must be an object");if($.isPlainObject(i)&&this._ns){for(var o in i)this._callMethod(t,[o,i[o]]);return i}var n=this._callMethod(t,r);return this._ns?n[i.split(".")[0]]:n},remove:function(){if(arguments.length<1)throw new Error("Minimum 1 argument must be given");return this._callMethod(r,arguments)},removeAll:function(e){return this._ns?(this._callMethod(t,[{}]),!0):this._callMethod(i,[e])},isEmpty:function(){return this._callMethod(o,arguments)},isSet:function(){if(arguments.length<1)throw new Error("Minimum 1 argument must be given");return this._callMethod(n,arguments)},keys:function(){return this._callMethod(s,arguments)}};if("object"==typeof Cookies){window.name||(window.name=Math.floor(1e8*Math.random()));var g={_cookie:!0,_prefix:"",_expires:null,_path:null,_domain:null,setItem:function(e,t){Cookies.set(this._prefix+e,t,{expires:this._expires,path:this._path,domain:this._domain})},getItem:function(e){return Cookies.get(this._prefix+e)},removeItem:function(e){return Cookies.remove(this._prefix+e,{path:this._path})},clear:function(){for(var e in Cookies.get())""!=e&&(!this._prefix&&e.indexOf(f)===-1&&e.indexOf(c)===-1||this._prefix&&0===e.indexOf(this._prefix))&&$.removeCookie(e)},setExpires:function(e){return this._expires=e,this},setPath:function(e){return this._path=e,this},setDomain:function(e){return this._domain=e,this},setConf:function(e){return e.path&&(this._path=e.path),e.domain&&(this._domain=e.domain),e.expires&&(this._expires=e.expires),this},setDefaultConf:function(){this._path=this._domain=this._expires=null}};h||(window.localCookieStorage=$.extend({},g,{_prefix:f,_expires:3650}),window.sessionCookieStorage=$.extend({},g,{_prefix:c+window.name+"_"})),window.cookieStorage=$.extend({},g),$.cookieStorage=$.extend({},u,{_type:"cookieStorage",setExpires:function(e){return window.cookieStorage.setExpires(e),this},setPath:function(e){return window.cookieStorage.setPath(e),this},setDomain:function(e){return window.cookieStorage.setDomain(e),this},setConf:function(e){return window.cookieStorage.setConf(e),this},setDefaultConf:function(){return window.cookieStorage.setDefaultConf(),this}})}$.initNamespaceStorage=function(e){return a(e)},h?($.localStorage=$.extend({},u,{_type:"localStorage"}),$.sessionStorage=$.extend({},u,{_type:"sessionStorage"})):($.localStorage=$.extend({},u,{_type:"localCookieStorage"}),$.sessionStorage=$.extend({},u,{_type:"sessionCookieStorage"})),$.namespaceStorages={},$.removeAllStorages=function(e){$.localStorage.removeAll(e),$.sessionStorage.removeAll(e),$.cookieStorage&&$.cookieStorage.removeAll(e),e||($.namespaceStorages={})},$.alwaysUseJsonInStorage=function(e){u.alwaysUseJson=e,$.localStorage.alwaysUseJson=e,$.sessionStorage.alwaysUseJson=e,$.cookieStorage&&($.cookieStorage.alwaysUseJson=e)}});
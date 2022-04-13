(self.webpackChunk=self.webpackChunk||[]).push([[356],{1528:(t,e)=>{"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=function(){function t(t,e){for(var r=0;r<e.length;r++){var n=e[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}return function(e,r,n){return r&&t(e.prototype,r),n&&t(e,n),e}}();function n(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}var i=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};n(this,t),this.record(e)}return r(t,[{key:"all",value:function(){return this.errors}},{key:"has",value:function(t){var e=this.errors.hasOwnProperty(t);e||(e=Object.keys(this.errors).filter((function(e){return e.startsWith(t+".")||e.startsWith(t+"[")})).length>0);return e}},{key:"first",value:function(t){return this.get(t)[0]}},{key:"get",value:function(t){return this.errors[t]||[]}},{key:"any",value:function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[];if(0===e.length)return Object.keys(this.errors).length>0;var r={};return e.forEach((function(e){return r[e]=t.get(e)})),r}},{key:"record",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};this.errors=t}},{key:"clear",value:function(t){if(t){var e=Object.assign({},this.errors);Object.keys(e).filter((function(e){return e===t||e.startsWith(t+".")||e.startsWith(t+"[")})).forEach((function(t){return delete e[t]})),this.errors=e}else this.errors={}}}]),t}();e.default=i},4365:(t,e,r)=>{"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n,i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o=function(){function t(t,e){for(var r=0;r<e.length;r++){var n=e[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}return function(e,r,n){return r&&t(e.prototype,r),n&&t(e,n),e}}(),a=r(1528),s=(n=a)&&n.__esModule?n:{default:n},u=r(2110);function c(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}var l=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};c(this,t),this.processing=!1,this.successful=!1,this.withData(e).withOptions(r).withErrors({})}return o(t,[{key:"withData",value:function(t){for(var e in(0,u.isArray)(t)&&(t=t.reduce((function(t,e){return t[e]="",t}),{})),this.setInitialValues(t),this.errors=new s.default,this.processing=!1,this.successful=!1,t)(0,u.guardAgainstReservedFieldName)(e),this[e]=t[e];return this}},{key:"withErrors",value:function(t){return this.errors=new s.default(t),this}},{key:"withOptions",value:function(t){this.__options={resetOnSuccess:!0},t.hasOwnProperty("resetOnSuccess")&&(this.__options.resetOnSuccess=t.resetOnSuccess),t.hasOwnProperty("onSuccess")&&(this.onSuccess=t.onSuccess),t.hasOwnProperty("onFail")&&(this.onFail=t.onFail);var e="undefined"!=typeof window&&window.axios;if(this.__http=t.http||e||r(9669),!this.__http)throw new Error("No http library provided. Either pass an http option, or install axios.");return this}},{key:"data",value:function(){var t={};for(var e in this.initial)t[e]=this[e];return t}},{key:"only",value:function(t){var e=this;return t.reduce((function(t,r){return t[r]=e[r],t}),{})}},{key:"reset",value:function(){(0,u.merge)(this,this.initial),this.errors.clear()}},{key:"setInitialValues",value:function(t){this.initial={},(0,u.merge)(this.initial,t)}},{key:"populate",value:function(t){var e=this;return Object.keys(t).forEach((function(r){(0,u.guardAgainstReservedFieldName)(r),e.hasOwnProperty(r)&&(0,u.merge)(e,function(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}({},r,t[r]))})),this}},{key:"clear",value:function(){for(var t in this.initial)this[t]="";this.errors.clear()}},{key:"post",value:function(t){return this.submit("post",t)}},{key:"put",value:function(t){return this.submit("put",t)}},{key:"patch",value:function(t){return this.submit("patch",t)}},{key:"delete",value:function(t){return this.submit("delete",t)}},{key:"submit",value:function(t,e){var r=this;return this.__validateRequestType(t),this.errors.clear(),this.processing=!0,this.successful=!1,new Promise((function(n,i){r.__http[t](e,r.hasFiles()?(0,u.objectToFormData)(r.data()):r.data()).then((function(t){r.processing=!1,r.onSuccess(t.data),n(t.data)})).catch((function(t){r.processing=!1,r.onFail(t),i(t)}))}))}},{key:"hasFiles",value:function(){for(var t in this.initial)if(this.hasFilesDeep(this[t]))return!0;return!1}},{key:"hasFilesDeep",value:function(t){if(null===t)return!1;if("object"===(void 0===t?"undefined":i(t)))for(var e in t)if(t.hasOwnProperty(e)&&this.hasFilesDeep(t[e]))return!0;if(Array.isArray(t))for(var r in t)if(t.hasOwnProperty(r))return this.hasFilesDeep(t[r]);return(0,u.isFile)(t)}},{key:"onSuccess",value:function(t){this.successful=!0,this.__options.resetOnSuccess&&this.reset()}},{key:"onFail",value:function(t){this.successful=!1,t.response&&t.response.data.errors&&this.errors.record(t.response.data.errors)}},{key:"hasError",value:function(t){return this.errors.has(t)}},{key:"getError",value:function(t){return this.errors.first(t)}},{key:"getErrors",value:function(t){return this.errors.get(t)}},{key:"__validateRequestType",value:function(t){var e=["get","delete","head","post","put","patch"];if(-1===e.indexOf(t))throw new Error("`"+t+"` is not a valid request type, must be one of: `"+e.join("`, `")+"`.")}}],[{key:"create",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return(new t).withData(e)}}]),t}();e.default=l},8062:(t,e,r)=>{"use strict";var n=r(4365);Object.defineProperty(e,"ZP",{enumerable:!0,get:function(){return o(n).default}});var i=r(1528);function o(t){return t&&t.__esModule?t:{default:t}}},9924:(t,e)=>{"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.guardAgainstReservedFieldName=function(t){if(-1!==r.indexOf(t))throw new Error("Field name "+t+" isn't allowed to be used in a Form or Errors instance.")};var r=e.reservedFieldNames=["__http","__options","__validateRequestType","clear","data","delete","errors","getError","getErrors","hasError","initial","onFail","only","onSuccess","patch","populate","post","processing","successful","put","reset","submit","withData","withErrors","withOptions"]},7823:(t,e)=>{"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};function n(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:new FormData,r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;if(null===t||"undefined"===t||0===t.length)return e.append(r,t);for(var n in t)t.hasOwnProperty(n)&&o(e,i(r,n),t[n]);return e}function i(t,e){return t?t+"["+e+"]":e}function o(t,e,i){return i instanceof Date?t.append(e,i.toISOString()):i instanceof File?t.append(e,i,i.name):"boolean"==typeof i?t.append(e,i?"1":"0"):null===i?t.append(e,""):"object"!==(void 0===i?"undefined":r(i))?t.append(e,i):void n(i,t,e)}e.objectToFormData=n},2110:(t,e,r)=>{"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=r(933);Object.keys(n).forEach((function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return n[t]}})}));var i=r(7823);Object.keys(i).forEach((function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return i[t]}})}));var o=r(9924);Object.keys(o).forEach((function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return o[t]}})}))},933:(t,e)=>{"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};function n(t){return t instanceof File||t instanceof FileList}function i(t){if(null===t)return null;if(n(t))return t;if(Array.isArray(t)){var e=[];for(var o in t)t.hasOwnProperty(o)&&(e[o]=i(t[o]));return e}if("object"===(void 0===t?"undefined":r(t))){var a={};for(var s in t)t.hasOwnProperty(s)&&(a[s]=i(t[s]));return a}return t}e.isArray=function(t){return"[object Array]"===Object.prototype.toString.call(t)},e.isFile=n,e.merge=function(t,e){for(var r in e)t[r]=i(e[r])},e.cloneDeep=i},1848:t=>{t.exports=function(t,e,r,n){for(var i=t.length,o=r+(n?1:-1);n?o--:++o<i;)if(e(t[o],o,t))return o;return-1}},7786:(t,e,r)=>{var n=r(1811),i=r(327);t.exports=function(t,e){for(var r=0,o=(e=n(e,t)).length;null!=t&&r<o;)t=t[i(e[r++])];return r&&r==o?t:void 0}},13:t=>{t.exports=function(t,e){return null!=t&&e in Object(t)}},2118:(t,e,r)=>{var n=r(1848),i=r(2722),o=r(2351);t.exports=function(t,e,r){return e==e?o(t,e,r):n(t,i,r)}},2958:(t,e,r)=>{var n=r(6384),i=r(939);t.exports=function(t,e,r,o){var a=r.length,s=a,u=!o;if(null==t)return!s;for(t=Object(t);a--;){var c=r[a];if(u&&c[2]?c[1]!==t[c[0]]:!(c[0]in t))return!1}for(;++a<s;){var l=(c=r[a])[0],f=t[l],p=c[1];if(u&&c[2]){if(void 0===f&&!(l in t))return!1}else{var v=new n;if(o)var h=o(f,p,l,t,e,v);if(!(void 0===h?i(p,f,3,o,v):h))return!1}}return!0}},2722:t=>{t.exports=function(t){return t!=t}},7206:(t,e,r)=>{var n=r(1573),i=r(6432),o=r(6557),a=r(1469),s=r(9601);t.exports=function(t){return"function"==typeof t?t:null==t?o:"object"==typeof t?a(t)?i(t[0],t[1]):n(t):s(t)}},1573:(t,e,r)=>{var n=r(2958),i=r(1499),o=r(2634);t.exports=function(t){var e=i(t);return 1==e.length&&e[0][2]?o(e[0][0],e[0][1]):function(r){return r===t||n(r,t,e)}}},6432:(t,e,r)=>{var n=r(939),i=r(7361),o=r(9095),a=r(5403),s=r(9162),u=r(2634),c=r(327);t.exports=function(t,e){return a(t)&&s(e)?u(c(t),e):function(r){var a=i(r,t);return void 0===a&&a===e?o(r,t):n(e,a,3)}}},371:t=>{t.exports=function(t){return function(e){return null==e?void 0:e[t]}}},9152:(t,e,r)=>{var n=r(7786);t.exports=function(t){return function(e){return n(e,t)}}},7415:(t,e,r)=>{var n=r(9932);t.exports=function(t,e){return n(e,(function(e){return t[e]}))}},1811:(t,e,r)=>{var n=r(1469),i=r(5403),o=r(5514),a=r(9833);t.exports=function(t,e){return n(t)?t:i(t,e)?[t]:o(a(t))}},7740:(t,e,r)=>{var n=r(7206),i=r(8612),o=r(3674);t.exports=function(t){return function(e,r,a){var s=Object(e);if(!i(e)){var u=n(r,3);e=o(e),r=function(t){return u(s[t],t,s)}}var c=t(e,r,a);return c>-1?s[u?e[c]:c]:void 0}}},1499:(t,e,r)=>{var n=r(9162),i=r(3674);t.exports=function(t){for(var e=i(t),r=e.length;r--;){var o=e[r],a=t[o];e[r]=[o,a,n(a)]}return e}},222:(t,e,r)=>{var n=r(1811),i=r(5694),o=r(1469),a=r(5776),s=r(1780),u=r(327);t.exports=function(t,e,r){for(var c=-1,l=(e=n(e,t)).length,f=!1;++c<l;){var p=u(e[c]);if(!(f=null!=t&&r(t,p)))break;t=t[p]}return f||++c!=l?f:!!(l=null==t?0:t.length)&&s(l)&&a(p,l)&&(o(t)||i(t))}},5403:(t,e,r)=>{var n=r(1469),i=r(3448),o=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,a=/^\w*$/;t.exports=function(t,e){if(n(t))return!1;var r=typeof t;return!("number"!=r&&"symbol"!=r&&"boolean"!=r&&null!=t&&!i(t))||(a.test(t)||!o.test(t)||null!=e&&t in Object(e))}},9162:(t,e,r)=>{var n=r(3218);t.exports=function(t){return t==t&&!n(t)}},2634:t=>{t.exports=function(t,e){return function(r){return null!=r&&(r[t]===e&&(void 0!==e||t in Object(r)))}}},4523:(t,e,r)=>{var n=r(8306);t.exports=function(t){var e=n(t,(function(t){return 500===r.size&&r.clear(),t})),r=e.cache;return e}},2351:t=>{t.exports=function(t,e,r){for(var n=r-1,i=t.length;++n<i;)if(t[n]===e)return n;return-1}},5514:(t,e,r)=>{var n=r(4523),i=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,o=/\\(\\)?/g,a=n((function(t){var e=[];return 46===t.charCodeAt(0)&&e.push(""),t.replace(i,(function(t,r,n,i){e.push(n?i.replace(o,"$1"):r||t)})),e}));t.exports=a},327:(t,e,r)=>{var n=r(3448);t.exports=function(t){if("string"==typeof t||n(t))return t;var e=t+"";return"0"==e&&1/t==-Infinity?"-0":e}},3279:(t,e,r)=>{var n=r(3218),i=r(7771),o=r(4841),a=Math.max,s=Math.min;t.exports=function(t,e,r){var u,c,l,f,p,v,h=0,d=!1,y=!1,m=!0;if("function"!=typeof t)throw new TypeError("Expected a function");function b(e){var r=u,n=c;return u=c=void 0,h=e,f=t.apply(n,r)}function _(t){return h=t,p=setTimeout(x,e),d?b(t):f}function g(t){var r=t-v;return void 0===v||r>=e||r<0||y&&t-h>=l}function x(){var t=i();if(g(t))return w(t);p=setTimeout(x,function(t){var r=e-(t-v);return y?s(r,l-(t-h)):r}(t))}function w(t){return p=void 0,m&&u?b(t):(u=c=void 0,f)}function k(){var t=i(),r=g(t);if(u=arguments,c=this,v=t,r){if(void 0===p)return _(v);if(y)return clearTimeout(p),p=setTimeout(x,e),b(v)}return void 0===p&&(p=setTimeout(x,e)),f}return e=o(e)||0,n(r)&&(d=!!r.leading,l=(y="maxWait"in r)?a(o(r.maxWait)||0,e):l,m="trailing"in r?!!r.trailing:m),k.cancel=function(){void 0!==p&&clearTimeout(p),h=0,u=v=c=p=void 0},k.flush=function(){return void 0===p?f:w(i())},k}},3311:(t,e,r)=>{var n=r(7740)(r(998));t.exports=n},998:(t,e,r)=>{var n=r(1848),i=r(7206),o=r(554),a=Math.max;t.exports=function(t,e,r){var s=null==t?0:t.length;if(!s)return-1;var u=null==r?0:o(r);return u<0&&(u=a(s+u,0)),n(t,i(e,3),u)}},7361:(t,e,r)=>{var n=r(7786);t.exports=function(t,e,r){var i=null==t?void 0:n(t,e);return void 0===i?r:i}},9095:(t,e,r)=>{var n=r(13),i=r(222);t.exports=function(t,e){return null!=t&&i(t,e,n)}},4721:(t,e,r)=>{var n=r(2118),i=r(8612),o=r(7037),a=r(554),s=r(2628),u=Math.max;t.exports=function(t,e,r,c){t=i(t)?t:s(t),r=r&&!c?a(r):0;var l=t.length;return r<0&&(r=u(l+r,0)),o(t)?r<=l&&t.indexOf(e,r)>-1:!!l&&n(t,e,r)>-1}},7037:(t,e,r)=>{var n=r(4239),i=r(1469),o=r(7005);t.exports=function(t){return"string"==typeof t||!i(t)&&o(t)&&"[object String]"==n(t)}},8306:(t,e,r)=>{var n=r(3369);function i(t,e){if("function"!=typeof t||null!=e&&"function"!=typeof e)throw new TypeError("Expected a function");var r=function(){var n=arguments,i=e?e.apply(this,n):n[0],o=r.cache;if(o.has(i))return o.get(i);var a=t.apply(this,n);return r.cache=o.set(i,a)||o,a};return r.cache=new(i.Cache||n),r}i.Cache=n,t.exports=i},7771:(t,e,r)=>{var n=r(5639);t.exports=function(){return n.Date.now()}},9601:(t,e,r)=>{var n=r(371),i=r(9152),o=r(5403),a=r(327);t.exports=function(t){return o(t)?n(a(t)):i(t)}},554:(t,e,r)=>{var n=r(8601);t.exports=function(t){var e=n(t),r=e%1;return e==e?r?e-r:e:0}},2628:(t,e,r)=>{var n=r(7415),i=r(3674);t.exports=function(t){return null==t?[]:n(t,i(t))}},3356:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>p});var n=r(8062),i=r(3311),o=r.n(i),a=r(4721),s=r.n(a),u=r(7361),c=r.n(u),l=r(3279);const f={name:"nzUserForm",props:{action:String,method:{type:String,default:"post"},roles:Array,user:{type:Object,default:function(){return{first_name:"",last_name:"",institution:"",roles:[],curated_taxa:[]}}},redirect:String},data:function(){return{filteredTaxa:[],curatedTaxa:this.user.curated_taxa,form:new n.ZP({first_name:this.user.first_name,last_name:this.user.last_name,institution:this.user.institution,roles_ids:this.user.roles.map((function(t){return t.id})),curated_taxa_ids:this.user.curated_taxa.map((function(t){return t.id}))},{resetOnSuccess:!1})}},computed:{isExpert:function(){return s()(this.form.roles_ids,o()(this.roles,{name:"expert"}).id)}},watch:{curatedTaxa:function(t){this.form.curated_taxa_ids=t.map((function(t){return t.id}))}},methods:{onTaxonNameInput:r.n(l)()((function(t){return this.fetchTaxa(t)}),500),fetchTaxa:function(t){var e=this;axios.get(route("api.taxa.index"),{params:{name:t,page:1,per_page:10,except:this.curatedTaxa.map((function(t){return t.id}))}}).then((function(t){var r=t.data;e.filteredTaxa=r.data}))},submit:function(){this.form.processing||this.form[this.method.toLowerCase()](this.action).then(this.onSuccessfulSubmit).catch(this.onFailedSubmit)},onSuccessfulSubmit:function(){var t=this;this.form.processing=!0,this.$buefy.toast.open({message:this.trans("Saved successfully"),type:"is-success"}),setTimeout((function(){t.form.processing=!1,window.location.href=t.redirect}),500)},onFailedSubmit:function(t){this.$buefy.toast.open({duration:2500,message:c()(t,"response.data.message",t.message),type:"is-danger"})}}};const p=(0,r(1900).Z)(f,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"user-form"},[r("form",{on:{submit:function(e){return e.preventDefault(),t.submit.apply(null,arguments)}}},[r("div",{staticClass:"columns"},[r("div",{staticClass:"column"},[r("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.users.first_name")}},[r("b-input",{model:{value:t.form.first_name,callback:function(e){t.$set(t.form,"first_name",e)},expression:"form.first_name"}})],1)],1),t._v(" "),r("div",{staticClass:"column"},[r("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.users.last_name")}},[r("b-input",{model:{value:t.form.last_name,callback:function(e){t.$set(t.form,"last_name",e)},expression:"form.last_name"}})],1)],1)]),t._v(" "),r("b-field",{attrs:{label:t.trans("labels.users.institution")}},[r("b-input",{model:{value:t.form.institution,callback:function(e){t.$set(t.form,"institution",e)},expression:"form.institution"}})],1),t._v(" "),r("b-field",{attrs:{label:t.trans("labels.users.roles")}},[r("div",{staticClass:"block"},t._l(t.roles,(function(e){return r("b-checkbox",{key:e.id,attrs:{"native-value":e.id},model:{value:t.form.roles_ids,callback:function(e){t.$set(t.form,"roles_ids",e)},expression:"form.roles_ids"}},[t._v("\n          "+t._s(t.trans("roles."+e.name))+"\n        ")])})),1)]),t._v(" "),t.isExpert?r("b-field",{attrs:{label:t.trans("labels.users.curated_taxa")}},[r("b-taginput",{attrs:{data:t.filteredTaxa,autocomplete:"",field:"name",placeholder:"Type taxon name"},on:{typing:t.onTaxonNameInput},scopedSlots:t._u([{key:"default",fn:function(e){return[r("span",[t._v(t._s(e.option.name))])]}}],null,!1,1538493864),model:{value:t.curatedTaxa,callback:function(e){t.curatedTaxa=e},expression:"curatedTaxa"}})],1):t._e(),t._v(" "),r("hr"),t._v(" "),r("button",{staticClass:"button is-primary",attrs:{type:"submit"}},[t._v(t._s(t.trans("buttons.save")))])],1)])}),[],!1,null,null,null).exports}}]);
//# sourceMappingURL=d02814045ed30118.js.map
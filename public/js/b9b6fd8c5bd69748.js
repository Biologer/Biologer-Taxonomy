(self.webpackChunk=self.webpackChunk||[]).push([[399],{2755:(t,e,n)=>{"use strict";n.d(e,{Z:()=>i});var r=n(8718),a=n.n(r);function o(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}const s=new(function(){function t(){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t)}var e,n,r;return e=t,(n=[{key:"get",value:function(t){var e=JSON.parse(localStorage.getItem(t));return e?new Date(e.expires)<new Date?(localStorage.removeItem(t),null):e.value:null}},{key:"has",value:function(t){return null!==this.get(t)}},{key:"set",value:function(t,e,n){var r=(new Date).getTime(),a=new Date(r+6e4*n);localStorage.setItem(t,JSON.stringify({value:e,expires:a}))}},{key:"delete",value:function(t){this.get(t)&&localStorage.removeItem(t)}}])&&o(e.prototype,n),r&&o(e,r),Object.defineProperty(e,"prototype",{writable:!1}),t}()),i={props:{cacheKey:{default:null},cacheLifetime:{default:1440}},computed:{storageKey:function(){return this.cacheKey?"nz-table.".concat(this.cacheKey):"nz-table.".concat(window.location.host).concat(window.location.pathname)}},methods:{getPersistantKeys:function(){return["sortField","sortOrder","perPage"]},saveState:function(){s.set(this.storageKey,a()(this.$data,this.getPersistantKeys()),this.cacheLifetime)},restoreState:function(){var t=this,e=s.get(this.storageKey);null!=e&&(this.getPersistantKeys().forEach((function(n){void 0!==e[n]&&t.$set(t,n,e[n])})),this.saveState())}}}},1078:(t,e,n)=>{var r=n(2488),a=n(7285);t.exports=function t(e,n,o,s,i){var l=-1,u=e.length;for(o||(o=a),i||(i=[]);++l<u;){var c=e[l];n>0&&o(c)?n>1?t(c,n-1,o,s,i):r(i,c):s||(i[i.length]=c)}return i}},7786:(t,e,n)=>{var r=n(1811),a=n(327);t.exports=function(t,e){for(var n=0,o=(e=r(e,t)).length;null!=t&&n<o;)t=t[a(e[n++])];return n&&n==o?t:void 0}},13:t=>{t.exports=function(t,e){return null!=t&&e in Object(t)}},5970:(t,e,n)=>{var r=n(3012),a=n(9095);t.exports=function(t,e){return r(t,e,(function(e,n){return a(t,n)}))}},3012:(t,e,n)=>{var r=n(7786),a=n(611),o=n(1811);t.exports=function(t,e,n){for(var s=-1,i=e.length,l={};++s<i;){var u=e[s],c=r(t,u);n(c,u)&&a(l,o(u,t),c)}return l}},611:(t,e,n)=>{var r=n(4865),a=n(1811),o=n(5776),s=n(3218),i=n(327);t.exports=function(t,e,n,l){if(!s(t))return t;for(var u=-1,c=(e=a(e,t)).length,f=c-1,d=t;null!=d&&++u<c;){var h=i(e[u]),p=n;if("__proto__"===h||"constructor"===h||"prototype"===h)return t;if(u!=f){var v=d[h];void 0===(p=l?l(v,h,d):void 0)&&(p=s(v)?v:o(e[u+1])?[]:{})}r(d,h,p),d=d[h]}return t}},1811:(t,e,n)=>{var r=n(1469),a=n(5403),o=n(5514),s=n(9833);t.exports=function(t,e){return r(t)?t:a(t,e)?[t]:o(s(t))}},9021:(t,e,n)=>{var r=n(5564),a=n(5357),o=n(61);t.exports=function(t){return o(a(t,void 0,r),t+"")}},222:(t,e,n)=>{var r=n(1811),a=n(5694),o=n(1469),s=n(5776),i=n(1780),l=n(327);t.exports=function(t,e,n){for(var u=-1,c=(e=r(e,t)).length,f=!1;++u<c;){var d=l(e[u]);if(!(f=null!=t&&n(t,d)))break;t=t[d]}return f||++u!=c?f:!!(c=null==t?0:t.length)&&i(c)&&s(d,c)&&(o(t)||a(t))}},7285:(t,e,n)=>{var r=n(2705),a=n(5694),o=n(1469),s=r?r.isConcatSpreadable:void 0;t.exports=function(t){return o(t)||a(t)||!!(s&&t&&t[s])}},5403:(t,e,n)=>{var r=n(1469),a=n(3448),o=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,s=/^\w*$/;t.exports=function(t,e){if(r(t))return!1;var n=typeof t;return!("number"!=n&&"symbol"!=n&&"boolean"!=n&&null!=t&&!a(t))||(s.test(t)||!o.test(t)||null!=e&&t in Object(e))}},4523:(t,e,n)=>{var r=n(8306);t.exports=function(t){var e=r(t,(function(t){return 500===n.size&&n.clear(),t})),n=e.cache;return e}},5514:(t,e,n)=>{var r=n(4523),a=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,o=/\\(\\)?/g,s=r((function(t){var e=[];return 46===t.charCodeAt(0)&&e.push(""),t.replace(a,(function(t,n,r,a){e.push(r?a.replace(o,"$1"):n||t)})),e}));t.exports=s},327:(t,e,n)=>{var r=n(3448);t.exports=function(t){if("string"==typeof t||r(t))return t;var e=t+"";return"0"==e&&1/t==-Infinity?"-0":e}},3279:(t,e,n)=>{var r=n(3218),a=n(7771),o=n(4841),s=Math.max,i=Math.min;t.exports=function(t,e,n){var l,u,c,f,d,h,p=0,v=!1,m=!1,g=!0;if("function"!=typeof t)throw new TypeError("Expected a function");function b(e){var n=l,r=u;return l=u=void 0,p=e,f=t.apply(r,n)}function y(t){return p=t,d=setTimeout(x,e),v?b(t):f}function _(t){var n=t-h;return void 0===h||n>=e||n<0||m&&t-p>=c}function x(){var t=a();if(_(t))return S(t);d=setTimeout(x,function(t){var n=e-(t-h);return m?i(n,c-(t-p)):n}(t))}function S(t){return d=void 0,g&&l?b(t):(l=u=void 0,f)}function w(){var t=a(),n=_(t);if(l=arguments,u=this,h=t,n){if(void 0===d)return y(h);if(m)return clearTimeout(d),d=setTimeout(x,e),b(h)}return void 0===d&&(d=setTimeout(x,e)),f}return e=o(e)||0,r(n)&&(v=!!n.leading,c=(m="maxWait"in n)?s(o(n.maxWait)||0,e):c,g="trailing"in n?!!n.trailing:g),w.cancel=function(){void 0!==d&&clearTimeout(d),p=0,l=h=u=d=void 0},w.flush=function(){return void 0===d?f:S(a())},w}},5564:(t,e,n)=>{var r=n(1078);t.exports=function(t){return(null==t?0:t.length)?r(t,1):[]}},9095:(t,e,n)=>{var r=n(13),a=n(222);t.exports=function(t,e){return null!=t&&a(t,e,r)}},8306:(t,e,n)=>{var r=n(3369);function a(t,e){if("function"!=typeof t||null!=e&&"function"!=typeof e)throw new TypeError("Expected a function");var n=function(){var r=arguments,a=e?e.apply(this,r):r[0],o=n.cache;if(o.has(a))return o.get(a);var s=t.apply(this,r);return n.cache=o.set(a,s)||o,s};return n.cache=new(a.Cache||r),n}a.Cache=r,t.exports=a},7771:(t,e,n)=>{var r=n(5639);t.exports=function(){return r.Date.now()}},8718:(t,e,n)=>{var r=n(5970),a=n(9021)((function(t,e){return null==t?{}:r(t,e)}));t.exports=a},2042:(t,e,n)=>{"use strict";n.d(e,{Z:()=>a});const r={name:"nzPerPageSelect",props:{value:Number,options:Array}};const a=(0,n(1900).Z)(r,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("b-field",[n("b-select",{attrs:{value:t.value,placeholder:"Per page"},on:{input:function(e){return t.$emit("input",e)}}},t._l(t.options,(function(e,r){return n("option",{key:r,domProps:{value:e,textContent:t._s(e)}})})),0)],1)}),[],!1,null,null,null).exports},8884:(t,e,n)=>{"use strict";n.d(e,{Z:()=>a});const r={name:"nzSortableColumnHeader",props:{column:{type:Object,required:!0},sort:Object},computed:{isNotSortedColumn:function(){return this.sort.field!==this.column.field},sortIcon:function(){return this.isNotSortedColumn?"sort":"asc"===this.sort.order?"sort-asc":"sort-desc"}}};const a=(0,n(1900).Z)(r,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("span",{staticClass:"is-flex is-align-items-center"},[t._v("\n  "+t._s(t.column.label)+"\n  "),t.column.sortable?n("b-icon",{staticClass:"ml-2",class:{"has-text-grey-light":t.isNotSortedColumn},attrs:{pack:"fa",icon:t.sortIcon,size:"is-small"}}):t._e()],1)}),[],!1,null,null,null).exports},2399:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>u});var r=n(3279),a=n.n(r),o=n(2755),s=n(2042),i=n(8884);const l={name:"nzUsersTable",mixins:[o.Z],components:{NzPerPageSelect:s.Z,NzSortableColumnHeader:i.Z},props:{perPageOptions:{type:Array,default:function(){return[15,30,50,100]},validator:function(t){return t.length}},listRoute:String,editRoute:String,deleteRoute:String,empty:{type:String,default:"Nothing here."}},data:function(){return{data:[],total:0,loading:!1,sortField:"id",sortOrder:"asc",page:1,perPage:this.perPageOptions[0],checkedRows:[],search:""}},computed:{showing:function(){var t=this.page*this.perPage<=this.total?this.page*this.perPage:this.total,e=this.page>1?(this.page-1)*this.perPage+1:1;return this.total?this.trans("labels.tables.from_to_total",{total:this.total,from:e,to:t}):""}},created:function(){this.restoreState(),this.loadAsyncData()},methods:{loadAsyncData:function(){var t=this;return this.loading=!0,axios.get(route(this.listRoute).withQuery({sort_by:"".concat(this.sortField,".").concat(this.sortOrder),page:this.page,per_page:this.perPage,search:this.search})).then((function(e){var n=e.data;t.data=[],t.total=n.meta.total,n.data.forEach((function(e){return t.data.push(e)})),t.loading=!1}),(function(e){t.data=[],t.total=0,t.loading=!1}))},onPageChange:function(t){this.page=t,this.loadAsyncData()},onSort:function(t,e){this.sortField=t,this.sortOrder=e,this.saveState(),this.loadAsyncData()},onPerPageChange:function(t){t!==this.perPage&&(this.perPage=t,this.saveState(),this.loadAsyncData())},confirmRemove:function(t){var e=this;this.$buefy.dialog.confirm({message:this.trans("Are you sure you want to delete this record?"),confirmText:this.trans("buttons.delete"),cancelText:this.trans("buttons.cancel"),type:"is-danger",onConfirm:function(){e.remove(t)}})},remove:function(t){var e=this;return axios.delete(route(this.deleteRoute,t.id)).then((function(t){e.$buefy.toast.open({message:e.trans("Record deleted"),type:"is-success"}),e.loadAsyncData()})).catch((function(t){console.error(t)}))},editLink:function(t){return route(this.editRoute,t.id)},performSearch:a()((function(t){this.search!==t&&(this.search=t,this.loadAsyncData())}),500),clearSearch:function(){this.search="",this.loadAsyncData()}}};const u=(0,n(1900).Z)(l,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"users-table"},[n("div",{staticClass:"level"},[n("div",{staticClass:"level-left"},[n("div",{staticClass:"level-item"},[n("b-field",{attrs:{grouped:""}},[n("b-input",{attrs:{placeholder:t.trans("labels.users.search"),value:t.search,icon:"search",expanded:""},on:{input:t.performSearch}}),t._v(" "),t.search?n("p",{staticClass:"control"},[n("span",{staticClass:"button",on:{click:t.clearSearch}},[n("b-icon",{attrs:{icon:"close"}})],1)]):t._e()],1)],1)])]),t._v(" "),n("hr"),t._v(" "),n("b-table",{attrs:{data:t.data,loading:t.loading,paginated:"","backend-pagination":"",total:t.total,"per-page":t.perPage,"current-page":t.page,"pagination-position":"both","backend-sorting":"","default-sort-direction":"asc","default-sort":[t.sortField,t.sortOrder],"mobile-cards":""},on:{"page-change":t.onPageChange,sort:t.onSort},scopedSlots:t._u([{key:"top-left",fn:function(){return[n("div",{staticClass:"level-item"},[n("nz-per-page-select",{attrs:{value:t.perPage,options:t.perPageOptions},on:{input:t.onPerPageChange}})],1),t._v(" "),n("div",{staticClass:"level-item"},[t._v(t._s(t.showing))])]},proxy:!0},{key:"bottom-left",fn:function(){return[n("div",{staticClass:"level-item"},[n("nz-per-page-select",{attrs:{value:t.perPage,options:t.perPageOptions},on:{input:t.onPerPageChange}})],1),t._v(" "),n("div",{staticClass:"level-item"},[t._v(t._s(t.showing))])]},proxy:!0},{key:"empty",fn:function(){return[n("section",{staticClass:"section"},[n("div",{staticClass:"content has-text-grey has-text-centered"},[n("p",[t._v(t._s(t.empty))])])])]},proxy:!0}])},[t._v(" "),t._v(" "),n("b-table-column",{attrs:{field:"id",label:t.trans("labels.id"),width:"40",numeric:"",sortable:""},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.row;return[t._v("\n        "+t._s(n.id)+"\n      ")]}},{key:"header",fn:function(e){var r=e.column;return[n("nz-sortable-column-header",{attrs:{column:r,sort:{field:t.sortField,order:t.sortOrder}}})]}}])}),t._v(" "),n("b-table-column",{attrs:{field:"first_name",label:t.trans("labels.users.first_name"),sortable:""},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.row;return[t._v("\n        "+t._s(n.first_name)+"\n      ")]}},{key:"header",fn:function(e){var r=e.column;return[n("nz-sortable-column-header",{attrs:{column:r,sort:{field:t.sortField,order:t.sortOrder}}})]}}])}),t._v(" "),n("b-table-column",{attrs:{field:"last_name",label:t.trans("labels.users.last_name"),sortable:""},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.row;return[t._v("\n        "+t._s(n.last_name)+"\n      ")]}},{key:"header",fn:function(e){var r=e.column;return[n("nz-sortable-column-header",{attrs:{column:r,sort:{field:t.sortField,order:t.sortOrder}}})]}}])}),t._v(" "),n("b-table-column",{attrs:{field:"email",label:t.trans("labels.users.email"),sortable:""},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.row;return[t._v("\n        "+t._s(n.email)+"\n      ")]}},{key:"header",fn:function(e){var r=e.column;return[n("nz-sortable-column-header",{attrs:{column:r,sort:{field:t.sortField,order:t.sortOrder}}})]}}])}),t._v(" "),n("b-table-column",{attrs:{field:"institution",label:t.trans("labels.users.institution"),sortable:""},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.row;return[t._v("\n        "+t._s(n.institution)+"\n      ")]}},{key:"header",fn:function(e){var r=e.column;return[n("nz-sortable-column-header",{attrs:{column:r,sort:{field:t.sortField,order:t.sortOrder}}})]}}])}),t._v(" "),n("b-table-column",{attrs:{width:"150",numeric:""},scopedSlots:t._u([{key:"default",fn:function(e){var r=e.row;return[n("a",{attrs:{href:t.editLink(r)}},[n("b-icon",{attrs:{icon:"edit"}})],1),t._v(" "),n("a",{on:{click:function(e){return t.confirmRemove(r)}}},[n("b-icon",{attrs:{icon:"trash"}})],1)]}}])})],1)],1)}),[],!1,null,null,null).exports}}]);
//# sourceMappingURL=b9b6fd8c5bd69748.js.map
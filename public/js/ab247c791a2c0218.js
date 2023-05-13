"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[966],{3855:(t,n,a)=>{a.r(n),a.d(n,{default:()=>s});const e={name:"nzSidebar",props:{active:Boolean,hasUnreadNotifications:Boolean},data:function(){return{activeTab:"notifications",notifications:[],currentPage:1,hasMoreToLoad:this.hasUnreadNotifications,loading:!1}},created:function(){"undefined"!=typeof window&&document.addEventListener("keyup",this.keyPress),this.hasUnreadNotifications&&this.load()},beforeDestroy:function(){"undefined"!=typeof window&&document.removeEventListener("keyup",this.keyPress)},methods:{hide:function(){this.$emit("close")},keyPress:function(t){27===t.keyCode&&this.hide()},load:function(){var t=this;if(!this.loading){this.loading=!0;var n=this.currentPage;axios.get(route("api.my.unread-notifications.index",{page:n})).then((function(n){t.notifications=t.notifications.concat(n.data.data),t.hasMoreToLoad=t.page<n.data.meta.last_page})).finally((function(){t.loading=!1}))}},loadMore:function(){!this.loading&&this.hasMoreToLoad&&(this.currentPage++,this.load())},markNotificationAsRead:function(t,n){var a=this;axios.post(route("api.my.read-notifications-batch.store"),{notifications_ids:[t]}).then((function(e){a.notifications=a.notifications.filter((function(n){return n.id!==t})),a.$emit("update:has-unread-notifications",e.data.meta.has_unread),n&&n()}))},markAllNotificationsAsRead:function(){var t=this;this.hasUnreadNotifications&&axios.post(route("api.my.read-notifications-batch.store"),{all:!0}).then((function(){t.notifications=[],t.$emit("update:has-unread-notifications",!1)}))}}};const s={name:"nzDashboardNavbar",components:{NzSidebar:(0,a(1900).Z)(e,(function(){var t=this,n=t._self._c;return n("div",{staticClass:"sidebar",class:{"is-active":t.active}},[n("div",{staticClass:"sidebar-header"},[n("h3",{staticClass:"title is-size-5"},[t._v(t._s(t.trans("notifications.title")))])]),t._v(" "),n("div",{staticClass:"sidebar-body"},[t.hasUnreadNotifications?[t.notifications.length?n("transition-group",{attrs:{name:"notification-list"}},t._l(t.notifications,(function(a){return n("nz-notification",{key:"notification-".concat(a.id),staticClass:"sidebar-block",attrs:{notification:a},on:{"mark-read":t.markNotificationAsRead}})})),1):t._e(),t._v(" "),n("div",{staticClass:"sidebar-block justify-center py-8"},[n("button",{staticClass:"button is-primary",class:{"is-loading":t.loading},attrs:{type:"button",disabled:!t.hasMoreToLoad},on:{click:t.loadMore}},[t._v("\n          "+t._s(t.trans("notifications.load_more"))+"\n        ")])])]:n("div",{staticClass:"sidebar-block justify-center py-8"},[t._v("\n      "+t._s(t.trans("notifications.no_new_notifications"))+"\n    ")])],2),t._v(" "),n("footer",{staticClass:"sidebar-footer"},[n("button",{staticClass:"button",attrs:{type:"button"},on:{click:t.hide}},[t._v(t._s(t.trans("buttons.close")))]),t._v(" "),t.notifications.length?n("button",{staticClass:"button is-text",attrs:{type:"button"},on:{click:t.markAllNotificationsAsRead}},[t._v("\n      "+t._s(t.trans("notifications.mark_all_as_read"))+"\n    ")]):t._e()])])}),[],!1,null,null,null).exports},props:{hasUnread:Boolean},data:function(){return{active:!1,showSidebar:!1,hasUnreadNotifications:this.hasUnread}},methods:{toggle:function(){this.active=!this.active},toggleSidebar:function(){this.showSidebar=!this.showSidebar}}}},7776:(t,n,a)=>{a.r(n),a.d(n,{default:()=>s});const e={name:"nzAnnouncement",props:{announcement:Object},data:function(){return{newAnnouncement:this.announcement}},computed:{link:function(){return route("announcements.show",{announcement:this.newAnnouncement.id})}},methods:{sendRequestToMarkAsRead:function(){return axios.post("/api/read-announcements",{announcement_id:this.newAnnouncement.id})},markAsRead:function(){var t=this;this.sendRequestToMarkAsRead().then((function(){t.newAnnouncement=null}))}}};const s=(0,a(1900).Z)(e,(function(){var t=this,n=t._self._c;return t.newAnnouncement?n("article",{staticClass:"message is-info shadow"},[n("div",{staticClass:"message-body flex justify-between"},[n("div",{},[t._v("\n      "+t._s(t.newAnnouncement.title)+"\n    ")]),t._v(" "),n("div",{staticClass:"message-actions"},[n("a",{attrs:{href:t.link}},[t._v("Read more")]),t._v(" "),n("b-icon",{staticClass:"is-clickable",attrs:{icon:"check",title:"Mark as read"},nativeOn:{click:function(n){return t.markAsRead.apply(null,arguments)}}})],1)])]):t._e()}),[],!1,null,null,null).exports},4431:(t,n,a)=>{a.r(n),a.d(n,{default:()=>c});const e={name:"nzDeleteAccounModal",props:{action:String,csrfToken:String}};var s=a(1900);const i=(0,s.Z)(e,(function(){var t=this,n=t._self._c;return n("form",{staticClass:"modal-card",attrs:{action:t.action,method:"POST"}},[n("header",{staticClass:"modal-card-head"},[n("h3",{staticClass:"modal-card-title"},[t._v(t._s(t.trans("navigation.preferences.delete_account")))])]),t._v(" "),n("input",{attrs:{type:"hidden",name:"_token"},domProps:{value:t.csrfToken}}),t._v(" "),n("input",{attrs:{type:"hidden",name:"_method",value:"DELETE"}}),t._v(" "),n("section",{staticClass:"modal-card-body"},[n("p",[t._v(t._s(t.trans("This action is irreversible, once an account is deleted it cannot be restored.")))]),t._v(" "),n("p",[t._v(t._s(t.trans("Are you sure you want to delete your account?")))]),t._v(" "),n("b-field",{staticClass:"mt-8"},[n("b-checkbox",{attrs:{name:"delete_observations"}},[t._v(t._s(t.trans("labels.preferences.account.delete_observations")))])],1)],1),t._v(" "),n("footer",{staticClass:"modal-card-foot"},[n("button",{staticClass:"button",attrs:{type:"button"},on:{click:function(n){return t.$parent.close()}}},[t._v(t._s(t.trans("buttons.cancel")))]),t._v(" "),n("button",{staticClass:"button is-danger",attrs:{type:"submit"}},[t._v(t._s(t.trans("labels.preferences.account.delete_account")))])])])}),[],!1,null,null,null).exports,o={name:"nzDeleteAccountButton",props:{action:String,csrfToken:String},methods:{openModal:function(){this.$buefy.modal.open({parent:this,component:i,hasModalCard:!0,props:{action:this.action,csrfToken:this.csrfToken}})}}};const c=(0,s.Z)(o,(function(){var t=this;return(0,t._self._c)("button",{staticClass:"button is-danger",attrs:{type:"button"},on:{click:t.openModal}},[t._v("\n  "+t._s(t.trans("labels.preferences.account.delete_account"))+"\n")])}),[],!1,null,null,null).exports}}]);
//# sourceMappingURL=ab247c791a2c0218.js.map
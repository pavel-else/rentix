(function(n){function e(e){for(var c,o,r=e[0],d=e[1],i=e[2],s=0,h=[];s<r.length;s++)o=r[s],u[o]&&h.push(u[o][0]),u[o]=0;for(c in d)Object.prototype.hasOwnProperty.call(d,c)&&(n[c]=d[c]);l&&l(e);while(h.length)h.shift()();return a.push.apply(a,i||[]),t()}function t(){for(var n,e=0;e<a.length;e++){for(var t=a[e],c=!0,o=1;o<t.length;o++){var r=t[o];0!==u[r]&&(c=!1)}c&&(a.splice(e--,1),n=d(d.s=t[0]))}return n}var c={},o={app:0},u={app:0},a=[];function r(n){return d.p+"js/"+({}[n]||n)+"."+{"chunk-22faa80c":"853db5ba","chunk-251cd286":"3d473460","chunk-26d22fa0":"a67d1db1","chunk-2d0a400c":"21de7ee8","chunk-2d0a443e":"b49a13f2","chunk-2d0ab2eb":"460ae480","chunk-2d0ae5e6":"274f4fe6","chunk-2d0ae943":"b729f23a","chunk-2d0b1bf6":"a239c182","chunk-2d0b59e9":"aa250633","chunk-2d0ba708":"de5eba04","chunk-2d0aab88":"7a3e2dd5","chunk-2d0bdf1e":"96dbc2ce","chunk-2d0c4303":"21074cd7","chunk-2d0d3e27":"9b8ce952","chunk-2d0de2d9":"98705df4","chunk-2d0de6aa":"487aaf17","chunk-2d0e1d93":"d2fed5be","chunk-2d0e8c24":"aec996c3","chunk-2d0f06bd":"a448c33f","chunk-2d208124":"dce37773","chunk-2d21444c":"43e79324","chunk-2d2183eb":"88ffba82","chunk-2d21e6d0":"f8c4b5ff","chunk-2d21eae7":"cdc5c0c9","chunk-2d222779":"72e296de","chunk-2d224eb7":"c4bb7b9e","chunk-2d226319":"88388a8d","chunk-2d22c303":"5ef01f26","chunk-2d22d610":"6426facf","chunk-2d23777b":"f3ec3339","chunk-3ea2c9b8":"5662005f","chunk-2d0d093a":"d2ff6515","chunk-e262515c":"a80a68e6","chunk-2d0baaba":"93da4ced","chunk-40f4cc33":"d5835e9f","chunk-2d0f0c1b":"b3cd9da9","chunk-46a98b40":"81428d9f","chunk-5bb89bfa":"d5f5a5a5","chunk-70353478":"a2eec6bb","chunk-8efa499c":"43bd1844","chunk-b2ddbeea":"6687870f","chunk-c6404252":"6499a8c7","chunk-e3e0ee12":"2074c756"}[n]+".js"}function d(e){if(c[e])return c[e].exports;var t=c[e]={i:e,l:!1,exports:{}};return n[e].call(t.exports,t,t.exports,d),t.l=!0,t.exports}d.e=function(n){var e=[],t={"chunk-22faa80c":1,"chunk-26d22fa0":1,"chunk-e262515c":1,"chunk-46a98b40":1,"chunk-5bb89bfa":1,"chunk-8efa499c":1,"chunk-b2ddbeea":1,"chunk-c6404252":1,"chunk-e3e0ee12":1};o[n]?e.push(o[n]):0!==o[n]&&t[n]&&e.push(o[n]=new Promise(function(e,t){for(var c="css/"+({}[n]||n)+"."+{"chunk-22faa80c":"28a1c86e","chunk-251cd286":"31d6cfe0","chunk-26d22fa0":"b57027f3","chunk-2d0a400c":"31d6cfe0","chunk-2d0a443e":"31d6cfe0","chunk-2d0ab2eb":"31d6cfe0","chunk-2d0ae5e6":"31d6cfe0","chunk-2d0ae943":"31d6cfe0","chunk-2d0b1bf6":"31d6cfe0","chunk-2d0b59e9":"31d6cfe0","chunk-2d0ba708":"31d6cfe0","chunk-2d0aab88":"31d6cfe0","chunk-2d0bdf1e":"31d6cfe0","chunk-2d0c4303":"31d6cfe0","chunk-2d0d3e27":"31d6cfe0","chunk-2d0de2d9":"31d6cfe0","chunk-2d0de6aa":"31d6cfe0","chunk-2d0e1d93":"31d6cfe0","chunk-2d0e8c24":"31d6cfe0","chunk-2d0f06bd":"31d6cfe0","chunk-2d208124":"31d6cfe0","chunk-2d21444c":"31d6cfe0","chunk-2d2183eb":"31d6cfe0","chunk-2d21e6d0":"31d6cfe0","chunk-2d21eae7":"31d6cfe0","chunk-2d222779":"31d6cfe0","chunk-2d224eb7":"31d6cfe0","chunk-2d226319":"31d6cfe0","chunk-2d22c303":"31d6cfe0","chunk-2d22d610":"31d6cfe0","chunk-2d23777b":"31d6cfe0","chunk-3ea2c9b8":"31d6cfe0","chunk-2d0d093a":"31d6cfe0","chunk-e262515c":"46d42d84","chunk-2d0baaba":"31d6cfe0","chunk-40f4cc33":"31d6cfe0","chunk-2d0f0c1b":"31d6cfe0","chunk-46a98b40":"d354acaa","chunk-5bb89bfa":"b964b1c6","chunk-70353478":"31d6cfe0","chunk-8efa499c":"603305bb","chunk-b2ddbeea":"755beef8","chunk-c6404252":"4c857213","chunk-e3e0ee12":"3e45d735"}[n]+".css",u=d.p+c,a=document.getElementsByTagName("link"),r=0;r<a.length;r++){var i=a[r],s=i.getAttribute("data-href")||i.getAttribute("href");if("stylesheet"===i.rel&&(s===c||s===u))return e()}var h=document.getElementsByTagName("style");for(r=0;r<h.length;r++){i=h[r],s=i.getAttribute("data-href");if(s===c||s===u)return e()}var l=document.createElement("link");l.rel="stylesheet",l.type="text/css",l.onload=e,l.onerror=function(e){var c=e&&e.target&&e.target.src||u,a=new Error("Loading CSS chunk "+n+" failed.\n("+c+")");a.request=c,delete o[n],l.parentNode.removeChild(l),t(a)},l.href=u;var f=document.getElementsByTagName("head")[0];f.appendChild(l)}).then(function(){o[n]=0}));var c=u[n];if(0!==c)if(c)e.push(c[2]);else{var a=new Promise(function(e,t){c=u[n]=[e,t]});e.push(c[2]=a);var i,s=document.createElement("script");s.charset="utf-8",s.timeout=120,d.nc&&s.setAttribute("nonce",d.nc),s.src=r(n),i=function(e){s.onerror=s.onload=null,clearTimeout(h);var t=u[n];if(0!==t){if(t){var c=e&&("load"===e.type?"missing":e.type),o=e&&e.target&&e.target.src,a=new Error("Loading chunk "+n+" failed.\n("+c+": "+o+")");a.type=c,a.request=o,t[1](a)}u[n]=void 0}};var h=setTimeout(function(){i({type:"timeout",target:s})},12e4);s.onerror=s.onload=i,document.head.appendChild(s)}return Promise.all(e)},d.m=n,d.c=c,d.d=function(n,e,t){d.o(n,e)||Object.defineProperty(n,e,{enumerable:!0,get:t})},d.r=function(n){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(n,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(n,"__esModule",{value:!0})},d.t=function(n,e){if(1&e&&(n=d(n)),8&e)return n;if(4&e&&"object"===typeof n&&n&&n.__esModule)return n;var t=Object.create(null);if(d.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:n}),2&e&&"string"!=typeof n)for(var c in n)d.d(t,c,function(e){return n[e]}.bind(null,c));return t},d.n=function(n){var e=n&&n.__esModule?function(){return n["default"]}:function(){return n};return d.d(e,"a",e),e},d.o=function(n,e){return Object.prototype.hasOwnProperty.call(n,e)},d.p="/",d.oe=function(n){throw console.error(n),n};var i=window["webpackJsonp"]=window["webpackJsonp"]||[],s=i.push.bind(i);i.push=e,i=i.slice();for(var h=0;h<i.length;h++)e(i[h]);var l=s;a.push([0,"chunk-vendors"]),t()})({0:function(n,e,t){n.exports=t("56d7")},"56d7":function(n,e,t){"use strict";t.r(e);t("cadf"),t("551c"),t("f751"),t("097d"),t("f466"),t("579f"),t("587a");var c=t("a026"),o=t("9f7b"),u=t.n(o),a=t("bc3a"),r=t.n(a),d=function(){var n=this,e=n.$createElement,t=n._self._c||e;return t("router-view")},i=[],s={name:"app",beforeCreate:function(){localStorage.getItem("user-token")||this.$router.push("/Pages/Login")}},h=s,l=(t("5c0b"),t("2877")),f=Object(l["a"])(h,d,i,!1,null,null,null),p=f.exports,m=t("8c4f"),b=t("2f62"),k=t("795b"),g=t.n(k),v={state:{token:localStorage.getItem("user-token")||"",status:""},getters:{isAuthenticated:function(n){return!!n.token},authStatus:function(n){return n.status}},mutations:{token:function(n,e){console.log("commit: token",e),n.status="success",n.token=e},AUTH_REQUEST:function(n){n.status="loading"},AUTH_ERROR:function(n){n.status="error"},AUTH_LOGOUT:function(n){n.token="",n.status=""}},actions:{login:function(n,e){var t=n.getters,c=n.commit;n.dispatch;return new g.a(function(n,o){console.log("dispatch: login"),r()({url:t.url,data:{cmd:"login",value:e},method:"POST"}).then(function(e){console.log(e);var t=e.data.token;c("token",t),localStorage.setItem("user-token",t),n(e)}).catch(function(n){c("AUTH_ERROR",n),localStorage.removeItem("user-token"),o(n)})})},AUTH_REGISTER:function(n,e){var t=n.getters,c=n.commit;n.dispatch;return new g.a(function(n,o){r()({url:t.url+"/api/register",data:e,method:"POST"}).then(function(e){var t=e.data.success.token;r.a.defaults.headers.common["Authorization"]=t,c("AUTH_SUCCESS",t),localStorage.setItem("user-token",t),n(e)}).catch(function(n){c("AUTH_ERROR",n),localStorage.removeItem("user-token"),o(n)})})},AUTH_LOGOUT:function(n){var e=n.commit;n.dispatch;return new g.a(function(n,t){e("AUTH_LOGOUT"),localStorage.removeItem("user-token"),delete r.a.defaults.headers.common["Authorization"],n()})}}},P={actions:{multiRequest:function(n,e){var t=n.commit,c=n.getters;e&&e.map||console.warn("Request error! Queue is not defined or is not array!",e);var o=function(n){for(var e in n)switch(e){case"products":t("products",n[e]);break;case"rental_points":t("rentalPoints",n[e]);break;case"logs":break;default:console.warn("Request: Unknown type data - ",e)}};return console.log("dispatch: request",e),new g.a(function(n,t){var u=c.url,a=localStorage.getItem("user-token");r()({url:u,data:{queue:e,token:a},method:"POST"}).then(function(e){console.log(e),o(e.data),n(!0)}).catch(function(n){console.log(n),t(n)})})}}},w={state:{url:"https://rentix.biz/api/request_adm.php"},getters:{url:function(n){return n.url}}},S={state:{rentalPoints:[]},getters:{rentalPoints:function(n){return n.rentalPoints}},mutations:{rentalPoints:function(n,e){console.log("commit: rentalPoints",e),n.rentalPoints=e}},actions:{getRentalPoints:function(n){var e=n.commit,t=n.getters;return console.log("dispatch: getRentalPoints"),new g.a(function(n,c){var o=[{cmd:"getRentalPoints"}],u=t.url,a=localStorage.getItem("user-token");r()({url:u,data:{queue:o,token:a},method:"POST"}).then(function(t){console.log(t),e("rentalPoints",t.data.rental_points),n(t)}).catch(function(n){console.log(n),c(n)})})}}},y={state:{products:[]},getters:{products:function(n){return n.products}},mutations:{products:function(n,e){console.log("commit: products",e),n.products=e}},actions:{getProducts:function(n){var e=n.commit,t=n.getters;return console.log("dispatch: getProducts"),new g.a(function(n,c){var o=[{cmd:"getAllProducts"}],u=t.url,a=localStorage.getItem("user-token");r()({url:u,data:{queue:o,token:a},method:"POST"}).then(function(t){console.log(t),e("products",t.data.products),n(!0)}).catch(function(n){console.log(n),c(n)})})},setProduct:function(n,e){var t=n.commit,c=n.getters;return console.log("dispatch: setProduct",e),new g.a(function(n,o){r()({method:"post",url:c.url,data:{queue:[{cmd:"setProduct",value:e},{cmd:"getProducts"}],token:localStorage.getItem("user-token")}}).then(function(n){console.log(n),t("products",n.data.products)}).catch(function(n){console.log(n),o(n)})})}}};c["default"].use(b["a"]);var T=new b["a"].Store({modules:{auth:v,multiRequest:P,settings:w,rentalPoints:S,products:y}}),A=T,O=function(){return Promise.all([t.e("chunk-40f4cc33"),t.e("chunk-46a98b40")]).then(t.bind(null,"e8c5"))},R=function(){return Promise.all([t.e("chunk-3ea2c9b8"),t.e("chunk-2d0ba708"),t.e("chunk-e262515c")]).then(t.bind(null,"7277"))},_=function(){return Promise.all([t.e("chunk-2d0ba708"),t.e("chunk-2d0aab88")]).then(t.bind(null,"11e7"))},U=function(){return t.e("chunk-2d0de2d9").then(t.bind(null,"8517"))},E=function(){return Promise.all([t.e("chunk-3ea2c9b8"),t.e("chunk-2d0ba708"),t.e("chunk-2d0d093a")]).then(t.bind(null,"6923"))},I=function(){return Promise.all([t.e("chunk-3ea2c9b8"),t.e("chunk-2d0baaba")]).then(t.bind(null,"37cc"))},C=function(){return t.e("chunk-c6404252").then(t.bind(null,"1292"))},B=function(){return t.e("chunk-8efa499c").then(t.bind(null,"da19"))},j=function(){return Promise.all([t.e("chunk-40f4cc33"),t.e("chunk-2d0f0c1b")]).then(t.bind(null,"9e70"))},q=function(){return t.e("chunk-2d0bdf1e").then(t.bind(null,"2dc9"))},H=function(){return t.e("chunk-2d22d610").then(t.bind(null,"f6f0"))},L=function(){return t.e("chunk-2d224eb7").then(t.bind(null,"e1d9"))},x=function(){return t.e("chunk-2d0b1bf6").then(t.bind(null,"20bd"))},N=function(){return t.e("chunk-2d0ae943").then(t.bind(null,"0b50"))},G=function(){return t.e("chunk-2d208124").then(t.bind(null,"a2da"))},M=function(){return t.e("chunk-2d0a443e").then(t.bind(null,"0668"))},z=function(){return t.e("chunk-2d21eae7").then(t.bind(null,"d731"))},D=function(){return t.e("chunk-2d0de6aa").then(t.bind(null,"860f"))},F=function(){return t.e("chunk-2d0ab2eb").then(t.bind(null,"13d7"))},J=function(){return t.e("chunk-2d0d3e27").then(t.bind(null,"5f55"))},Q=function(){return t.e("chunk-2d0f06bd").then(t.bind(null,"9bfd"))},$=function(){return t.e("chunk-2d21444c").then(t.bind(null,"afe6"))},W=function(){return t.e("chunk-5bb89bfa").then(t.bind(null,"3fe7"))},K=function(){return t.e("chunk-26d22fa0").then(t.bind(null,"9a51"))},V=function(){return t.e("chunk-22faa80c").then(t.bind(null,"c3fc"))},X=function(){return t.e("chunk-2d222779").then(t.bind(null,"cf77"))},Y=function(){return t.e("chunk-2d2183eb").then(t.bind(null,"c9ba"))},Z=function(){return t.e("chunk-e3e0ee12").then(t.bind(null,"261a"))},nn=function(){return t.e("chunk-2d0a400c").then(t.bind(null,"051b"))},en=function(){return t.e("chunk-2d21e6d0").then(t.bind(null,"d608"))},tn=function(){return t.e("chunk-2d0e1d93").then(t.bind(null,"7bd6"))},cn=function(){return t.e("chunk-2d0ae5e6").then(t.bind(null,"0a87"))},on=function(){return t.e("chunk-2d226319").then(t.bind(null,"e82b"))},un=function(){return t.e("chunk-2d0b59e9").then(t.bind(null,"1a58"))},an=function(){return t.e("chunk-2d23777b").then(t.bind(null,"faf0"))},rn=function(){return t.e("chunk-2d0c4303").then(t.bind(null,"3a87"))},dn=function(){return t.e("chunk-2d22c303").then(t.bind(null,"f1bd"))},sn=function(){return t.e("chunk-2d0e8c24").then(t.bind(null,"8b48"))},hn=function(){return t.e("chunk-251cd286").then(t.bind(null,"aaf8"))},ln=function(){return t.e("chunk-b2ddbeea").then(t.bind(null,"dc02"))},fn=function(){return t.e("chunk-70353478").then(t.bind(null,"eeca"))};c["default"].use(m["a"]);var pn=function(n,e,t){A.getters.isAuthenticated?t("/"):t()},mn=function(n,e,t){A.getters.isAuthenticated?t():t("/Pages/Login")},bn=new m["a"]({mode:"hash",linkActiveClass:"open active",scrollBehavior:function(){return{y:0}},routes:[{path:"/",redirect:"/dashboard",name:"Home",component:O,beforeEnter:mn,children:[{path:"dashboard",name:"Dashboard",component:R},{path:"rental-points",name:"RentalPoints",component:W},{path:"products",name:"Products",component:K},{path:"theme",redirect:"/theme/colors",name:"Theme",component:{render:function(n){return n("router-view")}},children:[{path:"colors",name:"Colors",component:_},{path:"typography",name:"Typography",component:U}]},{path:"charts",name:"Charts",component:E},{path:"widgets",name:"Widgets",component:I},{path:"users",meta:{label:"Users"},component:{render:function(n){return n("router-view")}},children:[{path:"",component:ln},{path:":id",meta:{label:"User Details"},name:"User",component:fn}]},{path:"base",redirect:"/base/cards",name:"Base",component:{render:function(n){return n("router-view")}},children:[{path:"cards",name:"Cards",component:C},{path:"forms",name:"Forms",component:B},{path:"switches",name:"Switches",component:j},{path:"tables",name:"Tables",component:q},{path:"tabs",name:"Tabs",component:H},{path:"breadcrumbs",name:"Breadcrumbs",component:L},{path:"carousels",name:"Carousels",component:x},{path:"collapses",name:"Collapses",component:N},{path:"jumbotrons",name:"Jumbotrons",component:G},{path:"list-groups",name:"List Groups",component:M},{path:"navs",name:"Navs",component:z},{path:"navbars",name:"Navbars",component:D},{path:"paginations",name:"Paginations",component:F},{path:"popovers",name:"Popovers",component:J},{path:"progress-bars",name:"Progress Bars",component:Q},{path:"tooltips",name:"Tooltips",component:$}]},{path:"buttons",redirect:"/buttons/standard-buttons",name:"Buttons",component:{render:function(n){return n("router-view")}},children:[{path:"standard-buttons",name:"Standard Buttons",component:V},{path:"button-groups",name:"Button Groups",component:X},{path:"dropdowns",name:"Dropdowns",component:Y},{path:"brand-buttons",name:"Brand Buttons",component:Z}]},{path:"icons",redirect:"/icons/font-awesome",name:"Icons",component:{render:function(n){return n("router-view")}},children:[{path:"coreui-icons",name:"CoreUI Icons",component:cn},{path:"flags",name:"Flags",component:nn},{path:"font-awesome",name:"Font Awesome",component:en},{path:"simple-line-icons",name:"Simple Line Icons",component:tn}]},{path:"notifications",redirect:"/notifications/alerts",name:"Notifications",component:{render:function(n){return n("router-view")}},children:[{path:"alerts",name:"Alerts",component:on},{path:"badges",name:"Badges",component:un},{path:"modals",name:"Modals",component:an}]}]},{path:"/pages",redirect:"/pages/404",name:"Pages",component:{render:function(n){return n("router-view")}},children:[{path:"404",name:"Page404",component:rn},{path:"500",name:"Page500",component:dn},{path:"login",name:"Login",component:sn,beforeEnter:pn},{path:"register",name:"Register",component:hn}]}]}),kn=localStorage.getItem("user-token");kn&&(r.a.defaults.headers.common["Authorization"]=kn),c["default"].use(u.a),new c["default"]({el:"#app",router:bn,store:A,template:"<App/>",components:{App:p}})},"5c0b":function(n,e,t){"use strict";var c=t("5e27"),o=t.n(c);o.a},"5e27":function(n,e,t){}});
//# sourceMappingURL=app.5da27650.js.map
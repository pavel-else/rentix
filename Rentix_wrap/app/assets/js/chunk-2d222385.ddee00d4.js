(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d222385"],{ce4a:function(t,e,n){"use strict";n.r(e);var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t._v("\n    "+t._s(t.message)+"\n")])},r=[],a={data:function(){return{message:"Инициализация..."}},beforeCreate:function(){var t=this;this.$store.dispatch("AUTH_LOGOUT");var e=this.$route.params.token;this.$store.dispatch("AUTH_TOKEN",e).then(function(){t.$store.dispatch("INIT_APP").then(function(){return t.$router.push("/")})}).catch(function(e){t.message="Не верный токен. "+e})}},c=a,u=n("2877"),i=Object(u["a"])(c,s,r,!1,null,null,null);e["default"]=i.exports}}]);
//# sourceMappingURL=chunk-2d222385.ddee00d4.js.map
(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-0f903cec"],{a55b:function(e,t,s){"use strict";s.r(t);var n=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("form",{staticClass:"login login-form",on:{submit:function(t){return t.preventDefault(),e.login(t)}}},[s("h1",[e._v("Sign in")]),s("label",{staticClass:"login-form__label"},[e._v("ID\n      "),s("input",{directives:[{name:"model",rawName:"v-model",value:e.id,expression:"id"}],attrs:{required:"",type:"text"},domProps:{value:e.id},on:{input:function(t){t.target.composing||(e.id=t.target.value)}}})]),s("label",{staticClass:"login-form__label"},[e._v("Password\n      "),s("input",{directives:[{name:"model",rawName:"v-model",value:e.password,expression:"password"}],attrs:{required:"",type:"password"},domProps:{value:e.password},on:{input:function(t){t.target.composing||(e.password=t.target.value)}}})]),s("hr"),s("button",{attrs:{type:"submit"}},[e._v("Login")])])])},i=[],o=(s("cadf"),s("551c"),s("097d"),{name:"Login",data:function(){return{password:123123,id:8800000001,message:""}},methods:{login:function(){var e=this,t=this.id,s=this.password;this.$store.dispatch("AUTH_REQUEST",{id:t,password:s}).then(function(){e.$router.push("/")}).catch(function(t){e.message="Не верный логин или пароль!"})},register:function(){this.$router.push("/Pages/Register")}}}),a=o,r=(s("ec2e"),s("2877")),u=Object(r["a"])(a,n,i,!1,null,"048c7c4d",null);u.options.__file="Login.vue";t["default"]=u.exports},ec2e:function(e,t,s){"use strict";var n=s("fe0b"),i=s.n(n);i.a},fe0b:function(e,t,s){}}]);
//# sourceMappingURL=chunk-0f903cec.b3dd1707.js.map
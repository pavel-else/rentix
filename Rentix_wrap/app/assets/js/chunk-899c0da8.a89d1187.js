(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-899c0da8"],{"03d5":function(t,e,s){},a55b:function(t,e,s){"use strict";s.r(e);var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("form",{staticClass:"login login-form",on:{submit:function(e){return e.preventDefault(),t.login(e)}}},[s("h1",[t._v("Sign in")]),s("label",{staticClass:"login-form__label"},[t._v("ID\n      "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.id,expression:"id"}],attrs:{required:"",type:"text"},domProps:{value:t.id},on:{input:function(e){e.target.composing||(t.id=e.target.value)}}})]),s("label",{staticClass:"login-form__label"},[t._v("Password\n      "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],attrs:{required:"",type:"password"},domProps:{value:t.password},on:{input:function(e){e.target.composing||(t.password=e.target.value)}}})]),s("hr"),s("button",{attrs:{type:"submit"}},[t._v("Login")])])])},o=[],i={name:"Login",data:function(){return{password:123123,id:8800000001,message:""}},methods:{login:function(){var t=this,e=this.id,s=this.password;this.$store.dispatch("AUTH_REQUEST",{id:e,password:s}).then(function(){t.$router.push("/")}).catch(function(e){console.log(e),t.message="Не верный логин или пароль!"})},register:function(){this.$router.push("/Pages/Register")}}},a=i,r=(s("b277"),s("2877")),u=Object(r["a"])(a,n,o,!1,null,"2e107acc",null);u.options.__file="Login.vue";e["default"]=u.exports},b277:function(t,e,s){"use strict";var n=s("03d5"),o=s.n(n);o.a}}]);
//# sourceMappingURL=chunk-899c0da8.a89d1187.js.map
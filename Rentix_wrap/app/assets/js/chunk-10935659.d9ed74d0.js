(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-10935659"],{"0e3e":function(t,e,r){},1727:function(t,e,r){},"25fe":function(t,e,r){"use strict";var a=r("1727"),s=r.n(a);s.a},3846:function(t,e,r){r("9e1e")&&"g"!=/./g.flags&&r("86cc").f(RegExp.prototype,"flags",{configurable:!0,get:r("0bfb")})},"43eb":function(t,e,r){},"6b54":function(t,e,r){"use strict";r("3846");var a=r("cb7c"),s=r("0bfb"),i=r("9e1e"),n="toString",o=/./[n],c=function(t){r("2aba")(RegExp.prototype,n,t,!0)};r("79e5")(function(){return"/a/b"!=o.call({source:"a",flags:"b"})})?c(function(){var t=a(this);return"/".concat(t.source,"/","flags"in t?t.flags:!i&&t instanceof RegExp?s.call(t):void 0)}):o.name!=n&&c(function(){return o.call(this)})},"717e":function(t,e,r){"use strict";var a=r("fd48"),s=r.n(a);s.a},"7e70":function(t,e,r){"use strict";var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"canvas"},[r("div",{staticClass:"details details--repair"},[r("h3",[t.repair.isNew?r("span",[t._v("Новый ремонт")]):t._e(),t.repair.isNew?t._e():r("span",[t._v("Детальная информация")])]),r("table",[r("tr",[r("td",[t._v("Товар")]),r("td",[t._v(t._s(t.repair.product_name))])]),r("tr",[r("td",[t._v("Начало ремонта")]),r("td",[r("span",[t._v(t._s(t.short(t.repair.start_time)))])])]),t.repair.end_time?r("tr",[r("td",[t._v("Конец ремонта")]),r("td",[t.repair.end_time?r("span",[t._v(t._s(t.short(t.repair.end_time)))]):t._e()])]):t._e(),r("tr",[t._m(0),r("td",[r("select",{directives:[{name:"model",rawName:"v-model",value:t.repair.repair_type,expression:"repair.repair_type"}],on:{change:function(e){var r=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){var e="_value"in t?t._value:t.value;return e});t.$set(t.repair,"repair_type",e.target.multiple?r:r[0])}}},[r("option",{attrs:{value:"null",disabled:""}},[t._v("Выбрать")]),t._l(t.planTypes,function(e){return r("option",{key:e.id_rent,domProps:{value:e.id_rent}},[t._v(t._s(e.name))])}),r("option",{attrs:{value:"null",disabled:""}},[t._v("__________________________")]),t._l(t.simpleTypes,function(e){return r("option",{key:e.id_rent,domProps:{value:e.id_rent}},[t._v(t._s(e.name))])})],2)])]),r("tr",[r("td",[t._v("Стоимость комплектующих")]),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:t.repair.cost_comp,expression:"repair.cost_comp"}],domProps:{value:t.repair.cost_comp},on:{input:function(e){e.target.composing||t.$set(t.repair,"cost_comp",e.target.value)}}})])]),r("tr",[r("td",[t._v("Стоимость работы")]),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:t.repair.cost_work,expression:"repair.cost_work"}],domProps:{value:t.repair.cost_work},on:{input:function(e){e.target.composing||t.$set(t.repair,"cost_work",e.target.value)}}})])]),r("tr",[r("td",[t._v("Примечание")]),r("td",[r("textarea",{directives:[{name:"model",rawName:"v-model",value:t.repair.note,expression:"repair.note"}],domProps:{value:t.repair.note},on:{input:function(e){e.target.composing||t.$set(t.repair,"note",e.target.value)}}})])])]),r("div",{staticClass:"btn-group"},[r("button",{on:{click:t.save}},[t._v("Сохранить")]),r("button",{on:{click:t.close}},[t._v("Отмена")]),t.repair.isCompleate||t.repair.isNew?t._e():r("button",{on:{click:t.stop}},[t._v("Завершить ремонт")])]),r("div",{staticClass:"details__close",on:{click:t.close}})])])},s=[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("td",[t._v("Тип ремонта "),r("span",{attrs:{title:"Обязательно к заполнению"}},[t._v("*")])])}],i=(r("55dd"),r("c060")),n=(r("6b54"),function(t,e){t||(t=(new Date).toString());var r=new Date(t);if(isNaN(r))console.log("date.js, makeDate","error to parse date",{fullDate:t});else{var a=r.getFullYear(),s=+r.getMonth()+1<=9?"0".concat(+r.getMonth()+1):"".concat(+r.getMonth()+1),i=+r.getDate()<=9?"0".concat(+r.getDate()):r.getDate(),n=+r.getHours()<=9?"0".concat(+r.getHours()):r.getHours(),o=+r.getMinutes()<=9?"0".concat(+r.getMinutes()):r.getMinutes();if(a&&s&&i){if(!e||n&&o)return e?"".concat(a,"-").concat(s,"-").concat(i," ").concat(n,":").concat(o):"".concat(a,"-").concat(s,"-").concat(i);console.log("date.js, makeDate","error to parse hourse",{mod:e,hours:n})}else console.log("date.js, makeDate","error to parse date",{year:a,month:s,day:i})}}),o=r("8a88"),c={props:{_repair:Object},data:function(){return{repair:Object(i["a"])(this._repair)}},methods:{close:function(){this.$emit("close")},save:function(){this.isReady()?(this.$store.dispatch("setRepair",this.repair),this.$emit("close")):alert("Укажите необходимые данные!")},stop:function(){this.repair.end_time=new Date,this.$store.dispatch("stopRepair",this.repair),this.$emit("close")},short:function(t){return o["a"]("DD MMMM YYYY",t)},isReady:function(){return!!this.repair.repair_type&&!("other"===this.repair.repair_type&&!this.repair.note)}},computed:{startMin:function(){return n()},repairTypes:function(){var t=this.$store.getters.repairTypes;return t.filter(function(t){return"active"===t.status})},planTypes:function(){return this.repairTypes?this.repairTypes.filter(function(t){return"1"===t.is_plan}):[]},simpleTypes:function(){var t=this.repairTypes?this.repairTypes.filter(function(t){return"0"===t.is_plan}):[],e=t.sort(function(t,e){return e.id_rent-t.id_rent});return e}}},p=c,l=(r("717e"),r("2877")),_=Object(l["a"])(p,a,s,!1,null,"66e175e6",null);e["a"]=_.exports},c734:function(t,e,r){"use strict";var a=r("43eb"),s=r.n(a);s.a},d176:function(t,e,r){"use strict";var a=r("0e3e"),s=r.n(a);s.a},edab:function(t,e,r){"use strict";r.r(e);var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"repairs"},[r("div",{staticClass:"table__wrap"},[r("div",{staticClass:"caption-wrap"},[r("h2",{staticClass:"repairs__caption"},[t._v("Плановое ТО")]),t.planRepairs?r("small",[t._v(" "+t._s(t.planRepairs.length)+" шт")]):t._e()]),t.planRepairs.length>0?r("table",{staticClass:"repairs__table"},[t._m(0),t._l(t.planRepairs.filter(t.filt),function(e){return r("tr",{key:e.product_id+"_"+e.repair_type,staticClass:"repairs__tr",on:{click:function(r){return t.createRepair(e)}}},[r("td",{staticClass:"repairs__td col--name"},[t._v(t._s(e.product_name))]),r("td",{staticClass:"repairs__td"},[t._v(t._s(e.repair_type_name))]),r("td",{staticClass:"repairs__td"},[t._v(t._s(t._f("round")(e.mileage))+" ч."),e.last_repair_mileage?r("span"):t._e()])])})],2):r("div",[t._v("Здесь пока пусто ...")])]),r("Tasks",{staticClass:"tasks"}),"details"===t.show?r("Details",{attrs:{_repair:t.repair},on:{close:function(e){t.show="repairs"}}}):t._e()],1)},s=[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("tr",{staticClass:"repairs__first-line"},[r("th",[t._v("Название")]),r("th",[t._v("Тип")]),r("th",{attrs:{title:"Текущий пробег в часах"}},[t._v("Текущий пробег")])])}],i=r("bd90"),n=r("7e70"),o=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"reapir-tasks"},[t._m(0),t.tasks.length>0?r("table",{staticClass:"tasks__table"},t._l(t.tasks,function(e){return r("tr",{staticClass:"repairs__tr"},[r("td",{staticClass:"repairs__td col--name"},[t._v(t._s(e.product_name))]),r("td",{staticClass:"repairs__td"},[t._v(t._s(e.repair_type_name))]),r("td",{staticClass:"repairs__td"},[t._v(t._s(t._f("round")(e.mileage))+" ч."),e.last_repair_mileage?r("span"):t._e()])])}),0):r("div",[t._v("Здесь пока пусто ...")])])},c=[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"caption-wrap"},[r("h2",{staticClass:"repairs__caption"},[t._v("Задачи на ремонт")])])}],p={computed:{tasks:function(){var t=this.$store.getters.repairs;return t.filter(function(t){return!t.start_time})}}},l=p,_=(r("c734"),r("2877")),u=Object(_["a"])(l,o,c,!1,null,null,null),d=u.exports,v={components:{Details:n["a"],Tasks:d},data:function(){return{filt:function(t){return t},show:"repairs",repair:{}}},methods:{createRepair:function(t){this.repair=t,this.repair.cost_work=0,this.repair.cost_comp=0,this.repair.start_time=new Date,this.repair.isNew=!0,this.repair.isPlan=!0,this.repair.isCompleate=!1,this.show="details"}},computed:{planRepairs:function(){return Object(i["a"])(this.$store)}},filters:{round:function(t){return t?Math.round(t):0}}},f=v,m=(r("25fe"),r("d176"),Object(_["a"])(f,a,s,!1,null,"2e71ec62",null));e["default"]=m.exports},fd48:function(t,e,r){}}]);
//# sourceMappingURL=chunk-10935659.d9ed74d0.js.map
(window.webpackJsonp=window.webpackJsonp||[]).push([[1],{931:function(t,e,r){"use strict";r.r(e);var n=r(9);function c(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,n)}return r}function i(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var o={data:function(){return{country:"Uganda",Origin:"Kampala"}},computed:function(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?c(Object(r),!0).forEach((function(e){i(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):c(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}({},Object(n.e)(["cities"])),filters:{currency:function(t){return new Intl.NumberFormat("en-US",{style:"currency",currency:"USD"}).format(t)}}},u=r(3),a=Object(u.a)(o,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("h3",{staticClass:"bg-success text-center text-white p-2 font-italic"},[t._v("\n        Summary\n  ")]),t._v(" "),r("table",{staticClass:"table"},[r("tr",[r("th",[t._v("Number Of City:")]),t._v(" "),r("td",[t._v(t._s(t.cities.length))])]),t._v(" "),r("tr",[r("th",[t._v("Country With Most Citys:")]),t._v(" "),r("td",[t._v(t._s(t._f("currency")(23e4)))])])])])}),[],!1,null,null,null);e.default=a.exports}}]);
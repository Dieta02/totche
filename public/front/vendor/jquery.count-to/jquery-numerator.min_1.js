!function(t){"use strict";if("function"==typeof define&&define.amd)define(["jquery"],t);else if("object"==typeof exports)t(require("jquery"));else{if("undefined"==typeof jQuery)throw"jquery-numerator requires jQuery to be loaded first";t(jQuery)}}((function(t){var e="numerator",n={easing:"swing",duration:500,delimiter:void 0,rounding:0,toValue:void 0,fromValue:void 0,queue:!1,onStart:function(){},onStep:function(){},onProgress:function(){},onComplete:function(){}};function i(i,s){this.element=i,this.settings=t.extend({},n,s),this._defaults=n,this._name=e,this.init()}i.prototype={init:function(){this.parseElement(),this.setValue()},parseElement:function(){var e=t.trim(t(this.element).text());this.settings.fromValue=this.settings.fromValue||this.format(e)},setValue:function(){var e=this;t({value:e.settings.fromValue}).animate({value:e.settings.toValue},{duration:parseInt(e.settings.duration,10),easing:e.settings.easing,start:e.settings.onStart,step:function(n,i){t(e.element).text(e.format(n)),e.settings.onStep(n,i)},progress:e.settings.onProgress,complete:e.settings.onComplete})},format:function(t){return t=parseInt(this.settings.rounding)<1?parseInt(t,10):parseFloat(t).toFixed(parseInt(this.settings.rounding)),this.settings.delimiter?this.delimit(t):t},delimit:function(t){var e=this;if(t=t.toString(),e.settings.rounding&&parseInt(e.settings.rounding,10)>0){var n=t.substring(t.length-(e.settings.rounding+1),t.length),i=t.substring(0,t.length-(e.settings.rounding+1));return e.addDelimiter(i)+n}return e.addDelimiter(t)},addDelimiter:function(t){return t.toString().replace(/\B(?=(\d{3})+(?!\d))/g,this.settings.delimiter)}},t.fn.numerator=function(e){return this.each((function(){t.data(this,"plugin_numerator")&&t.data(this,"plugin_numerator",null),t.data(this,"plugin_numerator",new i(this,e))}))}}));
"use strict";!function(){var e=[],t="template-welcome",n={init:function(){for(var t=this,n=document.scripts.length,i=0;i<n;++i){var o=document.scripts[i];"text/html"===o.type&&(e[o.id]={text:o.text},o.parentNode.removeChild(o),--n,--i)}$("aside .document-link").each(function(){var t=$(this),n=t.attr("href").slice(1);e[n]&&(e[n].title=t.data("title"))}),Riode.$body.on("click",".document-link",function(e){t.open(e.currentTarget.getAttribute("href").slice(1));var n=Riode.byClass("main-content");n.length&&$("html").animate({scrollTop:n[0].offsetTop},600)}),location.hash&&t.open(location.hash.slice(1)),$(".btn-search").click(function(){t.search(this.previousElementSibling.value)}),$(".input-search").keydown(function(e){13===e.keyCode&&t.search(this.value)})},open:function(n){n&&e[n]&&(t=n),t&&e[t]&&(Riode.byId("document-view").innerHTML=e[t].text,Riode.byId("document-title").textContent=e[t].title,Riode.byId("document-view").classList.remove("search-result")),$(Riode.byClass("document-link")).parent("li").removeClass("show"),$('.document-link[href="#'+n+'"]').parent().addClass("show")},search:function(t){var n=t.trim();if(""!=n){if(!(n.length<3)){var i=[];Riode.byId("document-title").textContent="Search Result";for(var o in e){var r,c=0;r=e[o].text.replace(new RegExp(n,"gi"),function(e,t,n){var i=0;for(i=t;i>=0;--i){if("<"===n[i])return e;if(">"===n[i])break}for(i=t;t[i];++i){if(">"===n[i])return e;if("<"===n[i])break}return++c,"<mark>"+e+"</mark>"}),c>0&&i.push({id:o,count:c,text:'<div class="search-pane"><sup class="search-count">'+c+"</sup>"+r+"</div>"})}var s="";i.sort(function(e,t){return t.count-e.count});for(var o in i)s+=i[o].text;Riode.byId("document-view").innerHTML=s||'<h5 class="text-center">Nothing Found</h5>',Riode.byId("document-view").classList.add("search-result")}}else this.open()}};Riode.docs=n,$(window).on("riode_complete",function(){Riode.docs&&Riode.docs.init()})}();
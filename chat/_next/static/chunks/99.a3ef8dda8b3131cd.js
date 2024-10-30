"use strict";(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[99],{8099:function(t,e,r){r.d(e,{a:function(){return m},b:function(){return ta},c:function(){return L},d:function(){return ts},e:function(){return te},f:function(){return td},g:function(){return ty},h:function(){return th},i:function(){return E},l:function(){return v},p:function(){return ti},s:function(){return tr},u:function(){return S}});var a=r(44),i=r(9373),n=r(211),l=r(3047),s=r(7657),d=r(1188);let o=(t,e,r,a)=>{e.forEach(e=>{b[e](t,r,a)})},h=(t,e,r)=>{a.l.trace("Making markers for ",r),t.append("defs").append("marker").attr("id",e+"-extensionStart").attr("class","marker extension "+e).attr("refX",0).attr("refY",7).attr("markerWidth",190).attr("markerHeight",240).attr("orient","auto").append("path").attr("d","M 1,7 L18,13 V 1 Z"),t.append("defs").append("marker").attr("id",e+"-extensionEnd").attr("class","marker extension "+e).attr("refX",19).attr("refY",7).attr("markerWidth",20).attr("markerHeight",28).attr("orient","auto").append("path").attr("d","M 1,1 V 13 L18,7 Z")},c=(t,e)=>{t.append("defs").append("marker").attr("id",e+"-compositionStart").attr("class","marker composition "+e).attr("refX",0).attr("refY",7).attr("markerWidth",190).attr("markerHeight",240).attr("orient","auto").append("path").attr("d","M 18,7 L9,13 L1,7 L9,1 Z"),t.append("defs").append("marker").attr("id",e+"-compositionEnd").attr("class","marker composition "+e).attr("refX",19).attr("refY",7).attr("markerWidth",20).attr("markerHeight",28).attr("orient","auto").append("path").attr("d","M 18,7 L9,13 L1,7 L9,1 Z")},p=(t,e)=>{t.append("defs").append("marker").attr("id",e+"-aggregationStart").attr("class","marker aggregation "+e).attr("refX",0).attr("refY",7).attr("markerWidth",190).attr("markerHeight",240).attr("orient","auto").append("path").attr("d","M 18,7 L9,13 L1,7 L9,1 Z"),t.append("defs").append("marker").attr("id",e+"-aggregationEnd").attr("class","marker aggregation "+e).attr("refX",19).attr("refY",7).attr("markerWidth",20).attr("markerHeight",28).attr("orient","auto").append("path").attr("d","M 18,7 L9,13 L1,7 L9,1 Z")},g=(t,e)=>{t.append("defs").append("marker").attr("id",e+"-dependencyStart").attr("class","marker dependency "+e).attr("refX",0).attr("refY",7).attr("markerWidth",190).attr("markerHeight",240).attr("orient","auto").append("path").attr("d","M 5,7 L9,13 L1,7 L9,1 Z"),t.append("defs").append("marker").attr("id",e+"-dependencyEnd").attr("class","marker dependency "+e).attr("refX",19).attr("refY",7).attr("markerWidth",20).attr("markerHeight",28).attr("orient","auto").append("path").attr("d","M 18,7 L9,13 L14,7 L9,1 Z")},y=(t,e)=>{t.append("defs").append("marker").attr("id",e+"-lollipopStart").attr("class","marker lollipop "+e).attr("refX",0).attr("refY",7).attr("markerWidth",190).attr("markerHeight",240).attr("orient","auto").append("circle").attr("stroke","black").attr("fill","white").attr("cx",6).attr("cy",7).attr("r",6)},f=(t,e)=>{t.append("marker").attr("id",e+"-pointEnd").attr("class","marker "+e).attr("viewBox","0 0 12 20").attr("refX",10).attr("refY",5).attr("markerUnits","userSpaceOnUse").attr("markerWidth",12).attr("markerHeight",12).attr("orient","auto").append("path").attr("d","M 0 0 L 10 5 L 0 10 z").attr("class","arrowMarkerPath").style("stroke-width",1).style("stroke-dasharray","1,0"),t.append("marker").attr("id",e+"-pointStart").attr("class","marker "+e).attr("viewBox","0 0 10 10").attr("refX",0).attr("refY",5).attr("markerUnits","userSpaceOnUse").attr("markerWidth",12).attr("markerHeight",12).attr("orient","auto").append("path").attr("d","M 0 5 L 10 10 L 10 0 z").attr("class","arrowMarkerPath").style("stroke-width",1).style("stroke-dasharray","1,0")},u=(t,e)=>{t.append("marker").attr("id",e+"-circleEnd").attr("class","marker "+e).attr("viewBox","0 0 10 10").attr("refX",11).attr("refY",5).attr("markerUnits","userSpaceOnUse").attr("markerWidth",11).attr("markerHeight",11).attr("orient","auto").append("circle").attr("cx","5").attr("cy","5").attr("r","5").attr("class","arrowMarkerPath").style("stroke-width",1).style("stroke-dasharray","1,0"),t.append("marker").attr("id",e+"-circleStart").attr("class","marker "+e).attr("viewBox","0 0 10 10").attr("refX",-1).attr("refY",5).attr("markerUnits","userSpaceOnUse").attr("markerWidth",11).attr("markerHeight",11).attr("orient","auto").append("circle").attr("cx","5").attr("cy","5").attr("r","5").attr("class","arrowMarkerPath").style("stroke-width",1).style("stroke-dasharray","1,0")},x=(t,e)=>{t.append("marker").attr("id",e+"-crossEnd").attr("class","marker cross "+e).attr("viewBox","0 0 11 11").attr("refX",12).attr("refY",5.2).attr("markerUnits","userSpaceOnUse").attr("markerWidth",11).attr("markerHeight",11).attr("orient","auto").append("path").attr("d","M 1,1 l 9,9 M 10,1 l -9,9").attr("class","arrowMarkerPath").style("stroke-width",2).style("stroke-dasharray","1,0"),t.append("marker").attr("id",e+"-crossStart").attr("class","marker cross "+e).attr("viewBox","0 0 11 11").attr("refX",-1).attr("refY",5.2).attr("markerUnits","userSpaceOnUse").attr("markerWidth",11).attr("markerHeight",11).attr("orient","auto").append("path").attr("d","M 1,1 l 9,9 M 10,1 l -9,9").attr("class","arrowMarkerPath").style("stroke-width",2).style("stroke-dasharray","1,0")},w=(t,e)=>{t.append("defs").append("marker").attr("id",e+"-barbEnd").attr("refX",19).attr("refY",7).attr("markerWidth",20).attr("markerHeight",14).attr("markerUnits","strokeWidth").attr("orient","auto").append("path").attr("d","M 19,7 L9,13 L14,7 L9,1 Z")},b={extension:h,composition:c,aggregation:p,dependency:g,lollipop:y,point:f,circle:u,cross:x,barb:w},m=o,k=(t,e,r,n)=>{let s=t||"";if("object"==typeof s&&(s=s[0]),(0,a.k)((0,a.g)().flowchart.htmlLabels)){s=s.replace(/\\n|\n/g,"<br />"),a.l.info("vertexText"+s);let t={isNode:n,label:(0,l.d)(s).replace(/fa[blrs]?:fa-[\w-]+/g,t=>`<i class='${t.replace(":"," ")}'></i>`),labelStyle:e.replace("fill:","color:")};return function(t){var e;let r=(0,i.Ys)(document.createElementNS("http://www.w3.org/2000/svg","foreignObject")),a=r.append("xhtml:div"),n=t.label,l=t.isNode?"nodeLabel":"edgeLabel";return a.html('<span class="'+l+'" '+(t.labelStyle?'style="'+t.labelStyle+'"':"")+">"+n+"</span>"),(e=t.labelStyle)&&a.attr("style",e),a.style("display","inline-block"),a.style("white-space","nowrap"),a.attr("xmlns","http://www.w3.org/1999/xhtml"),r.node()}(t)}{let t=document.createElementNS("http://www.w3.org/2000/svg","text");t.setAttribute("style",e.replace("color:","fill:"));for(let e of"string"==typeof s?s.split(/\\n|\n|<br\s*\/?>/gi):Array.isArray(s)?s:[]){let a=document.createElementNS("http://www.w3.org/2000/svg","tspan");a.setAttributeNS("http://www.w3.org/XML/1998/namespace","xml:space","preserve"),a.setAttribute("dy","1em"),a.setAttribute("x","0"),r?a.setAttribute("class","title-row"):a.setAttribute("class","row"),a.textContent=e.trim(),t.appendChild(a)}return t}},L=k,v=(t,e,r,s)=>{let d,o;let h=e.useHtmlLabels||(0,a.k)((0,a.g)().flowchart.htmlLabels),c=t.insert("g").attr("class",r||"node default").attr("id",e.domId||e.id),p=c.insert("g").attr("class","label").attr("style",e.labelStyle);d=void 0===e.labelText?"":"string"==typeof e.labelText?e.labelText:e.labelText[0];let g=p.node(),y=(o="markdown"===e.labelType?(0,n.c)(p,(0,a.b)((0,l.d)(d),(0,a.g)()),{useHtmlLabels:h,width:e.width||(0,a.g)().flowchart.wrappingWidth,classes:"markdown-node-label"}):g.appendChild(L((0,a.b)((0,l.d)(d),(0,a.g)()),e.labelStyle,!1,s))).getBBox();if((0,a.k)((0,a.g)().flowchart.htmlLabels)){let t=o.children[0],e=(0,i.Ys)(o);y=t.getBoundingClientRect(),e.attr("width",y.width),e.attr("height",y.height)}let f=e.padding/2;return h?p.attr("transform","translate("+-y.width/2+", "+-y.height/2+")"):p.attr("transform","translate(0, "+-y.height/2+")"),e.centerLabel&&p.attr("transform","translate("+-y.width/2+", "+-y.height/2+")"),p.insert("rect",":first-child"),{shapeSvg:c,bbox:y,halfPadding:f,label:p}},S=(t,e)=>{let r=e.node().getBBox();t.width=r.width,t.height=r.height};function M(t,e,r,a){return t.insert("polygon",":first-child").attr("points",a.map(function(t){return t.x+","+t.y}).join(" ")).attr("class","label-container").attr("transform","translate("+-e/2+","+r/2+")")}function T(t,e,r,a){var i=t.x,n=t.y,l=i-a.x,s=n-a.y,d=Math.sqrt(e*e*s*s+r*r*l*l),o=Math.abs(e*r*l/d);a.x<i&&(o=-o);var h=Math.abs(e*r*s/d);return a.y<n&&(h=-h),{x:i+o,y:n+h}}let B=(t,e)=>{var r,a,i=t.x,n=t.y,l=e.x-i,s=e.y-n,d=t.width/2,o=t.height/2;return Math.abs(s)*d>Math.abs(l)*o?(s<0&&(o=-o),r=0===s?0:o*l/s,a=o):(l<0&&(d=-d),r=d,a=0===l?0:d*s/l),{x:i+r,y:n+a}},E=B,C={node:function(t,e){return t.intersect(e)},circle:function(t,e,r){return T(t,e,e,r)},ellipse:T,polygon:function(t,e,r){var a=t.x,i=t.y,n=[],l=Number.POSITIVE_INFINITY,s=Number.POSITIVE_INFINITY;"function"==typeof e.forEach?e.forEach(function(t){l=Math.min(l,t.x),s=Math.min(s,t.y)}):(l=Math.min(l,e.x),s=Math.min(s,e.y));for(var d=a-t.width/2-l,o=i-t.height/2-s,h=0;h<e.length;h++){var c=e[h],p=e[h<e.length-1?h+1:0],g=function(t,e,r,a){var i,n,l,s,d,o,h,c,p,g,y,f,u;if(i=e.y-t.y,l=t.x-e.x,d=e.x*t.y-t.x*e.y,p=i*r.x+l*r.y+d,g=i*a.x+l*a.y+d,(0===p||0===g||!(p*g>0))&&(n=a.y-r.y,s=r.x-a.x,o=a.x*r.y-r.x*a.y,h=n*t.x+s*t.y+o,c=n*e.x+s*e.y+o,!(0!==h&&0!==c&&h*c>0)&&0!=(y=i*s-n*l)))return f=Math.abs(y/2),{x:(u=l*o-s*d)<0?(u-f)/y:(u+f)/y,y:(u=n*d-i*o)<0?(u-f)/y:(u+f)/y}}(t,r,{x:d+c.x,y:o+c.y},{x:d+p.x,y:o+p.y});g&&n.push(g)}return n.length?(n.length>1&&n.sort(function(t,e){var a=t.x-r.x,i=t.y-r.y,n=Math.sqrt(a*a+i*i),l=e.x-r.x,s=e.y-r.y,d=Math.sqrt(l*l+s*s);return n<d?-1:n===d?0:1}),n[0]):t},rect:E},N=(t,e)=>{let r=e.useHtmlLabels||(0,a.g)().flowchart.htmlLabels;r||(e.centerLabel=!0);let{shapeSvg:i,bbox:n,halfPadding:l}=v(t,e,"node "+e.classes,!0);a.l.info("Classes = ",e.classes);let s=i.insert("rect",":first-child");return s.attr("rx",e.rx).attr("ry",e.ry).attr("x",-n.width/2-l).attr("y",-n.height/2-l).attr("width",n.width+e.padding).attr("height",n.height+e.padding),S(e,s),e.intersect=function(t){return C.rect(e,t)},i},Y=(t,e)=>{let{shapeSvg:r,bbox:i}=v(t,e,void 0,!0),n=i.width+e.padding,l=i.height+e.padding,s=n+l,d=[{x:s/2,y:0},{x:s,y:-s/2},{x:s/2,y:-s},{x:0,y:-s/2}];a.l.info("Question main (Circle)");let o=M(r,s,s,d);return o.attr("style",e.style),S(e,o),e.intersect=function(t){return a.l.warn("Intersect called"),C.polygon(e,d,t)},r},H=(t,e)=>{let r=t.insert("g").attr("class","node default").attr("id",e.domId||e.id),a=r.insert("polygon",":first-child").attr("points",[{x:0,y:14},{x:14,y:0},{x:0,y:-14},{x:-14,y:0}].map(function(t){return t.x+","+t.y}).join(" "));return a.attr("class","state-start").attr("r",7).attr("width",28).attr("height",28),e.width=28,e.height=28,e.intersect=function(t){return C.circle(e,14,t)},r},P=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.height+e.padding,n=i/4,l=a.width+2*n+e.padding,s=[{x:n,y:0},{x:l-n,y:0},{x:l,y:-i/2},{x:l-n,y:-i},{x:n,y:-i},{x:0,y:-i/2}],d=M(r,l,i,s);return d.attr("style",e.style),S(e,d),e.intersect=function(t){return C.polygon(e,s,t)},r},R=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.width+e.padding,n=a.height+e.padding,l=[{x:-n/2,y:0},{x:i,y:0},{x:i,y:-n},{x:-n/2,y:-n},{x:0,y:-n/2}],s=M(r,i,n,l);return s.attr("style",e.style),e.width=i+n,e.height=n,e.intersect=function(t){return C.polygon(e,l,t)},r},I=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.width+e.padding,n=a.height+e.padding,l=[{x:-2*n/6,y:0},{x:i-n/6,y:0},{x:i+2*n/6,y:-n},{x:n/6,y:-n}],s=M(r,i,n,l);return s.attr("style",e.style),S(e,s),e.intersect=function(t){return C.polygon(e,l,t)},r},O=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.width+e.padding,n=a.height+e.padding,l=[{x:2*n/6,y:0},{x:i+n/6,y:0},{x:i-2*n/6,y:-n},{x:-n/6,y:-n}],s=M(r,i,n,l);return s.attr("style",e.style),S(e,s),e.intersect=function(t){return C.polygon(e,l,t)},r},$=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.width+e.padding,n=a.height+e.padding,l=[{x:-2*n/6,y:0},{x:i+2*n/6,y:0},{x:i-n/6,y:-n},{x:n/6,y:-n}],s=M(r,i,n,l);return s.attr("style",e.style),S(e,s),e.intersect=function(t){return C.polygon(e,l,t)},r},_=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.width+e.padding,n=a.height+e.padding,l=[{x:n/6,y:0},{x:i-n/6,y:0},{x:i+2*n/6,y:-n},{x:-2*n/6,y:-n}],s=M(r,i,n,l);return s.attr("style",e.style),S(e,s),e.intersect=function(t){return C.polygon(e,l,t)},r},W=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.width+e.padding,n=a.height+e.padding,l=[{x:0,y:0},{x:i+n/2,y:0},{x:i,y:-n/2},{x:i+n/2,y:-n},{x:0,y:-n}],s=M(r,i,n,l);return s.attr("style",e.style),S(e,s),e.intersect=function(t){return C.polygon(e,l,t)},r},X=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.width+e.padding,n=i/2,l=n/(2.5+i/50),s=a.height+l+e.padding,d=r.attr("label-offset-y",l).insert("path",":first-child").attr("style",e.style).attr("d","M 0,"+l+" a "+n+","+l+" 0,0,0 "+i+" 0 a "+n+","+l+" 0,0,0 "+-i+" 0 l 0,"+s+" a "+n+","+l+" 0,0,0 "+i+" 0 l 0,"+-s).attr("transform","translate("+-i/2+","+-(s/2+l)+")");return S(e,d),e.intersect=function(t){let r=C.rect(e,t),a=r.x-e.x;if(0!=n&&(Math.abs(a)<e.width/2||Math.abs(a)==e.width/2&&Math.abs(r.y-e.y)>e.height/2-l)){let i=l*l*(1-a*a/(n*n));0!=i&&(i=Math.sqrt(i)),i=l-i,t.y-e.y>0&&(i=-i),r.y+=i}return r},r},A=(t,e)=>{let{shapeSvg:r,bbox:i,halfPadding:n}=v(t,e,"node "+e.classes,!0),l=r.insert("rect",":first-child"),s=i.width+e.padding,d=i.height+e.padding;if(l.attr("class","basic label-container").attr("style",e.style).attr("rx",e.rx).attr("ry",e.ry).attr("x",-i.width/2-n).attr("y",-i.height/2-n).attr("width",s).attr("height",d),e.props){let t=new Set(Object.keys(e.props));e.props.borders&&(j(l,e.props.borders,s,d),t.delete("borders")),t.forEach(t=>{a.l.warn(`Unknown node property ${t}`)})}return S(e,l),e.intersect=function(t){return C.rect(e,t)},r},D=(t,e)=>{let{shapeSvg:r}=v(t,e,"label",!0);a.l.trace("Classes = ",e.classes);let i=r.insert("rect",":first-child");if(i.attr("width",0).attr("height",0),r.attr("class","label edgeLabel"),e.props){let t=new Set(Object.keys(e.props));e.props.borders&&(j(i,e.props.borders,0,0),t.delete("borders")),t.forEach(t=>{a.l.warn(`Unknown node property ${t}`)})}return S(e,i),e.intersect=function(t){return C.rect(e,t)},r};function j(t,e,r,i){let n=[],l=t=>{n.push(t,0)},s=t=>{n.push(0,t)};e.includes("t")?(a.l.debug("add top border"),l(r)):s(r),e.includes("r")?(a.l.debug("add right border"),l(i)):s(i),e.includes("b")?(a.l.debug("add bottom border"),l(r)):s(r),e.includes("l")?(a.l.debug("add left border"),l(i)):s(i),t.attr("stroke-dasharray",n.join(" "))}let U=(t,e)=>{let r;r=e.classes?"node "+e.classes:"node default";let n=t.insert("g").attr("class",r).attr("id",e.domId||e.id),l=n.insert("rect",":first-child"),s=n.insert("line"),d=n.insert("g").attr("class","label"),o=e.labelText.flat?e.labelText.flat():e.labelText,h="";h="object"==typeof o?o[0]:o,a.l.info("Label text abc79",h,o,"object"==typeof o);let c=d.node().appendChild(L(h,e.labelStyle,!0,!0)),p={width:0,height:0};if((0,a.k)((0,a.g)().flowchart.htmlLabels)){let t=c.children[0],e=(0,i.Ys)(c);p=t.getBoundingClientRect(),e.attr("width",p.width),e.attr("height",p.height)}a.l.info("Text 2",o);let g=o.slice(1,o.length),y=c.getBBox(),f=d.node().appendChild(L(g.join?g.join("<br/>"):g,e.labelStyle,!0,!0));if((0,a.k)((0,a.g)().flowchart.htmlLabels)){let t=f.children[0],e=(0,i.Ys)(f);p=t.getBoundingClientRect(),e.attr("width",p.width),e.attr("height",p.height)}let u=e.padding/2;return(0,i.Ys)(f).attr("transform","translate( "+(p.width>y.width?0:(y.width-p.width)/2)+", "+(y.height+u+5)+")"),(0,i.Ys)(c).attr("transform","translate( "+(p.width<y.width?0:-(y.width-p.width)/2)+", 0)"),p=d.node().getBBox(),d.attr("transform","translate("+-p.width/2+", "+(-p.height/2-u+3)+")"),l.attr("class","outer title-state").attr("x",-p.width/2-u).attr("y",-p.height/2-u).attr("width",p.width+e.padding).attr("height",p.height+e.padding),s.attr("class","divider").attr("x1",-p.width/2-u).attr("x2",p.width/2+u).attr("y1",-p.height/2-u+y.height+u).attr("y2",-p.height/2-u+y.height+u),S(e,l),e.intersect=function(t){return C.rect(e,t)},n},Z=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.height+e.padding,n=a.width+i/4+e.padding,l=r.insert("rect",":first-child").attr("style",e.style).attr("rx",i/2).attr("ry",i/2).attr("x",-n/2).attr("y",-i/2).attr("width",n).attr("height",i);return S(e,l),e.intersect=function(t){return C.rect(e,t)},r},z=(t,e)=>{let{shapeSvg:r,bbox:i,halfPadding:n}=v(t,e,void 0,!0),l=r.insert("circle",":first-child");return l.attr("style",e.style).attr("rx",e.rx).attr("ry",e.ry).attr("r",i.width/2+n).attr("width",i.width+e.padding).attr("height",i.height+e.padding),a.l.info("Circle main"),S(e,l),e.intersect=function(t){return a.l.info("Circle intersect",e,i.width/2+n,t),C.circle(e,i.width/2+n,t)},r},q=(t,e)=>{let{shapeSvg:r,bbox:i,halfPadding:n}=v(t,e,void 0,!0),l=r.insert("g",":first-child"),s=l.insert("circle"),d=l.insert("circle");return s.attr("style",e.style).attr("rx",e.rx).attr("ry",e.ry).attr("r",i.width/2+n+5).attr("width",i.width+e.padding+10).attr("height",i.height+e.padding+10),d.attr("style",e.style).attr("rx",e.rx).attr("ry",e.ry).attr("r",i.width/2+n).attr("width",i.width+e.padding).attr("height",i.height+e.padding),a.l.info("DoubleCircle main"),S(e,s),e.intersect=function(t){return a.l.info("DoubleCircle intersect",e,i.width/2+n+5,t),C.circle(e,i.width/2+n+5,t)},r},J=(t,e)=>{let{shapeSvg:r,bbox:a}=v(t,e,void 0,!0),i=a.width+e.padding,n=a.height+e.padding,l=[{x:0,y:0},{x:i,y:0},{x:i,y:-n},{x:0,y:-n},{x:0,y:0},{x:-8,y:0},{x:i+8,y:0},{x:i+8,y:-n},{x:-8,y:-n},{x:-8,y:0}],s=M(r,i,n,l);return s.attr("style",e.style),S(e,s),e.intersect=function(t){return C.polygon(e,l,t)},r},G=(t,e)=>{let r=t.insert("g").attr("class","node default").attr("id",e.domId||e.id),a=r.insert("circle",":first-child");return a.attr("class","state-start").attr("r",7).attr("width",14).attr("height",14),S(e,a),e.intersect=function(t){return C.circle(e,7,t)},r},V=(t,e,r)=>{let a=t.insert("g").attr("class","node default").attr("id",e.domId||e.id),i=70,n=10;"LR"===r&&(i=10,n=70);let l=a.append("rect").attr("x",-1*i/2).attr("y",-1*n/2).attr("width",i).attr("height",n).attr("class","fork-join");return S(e,l),e.height=e.height+e.padding/2,e.width=e.width+e.padding/2,e.intersect=function(t){return C.rect(e,t)},a},Q=(t,e)=>{let r=t.insert("g").attr("class","node default").attr("id",e.domId||e.id),a=r.insert("circle",":first-child"),i=r.insert("circle",":first-child");return i.attr("class","state-start").attr("r",7).attr("width",14).attr("height",14),a.attr("class","state-end").attr("r",5).attr("width",10).attr("height",10),S(e,i),e.intersect=function(t){return C.circle(e,7,t)},r},F=(t,e)=>{let r;let n=e.padding/2;r=e.classes?"node "+e.classes:"node default";let l=t.insert("g").attr("class",r).attr("id",e.domId||e.id),d=l.insert("rect",":first-child"),o=l.insert("line"),h=l.insert("line"),c=0,p=4,g=l.insert("g").attr("class","label"),y=0,f=e.classData.annotations&&e.classData.annotations[0],u=e.classData.annotations[0]?"\xab"+e.classData.annotations[0]+"\xbb":"",x=g.node().appendChild(L(u,e.labelStyle,!0,!0)),w=x.getBBox();if((0,a.k)((0,a.g)().flowchart.htmlLabels)){let t=x.children[0],e=(0,i.Ys)(x);w=t.getBoundingClientRect(),e.attr("width",w.width),e.attr("height",w.height)}e.classData.annotations[0]&&(p+=w.height+4,c+=w.width);let b=e.classData.label;void 0!==e.classData.type&&""!==e.classData.type&&((0,a.g)().flowchart.htmlLabels?b+="&lt;"+e.classData.type+"&gt;":b+="<"+e.classData.type+">");let m=g.node().appendChild(L(b,e.labelStyle,!0,!0));(0,i.Ys)(m).attr("class","classTitle");let k=m.getBBox();if((0,a.k)((0,a.g)().flowchart.htmlLabels)){let t=m.children[0],e=(0,i.Ys)(m);k=t.getBoundingClientRect(),e.attr("width",k.width),e.attr("height",k.height)}p+=k.height+4,k.width>c&&(c=k.width);let v=[];e.classData.members.forEach(t=>{let r=(0,s.p)(t),n=r.displayText;(0,a.g)().flowchart.htmlLabels&&(n=n.replace(/</g,"&lt;").replace(/>/g,"&gt;"));let l=g.node().appendChild(L(n,r.cssStyle?r.cssStyle:e.labelStyle,!0,!0)),d=l.getBBox();if((0,a.k)((0,a.g)().flowchart.htmlLabels)){let t=l.children[0],e=(0,i.Ys)(l);d=t.getBoundingClientRect(),e.attr("width",d.width),e.attr("height",d.height)}d.width>c&&(c=d.width),p+=d.height+4,v.push(l)}),p+=8;let M=[];if(e.classData.methods.forEach(t=>{let r=(0,s.p)(t),n=r.displayText;(0,a.g)().flowchart.htmlLabels&&(n=n.replace(/</g,"&lt;").replace(/>/g,"&gt;"));let l=g.node().appendChild(L(n,r.cssStyle?r.cssStyle:e.labelStyle,!0,!0)),d=l.getBBox();if((0,a.k)((0,a.g)().flowchart.htmlLabels)){let t=l.children[0],e=(0,i.Ys)(l);d=t.getBoundingClientRect(),e.attr("width",d.width),e.attr("height",d.height)}d.width>c&&(c=d.width),p+=d.height+4,M.push(l)}),p+=8,f){let t=(c-w.width)/2;(0,i.Ys)(x).attr("transform","translate( "+(-1*c/2+t)+", "+-1*p/2+")"),y=w.height+4}let T=(c-k.width)/2;return(0,i.Ys)(m).attr("transform","translate( "+(-1*c/2+T)+", "+(-1*p/2+y)+")"),y+=k.height+4,o.attr("class","divider").attr("x1",-c/2-n).attr("x2",c/2+n).attr("y1",-p/2-n+8+y).attr("y2",-p/2-n+8+y),y+=8,v.forEach(t=>{(0,i.Ys)(t).attr("transform","translate( "+-c/2+", "+(-1*p/2+y+4)+")"),y+=k.height+4}),y+=8,h.attr("class","divider").attr("x1",-c/2-n).attr("x2",c/2+n).attr("y1",-p/2-n+8+y).attr("y2",-p/2-n+8+y),y+=8,M.forEach(t=>{(0,i.Ys)(t).attr("transform","translate( "+-c/2+", "+(-1*p/2+y)+")"),y+=k.height+4}),d.attr("class","outer title-state").attr("x",-c/2-n).attr("y",-(p/2)-n).attr("width",c+e.padding).attr("height",p+e.padding),S(e,d),e.intersect=function(t){return C.rect(e,t)},l},K={rhombus:Y,question:Y,rect:A,labelRect:D,rectWithTitle:U,choice:H,circle:z,doublecircle:q,stadium:Z,hexagon:P,rect_left_inv_arrow:R,lean_right:I,lean_left:O,trapezoid:$,inv_trapezoid:_,rect_right_inv_arrow:W,cylinder:X,start:G,end:Q,note:N,subroutine:J,fork:V,join:V,class_box:F},tt={},te=(t,e,r)=>{let i,n;if(e.link){let l;"sandbox"===(0,a.g)().securityLevel?l="_top":e.linkTarget&&(l=e.linkTarget||"_blank"),i=t.insert("svg:a").attr("xlink:href",e.link).attr("target",l),n=K[e.shape](i,e,r)}else i=n=K[e.shape](t,e,r);return e.tooltip&&n.attr("title",e.tooltip),e.class&&n.attr("class","node default "+e.class),tt[e.id]=i,e.haveCallback&&tt[e.id].attr("class",tt[e.id].attr("class")+" clickable"),i},tr=(t,e)=>{tt[e.id]=t},ta=()=>{tt={}},ti=t=>{let e=tt[t.id];a.l.trace("Transforming node",t.diff,t,"translate("+(t.x-t.width/2-5)+", "+t.width/2+")");let r=t.diff||0;return t.clusterNode?e.attr("transform","translate("+(t.x+r-t.width/2)+", "+(t.y-t.height/2-8)+")"):e.attr("transform","translate("+t.x+", "+t.y+")"),r},tn={},tl={},ts=()=>{tn={},tl={}},td=(t,e)=>{let r;let l=(0,a.k)((0,a.g)().flowchart.htmlLabels),s="markdown"===e.labelType?(0,n.c)(t,e.label,{style:e.labelStyle,useHtmlLabels:l,addSvgBackground:!0}):L(e.label,e.labelStyle);a.l.info("abc82",e,e.labelType);let d=t.insert("g").attr("class","edgeLabel"),o=d.insert("g").attr("class","label");o.node().appendChild(s);let h=s.getBBox();if(l){let t=s.children[0],e=(0,i.Ys)(s);h=t.getBoundingClientRect(),e.attr("width",h.width),e.attr("height",h.height)}if(o.attr("transform","translate("+-h.width/2+", "+-h.height/2+")"),tn[e.id]=d,e.width=h.width,e.height=h.height,e.startLabelLeft){let a=L(e.startLabelLeft,e.labelStyle),i=t.insert("g").attr("class","edgeTerminals"),n=i.insert("g").attr("class","inner");r=n.node().appendChild(a);let l=a.getBBox();n.attr("transform","translate("+-l.width/2+", "+-l.height/2+")"),tl[e.id]||(tl[e.id]={}),tl[e.id].startLeft=i,to(r,e.startLabelLeft)}if(e.startLabelRight){let a=L(e.startLabelRight,e.labelStyle),i=t.insert("g").attr("class","edgeTerminals"),n=i.insert("g").attr("class","inner");r=i.node().appendChild(a),n.node().appendChild(a);let l=a.getBBox();n.attr("transform","translate("+-l.width/2+", "+-l.height/2+")"),tl[e.id]||(tl[e.id]={}),tl[e.id].startRight=i,to(r,e.startLabelRight)}if(e.endLabelLeft){let a=L(e.endLabelLeft,e.labelStyle),i=t.insert("g").attr("class","edgeTerminals"),n=i.insert("g").attr("class","inner");r=n.node().appendChild(a);let l=a.getBBox();n.attr("transform","translate("+-l.width/2+", "+-l.height/2+")"),i.node().appendChild(a),tl[e.id]||(tl[e.id]={}),tl[e.id].endLeft=i,to(r,e.endLabelLeft)}if(e.endLabelRight){let a=L(e.endLabelRight,e.labelStyle),i=t.insert("g").attr("class","edgeTerminals"),n=i.insert("g").attr("class","inner");r=n.node().appendChild(a);let l=a.getBBox();n.attr("transform","translate("+-l.width/2+", "+-l.height/2+")"),i.node().appendChild(a),tl[e.id]||(tl[e.id]={}),tl[e.id].endRight=i,to(r,e.endLabelRight)}return s};function to(t,e){(0,a.g)().flowchart.htmlLabels&&t&&(t.style.width=9*e.length+"px",t.style.height="12px")}let th=(t,e)=>{a.l.info("Moving label abc78 ",t.id,t.label,tn[t.id]);let r=e.updatedPath?e.updatedPath:e.originalPath;if(t.label){let i=tn[t.id],n=t.x,l=t.y;if(r){let i=d.u.calcLabelPosition(r);a.l.info("Moving label "+t.label+" from (",n,",",l,") to (",i.x,",",i.y,") abc78"),e.updatedPath&&(n=i.x,l=i.y)}i.attr("transform","translate("+n+", "+l+")")}if(t.startLabelLeft){let e=tl[t.id].startLeft,a=t.x,i=t.y;if(r){let e=d.u.calcTerminalLabelPosition(t.arrowTypeStart?10:0,"start_left",r);a=e.x,i=e.y}e.attr("transform","translate("+a+", "+i+")")}if(t.startLabelRight){let e=tl[t.id].startRight,a=t.x,i=t.y;if(r){let e=d.u.calcTerminalLabelPosition(t.arrowTypeStart?10:0,"start_right",r);a=e.x,i=e.y}e.attr("transform","translate("+a+", "+i+")")}if(t.endLabelLeft){let e=tl[t.id].endLeft,a=t.x,i=t.y;if(r){let e=d.u.calcTerminalLabelPosition(t.arrowTypeEnd?10:0,"end_left",r);a=e.x,i=e.y}e.attr("transform","translate("+a+", "+i+")")}if(t.endLabelRight){let e=tl[t.id].endRight,a=t.x,i=t.y;if(r){let e=d.u.calcTerminalLabelPosition(t.arrowTypeEnd?10:0,"end_right",r);a=e.x,i=e.y}e.attr("transform","translate("+a+", "+i+")")}},tc=(t,e)=>{let r=t.x,a=t.y,i=Math.abs(e.x-r),n=Math.abs(e.y-a),l=t.width/2,s=t.height/2;return i>=l||n>=s},tp=(t,e,r)=>{a.l.warn(`intersection calc abc89:
  outsidePoint: ${JSON.stringify(e)}
  insidePoint : ${JSON.stringify(r)}
  node        : x:${t.x} y:${t.y} w:${t.width} h:${t.height}`);let i=t.x,n=t.y,l=Math.abs(i-r.x),s=t.width/2,d=r.x<e.x?s-l:s+l,o=t.height/2,h=Math.abs(e.y-r.y),c=Math.abs(e.x-r.x);if(Math.abs(n-e.y)*s>Math.abs(i-e.x)*o){let t=r.y<e.y?e.y-o-n:n-o-e.y;d=c*t/h;let i={x:r.x<e.x?r.x+d:r.x-c+d,y:r.y<e.y?r.y+h-t:r.y-h+t};return 0===d&&(i.x=e.x,i.y=e.y),0===c&&(i.x=e.x),0===h&&(i.y=e.y),a.l.warn(`abc89 topp/bott calc, Q ${h}, q ${t}, R ${c}, r ${d}`,i),i}{let t=h*(d=r.x<e.x?e.x-s-i:i-s-e.x)/c,n=r.x<e.x?r.x+c-d:r.x-c+d,l=r.y<e.y?r.y+t:r.y-t;return a.l.warn(`sides calc abc89, Q ${h}, q ${t}, R ${c}, r ${d}`,{_x:n,_y:l}),0===d&&(n=e.x,l=e.y),0===c&&(n=e.x),0===h&&(l=e.y),{x:n,y:l}}},tg=(t,e)=>{a.l.warn("abc88 cutPathAtIntersect",t,e);let r=[],i=t[0],n=!1;return t.forEach(t=>{if(a.l.info("abc88 checking point",t,e),tc(e,t)||n)a.l.warn("abc88 outside",t,i),i=t,n||r.push(t);else{let l=tp(e,i,t);a.l.warn("abc88 inside",t,i,l),a.l.warn("abc88 intersection",l);let s=!1;r.forEach(t=>{s=s||t.x===l.x&&t.y===l.y}),r.some(t=>t.x===l.x&&t.y===l.y)?a.l.warn("abc88 no intersect",l,r):r.push(l),n=!0}}),a.l.warn("abc88 returning points",r),r},ty=function(t,e,r,n,l,s){let d,o,h=r.points,c=!1,p=s.node(e.v);var g=s.node(e.w);a.l.info("abc88 InsertEdge: ",r),g.intersect&&p.intersect&&((h=h.slice(1,r.points.length-1)).unshift(p.intersect(h[0])),a.l.info("Last point",h[h.length-1],g,g.intersect(h[h.length-1])),h.push(g.intersect(h[h.length-1]))),r.toCluster&&(a.l.info("to cluster abc88",n[r.toCluster]),h=tg(r.points,n[r.toCluster].node),c=!0),r.fromCluster&&(a.l.info("from cluster abc88",n[r.fromCluster]),h=tg(h.reverse(),n[r.fromCluster].node).reverse(),c=!0);let y=h.filter(t=>!Number.isNaN(t.y));d=("graph"===l||"flowchart"===l)&&r.curve||i.$0Z;let f=(0,i.jvg)().x(function(t){return t.x}).y(function(t){return t.y}).curve(d);switch(r.thickness){case"normal":o="edge-thickness-normal";break;case"thick":case"invisible":o="edge-thickness-thick";break;default:o=""}switch(r.pattern){case"solid":o+=" edge-pattern-solid";break;case"dotted":o+=" edge-pattern-dotted";break;case"dashed":o+=" edge-pattern-dashed"}let u=t.append("path").attr("d",f(y)).attr("id",r.id).attr("class"," "+o+(r.classes?" "+r.classes:"")).attr("style",r.style),x="";switch(((0,a.g)().flowchart.arrowMarkerAbsolute||(0,a.g)().state.arrowMarkerAbsolute)&&(x=(x=(x=window.location.protocol+"//"+window.location.host+window.location.pathname+window.location.search).replace(/\(/g,"\\(")).replace(/\)/g,"\\)")),a.l.info("arrowTypeStart",r.arrowTypeStart),a.l.info("arrowTypeEnd",r.arrowTypeEnd),r.arrowTypeStart){case"arrow_cross":u.attr("marker-start","url("+x+"#"+l+"-crossStart)");break;case"arrow_point":u.attr("marker-start","url("+x+"#"+l+"-pointStart)");break;case"arrow_barb":u.attr("marker-start","url("+x+"#"+l+"-barbStart)");break;case"arrow_circle":u.attr("marker-start","url("+x+"#"+l+"-circleStart)");break;case"aggregation":u.attr("marker-start","url("+x+"#"+l+"-aggregationStart)");break;case"extension":u.attr("marker-start","url("+x+"#"+l+"-extensionStart)");break;case"composition":u.attr("marker-start","url("+x+"#"+l+"-compositionStart)");break;case"dependency":u.attr("marker-start","url("+x+"#"+l+"-dependencyStart)");break;case"lollipop":u.attr("marker-start","url("+x+"#"+l+"-lollipopStart)")}switch(r.arrowTypeEnd){case"arrow_cross":u.attr("marker-end","url("+x+"#"+l+"-crossEnd)");break;case"arrow_point":u.attr("marker-end","url("+x+"#"+l+"-pointEnd)");break;case"arrow_barb":u.attr("marker-end","url("+x+"#"+l+"-barbEnd)");break;case"arrow_circle":u.attr("marker-end","url("+x+"#"+l+"-circleEnd)");break;case"aggregation":u.attr("marker-end","url("+x+"#"+l+"-aggregationEnd)");break;case"extension":u.attr("marker-end","url("+x+"#"+l+"-extensionEnd)");break;case"composition":u.attr("marker-end","url("+x+"#"+l+"-compositionEnd)");break;case"dependency":u.attr("marker-end","url("+x+"#"+l+"-dependencyEnd)");break;case"lollipop":u.attr("marker-end","url("+x+"#"+l+"-lollipopEnd)")}let w={};return c&&(w.updatedPath=h),w.originalPath=r.points,w}},7657:function(t,e,r){r.d(e,{p:function(){return s},s:function(){return g}});var a=r(9373),i=r(1188),n=r(44);let l=0,s=function(t){let e=t.match(/^([#+~-])?(\w+)(~\w+~|\[])?\s+(\w+) *([$*])?$/),r=t.match(/^([#+|~-])?(\w+) *\( *(.*)\) *([$*])? *(\w*[[\]|~]*\s*\w*~?)$/);return e&&!r?d(e):r?o(r):h(t)},d=function(t){let e="",r="";try{let a=t[1]?t[1].trim():"",i=t[2]?t[2].trim():"",l=t[3]?(0,n.z)(t[3].trim()):"",s=t[4]?t[4].trim():"",d=t[5]?t[5].trim():"";r=a+i+l+" "+s,e=p(d)}catch(e){r=t}return{displayText:r,cssStyle:e}},o=function(t){let e="",r="";try{let a=t[1]?t[1].trim():"",i=t[2]?t[2].trim():"",l=t[3]?(0,n.z)(t[3].trim()):"",s=t[4]?t[4].trim():"",d=t[5]?" : "+(0,n.z)(t[5]).trim():"";r=a+i+"("+l+")"+d,e=p(s)}catch(e){r=t}return{displayText:r,cssStyle:e}},h=function(t){let e="",r="",a="",i=t.indexOf("("),l=t.indexOf(")");if(i>1&&l>i&&l<=t.length){let s="",d="",o=t.substring(0,1);o.match(/\w/)?d=t.substring(0,i).trim():(o.match(/[#+~-]/)&&(s=o),d=t.substring(1,i).trim());let h=t.substring(i+1,l);t.substring(l+1,1),r=p(t.substring(l+1,l+2)),e=s+d+"("+(0,n.z)(h.trim())+")",l<t.length&&""!==(a=t.substring(l+2).trim())&&(e+=a=" : "+(0,n.z)(a))}else e=(0,n.z)(t);return{displayText:e,cssStyle:r}},c=function(t,e,r,a){let i=s(e),n=t.append("tspan").attr("x",a.padding).text(i.displayText);""!==i.cssStyle&&n.attr("style",i.cssStyle),r||n.attr("dy",a.textHeight)},p=function(t){switch(t){case"*":return"font-style:italic;";case"$":return"text-decoration:underline;";default:return""}},g={drawClass:function(t,e,r,a){let i;n.l.debug("Rendering class ",e,r);let l=e.id,s={id:l,label:e.id,width:0,height:0},d=t.append("g").attr("id",a.db.lookUpDomId(l)).attr("class","classGroup");i=e.link?d.append("svg:a").attr("xlink:href",e.link).attr("target",e.linkTarget).append("text").attr("y",r.textHeight+r.padding).attr("x",0):d.append("text").attr("y",r.textHeight+r.padding).attr("x",0);let o=!0;e.annotations.forEach(function(t){let e=i.append("tspan").text("\xab"+t+"\xbb");o||e.attr("dy",r.textHeight),o=!1});let h=e.id;void 0!==e.type&&""!==e.type&&(h+="<"+e.type+">");let p=i.append("tspan").text(h).attr("class","title");o||p.attr("dy",r.textHeight);let g=i.node().getBBox().height,y=d.append("line").attr("x1",0).attr("y1",r.padding+g+r.dividerMargin/2).attr("y2",r.padding+g+r.dividerMargin/2),f=d.append("text").attr("x",r.padding).attr("y",g+r.dividerMargin+r.textHeight).attr("fill","white").attr("class","classText");o=!0,e.members.forEach(function(t){c(f,t,o,r),o=!1});let u=f.node().getBBox(),x=d.append("line").attr("x1",0).attr("y1",r.padding+g+r.dividerMargin+u.height).attr("y2",r.padding+g+r.dividerMargin+u.height),w=d.append("text").attr("x",r.padding).attr("y",g+2*r.dividerMargin+u.height+r.textHeight).attr("fill","white").attr("class","classText");o=!0,e.methods.forEach(function(t){c(w,t,o,r),o=!1});let b=d.node().getBBox();var m=" ";e.cssClasses.length>0&&(m+=e.cssClasses.join(" "));let k=d.insert("rect",":first-child").attr("x",0).attr("y",0).attr("width",b.width+2*r.padding).attr("height",b.height+r.padding+.5*r.dividerMargin).attr("class",m),L=k.node().getBBox().width;return i.node().childNodes.forEach(function(t){t.setAttribute("x",(L-t.getBBox().width)/2)}),e.tooltip&&i.insert("title").text(e.tooltip),y.attr("x2",L),x.attr("x2",L),s.width=L,s.height=b.height+r.padding+.5*r.dividerMargin,s},drawEdge:function(t,e,r,s,d){let o,h,c,p,g,y;let f=function(t){switch(t){case d.db.relationType.AGGREGATION:return"aggregation";case d.db.relationType.EXTENSION:return"extension";case d.db.relationType.COMPOSITION:return"composition";case d.db.relationType.DEPENDENCY:return"dependency";case d.db.relationType.LOLLIPOP:return"lollipop"}};e.points=e.points.filter(t=>!Number.isNaN(t.y));let u=e.points,x=(0,a.jvg)().x(function(t){return t.x}).y(function(t){return t.y}).curve(a.$0Z),w=t.append("path").attr("d",x(u)).attr("id","edge"+l).attr("class","relation"),b="";s.arrowMarkerAbsolute&&(b=(b=(b=window.location.protocol+"//"+window.location.host+window.location.pathname+window.location.search).replace(/\(/g,"\\(")).replace(/\)/g,"\\)")),1==r.relation.lineType&&w.attr("class","relation dashed-line"),10==r.relation.lineType&&w.attr("class","relation dotted-line"),"none"!==r.relation.type1&&w.attr("marker-start","url("+b+"#"+f(r.relation.type1)+"Start)"),"none"!==r.relation.type2&&w.attr("marker-end","url("+b+"#"+f(r.relation.type2)+"End)");let m=e.points.length,k=i.u.calcLabelPosition(e.points);if(o=k.x,h=k.y,m%2!=0&&m>1){let t=i.u.calcCardinalityPosition("none"!==r.relation.type1,e.points,e.points[0]),a=i.u.calcCardinalityPosition("none"!==r.relation.type2,e.points,e.points[m-1]);n.l.debug("cardinality_1_point "+JSON.stringify(t)),n.l.debug("cardinality_2_point "+JSON.stringify(a)),c=t.x,p=t.y,g=a.x,y=a.y}if(void 0!==r.title){let e=t.append("g").attr("class","classLabel"),a=e.append("text").attr("class","label").attr("x",o).attr("y",h).attr("fill","red").attr("text-anchor","middle").text(r.title);window.label=a;let i=a.node().getBBox();e.insert("rect",":first-child").attr("class","box").attr("x",i.x-s.padding/2).attr("y",i.y-s.padding/2).attr("width",i.width+s.padding).attr("height",i.height+s.padding)}if(n.l.info("Rendering relation "+JSON.stringify(r)),void 0!==r.relationTitle1&&"none"!==r.relationTitle1){let e=t.append("g").attr("class","cardinality");e.append("text").attr("class","type1").attr("x",c).attr("y",p).attr("fill","black").attr("font-size","6").text(r.relationTitle1)}if(void 0!==r.relationTitle2&&"none"!==r.relationTitle2){let e=t.append("g").attr("class","cardinality");e.append("text").attr("class","type2").attr("x",g).attr("y",y).attr("fill","black").attr("font-size","6").text(r.relationTitle2)}l++},drawNote:function(t,e,r,a){n.l.debug("Rendering note ",e,r);let i=e.id,l={id:i,text:e.text,width:0,height:0},s=t.append("g").attr("id",i).attr("class","classGroup"),d=s.append("text").attr("y",r.textHeight+r.padding).attr("x",0),o=JSON.parse(`"${e.text}"`).split("\n");o.forEach(function(t){n.l.debug(`Adding line: ${t}`),d.append("tspan").text(t).attr("class","title").attr("dy",r.textHeight)});let h=s.node().getBBox(),c=s.insert("rect",":first-child").attr("x",0).attr("y",0).attr("width",h.width+2*r.padding).attr("height",h.height+o.length*r.textHeight+r.padding+.5*r.dividerMargin),p=c.node().getBBox().width;return d.node().childNodes.forEach(function(t){t.setAttribute("x",(p-t.getBBox().width)/2)}),l.width=p,l.height=h.height+o.length*r.textHeight+r.padding+.5*r.dividerMargin,l},parseMember:s}}}]);
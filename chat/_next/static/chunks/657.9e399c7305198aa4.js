"use strict";(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[657],{3132:function(t,e,r){r.r(e),r.d(e,{diagram:function(){return S}});var i=r(44),a=r(3047),n=r(5625),s=r(9373),o=r(2494),l=r(1188);let c=[];for(let t=0;t<256;++t)c.push((t+256).toString(16).slice(1));var h=/^(?:[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}|00000000-0000-0000-0000-000000000000)$/i,d=function(t){let e;if(!("string"==typeof t&&h.test(t)))throw TypeError("Invalid UUID");let r=new Uint8Array(16);return r[0]=(e=parseInt(t.slice(0,8),16))>>>24,r[1]=e>>>16&255,r[2]=e>>>8&255,r[3]=255&e,r[4]=(e=parseInt(t.slice(9,13),16))>>>8,r[5]=255&e,r[6]=(e=parseInt(t.slice(14,18),16))>>>8,r[7]=255&e,r[8]=(e=parseInt(t.slice(19,23),16))>>>8,r[9]=255&e,r[10]=(e=parseInt(t.slice(24,36),16))/1099511627776&255,r[11]=e/4294967296&255,r[12]=e>>>24&255,r[13]=e>>>16&255,r[14]=e>>>8&255,r[15]=255&e,r};function y(t,e){return t<<e|t>>>32-e}let u=function(t,e,r){function i(t,e,i,a){var n;if("string"==typeof t&&(t=function(t){t=unescape(encodeURIComponent(t));let e=[];for(let r=0;r<t.length;++r)e.push(t.charCodeAt(r));return e}(t)),"string"==typeof e&&(e=d(e)),(null===(n=e)||void 0===n?void 0:n.length)!==16)throw TypeError("Namespace must be array-like (16 iterable integer values, 0-255)");let s=new Uint8Array(16+t.length);if(s.set(e),s.set(t,e.length),(s=r(s))[6]=15&s[6]|80,s[8]=63&s[8]|128,i){a=a||0;for(let t=0;t<16;++t)i[a+t]=s[t];return i}return function(t,e=0){return(c[t[e+0]]+c[t[e+1]]+c[t[e+2]]+c[t[e+3]]+"-"+c[t[e+4]]+c[t[e+5]]+"-"+c[t[e+6]]+c[t[e+7]]+"-"+c[t[e+8]]+c[t[e+9]]+"-"+c[t[e+10]]+c[t[e+11]]+c[t[e+12]]+c[t[e+13]]+c[t[e+14]]+c[t[e+15]]).toLowerCase()}(s)}try{i.name="v5"}catch(t){}return i.DNS="6ba7b810-9dad-11d1-80b4-00c04fd430c8",i.URL="6ba7b811-9dad-11d1-80b4-00c04fd430c8",i}(0,0,function(t){let e=[1518500249,1859775393,2400959708,3395469782],r=[1732584193,4023233417,2562383102,271733878,3285377520];if("string"==typeof t){let e=unescape(encodeURIComponent(t));t=[];for(let r=0;r<e.length;++r)t.push(e.charCodeAt(r))}else Array.isArray(t)||(t=Array.prototype.slice.call(t));t.push(128);let i=t.length/4+2,a=Math.ceil(i/16),n=Array(a);for(let e=0;e<a;++e){let r=new Uint32Array(16);for(let i=0;i<16;++i)r[i]=t[64*e+4*i]<<24|t[64*e+4*i+1]<<16|t[64*e+4*i+2]<<8|t[64*e+4*i+3];n[e]=r}n[a-1][14]=(t.length-1)*8/4294967296,n[a-1][14]=Math.floor(n[a-1][14]),n[a-1][15]=(t.length-1)*8&4294967295;for(let t=0;t<a;++t){let i=new Uint32Array(80);for(let e=0;e<16;++e)i[e]=n[t][e];for(let t=16;t<80;++t)i[t]=y(i[t-3]^i[t-8]^i[t-14]^i[t-16],1);let a=r[0],s=r[1],o=r[2],l=r[3],c=r[4];for(let t=0;t<80;++t){let r=Math.floor(t/20),n=y(a,5)+function(t,e,r,i){switch(t){case 0:return e&r^~e&i;case 1:case 3:return e^r^i;case 2:return e&r^e&i^r&i}}(r,s,o,l)+c+e[r]+i[t]>>>0;c=l,l=o,o=y(s,30)>>>0,s=a,a=n}r[0]=r[0]+a>>>0,r[1]=r[1]+s>>>0,r[2]=r[2]+o>>>0,r[3]=r[3]+l>>>0,r[4]=r[4]+c>>>0}return[r[0]>>24&255,r[0]>>16&255,r[0]>>8&255,255&r[0],r[1]>>24&255,r[1]>>16&255,r[1]>>8&255,255&r[1],r[2]>>24&255,r[2]>>16&255,r[2]>>8&255,255&r[2],r[3]>>24&255,r[3]>>16&255,r[3]>>8&255,255&r[3],r[4]>>24&255,r[4]>>16&255,r[4]>>8&255,255&r[4]]});r(7856),r(7484),r(7967);var p=function(){var t=function(t,e,r,i){for(r=r||{},i=t.length;i--;r[t[i]]=e);return r},e=[1,2],r=[1,5],i=[6,9,11,23,25,27,29,30,31,51],a=[1,17],n=[1,18],s=[1,19],o=[1,20],l=[1,21],c=[1,22],h=[1,25],d=[1,30],y=[1,31],u=[1,32],p=[1,33],_=[6,9,11,15,20,23,25,27,29,30,31,44,45,46,47,51],f=[1,45],g=[30,31,48,49],m=[4,6,9,11,23,25,27,29,30,31,51],E=[44,45,46,47],O=[22,37],b=[1,65],k=[1,64],R=[22,37,39,41],N={trace:function(){},yy:{},symbols_:{error:2,start:3,ER_DIAGRAM:4,document:5,EOF:6,directive:7,line:8,SPACE:9,statement:10,NEWLINE:11,openDirective:12,typeDirective:13,closeDirective:14,":":15,argDirective:16,entityName:17,relSpec:18,role:19,BLOCK_START:20,attributes:21,BLOCK_STOP:22,title:23,title_value:24,acc_title:25,acc_title_value:26,acc_descr:27,acc_descr_value:28,acc_descr_multiline_value:29,ALPHANUM:30,ENTITY_NAME:31,attribute:32,attributeType:33,attributeName:34,attributeKeyTypeList:35,attributeComment:36,ATTRIBUTE_WORD:37,attributeKeyType:38,COMMA:39,ATTRIBUTE_KEY:40,COMMENT:41,cardinality:42,relType:43,ZERO_OR_ONE:44,ZERO_OR_MORE:45,ONE_OR_MORE:46,ONLY_ONE:47,NON_IDENTIFYING:48,IDENTIFYING:49,WORD:50,open_directive:51,type_directive:52,arg_directive:53,close_directive:54,$accept:0,$end:1},terminals_:{2:"error",4:"ER_DIAGRAM",6:"EOF",9:"SPACE",11:"NEWLINE",15:":",20:"BLOCK_START",22:"BLOCK_STOP",23:"title",24:"title_value",25:"acc_title",26:"acc_title_value",27:"acc_descr",28:"acc_descr_value",29:"acc_descr_multiline_value",30:"ALPHANUM",31:"ENTITY_NAME",37:"ATTRIBUTE_WORD",39:"COMMA",40:"ATTRIBUTE_KEY",41:"COMMENT",44:"ZERO_OR_ONE",45:"ZERO_OR_MORE",46:"ONE_OR_MORE",47:"ONLY_ONE",48:"NON_IDENTIFYING",49:"IDENTIFYING",50:"WORD",51:"open_directive",52:"type_directive",53:"arg_directive",54:"close_directive"},productions_:[0,[3,3],[3,2],[5,0],[5,2],[8,2],[8,1],[8,1],[8,1],[7,4],[7,6],[10,1],[10,5],[10,4],[10,3],[10,1],[10,2],[10,2],[10,2],[10,1],[17,1],[17,1],[21,1],[21,2],[32,2],[32,3],[32,3],[32,4],[33,1],[34,1],[35,1],[35,3],[38,1],[36,1],[18,3],[42,1],[42,1],[42,1],[42,1],[43,1],[43,1],[19,1],[19,1],[19,1],[12,1],[13,1],[16,1],[14,1]],performAction:function(t,e,r,i,a,n,s){var o=n.length-1;switch(a){case 1:break;case 3:case 7:case 8:this.$=[];break;case 4:n[o-1].push(n[o]),this.$=n[o-1];break;case 5:case 6:case 20:case 43:case 28:case 29:case 32:this.$=n[o];break;case 12:i.addEntity(n[o-4]),i.addEntity(n[o-2]),i.addRelationship(n[o-4],n[o],n[o-2],n[o-3]);break;case 13:i.addEntity(n[o-3]),i.addAttributes(n[o-3],n[o-1]);break;case 14:i.addEntity(n[o-2]);break;case 15:i.addEntity(n[o]);break;case 16:case 17:this.$=n[o].trim(),i.setAccTitle(this.$);break;case 18:case 19:this.$=n[o].trim(),i.setAccDescription(this.$);break;case 21:case 41:case 42:case 33:this.$=n[o].replace(/"/g,"");break;case 22:case 30:this.$=[n[o]];break;case 23:n[o].push(n[o-1]),this.$=n[o];break;case 24:this.$={attributeType:n[o-1],attributeName:n[o]};break;case 25:this.$={attributeType:n[o-2],attributeName:n[o-1],attributeKeyTypeList:n[o]};break;case 26:this.$={attributeType:n[o-2],attributeName:n[o-1],attributeComment:n[o]};break;case 27:this.$={attributeType:n[o-3],attributeName:n[o-2],attributeKeyTypeList:n[o-1],attributeComment:n[o]};break;case 31:n[o-2].push(n[o]),this.$=n[o-2];break;case 34:this.$={cardA:n[o],relType:n[o-1],cardB:n[o-2]};break;case 35:this.$=i.Cardinality.ZERO_OR_ONE;break;case 36:this.$=i.Cardinality.ZERO_OR_MORE;break;case 37:this.$=i.Cardinality.ONE_OR_MORE;break;case 38:this.$=i.Cardinality.ONLY_ONE;break;case 39:this.$=i.Identification.NON_IDENTIFYING;break;case 40:this.$=i.Identification.IDENTIFYING;break;case 44:i.parseDirective("%%{","open_directive");break;case 45:i.parseDirective(n[o],"type_directive");break;case 46:n[o]=n[o].trim().replace(/'/g,'"'),i.parseDirective(n[o],"arg_directive");break;case 47:i.parseDirective("}%%","close_directive","er")}},table:[{3:1,4:e,7:3,12:4,51:r},{1:[3]},t(i,[2,3],{5:6}),{3:7,4:e,7:3,12:4,51:r},{13:8,52:[1,9]},{52:[2,44]},{6:[1,10],7:15,8:11,9:[1,12],10:13,11:[1,14],12:4,17:16,23:a,25:n,27:s,29:o,30:l,31:c,51:r},{1:[2,2]},{14:23,15:[1,24],54:h},t([15,54],[2,45]),t(i,[2,8],{1:[2,1]}),t(i,[2,4]),{7:15,10:26,12:4,17:16,23:a,25:n,27:s,29:o,30:l,31:c,51:r},t(i,[2,6]),t(i,[2,7]),t(i,[2,11]),t(i,[2,15],{18:27,42:29,20:[1,28],44:d,45:y,46:u,47:p}),{24:[1,34]},{26:[1,35]},{28:[1,36]},t(i,[2,19]),t(_,[2,20]),t(_,[2,21]),{11:[1,37]},{16:38,53:[1,39]},{11:[2,47]},t(i,[2,5]),{17:40,30:l,31:c},{21:41,22:[1,42],32:43,33:44,37:f},{43:46,48:[1,47],49:[1,48]},t(g,[2,35]),t(g,[2,36]),t(g,[2,37]),t(g,[2,38]),t(i,[2,16]),t(i,[2,17]),t(i,[2,18]),t(m,[2,9]),{14:49,54:h},{54:[2,46]},{15:[1,50]},{22:[1,51]},t(i,[2,14]),{21:52,22:[2,22],32:43,33:44,37:f},{34:53,37:[1,54]},{37:[2,28]},{42:55,44:d,45:y,46:u,47:p},t(E,[2,39]),t(E,[2,40]),{11:[1,56]},{19:57,30:[1,60],31:[1,59],50:[1,58]},t(i,[2,13]),{22:[2,23]},t(O,[2,24],{35:61,36:62,38:63,40:b,41:k}),t([22,37,40,41],[2,29]),t([30,31],[2,34]),t(m,[2,10]),t(i,[2,12]),t(i,[2,41]),t(i,[2,42]),t(i,[2,43]),t(O,[2,25],{36:66,39:[1,67],41:k}),t(O,[2,26]),t(R,[2,30]),t(O,[2,33]),t(R,[2,32]),t(O,[2,27]),{38:68,40:b},t(R,[2,31])],defaultActions:{5:[2,44],7:[2,2],25:[2,47],39:[2,46],45:[2,28],52:[2,23]},parseError:function(t,e){if(e.recoverable)this.trace(t);else{var r=Error(t);throw r.hash=e,r}},parse:function(t){var e=this,r=[0],i=[],a=[null],n=[],s=this.table,o="",l=0,c=0,h=n.slice.call(arguments,1),d=Object.create(this.lexer),y={yy:{}};for(var u in this.yy)Object.prototype.hasOwnProperty.call(this.yy,u)&&(y.yy[u]=this.yy[u]);d.setInput(t,y.yy),y.yy.lexer=d,y.yy.parser=this,void 0===d.yylloc&&(d.yylloc={});var p=d.yylloc;n.push(p);var _=d.options&&d.options.ranges;"function"==typeof y.yy.parseError?this.parseError=y.yy.parseError:this.parseError=Object.getPrototypeOf(this).parseError;for(var f,g,m,E,O,b,k,R,N={};;){if(g=r[r.length-1],this.defaultActions[g]?m=this.defaultActions[g]:(null==f&&(f=function(){var t;return"number"!=typeof(t=i.pop()||d.lex()||1)&&(t instanceof Array&&(t=(i=t).pop()),t=e.symbols_[t]||t),t}()),m=s[g]&&s[g][f]),void 0===m||!m.length||!m[0]){var x="";for(O in R=[],s[g])this.terminals_[O]&&O>2&&R.push("'"+this.terminals_[O]+"'");x=d.showPosition?"Parse error on line "+(l+1)+":\n"+d.showPosition()+"\nExpecting "+R.join(", ")+", got '"+(this.terminals_[f]||f)+"'":"Parse error on line "+(l+1)+": Unexpected "+(1==f?"end of input":"'"+(this.terminals_[f]||f)+"'"),this.parseError(x,{text:d.match,token:this.terminals_[f]||f,line:d.yylineno,loc:p,expected:R})}if(m[0]instanceof Array&&m.length>1)throw Error("Parse Error: multiple actions possible at state: "+g+", token: "+f);switch(m[0]){case 1:r.push(f),a.push(d.yytext),n.push(d.yylloc),r.push(m[1]),f=null,c=d.yyleng,o=d.yytext,l=d.yylineno,p=d.yylloc;break;case 2:if(b=this.productions_[m[1]][1],N.$=a[a.length-b],N._$={first_line:n[n.length-(b||1)].first_line,last_line:n[n.length-1].last_line,first_column:n[n.length-(b||1)].first_column,last_column:n[n.length-1].last_column},_&&(N._$.range=[n[n.length-(b||1)].range[0],n[n.length-1].range[1]]),void 0!==(E=this.performAction.apply(N,[o,c,l,y.yy,m[1],a,n].concat(h))))return E;b&&(r=r.slice(0,-1*b*2),a=a.slice(0,-1*b),n=n.slice(0,-1*b)),r.push(this.productions_[m[1]][0]),a.push(N.$),n.push(N._$),k=s[r[r.length-2]][r[r.length-1]],r.push(k);break;case 3:return!0}}return!0}};function x(){this.yy={}}return N.lexer={EOF:1,parseError:function(t,e){if(this.yy.parser)this.yy.parser.parseError(t,e);else throw Error(t)},setInput:function(t,e){return this.yy=e||this.yy||{},this._input=t,this._more=this._backtrack=this.done=!1,this.yylineno=this.yyleng=0,this.yytext=this.matched=this.match="",this.conditionStack=["INITIAL"],this.yylloc={first_line:1,first_column:0,last_line:1,last_column:0},this.options.ranges&&(this.yylloc.range=[0,0]),this.offset=0,this},input:function(){var t=this._input[0];return this.yytext+=t,this.yyleng++,this.offset++,this.match+=t,this.matched+=t,t.match(/(?:\r\n?|\n).*/g)?(this.yylineno++,this.yylloc.last_line++):this.yylloc.last_column++,this.options.ranges&&this.yylloc.range[1]++,this._input=this._input.slice(1),t},unput:function(t){var e=t.length,r=t.split(/(?:\r\n?|\n)/g);this._input=t+this._input,this.yytext=this.yytext.substr(0,this.yytext.length-e),this.offset-=e;var i=this.match.split(/(?:\r\n?|\n)/g);this.match=this.match.substr(0,this.match.length-1),this.matched=this.matched.substr(0,this.matched.length-1),r.length-1&&(this.yylineno-=r.length-1);var a=this.yylloc.range;return this.yylloc={first_line:this.yylloc.first_line,last_line:this.yylineno+1,first_column:this.yylloc.first_column,last_column:r?(r.length===i.length?this.yylloc.first_column:0)+i[i.length-r.length].length-r[0].length:this.yylloc.first_column-e},this.options.ranges&&(this.yylloc.range=[a[0],a[0]+this.yyleng-e]),this.yyleng=this.yytext.length,this},more:function(){return this._more=!0,this},reject:function(){return this.options.backtrack_lexer?(this._backtrack=!0,this):this.parseError("Lexical error on line "+(this.yylineno+1)+". You can only invoke reject() in the lexer when the lexer is of the backtracking persuasion (options.backtrack_lexer = true).\n"+this.showPosition(),{text:"",token:null,line:this.yylineno})},less:function(t){this.unput(this.match.slice(t))},pastInput:function(){var t=this.matched.substr(0,this.matched.length-this.match.length);return(t.length>20?"...":"")+t.substr(-20).replace(/\n/g,"")},upcomingInput:function(){var t=this.match;return t.length<20&&(t+=this._input.substr(0,20-t.length)),(t.substr(0,20)+(t.length>20?"...":"")).replace(/\n/g,"")},showPosition:function(){var t=this.pastInput(),e=Array(t.length+1).join("-");return t+this.upcomingInput()+"\n"+e+"^"},test_match:function(t,e){var r,i,a;if(this.options.backtrack_lexer&&(a={yylineno:this.yylineno,yylloc:{first_line:this.yylloc.first_line,last_line:this.last_line,first_column:this.yylloc.first_column,last_column:this.yylloc.last_column},yytext:this.yytext,match:this.match,matches:this.matches,matched:this.matched,yyleng:this.yyleng,offset:this.offset,_more:this._more,_input:this._input,yy:this.yy,conditionStack:this.conditionStack.slice(0),done:this.done},this.options.ranges&&(a.yylloc.range=this.yylloc.range.slice(0))),(i=t[0].match(/(?:\r\n?|\n).*/g))&&(this.yylineno+=i.length),this.yylloc={first_line:this.yylloc.last_line,last_line:this.yylineno+1,first_column:this.yylloc.last_column,last_column:i?i[i.length-1].length-i[i.length-1].match(/\r?\n?/)[0].length:this.yylloc.last_column+t[0].length},this.yytext+=t[0],this.match+=t[0],this.matches=t,this.yyleng=this.yytext.length,this.options.ranges&&(this.yylloc.range=[this.offset,this.offset+=this.yyleng]),this._more=!1,this._backtrack=!1,this._input=this._input.slice(t[0].length),this.matched+=t[0],r=this.performAction.call(this,this.yy,this,e,this.conditionStack[this.conditionStack.length-1]),this.done&&this._input&&(this.done=!1),r)return r;if(this._backtrack)for(var n in a)this[n]=a[n];return!1},next:function(){if(this.done)return this.EOF;this._input||(this.done=!0),this._more||(this.yytext="",this.match="");for(var t,e,r,i,a=this._currentRules(),n=0;n<a.length;n++)if((r=this._input.match(this.rules[a[n]]))&&(!e||r[0].length>e[0].length)){if(e=r,i=n,this.options.backtrack_lexer){if(!1!==(t=this.test_match(r,a[n])))return t;if(!this._backtrack)return!1;e=!1;continue}if(!this.options.flex)break}return e?!1!==(t=this.test_match(e,a[i]))&&t:""===this._input?this.EOF:this.parseError("Lexical error on line "+(this.yylineno+1)+". Unrecognized text.\n"+this.showPosition(),{text:"",token:null,line:this.yylineno})},lex:function(){return this.next()||this.lex()},begin:function(t){this.conditionStack.push(t)},popState:function(){return this.conditionStack.length-1>0?this.conditionStack.pop():this.conditionStack[0]},_currentRules:function(){return this.conditionStack.length&&this.conditionStack[this.conditionStack.length-1]?this.conditions[this.conditionStack[this.conditionStack.length-1]].rules:this.conditions.INITIAL.rules},topState:function(t){return(t=this.conditionStack.length-1-Math.abs(t||0))>=0?this.conditionStack[t]:"INITIAL"},pushState:function(t){this.begin(t)},stateStackSize:function(){return this.conditionStack.length},options:{"case-insensitive":!0},performAction:function(t,e,r,i){switch(r){case 0:return this.begin("acc_title"),25;case 1:return this.popState(),"acc_title_value";case 2:return this.begin("acc_descr"),27;case 3:return this.popState(),"acc_descr_value";case 4:this.begin("acc_descr_multiline");break;case 5:this.popState();break;case 6:return"acc_descr_multiline_value";case 7:return this.begin("open_directive"),51;case 8:return this.begin("type_directive"),52;case 9:return this.popState(),this.begin("arg_directive"),15;case 10:return this.popState(),this.popState(),54;case 11:return 53;case 12:return 11;case 13:case 20:case 25:break;case 14:return 9;case 15:return 31;case 16:return 50;case 17:return 4;case 18:return this.begin("block"),20;case 19:return 39;case 21:return 40;case 22:case 23:return 37;case 24:return 41;case 26:return this.popState(),22;case 27:case 56:return e.yytext[0];case 28:case 32:case 33:case 46:return 44;case 29:case 30:case 31:case 39:case 41:case 48:return 46;case 34:case 35:case 36:case 37:case 38:case 40:case 47:return 45;case 42:case 43:case 44:case 45:return 47;case 49:case 52:case 53:case 54:return 48;case 50:case 51:return 49;case 55:return 30;case 57:return 6}},rules:[/^(?:accTitle\s*:\s*)/i,/^(?:(?!\n||)*[^\n]*)/i,/^(?:accDescr\s*:\s*)/i,/^(?:(?!\n||)*[^\n]*)/i,/^(?:accDescr\s*\{\s*)/i,/^(?:[\}])/i,/^(?:[^\}]*)/i,/^(?:%%\{)/i,/^(?:((?:(?!\}%%)[^:.])*))/i,/^(?::)/i,/^(?:\}%%)/i,/^(?:((?:(?!\}%%).|\n)*))/i,/^(?:[\n]+)/i,/^(?:\s+)/i,/^(?:[\s]+)/i,/^(?:"[^"%\r\n\v\b\\]+")/i,/^(?:"[^"]*")/i,/^(?:erDiagram\b)/i,/^(?:\{)/i,/^(?:,)/i,/^(?:\s+)/i,/^(?:\b((?:PK)|(?:FK)|(?:UK))\b)/i,/^(?:(.*?)[~](.*?)*[~])/i,/^(?:[A-Za-z_][A-Za-z0-9\-_\[\]\(\)]*)/i,/^(?:"[^"]*")/i,/^(?:[\n]+)/i,/^(?:\})/i,/^(?:.)/i,/^(?:one or zero\b)/i,/^(?:one or more\b)/i,/^(?:one or many\b)/i,/^(?:1\+)/i,/^(?:\|o\b)/i,/^(?:zero or one\b)/i,/^(?:zero or more\b)/i,/^(?:zero or many\b)/i,/^(?:0\+)/i,/^(?:\}o\b)/i,/^(?:many\(0\))/i,/^(?:many\(1\))/i,/^(?:many\b)/i,/^(?:\}\|)/i,/^(?:one\b)/i,/^(?:only one\b)/i,/^(?:1\b)/i,/^(?:\|\|)/i,/^(?:o\|)/i,/^(?:o\{)/i,/^(?:\|\{)/i,/^(?:\.\.)/i,/^(?:--)/i,/^(?:to\b)/i,/^(?:optionally to\b)/i,/^(?:\.-)/i,/^(?:-\.)/i,/^(?:[A-Za-z][A-Za-z0-9\-_]*)/i,/^(?:.)/i,/^(?:$)/i],conditions:{acc_descr_multiline:{rules:[5,6],inclusive:!1},acc_descr:{rules:[3],inclusive:!1},acc_title:{rules:[1],inclusive:!1},open_directive:{rules:[8],inclusive:!1},type_directive:{rules:[9,10],inclusive:!1},arg_directive:{rules:[10,11],inclusive:!1},block:{rules:[19,20,21,22,23,24,25,26,27],inclusive:!1},INITIAL:{rules:[0,2,4,7,12,13,14,15,16,17,18,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57],inclusive:!0}}},x.prototype=N,N.Parser=x,new x}();p.parser=p;let _={},f=[],g=function(t){return void 0===_[t]&&(_[t]={attributes:[]},i.l.info("Added new entity :",t)),_[t]},m={Cardinality:{ZERO_OR_ONE:"ZERO_OR_ONE",ZERO_OR_MORE:"ZERO_OR_MORE",ONE_OR_MORE:"ONE_OR_MORE",ONLY_ONE:"ONLY_ONE"},Identification:{NON_IDENTIFYING:"NON_IDENTIFYING",IDENTIFYING:"IDENTIFYING"},parseDirective:function(t,e,r){a.m.parseDirective(this,t,e,r)},getConfig:()=>(0,i.g)().er,addEntity:g,addAttributes:function(t,e){let r,a=g(t);for(r=e.length-1;r>=0;r--)a.attributes.push(e[r]),i.l.debug("Added attribute ",e[r].attributeName)},getEntities:()=>_,addRelationship:function(t,e,r,a){let n={entityA:t,roleA:e,entityB:r,relSpec:a};f.push(n),i.l.debug("Added new relationship :",n)},getRelationships:()=>f,clear:function(){_={},f=[],(0,i.y)()},setAccTitle:i.o,getAccTitle:i.p,setAccDescription:i.v,getAccDescription:i.q,setDiagramTitle:i.w,getDiagramTitle:i.x},E={ONLY_ONE_START:"ONLY_ONE_START",ONLY_ONE_END:"ONLY_ONE_END",ZERO_OR_ONE_START:"ZERO_OR_ONE_START",ZERO_OR_ONE_END:"ZERO_OR_ONE_END",ONE_OR_MORE_START:"ONE_OR_MORE_START",ONE_OR_MORE_END:"ONE_OR_MORE_END",ZERO_OR_MORE_START:"ZERO_OR_MORE_START",ZERO_OR_MORE_END:"ZERO_OR_MORE_END"},O={ERMarkers:E,insertMarkers:function(t,e){let r;t.append("defs").append("marker").attr("id",E.ONLY_ONE_START).attr("refX",0).attr("refY",9).attr("markerWidth",18).attr("markerHeight",18).attr("orient","auto").append("path").attr("stroke",e.stroke).attr("fill","none").attr("d","M9,0 L9,18 M15,0 L15,18"),t.append("defs").append("marker").attr("id",E.ONLY_ONE_END).attr("refX",18).attr("refY",9).attr("markerWidth",18).attr("markerHeight",18).attr("orient","auto").append("path").attr("stroke",e.stroke).attr("fill","none").attr("d","M3,0 L3,18 M9,0 L9,18"),(r=t.append("defs").append("marker").attr("id",E.ZERO_OR_ONE_START).attr("refX",0).attr("refY",9).attr("markerWidth",30).attr("markerHeight",18).attr("orient","auto")).append("circle").attr("stroke",e.stroke).attr("fill","white").attr("cx",21).attr("cy",9).attr("r",6),r.append("path").attr("stroke",e.stroke).attr("fill","none").attr("d","M9,0 L9,18"),(r=t.append("defs").append("marker").attr("id",E.ZERO_OR_ONE_END).attr("refX",30).attr("refY",9).attr("markerWidth",30).attr("markerHeight",18).attr("orient","auto")).append("circle").attr("stroke",e.stroke).attr("fill","white").attr("cx",9).attr("cy",9).attr("r",6),r.append("path").attr("stroke",e.stroke).attr("fill","none").attr("d","M21,0 L21,18"),t.append("defs").append("marker").attr("id",E.ONE_OR_MORE_START).attr("refX",18).attr("refY",18).attr("markerWidth",45).attr("markerHeight",36).attr("orient","auto").append("path").attr("stroke",e.stroke).attr("fill","none").attr("d","M0,18 Q 18,0 36,18 Q 18,36 0,18 M42,9 L42,27"),t.append("defs").append("marker").attr("id",E.ONE_OR_MORE_END).attr("refX",27).attr("refY",18).attr("markerWidth",45).attr("markerHeight",36).attr("orient","auto").append("path").attr("stroke",e.stroke).attr("fill","none").attr("d","M3,9 L3,27 M9,18 Q27,0 45,18 Q27,36 9,18"),(r=t.append("defs").append("marker").attr("id",E.ZERO_OR_MORE_START).attr("refX",18).attr("refY",18).attr("markerWidth",57).attr("markerHeight",36).attr("orient","auto")).append("circle").attr("stroke",e.stroke).attr("fill","white").attr("cx",48).attr("cy",18).attr("r",6),r.append("path").attr("stroke",e.stroke).attr("fill","none").attr("d","M0,18 Q18,0 36,18 Q18,36 0,18"),(r=t.append("defs").append("marker").attr("id",E.ZERO_OR_MORE_END).attr("refX",39).attr("refY",18).attr("markerWidth",57).attr("markerHeight",36).attr("orient","auto")).append("circle").attr("stroke",e.stroke).attr("fill","white").attr("cx",9).attr("cy",18).attr("r",6),r.append("path").attr("stroke",e.stroke).attr("fill","none").attr("d","M21,18 Q39,0 57,18 Q39,36 21,18")}},b=/[^\dA-Za-z](\W)*/g,k={},R=new Map,N=(t,e,r)=>{let a=k.entityPadding/3,n=k.entityPadding/3,s=.85*k.fontSize,o=e.node().getBBox(),l=[],c=!1,h=!1,d=0,y=0,u=0,p=0,_=o.height+2*a,f=1;r.forEach(t=>{void 0!==t.attributeKeyTypeList&&t.attributeKeyTypeList.length>0&&(c=!0),void 0!==t.attributeComment&&(h=!0)}),r.forEach(r=>{let n=`${e.node().id}-attr-${f}`,o=0,g=(0,i.z)(r.attributeType),m=t.append("text").classed("er entityLabel",!0).attr("id",`${n}-type`).attr("x",0).attr("y",0).style("dominant-baseline","middle").style("text-anchor","left").style("font-family",(0,i.g)().fontFamily).style("font-size",s+"px").text(g),E=t.append("text").classed("er entityLabel",!0).attr("id",`${n}-name`).attr("x",0).attr("y",0).style("dominant-baseline","middle").style("text-anchor","left").style("font-family",(0,i.g)().fontFamily).style("font-size",s+"px").text(r.attributeName),O={};O.tn=m,O.nn=E;let b=m.node().getBBox(),k=E.node().getBBox();if(d=Math.max(d,b.width),y=Math.max(y,k.width),o=Math.max(b.height,k.height),c){let e=void 0!==r.attributeKeyTypeList?r.attributeKeyTypeList.join(","):"",a=t.append("text").classed("er entityLabel",!0).attr("id",`${n}-key`).attr("x",0).attr("y",0).style("dominant-baseline","middle").style("text-anchor","left").style("font-family",(0,i.g)().fontFamily).style("font-size",s+"px").text(e);O.kn=a;let l=a.node().getBBox();u=Math.max(u,l.width),o=Math.max(o,l.height)}if(h){let e=t.append("text").classed("er entityLabel",!0).attr("id",`${n}-comment`).attr("x",0).attr("y",0).style("dominant-baseline","middle").style("text-anchor","left").style("font-family",(0,i.g)().fontFamily).style("font-size",s+"px").text(r.attributeComment||"");O.cn=e;let a=e.node().getBBox();p=Math.max(p,a.width),o=Math.max(o,a.height)}O.height=o,l.push(O),_+=o+2*a,f+=1});let g=4;c&&(g+=2),h&&(g+=2);let m=d+y+u+p,E={width:Math.max(k.minEntityWidth,Math.max(o.width+2*k.entityPadding,m+n*g)),height:r.length>0?_:Math.max(k.minEntityHeight,o.height+2*k.entityPadding)};if(r.length>0){let r=Math.max(0,(E.width-m-n*g)/(g/2));e.attr("transform","translate("+E.width/2+","+(a+o.height/2)+")");let i=o.height+2*a,s="attributeBoxOdd";l.forEach(e=>{let o=i+a+e.height/2;e.tn.attr("transform","translate("+n+","+o+")");let l=t.insert("rect","#"+e.tn.node().id).classed(`er ${s}`,!0).attr("x",0).attr("y",i).attr("width",d+2*n+r).attr("height",e.height+2*a),_=parseFloat(l.attr("x"))+parseFloat(l.attr("width"));e.nn.attr("transform","translate("+(_+n)+","+o+")");let f=t.insert("rect","#"+e.nn.node().id).classed(`er ${s}`,!0).attr("x",_).attr("y",i).attr("width",y+2*n+r).attr("height",e.height+2*a),g=parseFloat(f.attr("x"))+parseFloat(f.attr("width"));if(c){e.kn.attr("transform","translate("+(g+n)+","+o+")");let l=t.insert("rect","#"+e.kn.node().id).classed(`er ${s}`,!0).attr("x",g).attr("y",i).attr("width",u+2*n+r).attr("height",e.height+2*a);g=parseFloat(l.attr("x"))+parseFloat(l.attr("width"))}h&&(e.cn.attr("transform","translate("+(g+n)+","+o+")"),t.insert("rect","#"+e.cn.node().id).classed(`er ${s}`,"true").attr("x",g).attr("y",i).attr("width",p+2*n+r).attr("height",e.height+2*a)),i+=e.height+2*a,s="attributeBoxOdd"===s?"attributeBoxEven":"attributeBoxOdd"})}else E.height=Math.max(k.minEntityHeight,_),e.attr("transform","translate("+E.width/2+","+E.height/2+")");return E},x=function(t,e,r){let a;let n=Object.keys(e);return n.forEach(function(n){let s=function(t="",e=""){let r=t.replace(b,"");return`${I(e)}${I(r)}${u(t,"28e9f9db-3c8d-5aa5-9faf-44286ae5937c")}`}(n,"entity");R.set(n,s);let o=t.append("g").attr("id",s);a=void 0===a?s:a;let l="text-"+s,c=o.append("text").classed("er entityLabel",!0).attr("id",l).attr("x",0).attr("y",0).style("dominant-baseline","middle").style("text-anchor","middle").style("font-family",(0,i.g)().fontFamily).style("font-size",k.fontSize+"px").text(n),{width:h,height:d}=N(o,c,e[n].attributes),y=o.insert("rect","#"+l).classed("er entityBox",!0).attr("x",0).attr("y",0).attr("width",h).attr("height",d),p=y.node().getBBox();r.setNode(s,{width:p.width,height:p.height,shape:"rect",id:s})}),a},T=function(t,e){e.nodes().forEach(function(r){void 0!==r&&void 0!==e.node(r)&&t.select("#"+r).attr("transform","translate("+(e.node(r).x-e.node(r).width/2)+","+(e.node(r).y-e.node(r).height/2)+" )")})},v=function(t){return(t.entityA+t.roleA+t.entityB).replace(/\s/g,"")},A=0,M=function(t,e,r,a,n){A++;let o=r.edge(R.get(e.entityA),R.get(e.entityB),v(e)),l=(0,s.jvg)().x(function(t){return t.x}).y(function(t){return t.y}).curve(s.$0Z),c=t.insert("path","#"+a).classed("er relationshipLine",!0).attr("d",l(o.points)).style("stroke",k.stroke).style("fill","none");e.relSpec.relType===n.db.Identification.NON_IDENTIFYING&&c.attr("stroke-dasharray","8,8");let h="";switch(k.arrowMarkerAbsolute&&(h=(h=(h=window.location.protocol+"//"+window.location.host+window.location.pathname+window.location.search).replace(/\(/g,"\\(")).replace(/\)/g,"\\)")),e.relSpec.cardA){case n.db.Cardinality.ZERO_OR_ONE:c.attr("marker-end","url("+h+"#"+O.ERMarkers.ZERO_OR_ONE_END+")");break;case n.db.Cardinality.ZERO_OR_MORE:c.attr("marker-end","url("+h+"#"+O.ERMarkers.ZERO_OR_MORE_END+")");break;case n.db.Cardinality.ONE_OR_MORE:c.attr("marker-end","url("+h+"#"+O.ERMarkers.ONE_OR_MORE_END+")");break;case n.db.Cardinality.ONLY_ONE:c.attr("marker-end","url("+h+"#"+O.ERMarkers.ONLY_ONE_END+")")}switch(e.relSpec.cardB){case n.db.Cardinality.ZERO_OR_ONE:c.attr("marker-start","url("+h+"#"+O.ERMarkers.ZERO_OR_ONE_START+")");break;case n.db.Cardinality.ZERO_OR_MORE:c.attr("marker-start","url("+h+"#"+O.ERMarkers.ZERO_OR_MORE_START+")");break;case n.db.Cardinality.ONE_OR_MORE:c.attr("marker-start","url("+h+"#"+O.ERMarkers.ONE_OR_MORE_START+")");break;case n.db.Cardinality.ONLY_ONE:c.attr("marker-start","url("+h+"#"+O.ERMarkers.ONLY_ONE_START+")")}let d=c.node().getTotalLength(),y=c.node().getPointAtLength(.5*d),u="rel"+A,p=t.append("text").classed("er relationshipLabel",!0).attr("id",u).attr("x",y.x).attr("y",y.y).style("text-anchor","middle").style("dominant-baseline","middle").style("font-family",(0,i.g)().fontFamily).style("font-size",k.fontSize+"px").text(e.roleA),_=p.node().getBBox();t.insert("rect","#"+u).classed("er relationshipLabelBox",!0).attr("x",y.x-_.width/2).attr("y",y.y-_.height/2).attr("width",_.width).attr("height",_.height)};function I(t=""){return t.length>0?`${t}-`:""}let w=t=>`
  .entityBox {
    fill: ${t.mainBkg};
    stroke: ${t.nodeBorder};
  }

  .attributeBoxOdd {
    fill: ${t.attributeBackgroundColorOdd};
    stroke: ${t.nodeBorder};
  }

  .attributeBoxEven {
    fill:  ${t.attributeBackgroundColorEven};
    stroke: ${t.nodeBorder};
  }

  .relationshipLabelBox {
    fill: ${t.tertiaryColor};
    opacity: 0.7;
    background-color: ${t.tertiaryColor};
      rect {
        opacity: 0.5;
      }
  }

    .relationshipLine {
      stroke: ${t.lineColor};
    }

  .entityTitleText {
    text-anchor: middle;
    font-size: 18px;
    fill: ${t.textColor};
  }    
`,S={parser:p,db:m,renderer:{setConf:function(t){let e=Object.keys(t);for(let r of e)k[r]=t[r]},draw:function(t,e,r,a){var c;let h,d;k=(0,i.g)().er,i.l.info("Drawing ER diagram");let y=(0,i.g)().securityLevel;"sandbox"===y&&(h=(0,s.Ys)("#i"+e));let u="sandbox"===y?(0,s.Ys)(h.nodes()[0].contentDocument.body):(0,s.Ys)("body"),p=u.select(`[id='${e}']`);O.insertMarkers(p,k),d=new n.k({multigraph:!0,directed:!0,compound:!1}).setGraph({rankdir:k.layoutDirection,marginx:20,marginy:20,nodesep:100,edgesep:100,ranksep:100}).setDefaultEdgeLabel(function(){return{}});let _=x(p,a.db.getEntities(),d),f=((c=a.db.getRelationships()).forEach(function(t){d.setEdge(R.get(t.entityA),R.get(t.entityB),{relationship:t},v(t))}),c);(0,o.bK)(d),T(p,d),f.forEach(function(t){M(p,t,d,_,a)});let g=k.diagramPadding;l.u.insertTitle(p,"entityTitleText",k.titleTopMargin,a.db.getDiagramTitle());let m=p.node().getBBox(),E=m.width+2*g,b=m.height+2*g;(0,l.k)(p,b,E,k.useMaxWidth),p.attr("viewBox",`${m.x-g} ${m.y-g} ${E} ${b}`)}},styles:w}}}]);
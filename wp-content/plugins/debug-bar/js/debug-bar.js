var wpDebugBar;(function(c){var d,b,a,e;b={adminBarHeight:0,minHeight:0,marginBottom:0,inUpper:function(){return d.offset().top-e.scrollTop()>=b.adminBarHeight},inLower:function(){return d.outerHeight()>=b.minHeight&&e.height()>=b.minHeight},update:function(f){if(typeof f=="number"||f=="auto"){d.height(f)}if(!b.inUpper()||f=="upper"){d.height(e.height()-b.adminBarHeight)}if(!b.inLower()||f=="lower"){d.height(b.minHeight)}a.spacer.css("margin-bottom",d.height()+b.marginBottom)},restore:function(){a.spacer.css("margin-bottom",b.marginBottom)}};wpDebugBar=a={spacer:undefined,init:function(){d=c("#querylist");e=c(window);a.spacer=c(".wp-admin #footer");if(!a.spacer.length){a.spacer=c(document.body)}b.minHeight=c("#debug-bar-handle").outerHeight()+c("#debug-bar-menu").outerHeight();b.adminBarHeight=c("#wpadminbar").outerHeight();b.marginBottom=parseInt(a.spacer.css("margin-bottom"),10);a.dock();a.toggle.init();a.tabs();a.actions.init();a.cookie.restore()},cookie:{get:function(){var f=wpCookies.getHash("wp-debug-bar-"+userSettings.uid);if(!f){return}f.visible=f.visible=="true";f.height=parseInt(f.height,10);return f},update:function(){var g="wp-debug-bar-"+userSettings.uid,f=new Date(),i=userSettings.url,h={visible:d.is(":visible"),height:d.height()};f.setTime(f.getTime()+31536000000);wpCookies.setHash(g,h,f,i)},restore:function(){var f=a.cookie.get();if(!f){return}a.toggle.pending=f.height;a.toggle.visibility(f.visible)}},dock:function(){d.dockable({handle:"#debug-bar-handle",resize:function(g,f){return b.inUpper()&&b.inLower()},resized:function(g,f){b.update()},stop:function(g,f){a.cookie.update()}});e.resize(function(){if(d.is(":visible")&&!d.dockable("option","disabled")){b.update()}})},toggle:{pending:"",init:function(){c("#wp-admin-bar-debug-bar").click(function(f){f.preventDefault();a.toggle.visibility()})},visibility:function(f){f=typeof f=="undefined"?d.is(":hidden"):f;d.toggle(f);c(this).toggleClass("active",f);if(f){b.update(a.toggle.pending);a.toggle.pending=""}else{b.restore()}a.cookie.update()}},tabs:function(){var g=c(".debug-menu-link"),f=c(".debug-menu-target");g.click(function(i){var h=c(this);i.preventDefault();if(h.hasClass("current")){return}f.hide();g.removeClass("current");h.addClass("current");c("#"+this.href.substr(this.href.indexOf("#")+1)).show()})},actions:{height:0,overflow:"auto",buttons:{},init:function(){var f=c("#debug-bar-actions");a.actions.height=d.height();a.actions.overflow=a.spacer.css("overflow");a.actions.buttons.max=c(".plus",f).click(a.actions.maximize);a.actions.buttons.res=c(".minus",f).click(a.actions.restore)},maximize:function(){a.actions.height=d.height();a.spacer.css("overflow","hidden");b.update("auto");a.actions.buttons.max.hide();a.actions.buttons.res.show();d.dockable("disable")},restore:function(){a.spacer.css("overflow",a.actions.overflow);b.update(a.actions.height);a.actions.buttons.res.hide();a.actions.buttons.max.show();d.dockable("enable")}}};c(document).ready(wpDebugBar.init)})(jQuery);
//Will return true if the app was launched from iOS as a web application
//See : http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html#//apple_ref/doc/uid/TP40002051-CH3-SW3
Modernizr.addTest('fullscreen',function(){
	return window.navigator.standalone;
});

//Will return true if the device has an internet connection
Modernizr.addTest('online',function(){
  return navigator.online;
});

//will return true for all Android and iOS browsers and false for all desktop browsers
//See : http://www.tristanwaddington.com/2010/06/detecting-mobile-devices-with-javascript/
Modernizr.addTest('mobiledevice',function(){
  return typeof window.onorientationchange != "undefined" ? true : false; 
});

//Will return true is the browser supports the window object
//False in IE6/7/8, true in everything else
Modernizr.addTest('window',function(){
    return typeof window != "undefined" ? true : false;
});

//Will make the html5 placeholder attribute work inbrowsers that do not support it
//See: http://iliadraznin.com/2010/03/simple-jquery-placeholder-script-input-fields/
$(document).ready(function(){
	if (!Modernizr.input.placeholder){
	
    target = $('input[type="text"], input[type="email"],input[type="url"], input[type="tel"], input[type="search"]');
 
    target.each( function(i, el) {
      el = $(el);
      var ph = el.attr('placeholder');
      if (!ph) return true;

      el.addClass('placeholder');
      el.attr('value', ph);

      el.focus( function(e) {
        if( el.val()==ph ) {
          el.removeClass('placeholder');
          el.attr('value', '');
        }
      });

      el.blur( function(e) {
        if( $.trim(el.val())=='' ) {
          el.addClass('placeholder');
          el.attr('value', ph);
        }
      });
    });
	}
});

//Usage: log('inside coolFunc',this,arguments);
//See : paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console){
    console.log( Array.prototype.slice.call(arguments) );
  }
};

//Catch all document.write() calls
(function(doc){
  var write = doc.write;
  doc.write = function(q){ 
    log('document.write(): ',arguments); 
    if (/docwriteregexwhitelist/.test(q)) write.apply(doc,arguments);  
  };
})(document);



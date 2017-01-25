// Listener
(function(global, debug){
  function defineListener(){
    if (window.addEventListener) {
      // For standards-compliant web browsers
      window.addEventListener("message", handleMessage, false);
    }
    else {
      window.attachEvent("onmessage", handleMessage, false);
    }
  };

  function handleMessage(evt){
    var allowedIframeDomains = ['http://localhost:8080', 'http://54.83.147.14:8080', 'http://adproducts-stage.us-east-1.elasticbeanstalk.com', 'https://adproduct.timeinc.com'];
    var origin = evt.origin || evt.originalEvent.origin; // For Chrome, the origin property is in the event.originalEvent object.
    if (allowedIframeDomains.indexOf(origin) === -1) {
      console.log("You are not worthy");
      return;
    }

    debug.log("Received: ", evt.data, new Date().toISOString());

    if(evt.data.eventName === 'HEIGHT_UPDATE'){
      document.getElementById("quiz-app-frame").height = evt.data.heightValue;
    }
  };

  defineListener();
})(window, console);

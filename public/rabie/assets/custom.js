
    var handler = function(e) {
      e = e || window.event;
      var k = e.keyCode || e.which;
      switch(k) {
        case 37:
          document.body.scrollLeft -= 1000;
          document.documentElement.scrollLeft -= 1000;
          break;
        case 38:
          document.body.scrollTop-= 1000;
          document.documentElement.scrollTop-= 1000;
          break;
        case 39:
          document.body.scrollLeft += 1000;
          document.documentElement.scrollLeft += 1000;
          break;
        case 40:
          document.body.scrollLeft += 1000;
          document.documentElement.scrollLeft += 1000;
          break;
        default: return true;
      }
      if( e.preventDefault) e.preventDefault();
      return false;
    };
    if( window.attachEvent) window.addEvent("onkeydown",handler,false);
    else window.addEventListener("keydown",handler,false);







// set up any div with fullscreen class to go full screen when clicked
var inFullScreen = false;

var fsClass = document.getElementsByClassName("fullScreen");
for (var i = 0; i < fsClass.length; i++) {
  fsClass[i].addEventListener("click", function (evt) {
    if (inFullScreen == false) {
      makeFullScreen(document.getElementsByClassName("MainScr")); // open to full screen
    } else {
      reset();
    }
  }, false);
}

document.addEventListener("MSFullscreenError", function (evt) {
  console.error("full screen error has occured " + evt.target);
}, true);

//  request full screen across several browsers
function makeFullScreen(divObj) {
  if (divObj[0].requestFullscreen) {
    divObj[0].requestFullscreen();
  }
  else if (divObj[0].msRequestFullscreen) {
    divObj[0].msRequestFullscreen();
  }
  else if (divObj[0].mozRequestFullScreen) {
    divObj[0].mozRequestFullScreen();
  }
  else if (divObj[0].webkitRequestFullscreen) {
    divObj[0].webkitRequestFullscreen();
  }
  inFullScreen = false;
  return;
}

//  reset full screen across several browsers
function reset() {
  if (document.exitFullscreen) {
   // document.exitFullscreen();
  }
  else if (document.msExitFullscreen) {
  //  document.msExitFullscreen();
  }
  else if (document.mozCancelFullScreen) {
  //  document.mozCancelFullScreen();
  }
  else if (document.cancelFullScreen) {
 //   document.cancelFullScreen();
  }
  else if (document.webkitCancelFullScreen) {
 //   document.webkitCancelFullScreen();
  }
  inFullScreen = false;
  return;

}   
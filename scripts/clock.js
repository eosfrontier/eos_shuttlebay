function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').value = h + ":" + m + ":" + s;
    var t = setTimeout(function () { startTime() }, 1000);
  }
  
  function checkTime(i) {
    if (i < 10) { i = "0" + i } // add zero in front of numbers < 10
    return i;
  }
  startTime();
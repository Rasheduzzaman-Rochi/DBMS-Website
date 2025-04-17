//logout
document.getElementById("logout").addEventListener("click",function() {
    console.log("button is clicked")
    window.location.href = "./login.html"
  })
  

document.getElementById("inventory").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./inventory.html"
  });

  document.getElementById("storageMonitor").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./storageMonitorDash.html"
  });

  document.getElementById("salesDistribution").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./salesAndDistribution.html"
  });

  document.getElementById("lossRecords").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./lossrecord.html"
  });Reports
  document.getElementById("Alerts").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./alert.html"
  });

  document.getElementById("Reports").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./reportsAndImprovement.html"
  });
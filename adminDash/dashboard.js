//logout
document.getElementById("logout").addEventListener("click",function() {
    console.log("button is clicked")
    window.location.href = "./login.php"
  })
  

document.getElementById("inventory").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "inventory.php"
  });

  document.getElementById("storageMonitor").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./storageMonitorDash.php"
  });

  document.getElementById("salesDistribution").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./salesAndDistribution.php"
  });

  document.getElementById("lossRecords").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./lossrecord.php"
  });Reports
  document.getElementById("Alerts").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./alert.php"
  });

  document.getElementById("Reports").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./reportsAndImprovement.php"
  });

  
  document.getElementById("farmer").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./farmerDashBoard.php"
  });
  document.getElementById("transport").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./transporterDash.php"
  });
  

  document.getElementById("registerBtn").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "./adminDash.php"
  });
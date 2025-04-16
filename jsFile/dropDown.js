// Get the element where the selected designation is displayed
const dropdown = document.querySelector('#designation'); 

// Get the next sibling element (the list of options) of the dropdown
const optionsList = dropdown.nextElementSibling;
// Add an event listener to the dropdown to toggle the visibility of the options list
dropdown.addEventListener('click', () => {
  optionsList.classList.toggle('hidden'); // When clicked, we show or hide the options
});

// Add an event listener to the options list to update the text when an option is selected
optionsList.addEventListener('click', (e) => {
  // Get the text of the clicked option and set it as the new text of the dropdown
  dropdown.innerHTML = `<span>${e.target.innerText}</span>`; 
  
  // Hide the options list after an option is selected
  optionsList.classList.add('hidden'); 
});

//to redirect from register to login
document.getElementById("loginBtn").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("button is clicked")
    window.location.href = "login.html"
  });
  

 
//to redirect from land to register
document.getElementById("landRegBtn").addEventListener("click", function(event) {
  event.preventDefault();
  console.log("button is clicked")
  window.location.href = "login.html"
});


// register button logic
const registerBtn = document.getElementById("registerBtn");
const designationSelect = document.getElementById("designation");

if (registerBtn && designationSelect) {
  registerBtn.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent form submission

    const designation = designationSelect.value;

    if (designation === "farmer") {
      window.location.href = "farmerDashBoard.html";
    } else if (!designation) {
      alert("Please select a designation.");
    } else {
      alert("Only 'Farmer' designation is allowed to proceed to Farmer Dashboard for now.");
    }
  });
}

document.getElementById("inventory").addEventListener("click", function(event) {
  event.preventDefault();
  console.log("button is clicked")
  window.location.href = "inventory.html"
});




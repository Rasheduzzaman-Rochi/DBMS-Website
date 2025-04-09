// Get the element where the selected designation is displayed
const dropdown = document.querySelector('#designation'); 

// Get the next sibling element (the list of options) of the dropdown
const optionsList = dropdown.nextElementSibling; // This gets the <ul> that contains the options

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
document.getElementById("registerBtn").addEventListener("click", function(event) {
    event.preventDefault();
    window.location.href = "login2.html"
  });
  

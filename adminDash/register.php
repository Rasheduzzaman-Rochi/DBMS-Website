


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register form</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="navbar bg-base-100 shadow-sm justify-center">
        <div class="navbar-start">
          
          <div class="flex items-center space-x-2">
            <img src="https://img.icons8.com/color/48/000000/farm.png" alt="logo" class="w-10 h-10">
            <span class="text-xl font-bold text-green-700"> শস্য শ্যামলা
            </span>
          </div>
        </div>
       
        <div class="navbar-center">
            <button type="submit" id="loginBtn" class=" bg-green-500 text-white py-2 px-4 rounded-md mt-4 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Login</button>
        </div>
      </div>
     <!-- Register Form -->
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
     <div class="bg-white p-6 rounded-lg shadow-lg w-96">
      <h1 class="text-2xl font-bold mb-4 text-center">Register</h1>     
      <form method="POST" action="register.php">
  <div class="mb-4">
    <label for="username" class="block text-sm font-medium text-gray-700">UserName</label>
    <input name="username" type="text" id="username" placeholder="UserName" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
  </div>

  <div class="mb-4">
    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
    <input name="password" type="password" id="password" placeholder="Password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
  </div>

  <div class="mb-4">
    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
    <input name="confirm_password" type="password" id="confirm-password" placeholder="Confirm Your Password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
  </div>

  <div class="mb-4">
    <label for="designation" class="block text-sm font-medium text-gray-700">Designation</label>
    <select name="designation" id="designation" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
      <option value="">Select Designation</option>
      <option value="Manager">Manager</option>
      <option value="farmer">Farmer</option>
      <option value="distributor">Distributor</option>
      <option value="transporter">Transporter</option>
      <option value="consumer">Consumer</option>
    </select>
  </div>

  <button type="submit" name="register" id="registerBtn"
    class="w-full bg-green-500 text-white py-2 px-4 rounded-md mt-4 hover:bg-green-600">
    Register
  </button>
</form>

      
  
     
    </div>
    </div>
   
      


        
      
      


    <script src="jsFile/dropDown.js"></script>
</body>
</html>
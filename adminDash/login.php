<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
  <div class=" bg-green-800 p-5">
    <!-- Logo Section -->
    <div class="flex items-center justify-center space-x-2">
      <!-- Corrected the path to logo.svg -->
      <img src="./logo.svg" alt="logo" class="w-10 h-10">
      <span class="text-xl font-bold text-white"> শস্য শ্যামলা
      </span>
    </div>
  </div>

  <section class="relative h-[90vh] bg-cover bg-center flex items-center justify-center text-white op" style="background-image: url('../assets/assets2/Image.png');">
    <div class="flex justify-center items-center min-h-screen">
      <div class="p-6 rounded-lg shadow-lg w-96">
        <h1 class="text-2xl font-bold mb-4 text-center text-white">Login</h1>
      
        <!-- Start of the login form -->
        <form method="post" action="">

          <!-- Display error if username or password is incorrect -->
          <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                if ($username === 'admindash' && $password === '1234') {
                    // Redirect to admin dashboard
                    header("Location: admindash.php");
                    exit();
                } else {
                    echo '<div class="text-red-500 text-center mb-4">Invalid username or password</div>';
                }
            }
          ?>

          <div class="mb-4 input-group">
            <label for="username" class="block text-sm font-medium text-white-700">UserName</label>
            <input type="text" name="username" id="username" placeholder="UserName" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-black">
          </div>
    
          <div class="mb-4 input-group">
            <label for="password" class="block text-sm font-medium text-white-700">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-black">
          </div>

          <div class="input-group">     
              <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md mt-4 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Login</button>
          </div>
          <p>
              Not yet a member? <a href="register.php">Sign up</a>
          </p>
        </form>
      </div>
    </div>
  </section>
  
  <script src="./jsFile/dropDown.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - CreditInfo</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer>
    function toggleTermsModal(show) {
      document.getElementById('terms-modal').classList.toggle('hidden', !show);
    }
  </script>
</head>
<body class="bg-white text-gray-800">

<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">




  <div class="relative hidden md:flex items-end justify-start overflow-hidden bg-white rounded-3xl m-4">

<!-- Image -->
<img src="{{ asset('/image.jpg') }}" alt="Background"
     class="absolute inset-0 w-full h-full object-cover z-0 rounded-3xl" />

<!-- Bottom Gradient -->
<div class="absolute bottom-0 left-0 w-full h-1/2 z-10 pointer-events-none rounded-b-3xl"
     style="background: linear-gradient(to top, #C40F12, transparent); mix-blend-mode: multiply;"></div>

<!-- Right Gradient -->
<div class="absolute top-0 right-0 w-1/2 h-full z-10 pointer-events-none rounded-r-3xl"
     style="background: linear-gradient(to left, #C40F12, transparent); mix-blend-mode: multiply;"></div>

<!-- Content -->
<div class="relative z-20 text-white p-10 space-y-5 max-w-full float-animation">
  <img src="/creditInfoLogo.svg" alt="CreditInfo Logo" class="h-10" />
  <h1 class="text-4xl font-bold leading-tight">Join CreditInfo</h1>
  <p class="text-lg opacity-90">Unlock powerful statement processing and insights.</p>
</div>
</div>




  <!-- Right Form Section -->
  <div class="flex items-center justify-center p-8 md:p-16 bg-white">
    <div class="w-full max-w-md space-y-8">
      <div class="text-center">
        <h2 class="text-3xl font-bold">Create Your Account</h2>
        <p class="text-sm text-gray-500">Start your journey with CreditInfo today</p>
      </div>

      <form method="POST" class="space-y-6">
        <div>
          <label class="block text-sm font-medium">Full Name</label>
          <input type="text" required class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#C40F12] focus:border-[#C40F12]" />
        </div>

        <div>
          <label class="block text-sm font-medium">Email</label>
          <input type="email" required class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#C40F12] focus:border-[#C40F12]" />
        </div>

        <div>
          <label class="block text-sm font-medium">Password</label>
          <input type="password" required class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#C40F12] focus:border-[#C40F12]" />
        </div>

        <div class="flex items-start text-sm">
          <input id="terms" type="checkbox" required class="mt-1 border-gray-300 text-[#C40F12] focus:ring-[#C40F12]" />
          <label for="terms" class="ml-2">
            I agree to the 
            <button type="button" onclick="toggleTermsModal(true)" class="text-[#C40F12] hover:underline font-semibold">
              Terms & Conditions
            </button>
          </label>
        </div>

        <button type="submit" class="w-full py-2 px-4 bg-[#C40F12] text-white font-semibold rounded-md hover:bg-opacity-90 transition">
          Register
        </button>
      </form>

      <p class="text-center text-sm text-gray-500">Already have an account? 
        <a href="#" class="text-[#C40F12] font-semibold hover:underline">Login</a>
      </p>
    </div>
  </div>
</div>

<!-- Modal -->
<!-- Terms & Conditions Modal -->
<div id="terms-modal" class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center hidden">
  <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-lg relative max-h-[90vh] overflow-y-auto">
    <h2 class="text-2xl font-bold mb-4 text-[#C40F12]">CreditInfo Terms & Conditions</h2>

    <!-- TERMS SECTION -->
    <div class="mb-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-2 border-b border-gray-200 pb-1">Terms</h3>
      <ol class="list-decimal list-inside text-sm space-y-2 text-gray-700">
        <li>You must be at least 18 years old or the age of majority in your jurisdiction to use this service.</li>
        <li>You agree to provide accurate and current information during registration and maintain its accuracy over time.</li>
        <li>Use of CreditInfo services must comply with all applicable local, national, and international laws and regulations.</li>
        <li>Your login credentials must not be shared. You're responsible for all activities under your account.</li>
        <li>We reserve the right to update pricing and feature tiers with prior notice via email or platform notifications.</li>
        <li>By subscribing to paid plans, you authorize recurring charges and agree to our billing cycles and refund policies.</li>
        <li>All content, logos, and platform features are property of CreditInfo and may not be replicated or redistributed without consent.</li>
      </ol>
    </div>

    <!-- CONDITIONS SECTION -->
    <div class="mb-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-2 border-b border-gray-200 pb-1">Conditions</h3>
      <ol class="list-decimal list-inside text-sm space-y-2 text-gray-700">
        <li>Violation of terms may result in account suspension or termination without prior notice.</li>
        <li>Users must not misuse or attempt unauthorized access to any part of the system, including backend APIs.</li>
        <li>CreditInfo may temporarily disable access for maintenance or upgrades, which will be communicated in advance.</li>
        <li>Data provided by users may be stored securely and analyzed anonymously for system improvement and reporting.</li>
        <li>Accounts inactive for 12 months may be archived or removed unless otherwise agreed.</li>
        <li>We are not liable for losses resulting from inaccurate data entry or third-party access if caused by user negligence.</li>
        <li>Continued use of the platform implies acceptance of any updates made to these terms.</li>
      </ol>
    </div>

    <!-- Modal Actions -->
    <div class="flex justify-end mt-6 space-x-4">
      <button onclick="toggleTermsModal(false)" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
      <button onclick="toggleTermsModal(false)" class="px-4 py-2 bg-[#C40F12] text-white rounded-md hover:bg-opacity-90">Accept & Continue</button>
    </div>
  </div>
</div>


</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CreditInfo - Financial Statement Processing Solutions</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
    }
    
    .float-animation {
      animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
      0%   { transform: translateY(0px); }
      50%  { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    }

    .gradient-bg {
      background: linear-gradient(135deg, #C40F12 0%, #ff4b4e 100%);
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease-in-out forwards;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .btn-hover {
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .btn-hover:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.2);
      transform: scaleX(0);
      transform-origin: right;
      transition: transform 0.5s ease-in-out;
      z-index: -1;
    }
    
    .btn-hover:hover:after {
      transform: scaleX(1);
      transform-origin: left;
    }
    
    .card-shadow {
      box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.1), 0 2px 10px -2px rgba(0, 0, 0, 0.05);
    }

    .feature-card:hover {
      transform: translateY(-5px);
      transition: all 0.3s ease;
    }

    .testimonial-slider {
      scroll-behavior: smooth;
      scroll-snap-type: x mandatory;
    }

    .testimonial-slide {
      scroll-snap-align: center;
    }
  </style>
</head>

<body class="bg-gray-50">
  <!-- Top promo bar -->
  <div class="bg-[#C40F12] text-white text-center text-sm py-2">
    Limited time offer: 20% OFF all statement packages with code CREDIT20
  </div>

  <!-- Navbar -->
 
  <livewire:component.nav-bar />



  @yield('site-section')


  <livewire:component.footer />


<livewire:chart-bolt />

<script>
  // Chat functionality
  document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.getElementById('chatButton');
    const chatWindow = document.getElementById('chatWindow');
    const closeChat = document.getElementById('closeChat');
    const chatInput = document.getElementById('chatInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatMessages = document.getElementById('chatMessages');
    
    // Toggle chat window
    chatButton.addEventListener('click', function() {
      chatWindow.classList.toggle('hidden');
      if (!chatWindow.classList.contains('hidden')) {
        chatInput.focus();
      }
    });
    
    // Close chat window
    closeChat.addEventListener('click', function() {
      chatWindow.classList.add('hidden');
    });
    
    // Send message function
    function sendUserMessage() {
      const message = chatInput.value.trim();
      if (message) {
        // Add user message
        const userDiv = document.createElement('div');
        userDiv.className = 'mb-3 text-right';
        userDiv.innerHTML = `
          <div class="bg-[#C40F12] text-white p-2 rounded-lg inline-block max-w-xs">
            <p class="text-sm">${message}</p>
          </div>
        `;
        chatMessages.appendChild(userDiv);
        
        // Clear input
        chatInput.value = '';
        
        // Simulate response (in real implementation, you'd call your API)
        setTimeout(() => {
          const botDiv = document.createElement('div');
          botDiv.className = 'mb-3';
          botDiv.innerHTML = `
            <div class="bg-gray-200 text-gray-800 p-2 rounded-lg inline-block max-w-xs">
              <p class="text-sm">Thanks for your question. Our team will process your inquiry about "${message}" shortly.</p>
            </div>
          `;
          chatMessages.appendChild(botDiv);
          chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 1000);
        
        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }
    }
    
    // Send on click
    sendMessage.addEventListener('click', sendUserMessage);
    
    // Send on Enter key
    chatInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        sendUserMessage();
      }
    });
  });
</script>





<script>
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
</body>
</html>
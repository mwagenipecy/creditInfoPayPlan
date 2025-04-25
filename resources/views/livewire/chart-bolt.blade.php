<div>
<!-- Chatbot Widget -->
<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
  <!-- Chat Window (Hidden by default) -->
  <div id="chatWindow" class="hidden mb-4 w-80 bg-white rounded-lg shadow-xl overflow-hidden card-shadow fade-in">
    <!-- Chat Header -->
    <div class="gradient-bg p-4 text-white flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <div class="bg-white bg-opacity-20 p-1 rounded-full">
          <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path>
          </svg>
        </div>
        <span class="font-medium">CreditInfo Assistant</span>
      </div>
      <button id="closeChat" class="text-white hover:text-gray-200 focus:outline-none">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <!-- Chat Messages -->
    <div id="chatMessages" class="p-4 h-64 overflow-y-auto bg-gray-50">
      <div class="mb-3">
        <div class="bg-gray-200 text-gray-800 p-2 rounded-lg inline-block max-w-xs">
          <p class="text-sm">Hi there! How can I help you with financial statement processing today?</p>
        </div>
      </div>
    </div>
    
    <!-- Chat Input -->
    <div class="p-3 border-t border-gray-200 bg-white">
      <div class="flex items-center">
        <input type="text" id="chatInput" placeholder="Type your question here..." 
               class="flex-grow px-3 py-2 text-sm bg-gray-100 rounded-l-lg focus:outline-none focus:ring-1 focus:ring-[#C40F12]">
        <button id="sendMessage" class="gradient-bg text-white px-4 py-2 rounded-r-lg btn-hover flex items-center justify-center">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    </div>
  </div>
  
  <!-- Chat Button -->
  <button id="chatButton" class="gradient-bg text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all focus:outline-none btn-hover">
    <i class="fas fa-comment-dots text-xl"></i>
  </button>
</div>

</div>

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
        <span class="font-medium">Creditinfo Assistant</span>
      </div>
      <button id="closeChat" class="text-white hover:text-gray-200 focus:outline-none">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <!-- Language Selection Buttons (shown only at start) -->
    <div id="languageSelector" class="p-3 bg-gray-50 flex justify-center space-x-2">
      <button id="englishBtn" class="px-4 py-2 bg-[#C40F12] text-white rounded hover:bg-red-700 transition-colors">
        English
      </button>
      <button id="swahiliBtn" class="px-4 py-2 bg-[#C40F12] text-white rounded hover:bg-red-700 transition-colors">
        Kiswahili
      </button>
    </div>
    
    <!-- Chat Messages -->
    <div id="chatMessages" class="p-4 h-64 overflow-y-auto bg-gray-50">
      <div class="mb-3">
        <div class="bg-gray-200 text-gray-800 p-2 rounded-lg inline-block max-w-xs">
          <p class="text-sm">Welcome to Creditinfo Tanzania assistance! Please select your preferred language: English or Kiswahili?</p>
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
      <div id="loadingIndicator" class="hidden mt-2 text-xs text-center text-gray-500">
        <span id="loadingText" class="inline-block">Processing your request...</span>
      </div>
    </div>
  </div>
  
  <!-- Chat Button -->
  <button id="chatButton" class="gradient-bg text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all focus:outline-none btn-hover">
    <i class="fas fa-comment-dots text-xl"></i>
  </button>
</div>

<script>
  // Chat functionality with OpenRouter API integration
  document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.getElementById('chatButton');
    const chatWindow = document.getElementById('chatWindow');
    const closeChat = document.getElementById('closeChat');
    const chatInput = document.getElementById('chatInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatMessages = document.getElementById('chatMessages');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const loadingText = document.getElementById('loadingText');
    const languageSelector = document.getElementById('languageSelector');
    const englishBtn = document.getElementById('englishBtn');
    const swahiliBtn = document.getElementById('swahiliBtn');
    
    // OpenRouter API Configuration
    const OPENROUTER_API_KEY = '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';
    const AI_MODEL = 'deepseek/deepseek-chat-v3-0324:free';
    
    // Track selected language
    let selectedLanguage = null;
    
    // Company information in English
    const COMPANY_INFO_EN = `
    Creditinfo Tanzania provides intelligent information for business decisions and financial inclusion. Our services: 
    - Personal and company credit reports
    - Free annual credit report (plus after disputes/adverse actions)
    - Clearance certificates 
    - Pay-as-you-go subscription model
    - Creditinfo Predictor score (250-900) with risk grades
    
    Location: Tanzanite Park Building, 8th Floor, Victoria, Dar es Salaam
    Contact: info@creditinfo.co.tz
    `;
    
    // Company information in Swahili
    const COMPANY_INFO_SW = `
    Creditinfo Tanzania inatoa taarifa muhimu kwa maamuzi ya biashara na ujumuishaji wa kifedha. Huduma zetu:
    - Ripoti za mikopo za binafsi na kampuni
    - Ripoti ya mikopo ya bure kila mwaka (na baada ya migogoro/hatua mbaya)
    - Vyeti vya uthibitisho
    - Mpango wa kujisajili wa malipo-kama-unavyotumia
    - Alama ya Creditinfo Predictor (250-900) na madaraja ya hatari
    
    Mahali: Jengo la Tanzanite Park, Ghorofa ya 8, Victoria, Dar es Salaam
    Mawasiliano: info@creditinfo.co.tz
    `;
    
    // System prompt in English
    const SYSTEM_PROMPT_EN = `
    You are a helpful AI assistant for Creditinfo Tanzania. Answer questions ONLY based on the provided information. If you can't answer, suggest contacting info@creditinfo.co.tz or visiting our office.
    
    Keep responses SHORT (2-3 sentences maximum) and well-formatted without special characters.
    
    Never make up information not included in the provided context.
    `;
    
    // System prompt in Swahili
    const SYSTEM_PROMPT_SW = `
    Wewe ni msaidizi wa AI wa Creditinfo Tanzania. Jibu maswali TU kulingana na taarifa zilizotolewa. Ikiwa huwezi kujibu, pendekeza kuwasiliana na info@creditinfo.co.tz au kutembelea ofisi yetu.
    
    Weka majibu MAFUPI (sentensi 2-3 kwa upeo) na yaliyoundwa vizuri bila herufi maalum.
    
    Kamwe usibuni taarifa ambazo hazijajumuishwa katika muktadha uliotolewa.
    `;
    
    // Store conversation history
    let conversationHistory = [
      {
        role: "assistant",
        content: "Welcome to Creditinfo Tanzania assistance! Please select your preferred language: English or Kiswahili?"
      }
    ];
    
    // Function to set language
    function setLanguage(language) {
      selectedLanguage = language;
      
      // Hide language selector
      languageSelector.style.display = 'none';
      
      // Set system message based on selected language
      let systemMessage;
      let welcomeMessage;
      
      if (language === 'english') {
        systemMessage = SYSTEM_PROMPT_EN + "\n\nInformation about Creditinfo Tanzania:\n" + COMPANY_INFO_EN;
        welcomeMessage = 'Thank you! How can I help you today?';
        chatInput.placeholder = 'Type your question here...';
        loadingText.textContent = 'Processing your request...';
      } else {
        systemMessage = SYSTEM_PROMPT_SW + "\n\nTaarifa kuhusu Creditinfo Tanzania:\n" + COMPANY_INFO_SW;
        welcomeMessage = 'Asante! Nawezaje kukusaidia leo?';
        chatInput.placeholder = 'Andika swali lako hapa...';
        loadingText.textContent = 'Inaandaa jibu lako...';
      }
      
      // Reset conversation with system message and welcome
      conversationHistory = [
        {
          role: "system",
          content: systemMessage
        },
        {
          role: "assistant",
          content: welcomeMessage
        }
      ];
      
      // Clear chat messages and add welcome message
      chatMessages.innerHTML = '';
      const welcomeDiv = document.createElement('div');
      welcomeDiv.className = 'mb-3';
      welcomeDiv.innerHTML = `
        <div class="bg-gray-200 text-gray-800 p-2 rounded-lg inline-block max-w-xs">
          <p class="text-sm">${welcomeMessage}</p>
        </div>
      `;
      chatMessages.appendChild(welcomeDiv);
      
      // Focus on input
      chatInput.focus();
    }
    
    // Language button event listeners
    englishBtn.addEventListener('click', function() {
      setLanguage('english');
    });
    
    swahiliBtn.addEventListener('click', function() {
      setLanguage('swahili');
    });
    
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
    
    // Format email addresses to be clickable
    function formatEmailsToLinks(text) {
      return text.replace(/\b([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})\b/g, '<a href="mailto:$1">$1</a>');
    }
    
    // Call OpenRouter API
    async function callOpenRouterAPI(userMessage) {
      // Check if language is not selected yet
      if (selectedLanguage === null) {
        const lowercaseMessage = userMessage.toLowerCase();
        
        // Detect language selection from user input
        if (lowercaseMessage.includes('english') || lowercaseMessage.includes('ingereza')) {
          setLanguage('english');
          return "Language set to English";
        } else if (lowercaseMessage.includes('swahili') || lowercaseMessage.includes('kiswahili')) {
          setLanguage('swahili');
          return "Language set to Swahili";
        } else {
          // Prompt again for language selection
          return "Please select either \"English\" or \"Kiswahili\" to continue. / Tafadhali chagua \"English\" au \"Kiswahili\" kuendelea.";
        }
      }
      
      // Show loading indicator
      loadingIndicator.classList.remove('hidden');
      
      // Add user message to conversation history
      conversationHistory.push({
        role: "user",
        content: userMessage
      });
      
      try {
        const response = await fetch('https://openrouter.ai/api/v1/chat/completions', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${OPENROUTER_API_KEY}`
          },
          body: JSON.stringify({
            model: AI_MODEL,
            messages: conversationHistory,
            temperature: 0.2, // Lower temperature for more concise responses
            max_tokens: 250  // Limit response length for brevity
          })
        });
        
        if (!response.ok) {
          throw new Error(`API error: ${response.status}`);
        }
        
        const data = await response.json();
        const aiResponse = data.choices[0].message.content;
        
        // Add AI response to conversation history
        conversationHistory.push({
          role: "assistant",
          content: aiResponse
        });
        
        return aiResponse;
      } catch (error) {
        console.error('Error calling OpenRouter API:', error);
        
        // Language-specific error message
        if (selectedLanguage === 'english') {
          return 'Sorry, our service is experiencing technical difficulties. Please contact info@creditinfo.co.tz.';
        } else {
          return 'Samahani, huduma yetu inakumbana na matatizo ya kiufundi. Tafadhali wasiliana na info@creditinfo.co.tz.';
        }
      } finally {
        // Hide loading indicator
        loadingIndicator.classList.add('hidden');
      }
    }
    
    // Send message function
    async function sendUserMessage() {
      const message = chatInput.value.trim();
      if (message) {
        // Add user message to UI
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
        
        // Call API and get response
        const aiResponse = await callOpenRouterAPI(message);
        
        // Format emails as links in the response
        const formattedResponse = formatEmailsToLinks(aiResponse);
        
        // Add AI response to UI
        const botDiv = document.createElement('div');
        botDiv.className = 'mb-3';
        botDiv.innerHTML = `
          <div class="bg-gray-200 text-gray-800 p-2 rounded-lg inline-block max-w-xs">
            <p class="text-sm">${formattedResponse}</p>
          </div>
        `;
        chatMessages.appendChild(botDiv);
        
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

  // Ensure chat window is hidden on page load
  window.onload = function() {
    const chatWindow = document.getElementById('chatWindow');
    chatWindow.classList.add('hidden');
  };

  </script>
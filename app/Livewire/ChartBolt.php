<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ChartBolt extends Component
{
    public $userMessage = '';
    public $conversation = [];
    public $isLoading = false;
    public $selectedLanguage = null;

    // Company information in English
    private const COMPANY_INFO_EN = "
    Creditinfo Tanzania provides intelligent information for business decisions and financial inclusion. Our services: 
    - Personal and company credit reports
    - Free annual credit report (plus after disputes/adverse actions)
    - Clearance certificates 
    - Pay-as-you-go subscription model
    - Creditinfo Predictor score (250-900) with risk grades
    
    Location: Tanzanite Park Building, 8th Floor, Victoria, Dar es Salaam
    Contact: info@creditinfo.co.tz
    ";

    // Company information in Swahili
    private const COMPANY_INFO_SW = "
    Creditinfo Tanzania inatoa taarifa muhimu kwa maamuzi ya biashara na ujumuishaji wa kifedha. Huduma zetu:
    - Ripoti za mikopo za binafsi na kampuni
    - Ripoti ya mikopo ya bure kila mwaka (na baada ya migogoro/hatua mbaya)
    - Vyeti vya uthibitisho
    - Mpango wa kujisajili wa malipo-kama-unavyotumia
    - Alama ya Creditinfo Predictor (250-900) na madaraja ya hatari
    
    Mahali: Jengo la Tanzanite Park, Ghorofa ya 8, Victoria, Dar es Salaam
    Mawasiliano: info@creditinfo.co.tz
    ";

    // System prompt in English
    private const SYSTEM_PROMPT_EN = "
    You are a helpful AI assistant for Creditinfo Tanzania. Answer questions ONLY based on the provided information. If you can't answer, suggest contacting info@creditinfo.co.tz or visiting our office.
    
    Keep responses SHORT (2-3 sentences maximum) and well-formatted without special characters.
    
    Never make up information not included in the provided context.
    ";

    // System prompt in Swahili
    private const SYSTEM_PROMPT_SW = "
    Wewe ni msaidizi wa AI wa Creditinfo Tanzania. Jibu maswali TU kulingana na taarifa zilizotolewa. Ikiwa huwezi kujibu, pendekeza kuwasiliana na info@creditinfo.co.tz au kutembelea ofisi yetu.
    
    Weka majibu MAFUPI (sentensi 2-3 kwa upeo) na yaliyoundwa vizuri bila herufi maalum.
    
    Kamwe usibuni taarifa ambazo hazijajumuishwa katika muktadha uliotolewa.
    ";

    public function mount()
    {
        // Initialize conversation with language selection prompt
        $this->conversation = [
            [
                'role' => 'assistant',
                'content' => 'Welcome to Creditinfo Tanzania assistance! Please select your preferred language: English or Kiswahili?'
            ]
        ];
    }

    public function setLanguage($language)
    {
        $this->selectedLanguage = $language;
        
        // Add system message based on selected language
        if ($language === 'english') {
            $systemMessage = self::SYSTEM_PROMPT_EN . "\n\nInformation about Creditinfo Tanzania:\n" . self::COMPANY_INFO_EN;
            $welcomeMessage = 'Thank you! How can I help you today?';
        } else {
            $systemMessage = self::SYSTEM_PROMPT_SW . "\n\nTaarifa kuhusu Creditinfo Tanzania:\n" . self::COMPANY_INFO_SW;
            $welcomeMessage = 'Asante! Nawezaje kukusaidia leo?';
        }
        
        // Update conversation with system message and welcome
        $this->conversation = [
            [
                'role' => 'system',
                'content' => $systemMessage
            ],
            [
                'role' => 'assistant',
                'content' => $welcomeMessage
            ]
        ];
    }

    public function sendMessage()
    {
        if (empty($this->userMessage)) {
            return;
        }
        
        // Check if language is not selected yet
        if ($this->selectedLanguage === null) {
            $lowercaseMessage = strtolower($this->userMessage);
            
            // Detect language selection from user input
            if (strpos($lowercaseMessage, 'english') !== false || 
                strpos($lowercaseMessage, 'ingereza') !== false) {
                $this->setLanguage('english');
                $this->userMessage = '';
                return;
            } elseif (strpos($lowercaseMessage, 'swahili') !== false || 
                     strpos($lowercaseMessage, 'kiswahili') !== false) {
                $this->setLanguage('swahili');
                $this->userMessage = '';
                return;
            } else {
                // Prompt again for language selection
                $this->conversation[] = [
                    'role' => 'user',
                    'content' => $this->userMessage
                ];
                
                $this->conversation[] = [
                    'role' => 'assistant',
                    'content' => 'Please select either "English" or "Kiswahili" to continue. / Tafadhali chagua "English" au "Kiswahili" kuendelea.'
                ];
                
                $this->userMessage = '';
                return;
            }
        }

        // Add user message to conversation
        $this->conversation[] = [
            'role' => 'user',
            'content' => $this->userMessage
        ];

        $message = $this->userMessage;
        $this->userMessage = ''; // Clear input field
        $this->isLoading = true;

        // Prepare messages for API - exclude system message from display but include for API
        $apiMessages = $this->conversation;

        try {
            // Call OpenRouter API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('services.openrouter.api_key', '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')
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-chat-v3-0324:free',
                'messages' => $apiMessages,
                'temperature' => 0.2, // Lower temperature for more concise responses
                'max_tokens' => 250  // Limit response length for brevity
            ]);

            if ($response->successful()) {
                $aiMessage = $response->json('choices.0.message.content');
                
                // Format email addresses with proper HTML for clickability
                $aiMessage = preg_replace('/\b([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})\b/', '<a href="mailto:$1">$1</a>', $aiMessage);
                
                // Add AI response to conversation
                $this->conversation[] = [
                    'role' => 'assistant',
                    'content' => $aiMessage
                ];
            } else {
                // Handle error with language-specific message
                $errorMessage = $this->selectedLanguage === 'english' 
                    ? 'I apologize, but I encountered a technical issue. Please contact Creditinfo Tanzania at <a href="mailto:info@creditinfo.co.tz">info@creditinfo.co.tz</a>.'
                    : 'Samahani, nimekumbana na hitilafu ya kiufundi. Tafadhali wasiliana na Creditinfo Tanzania kupitia <a href="mailto:info@creditinfo.co.tz">info@creditinfo.co.tz</a>.';
                
                $this->conversation[] = [
                    'role' => 'assistant',
                    'content' => $errorMessage
                ];
            }
        } catch (\Exception $e) {
            // Log error and add language-specific error message
            logger()->error('OpenRouter API Error: ' . $e->getMessage());
            
            $errorMessage = $this->selectedLanguage === 'english' 
                ? 'Sorry, our service is experiencing technical difficulties. Please contact <a href="mailto:info@creditinfo.co.tz">info@creditinfo.co.tz</a>.'
                : 'Samahani, huduma yetu inakumbana na matatizo ya kiufundi. Tafadhali wasiliana na <a href="mailto:info@creditinfo.co.tz">info@creditinfo.co.tz</a>.';
            
            $this->conversation[] = [
                'role' => 'assistant',
                'content' => $errorMessage
            ];
        } finally {
            $this->isLoading = false;
        }
    }

    public function getDisplayConversationProperty()
    {
        // Filter out system messages for display to users
        return array_values(array_filter($this->conversation, function($message) {
            return $message['role'] !== 'system';
        }));
    }

    public function render()
    {
        return view('livewire.chart-bolt');
    }
}
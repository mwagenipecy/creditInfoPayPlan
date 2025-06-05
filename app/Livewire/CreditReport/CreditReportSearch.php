<?php

namespace App\Livewire\CreditReport;


use Livewire\Component;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ReportLog;

use App\Models\Account;
use App\Models\AccountUsageLog;
use Illuminate\Support\Facades\DB;


class CreditReportSearch extends Component
{
    public $fullName = '';
    public $idNumber = '';
    public $idNumberType = 'NationalID';
    public $phoneNumber = '';
    
    public $isSearching = false;
    public $searchResults = [];
    public $errorMessage = '';
    
    public $selectedId = null;
    public $isLoadingReport = false;
    public $reportData = null;
    public $reportError = '';
    public $reportUrl = null;
    protected $rules = [
        'fullName' => 'required_without_all:idNumber,phoneNumber',
    ];
    // public function search()
    // {
    //     $this->validate();
        
    //     $this->isSearching = true;
    //     $this->errorMessage = '';
    //     $this->searchResults = [];
    //     $this->selectedId = null;
    //     $this->reportData = null;
    //     $this->reportUrl = null;
        
    //     try {
    //         $results = $this->searchIndividual();
    //         $this->searchResults = $results;

    //     } catch (\Exception $e) {
    //         Log::error('Search failed: ' . $e->getMessage());
    //         $this->errorMessage = 'Search failed: ' . $e->getMessage();
    //     }
        
    //     $this->isSearching = false;
    // }


    private function searchIndividual()
    {
        $client = new Client();
        
        // Properly format and escape input values
        $soapXml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cb5="http://creditinfo.com/CB5" xmlns:sear="http://creditinfo.com/CB5/v5.73/Search">
           <soapenv:Header/>
           <soapenv:Body>
              <cb5:SearchIndividual>
                 <cb5:query>
                    <sear:Parameters>
                       <sear:FullName>' . htmlspecialchars($this->fullName) . '</sear:FullName>
                       <sear:IdNumber>' . htmlspecialchars($this->idNumber) . '</sear:IdNumber>
                       <sear:IdNumberType>' . htmlspecialchars($this->idNumberType) . '</sear:IdNumberType>
                       <sear:PhoneNumber>' . htmlspecialchars($this->phoneNumber ?: '?') . '</sear:PhoneNumber>
                    </sear:Parameters>
                 </cb5:query>
              </cb5:SearchIndividual>
           </soapenv:Body>
        </soapenv:Envelope>';
        
        // Log the request for debugging
        Log::debug('SOAP Request: ' . $soapXml);
        
        try {
            // Set up request with robust error handling options
            $options = [
                'headers' => [
                    'Content-Type' => 'text/xml;charset=UTF-8',
                    'SOAPAction' => 'http://creditinfo.com/CB5/IReportPublicServiceBase/SearchIndividual',
                    'Accept-Encoding' => 'gzip, deflate, br'
                ],
                'body' => $soapXml,
                'auth' => ['nbcemkopo', 'nbcEmkopo213'],
                'http_errors' => false, // Don't throw exceptions for HTTP errors
                'timeout' => 30, // 30 second timeout
                'connect_timeout' => 10, // 10 second connect timeout
                'verify' => true, // Verify SSL certificates
                'debug' => false, // Set to true for verbose debugging information
            ];
            
            // Execute the request with retry logic
            $maxRetries = 2;
            $attempts = 0;
            $lastException = null;
            
            while ($attempts <= $maxRetries) {
                try {
                    $response = $client->post('https://ws-stage.creditinfo.co.tz/WsReport/v5.73/service.svc', $options);
                    
                    // Check status code
                    $statusCode = $response->getStatusCode();
                    if ($statusCode >= 200 && $statusCode < 300) {
                        // Success, parse the response
                        $responseBody = $response->getBody()->getContents();
                        Log::debug('SOAP Response Status: ' . $statusCode);
                        Log::debug('SOAP Response Body: ' . substr($responseBody, 0, 1000) . (strlen($responseBody) > 1000 ? '...' : ''));
                        
                        return $this->parseSearchResponse($responseBody);
                    } else {
                        // HTTP error
                        $responseBody = $response->getBody()->getContents();
                        Log::error('SOAP Error Response: Status ' . $statusCode);
                        Log::error('Response Body: ' . substr($responseBody, 0, 1000) . (strlen($responseBody) > 1000 ? '...' : ''));
                        
                        throw new \Exception("HTTP Error: Received status code $statusCode from the server.");
                    }
                } catch (\GuzzleHttp\Exception\ConnectException $e) {
                    // Connection errors might be temporary - we can retry these
                    $lastException = $e;
                    Log::warning("Connection attempt $attempts failed: " . $e->getMessage());
                    $attempts++;
                    
                    if ($attempts <= $maxRetries) {
                        // Wait before retrying (exponential backoff)
                        sleep(pow(2, $attempts));
                    }
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    // Request errors - check if we should retry
                    $lastException = $e;
                    Log::warning("Request attempt $attempts failed: " . $e->getMessage());
                    
                    // Only retry on timeout or server errors (5xx)
                    $shouldRetry = false;
                    if ($e instanceof \GuzzleHttp\Exception\ServerException || 
                        $e instanceof \GuzzleHttp\Exception\ConnectException) {
                        $shouldRetry = true;
                    }
                    
                    if ($shouldRetry && $attempts < $maxRetries) {
                        $attempts++;
                        sleep(pow(2, $attempts));
                    } else {
                        // Don't retry other types of exceptions
                        break;
                    }
                } catch (\Exception $e) {
                    // General exceptions - don't retry
                    $lastException = $e;
                    Log::error('SOAP Exception: ' . $e->getMessage());
                    break;
                }
            }
            
            // If we got here, all retries failed or we encountered a non-retryable error
            if ($lastException) {
                if ($lastException instanceof \GuzzleHttp\Exception\ConnectException) {
                    throw new \Exception('Connection to credit information service timed out. Please try again later.');
                } else {
                    throw new \Exception('Error connecting to credit information service: ' . $lastException->getMessage());
                }
            }
            
            throw new \Exception('Unknown error when connecting to credit information service.');
            
        } catch (\Exception $e) {
            Log::error('Search individual failed: ' . $e->getMessage());
            Log::error('Request XML: ' . $soapXml);
            
            // Format user-friendly error message
            $errorMessage = $this->formatUserFriendlyErrorMessage($e);
            throw new \Exception($errorMessage);
        }
    }    
    /**
     * Create a user-friendly error message from exception
     */
    private function formatUserFriendlyErrorMessage(\Exception $e)
    {
        $message = $e->getMessage();
        
        // Connection timeout
        if (stripos($message, 'cURL error 28') !== false || 
            stripos($message, 'timeout') !== false) {
            return 'Connection to credit service timed out. Please try again later.';
        }
        
        // Connection refused
        if (stripos($message, 'connection refused') !== false) {
            return 'Credit service is currently unavailable. Please try again later.';
        }
        
        // Authentication error
        if (stripos($message, '401') !== false || 
            stripos($message, 'Unauthorized') !== false) {
            return 'Authentication with credit service failed. Please contact support.';
        }
        
        // Server error
        if (stripos($message, '500') !== false || 
            stripos($message, 'Internal Server Error') !== false) {
            return 'Credit service encountered an internal error. Please try again later.';
        }
        
        // Default
        return 'Credit search failed: ' . $message;
    }

    private function parseSearchResponse($xml)
    {
        $xml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$3', $xml);
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        
        if (!isset($array['Body']['SearchIndividualResponse']['SearchIndividualResult']['IndividualRecords']['SearchIndividualRecord'])) {
            return [];
        }
        
        $records = $array['Body']['SearchIndividualResponse']['SearchIndividualResult']['IndividualRecords']['SearchIndividualRecord'];
        
        // Ensure records is an array even if only one result is returned
        if (!isset($records[0])) {
            $records = [$records];
        }
        
        return $records;
    }
    public function getReport($creditinfoId)
    {
        
        Log::info("Starting credit report retrieval for ID: {$creditinfoId}");
    
        $this->selectedId = $creditinfoId;
        $this->isLoadingReport = true;
        $this->reportError = '';
        $this->reportData = null;
        $this->reportUrl = null;
        
        $startTime = microtime(true);
        
        try {

            $this->checkUserPermissions();


            Log::info("Fetching PDF report for credit info ID: {$creditinfoId}", [
                'user_id' => auth()->id() ?? 'guest',
                'session_id' => session()->getId(),
                'ip_address' => request()->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);
            
            // Fetch the PDF data from the API
            $pdfData = $this->fetchPdfReport($creditinfoId);
            $dataSize = strlen($pdfData ?? '');
            
            Log::info("PDF data received successfully", [
                'credit_info_id' => $creditinfoId,
                'data_size' => $dataSize,
                'response_time' => round(microtime(true) - $startTime, 2) . 's'
            ]);
            
            // Validate the PDF data
            if (empty($pdfData)) {
                throw new \Exception("Received empty PDF data from the API");
            }
            
            // Check if the data is valid base64
            if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $pdfData)) {
                Log::warning("Received non-base64 data from API", [
                    'data_preview' => substr($pdfData, 0, 100) . '...',
                ]);
                // Try to clean the base64 string - remove whitespace and invalid characters
                $pdfData = preg_replace('/\s+/', '', $pdfData);
                $pdfData = preg_replace('/[^a-zA-Z0-9\/+]/', '', $pdfData) . str_repeat('=', strlen($pdfData) % 4);
                
                Log::info("Attempted to clean base64 data", [
                    'cleaned_data_length' => strlen($pdfData),
                    'cleaned_data_preview' => substr($pdfData, 0, 100) . '...',
                ]);
            }
            
            $this->reportData = $pdfData;
            
            // Generate a unique filename for zip and extracted files
            $zipFileName = 'credit_report_' . $creditinfoId . '_' . time() . '_' . Str::random(8) . '.zip';
            $extractDir = 'credit_reports/' . $creditinfoId . '_' . time() . '_' . Str::random(8);
            
            // Ensure the storage directories exist
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }
            if (!file_exists(storage_path('app/public/credit_reports'))) {
                mkdir(storage_path('app/public/credit_reports'), 0755, true);
            }
            
            Log::info("Decoding base64 data and processing zip file", [
                'zip_filename' => $zipFileName,
                'extract_dir' => $extractDir,
                'disk' => 'public'
            ]);
            
            $startSaveTime = microtime(true);
            
            // Decode the base64 data with error handling
            try {
                $decodedData = base64_decode($pdfData, true);
                if ($decodedData === false) {
                    // Try again with more lenient parameters
                    $decodedData = base64_decode($pdfData, false);
                    if ($decodedData === false) {
                        throw new \Exception("Invalid base64 data received from API");
                    }
                    Log::info("Base64 decoded successfully with lenient parameters");
                }
                $zipSizeBytes = strlen($decodedData);
                
                // Check if the data appears to be a PDF directly (not zipped)
                $isPdf = (substr($decodedData, 0, 4) === '%PDF');
                $isZip = (!$isPdf && (substr($decodedData, 0, 2) === 'PK'));
                
                Log::info("Decoded data analysis", [
                    'size_bytes' => $zipSizeBytes,
                    'appears_to_be_pdf' => $isPdf,
                    'appears_to_be_zip' => $isZip,
                    'first_bytes' => bin2hex(substr($decodedData, 0, 16))
                ]);
                
            } catch (\Exception $e) {
                Log::error("Base64 decoding failed", [
                    'error' => $e->getMessage(),
                    'data_sample' => substr($pdfData, 0, 50) . '...'
                ]);
                throw new \Exception("Failed to decode base64 data: " . $e->getMessage());
            }
            
            // Create temporary file for the zip
            $tempZipPath = storage_path('app/temp/' . $zipFileName);
            if (!file_exists(dirname($tempZipPath))) {
                mkdir(dirname($tempZipPath), 0755, true);
            }
            
            // Save the decoded zip data to the temporary file
            file_put_contents($tempZipPath, $decodedData);
            
            Log::info("Temporary zip file saved", [
                'temp_path' => $tempZipPath,
                'file_size' => $zipSizeBytes . ' bytes'
            ]);
            
            // Create extraction directory
            $extractPath = storage_path('app/public/' . $extractDir);
            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0755, true);
            }
            
            // First attempt: Try using ZipArchive
            $useAlternativeMethod = false;
            $zipErrorMessage = '';
            
            try {
                // Open the zip archive
                $zip = new \ZipArchive();
                $zipResult = $zip->open($tempZipPath);
                
                if ($zipResult !== true) {
                    $zipErrorMessage = "ZipArchive couldn't open file, error code: {$zipResult}";
                    Log::warning($zipErrorMessage);
                    $useAlternativeMethod = true;
                } else {
                    // Extract the contents with error checking
                    if (!$zip->extractTo($extractPath)) {
                        $lastError = error_get_last();
                        $zipErrorMessage = "ZipArchive couldn't extract: " . ($lastError ? $lastError['message'] : 'Unknown extraction error');
                        Log::warning($zipErrorMessage);
                        $useAlternativeMethod = true;
                    } else {
                        $fileCount = $zip->numFiles;
                        Log::info("Zip file extracted successfully using ZipArchive", [
                            'extract_path' => $extractPath,
                            'file_count' => $fileCount
                        ]);
                    }
                    $zip->close();
                }
            } catch (\Exception $zipEx) {
                $zipErrorMessage = "ZipArchive exception: " . $zipEx->getMessage();
                Log::warning($zipErrorMessage);
                $useAlternativeMethod = true;
            }
            
            // Second attempt: If ZipArchive failed, try using system unzip command
            if ($useAlternativeMethod) {
                Log::info("Attempting alternative unzip method using system command", [
                    'original_error' => $zipErrorMessage
                ]);
                
                // Check if unzip command exists
                $unzipExists = false;
                try {
                    exec('which unzip', $output, $returnVar);
                    $unzipExists = $returnVar === 0;
                } catch (\Exception $e) {
                    $unzipExists = false;
                }
                
                if ($unzipExists) {
                    // Use system unzip command
                    $command = "unzip -o " . escapeshellarg($tempZipPath) . " -d " . escapeshellarg($extractPath) . " 2>&1";
                    exec($command, $output, $returnCode);
                    
                    if ($returnCode !== 0) {
                        $outputStr = implode("\n", $output);
                        Log::error("System unzip command failed", [
                            'command' => $command,
                            'return_code' => $returnCode,
                            'output' => $outputStr
                        ]);
                        
                        // If both methods fail, check if we can directly use the content as a PDF
                        if (substr($decodedData, 0, 4) === '%PDF') {
                            Log::info("Content appears to be a direct PDF rather than a zip. Saving directly.");
                            $pdfPath = $extractPath . '/direct.pdf';
                            file_put_contents($pdfPath, $decodedData);
                            
                            // Verify the file was created
                            if (file_exists($pdfPath) && filesize($pdfPath) > 0) {
                                Log::info("Successfully saved direct PDF file", [
                                    'path' => $pdfPath,
                                    'size' => filesize($pdfPath)
                                ]);
                            } else {
                                throw new \Exception("Failed to save direct PDF: " . 
                                    "ZipArchive failed ({$zipErrorMessage}), " .
                                    "system unzip failed (code {$returnCode}: {$outputStr})");
                            }
                        } else {
                            throw new \Exception("All unzip methods failed: " . 
                                "ZipArchive failed ({$zipErrorMessage}), " .
                                "system unzip failed (code {$returnCode}: {$outputStr})");
                        }
                    } else {
                        Log::info("Zip file extracted successfully using system unzip command", [
                            'extract_path' => $extractPath,
                        ]);
                    }
                } else {
                    // If unzip doesn't exist and the content appears to be a direct PDF
                    if (substr($decodedData, 0, 4) === '%PDF') {
                        Log::info("Content appears to be a direct PDF rather than a zip. Saving directly.");
                        $pdfPath = $extractPath . '/direct.pdf';
                        file_put_contents($pdfPath, $decodedData);
                        
                        if (!file_exists($pdfPath) || filesize($pdfPath) === 0) {
                            throw new \Exception("Failed to save direct PDF and all unzip methods failed: " . $zipErrorMessage);
                        }
                        
                        Log::info("Successfully saved direct PDF file", [
                            'path' => $pdfPath,
                            'size' => filesize($pdfPath)
                        ]);
                    } else {
                        throw new \Exception("Failed to unzip: ZipArchive failed ({$zipErrorMessage}) and system unzip command is not available");
                    }
                }
            }
            
            // Find PDF file(s) in the extracted directory (case insensitive search)
            $pdfFiles = array_merge(
                glob($extractPath . '/*.pdf'),
                glob($extractPath . '/*.PDF')
            );
            
            // Also search in subdirectories
            $dirIterator = new \RecursiveDirectoryIterator($extractPath);
            $iterator = new \RecursiveIteratorIterator($dirIterator);
            foreach ($iterator as $file) {
                if ($file->isFile() && preg_match('/\.(pdf|PDF)$/', $file->getFilename())) {
                    $pdfFiles[] = $file->getPathname();
                }
            }
            
            // Log the search results
            Log::info("PDF file search results", [
                'search_path' => $extractPath,
                'files_found' => count($pdfFiles),
                'files' => $pdfFiles
            ]);
            
            if (empty($pdfFiles)) {
                // List all files in the extracted directory for debugging
                $allFiles = [];
                $dirIterator = new \RecursiveDirectoryIterator($extractPath);
                $iterator = new \RecursiveIteratorIterator($dirIterator);
                foreach ($iterator as $file) {
                    if ($file->isFile()) {
                        $allFiles[] = $file->getPathname();
                    }
                }
                
                Log::warning("No PDF files found in the extracted zip", [
                    'all_extracted_files' => $allFiles
                ]);
                
                throw new \Exception("No PDF files found in the extracted zip");
            }
            
            // Use the first PDF file (or implement your own logic to choose the right file)
            $mainPdfFile = $pdfFiles[0];
            $pdfFileName = basename($mainPdfFile);
            
            // Get the relative path to the public storage
            $relativePathFromPublic = str_replace(storage_path('app/public/'), '', $mainPdfFile);
            
            // Generate the public URL directly from the extracted PDF's location
            $this->reportUrl = Storage::disk('public')->url($relativePathFromPublic);
            
            Log::info("PDF URL generated successfully", [
                'pdf_file' => $mainPdfFile,
                'relative_path' => $relativePathFromPublic,
                'url' => $this->reportUrl
            ]);
            
            // Clean up temporary files
            @unlink($tempZipPath);
            
            // Log this report retrieval
            $this->logReportRetrieval($creditinfoId);
            
            Log::info("Credit report retrieval completed successfully", [
                'credit_info_id' => $creditinfoId,
                'total_time' => round(microtime(true) - $startTime, 2) . 's'
            ]);
        } catch (\Exception $e) {
            $errorTime = round(microtime(true) - $startTime, 2);
            
            Log::error("Failed to retrieve credit report", [
                'credit_info_id' => $creditinfoId,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'time_elapsed' => $errorTime . 's',
                'trace' => $e->getTraceAsString()
            ]);
            
            // Provide a more user-friendly error message
            $userMessage = $this->getUserFriendlyErrorMessage($e);
            $this->reportError = $userMessage;
            
            // Also log the user-friendly error message
            Log::info("Displaying user-friendly error: {$userMessage}");
        } finally {
            $this->isLoadingReport = false;
            
            Log::info("Credit report retrieval process completed", [
                'credit_info_id' => $creditinfoId,
                'total_time' => round(microtime(true) - $startTime, 2) . 's',
                'status' => $this->reportError ? 'error' : 'success'
            ]);
        }
    }
    /**
     * Generate a more user-friendly error message
     */
    private function getUserFriendlyErrorMessage(\Exception $e)
    {
        $message = $e->getMessage();
        
        // Handle common error cases
        if (strpos($message, 'timeout') !== false || strpos($message, 'timed out') !== false) {
            return 'The report service is taking too long to respond. Please try again later.';
        }
        
        if (strpos($message, 'empty PDF data') !== false) {
            return 'The credit information service returned an empty report. Please try again.';
        }
        
        if (strpos($message, '500') !== false || strpos($message, 'Internal Server Error') !== false) {
            return 'The credit information service encountered a server error. Please try again later.';
        }
        
        if (strpos($message, '401') !== false || strpos($message, 'Unauthorized') !== false) {
            return 'Authentication error with the credit information service. Please contact support.';
        }
        
        if (strpos($message, '404') !== false || strpos($message, 'Not Found') !== false) {
            return 'The requested credit report could not be found.';
        }
        
        if (strpos($message, 'base64') !== false) {
            return 'The report data was received in an invalid format. Please try again.';
        }
        
        // Default message for unknown errors
        return 'Failed to retrieve report: ' . $message;
    }
    /**
     * Helper function to generate a random string
     */
    private function str_random($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }    
    private function fetchPdfReport($creditinfoId)
    {
        $client = new Client();
        
        $soapXml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cb5="http://creditinfo.com/CB5" xmlns:cus="http://creditinfo.com/CB5/v5.73/CustomReport">
           <soapenv:Header/>
           <soapenv:Body>
              <cb5:GetPdfReport>
                 <cb5:parameters>
                    <cus:Consent>true</cus:Consent>
                    <cus:IDNumber>' . $creditinfoId . '</cus:IDNumber>
                    <cus:IDNumberType>CreditinfoId</cus:IDNumberType>
                    <cus:InquiryReason>ApplicationForCreditOrAmendmentOfCreditTerms</cus:InquiryReason>
                    <cus:InquiryReasonText>Testing Purposes</cus:InquiryReasonText>
                    <cus:LanguageCode>en-GB</cus:LanguageCode>
                    <cus:ReportName>CreditinfoReport</cus:ReportName>
                    <cus:SubjectType>Individual</cus:SubjectType>
                 </cb5:parameters>
              </cb5:GetPdfReport>
           </soapenv:Body>
        </soapenv:Envelope>';
        
        $response = $client->post('https://ws-stage.creditinfo.co.tz/WsReport/v5.73/service.svc', [
            'headers' => [
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction' => 'http://creditinfo.com/CB5/IReportPublicServiceBase/GetPdfReport',
            ],
            'body' => $soapXml,
            'auth' => ['nbcemkopo', 'nbcEmkopo213'],
        ]);
        
        $responseBody = $response->getBody()->getContents();
        return $this->parsePdfResponse($responseBody);
    }

    private function parsePdfResponse($xml)
    {
        $xml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$3', $xml);
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        
        if (!isset($array['Body']['GetPdfReportResponse']['GetPdfReportResult'])) {
            throw new \Exception('PDF data not found in response');
        }
        
        return $array['Body']['GetPdfReportResponse']['GetPdfReportResult'];
    }
    
    // private function logReportRetrieval($creditinfoId)
    // {
    //     // Assuming we have authentication
    //     if (auth()->check()) {
    //         ReportLog::create([
    //             'user_id' => auth()->id(),
    //             'creditinfo_id' => $creditinfoId,
    //             'retrieved_at' => now(),
    //         ]);
    //     }
    // }
    
    // public function render()
    // {
    //     $reportCount = 0;
    //     if (auth()->check()) {
    //         $reportCount = ReportLog::where('user_id', auth()->id())->count();
    //     }
        
    //     return view('livewire.credit-report.credit-report-search', [
    //         'reportCount' => $reportCount
    //     ]);
    // }




    private function logReportRetrieval($creditinfoId)
{
    // Ensure user is authenticated and has a company
    if (!auth()->check() || !auth()->user()->company_id) {
        Log::warning('Report retrieval attempted without proper authentication or company', [
            'user_id' => auth()->id(),
            'creditinfo_id' => $creditinfoId,
        ]);
        return;
    }

    $userId = auth()->id();
    $companyId = auth()->user()->company_id;

    try {
        DB::beginTransaction();

        // Check if this creditinfo_id has been retrieved by this company before
        $existingReport = ReportLog::whereHas('user', function($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
        ->where('creditinfo_id', $creditinfoId)
        ->first();

        $shouldCountUsage = !$existingReport; // Only count if it's a new credit report for this company

        Log::info('Report retrieval check', [
            'creditinfo_id' => $creditinfoId,
            'company_id' => $companyId,
            'user_id' => $userId,
            'existing_report_found' => (bool)$existingReport,
            'should_count_usage' => $shouldCountUsage,
        ]);

        // Always log the report retrieval (for audit purposes)
        $reportLog = ReportLog::create([
            'user_id' => $userId,
            'creditinfo_id' => $creditinfoId,
            'retrieved_at' => now(),
        ]);

        Log::info('Report log created', [
            'report_log_id' => $reportLog->id,
            'creditinfo_id' => $creditinfoId,
            'user_id' => $userId,
        ]);

        // Only deduct usage if this is a new credit report for the company
        if ($shouldCountUsage) {
            $this->processUsageDeduction($companyId, $creditinfoId);
        } else {
            Log::info('Usage not deducted - credit report already retrieved by company', [
                'creditinfo_id' => $creditinfoId,
                'company_id' => $companyId,
                'existing_report_id' => $existingReport->id,
            ]);
        }

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        
        Log::error('Error in report retrieval logging', [
            'creditinfo_id' => $creditinfoId,
            'user_id' => $userId,
            'company_id' => $companyId,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        // Just log the error
    }
}

private function processUsageDeduction($companyId, $creditinfoId)
{
    // Get the oldest active account for this company with remaining reports
    $account = Account::where('company_id', $companyId)
        ->where('status', 'active')
        ->where('remaining_reports', '>', 0)
        ->where('valid_until', '>', now())
        ->orderBy('created_at', 'asc') // Oldest first
        ->first();

    if (!$account) {
        Log::warning('No active account with remaining reports found for company', [
            'company_id' => $companyId,
            'creditinfo_id' => $creditinfoId,
        ]);
        
        // Check if there are any accounts that might need status updates
        $this->checkAndUpdateExpiredAccounts($companyId);
        return;
    }

    Log::info('Found account for usage deduction', [
        'account_id' => $account->id,
        'account_number' => $account->account_number,
        'remaining_reports' => $account->remaining_reports,
        'company_id' => $companyId,
    ]);

    // Deduct one report from the account
    $newRemainingReports = $account->remaining_reports - 1;
    
    // Update the account
    $account->update([
        'remaining_reports' => $newRemainingReports,
        'last_used' => now(),
    ]);

    // Log the usage
    AccountUsageLog::create([
        'account_id' => $account->id,
        'reports_used' => 1,
        'remaining_reports' => $newRemainingReports,
        'action_type' => 'report_generation',
        'metadata' => json_encode([
            'creditinfo_id' => $creditinfoId,
            'user_id' => auth()->id(),
            'report_type' => 'credit_report',
            'deduction_reason' => 'new_credit_report_for_company',
        ]),
        'used_at' => now(),
    ]);

    Log::info('Usage deducted and logged', [
        'account_id' => $account->id,
        'account_number' => $account->account_number,
        'reports_used' => 1,
        'remaining_reports' => $newRemainingReports,
        'creditinfo_id' => $creditinfoId,
    ]);

    // Check if account should be closed due to zero remaining reports
    if ($newRemainingReports <= 0) {
        $this->closeAccountDueToUsage($account);
    }

    // Also check for any expired accounts that need status updates
    $this->checkAndUpdateExpiredAccounts($companyId);
}

private function closeAccountDueToUsage(Account $account)
{
    $account->update([
        'status' => 'expired',
    ]);

    Log::info('Account closed due to zero remaining reports', [
        'account_id' => $account->id,
        'account_number' => $account->account_number,
        'company_id' => $account->company_id,
        'closure_reason' => 'zero_remaining_reports',
    ]);

    // Log the account closure
    AccountUsageLog::create([
        'account_id' => $account->id,
        'reports_used' => 0,
        'remaining_reports' => 0,
        'action_type' => 'account_closure',
        'metadata' => json_encode([
            'closure_reason' => 'zero_remaining_reports',
            'closed_at' => now()->toDateTimeString(),
            'closed_by_system' => true,
        ]),
        'used_at' => now(),
    ]);
}

private function checkAndUpdateExpiredAccounts($companyId)
{
    // Find accounts that have passed their valid_until date but are still active
    $expiredAccounts = Account::where('company_id', $companyId)
        ->where('status', 'active')
        ->where('valid_until', '<=', now())
        ->get();

    foreach ($expiredAccounts as $account) {
        $account->update([
            'status' => 'expired',
        ]);

        Log::info('Account closed due to expiration date', [
            'account_id' => $account->id,
            'account_number' => $account->account_number,
            'company_id' => $account->company_id,
            'valid_until' => $account->valid_until,
            'closure_reason' => 'expiration_date_reached',
        ]);

        // Log the account closure
        AccountUsageLog::create([
            'account_id' => $account->id,
            'reports_used' => 0,
            'remaining_reports' => $account->remaining_reports,
            'action_type' => 'account_closure',
            'metadata' => json_encode([
                'closure_reason' => 'expiration_date_reached',
                'valid_until' => $account->valid_until->toDateTimeString(),
                'closed_at' => now()->toDateTimeString(),
                'closed_by_system' => true,
            ]),
            'used_at' => now(),
        ]);
    }

    if ($expiredAccounts->count() > 0) {
        Log::info('Expired accounts updated', [
            'company_id' => $companyId,
            'accounts_closed' => $expiredAccounts->count(),
        ]);
    }
}

// Update the render method to show company-level report count
public function render()
{
    $reportCount = 0;
    $remainingReports = 0;
    $activeAccounts = collect();
    
    if (auth()->check() && auth()->user()->company_id) {
        $companyId = auth()->user()->company_id;
        
        // Get total reports retrieved by this company (unique creditinfo_ids)
        $reportCount = ReportLog::whereHas('user', function($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
        ->distinct('creditinfo_id')
        ->count('creditinfo_id');

        // Get active accounts for this company
        $activeAccounts = Account::where('company_id', $companyId)
            ->where('status', 'active')
            ->where('valid_until', '>', now())
            ->orderBy('created_at', 'asc')
            ->get();

        // Calculate total remaining reports
        $remainingReports = $activeAccounts->sum('remaining_reports');

        // Check and update any expired accounts
        $this->checkAndUpdateExpiredAccounts($companyId);
    }
    
    return view('livewire.credit-report.credit-report-search', [
        'reportCount' => $reportCount,
        'remainingReports' => $remainingReports,
        'activeAccounts' => $activeAccounts,
    ]);
}





public $currentPage = 1;
    public $perPage = 10;
    
    /**
     * Navigate to previous page
     */
    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }
    }
    
    /**
     * Navigate to next page
     */
    public function nextPage()
    {
        $totalPages = ceil(count($this->searchResults) / $this->perPage);
        if ($this->currentPage < $totalPages) {
            $this->currentPage++;
        }
    }
    
    /**
     * Go to specific page
     */
    public function goToPage($page)
    {
        $totalPages = ceil(count($this->searchResults) / $this->perPage);
        if ($page >= 1 && $page <= $totalPages) {
            $this->currentPage = $page;
        }
    }
    
    /**
     * Clear selection and go back to results
     */
    public function clearSelection()
    {
        $this->selectedId = null;
        $this->reportUrl = null;
        $this->reportData = null;
        $this->reportError = '';
    }
    
    /**
     * Reset pagination when perPage changes
     */
    public function updatedPerPage()
    {
        $this->currentPage = 1;
    }
    
    /**
     * Reset pagination and clear results when search parameters change
     */
    public function updatedFullName()
    {
        $this->resetSearch();
    }
    
    public function updatedIdNumber()
    {
        $this->resetSearch();
    }
    
    public function updatedPhoneNumber()
    {
        $this->resetSearch();
    }
    
    /**
     * Reset search state
     */
    private function resetSearch()
    {
        $this->currentPage = 1;
        $this->searchResults = [];
        $this->selectedId = null;
        $this->reportUrl = null;
        $this->reportData = null;
        $this->reportError = '';
        $this->errorMessage = '';
    }
    
    /**
     * Get total pages for pagination
     */
    public function getTotalPagesProperty()
    {
        return ceil(count($this->searchResults) / $this->perPage);
    }
    
    /**
     * Get paginated results
     */
    public function getPaginatedResultsProperty()
    {
        $offset = ($this->currentPage - 1) * $this->perPage;
        return array_slice($this->searchResults, $offset, $this->perPage);
    }
    
    /**
     * Enhanced validation rules with custom messages
     */
    protected $messages = [
        'fullName.required_without_all' => 'Please provide at least a full name, ID number, or phone number to search.',
    ];
    
    /**
     * Reset component state when mounted
     */
    public function mount()
    {
        $this->resetSearch();
    }
    
    /**
     * Handle real-time validation
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    /**
     * Get formatted search summary for display
     */
    public function getSearchSummaryProperty()
    {
        $criteria = [];
        
        if (!empty($this->fullName)) {
            $criteria[] = "Name: {$this->fullName}";
        }
        
        if (!empty($this->idNumber)) {
            $criteria[] = "{$this->idNumberType}: {$this->idNumber}";
        }
        
        if (!empty($this->phoneNumber)) {
            $criteria[] = "Phone: {$this->phoneNumber}";
        }
        
        return implode(', ', $criteria);
    }
    
    /**
     * Check if user has sufficient permissions/credits
     */
    private function checkUserPermissions()
    {
        if (!auth()->check()) {
            throw new \Exception('You must be logged in to perform this action.');
        }
        
        if (!auth()->user()->company_id) {
            throw new \Exception('No company associated with your account.');
        }
        
        // Check if company has active accounts with remaining reports
        $companyId = auth()->user()->company_id;
        $hasActiveAccount = Account::where('company_id', $companyId)
            ->where('status', 'active')
            ->where('remaining_reports', '>', 0)
            ->where('valid_until', '>', now())
            ->exists();
            
        if (!$hasActiveAccount) {
            throw new \Exception('No active account with remaining reports found. Please contact your administrator.');
        }
    }
    
    /**
     * Enhanced search with permission checking
     */
    public function search()
    {
        try {
            // Check permissions before searching
            $this->checkUserPermissions();
            
            // Validate input
            $this->validate();
            
            // Reset state
            $this->isSearching = true;
            $this->errorMessage = '';
            $this->searchResults = [];
            $this->selectedId = null;
            $this->reportData = null;
            $this->reportUrl = null;
            $this->currentPage = 1;
            
            // Perform search
            $results = $this->searchIndividual();
            $this->searchResults = $results;
            
            // Log search activity
            Log::info('Credit report search performed', [
                'user_id' => auth()->id(),
                'company_id' => auth()->user()->company_id,
                'search_criteria' => $this->getSearchSummaryProperty(),
                'results_count' => count($results),
            ]);

        } catch (\Exception $e) {
            Log::error('Search failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'search_criteria' => $this->getSearchSummaryProperty(),
            ]);
            $this->errorMessage = $e->getMessage();
        } finally {
            $this->isSearching = false;
        }
    }
    
  
    
    /**
     * Export search results to CSV
     */
    public function exportResults()
    {
        if (empty($this->searchResults)) {
            $this->addError('export', 'No search results to export.');
            return;
        }
        
        $filename = 'credit_search_results_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['Full Name', 'Date of Birth', 'National ID', 'Address', 'Creditinfo ID']);
            
            // Add data rows
            foreach ($this->searchResults as $result) {
                fputcsv($file, [
                    $result['FullName'] ?? 'N/A',
                    isset($result['DateOfBirth']) ? \Carbon\Carbon::parse($result['DateOfBirth'])->format('Y-m-d') : 'N/A',
                    $result['NationalID'] ?? 'N/A',
                    $result['Address'] ?? 'N/A',
                    $result['CreditinfoId'] ?? 'N/A',
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Get company statistics for dashboard
     */
    public function getCompanyStatsProperty()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return null;
        }
        
        $companyId = auth()->user()->company_id;
        
        return [
            'total_reports_generated' => ReportLog::whereHas('user', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->distinct('creditinfo_id')->count('creditinfo_id'),
            
            'reports_this_month' => ReportLog::whereHas('user', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->whereMonth('retrieved_at', now()->month)->count(),
            
            'active_accounts' => Account::where('company_id', $companyId)
                ->where('status', 'active')
                ->where('valid_until', '>', now())
                ->count(),
                
            'total_remaining_reports' => Account::where('company_id', $companyId)
                ->where('status', 'active')
                ->where('valid_until', '>', now())
                ->sum('remaining_reports'),
        ];
    }








}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'trading_name',
        'registration_number',
        'date_of_incorporation',
        'business_type',
        'industry',
        'primary_email',
        'phone_number',
        'website',
        'physical_address',
        'city',
        'region',
        'postal_address',
        'contact_name',
        'contact_position',
        'contact_email',
        'contact_phone',
        'verification_status',
        'terms_accepted',
    ];

    /**
     * Get the documents for the company.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Check if all required documents are uploaded.
     */
    public function allDocumentsUploaded()
    {
        $requiredDocumentTypes = [
            Document::TYPE_BUSINESS_LICENSE,
            Document::TYPE_BOT_LICENSE,
            Document::TYPE_BRELA_CERTIFICATE,
            Document::TYPE_MEMORANDUM,
            Document::TYPE_TIN,
            Document::TYPE_TAX_CLEARANCE,
        ];

        $uploadedDocuments = $this->documents()
            ->whereIn('document_type', $requiredDocumentTypes)
            ->where('status', '!=', Document::STATUS_NOT_UPLOADED)
            ->count();

        return $uploadedDocuments === count($requiredDocumentTypes);
    }

    /**
     * Get the count of completed documents.
     */
    public function getCompletedDocumentsCountAttribute()
    {
        return $this->documents()
            ->where('status', '!=', Document::STATUS_NOT_UPLOADED)
            ->count();
    }

    /**
     * Get the total required documents count.
     */
    public function getRequiredDocumentsCountAttribute()
    {
        return 6; // Number of required document types
    }


}
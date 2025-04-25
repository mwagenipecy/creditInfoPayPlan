<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'document_type',
        'file_path',
        'file_name',
        'file_size',
        'status',
        'admin_notes',
        'tin_number',
        'issue_date',
    ];

    // Document types
    const TYPE_BUSINESS_LICENSE = 'business_license';
    const TYPE_BOT_LICENSE = 'bot_license';
    const TYPE_BRELA_CERTIFICATE = 'brela_certificate';
    const TYPE_MEMORANDUM = 'memorandum';
    const TYPE_TIN = 'tin';
    const TYPE_TAX_CLEARANCE = 'tax_clearance';
    
    // Document statuses
    const STATUS_NOT_UPLOADED = 'not_uploaded';
    const STATUS_UPLOADED = 'uploaded';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CHANGES_REQUESTED = 'changes_requested';

    /**
     * Get the company that owns the document.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get document type label.
     */
    public function getDocumentTypeLabelAttribute()
    {
        return [
            self::TYPE_BUSINESS_LICENSE => 'Business License',
            self::TYPE_BOT_LICENSE => 'BOT License',
            self::TYPE_BRELA_CERTIFICATE => 'BRELA Certificate',
            self::TYPE_MEMORANDUM => 'Memorandum of Association',
            self::TYPE_TIN => 'TIN Number',
            self::TYPE_TAX_CLEARANCE => 'Tax Clearance',
        ][$this->document_type] ?? $this->document_type;
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute()
    {
        return [
            self::STATUS_NOT_UPLOADED => 'Not Uploaded',
            self::STATUS_UPLOADED => 'Uploaded',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_CHANGES_REQUESTED => 'Changes Requested',
        ][$this->status] ?? $this->status;
    }

    /**
     * Get status color class.
     */
    public function getStatusColorAttribute()
    {
        return [
            self::STATUS_NOT_UPLOADED => 'bg-gray-100 text-gray-600',
            self::STATUS_UPLOADED => 'bg-blue-100 text-blue-600',
            self::STATUS_APPROVED => 'bg-green-100 text-green-700',
            self::STATUS_REJECTED => 'bg-red-100 text-red-700',
            self::STATUS_CHANGES_REQUESTED => 'bg-yellow-100 text-yellow-700',
        ][$this->status] ?? 'bg-gray-100 text-gray-600';
    }

    /**
     * Get document icon.
     */
    public function getIconAttribute()
    {
        return [
            self::TYPE_BUSINESS_LICENSE => 'fas fa-building',
            self::TYPE_BOT_LICENSE => 'fas fa-certificate',
            self::TYPE_BRELA_CERTIFICATE => 'fas fa-file-contract',
            self::TYPE_MEMORANDUM => 'fas fa-file-signature',
            self::TYPE_TIN => 'fas fa-id-card',
            self::TYPE_TAX_CLEARANCE => 'fas fa-receipt',
        ][$this->document_type] ?? 'fas fa-file';
    }
}
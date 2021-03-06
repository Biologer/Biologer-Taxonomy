<?php

namespace App\Importing;

class ImportStatus extends \MyCLabs\Enum\Enum
{
    public const PROCESSING_QUEUED = 'processing_queued';
    public const PARSING = 'parsing';
    public const PARSED = 'parsed';
    public const VALIDATING = 'validating';
    public const VALIDATION_FAILED = 'validation_failed';
    public const VALIDATION_PASSED = 'validation_passed';
    public const SAVING = 'saving';
    public const SAVING_FAILED = 'saving_failed';
    public const SAVED = 'saved';
    public const CANCELLED = 'cancelled';

    /**
     * Check if import status is "parsed".
     *
     * @return bool
     */
    public function parsed()
    {
        return $this->getValue() === self::PARSED;
    }

    /**
     * Check if import status is "validation_failed".
     *
     * @return bool
     */
    public function validationFailed()
    {
        return $this->getValue() === self::VALIDATION_FAILED;
    }

    /**
     * Check if import status is "validation_passed".
     *
     * @return bool
     */
    public function validationPassed()
    {
        return $this->getValue() === self::VALIDATION_PASSED;
    }

    /**
     * Check if import status is "stored".
     *
     * @return bool
     */
    public function saved()
    {
        return $this->getValue() === self::SAVED;
    }

    /**
     * Check if import is "cancelled".
     *
     * @return bool
     */
    public function cancelled()
    {
        return $this->getValue() === self::CANCELLED;
    }

    /**
     * Statuses that mark import as done with processing:
     * "validation_failed" & "stored".
     *
     * @return array
     */
    public static function doneStatuses()
    {
        return [
            self::VALIDATION_FAILED,
            self::SAVING_FAILED,
            self::SAVED,
            self::CANCELLED,
        ];
    }

    /**
     * Statuses at which import can be cancelled.
     *
     * @return array
     */
    public static function cancellableStatuses()
    {
        return [
            self::PROCESSING_QUEUED,
            self::PARSING,
            self::PARSED,
            self::VALIDATING,
            self::VALIDATION_PASSED,
        ];
    }
}

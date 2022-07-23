<?php

namespace App\Rules;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ReaderInterface;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ImportFile implements Rule
{
    /**
     * Does the import file contain header row?
     *
     * @var bool
     */
    private $hasHeading;

    public function __construct($hasHeading)
    {
        $this->hasHeading = $hasHeading;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $reader = $this->makeReader($value);

        $hasOneRow = $this->checkForOneRow($reader);

        $reader->close();

        return $hasOneRow;
    }

    /**
     * Make file reader.
     *
     * @param mixed $value
     * @return ReaderInterface
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException|\Box\Spout\Common\Exception\IOException
     */
    private function makeReader($value)
    {
        // for CSV and XLSX files
        Str::lower(pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION)) == 'xlsx' ?
            $reader = ReaderEntityFactory::createXLSXReader() :
            $reader = ReaderEntityFactory::createCSVReader();

        $reader->open($value->getPathname());

        return $reader;
    }

    /**
     * Check if there is at least one row with data, excluding header row if expected.
     *
     * @param  ReaderInterface  $reader
     * @return bool
     */
    private function checkForOneRow($reader)
    {
        $hasOneRow = false;

        // Check that we have at least one row and that it is not the header
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                if (! $this->hasHeading || ($this->hasHeading && $hasOneRow)) {
                    return true;
                }
                $hasOneRow = true;
            }

            break;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validate.csv_row_count');
    }
}

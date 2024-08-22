<?php

namespace common\helper;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SpreadsheetHelper
{
    private static ?SpreadsheetHelper $instance = null;

    public static function getInstance(): SpreadsheetHelper{
        if (self::$instance === null) {
            self::$instance = new SpreadsheetHelper();
        }
        return self::$instance;
    }

    public function getReader($inputFileName, $sheetName){
        $filterSubset = new ReadFilter();

        $inputFileType = IOFactory::identify($inputFileName);
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true); //THIS WILL IGNORE FORMATTING
        $reader->setLoadSheetsOnly($sheetName);
        $reader->setReadFilter($filterSubset);

        return $reader;
    }

    public function getHelper(): Sample
    {
        return new Sample();
    }

    public function getSheetName(): String {
        return 'Participant';
    }

    public function getIdentify($inputFileName): string
    {
        return IOFactory::identify($inputFileName);
    }
}
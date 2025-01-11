<?php

namespace common\helper;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\IReader;

class SpreadsheetHelper extends Sample
{
    private static ?SpreadsheetHelper $instance = null;

    public static function getInstance(): SpreadsheetHelper
    {
        if (self::$instance === null) {
            self::$instance = new SpreadsheetHelper();
        }
        return self::$instance;
    }

    /**
     * @throws Exception
     */
    public function getReader($inputFileName, $sheetName = 'Participant'): IReader
    {
        $inputFileType = IOFactory::identify($inputFileName);
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load($inputFileName);
        $sheetNames = $spreadsheet->getSheetNames();

        if (!in_array($sheetName, $sheetNames)) {
            $sheetName = in_array('Sheet1', $sheetNames) ? 'Sheet1' : $sheetNames[0];
        }

        $reader->setLoadSheetsOnly($sheetName);

        return $reader;
    }

    public function getHelper(): Sample
    {
        return new Sample();
    }

    public function getIdentify($inputFileName): string
    {
        return IOFactory::identify($inputFileName);
    }

    public function getDataList($data): array
    {
        $dataList = [];

        foreach ($data->getRowIterator(1) as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowList = [];
            foreach ($cellIterator as $i => $cell) {
                if ($i != 'A' && $cell->getValue() !== null) {
                    $rowList[] = $cell->getFormattedValue();
                }
            }

            if (!empty($rowList)) {
                $dataList[] = $rowList;
            }
        }

        return $dataList;
    }
}
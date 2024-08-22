<?php

namespace common\helper;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class ReadFilter implements IReadFilter
{

    public function readCell ($columnAddress, $row, $worksheetName = ''): bool
    {
        // Read rows 2 to 50 and columns A to E only
        if ($row >= 2 && $row <= 50) {
            if (in_array($columnAddress, range('A', 'D'))) {
                return true;
            }
        }

        return false;
    }
}
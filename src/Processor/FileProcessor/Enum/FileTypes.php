<?php

namespace App\Processor\FileProcessor\Enum;

enum FileTypes: string
{
    case JSON_ROW = 'json_row';
    case CSV = 'csv';
}

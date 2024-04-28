<?php

namespace App\Exceptions;

use Exception;

class ImportException extends Exception
{
    public function __construct($indexJp, $rowNum, $columns)
    {
        $this->message = $indexJp . 'が不正です。';
        $this->message .= $rowNum . '行目';
        $this->message .= ':';

        for($i=0; $i<35; $i++) {
            $this->message .= $columns[$i] . ',';
        }

//        parent::__construct();
    }

}
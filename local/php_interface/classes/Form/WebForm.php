<?php

namespace Form;

use CFormResult;
use CModule;

class WebForm
{
    /* @var int */
    private int $webFormId;


    public function __construct(int $webFormId)
    {
        CModule::IncludeModule('form');
        $this->webFormId = $webFormId;
    }


    /**
     * @param array $data - ассоциативный массив, где:
     * ключ — id поля для веб-формы, значение — input value
     * @return bool - возвращает true, если добавление результата в веб-форму прошло успешно, иначе false
     */
    public function saveResult(array $data): bool
    {
        $result = CFormResult::Add($this->webFormId, $data, 'N');
        if ($result) {
            return true;
        }
        return false;
    }
}
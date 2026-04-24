<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class ImgSizeValidator extends AbstractValidator
{
    protected string $message = 'Файл :field слишком большой (макс 2МБ)';

    public function rule(): bool
    {
        if (empty($_FILES[$this->field]['name'])) {
            return true;
        }
        return $_FILES[$this->field]['size'] <= 2 * 1024 * 1024;
    }
}
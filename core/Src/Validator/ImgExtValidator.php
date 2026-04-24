<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class ImgExtValidator extends AbstractValidator
{
    protected string $message = 'Для поля :field разрешены только форматы jpg, png';

    public function rule(): bool
    {
        if (empty($_FILES[$this->field]['name'])) {
            return true;
        }
        
        $file = $_FILES[$this->field]['name'];
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        
        return in_array($extension, ['jpg', 'jpeg', 'png']);
    }
}
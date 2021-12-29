<?php

namespace App\Supports\Services;

use Illuminate\Support\Str;
use Collective\Html\FormFacade as FormBuilder;

class FormService
{
    public $fields;

    public function __construct(array $fields)
    {
        $this->fields = collect($fields);
    }

    public function render()
    {
        $html = FormBuilder::open([
            'method' => 'POST',
            //'url' => ''
        ]);
        $html .= '<div class="form-row">';
        foreach ($this->fields as $field) {
            $html .= '<div class="form-group ' . $this->convertWithToColumn($field['width']) . '">';
            $nameField = $this->sanitizeNameToNameField($field['name']);
            $classMaskToPhone = $this->isPhone($nameField) ? 'phone' : '';

            switch ($field['type']) {
                case 'textarea':
                    $html .= FormBuilder::label($nameField, $field['name']);
                    $html .= FormBuilder::textarea($nameField, null, ['rows' => 10, 'class' => 'form-control border ' . $classMaskToPhone]);
                    break;

                case 'select':
                    $html .= FormBuilder::label($nameField, $field['name']);
                    $html .= FormBuilder::select($nameField, ['' => 'Selecione'] + $field['options'], null, ['class' => 'form-control border ' . $classMaskToPhone]);
                    break;

                case 'email':
                    $html .= FormBuilder::label($nameField, $field['name']);
                    $html .= FormBuilder::email($nameField, null, ['class' => 'form-control border ' . $classMaskToPhone]);
                    break;

                default:
                    $html .= FormBuilder::label($nameField, $field['name']);
                    $html .= FormBuilder::text($nameField, null, ['class' => 'form-control border ' . $classMaskToPhone]);
                    break;
            }
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '<button type=""submit" class="btn btn-dark btn-lg px-7 rounded-pill">Enviar</button>';
        $html .= FormBuilder::close();

        return $html;
    }

    public function rules()
    {
        $rules = [];
        foreach ($this->fields as $field) {            
            $rules[$this->sanitizeNameToNameField($field['name'])] = 'required' . $this->rulesAppend($field);
        }
        return $rules;
    }

    public function rulesAppend($field)
    {
        $rulesAppend = null;
        if ($field['type'] == 'email') {
            $rulesAppend .= '|email';
        } 

        if ($this->isPhone($field['name'])) {
            $rulesAppend .= '|regex:/^\(?\d{2}\)?[\s-]?[\s9]?\d{4}-?\d{4}$/|max:15|min:12';
        }

        return $rulesAppend;
    }

    public function getNameFields()
    {
        return $this->fields->pluck('name')->map(function ($item) {
            return $this->sanitizeNameToNameField($item);
        })->toArray();
    }

    public function isPhone($name)
    {
        return Str::contains($this->sanitizeNameToNameField($name), ['telefone', 'fone', 'phone']);
    }
    public function sanitizeNameToNameField($name)
    {
        $name = Str::slug($name);
        $name = preg_replace('/-/', '', $name);
        return $name;
    }

    private function convertWithToColumn(int $width)
    {
        switch ($width) {
            case '100':
                return 'col-12';
                break;

            case '75':
                return 'col-12 col-md-8';
                break;

            case '50':
                return 'col-12 col-md-6';
                break;

            case '25':
                return 'col-12 col-md-3';
                break;

            default:
                return 'col-12';
                break;
        }
    }
}

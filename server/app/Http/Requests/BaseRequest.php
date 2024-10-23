<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Service\Function\ServiceFunction\ConvertData;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    protected $ConvertData;
    protected $defaultMessages = [];

    public function __construct(ConvertData $ConvertData)
    {
        parent::__construct();
        $this->ConvertData = $ConvertData;
        $this->initializeMessages();
    }

    protected function returnFailedValidation($errorMessage)
    {
        $response = response()->json([
            'status' => 'error',
            'message' =>trans('message.errorMessage'),
            'errors' => $errorMessage,
        ], 422);
        throw new ValidationException($this->validator, $response);
    }

    protected function failedValidation(Validator $validator)
    {
        $this->returnFailedValidation($validator->errors()->toArray());
    }

    protected function checkFilterTime($start, $end, $type)
    {
        $messages = [];
        if ($start === null || $end === null || $type === null) {
            $messages[] = trans('message.filter_time_required');
        } else {
            if (strtotime($start) > strtotime($end)) {
                $messages[] = trans('message.end_greater_than_start');
            }
        }
        return $messages;
    }
    public function prepareForValidation()
    {
        $data = [];

        if ($this->start) {
            $data['start'] = $this->ConvertData->convertToDate($this->start);
        }

        if ($this->end) {
            $data['end'] = $this->ConvertData->convertToDate($this->end);
        }

        if (!empty($data)) {
            $this->merge($data);
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $messages = [];

            if ($this->has('start') && !$this->start) {
                $messages[] = trans('message.start_date_format');
            }

            if ($this->has('end') && !$this->end) {
                $messages[] = trans('message.end_date_format');
            }

            $messages = array_merge($messages, $this->checkFilterTime($this->start, $this->end, $this->typeTime));

            if (!empty($messages)) {
                foreach ($messages as $message) {
                    $validator->errors()->add('filter_error', $message);
                }
            }
        });
    }

    protected function getMethodDelete($table)
    {
        return ['id' => "required|integer|exists:$table,id"];
    }

    protected function getMethodGet()
    {
        return [
            'page' => 'nullable|integer|min:1',
            'limit' => 'nullable|integer|min:1',
            'search' => 'nullable|string|min:1|max:255',
            'start' => 'nullable',
            'end' => 'nullable',
            'typeTime' => 'nullable|in:created_at,updated_at',
            'filtersBase64' => "nullable|string"
        ];
    }
    public function attributesBase()
    {
        return [
            'page' => trans('message.page') ,
            'limit' => trans('message.limit') ,
            'typeTime' => trans('message.typeTime') ,
            'start' => trans('message.start') ,
            'end' => trans('message.end') ,
            'search' => trans('message.search') ,
        ];
    }
    protected function initializeMessages()
    {
        $this->defaultMessages = [
            'required' => trans('message.required'),
            'email' => trans('message.email'),
            'max' => trans('message.max'),
            'min' => trans('message.min'),
            'integer' =>trans('message.integer'),
            'string' => trans('message.string'),
            'date' => trans('message.date'),
            'in' => trans('message.in'),
        ];
    }

    public function generateMessages(array $rules)
    {
        $messages = [];
        $attributes = $this->attributes(); 
    
        foreach ($rules as $field => $fieldRules) {
            $fieldRulesArray = explode('|', $fieldRules);
            foreach ($fieldRulesArray as $rule) {
                if (strpos($rule, ':') !== false) {
                    [$ruleName, $ruleValue] = explode(':', $rule);
                    $messages["{$field}.{$ruleName}"] = str_replace(
                        [':attribute', ":{$ruleName}"],
                        [$attributes[$field] ?? $field, $ruleValue], 
                        $this->defaultMessages[$ruleName] ?? "{$field}.{$ruleName} không hợp lệ."
                    );
                } else {
                    $messages["{$field}.{$rule}"] = str_replace(
                        ':attribute',
                        $attributes[$field] ?? $field,
                        $this->defaultMessages[$rule] ?? "{$field}.{$rule} không hợp lệ."
                    );
                }
            }
        }
    
        return $messages;
    }
    
    
}
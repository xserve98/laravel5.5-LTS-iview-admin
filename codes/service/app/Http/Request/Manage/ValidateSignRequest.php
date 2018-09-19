<?php
/**
 *
 * User: fengyan
 * Date: 18-9-13
 * Time: 下午4:33
 */

namespace App\Http\Request\Manage;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ValidateSignRequest extends FormRequest
{
    public $rules = [
        'version' => 'required',
        'nonce' => 'required',
        'timestamp' => 'required'
    ];
}
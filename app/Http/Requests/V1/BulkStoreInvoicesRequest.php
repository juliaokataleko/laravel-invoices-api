<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoicesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return !is_null($user) AND $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "*.customerId" => "required",
            "*.amount" => ['required', "numeric"],
            "*.status" => ["required", Rule::in(["B", "P", "V", "b", "p", "v"])],
            "*.billedDate" => ["required", "date_format:Y-m-d H:i:s"],
            "*.paidDate" => ["date_format:Y-m-d H:i:s", "nullable"],
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];
        foreach ($this->toArray() as $key => $obj) {
            $obj["customer_id"] = $obj["customerId"] ?? null;
            $obj["billed_date"] = $obj["billedDate"] ?? null;
            $obj["paid_date"] = $obj["paidDate"] ?? null;

            $data[] = $obj;
        }

        $this->merge($data);
    }
}

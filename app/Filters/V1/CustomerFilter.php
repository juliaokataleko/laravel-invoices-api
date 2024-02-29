<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class CustomerFilter extends ApiFilter {
    protected $safeParms = [
        "postalCode" => ["eq", "gt", "lt"],
        "name" => ["eq"],
        "type" => ["eq"],
        "email" => ["eq"],
        "address" => ["eq"],
        "state" => ["eq"],
        "city" => ["eq"],
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];

}

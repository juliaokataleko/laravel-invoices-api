<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Requests\V1\BulkStoreInvoicesRequest;
use App\Http\Requests\V1\StoreInvoiceRequest as V1StoreInvoiceRequest;
use App\Http\Requests\V1\UpdateInvoiceRequest as V1UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoiceFilter;
        $queryItems = $filter->transform($request);

        if (count($queryItems) == 0) return new InvoiceCollection(Invoice::paginate()->appends($request->query()));

        return new InvoiceCollection(Invoice::where($queryItems)->paginate()->appends($request->query()));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(V1StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    public function bulkStore(BulkStoreInvoicesRequest $request) {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ["customerId", "billedDate", "paidDate"]);
        });

        Invoice::insert($bulk->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(V1UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}

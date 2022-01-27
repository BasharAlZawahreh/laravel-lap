<?php

namespace App\Http\Controllers\Aramex;

use App\Http\Controllers\Controller;
use App\Http\Requests\Aramex\CreateOrderRequest;
use App\Jobs\SendLabelJob;
use App\Models\User;
use Attribute;
use Carbon\Carbon;
use DateTimeInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class CreateOrder extends Controller
{
    public function create(CreateOrderRequest $request)
    {
        try {
            $attributes = $request->validated();


            SendLabelJob::dispatch($attributes);

            return response('Message: your order is being processed , you’ll receive an email with the results.', 200);
        } catch (Exception $e) {
            response('Something went wrong please try again later!', 500);
        }
    }
}

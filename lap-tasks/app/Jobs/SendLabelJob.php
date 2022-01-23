<?php

namespace App\Jobs;

use App\Mail\SendLabel;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SendLabelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $shipmentNumber;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shipmentNumber,User $user)
    {
        $this->shipmentNumber = $shipmentNumber;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $response = Http::post('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/PrintLabel', [
                [
                    "ClientInfo"=> [
                        "UserName" => $this->user->email,
                        "Password" => $this->user->password,
                        "Version" => $this->user->version,
                        "AccountNumber" => $this->user->accountNumber,
                        "AccountPin" => $this->user->accountPin,
                        "AccountEntity" => $this->user->accountEntity,
                        "AccountCountryCode" => $this->user->accountCountryCode,
                        "Source" => $this->user->source
                    ],
                    "LabelInfo"=> [
                        "ReportID"=> 9201,
                        "ReportType"=> "URL"
                    ],
                    "OriginEntity"=> "AMM",
                    "ProductGroup"=> "EXP",
                    "ShipmentNumber"=> $this->shipmentNumber,
                    "Transaction"=> [
                        "Reference1"=> "",
                        "Reference2"=> "",
                        "Reference3"=> "",
                        "Reference4"=> "",
                        "Reference5"=> ""
                    ]
                ]
            ]);

            Mail::to($this->user->email)->send(new SendLabel($this->shipmentId));

        } catch (Exception $e) {
            throw new Exception('Not passed');
        }
    }


}

<?php

namespace Tests\Endpoints;

use Lexoffice\Api\Endpoints\PaymentsEndpoint;
use Lexoffice\Contracts\Interfaces\API\BaseEndpointInterface;
use Lexoffice\Entities\Payments\Payment;
use Tests\Contracts\EndpointTest;

class PaymentsEndpointTest extends EndpointTest {
    private ?BaseEndpointInterface $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new PaymentsEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testJsonSerialize() {
        $data1 = [
            "openAmount" => 200.00,
            "currency" => "EUR",
            "paymentStatus" => "openRevenue",
            "voucherType" => "invoice",
            "voucherStatus" => "open",
            "paymentItems" => []
        ];

        $data2 = [
            "openAmount" => 39.90,
            "currency" => "EUR",
            "paymentStatus" => "openExpense",
            "voucherType" => "purchaseinvoice",
            "voucherStatus" => "open",
            "paymentItems" => [
                [
                    "paymentItemType" => "manualPayment",
                    "postingDate" => "2023-11-07T00:00:00.000+01:00",
                    "amount" => 10.50,
                    "currency" => "EUR"
                ],
                [
                    "paymentItemType" => "manualPayment",
                    "postingDate" => "2023-11-13T00:00:00.000+01:00",
                    "amount" => 20.0,
                    "currency" => "EUR"
                ]
            ]
        ];

        $data3 = [
            "openAmount" => 0.0,
            "currency" => "EUR",
            "paymentStatus" => "balanced",
            "voucherType" => "purchasecreditnote",
            "voucherStatus" => "paidoff",
            "paidDate" => "2023-07-14T13:42:02.123+02:00",
            "paymentItems" => [
                [
                    "paymentItemType" => "manualPayment",
                    "postingDate" => "2023-07-14T00:00:00.000+01:00",
                    "amount" => 119.0,
                    "currency" => "EUR"
                ]
            ]
        ];

        $data4 = [
            "openAmount" => 0.0,
            "currency" => "EUR",
            "paymentStatus" => "balanced",
            "voucherType" => "invoice",
            "voucherStatus" => "paid",
            "paidDate" => "2023-07-14T13:42:02.123+02:00",
            "paymentItems" => [
                [
                    "paymentItemType" => "manualPayment",
                    "postingDate" => "2023-07-14T00:00:00.000+01:00",
                    "amount" => 72.0,
                    "currency" => "EUR"
                ],
                [
                    "paymentItemType" => "cashDiscount",
                    "postingDate" => "2023-07-14T00:00:00.000+01:00",
                    "amount" => 7.85,
                    "currency" => "EUR"
                ]
            ]
        ];

        $payment1 = new Payment($data1);
        $payment2 = new Payment($data2);
        $payment3 = new Payment($data3);
        $payment4 = new Payment($data4);

        $this->assertEquals(json_encode($data1), $payment1->toJson());
        $this->assertEquals(json_encode($data2), $payment2->toJson());
        $this->assertEquals(json_encode($data3), $payment3->toJson());
        $this->assertEquals(json_encode($data4), $payment4->toJson());
    }
}

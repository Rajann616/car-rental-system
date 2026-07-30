<?php

namespace Tests\Unit;

use App\Services\RazorpayService;
use Tests\TestCase;

class RazorpayServiceTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function service_instantiates_properly()
    {
        $service = new RazorpayService();
        $this->assertInstanceOf(RazorpayService::class, $service);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function signature_verification_returns_boolean()
    {
        $service = new RazorpayService();
        $isVerified = $service->verifySignature('order_test123', 'pay_test123', 'invalid_signature');
        $this->assertIsBool($isVerified);
        $this->assertFalse($isVerified);
    }
}

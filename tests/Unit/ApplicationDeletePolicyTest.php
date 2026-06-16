<?php

namespace Tests\Unit;

use App\Models\Application;
use PHPUnit\Framework\TestCase;

class ApplicationDeletePolicyTest extends TestCase
{
    public function test_pending_application_can_be_deleted(): void
    {
        $application = new Application();
        $application->status = Application::STATUS_PENDING;

        $this->assertTrue($application->isDeletable());
    }

    public function test_non_pending_application_cannot_be_deleted(): void
    {
        $application = new Application();
        $application->status = Application::STATUS_VERIFYING;

        $this->assertFalse($application->isDeletable());
    }
}

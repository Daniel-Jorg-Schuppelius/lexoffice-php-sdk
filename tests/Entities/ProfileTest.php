<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ProfileTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Entities;

use Lexoffice\Entities\Profile\Profile;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase {
    public function testCreateProfile() {
        $data = [
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "companyName" => "Testfirma GmbH",
            "created" => [
                "userId" => "1aea5501-3f3e-403d-8492-2dad03016289",
                "userName" => "Frau Erika Musterfrau",
                "userEmail" => "erika.musterfrau@testfirma.de",
                "date" => "2017-01-03T13:15:45.000+01:00"
            ],
            "connectionId" => "3dea098a-fae5-4458-a85c-f97965966c25",
            "features" => [
                "cashbox"
            ],
            "businessFeatures" => [
                "INVOICING",
                "INVOICING_PRO",
                "BOOKKEEPING"
            ],
            "subscriptionStatus" => "active",
            "taxType" => "net",
            "smallBusiness" => false
        ];

        $profile = new Profile($data);
        $this->assertInstanceOf(Profile::class, $profile);
    }
}

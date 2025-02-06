<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraServiceProvider;

use NetworkRailBusinessSystems\Entra\EntraServiceProvider;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class RegisterTest extends TestCase
{
    protected EntraServiceProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new EntraServiceProvider(app());
        $this->provider->register();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'businessPhones' => 'business_phone',
                'displayName' => 'name',
                'givenName' => 'first_name',
                'id' => 'azure_id',
                'jobTitle' => 'title',
                'mail' => 'email',
                'mobilePhone' => 'mobile_phone',
                'officeLocation' => 'office',
                'surname' => 'last_name',
                'userPrincipalName' => 'username',
            ],
            config('entra.sync_attributes'),
        );
    }
}

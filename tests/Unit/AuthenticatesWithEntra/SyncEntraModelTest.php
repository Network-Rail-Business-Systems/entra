<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\AuthenticatesWithEntra;

use NetworkRailBusinessSystems\Entra\Tests\Data\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class SyncEntraModelTest extends TestCase
{
    protected array $details = [
        'businessPhones' => '01234567890',
        'displayName' => 'Joe Bloggs',
        'givenName' => 'Joe',
        'id' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
        'jobTitle' => 'Business Systems Developer',
        'mail' => 'Joe.Bloggs@networkrail.co.uk',
        'mobilePhone' => '01234567890',
        'officeLocation' => 'Some Office',
        'surname' => 'Bloggs',
        'userPrincipalName' => 'JBloggs2',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $user = new User();
        $user->syncEntraDetails($this->details);
    }

    public function testLoadsExisting(): void
    {
        $this->assertDatabaseHas('users', [
            'azure_id' => $this->details['id'],
            'business_phone' => $this->details['businessPhones'],
            'email' => $this->details['mail'],
            'first_name' => $this->details['givenName'],
            'last_name' => $this->details['surname'],
            'name' => $this->details['displayName'],
            'office' => $this->details['officeLocation'],
            'mobile_phone' => $this->details['mobilePhone'],
            'title' => $this->details['jobTitle'],
            'username' => $this->details['userPrincipalName'],
        ]);
    }
}

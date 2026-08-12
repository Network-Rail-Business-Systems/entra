<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ToArrayTest extends TestCase
{
    public function test(): void
    {
        $user = $this->entraFakeUser();

        $this->assertEquals(
            [
                'department' => $user->department,
                'displayName' => $user->displayName,
                'employeeId' => $user->employeeId,
                'givenName' => $user->givenName,
                'id' => $user->id,
                'jobTitle' => $user->jobTitle,
                'mail' => $user->mail,
                'officeLocation' => $user->officeLocation,
                'phone' => $user->phone,
                'surname' => $user->surname,
                'userPrincipalName' => $user->userPrincipalName,
            ],
            $user->toArray(),
        );
    }
}

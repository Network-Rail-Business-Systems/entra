<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Rules;

use NetworkRailBusinessSystems\Entra\Rules\UserExistsInEntra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class UserExistsInEntraTest extends TestCase
{
    protected UserExistsInEntra $rule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useEntraEmulator();
    }

    #[DataProvider('expectations')]
    public function testPasses(
        string $field,
        string $value,
    ): void {
        $this->rule = new UserExistsInEntra($field);

        $this->assertRulePasses(
            $this->rule,
            $field,
            $value,
        );
    }

    public function testFails(): void
    {
        $this->rule = new UserExistsInEntra('banana');

        $this->assertRuleFails(
            $this->rule,
            'mail',
            'goose@honk.com',
        );
    }

    public static function expectations(): array
    {
        return [
            [
                'field' => 'businessPhones',
                'value' => '01234567890',
            ],
            [
                'field' => 'displayName',
                'value' => 'Gandalf Stormcrow',
            ],
            [
                'field' => 'givenName',
                'value' => 'Gandalf',
            ],
            [
                'field' => 'id',
                'value' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
            ],
            [
                'field' => 'jobTitle',
                'value' => 'Wizard',
            ],
            [
                'field' => 'mail',
                'value' => 'gandalf.stormcrow@networkrail.co.uk',
            ],
            [
                'field' => 'mobilePhone',
                'value' => '01234567890',
            ],
            [
                'field' => 'officeLocation',
                'value' => 'Minas Tirith',
            ],
            [
                'field' => 'surname',
                'value' => 'Stormcrow',
            ],
            [
                'field' => 'userPrincipalName',
                'value' => 'gandalf@networkrail.co.uk',
            ],
        ];
    }
}

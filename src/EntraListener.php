<?php

namespace App\Listeners;

use Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent;
use Dcblogdev\MsGraph\MsGraph;
use EntraAuthenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent {
 *     +token: [
 *         "info" => [
 *             "@odata.context" => "https://graph.microsoft.com/v1.0/$metadata#users/$entity",
 *             "businessPhones" => [
 *                 "01234567890",
 *             ],
 *             "displayName" => "Joe Bloggs",
 *             "givenName" => "Joe",
 *             "jobTitle" => "Business Systems Developer",
 *             "mail" => "Joe.Bloggs@networkrail.co.uk",
 *             "mobilePhone" => "01234567890",
 *             "officeLocation" => "Some Office",
 *             "preferredLanguage" => null,
 *             "surname" => "Bloggs",
 *             "userPrincipalName" => "JBloggs2@networkrail.co.uk",
 *             "id" => "123ab4c5-6789-01de-f2g3-45678hijk9lm",
 *         ],
 *         "accessToken" => "... A string which is ~2400 characters long ...",
 *         "refreshToken" => null,
 *         "expires" => 1234567890,
 *     ],
 *     +socket: null,
 * }
 */
class EntraListener
{
    public function handle(NewMicrosoft365SignInEvent $event): void
    {
        $details = $this->formatDetails($event->token['info']);
        $user = $this->syncUser($details);

        $token = new MsGraph();
        $token->storeToken(
            $event->token['accessToken'],
            $event->token['refreshToken'],
            $event->token['expires'],
            (string) $user->id,
            $user->email,
        );

        Auth::login($user);
    }

    protected function formatDetails(array $details): array
    {
        $details['businessPhones'] = $details['businessPhones'][0] ?? null;

        $index = strpos($details['userPrincipalName'], '@');
        $details['userPrincipalName'] = substr($details['userPrincipalName'], 0, $index);

        return $details;
    }

    protected function syncUser(array $details): EntraAuthenticatable
    {
        /** @var class-string<EntraAuthenticatable> $modelClass */
        $modelClass = config('entra.user_model');
        $attributes = config('entra.sync_attributes');

        $user = $modelClass::query()
            ->where('azure_id', '=', $details['id'])
            ->orWhere('email', '=', $details['mail'])
            ->firstOrNew();

        foreach ($attributes as $azureKey => $laravelKey) {
            $user->$laravelKey = $details[$azureKey];
        }

        $user->save();

        return $user;
    }
}

<?php

namespace NetworkRailBusinessSystems\Entra;

use Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent;
use Dcblogdev\MsGraph\MsGraph;
use Illuminate\Support\Facades\Auth;

class EntraListener
{
    public function handle(NewMicrosoft365SignInEvent $event): void
    {
        $details = $this->formatDetails($event->token['info']);
        $model = $this->syncModel($details);

        $token = new MsGraph();
        $token->storeToken(
            $event->token['accessToken'],
            $event->token['refreshToken'],
            $event->token['expires'],
            $model->entraId(),
            $model->entraEmail(),
        );

        Auth::login($model);
    }

    protected function formatDetails(array $details): array
    {
        $details['businessPhones'] = $details['businessPhones'][0] ?? null;

        $index = strpos($details['userPrincipalName'], '@');
        $details['userPrincipalName'] = substr($details['userPrincipalName'], 0, $index);

        return $details;
    }

    protected function syncModel(array $details): EntraAuthenticatable
    {
        /** @var class-string<EntraAuthenticatable> $modelClass */
        $modelClass = config('entra.user_model');

        $model = $modelClass::getEntraModel($details);
        return $model->syncEntraDetails($details);
    }
}

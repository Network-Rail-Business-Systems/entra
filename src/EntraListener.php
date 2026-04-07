<?php

namespace NetworkRailBusinessSystems\Entra;

use Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent;
use Dcblogdev\MsGraph\MsGraph;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\Exceptions\OnlyExistingUsersException;

class EntraListener
{
    public function handle(NewMicrosoft365SignInEvent $event): void
    {
        $details = $event->token['info'];
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

    protected function syncModel(array $details): EntraAuthenticatable
    {
        /** @var class-string<EntraAuthenticatable> $modelClass */
        $modelClass = config('entra.user_model');
        $details = $modelClass::formatEntraDetails($details);

        /** @var EntraAuthenticatable|Model $model */
        $model = $modelClass::getEntraModel($details);

        if (
            config('entra.create_users') === false
            && $model->exists === false
        ) {
            throw new OnlyExistingUsersException();
        }

        return $model->syncEntraDetails($details);
    }
}

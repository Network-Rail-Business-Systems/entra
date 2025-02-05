<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $email
 * @property int $id
 *
 * @mixin Model
 */
trait AuthenticatesWithEntra
{
    public static function getEntraModel(array $details): self
    {
        return self::query()
            ->where('azure_id', '=', $details['id'])
            ->orWhere('email', '=', $details['mail'])
            ->firstOrNew();
    }

    public function syncEntraDetails(array $details): self
    {
        $attributes = config('entra.sync_attributes');

        foreach ($attributes as $azureKey => $laravelKey) {
            $this->$laravelKey = $details[$azureKey];
        }

        $this->save();

        return $this;
    }

    public function entraId(): string
    {
        return (string) $this->id;
    }

    public function entraEmail(): string
    {
        return $this->email;
    }
}

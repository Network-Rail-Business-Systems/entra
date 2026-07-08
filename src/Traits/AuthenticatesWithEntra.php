<?php

namespace NetworkRailBusinessSystems\Entra\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use NetworkRailBusinessSystems\Entra\EntraAuthenticatable;
use NetworkRailBusinessSystems\Entra\Models\EntraToken;

/**
 * @property string $email
 * @property ?EntraToken $entraToken
 * @property int $id
 * @property Carbon $updated_at
 *
 * @mixin Model
 */
trait AuthenticatesWithEntra
{
    public static function getEntraModel(array $details): static
    {
        /** @var EntraAuthenticatable $model */
        $model = static::query()
            ->when(static::usesSoftDeletes() === true, function ($query) {
                $query->withTrashed();
            })
            ->where('azure_id', '=', $details['id'])
            ->orWhere('email', '=', $details['mail'])
            ->firstOrNew();

        return $model;
    }

    public static function formatEntraDetails(array $details): array
    {
        foreach ($details as $key => $value) {
            if (is_array($value) === true) {
                $details[$key] = $value[0] ?? null;
            }

            if ($key === 'mail') {
                $details[$key] = strtolower($details[$key]);
            }
        }

        return $details;
    }

    public function syncEntraDetails(array $details): static
    {
        $attributes = config('entra.sync_attributes');
        $details = static::formatEntraDetails($details);

        foreach ($attributes as $azureKey => $laravelKey) {
            $this->$laravelKey = $details[$azureKey] ?? null;
        }

        if ($this->timestamps === true) {
            $this->updated_at = Carbon::now();
        }

        if (
            static::usesSoftDeletes() === true
            && $this->trashed() === true
        ) {
            $this->deleted_at = null;
        }

        $this->save();

        return $this;
    }

    public function entraId(): string
    {
        return $this->id;
    }

    public function entraEmail(): string
    {
        return $this->email;
    }

    public function entraToken(): HasOne
    {
        return $this->hasOne(EntraToken::class);
    }

    protected static function usesSoftDeletes(): bool
    {
        return in_array(
            SoftDeletes::class,
            class_uses_recursive(static::class),
            true,
        );
    }
}

<?php


namespace NetworkRailBusinessSystems\Entra\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use NetworkRailBusinessSystems\Entra\Database\Factories\EntraTokenFactory;

/**
 * @property string $access_token
 * @property Carbon $expires
 * @property ?string $refresh_token
 * @property Model $user
 * @property int $user_id
 */
class EntraToken extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $guarded = [
        'access_token',
        'expires',
        'refresh_token',
        'user_id',
    ];

    protected $casts = [
        'expires' => 'timestamp', // TODO TEST
        'user_id' => 'int',
    ];

    public $timestamps = false;

    // Setup
    protected static function newFactory(): EntraTokenFactory
    {
        return new EntraTokenFactory();
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            config('entra.models.user'),
        );
    }

    // Utilities
    public function hasExpired(): bool
    {
        return $this->expires->isPast() === true;
    }

    // Emulation
    public static function emulateResults(): array
    {
        return [
            'info' => [
                '@odata.context' => 'https://graph.microsoft.com/v1.0/...',
                'businessPhones' => [
                    '01234567890',
                ],
                'displayName' => 'Joe Bloggs',
                'employeeId' => '123456',
                'givenName' => 'Joe',
                'jobTitle' => 'Business Systems Developer',
                'mail' => 'Joe.Bloggs@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Some Office',
                'preferredLanguage' => null,
                'surname' => 'Bloggs',
                'userPrincipalName' => 'JBloggs2@networkrail.co.uk',
                'id' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
            ],
            'accessToken' => 'A string which is ~2400 characters long...',
            'refreshToken' => 'A string which is ~2400 characters long...',
            'expires' => 1234567890,
        ];
    }
}

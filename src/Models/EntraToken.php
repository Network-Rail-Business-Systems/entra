<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use Carbon\Carbon;
use Dcblogdev\MsGraph\Models\MsGraphToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use NetworkRailBusinessSystems\Entra\Tests\Database\Factories\EntraTokenFactory;

/**
 * @property string $access_token
 * @property Carbon $created_at
 * @property string $email
 * @property string $expires
 * @property int $id
 * @property string $refresh_token
 * @property Carbon $updated_at
 * @property Model $user
 * @property int $user_id
 */
class EntraToken extends MsGraphToken
{
    use HasFactory;

    protected $fillable = [
        'access_token',
        'email',
        'expires',
        'refresh_token',
        'user_id',
    ];

    protected $guarded = [
        'created_at',
        'id',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'id' => 'int',
        'updated_at' => 'datetime',
        'user_id' => 'int',
    ];

    protected $table = 'ms_graph_tokens';

    // Setup
    public function __construct(array $attributes = [])
    {
        parent::__construct();

        $this->fill($attributes);
    }

    protected static function newFactory(): EntraTokenFactory
    {
        return new EntraTokenFactory();
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            config('entra.user_model'),
        );
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
            'accessToken' => '... A string which is ~2400 characters long ...',
            'refreshToken' => '... A string which is ~2400 characters long ...',
            'expires' => 1234567890,
        ];
    }
}

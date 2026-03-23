<?php

namespace NetworkRailBusinessSystems\Entra\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;

class RefreshUsers extends Command
{
    protected $signature = 'entra:refresh-users {laravelField=email} {entraField=mail}';

    protected $description = 'Refresh the Users in your database with the latest details from Entra';

    public function handle(): void
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = config('entra.user_model');
        $userCount = $modelClass::query()->count();

        $this->info('This command will attempt to refresh every User in the database from Entra');
        $this->info("There are $userCount Users to process; this may take some time.");
        $this->confirm('Continue?');

        $this->info('Starting process...');
        $this->updateUsers($userCount);
        $this->info('Complete!');
    }

    protected function updateUsers(int $total): void
    {
        $current = 1;
        $laravelField = $this->argument('laravelField');
        $entraField = $this->argument('entraField');

        /** @var class-string<Model> $modelClass */
        $modelClass = config('entra.user_model');
        $modelClass::query()
            ->each(function ($user) use ($total, &$current, $entraField, $laravelField) {
                /** @var Model $user */

                $value = $user->$laravelField;
                $this->info("$current/$total | Processing $value...");

                if (EntraUser::import($value, $entraField) === null) {
                    $this->warn('-- Unable to find the user, or an error occurred');
                }

                ++$current;
            });
    }
}

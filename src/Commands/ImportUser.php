<?php

namespace NetworkRailBusinessSystems\Entra\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;

class ImportUser extends Command implements PromptsForMissingInput
{
    protected $signature = 'entra:import-user {term} {entraField=mail}';

    protected $description = 'Import a User from Entra';

    public function handle(): void
    {
        $term = $this->argument('term');
        $entraField = $this->argument('entraField');

        $this->info("Attempting import of $term...");
        EntraUser::import($term, $entraField);
        $this->info('Complete!');
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        $entraField = $this->argument('entraField');

        return [
            'term' => "What is the User's $entraField?",
        ];
    }
}

<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use NetworkRailBusinessSystems\Entra\Entra;

class EntraList
{
    public function __construct(
        public string $modelClass,
        public EntraAccessToken $token,
        public array $items = [],
        public ?string $nextLink = null,
    ) {
        //
    }

    public static function make(
        string $modelClass,
        EntraAccessToken $token,
        array $response,
    ): EntraList {
        return new EntraList(
            $modelClass,
            $token,
            EntraList::makeItems($modelClass, $response),
            $response[Entra::NEXT_LINK] ?? null,
        );
    }

    public function next(): EntraList
    {
        $response = Entra::query($this->nextLink, $this->token);

        return new EntraList(
            $this->modelClass,
            $this->token,
            EntraList::makeItems($this->modelClass, $response),
            $response[Entra::NEXT_LINK] ?? null,
        );
    }

    /** @param class-string<EntraUser> $modelClass */
    public static function makeItems(
        string $modelClass,
        array $response,
    ): array {
        $items = [];

        foreach ($response['value'] as $details) {
            $items[] = $modelClass::make($details);
        }

        return $items;
    }
}

<?php

namespace NetworkRailBusinessSystems\Entra\Traits;

trait AssertsEntra
{
    public function useEntraEmulator(): void
    {
        config()->set('entra.emulator.enabled', true);
    }
}

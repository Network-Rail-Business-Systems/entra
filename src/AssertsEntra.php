<?php

namespace NetworkRailBusinessSystems\Entra;

trait AssertsEntra
{
    public function useEntraEmulator(): void
    {
        config()->set('entra.emulator.enabled', true);
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GenerarCredenciales extends Page
{
    protected static ?string $navigationIcon = "heroicon-o-printer";
    protected static ?string $navigationLabel = "Imprimir Credenciales";
    protected static ?string $title = "Generar Credenciales QR";

    protected static string $view = "filament.pages.generar-credenciales";
}

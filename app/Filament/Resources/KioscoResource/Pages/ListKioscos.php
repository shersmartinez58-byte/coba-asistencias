<?php
namespace App\Filament\Resources\KioscoResource\Pages;
use App\Filament\Resources\KioscoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListKioscos extends ListRecords {
    protected static string $resource = KioscoResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}

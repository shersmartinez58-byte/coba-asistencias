<?php
namespace App\Filament\Resources\KioscoResource\Pages;
use App\Filament\Resources\KioscoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditKiosco extends EditRecord {
    protected static string $resource = KioscoResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}

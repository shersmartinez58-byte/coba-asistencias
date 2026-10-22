<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KioscoResource\Pages;
use App\Models\Kiosco;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KioscoResource extends Resource
{
    protected static ?string $model = Kiosco::class;
    protected static ?string $navigationIcon = "heroicon-o-qr-code";
    protected static ?string $navigationLabel = "Kioscos";
    protected static ?string $modelLabel = "Kiosco";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("nombre")->required()->maxLength(50),
            Forms\Components\TextInput::make("slug")->required()->maxLength(50)->unique(ignoreRecord: true),
            Forms\Components\TextInput::make("ubicacion")->maxLength(100),
            Forms\Components\TextInput::make("token")
                ->default(fn () => Str::random(64))
                ->required()->maxLength(64)->readOnly()
                ->helperText("Token de autenticación del kiosco. No lo compartas."),
            Forms\Components\Toggle::make("activo")->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("nombre")->searchable(),
                Tables\Columns\TextColumn::make("slug")->searchable()->badge(),
                Tables\Columns\TextColumn::make("ubicacion")->searchable(),
                Tables\Columns\TextColumn::make("token")->limit(20)->copyable()->toggleable(),
                Tables\Columns\IconColumn::make("activo")->boolean(),
            ])
            ->actions([
                Tables\Actions\Action::make("abrir")
                    ->label("Abrir kiosco")
                    ->icon("heroicon-o-arrow-top-right-on-square")
                    ->url(fn (Kiosco $r) => "/kiosco/{$r->slug}", true),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListKioscos::route("/"),
            "create" => Pages\CreateKiosco::route("/create"),
            "edit" => Pages\EditKiosco::route("/{record}/edit"),
        ];
    }
}

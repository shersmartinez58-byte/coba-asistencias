<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalificacionResource\Pages;
use App\Models\Calificacion;
use App\Models\Estudiante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CalificacionResource extends Resource
{
    protected static ?string $model = Calificacion::class;
    protected static ?string $navigationIcon = "heroicon-o-clipboard-document-list";
    protected static ?string $navigationLabel = "Calificaciones";
    protected static ?string $modelLabel = "Calificación";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make("matricula")
                ->label("Estudiante")
                ->options(fn () => Estudiante::all()->mapWithKeys(fn ($e) => [$e->matricula => "{$e->matricula} - {$e->nombre_completo}"]))
                ->searchable()->required(),
            Forms\Components\Select::make("materia_id")
                ->relationship("materia", "nombre")->required()->searchable()->preload(),
            Forms\Components\Select::make("parcial")
                ->options([1=>"1er parcial",2=>"2do parcial",3=>"3er parcial"])->required(),
            Forms\Components\TextInput::make("calificacion")
                ->numeric()->minValue(0)->maxValue(10)->step(0.1)->required(),
            Forms\Components\TextInput::make("periodo")->default("2025-2026-1")->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("matricula")->label("Matrícula")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("estudiante.nombre")
                    ->label("Estudiante")
                    ->getStateUsing(fn (Calificacion $r) => $r->estudiante?->nombre_completo)
                    ->searchable(["estudiante.nombre","estudiante.apellido_paterno"]),
                Tables\Columns\TextColumn::make("materia.nombre")->label("Materia")->sortable(),
                Tables\Columns\TextColumn::make("parcial")->label("Parcial")->badge(),
                Tables\Columns\TextColumn::make("calificacion")
                    ->color(fn ($state) => $state >= 6 ? "success" : "danger")
                    ->weight("bold"),
                Tables\Columns\TextColumn::make("periodo")->label("Periodo")->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("materia_id")
                    ->relationship("materia", "nombre")->label("Materia"),
                Tables\Filters\SelectFilter::make("parcial")
                    ->options([1=>"1er parcial",2=>"2do parcial",3=>"3er parcial"]),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListCalificaciones::route("/"),
            "create" => Pages\CreateCalificacion::route("/create"),
            "edit" => Pages\EditCalificacion::route("/{record}/edit"),
        ];
    }
}

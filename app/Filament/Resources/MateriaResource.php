<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MateriaResource\Pages;
use App\Models\Materia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MateriaResource extends Resource
{
    protected static ?string $model = Materia::class;
    protected static ?string $navigationIcon = "heroicon-o-book-open";
    protected static ?string $navigationLabel = "Materias";
    protected static ?string $modelLabel = "Materia";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("nombre")->required()->maxLength(100),
            Forms\Components\TextInput::make("clave")->required()->maxLength(20)->unique(ignoreRecord: true),
            Forms\Components\Select::make("semestre")
                ->options(["1"=>"1°","2"=>"2°","3"=>"3°","4"=>"4°","5"=>"5°","6"=>"6°"])
                ->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("clave")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("nombre")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("semestre")->sortable()->label("Semestre"),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("semestre")
                    ->options(["1"=>"1°","2"=>"2°","3"=>"3°","4"=>"4°","5"=>"5°","6"=>"6°"]),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListMaterias::route("/"),
            "create" => Pages\CreateMateria::route("/create"),
            "edit" => Pages\EditMateria::route("/{record}/edit"),
        ];
    }
}

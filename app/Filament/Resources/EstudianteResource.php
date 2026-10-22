<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstudianteResource\Pages;
use App\Models\Estudiante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;
    protected static ?string $navigationIcon = "heroicon-o-academic-cap";
    protected static ?string $navigationLabel = "Estudiantes";
    protected static ?string $modelLabel = "Estudiante";
    protected static ?string $pluralModelLabel = "Estudiantes";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make("Datos del estudiante")->schema([
                Forms\Components\TextInput::make("matricula")
                    ->required()->maxLength(20)->unique(ignoreRecord: true)
                    ->label("Matrícula"),
                Forms\Components\TextInput::make("nombre")->required()->maxLength(100),
                Forms\Components\TextInput::make("apellido_paterno")->required()->maxLength(100),
                Forms\Components\TextInput::make("apellido_materno")->maxLength(100),
                Forms\Components\DatePicker::make("fecha_nacimiento")->required(),
                Forms\Components\TextInput::make("curp")->maxLength(18)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make("telefono")->tel()->maxLength(15),
                Forms\Components\TextInput::make("email")->email()->unique(ignoreRecord: true),
            ])->columns(2),

            Forms\Components\Section::make("Datos académicos")->schema([
                Forms\Components\Select::make("semestre")
                    ->options(["1"=>"1°","2"=>"2°","3"=>"3°","4"=>"4°","5"=>"5°","6"=>"6°"])
                    ->required(),
                Forms\Components\TextInput::make("grupo")->required()->maxLength(5),
                Forms\Components\Select::make("turno")
                    ->options(["Matutino"=>"Matutino","Vespertino"=>"Vespertino"])
                    ->required(),
                Forms\Components\Toggle::make("activo")->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("matricula")->searchable()->sortable()->label("Matrícula"),
                Tables\Columns\TextColumn::make("nombre")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("apellido_paterno")->searchable()->label("Apellido paterno"),
                Tables\Columns\TextColumn::make("semestre")->sortable()->label("Semestre"),
                Tables\Columns\TextColumn::make("grupo")->sortable()->label("Grupo"),
                Tables\Columns\TextColumn::make("turno")->sortable()->badge(),
                Tables\Columns\IconColumn::make("activo")->boolean()->label("Activo"),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("turno")
                    ->options(["Matutino"=>"Matutino","Vespertino"=>"Vespertino"]),
                Tables\Filters\SelectFilter::make("semestre")
                    ->options(["1"=>"1°","2"=>"2°","3"=>"3°","4"=>"4°","5"=>"5°","6"=>"6°"]),
                Tables\Filters\TernaryFilter::make("activo")->label("Activo"),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListEstudiantes::route("/"),
            "create" => Pages\CreateEstudiante::route("/create"),
            "edit" => Pages\EditEstudiante::route("/{record}/edit"),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HorarioResource\Pages;
use App\Models\Horario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HorarioResource extends Resource
{
    protected static ?string $model = Horario::class;
    protected static ?string $navigationIcon = "heroicon-o-calendar-days";
    protected static ?string $navigationLabel = "Horarios";
    protected static ?string $modelLabel = "Horario";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make("semestre")
                ->options(["1"=>"1°","2"=>"2°","3"=>"3°","4"=>"4°","5"=>"5°","6"=>"6°"])->required(),
            Forms\Components\TextInput::make("grupo")->required()->maxLength(5),
            Forms\Components\Select::make("turno")
                ->options(["Matutino"=>"Matutino","Vespertino"=>"Vespertino"])->required(),
            Forms\Components\Select::make("dia_semana")
                ->options([1=>"Lunes",2=>"Martes",3=>"Miércoles",4=>"Jueves",5=>"Viernes"])->required(),
            Forms\Components\TimePicker::make("hora_inicio")->required()->seconds(false),
            Forms\Components\TimePicker::make("hora_fin")->required()->seconds(false),
            Forms\Components\Select::make("materia_id")
                ->relationship("materia", "nombre")->required()->searchable()->preload(),
            Forms\Components\TextInput::make("docente")->maxLength(100)->label("Docente (opcional)"),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("semestre")->label("Semestre")->sortable(),
                Tables\Columns\TextColumn::make("grupo")->sortable(),
                Tables\Columns\TextColumn::make("turno")->badge(),
                Tables\Columns\TextColumn::make("dia_nombre")->label("Día")->sortable(),
                Tables\Columns\TextColumn::make("hora_inicio")->label("Inicio")->time("H:i"),
                Tables\Columns\TextColumn::make("hora_fin")->label("Fin")->time("H:i"),
                Tables\Columns\TextColumn::make("materia.nombre")->label("Materia")->searchable(),
                Tables\Columns\TextColumn::make("docente")->label("Docente"),
            ])
            ->defaultSort("dia_semana")
            ->filters([
                Tables\Filters\SelectFilter::make("semestre")->options(["1"=>"1°","2"=>"2°","3"=>"3°","4"=>"4°","5"=>"5°","6"=>"6°"]),
                Tables\Filters\SelectFilter::make("grupo")->options(fn () => Horario::distinct()->pluck("grupo","grupo")->toArray()),
                Tables\Filters\SelectFilter::make("turno")->options(["Matutino"=>"Matutino","Vespertino"=>"Vespertino"]),
                Tables\Filters\SelectFilter::make("dia_semana")->options([1=>"Lunes",2=>"Martes",3=>"Miércoles",4=>"Jueves",5=>"Viernes"]),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListHorarios::route("/"),
            "create" => Pages\CreateHorario::route("/create"),
            "edit" => Pages\EditHorario::route("/{record}/edit"),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsistenciaResource\Pages;
use App\Models\Asistencia;
use App\Models\Estudiante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AsistenciaResource extends Resource
{
    protected static ?string $model = Asistencia::class;
    protected static ?string $navigationIcon = "heroicon-o-clock";
    protected static ?string $navigationLabel = "Asistencias";
    protected static ?string $modelLabel = "Asistencia";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make("matricula")
                ->label("Estudiante")
                ->options(fn () => Estudiante::all()->mapWithKeys(fn ($e) => [$e->matricula => "{$e->matricula} - {$e->nombre_completo}"]))
                ->searchable()->required(),
            Forms\Components\DatePicker::make("fecha")->required(),
            Forms\Components\DateTimePicker::make("hora_entrada")->seconds(false),
            Forms\Components\DateTimePicker::make("hora_salida")->seconds(false),
            Forms\Components\Select::make("estado")
                ->options(["presente"=>"Presente","retardo"=>"Retardo","falta"=>"Falta","justificada"=>"Justificada"])
                ->required(),
            Forms\Components\Textarea::make("observacion")->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort("fecha", "desc")
            ->columns([
                Tables\Columns\TextColumn::make("fecha")->date("d/m/Y")->sortable(),
                Tables\Columns\TextColumn::make("matricula")->label("Matrícula")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("estudiante.nombre")
                    ->label("Estudiante")
                    ->getStateUsing(fn (Asistencia $r) => $r->estudiante?->nombre_completo),
                Tables\Columns\TextColumn::make("hora_entrada")->label("Entrada")->time("H:i:s")->placeholder("—"),
                Tables\Columns\TextColumn::make("hora_salida")->label("Salida")->time("H:i:s")->placeholder("—"),
                Tables\Columns\TextColumn::make("estado")
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        "presente" => "success",
                        "retardo" => "warning",
                        "falta" => "danger",
                        "justificada" => "info",
                        default => "gray",
                    }),
                Tables\Columns\TextColumn::make("kioscoEntrada.nombre")->label("Kiosco entrada")->toggleable(),
                Tables\Columns\TextColumn::make("kioscoSalida.nombre")->label("Kiosco salida")->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("estado")
                    ->options(["presente"=>"Presente","retardo"=>"Retardo","falta"=>"Falta","justificada"=>"Justificada"]),
                Tables\Filters\Filter::make("fecha")
                    ->form([
                        Forms\Components\DatePicker::make("desde"),
                        Forms\Components\DatePicker::make("hasta"),
                    ])
                    ->query(fn ($query, array $data) => $query
                        ->when($data["desde"], fn ($q, $d) => $q->whereDate("fecha", ">=", $d))
                        ->when($data["hasta"], fn ($q, $d) => $q->whereDate("fecha", "<=", $d))
                    ),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListAsistencias::route("/"),
            "create" => Pages\CreateAsistencia::route("/create"),
            "edit" => Pages\EditAsistencia::route("/{record}/edit"),
        ];
    }
}

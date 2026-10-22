<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReporteResource\Pages;
use App\Models\Estudiante;
use App\Models\Reporte;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ReporteResource extends Resource
{
    protected static ?string $model = Reporte::class;
    protected static ?string $navigationIcon = "heroicon-o-exclamation-triangle";
    protected static ?string $navigationLabel = "Reportes";
    protected static ?string $modelLabel = "Reporte";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make("matricula")
                ->label("Estudiante")
                ->options(fn () => Estudiante::all()->mapWithKeys(fn ($e) => [$e->matricula => "{$e->matricula} - {$e->nombre_completo}"]))
                ->searchable()->required(),
            Forms\Components\Select::make("tipo")
                ->options(["conducta"=>"Conducta","academico"=>"Académico","medico"=>"Médico","otro"=>"Otro"])
                ->required(),
            Forms\Components\Textarea::make("descripcion")->required()->columnSpanFull(),
            Forms\Components\Hidden::make("creado_por")->default(fn () => Auth::id()),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort("created_at", "desc")
            ->columns([
                Tables\Columns\TextColumn::make("created_at")->label("Fecha")->dateTime("d/m/Y H:i")->sortable(),
                Tables\Columns\TextColumn::make("matricula")->label("Matrícula")->searchable(),
                Tables\Columns\TextColumn::make("estudiante.nombre")
                    ->label("Estudiante")
                    ->getStateUsing(fn (Reporte $r) => $r->estudiante?->nombre_completo),
                Tables\Columns\TextColumn::make("tipo")->badge()
                    ->color(fn ($state) => match($state) {
                        "conducta" => "danger",
                        "academico" => "warning",
                        "medico" => "info",
                        default => "gray",
                    }),
                Tables\Columns\TextColumn::make("descripcion")->limit(50),
                Tables\Columns\TextColumn::make("creador.name")->label("Creado por")->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("tipo")
                    ->options(["conducta"=>"Conducta","academico"=>"Académico","medico"=>"Médico","otro"=>"Otro"]),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListReportes::route("/"),
            "create" => Pages\CreateReporte::route("/create"),
            "edit" => Pages\EditReporte::route("/{record}/edit"),
        ];
    }
}

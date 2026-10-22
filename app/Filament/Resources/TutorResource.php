<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TutorResource\Pages;
use App\Models\Estudiante;
use App\Models\Tutor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TutorResource extends Resource
{
    protected static ?string $model = Tutor::class;
    protected static ?string $navigationIcon = "heroicon-o-user-group";
    protected static ?string $navigationLabel = "Tutores";
    protected static ?string $modelLabel = "Tutor";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("nombre")->required()->maxLength(100),
            Forms\Components\TextInput::make("apellido_paterno")->required()->maxLength(100),
            Forms\Components\TextInput::make("apellido_materno")->maxLength(100),
            Forms\Components\TextInput::make("telefono")->required()->tel()->maxLength(15),
            Forms\Components\TextInput::make("email")->required()->email()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make("parentesco")->required()->maxLength(50),
            Forms\Components\Select::make("estudiantes")
                ->label("Hijos")
                ->multiple()
                ->relationship("estudiantes", "matricula")
                ->getOptionLabelFromRecordUsing(fn (Estudiante $r) => "{$r->matricula} - {$r->nombre_completo}")
                ->searchable()
                ->preload(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("nombre")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("apellido_paterno")->label("Apellido")->searchable(),
                Tables\Columns\TextColumn::make("email")->searchable()->label("Email"),
                Tables\Columns\TextColumn::make("telefono")->label("Teléfono"),
                Tables\Columns\TextColumn::make("parentesco")->label("Parentesco")->badge(),
                Tables\Columns\TextColumn::make("estudiantes_count")->counts("estudiantes")->label("Hijos"),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListTutores::route("/"),
            "create" => Pages\CreateTutor::route("/create"),
            "edit" => Pages\EditTutor::route("/{record}/edit"),
        ];
    }
}

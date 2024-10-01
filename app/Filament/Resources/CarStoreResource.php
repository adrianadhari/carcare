<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarStoreResource\Pages;
use App\Filament\Resources\CarStoreResource\RelationManagers;
use App\Filament\Resources\CarStoreResource\RelationManagers\PhotosRelationManager;
use App\Models\CarService;
use App\Models\CarStore;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CarStoreResource extends Resource
{
    protected static ?string $model = CarStore::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Select::make('city_id')
                    ->label('City')
                    ->relationship('city', 'name'),
                TextInput::make('cs_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->required()
                    ->numeric(),
                FileUpload::make('thumbnail')
                    ->required()
                    ->image()
                    ->directory('thumbnail'),
                Textarea::make('address')
                    ->required(),
                Select::make('is_full')
                    ->required()
                    ->label('Status Capacity')
                    ->options([
                        true => 'Full Booked',
                        false => 'Available'
                    ]),
                Select::make('is_open')
                    ->required()
                    ->label('Status Store')
                    ->options([
                        true => 'Open',
                        false => 'Not Open'
                    ]),
                Repeater::make('storeServices')
                    ->relationship()
                    ->schema([
                        Select::make('car_service_id')
                            ->relationship('storeService', 'name')
                            ->required()
                    ]),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                IconColumn::make('is_open')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Buka?'),
                IconColumn::make('is_full')
                    ->boolean()
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueIcon('heroicon-o-x-circle')
                    ->label('Tersedia?'),
                ImageColumn::make('thumbnail')
            ])
            ->filters([
                SelectFilter::make('city_id')
                    ->label('City')
                    ->relationship('city', 'name'),
                // SelectFilter::make('car_service_id')
                //     ->label('Service')
                //     ->options(CarService::pluck('name', 'id'))
                //     ->query(function (Builder $query, array  $data) {
                //         $query->whereHas('storeServices', function ($query) use ($data) {
                //             $query->where('car_service_id', $data['value']);
                //         });
                //     })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PhotosRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarStores::route('/'),
            'create' => Pages\CreateCarStore::route('/create'),
            'edit' => Pages\EditCarStore::route('/{record}/edit'),
        ];
    }
}

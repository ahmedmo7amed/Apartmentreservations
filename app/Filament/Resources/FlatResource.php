<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlatResource\Pages;
use App\Filament\Resources\FlatResource\RelationManagers;
use App\Models\Flat;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FlatResource extends Resource
{
    protected static ?string $model = Flat::class;

    //path ="images/flats
    //private const IMAGE_DIRECTORY = 'flats/images' ; // Directory for storing images

    //store Images
    public static function storeImages(Flat $flat, array $images): void
    {
        foreach ($images as $image) {
            $flat->addMediaFromRequest($image)
                ->toMediaCollection('flats-images');
        }
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('bedrooms')
                    ->required()
                    ->numeric()
                    ->afterStateUpdated(function (callable $set, $state, callable $get) {
                        $features = $get('features') ?? [];
                        $features = array_filter($features, fn($f) => $f['name'] !== 'Bedrooms');
                        $features[] = ['name' => 'Bedrooms', 'value' => $state];
                        $set('features', array_values($features));
                    }),
                Forms\Components\TextInput::make('bathrooms')
                    ->required()
                    ->numeric()
                    ->afterStateUpdated(function (callable $set, $state, callable $get) {
                        $features = $get('features') ?? [];
                        $features = array_filter($features, fn($f) => $f['name'] !== 'Bathrooms');
                        $features[] = ['name' => 'Bathrooms', 'value' => $state];
                        $set('features', array_values($features));
                    }),
                Forms\Components\TextInput::make('floor_area')
                    ->required()
                    ->numeric()
                    ->afterStateUpdated(function (callable $set, $state, callable $get) {
                        $features = $get('features') ?? [];
                        $features = array_filter($features, fn($f) => $f['name'] !== 'Floor Area');
                        $features[] = ['name' => 'Floor Area', 'value' => $state . ' sqft'];
                        $set('features', array_values($features));
                    }),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('available'),
                Forms\Components\Repeater::make('features')
                    ->label('Features')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Feature Name')
                            ->required(),
                        Forms\Components\TextInput::make('value')
                            ->label('Feature Value')
                            ->required(),
                    ])
                    ->default([])
                    ->columns(2) // عرض الحقول جنبًا إلى جنب
                    ->columnSpanFull(),
                    FileUpload::make('images')
                        ->label('Flat Images')
                        ->multiple()
                        ->disk('public')
                        ->directory('flats-images')
                        ->image()
                        ->reorderable()
                        ->openable()
                        ->rules(['image', 'mimes:jpg,jpeg,png', 'max:4096']) // حجم أقصى 2 ميجابايت
                        ->imagePreviewHeight('100'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bedrooms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bathrooms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('floor_area')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFlats::route('/'),
            'create' => Pages\CreateFlat::route('/create'),
            'edit' => Pages\EditFlat::route('/{record}/edit'),
        ];
    }



}

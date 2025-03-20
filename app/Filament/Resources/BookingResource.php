<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Booking;
use App\Models\Flat;
use App\Models\Room;
use App\Observers\BookingObservers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function query(EloquentBuilder $query): EloquentBuilder
    {
        return $query= Booking::with(['Customer', 'bookable']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('تفاصيل الحجز')
                    ->schema([
                        // app/Filament/Resources/BookingResource.php

// في الفورم
                        Forms\Components\Radio::make('booking_type')
                            ->label('نوع الحجز')
                            ->options([
                                //Room::class => 'غرفة',
                                //Flat::class => 'شقة'
                                'room' => 'غرفة',
                                'flat' => 'شقة'
                               ])
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(function (callable $set) {
                                $set('bookable_id', null);
                                $set('total_price', 0);
                            }),

                        Forms\Components\Select::make('bookable_id')
                            ->label('اختر المكان')
                            ->options(function ($get) {
                                $type = $get('booking_type');
                                if ($type === 'room') {
                                    return Room::pluck('title', 'id');
                                } elseif ($type === 'flat') {
                                    return Flat::pluck('title', 'id');
                                }
                                return [];
                            })
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $get, callable $set) =>
                            BookingObservers::calculateTotalPrice($get, $set)),

                        Forms\Components\DateTimePicker::make('time_from')
                            ->label('تاريخ البداية')
                            ->required()
                            ->seconds(false)
                            ->displayFormat('d/m/Y H:i')
                            ->afterStateUpdated(fn ($state, callable $get, callable $set) =>
                            BookingObservers::calculateTotalPrice($get, $set)
                            ),

                        Forms\Components\DateTimePicker::make('time_to')
                            ->label('تاريخ النهاية')
                            ->required()
                            ->seconds(false)
                            ->displayFormat('d/m/Y H:i')
                            ->afterStateUpdated(fn ($state, callable $get, callable $set) =>
                            BookingObservers::calculateTotalPrice($get, $set)
                            ),

                        Forms\Components\TextInput::make('total_price')
                            ->label('السعر الإجمالي')
                            ->numeric()
                            ->prefix(config('app.currency', 'USD'))
                            ->disabled()
                            ->dehydrated(true)
                    ]),

                Forms\Components\Section::make('معلومات العميل')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->label('العميل')
                            ->relationship('Customer', 'first_name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('first_name')
                                    ->label('الاسم')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('البريد الإلكتروني')
                                    ->email()
                                    ->required()
                            ])
                            ->required(),

                    ]),

            //dd($data)

            ]);



    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Customer.full_name')
                    ->label('العميل')
                    ->formatStateUsing(fn ($state) => $state ?? 'غير معروف')
                    ->sortable(),

                Tables\Columns\TextColumn::make('bookable_type')
                    ->label('النوع')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        \App\Models\Room::class => 'غرفة',
                        \App\Models\Flat::class => 'شقة',
                        default => 'غير معروف',
                    }),

                Tables\Columns\TextColumn::make('bookable.title')
                    ->label('اسم المكان')
                    ->formatStateUsing(fn ($state) => $state ?? 'غير معروف'),

                Tables\Columns\TextColumn::make('time_from')
                    ->label('تاريخ البداية')
                    ->dateTime('d/m/Y H:i')
                    ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : 'غير محدد'),

                Tables\Columns\TextColumn::make('time_to')
                    ->label('تاريخ النهاية')
                    ->dateTime('d/m/Y H:i')
                    ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : 'غير محدد'),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('السعر')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' ' . config('app.currency', 'USD') : 'غير محدد'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('bookable_type')
                    ->label('نوع الحجز')
                    ->options([
                        \App\Models\Room::class => 'غرف',
                        \App\Models\Flat::class => 'شقق',
                    ])
                    ->query(fn ($query, $data) => $data['value'] ? $query->where('bookable_type', $data['value']) : $query),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}

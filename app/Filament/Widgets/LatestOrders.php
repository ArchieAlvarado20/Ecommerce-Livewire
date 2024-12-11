<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OrderState;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                ->label('Order ID')
                ->searchable(),

                TextColumn::make('user.name')
                ->label('Customer')
                ->searchable(),
 
                TextColumn::make('grand_total')
                ->money('PHP'),
 
                TextColumn::make('status')
                ->badge()
                ->color(fn (string $state):string => match($state){
                 'new' => 'info',
                 'processing' => 'warning',
                 'shipped' => 'primary',
                 'delivered' => 'success',
                 'canceled' => 'danger' 
                })
                ->icon(fn (string $state):string => match($state){
                 'new' => 'heroicon-o-sparkles',
                 'processing' => 'heroicon-o-arrow-path',
                 'shipped' => 'heroicon-o-truck',
                 'delivered' => 'heroicon-o-check-badge',
                 'canceled' => 'heroicon-o-x-circle' 
                }),
 
                TextColumn::make('payment_method')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn (string $state) => ucfirst($state))
                ->extraAttributes(['class' => 'text-center'])
                ->alignCenter(),
 
                TextColumn::make('payment_status')
                ->sortable()
                ->badge()
                ->color(fn (string $state):string => match($state){
                    'pending' => 'warning',
                    'paid' => 'success',
                    'failed' => 'danger'
                 })
                ->searchable()
                ->formatStateUsing(fn (string $state) => ucfirst($state))
                ->extraAttributes(['class' => 'text-center'])
                ->alignCenter(),
 
                TextColumn::make('created_at')
                ->label('Order Date')
                ->dateTime()
            ])
            ->actions([
                Tables\Actions\Action::make('View Order')
                ->url(fn (Order $record):string => OrderResource::getUrl('view', ['record' => $record]))
                ->color('info')
                ->icon('heroicon-o-eye'),
            ]);
    }
}

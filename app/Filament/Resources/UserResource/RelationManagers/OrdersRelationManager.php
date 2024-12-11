<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('id')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
               TextColumn::make('id')
               ->label('Order ID')
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
               ->searchable()
               ->formatStateUsing(fn (string $state) => ucfirst($state))
               ->extraAttributes(['class' => 'text-center'])
               ->alignCenter(),

               TextColumn::make('created_at')
               ->label('Order Date')
               ->dateTime()
            ])
            ->filters([
                //
            ])
            // ->headerActions([
            //     Tables\Actions\CreateAction::make(),
            // ])
            ->actions([
                Tables\Actions\Action::make('View Order')
                ->url(fn (Order $record):string => OrderResource::getUrl('view', ['record' => $record]))
                ->color('info')
                ->icon('heroicon-o-eye'),
                
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

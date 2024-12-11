<?php

namespace App\Filament\Auth;

use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login;
use Filament\Forms\Components\TextInput;

class CustomLogin 
{
    protected function getForms(): array
    {
        return [
            'form' => $this->forms(
                $this->makeForm()
                ->schema([
                    $this->getLoginFormComponent(),
                    $this->getPasswordFormComponent(),
                    $this->getRemeberFormComponent(),
                ])
                ->statepath(path : 'data'),
                ),
            ];
    }
    protected function getLoginFormComponent(): Component
    {
        return TextInput::make(name: 'login')
        ->label(__(key: 'Username / Email'))
        ->required()
        ->autocomplete()
        ->autofocus()
        ->extraInputAttributes(['tabindex' => 1]);
    }
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ManageSettings extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Settings';

    protected static ?string $slug = 'settings';

    protected string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->loadSettings());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Settings')
                    ->tabs(fn (): array => $this->buildTabs()),
            ])
            ->statePath('data');
    }

    protected function loadSettings(): array
    {
        return Setting::query()
            ->orderBy('group')
            ->orderBy('sort_order')
            ->get()
            ->mapWithKeys(fn (Setting $s) => [$this->formKey($s->key) => $s->castValue()])
            ->toArray();
    }

    protected function buildTabs(): array
    {
        $tabs = [];

        Setting::query()
            ->orderBy('group')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('group')
            ->each(function ($settings, string $group) use (&$tabs) {
                $tabs[] = Tab::make(Str::title($group))
                    ->columns(2)
                    ->schema(
                        $settings
                            ->map(fn (Setting $s) => $this->fieldFor($s))
                            ->all()
                    );
            });

        return $tabs;
    }

    protected function fieldFor(Setting $setting)
    {
        $key = $this->formKey($setting->key);

        $field = match ($setting->type) {
            'boolean' => Toggle::make($key),
            'number' => TextInput::make($key)->numeric(),
            'json' => Textarea::make($key)
                ->rows(4)
                ->helperText('Raw JSON value.'),
            'image' => TextInput::make($key),
            default => $setting->value && mb_strlen((string) $setting->value) > 120
                ? Textarea::make($key)->rows(3)
                : TextInput::make($key),
        };

        $field->label($setting->label ?? $setting->key);

        if ($setting->description) {
            $field->helperText($setting->description);
        }

        return $field;
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($this->settingKey($key), $value);
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }

    protected function formKey(string $key): string
    {
        return str_replace('.', '__', $key);
    }

    protected function settingKey(string $key): string
    {
        return str_replace('__', '.', $key);
    }
}
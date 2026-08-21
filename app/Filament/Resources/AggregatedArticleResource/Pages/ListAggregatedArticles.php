<?php

namespace App\Filament\Resources\AggregatedArticleResource\Pages;

use App\Filament\Resources\AggregatedArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAggregatedArticles extends ListRecords
{
    protected static string $resource = AggregatedArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

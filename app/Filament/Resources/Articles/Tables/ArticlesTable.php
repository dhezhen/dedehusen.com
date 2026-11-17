<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Enums\ArticleCategory;
use App\Models\Article;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->formatStateUsing(fn (?string $state): string => ArticleCategory::tryFrom((string) $state)?->label() ?? ucfirst((string) $state))
                    ->badge(),
                TextColumn::make('publication_state')
                    ->label('Status')
                    ->state(fn (Article $record): string => $record->publicationStatus())
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Terbit' => 'success',
                        'Terjadwal' => 'info',
                        'Tanggal belum diatur' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('published_at')
                    ->label('Tanggal terbit')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Terakhir diubah')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(ArticleCategory::options()),
                TernaryFilter::make('is_published')
                    ->label('Status publikasi')
                    ->placeholder('Semua status')
                    ->trueLabel('Aktif, termasuk terjadwal')
                    ->falseLabel('Draf'),
            ])
            ->recordActions([
                EditAction::make()->label('Ubah'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus dipilih'),
                ]),
            ]);
    }
}

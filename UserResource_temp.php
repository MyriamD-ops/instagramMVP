<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Utilisateurs';

    protected static ?string $modelLabel = 'utilisateur';

    protected static ?string $pluralModelLabel = 'utilisateurs';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations personnelles')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('username')
                            ->label('Nom d\'utilisateur')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->alphaDash(),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('password')
                            ->label('Mot de passe')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->minLength(8),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Profil')
                    ->schema([
                        Forms\Components\Textarea::make('bio')
                            ->label('Biographie')
                            ->maxLength(150)
                            ->rows(3),
                        
                        Forms\Components\TextInput::make('website')
                            ->label('Site web')
                            ->url()
                            ->maxLength(255),
                        
                        Forms\Components\FileUpload::make('profile_picture')
                            ->label('Photo de profil')
                            ->image()
                            ->directory('profile_pictures')
                            ->visibility('public'),
                        
                        Forms\Components\Toggle::make('is_private')
                            ->label('Compte privé')
                            ->default(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Statistiques')
                    ->schema([
                        Forms\Components\Placeholder::make('followers_count')
                            ->label('Followers')
                            ->content(fn (User $record): string => $record->followers_count ?? '0'),
                        
                        Forms\Components\Placeholder::make('following_count')
                            ->label('Abonnements')
                            ->content(fn (User $record): string => $record->following_count ?? '0'),
                        
                        Forms\Components\Placeholder::make('posts_count')
                            ->label('Posts')
                            ->content(fn (User $record): string => $record->posts_count ?? '0'),
                    ])
                    ->columns(3)
                    ->hidden(fn (string $context): bool => $context === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                
                Tables\Columns\TextColumn::make('username')
                    ->label('Nom d\'utilisateur')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\IconColumn::make('is_private')
                    ->label('Privé')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('followers_count')
                    ->label('Followers')
                    ->sortable()
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('following_count')
                    ->label('Suivis')
                    ->sortable()
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Posts')
                    ->sortable()
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Inscrit le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_private')
                    ->label('Compte privé')
                    ->boolean()
                    ->trueLabel('Privés uniquement')
                    ->falseLabel('Publics uniquement')
                    ->native(false),
                
                Tables\Filters\Filter::make('has_posts')
                    ->label('Avec posts')
                    ->query(fn (Builder $query): Builder => $query->where('posts_count', '>', 0)),
                
                Tables\Filters\Filter::make('popular')
                    ->label('Populaires (10+ followers)')
                    ->query(fn (Builder $query): Builder => $query->where('followers_count', '>=', 10)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

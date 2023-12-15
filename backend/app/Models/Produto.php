<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'descricao',
        'data_validade',
        'preco',
        'imagem',
        'categoria_id',
    ];

    protected $hidden = ['categoria_id'];


    protected function dataValidade(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn (string $value) => Carbon::parse($value),
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::get(fn (string $value) => Carbon::parse($value)->format('d/m/Y'));
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::get( fn (string $value) => Carbon::parse($value)->format('d/m/Y'));
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }
}

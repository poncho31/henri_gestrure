<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 *
 * @property string $name
 * @property string $path
 * @property string $fullpath
 * @property $getOptions
 * @property string $options
 *
 * @property string $category
 *
 * @property bool    $isRunning
 * @property int     $processId
 * @property string  $processName
 * @property string  $deviceName
 *
 * @property string  $command
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property User $idUser
* @package App\Models\Entities
* @mixin Builder

*/
class Record extends Model
{
    use HasFactory, SoftDeletes;

    protected string $schema = 'henrigestrure';
    protected        $table  = 'records';
    public           $timestamps  = true;

    protected        $fillable = [
        'id',
        'name', 'path', 'fullpath',
        'processName', 'processId', 'deviceName','isRunning',
        'command',
        'options',
        'created_at', 'updated_at', 'deleted_at'
    ];


    public function options(): Attribute
    {
        return Attribute::make(
            get: fn ($value)=> is_array($value)? $value : json_decode($value??'', true),

        );
    }

    public function create(string $fullpath, array $options = []): Model|Record
    {
        return $this->updateOrCreate(['fullpath'=>$fullpath], [
            'name'    => basename($fullpath),
            'path'    => dirname($fullpath) ,
            'options' => json_encode($options ?? null) ,
        ]);
    }



}

<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;

    protected $fillable = ['title', 'alt', 'file_path', 'file_url', 'author_id'];

    public function scopeAuthor($query, int $userId)
    {
        return $query->where('author_id', '=', $userId);
    }

    public $timestamps = false;

}

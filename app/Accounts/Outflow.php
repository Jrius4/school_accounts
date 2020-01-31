<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;
use App\ExpenseTag;

class Outflow extends Model
{
    protected $fillable = ['destination_identifier','amount'];



    public function expenseTags(){
      return  $this->belongsToMany(ExpenseTag::class);
    }

    public function expenseTag(){
      return  $this->belongsTo(ExpenseTag::class);
    }

    public function getTagsListAttribute()
    {
        return $this->expenseTags->pluck('name');
    }

    public function createTags($str)
    {
        $tags = explode(",", $str);
        $tagIds = [];

        foreach ($tags as $tag)
        {
            $newTag = ExpenseTag::firstOrCreate([
                'slug' => str_slug($tag),
                'name' => ucwords(trim($tag))
            ]);

            $tagIds[] = $newTag->id;
        }

        $this->expenseTags()->sync($tagIds);
    }
}

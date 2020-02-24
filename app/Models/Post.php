<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable=['post_title','post_image','post_category_id','post_title_seo','post_description','page_name'];

}

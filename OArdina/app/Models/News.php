<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class News extends Model
{
    use HasFactory;

    /**
     * The table's name.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'content_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates the type of the content.
     *
     * @var string
     */
    public $type = "post";

    /**
     * Get the content that owns the news.
     */
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    /**
     * Get the comments

        associaceted with the news.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'news_id');
    }

    /**
     * Get the tags associaceted with the news.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tag', 'news_id', 'tag_id');
    }

    /**
     * Get the comments that are being replied
     */
    public function getParentComments(){
        $query = $this->hasMany(Comment::class, 'news_id')->where('reply_to_id', null)->orderByDesc(
            Content::select('date')
                ->whereColumn('id', 'comment.content_id')
                ->orderByDesc('date')
                ->limit(1)
        );

        return $query;
    }


    /**
     * Get Posts from Feed
     */
    public static function getFeedPosts(){
        return News::whereIn('content_id', function ($query) {
            $query->select('id')
                ->from('content')
                ->whereIn('author_id', function ($query) {
                    $query->select('users_id')
                        ->from('follow')
                        ->where('follower_id', Auth::id());
                });
        })->get();
    }

    /**
     * Search news
     *
     * @param string $query
     * @param string $sortby
     * @return string
     */
     public static function search($search, $sortby)
     {
        $news = News::whereRaw('search @@ websearch_to_tsquery(\'english\', ?)', [$search]);

        switch($sortby){
            case 1: // relevance
                $news->orderByRaw('ts_rank(search, websearch_to_tsquery(\'english\', ?)) DESC', [$search]);
                break;
            case 2: // top
                $news->orderByDesc(
                    Content::select('nr_votes')
                        ->whereColumn('id', 'news.content_id')
                        ->orderBy('nr_votes')    
                );
                break;
            case 3: // new
                $news->orderByDesc(
                    Content::select('date')
                        ->whereColumn('id', 'news.content_id')
                        ->orderBy('date')    
                );
                break;
            
            case 4: // trending
                    $news->orderBy('trending_score', 'desc');
                    break;

            default:
                $news->orderByRaw('ts_rank(search, websearch_to_tsquery(\'english\', ?)) DESC', [$search]);
                break;
        };
        return $news->get();
    }

    /**
     * Get news from users that are not banned or deleted
     *
     * @return Collection
     */
    public static function getNews()
    {
        return News::whereIn('content_id', function($query){
            $query->select('id')
                ->from('content')
                ->whereIn('author_id', function ($query) {
                    $query->select('id')
                        ->from('users')
                        ->where('is_banned', false)
                        ->where('is_deleted', false);
                });
        })->get();
    }
}

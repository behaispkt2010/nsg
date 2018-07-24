<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Article
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $category
 * @property string $content
 * @property string $description
 * @property string $image
 * @property int $auth
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $author
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereAuth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $author_id
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereAuthorId($value)
 */
class Article extends Model
{
    protected $fillable = ['title','title_seo', 'slug', 'category','content','description','image','author_id','status', 'deleted'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Returns a formatted post content entry,
     * this ensures that line breaks are returned.
     *
     * @return string
     */
    public function content()
    {
        return nl2br($this->content);
    }
    /**
     * Returns a formatted post content entry,
     * this ensures that line breaks are returned.
     *
     * @return string
     */
    public function introduction()
    {
        return nl2br($this->description);
    }
    public static function getNewArticle(){
        $article = Article::orderBy('id', "DESC")->where('deleted', 0)->take(3)->get();
        return $article;

    }
    public static function getBestViewProduct($limit = 0){
        if($limit == 0) {
            $getBestViewProduct = View::leftJoin('articles', 'articles.id', '=', 'views.blog_id')
                ->groupBy('views.blog_id')
                ->where('deleted', 0)
                ->get();
        }
        else{
            $getBestViewProduct = View::leftJoin('articles', 'articles.id', '=', 'views.blog_id')
                ->groupBy('views.blog_id')
                ->where('deleted', 0)
                ->take($limit)
                ->get();
        }
        return $getBestViewProduct;
    }
    public static function getRelatedArticle($id, $limit){

        $getCategory = Article::find($id);
        if($limit == 0) {
            $getRelated = Article::where('category', $getCategory->category)
                ->whereNotIn('id', [$id])
                ->where('deleted', 0)
                ->inRandomOrder()
                ->get();
        }
        else{
            $getRelated = Article::where('category', $getCategory->category)
                ->whereNotIn('id', [$id])
                ->where('deleted', 0)
                ->inRandomOrder()
                ->take($limit)
                ->get();
        }
        return $getRelated;
    }

}

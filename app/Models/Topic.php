<?php

namespace App\Models;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;
    /**
     *字段的可见性
     *
     * @var array
     */
    protected $fillable = ['title', 'body',  "category_id",  "slug", "excerpt"];
    /**
     * 关联用户,一对一
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * 关联帖子类型,一对一
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * 排序方式
     *
     * @param Model $query
     * @param string $order
     * @return void
     */
    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
    }
    /**
     * 更新时间倒序
     *
     * @param Model $query
     * @return Model
     */
    public function scopeRecentReplied($query)
    {

        return $query->orderBy("updated_at", 'desc');
    }
    /**
     * 创建时间倒序
     *
     * @param Model $query
     * @return Model
     */
    public function scopeRecent($query)
    {
        return $query->orderBy("created_at", "desc");
    }
    /**
     * 生成链接
     *
     * @param array $params
     * @return string
     */
    public function link(array $params = []): string
    {
        return route("topics.show", array_merge([$this->id, $this->slug], $params));
    }
    /**
     * 帖子的所有评论
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }
}

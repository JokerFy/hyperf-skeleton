<?php

declare (strict_types=1);
namespace App\Model\Chat;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $userid 
 * @property int $cmd 
 * @property int $dstid 
 * @property int $media 
 * @property string $content 
 * @property string $pic 
 * @property string $url 
 * @property string $memo 
 * @property int $amount 
 */
class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message';
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'chat';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'userid' => 'integer', 'cmd' => 'integer', 'dstid' => 'integer', 'media' => 'integer', 'amount' => 'integer'];
}
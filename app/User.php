<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/14 0014
 * Time: 上午 8:40
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
	//确认哪个表
	protected $table = 'hongri_users';

	//声明主键id
	protected $primaryKey = 'uid';

	//禁止记录时间
	public $timestamps = false;

	//那些字段的数据可以多条一起更新
	//    protected $fillable = ['money','age','mobile'];
}
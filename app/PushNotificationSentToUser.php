<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotificationSentToUser extends Model
{
    protected $table = 'push_notifications_sent_to_users';

	protected $fillable = [
		'user_id', 'title', 'body', 'data',
	];

	protected $casts = [
		'data' => 'array',
	];

	public function user()
	{
		return $this->belongsTo(\App\User::class);
	}

}

<?php

namespace App\Validation;

use App\Models\ApplicationModel;

class UserRules
{
	public function validateUser(string $str, string $feilds, array $data)
	{

		$model = new ApplicationModel('admin_info', 'user_id');
		$user = $model->where(['user_mobile' => $data['mobile'], 'user_status' => 1, 'user_deleted_status' => 0])->first();
		if ($user) {
			return password_verify($data['password'], $user['user_password']);
		}
		return false;
	}
}

<?php
namespace KraftHaus\BauhausUser;

class DefaultPermissionsTableSeeder extends \Seeder {

	public function run()
	{
		$defaultPermissions = [
			'FeedCategory',
			'FeedItem',
			'KraftHaus-BauhausUser-User',
			'KraftHaus-BauhausUser-Group'
		];

		$adminPermissions = [];

		foreach ($defaultPermissions as $p) {
			PermissionRegister::create(['name'=>$p]);
			$adminPermissions[$p] = 1;
		}

		$adminGroup = \Sentry::findGroupById(1);
		$adminGroup->permissions = $adminPermissions;
		$adminGroup->save();

	}

}

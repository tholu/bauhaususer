<?php
namespace KraftHaus\BauhausUser;

class SentryDefaultGroupsTableSeeder extends \Seeder {

	public function run()
	{
		\Sentry::createGroup([
			'name'=>'Administrator'
		]);

		\Sentry::createGroup([
			'name'=>'Moderator'
		]);

		\Sentry::createGroup([
			'name'=>'Contributor'
		]);

		\Sentry::createGroup([
			'name'=>'User'
		]);
	}

}

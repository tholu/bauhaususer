<?php

namespace KraftHaus\BauhausUser;

/**
 * This file is part of the KraftHaus BauhausUser package.
 *
 * (c) KraftHaus <hello@krafthaus.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserExistsException;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class RegisterCommand
 * @package KraftHaus\BauhausUser
 */
class GrantCommand extends Command
{

	/**
	 * The console command name.
	 * @var string
	 */
	protected $name = 'bauhaus:user:grant';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'grant admin permissions to a module';

	/**
	 * @var string
	 */
	private $permissionStoragePath;


	function __construct() {
		parent::__construct();


		$this->permissionStoragePath = app_path('permissionStorage.json');
	}

	/**
	 * Execute the console command.
	 *
	 * @access public
	 * @return mixed
	 */
	public function fire()
	{



		$model = $this->argument('moduleName');


		if ($model != '') {
			$model = $this->argument('moduleName');

			$this->grantPermission($model);
			$this->storePermission($model);

		} else {
			$permissions = $this->getStoredPermissions();

			foreach ($permissions AS $model) {
				$this->grantPermission($model);
			}

		}

	}

	private function storePermission($model = '') {
		$storage = [];

		try {

			$contents = \File::get($this->permissionStoragePath);
			$storage = json_decode($contents);

		} catch (\Illuminate\Filesystem\FileNotFoundException $exception) {
			$this->info('The persmissions storage file doesn\'t exist at ' . $this->permissionStoragePath);
		}

		if (!in_array($model,$storage)) {
			$storage[] = $model;
		}

		$bytes_written = \File::put($this->permissionStoragePath, json_encode($storage));

		if ($bytes_written === false)
		{
			$this->info('Failed to create permission storage file at ' . $this->permissionStoragePath);
		} else {
			$this->info('Permissions for ' . $model . ' stored at ' . $this->permissionStoragePath);
		}

	}

	private function getStoredPermissions() {

		$storage = [];

		try {

			$contents = \File::get($this->permissionStoragePath);
			$storage = json_decode($contents);

		} catch (\Illuminate\Filesystem\FileNotFoundException $exception) {
			$this->info('The persmissions storage file doesn\'t exist at ' . $this->permissionStoragePath . '. Nothing to process.');
		}

		return $storage;

	}

	private function grantPermission($model = '') {
		\Eloquent::unguard();

		PermissionRegister::firstOrCreate([
			'name'=>$model
		]);

		$this->info('Permission created: ' . $model);

		/*
		 * Update the admin group with the new permission
		 */
		$adminGroup = \Sentry::findGroupById(1);

		$permissions = $adminGroup->getPermissions();
		$permissions[$model] = 1;

		$adminGroup->permissions = $permissions;
		$adminGroup->save();

		$this->info('General permission assigned to group: ' . $adminGroup->getName());
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			['moduleName',      InputArgument::OPTIONAL, 'Module Name']
		);
	}

}

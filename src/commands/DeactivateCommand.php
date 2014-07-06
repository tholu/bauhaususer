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

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class DeactivateCommand
 * @package KraftHaus\BauhausUser
 */
class DeactivateCommand extends Command
{

	/**
	 * The console command name.
	 * @var string
	 */
	protected $name = 'bauhaus:user:deactivate';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'deactivate a specific user by id';

	/**
	 * Execute the console command.
	 *
	 * @access public
	 * @return mixed
	 */
	public function fire()
	{
		$user = $this->argument('user');
		$user = User::find($user);
		$user->update(['is_active' => '0']);

		// print_r($user);

		$this->info('User deactivated with success');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			['user', InputArgument::REQUIRED, 'User id']
		);
	}

}
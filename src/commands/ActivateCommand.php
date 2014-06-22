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
 * Class ActivateCommand
 * @package KraftHaus\BauhausUser
 */
class ActivateCommand extends Command
{

	/**
	 * The console command name.
	 * @var string
	 */
	protected $name = 'bauhaus:user:activate';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = '';

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
		$user->update(['is_active' => '1']);

		// print_r($user);

		$this->info('User activated with success');
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
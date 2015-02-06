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
class RegisterCommand extends Command
{

	/**
	 * The console command name.
	 * @var string
	 */
	protected $name = 'bauhaus:user:register';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'register a new user';

	/**
	 * Execute the console command.
	 *
	 * @access public
	 * @return mixed
	 */
	public function fire()
	{

		try
		{
			$user = \Sentry::createUser([
				'email' 		=> $this->argument('email'),
				'password' 		=> $this->argument('password'),
				'first_name'	=> $this->argument('first_name'),
				'last_name' 	=> $this->argument('last_name'),
				'activated' 	=> true
			]);

			$this->info('User created with success');

			$group = \Sentry::findGroupById(1);

			$user->addGroup($group);

			$this->info('User assignet to group: ' . $group->getName());
		}
		catch (LoginRequiredException $e)
		{
			$this->info('Login field is required.');
		}
		catch (PasswordRequiredException $e)
		{
			$this->info('Password field is required.');
}
		catch (UserExistsException $e)
		{
			$this->info('User with this login already exists.');
		}

		catch (GroupNotFoundException $e)
		{
			$this->info('Group was not found.');
		}

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			['email',      InputArgument::REQUIRED, 'User email'],
			['password',   InputArgument::REQUIRED, 'User password'],
			['first_name', InputArgument::OPTIONAL, 'User first name'],
			['last_name',  InputArgument::OPTIONAL, 'User last name']
		);
	}

}

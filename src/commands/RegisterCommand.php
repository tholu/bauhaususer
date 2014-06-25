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
	protected $description = '';

	/**
	 * Execute the console command.
	 *
	 * @access public
	 * @return mixed
	 */
	public function fire()
	{
		$email     = $this->argument('email');
		$password  = Hash::make($this->argument('password'));
		$firstname = $this->argument('first_name');
		$lastname  = $this->argument('last_name');

		User::create([
			'email'      => $email,
			'password'   => $password,
			'first_name' => $firstname,
			'last_name'  => $lastname,
			'is_active'  => 1
		]);

		$this->info('User created with success');
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
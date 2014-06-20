<?php

namespace KraftHaus\BauhausUser;

use Illuminate\Support\Facades\Hash;
use KraftHaus\Bauhaus\Admin;

class UserAdmin extends Admin
{

	protected $singularName = 'user';
	protected $pluralName = 'users';

	/**
	 * Configure the UserAdmin list.
	 *
	 * @param \KraftHaus\Bauhaus\Mapper\ListMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureList($mapper)
	{
		$mapper->identifier('full_name')->label('Name');
		$mapper->string('email');
	}

	public function configureForm($mapper)
	{
		$mapper->tab('General', function ($mapper) {
			$mapper->text('email');
			$mapper->password('password');
			$mapper->password('password_confirmation')->label('Confirm Password');
		});

		$mapper->tab('Info', function ($mapper) {
			$mapper->text('first_name')->label('First name');
			$mapper->text('last_name')->label('Last name');
		});
	}

	public function configureFilters($mapper)
	{
		$mapper->text('email')->label('Email');
	}

	public function create($input)
	{
		if ($input['password'] == '') {
			unset($input['password']);
		} else {
			$input['password'] = Hash::make($input['password']);
		}

		User::create($input);
	}

	public function update($input)
	{
		$user = User::find($input['user_id']);

		if ($input['password'] == '') {
			unset($input['password']);
		} else {
			$input['password'] = Hash::make($input['password']);
		}

		$user->update($input);
	}

}
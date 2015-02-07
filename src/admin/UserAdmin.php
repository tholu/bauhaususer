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

use Illuminate\Support\Facades\Hash;
use KraftHaus\Bauhaus\Admin;
use KraftHaus\Bauhaus\Mapper\FilterMapper;
use KraftHaus\Bauhaus\Mapper\ListMapper;
use KraftHaus\Bauhaus\Mapper\FormMapper;
use KraftHaus\Bauhaus\Mapper\ScopeMapper;
use Cartalyst\Sentry\Users;
use Cartalyst\Sentry\Groups;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use TijsVerkoyen\CssToInlineStyles\Exception;

/**
 * Class UserAdmin
 * @package KraftHaus\BauhausUser
 */
class UserAdmin extends Admin
{

	/**
	 * Public constructor override to set translatable names (singular, plural).
	 *
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();

		$this->setSingularName(trans('bauhaususer::admin.users.title.singular'));
		$this->setPluralName(trans('bauhaususer::admin.users.title.plural'));
	}

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
		$mapper->identifier('full_name')
			->label(trans('bauhaususer::admin.users.list.name'));

		$mapper->string('email')
			->label(trans('bauhaususer::admin.users.list.email'));

		/*
		$mapper->belongsToMany('groups')
			->display('name')
			->label(trans('bauhaususer::admin.users.list.groups'));
		*/
	}

	/**
	 * Configure the UserAdmin form.
	 *
	 * @param  \KraftHaus\Bauhaus\Mapper\FormMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureForm($mapper)
	{
		$mapper->tab(trans('bauhaususer::admin.users.form.tabs.general'), function ($mapper) {
			$mapper->text('email')
				->label(trans('bauhaususer::admin.users.form.email.label'))
				->placeholder(trans('bauhaususer::admin.users.form.email.placeholder'));

			$mapper->password('password')
				->label(trans('bauhaususer::admin.users.form.password.label'))
				->placeholder(trans('bauhaususer::admin.users.form.password.placeholder'));

			$mapper->password('password_confirmation')
				->label(trans('bauhaususer::admin.users.form.password-confirm.label'))
				->placeholder(trans('bauhaususer::admin.users.form.password-confirm.placeholder'));

			$mapper->belongsToMany('groups')
				->display('name')
				->placeholder(trans('bauhaususer::admin.users.form.groups.label'));
		});

		$mapper->tab(trans('bauhaususer::admin.users.form.tabs.info'), function ($mapper) {
			$mapper->text('first_name')
				->label(trans('bauhaususer::admin.users.form.first-name.label'))
				->placeholder(trans('bauhaususer::admin.users.form.first-name.placeholder'));

			$mapper->text('last_name')
				->label(trans('bauhaususer::admin.users.form.last-name.label'))
				->placeholder(trans('bauhaususer::admin.users.form.last-name.placeholder'));

		});
		
	}

	/**
	 * Configure the UserAdmin filters.
	 * @param  \KraftHaus\Bauhaus\Mapper\FilterMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureFilters($mapper)
	{
		$mapper->text('email')
			->label(trans('bauhaususer::admin.users.filter.email'));
		
		$mapper->text('last_name')
			->label(trans('bauhaususer::admin.users.filter.last_name'));
		
		$mapper->text('first_name')
			->label(trans('bauhaususer::admin.users.filter.first_name'));
	}

	/**
	 * Scoping on active state.
	 *
	 * @param  \KraftHaus\Bauhaus\Mapper\ScopeMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureScopes($mapper)
	{
		$mapper->scope('active')
			->label(trans('bauhaususer::admin.users.scope.active-users'));
	}

	/**
	 * Create hook.
	 *
	 * @param  array $input
	 *
	 * @access public
	 * @return static
	 */
	public function create($input)
	{
		try {
			// Create the user
			$user = \Sentry::createUser(array(
				'email'      => $input['email'],
				'password'   => $input['password'],
				'first_name' => $input['first_name'],
				'last_name'  => $input['last_name'],
				'activated'  => true,
			));

			return $user;
		} catch (Users\LoginRequiredException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.login-required'));
		} catch (Users\PasswordRequiredException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.password-required'));
		} catch (Users\UserExistsException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.user.already-exists'));
		} catch (Groups\GroupNotFoundException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.groups.not-found'));
		}


		return Redirect::refresh();
	}

	/**
	 * Update hook.
	 *
	 * @param  array $input
	 *
	 * @return bool
	 */
	public function update($input)
	{
		try {
			$user = \Sentry::findUserById($input['user_id']);

			/* update password only if the password fields are set */
			if ($input['password'] != '' && $input['password_confirmation'] != '') {
				if ($input['password'] != $input['password_confirmation']) {
					Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.no-pwd-match'));

					return Redirect::refresh();
				}

				if ($user->checkPassword($input['password'])) {
					Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.no-pwd-change'));

					return Redirect::refresh();
				}

				$user->password = $input['password'];
				
			}
			
			$user->email = $input['email'];
			$user->first_name = $input['first_name'];
			$user->last_name = $input['last_name'];
			
			if (isset($input['groups']) && is_array($input['groups']) && count($input['groups']) > 0) {

				/* Remove all groups associated to user */
				$allGroups = \Sentry::findAllGroups();

				foreach ($allGroups AS $grp) {
					$user->removeGroup($grp);

				}

				/* Add groups based on the groups input field */
				foreach ($input['groups'] as $grp) {
					$group = \Sentry::findGroupById($grp);

					$user->addGroup($group);
				}
			}


			return $user->save();

		} catch (Users\LoginRequiredException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.login-required'));
		} catch (Users\PasswordRequiredException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.password-required'));
		} catch (Users\UserExistsException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.user.already-exists'));
		} catch (Groups\GroupNotFoundException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.groups.not-found'));
		}


		return Redirect::refresh();
		

		
	}

}

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

use KraftHaus\Bauhaus\Admin;
use Cartalyst\Sentry\Groups;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/**
 * Class GroupAdmin
 * @package KraftHaus\BauhausUser
 */
class GroupAdmin extends Admin
{

	/**
	 * Public constructor override to set translatable names (singular, plural).
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->setSingularName(trans('bauhaususer::admin.groups.title.singular'));
		$this->setPluralName(trans('bauhaususer::admin.groups.title.plural'));
	}

	/**
	 * Configure the GroupAdmin list.
	 *
	 * @param \KraftHaus\Bauhaus\Mapper\ListMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureList($mapper)
	{
		$mapper->identifier('name')
			->label(trans('bauhaususer::admin.groups.list.name'));

	}

	/**
	 * Configure the GroupAdmin form.
	 *
	 * @param  \KraftHaus\Bauhaus\Mapper\FormMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureForm($mapper)
	{
		$mapper->tab(trans('bauhaususer::admin.users.form.tabs.general'), function ($mapper) {

			$mapper->text('name')
				->label(trans('bauhaususer::admin.groups.form.name.label'))
				->placeholder(trans('bauhaususer::admin.groups.form.name.placeholder'));
		});

		$mapper->tab(trans('bauhaususer::admin.users.form.tabs.permissions'), function ($mapper) {
			$mapper->permissions('none')->label('');

		});
	}


	/**
	 * @param $input
	 * @return Groups\GroupInterface
	 */
	public function create($input)
	{

		try {
			// Create the group
			return \Sentry::createGroup([
				'name' => $input['name']
			]);

		} catch (Groups\NameRequiredException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.groups.missing-name'));
		} catch (Groups\GroupExistsException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.groups.group-exists'));
		}

		return Redirect::refresh();
	}

	/**
	 * @param $input
	 * @return bool
	 */
	public function update($input)
	{

		try {
			$group = \Sentry::findGroupById($input['group_id']);
			$group->name = $input['name'];

			$permissions = [];

			if (isset($input['permissions']) && is_array($input['permissions'])) {
				foreach ($input['permissions'] AS $p) {
					$permissions[$p] = 1;

				}

			}

			$group->permissions = $permissions;
			
			return $group->save();

		} catch (Groups\NameRequiredException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.groups.missing-name'));
		} catch (Groups\GroupExistsException $e) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.groups.group-exists'));
		}

		return Redirect::refresh();

	}

}

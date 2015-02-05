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

		/*
		$mapper->belongsToMany('permissions')
			->display('name')
			->label(trans('bauhaususer::admin.groups.list.permissions'));
		*/
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
		$mapper->text('name')
			->label(trans('bauhaususer::admin.groups.form.name.label'))
			->placeholder(trans('bauhaususer::admin.groups.form.name.placeholder'));

		/*
		$mapper->belongsToMany('permissions')
			->display('name')
			->label(trans('bauhaususer::admin.groups.form.permissions.label'));
		*/
	}

	
	public function create($input) {

		try
		{
			// Create the group
			return \Sentry::createGroup([
				'name'=>$input['name']
			]);

		}
		catch (Groups\NameRequiredException $e)
		{
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.groups.missing-name'));
		}
		catch (Groups\GroupExistsException $e)
		{
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.groups.group-exists'));
		}
		
		return Redirect::refresh();
	}

}

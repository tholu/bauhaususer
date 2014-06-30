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

/**
 * Class PermissionAdmin
 * @package KraftHaus\BauhausUser
 */
class PermissionAdmin extends Admin
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

		$this->setSingularName(trans('bauhaususer::admin.permissions.title.singular'));
		$this->setPluralName(trans('bauhaususer::admin.permissions.title.plural'));
	}

	/**
	 * Configure the PermissionAdmin list.
	 *
	 * @param \KraftHaus\Bauhaus\Mapper\ListMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureList($mapper)
	{
		$mapper->identifier('name')
			->label(trans('bauhaususer::admin.permissions.list.name'));

		$mapper->string('value')
			->label(trans('bauhaususer::admin.permissions.list.value'));

		$mapper->string('description')
			->label(trans('bauhaususer::admin.permissions.list.description'));
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
		$mapper->text('name')
			->label(trans('bauhaususer::admin.permissions.form.name.label'))
			->placeholder(trans('bauhaususer::admin.permissions.form.name.placeholder'));

		$mapper->text('value')
			->label(trans('bauhaususer::admin.permissions.form.value.label'))
			->placeholder(trans('bauhaususer::admin.permissions.form.value.placeholder'));

		$mapper->textarea('description')
			->label(trans('bauhaususer::admin.permissions.form.description.label'))
			->placeholder(trans('bauhaususer::admin.permissions.form.description.placeholder'));
	}

	/**
	 * Configure the PermissionAdmin filters.
	 * @param  \KraftHaus\Bauhaus\Mapper\FilterMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureFilters($mapper)
	{
		$mapper->text('name')
			->label(trans('bauhaususer::admin.permissions.filter.name'));

		$mapper->text('value')
			->label(trans('bauhaususer::admin.permissions.filter.value'));

		$mapper->text('description')
			->label(trans('bauhaususer::admin.permissions.filter.description'));
	}

}
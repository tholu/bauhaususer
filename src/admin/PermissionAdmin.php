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
	 * Override the singular name.
	 * @var string
	 */
	protected $singularName = 'permission';

	/**
	 * Override the plural name.
	 * @var string
	 */
	protected $pluralName = 'permissions';

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
		$mapper->identifier('name');
		$mapper->string('value');
		$mapper->string('description');
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
		$mapper->text('name')->label('Name')->placeholder('The permission name');
		$mapper->text('value')->placeholder('The permission value');
		$mapper->textarea('description')->placeholder('The permission description');
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
		$mapper->text('name');
		$mapper->text('value');
		$mapper->text('description');
	}

}
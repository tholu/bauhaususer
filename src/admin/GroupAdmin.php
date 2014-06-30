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
 * Class GroupAdmin
 * @package KraftHaus\BauhausUser
 */
class GroupAdmin extends Admin
{

	/**
	 * Override the singular name.
	 * @var string
	 */
	protected $singularName = 'group';

	/**
	 * Override the plural name.
	 * @var string
	 */
	protected $pluralName = 'groups';

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
		$mapper->identifier('name');
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
		$mapper->text('name')->label('Name');
	}

}
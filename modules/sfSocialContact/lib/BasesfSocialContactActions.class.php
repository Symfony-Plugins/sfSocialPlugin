<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <lionel.guichard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Lionel Guichard <lionel.guichard@gmail.com>
 */
class BasesfSocialContactActions extends sfActions
{
	public function executeIndex($request)
	{
		$this->getUser()->signIn('john');
	}
}
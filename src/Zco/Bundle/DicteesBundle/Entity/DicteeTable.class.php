<?php

/**
 * zCorrecteurs.fr est le logiciel qui fait fonctionner www.zcorrecteurs.fr
 *
 * Copyright (C) 2012-2020 Corrigraphie
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use Zco\Bundle\Doctrine1Bundle\Model\NamedDoctrineTableInterface;

/**
 */
class DicteeTable extends Doctrine_Table implements NamedDoctrineTableInterface
{
	/**
	 * Liste simplement les dictées avec leur id et leur titre
	 * pour le sitemap.
	 *
	 * @return array
	 */
	public function getAllId()
	{
	    return $this->createQuery()
	        ->select('id, titre')
	        ->where('etat = ?', DICTEE_VALIDEE)
	        ->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
	}
	
	public function getName()
	{
		return 'Dictée';
	}
}

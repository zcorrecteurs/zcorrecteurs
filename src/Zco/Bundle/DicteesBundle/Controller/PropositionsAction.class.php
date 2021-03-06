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

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Zco\Bundle\DicteesBundle\Controller\BaseController;

/**
 * Dictées proposées.
 *
 * @author mwsaz
 */
class PropositionsAction extends BaseController
{
	public function execute()
	{
        if (!verifier('dictees_publier')) {
            throw new AccessDeniedHttpException();
        }
		Page::$titre = 'Dictées proposées';
		fil_ariane('Liste des dictées proposées');

		return render_to_response(array(
			'Dictees' => DicteesProposees()
		));
	}
}

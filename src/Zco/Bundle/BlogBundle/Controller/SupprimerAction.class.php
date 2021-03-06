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

use Symfony\Component\HttpFoundation\Response;
use Zco\Bundle\BlogBundle\Controller\BaseController;

/**
 * Contôleur gérant la suppression d'un billet.
 *
 * @author vincent1870 <vincent@zcorrecteurs.fr>
 */
class SupprimerAction extends BaseController
{
	public function execute()
	{
		zCorrecteurs::VerifierFormatageUrl(null, true);

		if(!empty($_GET['id']) && is_numeric($_GET['id']))
		{
			$ret = $this->initBillet();
			if ($ret instanceof Response)
				return $ret;
			Page::$titre .= ' - Supprimer le billet';

			if($this->verifier_supprimer)
			{
				//Si on veut bien le supprimer
				if(isset($_POST['confirmer']))
				{
					SupprimerBillet($_GET['id']);

					if($this->autorise == true)
						return redirect(9, 'mes-billets.html');
					else
						return redirect(9, 'gestion.html');
				}

				//Si on annule
				elseif(isset($_POST['annuler']))
				{
					if($this->autorise == true)
						return new Symfony\Component\HttpFoundation\RedirectResponse('mes-billets.html');
					else
						return new Symfony\Component\HttpFoundation\RedirectResponse('gestion.html');
				}

				//Inclusion de la vue
				fil_ariane($this->InfosBillet['cat_id'], array(
					htmlspecialchars($this->InfosBillet['version_titre']) => 'admin-billet-'.$_GET['id'].'-'.rewrite($this->InfosBillet['version_titre']).'.html',
					'Supprimer le billet'));
				return render_to_response(array('InfosBillet' => $this->InfosBillet));
			}
			else
				throw new Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

		}
		else
			return redirect(20, 'index.html', MSG_ERROR);
	}
}

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
 * Contrôleur gérant la dévalidation d'un billet.
 *
 * @author vincent1870 <vincent@zcorrecteurs.fr>
 */
class DevaliderAction extends BaseController
{
	public function execute()
	{
		zCorrecteurs::VerifierFormatageUrl(null, true);

		if(!empty($_GET['id']) && is_numeric($_GET['id']))
		{
			//On récupère des infos sur le billet
			$ret = $this->initBillet();
			if ($ret instanceof Response)
				return $ret;
			Page::$titre .= ' - Dévalider le billet';

			if(verifier('blog_devalider', $this->InfosBillet['blog_id_categorie']) && $this->InfosBillet['blog_etat'] == BLOG_VALIDE)
			{
				//Si on veut bien dévalider
				if(isset($_POST['confirmer']))
				{
					EditerBillet($_GET['id'], array('etat' => BLOG_BROUILLON));
					return redirect(7, 'brouillons.html');
				}
				//Si on annule
				elseif(isset($_POST['annuler']))
				{
					return new Symfony\Component\HttpFoundation\RedirectResponse('gestion.html');
				}

				//Inclusion de la vue
				fil_ariane($this->InfosBillet['cat_id'], array(
					htmlspecialchars($this->InfosBillet['version_titre']) => 'billet-'.$_GET['id'].'-'.rewrite($this->InfosBillet['version_titre']).'.html',
					'Dévalider le billet'
				));
				
				return render_to_response($this->getVars());
			}
			else
			{
				throw new Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
			}
		}
		else
		{
			return redirect(20, '/blog/', MSG_ERROR);
		}
	}
}

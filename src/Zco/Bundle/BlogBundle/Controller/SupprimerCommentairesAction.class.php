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
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Zco\Bundle\BlogBundle\Controller\BaseController;

/**
 * Contrôleur gérant la suppression de tous les commentaires d'un billet.
 *
 * @author vincent1870 <vincent@zcorrecteurs.fr>
 */
class SupprimerCommentairesAction extends BaseController
{
	public function execute()
	{
        if (!verifier('blog_supprimer_commentaires')) {
            throw new AccessDeniedHttpException();
        }

		//Si on a bien demandé à voir un billet
		if(!empty($_GET['id']) && is_numeric($_GET['id']))
		{
			$ret = $this->initBillet();
			if ($ret instanceof Response)
				return $ret;
			Page::$titre .= ' - Supprimer tous les commentaires';

			//Si on veut le supprimer
			if(isset($_POST['confirmer']))
			{
				SupprimerCommentairesBillet($_GET['id']);
				return redirect(208, 'billet-'.$this->InfosBillet['blog_id'].'-'.rewrite($this->InfosBillet['version_titre']).'.html');
			}
			//Si on annule
			elseif(isset($_POST['annuler']))
			{
				return new Symfony\Component\HttpFoundation\RedirectResponse('billet-'.$this->InfosBillet['blog_id'].'-'.rewrite($this->InfosBillet['version_titre']).'.html');
			}

			//Inclusion de la vue
			fil_ariane($this->InfosBillet['cat_id'], array(
				htmlspecialchars($this->InfosBillet['version_titre']) => 'billet-'.$_GET['id'].'-'.rewrite($this->InfosBillet['version_titre']).'.html',
				'Supprimer tous les commentaires'
			));
			return render_to_response(array('InfosBillet' => $this->InfosBillet));
		}
		else
			return redirect(20, 'index.html', MSG_ERROR);
	}
}

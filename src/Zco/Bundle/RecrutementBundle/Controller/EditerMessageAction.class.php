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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Contrôleur gérant la modification d'un message dans la shoutbox des
 * administrateurs.
 *
 * @author mwsaz <mwsaz@zcorrecteurs.fr>
 */
class EditerMessageAction extends Controller
{
	public function execute()
	{
        if (!verifier('recrutements_editer_shoutbox')) {
            throw new AccessDeniedHttpException();
        }

		if(!empty($_GET['id']) && is_numeric($_GET['id']))
		{
			include(dirname(__FILE__).'/../modeles/commentaires.php');

			$InfosCommentaire = InfosCommentaire($_GET['id']);
			if(empty($InfosCommentaire))
				return redirect(350, '/recrutement/', MSG_ERROR);

			if(!($InfosCommentaire['recrutement_etat'] != RECRUTEMENT_FINI &&
			     verifier('recrutements_voir_shoutbox')) &&
			   !($InfosCommentaire['recrutement_etat'] == RECRUTEMENT_FINI &&
			     verifier('recrutements_termines_voir_shoutbox')))
				throw new Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


			zCorrecteurs::VerifierFormatageUrl($InfosCommentaire['utilisateur_pseudo'], true);

			if(isset($_POST['submit'], $_POST['texte']))
			{
				$_POST['texte'] = trim($_POST['texte']);
				if(empty($_POST['texte']))
					return redirect(17, 'editer-message-'.$_GET['id'].'.html', MSG_ERROR);

				EditerCommentaireShoutbox($_GET['id'], $_POST['texte']);
				return redirect(352, 'candidature-'.$InfosCommentaire['candidature_id'].'.html#shoutbox');
			}

			fil_ariane(array(
				htmlspecialchars($InfosCommentaire['recrutement_nom']) => 'recrutement-'.$InfosCommentaire['recrutement_id'].'.html',
				'Candidature de '.htmlspecialchars($InfosCommentaire['postulant_pseudo']) => 'candidature-'.$InfosCommentaire['candidature_id'].'.html',
				'Modifier un commentaire'
			));
			
			return render_to_response(array(
				'InfosCommentaire' => $InfosCommentaire,
			));
		}
		else
			return redirect(349, '/recrutement/', MSG_ERROR);
	}
}

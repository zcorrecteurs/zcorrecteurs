<?php

/**
 * zCorrecteurs.fr est le logiciel qui fait fonctionner www.zcorrecteurs.fr
 *
 * Copyright (C) 2012-2018 Corrigraphie
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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Contrôleur gérant l'ajout des droits de maître à un participant.
 *
 * @author DJ Fox <djfox@zcorrecteurs.fr>
 */
class StatutMasterAction extends Controller
{
    public function execute()
    {
        if (!verifier('connecte')) {
            throw new AccessDeniedHttpException();
        }
        include(BASEPATH . '/src/Zco/Bundle/MpBundle/modeles/lire.php');
        include(BASEPATH . '/src/Zco/Bundle/MpBundle/modeles/participants.php');
        if (!empty($_GET['id']) AND is_numeric($_GET['id']) AND !empty($_GET['id2']) AND is_numeric($_GET['id2'])) {
            $InfoMP = InfoMP();

            if (isset($InfoMP['mp_id']) AND !empty($InfoMP['mp_id'])) {
                //Vérification : le participant à "mastoriser" existe-t-il ?
                $InfoParticipant = InfoParticipant();
                if (empty($InfoParticipant['mp_participant_id']) OR $InfoParticipant['mp_participant_statut'] == MP_STATUT_SUPPRIME) {
                    return redirect(
                        'Le participant n\'existe pas, il ne participe pas à ce MP ou il a été supprimé.',
                        'lire-' . $_GET['id'] . '.html',
                        MSG_ERROR
                    );
                }
                //Vérification : a-t-on le droit de rendre ce participant maître de conversation ?
                if (($InfoMP['mp_participant_statut'] == MP_STATUT_OWNER OR verifier('mp_tous_droits_participants')) AND $InfoParticipant['mp_participant_statut'] == MP_STATUT_NORMAL) {
                    MaitreConversation();
                    return redirect(
                        'Le participant est maintenant maître de conversation.',
                        'lire-' . $_GET['id'] . '.html'
                    );
                } else {
                    throw new AccessDeniedHttpException();
                }
            } else {
                throw new AccessDeniedHttpException();
            }
        } else {
            throw new NotFoundHttpException();
        }
    }
}

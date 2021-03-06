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

namespace Zco\Bundle\GroupesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Contrôleur gérant les actions sur les groupes et les droits.
 *
 * @author vincent1870 <vincent@zcorrecteurs.fr>
 */
class DefaultController extends Controller
{
    /**
     * Constructeur.
     */
    public function __construct()
    {
        include_once(__DIR__ . '/../modeles/droits.php');
    }

    /**
     * Affiche la liste des groupes.
     * @author vincent1870 <vincent@zcorrecteurs.fr>
     */
    public function indexAction()
    {
        if (!verifier_array([['groupes_gerer', 'groupes_changer_droits']])) {
            throw new AccessDeniedHttpException();
        }

        fil_ariane('Gestion des groupes');

        return render_to_response(array(
            'ListerGroupes' => ListerGroupes(),
            'ListerGroupesSecondaires' => ListerGroupesSecondaires(),
        ));
    }

    /**
     * Ajoute un nouveau groupe.
     * @author vincent1870 <vincent@zcorrecteurs.fr>
     */
    public function ajouterAction()
    {
        if (!verifier('groupes_gerer')) {
            throw new AccessDeniedHttpException();
        }
        \Page::$titre = 'Ajouter un groupe';

        //Si on veut ajouter un groupe
        if (!empty($_POST['nom'])) {
            AjouterGroupe();
            return redirect(6, 'index.html');
        }

        fil_ariane('Ajouter un groupe');

        return render_to_response(array('ListerGroupes' => ListerGroupes()));
    }

    /**
     * Modifie un groupe.
     * @author vincent1870 <vincent@zcorrecteurs.fr>
     */
    public function editerAction()
    {
        if (!verifier('groupes_gerer')) {
            throw new AccessDeniedHttpException();
        }
        \Page::$titre = 'Modifier un groupe';

        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            //Si on veut éditer un groupe
            if (!empty($_POST['nom'])) {
                EditerGroupe($_GET['id']);
                return redirect(7, 'index.html');
            }

            $InfosGroupe = InfosGroupe($_GET['id']);
            if (empty($InfosGroupe))
                return redirect(2, 'index.html', MSG_ERROR);

            \zCorrecteurs::VerifierFormatageUrl($InfosGroupe['groupe_nom'], true);
            fil_ariane('Modifier un groupe');

            return render_to_response(array('InfosGroupe' => $InfosGroupe));
        } else
            return redirect(167, 'index.html', MSG_ERROR);
    }

    /**
     * Supprime un groupe.
     * @author vincent1870 <vincent@zcorrecteurs.fr>
     */
    public function supprimerAction()
    {
        if (!verifier('groupes_gerer')) {
            throw new AccessDeniedHttpException();
        }
        \Page::$titre = 'Supprimer un groupe';

        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            //Si on veut supprimer le groupe
            if (isset($_POST['confirmer'])) {
                SupprimerGroupe($_GET['id']);
                $this->get('zco_core.cache')->save('dernier_refresh_droits', time(), 0);

                return redirect(8, 'index.html');
            } //Si on annule
            elseif (isset($_POST['annuler'])) {
                return new RedirectResponse('index.html');
            }

            $InfosGroupe = InfosGroupe($_GET['id']);
            if (empty($InfosGroupe))
                return redirect(2, 'index.html', MSG_ERROR);

            \zCorrecteurs::VerifierFormatageUrl($InfosGroupe['groupe_nom'], true);

            fil_ariane('Supprimer un groupe');
            return render_to_response(array('InfosGroupe' => $InfosGroupe));
        } else
            return redirect(2, 'index.html', MSG_ERROR);
    }

    /**
     * Vérifier la liste des droits attribués à un groupe.
     * @author vincent1870 <vincent@zcorrecteurs.fr>
     */
    public function verifierAction()
    {
        if (!verifier_array([['groupes_changer_droits', 'groupes_changer_membre']])) {
            throw new AccessDeniedHttpException();
        }
        \Page::$titre = 'Vérification des droits d\'un groupe';

        $ListerGroupes = ListerGroupes();
        $ListerDroits = ListerDroits();

        if (isset($_POST['id'])) {
            $_GET['id'] = $_POST['id'];
            $_POST = null;
        }

        //Infos sur le groupe si besoin
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $InfosGroupe = InfosGroupe($_GET['id']);
            if (empty($InfosGroupe))
                return redirect(2, 'verifier.html', MSG_ERROR);
            \zCorrecteurs::VerifierFormatageUrl($InfosGroupe['groupe_nom'], true);
        } else
            \zCorrecteurs::VerifierFormatageUrl();

        //Listage des droits
        if (!empty($InfosGroupe))
            $Droits = VerifierDroitsGroupe($_GET['id']);
        else
            $Droits = null;

        //Inclusion de la vue
        fil_ariane('Vérifier les droits d\'un groupe');

        return render_to_response(array(
            'InfosGroupe' => $InfosGroupe,
            'ListerGroupes' => $ListerGroupes,
            'ListerDroits' => $ListerDroits,
            'Droits' => $Droits,
        ));
    }

    /**
     * Change un membre de groupe.
     */
    public function changerMembreGroupeAction()
    {
        if (!verifier('groupes_changer_membre')) {
            throw new AccessDeniedHttpException();
        }
        \Page::$titre = 'Changer un membre de groupe';

        if (!empty($_POST['pseudo'])) {
            $InfosUtilisateur = InfosUtilisateur($_POST['pseudo']);
            unset($_POST['pseudo']);
        } elseif (!empty($_GET['id']))
            $InfosUtilisateur = InfosUtilisateur($_GET['id']);

        if (isset($InfosUtilisateur)) {
            if (empty($InfosUtilisateur))
                return redirect(1, '', MSG_ERROR);

            $_GET['id'] = $InfosUtilisateur['utilisateur_id'];
            \zCorrecteurs::VerifierFormatageUrl($InfosUtilisateur['utilisateur_pseudo'], true);

            if (!isset($_POST['groupe'])) {
                $ListerGroupes = ListerGroupes();
            } elseif (!empty($_POST['groupe']) && is_numeric($_POST['groupe']) && $_POST['groupe'] != GROUPE_VISITEURS) {
                $_POST['id'] = $_GET['id'];
                ChangerGroupeUtilisateur();
                $this->get('zco_core.cache')->save('dernier_refresh_droits', time(), 0);

                return redirect(9, 'changer-membre-groupe-' . $_GET['id'] . '.html');
            } else
                $ListerGroupes = null;

            if (isset($_POST['changement_groupes_secondaires'])) {
                ModifierGroupesSecondairesUtilisateur(
                    $_GET['id'],
                    isset($_POST['groupes_secondaires']) ? $_POST['groupes_secondaires'] : array()
                );
                $this->get('zco_core.cache')->save('dernier_refresh_droits', time(), 0);

                return redirect(9,
                    '/groupes/changer-membre-groupe-'
                    . $InfosUtilisateur['utilisateur_id'] . '-'
                    . rewrite($InfosUtilisateur['utilisateur_pseudo']) . '.html');
            }

            $GroupesSecondaires = ListerGroupesSecondairesUtilisateur($InfosUtilisateur['utilisateur_id']);
            $ListerGroupesSecondaires = ListerGroupesSecondaires();
            $temp = array();
            foreach ($GroupesSecondaires as $groupe) {
                $temp[] = $groupe['groupe_id'];
            }
            $GroupesSecondaires = $temp;
        } else {
            $ListerGroupes = null;
            $InfosUtilisateur = null;
            $GroupesSecondaires = null;
        }

        $pseudo = isset($InfosUtilisateur) ? $InfosUtilisateur['utilisateur_pseudo'] : '';

        //Inclusion de la vue
        fil_ariane('Changer un membre de groupe');

        return render_to_response(array(
            'ListerGroupes' => $ListerGroupes,
            'ListerGroupesSecondaires' => isset($ListerGroupesSecondaires) ? $ListerGroupesSecondaires : null,
            'pseudo' => $pseudo,
            'InfosUtilisateur' => $InfosUtilisateur,
            'GroupesSecondaires' => $GroupesSecondaires,
        ));
    }

    /**
     * Modifie la liste des droits attribués à un groupe.
     * @author vincent1870 <vincent@zcorrecteurs.fr>
     */
    public function droitsAction()
    {
        if (!verifier('groupes_changer_droits')) {
            throw new AccessDeniedHttpException();
        }
        \Page::$titre = 'Changement des droits d\'un groupe';

        $ListerGroupes = array_merge(ListerGroupes(), ListerGroupesSecondaires());
        $ListerDroits = ListerDroits();

        //Infos sur le groupe si besoin
        if ($_GET['id'] != '' && is_numeric($_GET['id'])) {
            $InfosGroupe = InfosGroupe($_GET['id']);
            if (empty($InfosGroupe))
                return redirect(2, 'droits.html', MSG_ERROR);
        } else {
            $InfosGroupe = null;
        }
        //Infos sur le droit si besoin
        if (!empty($_GET['id2']) && is_numeric($_GET['id2'])) {
            $InfosDroit = InfosDroit($_GET['id2']);
            if (empty($InfosDroit))
                return redirect(3, 'droits.html', MSG_ERROR);
        } else {
            $InfosDroit = null;
        }

        //Listage des catégories nécessaires et récupération de la valeur du droit si besoin
        $ValeurNumerique = null;
        if (!empty($InfosDroit) && !empty($InfosGroupe)) {
            if ($InfosDroit['droit_choix_categorie'] == 1) {
                $ListerEnfants = ListerEnfants($InfosDroit, true);
            } else {
                $ListerEnfants = null;
            }

            $ValeurDroit = RecupererValeurDroit($_GET['id2'], $_GET['id']);
            if (!$InfosDroit['droit_choix_categorie'] && !empty($ValeurDroit) && $InfosDroit['droit_choix_binaire'])
                $ValeurDroit = $ValeurDroit[0];
            elseif (!$InfosDroit['droit_choix_categorie'] && !empty($ValeurDroit) && !$InfosDroit['droit_choix_binaire'])
                $ValeurNumerique = $ValeurDroit[0]['gd_valeur'];
            elseif ($InfosDroit['droit_choix_categorie'] && !$InfosDroit['droit_choix_binaire']) {
                foreach ($ValeurDroit as $d) {
                    if ($d['gd_valeur'] != 0)
                        $ValeurNumerique = $d['gd_valeur'];
                }
            } else
                $ValeurNumerique = '';
        } else {
            $ValeurDroit = null;
            $ListerEnfants = null;
            $ValeurNumerique = null;
        }

        //Si on veut modifier
        if (isset($_POST['modifier']) && !empty($InfosDroit) && !empty($InfosGroupe)) {
            //En cas de droit simple (sans sélection de catégorie)
            if (!$InfosDroit['droit_choix_binaire'] && !$InfosDroit['droit_choix_categorie']) {
                EditerDroitGroupe($_GET['id'], $InfosDroit['droit_id_categorie'], $_GET['id2'], (int)$_POST['valeur']);
            } elseif (!$InfosDroit['droit_choix_categorie']) {
                EditerDroitGroupe($_GET['id'], $InfosDroit['droit_id_categorie'], $_GET['id2'], isset($_POST['valeur']) ? 1 : 0);
            } //Sinon droit appliquable par catégorie
            else {
                //Pour éviter des erreurs
                if (empty($_POST['cat']))
                    $_POST['cat'] = array();

                //$done = array();
                foreach ($ListerEnfants as $e) {
                    //Si on doit ajouter le droit
                    if (in_array($e['cat_id'], $_POST['cat'])) {
                        if (!$InfosDroit['droit_choix_binaire'])
                            $valeur = (int)$_POST['valeur'];
                        else
                            $valeur = 1;
                        EditerDroitGroupe($_GET['id'], $e['cat_id'], $_GET['id2'], $valeur);
                    } //Sinon on le retire
                    else {
                        //if(!in_array($e['cat_id'], $done))
                        EditerDroitGroupe($_GET['id'], $e['cat_id'], $_GET['id2'], 0);
                    }
                }
            }

            //Suppression des caches
            $this->get('zco_core.cache')->delete('droits_groupe_' . $_GET['id']);

            return redirect(4, 'droits-' . $_GET['id'] . '-' . $_GET['id2'] . '.html');
        }

        //Inclusion de la vue
        fil_ariane('Changer les droits d\'un groupe');
        $this->get('zco_vitesse.resource_manager')->requireResource(
            '@ZcoCoreBundle/Resources/public/css/zcode.css'
        );

        return render_to_response(array(
            'InfosGroupe' => $InfosGroupe,
            'ListerGroupes' => $ListerGroupes,
            'ListerDroits' => $ListerDroits,
            'InfosDroit' => $InfosDroit,
            'ListerEnfants' => $ListerEnfants,
            'ValeurDroit' => $ValeurDroit,
            'ValeurNumerique' => $ValeurNumerique,
        ));
    }

    /**
     * Action affichant l'historique des changements de groupe.
     * @author Vanger
     */
    public function historiqueGroupesAction()
    {
        if (!verifier('groupes_changer_membre')) {
            throw new AccessDeniedHttpException();
        }
        \Page::$titre = 'Historique des changements de groupe';

        $NombreDeChangements = CompterChangementHistorique();
        $NombreDePages = ceil($NombreDeChangements / 20);
        $_GET['p'] = (!empty($_GET['p']) && is_numeric($_GET['p'])) ? $_GET['p'] : 1;
        $Debut = ($_GET['p'] - 1) * 20;

        $TableauPage = liste_pages($_GET['p'], $NombreDePages, $NombreDeChangements, 20, 'historique-groupes-p%s.html', false);
        $Changements = ListerChangementGroupe($Debut, 20);

        //Inclusion de la vue
        fil_ariane('Historique des changements de groupe');

        return render_to_response(array(
            'NombreDeChangements' => $NombreDeChangements,
            'TableauPage' => $TableauPage,
            'Changements' => $Changements,
        ));
    }
}

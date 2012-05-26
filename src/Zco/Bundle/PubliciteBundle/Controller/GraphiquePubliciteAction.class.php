<?php

/**
 * zCorrecteurs.fr est le logiciel qui fait fonctionner www.zcorrecteurs.fr
 *
 * Copyright (C) 2012 Corrigraphie
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

/**
 * Affiche un graphique montrant les performances d'une publicité
 * sur différents domaines : clics, impressions, CTR, catégories
 * des clics, pays de provenance des clics et âge des cliqueurs.
 *
 * @author vincent1870 <vincent@zcorrecteurs.fr>
 */
class GraphiquePubliciteAction extends PubliciteActions
{
	public function execute()
	{
		include_once(BASEPATH.'/vendor/Artichow/LinePlot.class.php');
		include_once(BASEPATH.'/vendor/Artichow/BarPlot.class.php');
		include_once(BASEPATH.'/vendor/Artichow/Pie.class.php');
		include_once(BASEPATH.'/vendor/Artichow/Graph.class.php');

		$publicite = Doctrine_Core::getTable('Publicite')->find($_GET['id']);
		if ($publicite != false)
		{
			if(
				verifier('publicite_voir') ||
				($publicite->Campagne['utilisateur_id'] == $_SESSION['id'] && verifier('publicite_proposer'))
			)
			{
				$outil = $_GET['type'];
				$response = new Response;
				$response->headers->set('Content-type', 'image/png');

				/**
				 * Clics par catégorie ou pays.
				 */
				if ($outil == 'categorie' || $outil == 'pays')
				{
					$donnees = array();
					if ($outil == 'categorie')
					{
						$rows = Doctrine_Query::create()
							->from('PubliciteClic c')
							->select('COUNT(*) AS nombre, c.categorie_id, cat.cat_id, cat.cat_nom')
							->leftJoin('c.Categorie cat')
							->where('c.publicite_id = ?', $publicite['id'])
							->groupBy('c.categorie_id')
							->execute();
						foreach ($rows as $row)
						{
							$nom = $row->Categorie['nom'] != 'Informations' ? $row->Categorie['nom'] : 'Pages statiques';
							$donnees[$nom] = $row['nombre'];
						}

					}
					elseif ($outil == 'pays')
					{
						$rows = Doctrine_Query::create()
							->from('PubliciteClic c')
							->select('COUNT(*) AS nombre, c.pays')
							->where('c.publicite_id = ?', $publicite['id'])
							->groupBy('c.pays')
							->execute();
						foreach ($rows as $row)
						{
							$nom = !empty($row['pays']) && $row['pays'] != '-' ? $row['pays'] : 'Inconnu';
							$donnees[$nom] = $row['nombre'];
						}
					}

					$graph = new Graph(500, 400);

					$graph->shadow->setPosition(Shadow::RIGHT_BOTTOM);
					$graph->shadow->setSize(4);
					$graph->setBackgroundGradient(new LinearGradient(
						new Color(240, 240, 240, 0),
						new White, 0));

					$pie = new Pie(array_values($donnees));
					$pie->setLegend(array_keys($donnees));

					$pie->legend->setPosition(1.35, 0.3);
					$pie->legend->setTextFont(new Tuffy(10));
					$pie->legend->setPosition(1.3, 0.5);
					$pie->setCenter(0.4, 0.5);
					$pie->setSize(0.65, 0.65);

					$pie->set3D(5);
					$graph->add($pie);
					$response->setContent($graph->draw(Graph::DRAW_RETURN));
				}

				/**
				 * Clics par âge des cliqueurs.
				 */
				elseif ($outil == 'age')
				{
					$donnees = array();
					$rows = Doctrine_Query::create()
						->from('PubliciteClic c')
						->select('COUNT(*) AS nombre, c.age')
						->where('c.publicite_id = ?', $publicite['id'])
						->groupBy('c.age')
						->execute();
					foreach ($rows as $row)
					{
						if (!empty($row['age']))
							$donnees[$row['age']] = $row['nombre'];
					}
					//Si aucune donnée on affiche un message et on quite.
					if (empty($donnees))
					{
						header ("Content-type: image/png");
						$image = imagecreate(300, 50);
						$blanc = imagecolorallocate($image, 255, 255, 255);
						$noir = imagecolorallocate($image, 0, 0, 0);
						imagestring($image, 4, 35, 15, 'Pas d\'informations disponibles.', $noir);
						imagepng($image);
						exit();
					}
					for ($i = min(array_keys($donnees)) ; $i <= max(array_keys($donnees)) ; $i++)
					{
						if (!isset($donnees[$i])) $donnees[$i] = 0;
					}
					ksort($donnees);

					$graph = new Graph(800, 450);
					$graph->setBackgroundGradient(new LinearGradient(
						new Color(62, 207, 248, 0),
						new Color(85, 214, 251, 0),
						0
					));
					$graph->title->set('Répartition des âges des cliqueurs');
					$graph->title->setPadding(20, 0, 20, 0);

					//Légende abscisse-ordonnée.
					$groupe = new PlotGroup;
					$groupe->setPadding(50, 20, 20, 40);
					$groupe->axis->left->title->setFont(new Tuffy(10));
					$groupe->axis->left->title->setPadding(0, 20, 0, 0);
					$groupe->axis->left->title->set('Nombre de clics');

					$groupe->axis->bottom->title->setFont(new Tuffy(10));
					$groupe->axis->bottom->title->set('Âge');
					$groupe->axis->bottom->setLabelText(array_keys($donnees));

					$plot = new BarPlot(array_values($donnees));
					$plot->setBarGradient(new LinearGradient(
						new Color(100, 100, 255, 0),
						new Color(150, 150, 255, 0),
						0
					));
					$plot->setXAxis(Plot::BOTTOM);
					$plot->setYAxis(Plot::LEFT);

					$groupe->add($plot);
					$graph->add($groupe);
					$response->setContent($graph->draw(Graph::DRAW_RETURN));
				}
				/**
				 * Nombre de clics / affichages / taux sur une période de temps.
				 */
				elseif ($outil == 'clic' || $outil == 'affichage' || $outil == 'taux')
				{
					$interval = 14;
					$dateDebut = isset($_GET['week']) ? strtotime($_GET['week']) : strtotime('-'.$interval.' days', time());
					$dateFin = strtotime('+'.$interval.' days', $dateDebut);
					$listeJours = array('Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');
					$listeMois = array('Jan', 'Fév', 'Mar', 'Avr', 'Mai',
						'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc');
					list($jour, $mois, $annee) = explode('-', date('d-m-Y', $dateDebut));

					$labels = $donnees = $rows = array();
					$rows_ = Doctrine_Query::create()
						->from('PubliciteStat s')
						->select('s.nb_clics, s.nb_affichages, s.date')
						->where('s.publicite_id = ?', $publicite['id'])
						->andWhere('s.date >= ?', date('Y-m-d', $dateDebut))
						->andWhere('s.date < ?', date('Y-m-d', $dateFin))
						->orderBy('s.date')
						->execute();
					foreach ($rows_ as $row)
					{
						$rows[$row['date']] = $row;
					}
					unset($rows_);

					for ($i = 0 ; $i < $interval ; $i++)
					{
						$time = strtotime('+'.$i.' days', $dateDebut);
						$labels[] = $listeJours[(int)date('N', $time)-1]."\n".date('j', $time).' '.$listeMois[date('n', $time)-1];
						if (isset($rows[date('Y-m-d', $time)]))
						{
							if ($outil == 'clic')
								$donnees[] = (int)$rows[date('Y-m-d', $time)]['nb_clics'];
							elseif ($outil == 'affichage')
								$donnees[] = (int)$rows[date('Y-m-d', $time)]['nb_affichages'];
							elseif ($outil == 'taux')
								$donnees[] = round($rows[date('Y-m-d', $time)]['nb_affichages'] > 0 ? (int)$rows[date('Y-m-d', $time)]['nb_clics']*100 / (int)$rows[date('Y-m-d', $time)]['nb_affichages'] : 0, 2);
						}
						else
							$donnees[] = 0;

					}
					array_reverse($labels);

					$graph = new Graph(800, 400);
					$graph->setBackgroundGradient(new LinearGradient(
						new Color(62, 207, 248, 0),
						new Color(85, 214, 251, 0),
						0
					));

					//Légendes des axes.
					$legendes = array('clic' => 'Nombre de clics', 'affichage' => 'Nombre d\'impressions', 'taux' => 'Taux de clics (%)');

					$groupe = new PlotGroup;
					$groupe->setPadding(50, 20, 20, 40);
					$groupe->axis->left->title->setFont(new Tuffy(10));
					$groupe->axis->left->title->setPadding(0, 20, 0, 0);
					$groupe->axis->left->title->set($legendes[$outil]);

					$groupe->axis->bottom->title->setFont(new Tuffy(10));
					$groupe->axis->bottom->setLabelText($labels);

					//On trace la courbe avec les données.
					$plot = new LinePlot($donnees);
					$plot->setColor(new Color(20, 100, 10, 0));
					$plot->setXAxis(Plot::BOTTOM);
					$plot->setYAxis(Plot::LEFT);

					$groupe->add($plot);
					$graph->add($groupe);
					$response->setContent($graph->draw(Graph::DRAW_RETURN));
				}

				return $response;
			}
			else
			{
				return new Response('Vous n\'avez pas l\'autorisation de voir les statistiques des publicités.');
			}
		}
		else
		{
			return new Response('Vous n\'avez pas l\'autorisation de voir les statistiques des publicités.');
		}
	}
}
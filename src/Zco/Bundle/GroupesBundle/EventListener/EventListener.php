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

namespace Zco\Bundle\GroupesBundle\EventListener;

use Zco\Bundle\AdminBundle\AdminEvents;
use Zco\Bundle\CoreBundle\Menu\Event\FilterMenuEvent;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventListener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			AdminEvents::MENU => 'onFilterAdmin',
		);
	}
	
	public function onFilterAdmin(FilterMenuEvent $event)
	{
		$tab = $event
		    ->getRoot()
		    ->getChild('Communauté')
		    ->getChild('Groupes');
		
		$tab->addChild('Ajouter un groupe', array(
			'uri' => '/groupes/ajouter.html',
		))->secure('groupes_gerer');
	
		$tab->addChild('Gérer les groupes', array(
			'uri' => '/groupes/',
		))->secure('groupes_gerer');
	
		$tab->addChild('Éditer les droits d\'un groupe', array(
			'uri' => '/groupes/droits.html',
		))->secure('groupes_changer_droits');
	
		$tab->addChild('Changer un membre de groupe', array(
			'uri' => '/groupes/changer-membre-groupe.html',
			'separator' => true,
		))->secure('groupes_changer_membre');
		
		$tab = $event
		    ->getRoot()
		    ->getChild('Informations')
		    ->getChild('Journaux');
		
		$tab->addChild('Historique des changements de groupe', array(
			'uri' => '/groupes/historique-groupes.html',
		))->secure('voir_historique_groupes');
	}
}
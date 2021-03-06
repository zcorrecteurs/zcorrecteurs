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

namespace Zco\Bundle\BlogBundle;

use Zco\Component\HttpKernel\Bundle\AbstractBundle;

class ZcoBlogBundle extends AbstractBundle
{
	public function preload()
	{
		//Enregistrement des compteurs de tâches admin.
		$this->container->get('zco_admin.manager')->register('commentairesBlog', array('blog_editer_commentaires', 'blog_supprimer_commentaires'));
		$this->container->get('zco_admin.manager')->register('blog', 'blog_valider');
	}
	
	public function load()
	{
		//Inclusion des modèles
		include_once(__DIR__.'/modeles/blog.php');
		include_once(__DIR__.'/modeles/commentaires.php');
		include_once(__DIR__.'/modeles/versions.php');
		include_once(__DIR__.'/modeles/validation.php');
	}
}
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

/**
 * Widget représentant un ensemble de boutons radio.
 *
 * @author vincent1870 <vincent@zcorrecteurs.fr>
*/
class Widget_Radio extends Widget
{
	public function configure($options, $attrs)
	{
		$this->addOption('separator', ' ');
		$this->addOption('choices');
		$this->addRequiredOption('choices');
	}

	public function render()
	{
		$return = array();
		$v = $this->getAttribute('value');
		$this->setAttribute('value', null);
		foreach($this->getOption('choices') as $key => $value)
		{
			$checked = $key == $v ? ' checked="checked"' : '';
			$this->setAttribute('id', sprintf('id_for_%s', $key));
			$return[] = sprintf('<input type="radio" value="%s"%s%s />',
				$key,
				$this->flatAttrs(),
				$checked
			);
			$return[] = sprintf('<label for="id_for_%s" class="nofloat">%s</label>'."\n", $key, $value);
		}

		return implode($this->getOption('separator'), $return);
	}
}

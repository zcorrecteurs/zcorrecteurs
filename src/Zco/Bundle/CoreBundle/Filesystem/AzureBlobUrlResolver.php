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

namespace Zco\Bundle\CoreBundle\Filesystem;

final class AzureBlobUrlResolver implements UrlResolver
{
    private $account;
    private $container;

    /**
     * Constructor.
     *
     * @param string $account
     * @param string $container
     */
    public function __construct(string $account, string $container)
    {
        $this->account = $account;
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveUrl(string $path)
    {
        if (strpos($path, '://') > -1) {
            // It is already a full URL.
            return $path;
        }
        return sprintf('https://%s.blob.core.windows.net/%s/%s', $this->account, $this->container, $path);
    }
}
<?php $view->extend('::layouts/bootstrap.html.php') ?>

<h1>Historique des versions</h1>

<p>
	Voici la liste de toutes les versions du billet. Pour chacune vous pouvez
	la visualiser, et éventuellement décider de rétablir votre billet tel qu'il
	était à ce moment.<br />

	Un <span class="vertf">élément vert</span> indique qu'il n'y a pas eu de
	modification par rapport à la version précédente (au-dessous).<br />

	Un <span class="rouge">élément rouge</span> indique des modifications par
	rapport à la version précédente (au-dessous).
</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th style="width: 5%;">N<sup>o</sup></th>
			<th style="width: 15%;">Date</th>
			<th style="width: 15%;">Pseudo</th>
			<th style="width: 40%;">Modifications</th>
			<th style="width: 15%;">Comparer</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach($ListerVersions as $i => $v){ ?>
		<tr>
			<td class="center">
				<?php echo $v['version_id_fictif']; ?>
			</td>
			<td class="center">
				<?php echo dateformat($v['version_date']); ?>
			</td>
			<td>
				<a href="/membres/profil-<?php echo $v['utilisateur_id']; ?>-<?php echo rewrite($v['utilisateur_pseudo']); ?>.html">
					<?php echo htmlspecialchars($v['utilisateur_pseudo']); ?>
				</a>
			</td>
			<td>
				<span class="<?php echo $v['titre']; ?>">
					<?php echo htmlspecialchars($v['version_titre']); ?>
				</span> -
				<span class="<?php echo $v['sous_titre']; ?>">
					<?php echo !empty($v['version_sous_titre']) ? htmlspecialchars($v['version_sous_titre']) : '(aucun)'; ?>
				</span> -
				<span class="italic <?php echo $v['texte']; ?>">(contenu)</span> -
				<span class="italic <?php echo $v['intro']; ?>">(intro)</span>
				<?php if(!empty($v['version_commentaire'])){ ?><br />
				<strong>Commentaire :</strong> <?php echo htmlspecialchars($v['version_commentaire']); ?>
				<?php } ?>
			</td>
			<td class="center">
				<?php if($v['version_id_fictif'] > 0){ ?>
				<a href="<?php echo $view['router']->path('zco_blog_compare', ['from' => $v['version_id'], 'to' => $v['id_precedent']]) ?>">
					Comparer avec n<sup>o</sup>&nbsp;<?php echo $v['version_id_fictif'] - 1; ?>
				</a>
				<?php } else echo '-'; ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
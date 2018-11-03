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

namespace Zco\Bundle\CoreBundle\Parser;

use Highlight\Highlighter;

/**
 * Composant principal du parseur de zCode, voir zCode.xsl pour la présentation.
 *
 * @author    mwsaz <mwsaz@zcorrecteurs.fr>
 * @copyright mwsaz <mwksaz@gmail.com> 2010-2012
 */
class CoreFeature implements ParserFeature
{
	/**
	 * Protocoles acceptés pour les urls (liens, images).
	 *
	 * @var array
	 */
	private static $protocoles = array(
		'apt', 'ftp', 'http', 'https',
	);

	/**
	 * Liste des balises du zCode (utilisé pour échapper les autres balises,
	 * supposées malicieuses).
	 *
	 * @var array
	 */
	private static $balises = array(
		'barre', 'gras', 'italique', 'souligne',
		'attention', 'erreur', 'information', 'question',
		'titre1', 'titre2',
		'exposant', 'indice', 'acronyme', 'faute',
		'lien',	'email',
		'liste', 'puce',
		'image', 'math',
		'couleur', 'police', 'taille',
		'position', 'flottant',
		'citation', 'secret', 'code', 'minicode', 'touche',
		'tableau', 'legende', 'ligne', 'entete', 'cellule',
	);

	/**
	 * Liste des différents types de codes pour le colorateur syntaxique.
	 * Le type de code est placé en clé et en valeur un tableau contenant
	 * le nom du colorateur à utiliser le nom lisible du langage. Le type
	 * a été entré directement par l'utilisateur.
	 *
	 * @var array
	 */
	private static $langages = array(
		'actionscript' => array('actionscript', 'Actionscript'),
		'apache' => array('apache', 'Apache'),
		'bash' => array('bash', 'Bash'),
		'bat' => array('dos', 'Batch'),
		'brainfuck' => array('brainfuck', 'BrainFuck'),
		'c' => array('cpp', 'C'),
		'c#' => array('cs', 'C#'),
        'csharp' => array('csharp', 'C#'),
		'c++' => array('cpp', 'C++'),
        'cpp' => array('cpp', 'C++'),
		'console' => array('console', 'Console'),
		'css' => array('css', 'CSS'),
		'd' => array('d', 'D'),
		'delphi' => array('delphi', 'Delphi'),
		'diff' => array('diff', 'Diff'),
		'django' => array('django', 'Django'),
		'erb' => array('erb', 'ERB'),
		'erlang' => array('erlang', 'Erlang'),
		'haskell' => array('haskell', 'Haskell'),
		'html' => array('xml', 'HTML'),
		'ini' => array('ini', 'Ini'),
		'java' => array('java', 'Java'),
		'javascript' => array('javascript', 'JavaScript'),
		'js' => array('js', 'JavaScript'),
		//'latex' => array('latex', 'LaTeX'),
		'llvm' => array('llvm', 'LLVM'),
		'lua' => array('lua', 'Lua'),
		'make' => array('make', 'Make (extension)'),
		'makefile' => array('makefile', 'Makefile'),
		'obj-c' => array('objective-c', 'Objective-C'),
		'objc' => array('objective-c', 'Objective-C'),
		'objective-c' => array('objective-c', 'Objective-C'),
		'objectivec' => array('objective-c', 'Objective-C'),
		'ocaml' => array('ocaml', 'OCaml'),
		'pascal' => array('pascal', 'Pascal'),
		'perl' => array('perl', 'Perl'),
		'php' => array('php', 'PHP'),
		'pl' => array('perl', 'Perl'),
		'po' => array('po', 'PO'),
		'pot' => array('pot', 'Gettext'),
		'py' => array('python', 'Python'),
		'python' => array('python', 'Python'),
		'rb' => array('ruby', 'Ruby'),
		'rst' => array('rst', 'ReStructured Text'),
		'ruby' => array('ruby', 'Ruby'),
		'scheme' => array('scheme', 'Scheme'),
		'sh' => array('sh', 'Bash'),
		'sql' => array('sql', 'SQL'),
		'squid' => array('squid', 'SQUID'),
		'tcl' => array('tcl', 'Tcl'),
		'tex' => array('tex', 'TeX'),
		'text' => array('text', 'Texte'),
		'vb.net' => array('vb.net', 'VB.NET'),
		'vbnet' => array('vb.net', 'VB.NET'),
		'xml' => array('xml', 'XML'),
		'zcode' => array('xml', 'zCode')
	);

	private static $codesParses;
	private static $prefixeAncre;
	private static $ancres;
	private static $dom;

    /**
     * Remplace les liens automatiques (non-entourés de balises).
     *
     * @param string $content
     * @param array $options
     * @return string
     */
    public function preProcessText(string $content, array $options): string
    {
		static $protocoles = array();
		if (!$protocoles)
		{
			foreach (self::$protocoles as $protocole)
			{
				$protocoles[] = preg_quote($protocole, '`');
			}
			$protocoles = implode('|', $protocoles);
		}

		return preg_replace(
			'`(\s|^|>)'
			.'((?:'.$protocoles.')://[.0-9a-z/~;:@?&=#%_-]+)'
			.'(\s|$|<)(?![^><]*"[^>]*>)`i',
			'$1<lien>$2</lien>$3',
			$content
		);
    }

    /**
     * Remplace les sauts de ligne par la balise HTML appropriée.
     * Remplace les codes parsés par leur valeur.
     *
     * @param string $content
     * @param array $options
     * @return string
     */
    public function postProcessText(string $content, array $options): string
    {
        $text = nl2br(trim($content));
		$text = preg_replace(
		    '`(</li>|<ul [a-z]+="[a-zA-Z0-9_]*">)<br />`',
		    '$1',
		    $text
		);

		if (self::$codesParses) // Balises code
		{
		    $codesParses = self::$codesParses;
			$text = preg_replace_callback(
				'`<zcode-code>([0-9]+)</zcode-code>`',
				function($m) use ($codesParses) {
				    return isset($codesParses[$m[1]]) ? $codesParses[$m[1]] : '';
				}, $text
			);
		}

		return $text;
    }

	/**
	 * Convertit le zCode en HTML grâce à une feuille de style XSLT.
	 *
	 * @param \DOMDocument $doc
     * @param array $options
     * @return \DOMDocument
	 */
	public function processDom(\DOMDocument $doc, array $options): \DOMDocument
	{
	    self::$dom = $doc;
		self::$codesParses = array(); // Nettoyer les anciens parsages
		self::$prefixeAncre = $options['core.anchor_prefix'] ?? false;
		if (self::$prefixeAncre)
		{
			self::$prefixeAncre = (ctype_digit(self::$prefixeAncre) ? 'zc' : '').self::$prefixeAncre.'-';
		}
		self::$ancres = array();

		static $xsl = false;  // Le chargement de la feuille de style
		static $xslt = false; // est ce qui prend le plus de temps...
		if ($xsl === false || $xslt === false)
		{
			$xsl = new \DOMDocument;
			$xsl->load(__DIR__ . '/zCode.xsl');

			$xslt = new \XSLTProcessor;
			$xslt->importStylesheet($xsl);
			$xslt->registerPhpFunctions();
		}

		$html = $xslt->transformToXML($doc);

		//On insère le HTML dans un nouvel arbre DOM rien que pour lui.
		$html = trim(substr($html, strlen('<?xml version="1.0" encoding="utf-8"?>')));
		$newDom = new \DOMDocument;
		$newDom->loadXML('<zcode>'.$html.'</zcode>');

		return $newDom;
	}

	/**
	 * Récupère les balises du zCode et les repasse en XML. Évite ainsi
	 * l'insertion d'une balise HTML au milieu du zCode.
	 *
	 * @param string $content
     * @param array $options
     * @return string
	 */
	public function prepareXML(string $content, array $options): string
	{
	    $texte = htmlspecialchars($content);
		static $balises = array();
		if(!$balises)
		{
			foreach(self::$balises as &$balise)
				$balises[] = preg_quote($balise, '`');
			$balises = implode('|', $balises);
		}

		$remplacements = 1;
		$balises_c = function($m)
		{
			return '<'.$m[1].str_replace('&quot;', '"', $m[2])
				.'>'.$m[3].'</'.$m[1].'>';
		};

		$pattern = '`&lt;('.$balises.')'
			.'((?:\s+[A-Za-z_-]+=&quot;.*?&quot;)*)'
			.'&gt;(.+?)&lt;/\\1&gt;`s';
		do
		{
			$texte = preg_replace_callback(
				$pattern,
				$balises_c, $texte, -1, $remplacements);
		}
		while($remplacements && preg_match($pattern, $texte));

		$code_c = function($m){
		    return $m[1].htmlspecialchars($m[2]).$m[3];
		};
		$texte = preg_replace_callback(
			'`(<code(?:(?:\s+[A-Za-z_-]+=".*?")*)>)(.+?)(</code>)`s',
			$code_c, $texte);

		return $texte;
	}

	/**
	 * Vérifie le protocole d'une URL.
	 *
	 * @param  string $lien URL
	 * @return boolean Protocole autorisé ?
	 */
	public static function verifierLien($lien)
	{
		$protocole = substr($lien, 0, strpos($lien, ':'));

		return $protocole === '' || in_array($protocole, self::$protocoles);
	}

    /**
     * Crée une ancre automatique pour un contenu donné.
     *
     * @param  string $text Le contenu sur lequel créer une ancre
     * @return string L'identifant de l'ancre
     */
	public static function ancre($text)
	{
		if (self::$prefixeAncre === false)
			return '';

		$t = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$t = preg_replace('`[^A-Za-z0-9]+`', '-', $t);
		$t = trim($t, '-');

		if (!$t)
		{
		    $t = substr(md5($text), 0, 8);
		}

		if (isset(self::$ancres[$t]))
			$t .= ++self::$ancres[$t];
		else
			self::$ancres[$t] = 1;

		return self::$prefixeAncre.$t;
	}

	/**
	 * Colore un code.
	 *
	 * @param \DOMElement $code Code à colorer.
	 * @return int ID du code coloré.
	 */
	public static function colorerCode(\DOMElement $code)
	{
		// Récupération des attributs
		$langage = $code[0]->getAttribute('type');
		$premiereLigne = (int)$code[0]->getAttribute('debut');
		$surligne = $code[0]->getAttribute('surligne');
		$minicode = $code[0]->nodeName == 'minicode';

		// Puis du code à colorer
		$texte = '';
		foreach($code[0]->childNodes as $enfant)
			$texte .= self::$dom->saveXML($enfant);

		// URLs cliquables
		$texte = str_replace(array('<lien>', '</lien>'), '', $texte);

		$html = create_function('$t',
			'return str_replace(array("&lt;", "&gt;", '
			.'"&quot;", "&amp;"), array("<", ">", "\\"", "&"), $t);');
		$texte = $html($html(trim($texte)));

		// Décalage dans la numérotation (commencer à x)
		if($premiereLigne <= 0)
			$premiereLigne = 1;
		$derniereLigne = $premiereLigne + substr_count($texte, "\n");

		// ID du code parsé
		$id = count(self::$codesParses);

		$langage = isset(self::$langages[$langage]) ?
			self::$langages[$langage][0] : false;

		// Le langage "console" est un peu à part, c'est juste un fond noir
		$colorer = $langage && $langage != 'console';
		$reponse = null;
		if($colorer)
		{
			$reponse = self::colorerCode_c($texte, $langage, $premiereLigne, $minicode) ?: htmlspecialchars($texte);
            if(!$minicode) {
                $out = '<table class="syntaxtable"><tbody><tr><td class="linenos"><pre>';
                if ($langage != self::$langages['console'][0]) {
                    for ($i = $premiereLigne; $i <= $derniereLigne; $i++)
                        $out .= $i . "\n";
                }
                $out .= '</pre></td>'
                    . '<td class="code"><div class="syntax"><pre>'
                    . $reponse
                    . '</pre></div></td></tr></tbody></table>';
                $reponse = $out;
            }

            self::$codesParses[] = $reponse;
		}

		// Surlignage
		if(strpos($surligne, '-') !== false) // Plage de lignes
		{
			$surligne = explode('-', $surligne);
			if(count($surligne) != 2)
				$surligne = false;
			else
			{
				$surligne[0] = (int)trim($surligne[0]);
				$surligne[1] = $surligne[1] === '' ? // Plages incomplètes e.g. 3-
					$derniereLigne : (int)trim($surligne[1]);

				if($surligne[0] == $surligne[1])
					$surligne[0] = &$surligne[1];
				else if($surligne[0] > $surligne[1]) // Inverser l'ordre
				{
					list($surligne[0], $surligne[1])
						= array($surligne[1], $surligne[0]);
				}

				if($surligne[0] < $premiereLigne)
					$surligne[0] = $premiereLigne;
				if($surligne[1] > $derniereLigne)
					$surligne[1] = $derniereLigne;

				$s = array();
				for($i = $surligne[0]; $i <= $surligne[1]; $i++)
					$s[] = $i;
				$surligne = $s;
			}
		}
		elseif(strpos($surligne, ',') !== false || (int)$surligne) // Lignes précises
		{
			$surligne = explode(',', $surligne);
			foreach($surligne as $k => &$ligne)
			{
				$ligne = (int)$ligne;
				if($ligne < $premiereLigne
				|| $ligne > $derniereLigne)
					unset($surligne[$k]);
			}
			$surligne = array_unique($surligne);
		}
		else
			$surligne = false;

		if(!$minicode && $surligne)
		{
			$texte = self::$codesParses[$id];
			$finNumeros = '</pre></td><td class="code"><div class="syntax"><pre>';

			// Séparation du texte et des balises du tableau
			$debutTableau = substr($texte, 0, strpos($texte, $finNumeros) + strlen($finNumeros));
			$finTableau = substr($texte, strrpos($texte, '</pre>'));

			$texte = substr($texte, strlen($debutTableau), -strlen($finTableau));
			$texte = explode("\n", $texte);

			foreach($surligne as &$ligne)
			{
				$texte[$ligne - $premiereLigne]
					= '<span class="ln-xtra">'
					 .$texte[$ligne - $premiereLigne]
					 .'</span>';
			}
			self::$codesParses[$id] = $debutTableau.implode("\n", $texte).$finTableau;
		}

		return $id;
	}

	/**
	 * Callback pour la coloration d'un code.
	 *
	 * @param  string $code            Code à colorer.
	 * @param  string $langage         Langage.
	 * @param  string $premiereLigne   Nombre à partir duquel commencer la numérotation.
	 * @param  bool   $minicode        Balise minicode ?
	 * @return string Code coloré.
	 */
	private static function colorerCode_c($code, $langage, $premiereLigne, $minicode)
	{
        $hl = new Highlighter();
        return $hl->highlight($langage, $code)->value;
	}

	/**
	 * Retourne le nom du langage, à afficher à côté de Code :
	 *
	 * @param string $langage Attribut type.
	 * @return string Nom "humain" du langage.
	 */
	public static function nomCode($langage)
	{
		return isset(self::$langages[$langage]) ? self::$langages[$langage][1] : 'Autre';
	}

	/**
	 * Retourne l'attribut class associé au langage, pour le span.
	 *
	 * @param string $langage Attribut type.
	 * @return string Class associée.
	 */
	public static function typeCode($langage)
	{
		return isset(self::$langages[$langage]) ? ' '.$langage : '';
	}

	/**
	 * Renvoie le nom de l'auteur, et un lien vers le message.
	 *
	 * @param int $rid ID du message
	 * @return string sujet:auteur
	 */
	public static function citationRid($rid)
	{
		$dbh = \Doctrine_Manager::connection()->getDbh();

		$stmt = $dbh->prepare('SELECT message_sujet_id, utilisateur_pseudo '
			.'FROM zcov2_forum_messages '
			.'LEFT JOIN zcov2_utilisateurs '
			.'ON message_auteur = utilisateur_id '
			.'WHERE message_id = :message');

		$stmt->bindParam('message', $rid);
		$stmt->execute();
		if (!$row = $stmt->fetch(\PDO::FETCH_ASSOC))
		{
			return false;
		}

		return $row['message_sujet_id'].':'.$row['utilisateur_pseudo'];
	}
}
<?php

/**
 * BaseCategorie
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $nom
 * @property integer $gauche
 * @property integer $droite
 * @property integer $niveau
 * @property string $description
 * @property string $keywords
 * @property string $url
 * @property integer $nb_elements
 * @property integer $last_element
 * @property string $reglement
 * @property string $map
 * @property integer $map_type
 * @property string $redirection
 * @property boolean $disponible_ciblage
 * @property boolean $ciblage_actions
 * @property boolean $cat_archive
 * @property GroupeDroit $GroupeDroit
 * @property Doctrine_Collection $Online
 * @property Doctrine_Collection $Aide
 * @property Doctrine_Collection $Annonce
 * @property Doctrine_Collection $AnnonceCategorie
 * @property Doctrine_Collection $Blog
 * @property Doctrine_Collection $ForumSujet
 * @property Doctrine_Collection $Droit
 * @property Doctrine_Collection $Quiz
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCategorie extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_categories');
        $this->hasColumn('cat_id as id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('cat_nom as nom', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('cat_gauche as gauche', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('cat_droite as droite', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('cat_niveau as niveau', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('cat_description as description', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('cat_keywords as keywords', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('cat_url as url', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('cat_nb_elements as nb_elements', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('cat_last_element as last_element', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('cat_reglement as reglement', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('cat_map as map', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('cat_map_type as map_type', 'integer', 1, array(
             'type' => 'integer',
             'length' => '1',
             ));
        $this->hasColumn('cat_redirection as redirection', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('cat_disponible_ciblage as disponible_ciblage', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('cat_ciblage_actions as ciblage_actions', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('cat_archive', 'boolean', null, array(
             'type' => 'boolean',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('GroupeDroit', array(
             'local' => 'id',
             'foreign' => 'gd_id_categorie'));

        $this->hasMany('Online', array(
             'local' => 'cat_id',
             'foreign' => 'category_id'));

        $this->hasMany('Aide', array(
             'local' => 'id',
             'foreign' => 'categorie_id'));

        $this->hasMany('Annonce', array(
             'refClass' => 'AnnonceCategorie',
             'local' => 'categorie_id',
             'foreign' => 'annonce_id'));

        $this->hasMany('AnnonceCategorie', array(
             'local' => 'cat_id',
             'foreign' => 'categorie_id'));

        $this->hasMany('Blog', array(
             'local' => 'cat_id',
             'foreign' => 'category_id'));

        $this->hasMany('ForumSujet', array(
             'local' => 'cat_id',
             'foreign' => 'sujet_forum_id'));

        $this->hasMany('Droit', array(
             'local' => 'cat_id',
             'foreign' => 'droit_id_categorie'));

        $this->hasMany('Quiz', array(
             'local' => 'cat_id',
             'foreign' => 'categorie_id'));
    }
}
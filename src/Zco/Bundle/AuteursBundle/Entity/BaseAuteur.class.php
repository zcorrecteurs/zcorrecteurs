<?php

/**
 * BaseAuteur
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $utilisateur_id
 * @property string $nom
 * @property string $prenom
 * @property string $autres
 * @property string $description
 * @property Utilisateur $Utilisateur
 * @property Doctrine_Collection $Dictee
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAuteur extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_auteurs');
        $this->hasColumn('utilisateur_id', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '11',
             ));
        $this->hasColumn('nom', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('prenom', 'string', 100, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '100',
             ));
        $this->hasColumn('autres', 'string', 100, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '100',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'notnull' => false,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Utilisateur', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Dictee', array(
             'local' => 'id',
             'foreign' => 'auteur_id'));
    }
}
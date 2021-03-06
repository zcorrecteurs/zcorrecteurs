<?php

/**
 * BaseHistoriqueGroupe
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $utilisateur_id
 * @property timestamp $date
 * @property integer $admin_id
 * @property integer $nouveau_groupe
 * @property integer $ancien_groupe
 * @property Utilisateur $Utilisateur
 * @property Utilisateur $Admin
 * @property Groupe $AncienGroupe
 * @property Groupe $NouveauGroupe
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseHistoriqueGroupe extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_historique_groupes');
        $this->hasColumn('utilisateur_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => '25',
             ));
        $this->hasColumn('admin_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('nouveau_groupe', 'integer', 1, array(
             'type' => 'integer',
             'length' => '1',
             ));
        $this->hasColumn('ancien_groupe', 'integer', 1, array(
             'type' => 'integer',
             'length' => '1',
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

        $this->hasOne('Utilisateur as Admin', array(
             'local' => 'admin_id',
             'foreign' => 'utilisateur_id'));

        $this->hasOne('Groupe as AncienGroupe', array(
             'local' => 'ancien_groupe',
             'foreign' => 'groupe_id'));

        $this->hasOne('Groupe as NouveauGroupe', array(
             'local' => 'nouveau_groupe',
             'foreign' => 'groupe_id'));
    }
}
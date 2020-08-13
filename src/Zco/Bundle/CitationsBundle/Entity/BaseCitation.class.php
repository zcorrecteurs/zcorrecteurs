<?php

/**
 * BaseCitation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $utilisateur_id
 * @property string $auteur_prenom
 * @property string $auteur_nom
 * @property string $auteur_autres
 * @property string $contenu
 * @property timestamp $date
 * @property boolean $statut
 * @property Utilisateur $Utilisateur
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCitation extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_citations');
        $this->hasColumn('utilisateur_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('auteur_prenom', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('auteur_nom', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('auteur_autres', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('contenu', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => '25',
             ));
        $this->hasColumn('statut', 'boolean', null, array(
             'type' => 'boolean',
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
    }
}
<?php

/**
 * BaseForumAlerte
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $utilisateur_id
 * @property integer $admin_id
 * @property integer $sujet_id
 * @property timestamp $date
 * @property string $raison
 * @property boolean $resolu
 * @property integer $ip
 * @property Utilisateur $Utilisateur
 * @property Utilisateur $Admin
 * @property ForumSujet $Sujet
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseForumAlerte extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_forum_alertes');
        $this->hasColumn('utilisateur_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('admin_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('sujet_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => '25',
             ));
        $this->hasColumn('raison', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('resolu', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('ip', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
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

        $this->hasOne('ForumSujet as Sujet', array(
             'local' => 'sujet_id',
             'foreign' => 'sujet_id'));
    }
}
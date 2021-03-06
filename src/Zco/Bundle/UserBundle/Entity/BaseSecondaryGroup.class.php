<?php

/**
 * BaseSecondaryGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $groupe_id
 * @property integer $utilisateur_id
 * @property Utilisateur $User
 * @property Groupe $Group
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseSecondaryGroup extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_groupes_secondaires');
        $this->hasColumn('groupe_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('utilisateur_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Utilisateur as User', array(
             'local' => 'utilisateur_id',
             'foreign' => 'id'));

        $this->hasOne('Groupe as Group', array(
             'local' => 'groupe_id',
             'foreign' => 'id'));
    }
}
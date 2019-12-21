<?php

/**
 * BaseAnnoncePays
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $annonce_id
 * @property integer $pays_id
 * @property Annonce $Annonce
 * @property Pays $Pays
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAnnoncePays extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_annonces_pays');
        $this->hasColumn('annonce_id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '11',
             ));
        $this->hasColumn('pays_id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '11',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Annonce', array(
             'local' => 'annonce_id',
             'foreign' => 'id'));

        $this->hasOne('Pays', array(
             'local' => 'pays_id',
             'foreign' => 'id'));
    }
}
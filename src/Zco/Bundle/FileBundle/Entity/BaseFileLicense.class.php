<?php

/**
 * BaseFileLicense
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $file_id
 * @property integer $license_id
 * @property string $pseudo
 * @property License $License
 * @property File $File
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseFileLicense extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('file_license');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'autoincrement' => true,
             'primary' => true,
             'length' => '11',
             ));
        $this->hasColumn('file_id', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '11',
             ));
        $this->hasColumn('license_id', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '11',
             ));
        $this->hasColumn('pseudo', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('License', array(
             'local' => 'licence_id',
             'foreign' => 'id'));

        $this->hasOne('File', array(
             'local' => 'file_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             'created' => 
             array(
              'name' => 'date',
             ),
             'updated' => 
             array(
              'disabled' => true,
             ),
             ));
        $this->actAs($timestampable0);
    }
}
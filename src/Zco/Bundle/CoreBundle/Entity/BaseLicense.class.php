<?php

/**
 * BaseLicense
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $logo_url
 * @property string $summary_url
 * @property string $fulltext_url
 * @property boolean $keep_author
 * @property boolean $keep_same_license
 * @property boolean $can_be_modified
 * @property boolean $commercial_use_allowed
 * @property Doctrine_Collection $File
 * @property Doctrine_Collection $FileLicense
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseLicense extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('license');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'autoincrement' => true,
             'primary' => true,
             'length' => '11',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('logo_url', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('summary_url', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('fulltext_url', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('keep_author', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('keep_same_license', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('can_be_modified', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('commercial_use_allowed', 'boolean', null, array(
             'type' => 'boolean',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('File', array(
             'local' => 'id',
             'foreign' => 'license_id'));

        $this->hasMany('FileLicense', array(
             'local' => 'id',
             'foreign' => 'licence_id'));
    }
}
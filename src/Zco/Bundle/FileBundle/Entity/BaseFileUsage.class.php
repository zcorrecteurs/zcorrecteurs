<?php

/**
 * BaseFileUsage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $file_id
 * @property integer $thumbnail_id
 * @property integer $part
 * @property string $entity_class
 * @property integer $entity_id
 * @property FileThumbnail $Thumbnail
 * @property File $File
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseFileUsage extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('file_usage');
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
        $this->hasColumn('thumbnail_id', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '11',
             ));
        $this->hasColumn('part', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '11',
             ));
        $this->hasColumn('entity_class', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('entity_id', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '11',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('FileThumbnail as Thumbnail', array(
             'local' => 'thumbnail_id',
             'foreign' => 'id'));

        $this->hasOne('File', array(
             'local' => 'file_id',
             'foreign' => 'id'));
    }
}
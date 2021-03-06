<?php

/**
 * BaseBlogVersion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $version_id
 * @property integer $version_id_billet
 * @property integer $version_id_utilisateur
 * @property integer $version_id_fictif
 * @property timestamp $version_date
 * @property integer $version_ip
 * @property string $title
 * @property string $subtitle
 * @property string $content
 * @property string $introduction
 * @property string $version_commentaire
 * @property Doctrine_Collection $Blog
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseBlogVersion extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_blog_versions');
        $this->hasColumn('version_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('version_id_billet', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '4',
             ));
        $this->hasColumn('version_id_utilisateur', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '4',
             ));
        $this->hasColumn('version_id_fictif', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('version_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => '25',
             ));
        $this->hasColumn('version_ip', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('version_titre as title', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('version_sous_titre as subtitle', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('version_texte as content', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('version_intro as introduction', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('version_commentaire', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Blog', array(
             'local' => 'version_id',
             'foreign' => 'current_version_id'));
    }
}
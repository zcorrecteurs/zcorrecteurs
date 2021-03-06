<?php

/**
 * BaseBlogLunonlu
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $lunonlu_id_utilisateur
 * @property integer $lunonlu_id_billet
 * @property integer $lunonlu_id_commentaire
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseBlogLunonlu extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_blog_lunonlu');
        $this->hasColumn('lunonlu_id_utilisateur', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('lunonlu_id_billet', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('lunonlu_id_commentaire', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}
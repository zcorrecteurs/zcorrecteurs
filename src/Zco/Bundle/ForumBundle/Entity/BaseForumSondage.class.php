<?php

/**
 * BaseForumSondage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $sondage_id
 * @property string $sondage_question
 * @property boolean $sondage_ferme
 * @property Doctrine_Collection $ForumSujet
 * @property Doctrine_Collection $ForumSondageChoix
 * @property Doctrine_Collection $ForumSondageVote
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseForumSondage extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_forum_sondages');
        $this->hasColumn('sondage_id', 'integer', 11, array(
             'type' => 'integer',
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('sondage_question', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('sondage_ferme', 'boolean', null, array(
             'type' => 'boolean',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('ForumSujet', array(
             'local' => 'sondage_id',
             'foreign' => 'sujet_sondage'));

        $this->hasMany('ForumSondageChoix', array(
             'local' => 'sondage_id',
             'foreign' => 'choix_sondage_id'));

        $this->hasMany('ForumSondageVote', array(
             'local' => 'sondage_id',
             'foreign' => 'vote_sondage_id'));
    }
}
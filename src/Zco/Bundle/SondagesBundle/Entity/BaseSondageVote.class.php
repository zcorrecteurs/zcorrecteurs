<?php

/**
 * BaseSondageVote
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $utilisateur_id
 * @property integer $reponse_id
 * @property integer $question_id
 * @property timestamp $date
 * @property integer $ip
 * @property SondageReponse $Reponse
 * @property SondageQuestion $Question
 * @property Utilisateur $Utilisateur
 * @property SondageTexte $TexteLibre
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseSondageVote extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_sondages_votes');
        $this->hasColumn('utilisateur_id', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '11',
             ));
        $this->hasColumn('reponse_id', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '11',
             ));
        $this->hasColumn('question_id', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '11',
             ));
        $this->hasColumn('date', 'timestamp', null, array(
             'type' => 'timestamp',
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
        $this->hasOne('SondageReponse as Reponse', array(
             'local' => 'reponse_id',
             'foreign' => 'id'));

        $this->hasOne('SondageQuestion as Question', array(
             'local' => 'question_id',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasOne('SondageTexte as TexteLibre', array(
             'local' => 'id',
             'foreign' => 'vote_id'));
    }
}
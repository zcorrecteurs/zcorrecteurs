<?php

/**
 * BaseSondageTexte
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $vote_id
 * @property string $texte
 * @property SondageVote $Vote
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseSondageTexte extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_sondages_votes_textes');
        $this->hasColumn('vote_id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '11',
             ));
        $this->hasColumn('texte', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('SondageVote as Vote', array(
             'local' => 'vote_id',
             'foreign' => 'id'));
    }
}
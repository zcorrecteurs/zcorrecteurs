<?php

/**
 * BaseUtilisateur
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $groupe_id
 * @property string $pseudo
 * @property string $email
 * @property string $new_email
 * @property string $avatar
 * @property string $mot_de_passe
 * @property string $utilisateur_nouveau_mot_de_passe
 * @property string $signature
 * @property integer $forum_messages
 * @property timestamp $date_inscription
 * @property timestamp $date_derniere_visite
 * @property boolean $valide
 * @property string $registration_hash
 * @property string $validation_hash
 * @property integer $ip
 * @property string $title
 * @property string $address
 * @property decimal $latitude
 * @property decimal $longitude
 * @property integer $nb_sanctions
 * @property integer $percentage
 * @property boolean $email_displayed
 * @property string $job
 * @property date $birth_date
 * @property string $website
 * @property string $localisation
 * @property boolean $country_displayed
 * @property string $biography
 * @property string $hobbies
 * @property string $citation
 * @property string $pgk_key
 * @property timestamp $utilisateur_derniere_lecture
 * @property integer $sexe
 * @property string $twitter
 * @property boolean $display_signature
 * @property Groupe $Groupe
 * @property UserPreference $Preferences
 * @property Doctrine_Collection $BannedEmail
 * @property Doctrine_Collection $Online
 * @property Doctrine_Collection $SecondaryGroups
 * @property Doctrine_Collection $UtilisateurIp
 * @property Doctrine_Collection $UserNewUsername
 * @property Doctrine_Collection $UserPunishment
 * @property Doctrine_Collection $UserWarning
 * @property Doctrine_Collection $ZformBackup
 * @property Doctrine_Collection $Tentative
 * @property Doctrine_Collection $Annonce
 * @property Doctrine_Collection $Auteur
 * @property Doctrine_Collection $BlogAuteur
 * @property Doctrine_Collection $Citation
 * @property Doctrine_Collection $Dictee
 * @property Doctrine_Collection $Dictee_Participation
 * @property Doctrine_Collection $Don
 * @property Doctrine_Collection $EvolutionFeedback
 * @property Doctrine_Collection $ForumAlerte
 * @property Doctrine_Collection $ForumLunonlu
 * @property Doctrine_Collection $ForumMessage
 * @property Doctrine_Collection $ForumSujet
 * @property Doctrine_Collection $ForumSondageVote
 * @property Doctrine_Collection $HistoriqueGroupe
 * @property Doctrine_Collection $Quiz
 * @property Doctrine_Collection $QuizQuestion
 * @property Doctrine_Collection $QuizScore
 * @property Doctrine_Collection $RecrutementCandidature
 * @property Doctrine_Collection $RecrutementCommentaire
 * @property Doctrine_Collection $RecrutementLuNonLu
 * @property Doctrine_Collection $RecrutementAvis
 * @property Doctrine_Collection $Sondage
 * @property Doctrine_Collection $SondageVote
 * @property Doctrine_Collection $Tag
 * @property Doctrine_Collection $File
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseUtilisateur extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('zcov2_utilisateurs');
        $this->hasColumn('utilisateur_id as id', 'integer', 11, array(
             'type' => 'integer',
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('utilisateur_id_groupe as groupe_id', 'integer', 1, array(
             'type' => 'integer',
             'length' => '1',
             ));
        $this->hasColumn('utilisateur_pseudo as pseudo', 'string', 32, array(
             'type' => 'string',
             'length' => '32',
             ));
        $this->hasColumn('utilisateur_email as email', 'string', 128, array(
             'type' => 'string',
             'length' => '128',
             ));
        $this->hasColumn('utilisateur_nouvel_email as new_email', 'string', 128, array(
             'type' => 'string',
             'length' => '128',
             ));
        $this->hasColumn('utilisateur_avatar as avatar', 'string', 20, array(
             'type' => 'string',
             'length' => '20',
             ));
        $this->hasColumn('utilisateur_mot_de_passe as mot_de_passe', 'string', 40, array(
             'type' => 'string',
             'length' => '40',
             ));
        $this->hasColumn('utilisateur_nouveau_mot_de_passe', 'string', 40, array(
             'type' => 'string',
             'length' => '40',
             ));
        $this->hasColumn('utilisateur_signature as signature', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('utilisateur_forum_messages as forum_messages', 'integer', 11, array(
             'type' => 'integer',
             'default' => '0',
             'length' => '11',
             ));
        $this->hasColumn('utilisateur_date_inscription as date_inscription', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => '25',
             ));
        $this->hasColumn('utilisateur_date_derniere_visite as date_derniere_visite', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => '25',
             ));
        $this->hasColumn('utilisateur_valide as valide', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('utilisateur_hash_validation as registration_hash', 'string', 40, array(
             'type' => 'string',
             'length' => '40',
             ));
        $this->hasColumn('utilisateur_hash_validation2 as validation_hash', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('utilisateur_ip as ip', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('utilisateur_titre as title', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('utilisateur_adresse as address', 'string', 80, array(
             'type' => 'string',
             'length' => '80',
             ));
        $this->hasColumn('utilisateur_latitude as latitude', 'decimal', 10, array(
             'type' => 'decimal',
             'length' => '10',
             'scale' => ' 6',
             ));
        $this->hasColumn('utilisateur_longitude as longitude', 'decimal', 10, array(
             'type' => 'decimal',
             'length' => '10',
             'scale' => ' 6',
             ));
        $this->hasColumn('utilisateur_nb_sanctions as nb_sanctions', 'integer', 1, array(
             'type' => 'integer',
             'length' => '1',
             ));
        $this->hasColumn('utilisateur_pourcentage as percentage', 'integer', 1, array(
             'type' => 'integer',
             'length' => '1',
             ));
        $this->hasColumn('utilisateur_afficher_mail as email_displayed', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('utilisateur_profession as job', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('utilisateur_date_naissance as birth_date', 'date', null, array(
             'type' => 'date',
             'notnull' => false,
             ));
        $this->hasColumn('utilisateur_site_web as website', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('utilisateur_localisation as localisation', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('utilisateur_afficher_pays as country_displayed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => '1',
             ));
        $this->hasColumn('utilisateur_biographie as biography', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('utilisateur_passions as hobbies', 'string', 60, array(
             'type' => 'string',
             'length' => '60',
             ));
        $this->hasColumn('utilisateur_citation as citation', 'string', 30, array(
             'type' => 'string',
             'length' => '30',
             ));
        $this->hasColumn('utilisateur_cle_pgp as pgk_key', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('utilisateur_derniere_lecture', 'timestamp', 25, array(
             'type' => 'timestamp',
             'notnull' => false,
             'length' => '25',
             ));
        $this->hasColumn('utilisateur_sexe as sexe', 'integer', 1, array(
             'type' => 'integer',
             'default' => 0,
             'length' => '1',
             ));
        $this->hasColumn('utilisateur_twitter as twitter', 'string', 128, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '128',
             ));
        $this->hasColumn('utilisateur_display_signature as display_signature', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 1,
             'notnull' => true,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Groupe', array(
             'local' => 'utilisateur_id_groupe',
             'foreign' => 'groupe_id'));

        $this->hasOne('UserPreference as Preferences', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('BannedEmail', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Online', array(
             'local' => 'utilisateur_id',
             'foreign' => 'user_id'));

        $this->hasMany('SecondaryGroup as SecondaryGroups', array(
             'local' => 'id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('UtilisateurIp', array(
             'local' => 'utilisateur_id',
             'foreign' => 'ip_id_utilisateur'));

        $this->hasMany('UserNewUsername', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('UserPunishment', array(
             'local' => 'utilisateur_id',
             'foreign' => 'user_id'));

        $this->hasMany('UserWarning', array(
             'local' => 'utilisateur_id',
             'foreign' => 'user_id'));

        $this->hasMany('ZformBackup', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Tentative', array(
             'local' => 'utilisateur_id',
             'foreign' => 'user'));

        $this->hasMany('Annonce', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Auteur', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('BlogAuteur', array(
             'local' => 'utilisateur_id',
             'foreign' => 'auteur_id_utilisateur'));

        $this->hasMany('Citation', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Dictee', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Dictee_Participation', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Don', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('EvolutionFeedback', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('ForumAlerte', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('ForumLunonlu', array(
             'local' => 'utilisateur_id',
             'foreign' => 'lunonlu_utilisateur_id'));

        $this->hasMany('ForumMessage', array(
             'local' => 'utilisateur_id',
             'foreign' => 'message_auteur'));

        $this->hasMany('ForumSujet', array(
             'local' => 'utilisateur_id',
             'foreign' => 'sujet_auteur'));

        $this->hasMany('ForumSondageVote', array(
             'local' => 'utilisateur_id',
             'foreign' => 'vote_membre_id'));

        $this->hasMany('HistoriqueGroupe', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Quiz', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('QuizQuestion', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('QuizScore', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('RecrutementCandidature', array(
             'local' => 'utilisateur_id',
             'foreign' => 'candidature_id_utilisateur'));

        $this->hasMany('RecrutementCommentaire', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('RecrutementLuNonLu', array(
             'local' => 'utilisateur_id',
             'foreign' => 'lunonlu_utilisateur_id'));

        $this->hasMany('RecrutementAvis', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Sondage', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('SondageVote', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Tag', array(
             'local' => 'utilisateur_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('File', array(
             'local' => 'utilisateur_id',
             'foreign' => 'user_id'));
    }
}
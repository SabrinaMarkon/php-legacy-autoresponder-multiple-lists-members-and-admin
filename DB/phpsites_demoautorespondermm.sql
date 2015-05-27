-- MySQL dump 10.13  Distrib 5.5.40, for Linux (x86_64)
--
-- Host: localhost    Database: phpsites_demoautorespondermm
-- ------------------------------------------------------
-- Server version	5.5.40-cll

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adminemail_saved`
--

DROP TABLE IF EXISTS `adminemail_saved`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminemail_saved` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `adbody` longtext NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `sendtopaid` varchar(4) NOT NULL DEFAULT 'no',
  `sendtofree` varchar(4) NOT NULL DEFAULT 'no',
  `sendtouserid` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminemail_saved`
--

LOCK TABLES `adminemail_saved` WRITE;
/*!40000 ALTER TABLE `adminemail_saved` DISABLE KEYS */;
/*!40000 ALTER TABLE `adminemail_saved` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adminemails`
--

DROP TABLE IF EXISTS `adminemails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminemails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `adbody` longtext NOT NULL,
  `url` varchar(255) NOT NULL,
  `clicks` int(10) unsigned NOT NULL,
  `sent` tinyint(4) NOT NULL,
  `datesent` int(10) unsigned NOT NULL,
  `sendtopaid` varchar(4) NOT NULL DEFAULT 'no',
  `sendtofree` varchar(4) NOT NULL DEFAULT 'no',
  `sendtouserid` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminemails`
--

LOCK TABLES `adminemails` WRITE;
/*!40000 ALTER TABLE `adminemails` DISABLE KEYS */;
/*!40000 ALTER TABLE `adminemails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adminnavigation`
--

DROP TABLE IF EXISTS `adminnavigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminnavigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adminnavtitle` varchar(255) NOT NULL,
  `adminnavurl` varchar(255) NOT NULL,
  `adminnavwindow` varchar(255) NOT NULL DEFAULT '_top',
  `adminnavenabled` varchar(4) NOT NULL DEFAULT 'yes',
  `adminnavsequence` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminnavigation`
--

LOCK TABLES `adminnavigation` WRITE;
/*!40000 ALTER TABLE `adminnavigation` DISABLE KEYS */;
INSERT INTO `adminnavigation` (`id`, `adminnavtitle`, `adminnavurl`, `adminnavwindow`, `adminnavenabled`, `adminnavsequence`) VALUES (27,'SITE GRAPHICS CONTROL','graphicscontrol.php','_top','yes',11),(26,'EDIT PROMOTIONAL ADS','editpromotional.php','_top','yes',10),(25,'TRANSACTIONS','transactions.php','_top','yes',9),(24,'CASH OUT REQUESTS','cashoutrequests.php','_top','yes',8),(23,'EMAIL MEMBERS','contactmembers.php','_top','yes',7),(22,'MEMBER ACCOUNTS','membercontrol.php','_top','yes',6),(21,'EMAIL SIGNUP FILTER','signupemailcontrol.php','_top','yes',5),(20,'AUTORESPONDER SETTINGS','autoresponder_control.php','_top','yes',4),(19,'SITE SETTINGS','sitecontrol.php','_top','yes',3),(18,'ADMIN MAIN','controlpanel.php','_top','yes',2),(17,'MAIN SITE','http://demoautorespondermm.phpsitescripts.com','_blank','yes',1),(28,'EDIT HTML LAYOUT','editlayout.php','_top','yes',12),(29,'EDIT MAIN PAGES CONTENT','editpages.php','_top','yes',13),(30,'ADD YOUR OWN PAGES','addpages.php','_top','yes',14),(31,'EDIT ADMIN NAVIGATION','editadminnavigation.php','_top','yes',15),(32,'EDIT MEMBER NAVIGATION','editmembernavigation.php','_top','yes',16),(33,'LOG OUT','index.php','_top','yes',15);
/*!40000 ALTER TABLE `adminnavigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adminnotes`
--

DROP TABLE IF EXISTS `adminnotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminnotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL DEFAULT '',
  `htmlcode` longtext NOT NULL,
  KEY `index` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminnotes`
--

LOCK TABLES `adminnotes` WRITE;
/*!40000 ALTER TABLE `adminnotes` DISABLE KEYS */;
INSERT INTO `adminnotes` (`id`, `name`, `htmlcode`) VALUES (1,'Admin Notes','');
/*!40000 ALTER TABLE `adminnotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adminpromotional`
--

DROP TABLE IF EXISTS `adminpromotional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminpromotional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'banner',
  `promotionalimage` varchar(255) NOT NULL,
  `promotionalsubject` varchar(255) NOT NULL,
  `promotionaladbody` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminpromotional`
--

LOCK TABLES `adminpromotional` WRITE;
/*!40000 ALTER TABLE `adminpromotional` DISABLE KEYS */;
/*!40000 ALTER TABLE `adminpromotional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adminsettings`
--

DROP TABLE IF EXISTS `adminsettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminsettings` (
  `name` varchar(255) NOT NULL,
  `setting` varchar(255) NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminsettings`
--

LOCK TABLES `adminsettings` WRITE;
/*!40000 ALTER TABLE `adminsettings` DISABLE KEYS */;
INSERT INTO `adminsettings` (`name`, `setting`) VALUES ('row1','x'),('adminuserid','Admin'),('adminpassword','admin'),('adminmemberuserid','programmer_account'),('adminname','Admin Name'),('domain','http://demoautorespondermm.phpsitescripts.com'),('sitename','Autoresponder Member Multi-list Demo'),('adminemail','Admin Email'),('egopay_store_id',''),('egopay_store_password',''),('adminpayza',''),('adminpayzaseccode',''),('adminperfectmoney',''),('adminperfectmoneyalternatepassphrase',''),('adminokpay',''),('adminsolidtrustpay',''),('adminpaypal','sales@phpsitescripts.com'),('emailsignupmethod','denyallexcept'),('turingkeyenable','no'),('joinprice','5.00'),('joinpriceinterval','Monthly'),('level1name','Free'),('level2name','Upgraded'),('upgradecommissionfree','0.00'),('upgradecommissionpaid','0.00'),('minimumpayout','1.00'),('enableautodowngrade','yes'),('autodowngradeafterhowmanydayslatepay','5'),('ar_howmanylistspaid','Infinite'),('ar_howmanylistsfree','1'),('ar_howmanyprospectsperlistpaid','Infinite'),('ar_howmanyprospectsperlistfree','200'),('ar_maxprospectsmailedperlistpaid','Infinite'),('ar_maxprospectsmailedperlistfree','200'),('ar_maxautoresponderemailspaid','Infinite'),('ar_maxautoresponderemailsfree','2'),('ar_bouncestoautounsubscribepaid','5'),('ar_bouncestoautounsubscribefree','2'),('ar_defaultredirecturlaftersubscribeformsubmission','http://phpsitescripts.com'),('ar_defaultredirecturlafterclickingaremaillink','http://phpsitescripts.com'),('ar_defaultredirecturlafterverification','http://phpsitescripts.com'),('ar_bounceemail','bounce@phpsitescripts.com'),('editpageshtmleditor','yes');
/*!40000 ALTER TABLE `adminsettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponder_directmail`
--

DROP TABLE IF EXISTS `autoresponder_directmail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponder_directmail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `fromfield` varchar(255) NOT NULL,
  `fromemail` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `adbodyhtml` longtext NOT NULL,
  `adbodytext` longtext NOT NULL,
  `url` varchar(255) NOT NULL,
  `disclaimerbodyhtml` longtext NOT NULL,
  `disclaimerbodytext` longtext NOT NULL,
  `headerbodyhtml` longtext NOT NULL,
  `headerbodytext` longtext NOT NULL,
  `sendtoprospectlists` text NOT NULL,
  `clicks` int(10) unsigned NOT NULL,
  `sent` tinyint(4) NOT NULL,
  `datesent` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponder_directmail`
--

LOCK TABLES `autoresponder_directmail` WRITE;
/*!40000 ALTER TABLE `autoresponder_directmail` DISABLE KEYS */;
/*!40000 ALTER TABLE `autoresponder_directmail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponder_directmail_saved`
--

DROP TABLE IF EXISTS `autoresponder_directmail_saved`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponder_directmail_saved` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `fromfield` varchar(255) NOT NULL,
  `fromemail` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `adbodyhtml` longtext NOT NULL,
  `adbodytext` longtext NOT NULL,
  `url` varchar(255) NOT NULL,
  `disclaimerbodyhtml` longtext NOT NULL,
  `disclaimerbodytext` longtext NOT NULL,
  `headerbodyhtml` longtext NOT NULL,
  `headerbodytext` longtext NOT NULL,
  `sendtoprospectlists` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponder_directmail_saved`
--

LOCK TABLES `autoresponder_directmail_saved` WRITE;
/*!40000 ALTER TABLE `autoresponder_directmail_saved` DISABLE KEYS */;
/*!40000 ALTER TABLE `autoresponder_directmail_saved` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponder_reminders`
--

DROP TABLE IF EXISTS `autoresponder_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponder_reminders` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `reminderenabled` varchar(4) NOT NULL DEFAULT 'yes',
  `remindertitle` varchar(255) NOT NULL,
  `remindermessage` longtext NOT NULL,
  `remindersubject` varchar(255) NOT NULL DEFAULT '',
  `reminderfromfield` varchar(255) NOT NULL DEFAULT '',
  `reminderurl` varchar(255) NOT NULL,
  `remindereventstart` datetime NOT NULL,
  `remindereventend` datetime NOT NULL,
  `remindertime` datetime NOT NULL,
  `reminderhowmanytimes` int(10) unsigned NOT NULL DEFAULT '1',
  `reminderhowmanytimesinterval` int(10) unsigned NOT NULL DEFAULT '24',
  `reminderlastsent` datetime NOT NULL,
  `remindernextsent` datetime NOT NULL,
  `totalmailed` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponder_reminders`
--

LOCK TABLES `autoresponder_reminders` WRITE;
/*!40000 ALTER TABLE `autoresponder_reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `autoresponder_reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponder_substitution_variables`
--

DROP TABLE IF EXISTS `autoresponder_substitution_variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponder_substitution_variables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `variablename` varchar(255) NOT NULL,
  `variablevalue` varchar(255) NOT NULL,
  `variabledescription` varchar(255) NOT NULL,
  `variabletype` varchar(255) NOT NULL DEFAULT 'system',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponder_substitution_variables`
--

LOCK TABLES `autoresponder_substitution_variables` WRITE;
/*!40000 ALTER TABLE `autoresponder_substitution_variables` DISABLE KEYS */;
INSERT INTO `autoresponder_substitution_variables` (`id`, `userid`, `variablename`, `variablevalue`, `variabledescription`, `variabletype`) VALUES (1,'','~FIRSTNAME~','firstname','Recipient First Name','system'),(2,'','~LASTNAME~','lastname','Recipient Last Name','system'),(3,'','~EMAIL~','email','Recipient Email Address','system'),(4,'','~HOW_FOUND~','howfound','How Recipient Found Your AutoResponder Signup Page','system'),(5,'','~REFERRING_PAGE~','referringpage','Website URL that Referred the Recipient to your AutoResponder (if available)','system'),(6,'','~DAYS_SUBSCRIBED~','howmanydays','Number of Days since Recipient Subscribed to your AutoResponder','system'),(7,'','~SIGNUP_DATE~','signupdate','Date Recipient Subscribed to your AutoResponder','system'),(8,'','~SIGNUP_IP~','signupip','IP Address of Recipient when they Subscribed to your AutoResponder','system'),(9,'','~MAILING_LIST_NAME~','listname','Name of your Mailing List AutoResponder that Recipient is Subscribed to','system'),(10,'','~BOUNCE_COUNT~','bounces','How many times the Recipient\'s Email Address has Bounced in Response to your AutoResponder Emails','system'),(11,'','~BOUNCE_LAST_DATE~','bouncelastdate','Date Recipient\'s Email Address last Bounced in response to email from your AutoResponder','system'),(12,'','~BOUNCE_LAST_ERROR~','bouncelasterror','Last Bounce Error Received from Recipient\'s Email Address in response to email from your AutoResponder','system'),(13,'demomember','~TESTING_NEW_TAG~','testing new tag','','member');
/*!40000 ALTER TABLE `autoresponder_substitution_variables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponder_userfields`
--

DROP TABLE IF EXISTS `autoresponder_userfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponder_userfields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `fieldname` varchar(255) NOT NULL,
  `fieldtitle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponder_userfields`
--

LOCK TABLES `autoresponder_userfields` WRITE;
/*!40000 ALTER TABLE `autoresponder_userfields` DISABLE KEYS */;
INSERT INTO `autoresponder_userfields` (`id`, `userid`, `fieldname`, `fieldtitle`) VALUES (1,'demomember','testfield','field to test custom form fields in AR signup forms');
/*!40000 ALTER TABLE `autoresponder_userfields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponder_userfields_data`
--

DROP TABLE IF EXISTS `autoresponder_userfields_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponder_userfields_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `prospectid` bigint(255) unsigned NOT NULL,
  `fieldname` varchar(255) NOT NULL,
  `fieldvalue` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponder_userfields_data`
--

LOCK TABLES `autoresponder_userfields_data` WRITE;
/*!40000 ALTER TABLE `autoresponder_userfields_data` DISABLE KEYS */;
INSERT INTO `autoresponder_userfields_data` (`id`, `userid`, `prospectid`, `fieldname`, `fieldvalue`) VALUES (1,'demomember',1,'testfield','stuff entered in custom field');
/*!40000 ALTER TABLE `autoresponder_userfields_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponder_userfields_forms`
--

DROP TABLE IF EXISTS `autoresponder_userfields_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponder_userfields_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `listnameid` bigint(255) unsigned NOT NULL,
  `fieldname` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'system',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponder_userfields_forms`
--

LOCK TABLES `autoresponder_userfields_forms` WRITE;
/*!40000 ALTER TABLE `autoresponder_userfields_forms` DISABLE KEYS */;
INSERT INTO `autoresponder_userfields_forms` (`id`, `userid`, `listnameid`, `fieldname`, `type`) VALUES (5,'demomember',1,'firstname','system'),(6,'demomember',1,'lastname','system'),(7,'demomember',1,'email','system'),(8,'demomember',1,'testfield','member');
/*!40000 ALTER TABLE `autoresponder_userfields_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponders`
--

DROP TABLE IF EXISTS `autoresponders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `autoresponderenabled` varchar(4) NOT NULL DEFAULT 'yes',
  `autoresponderfromemail` varchar(255) NOT NULL,
  `autorespondertitle` varchar(255) NOT NULL,
  `autorespondermessagehtml` longtext NOT NULL,
  `autorespondermessagetext` longtext NOT NULL,
  `autorespondersubject` varchar(255) NOT NULL DEFAULT '',
  `autoresponderfromfield` varchar(255) NOT NULL DEFAULT '',
  `autoresponderdays` int(10) unsigned NOT NULL DEFAULT '0',
  `sendtoprospectlists` text NOT NULL,
  `totalmailed` int(10) unsigned NOT NULL DEFAULT '0',
  `totalclicked` int(10) unsigned NOT NULL DEFAULT '0',
  `emailclick_redirecturl` varchar(255) NOT NULL,
  `disclaimerbodyhtml` longtext NOT NULL,
  `disclaimerbodytext` longtext NOT NULL,
  `headerbodyhtml` longtext NOT NULL,
  `headerbodytext` longtext NOT NULL,
  `liststosubscribetoaftersendingthismessage` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponders`
--

LOCK TABLES `autoresponders` WRITE;
/*!40000 ALTER TABLE `autoresponders` DISABLE KEYS */;
/*!40000 ALTER TABLE `autoresponders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponders_lists`
--

DROP TABLE IF EXISTS `autoresponders_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponders_lists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `listname` varchar(255) NOT NULL,
  `submitform_redirecturl` varchar(255) NOT NULL,
  `verification_redirecturl` varchar(255) NOT NULL,
  `verificationheaderbodyhtml` longtext NOT NULL,
  `verificationheaderbodytext` longtext NOT NULL,
  `verificationmessagehtml` longtext NOT NULL,
  `verificationmessagetext` longtext NOT NULL,
  `verificationsubject` varchar(255) NOT NULL DEFAULT '',
  `verificationfromfield` varchar(255) NOT NULL DEFAULT '',
  `verificationdisclaimerbodyhtml` longtext NOT NULL,
  `verificationdisclaimerbodytext` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponders_lists`
--

LOCK TABLES `autoresponders_lists` WRITE;
/*!40000 ALTER TABLE `autoresponders_lists` DISABLE KEYS */;
INSERT INTO `autoresponders_lists` (`id`, `userid`, `listname`, `submitform_redirecturl`, `verification_redirecturl`, `verificationheaderbodyhtml`, `verificationheaderbodytext`, `verificationmessagehtml`, `verificationmessagetext`, `verificationsubject`, `verificationfromfield`, `verificationdisclaimerbodyhtml`, `verificationdisclaimerbodytext`) VALUES (1,'demomember','Test AR Mailing List','http://www.sunshinehosting.net','http://www.pearlsofwealth.com','<p><span style=\"color:#FF0000\"><strong>Testing AR verfiication mailing list HEADER</strong></span></p>\r\n\r\n<p><span style=\"color:#FF0000\"><strong>~TESTING_NEW_TAG~</strong></span></p>\r\n\r\n<p><span style=\"color:#FF0000\"><strong>The above tag should be replaced by the substitution value &quot;testing new tag&quot;</strong></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>ad for email header</p>\r\n\r\n<p>ads for email header</p>\r\n','plain text header\r\n~TESTING_NEW_TAG~\r\n\r\nad for email header','<p><span style=\"color:#0000CD\"><strong>Testing AR verfiication mailing list BODY</strong></span></p>\r\n\r\n<p><span style=\"color:#0000CD\"><strong>~TESTING_NEW_TAG~</strong></span></p>\r\n\r\n<p><span style=\"color:#0000CD\"><strong>The above tag should be replaced by the substitution value &quot;testing new tag&quot;</strong></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>ads for email body</p>\r\n\r\n<p>ads for email body</p>\r\n','plain text body\r\n~TESTING_NEW_TAG~\r\n\r\nads for email body','Hi ~FIRSTNAME~ Testing AR Mailing List','My Test AR','<p><span style=\"color:#008000\"><strong>Testing AR verfiication mailing list DISCLAIMER</strong></span></p>\r\n\r\n<p><span style=\"color:#008000\"><strong>~TESTING_NEW_TAG~</strong></span></p>\r\n\r\n<p><span style=\"color:#008000\"><strong>The above tag should be replaced by the substitution value &quot;testing new tag&quot;</strong></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>disclaimer message and maybe a footer ad</p>\r\n\r\n<p>disclaimer message and maybe a footer ad</p>\r\n\r\n<p>&nbsp;</p>\r\n','plain text disclaimer\r\n~TESTING_NEW_TAG~\r\n\r\n~FIRSTNAME~\r\n\r\ndisclaimer message and maybe a footer ad');
/*!40000 ALTER TABLE `autoresponders_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoresponders_prospects`
--

DROP TABLE IF EXISTS `autoresponders_prospects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autoresponders_prospects` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL DEFAULT '',
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `howfound` varchar(255) NOT NULL DEFAULT '',
  `referringpage` varchar(255) NOT NULL DEFAULT '',
  `howmanydays` int(10) unsigned NOT NULL DEFAULT '0',
  `signupdate` datetime NOT NULL,
  `signupip` varchar(255) NOT NULL,
  `listname` varchar(255) NOT NULL DEFAULT '',
  `verifiedcode` varchar(255) NOT NULL,
  `verified` varchar(4) NOT NULL DEFAULT 'no',
  `verifieddate` datetime NOT NULL,
  `verifiedip` varchar(255) NOT NULL,
  `bounces` int(10) unsigned NOT NULL DEFAULT '0',
  `bouncelastdate` datetime NOT NULL,
  `bouncelasterror` longtext NOT NULL,
  `vacation` varchar(4) NOT NULL DEFAULT 'no',
  `vacationdate` datetime NOT NULL,
  `unsubscribed` varchar(4) NOT NULL DEFAULT 'no',
  `unsubscribedate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoresponders_prospects`
--

LOCK TABLES `autoresponders_prospects` WRITE;
/*!40000 ALTER TABLE `autoresponders_prospects` DISABLE KEYS */;
INSERT INTO `autoresponders_prospects` (`id`, `userid`, `firstname`, `lastname`, `email`, `howfound`, `referringpage`, `howmanydays`, `signupdate`, `signupip`, `listname`, `verifiedcode`, `verified`, `verifieddate`, `verifiedip`, `bounces`, `bouncelastdate`, `bouncelasterror`, `vacation`, `vacationdate`, `unsubscribed`, `unsubscribedate`) VALUES (1,'demomember','test','signup','webmaster@pearlsofwealth.com','','',0,'2014-09-24 17:15:51','68.146.236.220','Test AR Mailing List','f62033b0','yes','2014-09-24 18:22:30','68.146.236.220',0,'0000-00-00 00:00:00','','no','0000-00-00 00:00:00','no','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `autoresponders_prospects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashoutrequests`
--

DROP TABLE IF EXISTS `cashoutrequests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cashoutrequests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `egopay` varchar(255) NOT NULL,
  `payza` varchar(255) NOT NULL,
  `perfectmoney` varchar(255) NOT NULL,
  `okpay` varchar(255) NOT NULL,
  `solidtrustpay` varchar(255) NOT NULL,
  `paypal` varchar(255) NOT NULL,
  `amountrequested` decimal(9,2) NOT NULL DEFAULT '0.00',
  `daterequested` datetime NOT NULL,
  `paid` decimal(9,2) NOT NULL,
  `lastpaid` datetime NOT NULL,
  `preferredpaymentprocessor` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashoutrequests`
--

LOCK TABLES `cashoutrequests` WRITE;
/*!40000 ALTER TABLE `cashoutrequests` DISABLE KEYS */;
/*!40000 ALTER TABLE `cashoutrequests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(64) NOT NULL DEFAULT '',
  `iso_code2` char(2) NOT NULL DEFAULT '',
  `iso_code3` char(3) NOT NULL DEFAULT '',
  `reserved1` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`country_id`),
  KEY `IDX_COUNTRIES_NAME` (`country_name`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) VALUES (1,'Afghanistan','AF','AFG',0),(2,'Albania','AL','ALB',0),(3,'Algeria','DZ','DZA',0),(4,'American Samoa','AS','ASM',0),(5,'Andorra','AD','AND',0),(6,'Angola','AO','AGO',0),(7,'Anguilla','AI','AIA',0),(8,'Antarctica','AQ','ATA',0),(9,'Antigua and Barbuda','AG','ATG',0),(10,'Argentina','AR','ARG',0),(11,'Armenia','AM','ARM',0),(12,'Aruba','AW','ABW',0),(13,'Australia','AU','AUS',0),(14,'Austria','AT','AUT',0),(15,'Azerbaijan','AZ','AZE',0),(16,'Bahamas','BS','BHS',0),(17,'Bahrain','BH','BHR',0),(18,'Bangladesh','BD','BGD',0),(19,'Barbados','BB','BRB',0),(20,'Belarus','BY','BLR',0),(21,'Belgium','BE','BEL',0),(22,'Belize','BZ','BLZ',0),(23,'Benin','BJ','BEN',0),(24,'Bermuda','BM','BMU',0),(25,'Bhutan','BT','BTN',0),(26,'Bolivia','BO','BOL',0),(27,'Bosnia and Herzegowina','BA','BIH',0),(28,'Botswana','BW','BWA',0),(29,'Bouvet Island','BV','BVT',0),(30,'Brazil','BR','BRA',0),(31,'British Indian Ocean Territory','IO','IOT',0),(32,'Brunei Darussalam','BN','BRN',0),(33,'Bulgaria','BG','BGR',0),(34,'Burkina Faso','BF','BFA',0),(35,'Burundi','BI','BDI',0),(36,'Cambodia','KH','KHM',0),(37,'Cameroon','CM','CMR',0),(38,'Canada','CA','CAN',0),(39,'Cape Verde','CV','CPV',0),(40,'Cayman Islands','KY','CYM',0),(41,'Central African Republic','CF','CAF',0),(42,'Chad','TD','TCD',0),(43,'Chile','CL','CHL',0),(44,'China','CN','CHN',0),(45,'Christmas Island','CX','CXR',0),(46,'Cocos (Keeling) Islands','CC','CCK',0),(47,'Colombia','CO','COL',0),(48,'Comoros','KM','COM',0),(49,'Congo','CG','COG',0),(50,'Cook Islands','CK','COK',0),(51,'Costa Rica','CR','CRI',0),(52,'Cote D\'Ivoire','CI','CIV',0),(53,'Croatia','HR','HRV',0),(54,'Cuba','CU','CUB',0),(55,'Cyprus','CY','CYP',0),(56,'Czech Republic','CZ','CZE',0),(57,'Denmark','DK','DNK',0),(58,'Djibouti','DJ','DJI',0),(59,'Dominica','DM','DMA',0),(60,'Dominican Republic','DO','DOM',0),(61,'East Timor','TP','TMP',0),(62,'Ecuador','EC','ECU',0),(63,'Egypt','EG','EGY',0),(64,'El Salvador','SV','SLV',0),(65,'Equatorial Guinea','GQ','GNQ',0),(66,'Eritrea','ER','ERI',0),(67,'Estonia','EE','EST',0),(68,'Ethiopia','ET','ETH',0),(69,'Falkland Islands (Malvinas)','FK','FLK',0),(70,'Faroe Islands','FO','FRO',0),(71,'Fiji','FJ','FJI',0),(72,'Finland','FI','FIN',0),(73,'France','FR','FRA',0),(74,'France, Metropolitan','FX','FXX',0),(75,'French Guiana','GF','GUF',0),(76,'French Polynesia','PF','PYF',0),(77,'French Southern Territories','TF','ATF',0),(78,'Gabon','GA','GAB',0),(79,'Gambia','GM','GMB',0),(80,'Georgia','GE','GEO',0),(81,'Germany','DE','DEU',0),(82,'Ghana','GH','GHA',0),(83,'Gibraltar','GI','GIB',0),(84,'Greece','GR','GRC',0),(85,'Greenland','GL','GRL',0),(86,'Grenada','GD','GRD',0),(87,'Guadeloupe','GP','GLP',0),(88,'Guam','GU','GUM',0),(89,'Guatemala','GT','GTM',0),(90,'Guinea','GN','GIN',0),(91,'Guinea-bissau','GW','GNB',0),(92,'Guyana','GY','GUY',0),(93,'Haiti','HT','HTI',0),(94,'Heard and Mc Donald Islands','HM','HMD',0),(95,'Honduras','HN','HND',0),(96,'Hong Kong','HK','HKG',0),(97,'Hungary','HU','HUN',0),(98,'Iceland','IS','ISL',0),(99,'India','IN','IND',0),(100,'Indonesia','ID','IDN',0),(101,'Iran (Islamic Republic of)','IR','IRN',0),(102,'Iraq','IQ','IRQ',0),(103,'Ireland','IE','IRL',0),(104,'Israel','IL','ISR',0),(105,'Italy','IT','ITA',0),(106,'Jamaica','JM','JAM',0),(107,'Japan','JP','JPN',0),(108,'Jordan','JO','JOR',0),(109,'Kazakhstan','KZ','KAZ',0),(110,'Kenya','KE','KEN',0),(111,'Kiribati','KI','KIR',0),(112,'Korea','KP','PRK',0),(114,'Kuwait','KW','KWT',0),(115,'Kyrgyzstan','KG','KGZ',0),(116,'Lao People\'s Democratic Republic','LA','LAO',0),(117,'Latvia','LV','LVA',0),(118,'Lebanon','LB','LBN',0),(119,'Lesotho','LS','LSO',0),(120,'Liberia','LR','LBR',0),(121,'Libyan Arab Jamahiriya','LY','LBY',0),(122,'Liechtenstein','LI','LIE',0),(123,'Lithuania','LT','LTU',0),(124,'Luxembourg','LU','LUX',0),(125,'Macau','MO','MAC',0),(126,'Macedonia','MK','MKD',0),(127,'Madagascar','MG','MDG',0),(128,'Malawi','MW','MWI',0),(129,'Malaysia','MY','MYS',0),(130,'Maldives','MV','MDV',0),(131,'Mali','ML','MLI',0),(132,'Malta','MT','MLT',0),(133,'Marshall Islands','MH','MHL',0),(134,'Martinique','MQ','MTQ',0),(135,'Mauritania','MR','MRT',0),(136,'Mauritius','MU','MUS',0),(137,'Mayotte','YT','MYT',0),(138,'Mexico','MX','MEX',0),(139,'Micronesia, Federated States of','FM','FSM',0),(140,'Moldova, Republic of','MD','MDA',0),(141,'Monaco','MC','MCO',0),(142,'Mongolia','MN','MNG',0),(143,'Montserrat','MS','MSR',0),(144,'Morocco','MA','MAR',0),(145,'Mozambique','MZ','MOZ',0),(146,'Myanmar','MM','MMR',0),(147,'Namibia','NA','NAM',0),(148,'Nauru','NR','NRU',0),(149,'Nepal','NP','NPL',0),(150,'Netherlands','NL','NLD',0),(151,'Netherlands Antilles','AN','ANT',0),(152,'New Caledonia','NC','NCL',0),(153,'New Zealand','NZ','NZL',0),(154,'Nicaragua','NI','NIC',0),(155,'Niger','NE','NER',0),(156,'Nigeria','NG','NGA',0),(157,'Niue','NU','NIU',0),(158,'Norfolk Island','NF','NFK',0),(159,'Northern Mariana Islands','MP','MNP',0),(160,'Norway','NO','NOR',0),(161,'Oman','OM','OMN',0),(162,'Pakistan','PK','PAK',0),(163,'Palau','PW','PLW',0),(164,'Panama','PA','PAN',0),(165,'Papua New Guinea','PG','PNG',0),(166,'Paraguay','PY','PRY',0),(167,'Peru','PE','PER',0),(168,'Philippines','PH','PHL',0),(169,'Pitcairn','PN','PCN',0),(170,'Poland','PL','POL',0),(171,'Portugal','PT','PRT',0),(172,'Puerto Rico','PR','PRI',0),(173,'Qatar','QA','QAT',0),(174,'Reunion','RE','REU',0),(175,'Romania','RO','ROM',0),(176,'Russian Federation','RU','RUS',0),(177,'Rwanda','RW','RWA',0),(178,'Saint Kitts and Nevis','KN','KNA',0),(179,'Saint Lucia','LC','LCA',0),(180,'Saint Vincent and the Grenadines','VC','VCT',0),(181,'Samoa','WS','WSM',0),(182,'San Marino','SM','SMR',0),(183,'Sao Tome and Principe','ST','STP',0),(184,'Saudi Arabia','SA','SAU',0),(185,'Senegal','SN','SEN',0),(186,'Seychelles','SC','SYC',0),(187,'Sierra Leone','SL','SLE',0),(188,'Singapore','SG','SGP',0),(189,'Slovakia (Slovak Republic)','SK','SVK',0),(190,'Slovenia','SI','SVN',0),(191,'Solomon Islands','SB','SLB',0),(192,'Somalia','SO','SOM',0),(193,'South Africa','ZA','ZAF',0),(194,'South Georgia','GS','SGS',0),(195,'Spain','ES','ESP',0),(196,'Sri Lanka','LK','LKA',0),(197,'St. Helena','SH','SHN',0),(198,'St. Pierre and Miquelon','PM','SPM',0),(199,'Sudan','SD','SDN',0),(200,'Suriname','SR','SUR',0),(201,'Svalbard and Jan Mayen Islands','SJ','SJM',0),(202,'Swaziland','SZ','SWZ',0),(203,'Sweden','SE','SWE',0),(204,'Switzerland','CH','CHE',0),(205,'Syrian Arab Republic','SY','SYR',0),(206,'Taiwan','TW','TWN',0),(207,'Tajikistan','TJ','TJK',0),(208,'Tanzania, United Republic of','TZ','TZA',0),(209,'Thailand','TH','THA',0),(210,'Togo','TG','TGO',0),(211,'Tokelau','TK','TKL',0),(212,'Tonga','TO','TON',0),(213,'Trinidad and Tobago','TT','TTO',0),(214,'Tunisia','TN','TUN',0),(215,'Turkey','TR','TUR',0),(216,'Turkmenistan','TM','TKM',0),(217,'Turks and Caicos Islands','TC','TCA',0),(218,'Tuvalu','TV','TUV',0),(219,'Uganda','UG','UGA',0),(220,'Ukraine','UA','UKR',0),(221,'United Arab Emirates','AE','ARE',0),(222,'United Kingdom','GB','GBR',0),(223,'United States','US','USA',0),(224,'United States Minor Outlying Islands','UM','UMI',0),(225,'Uruguay','UY','URY',0),(226,'Uzbekistan','UZ','UZB',0),(227,'Vanuatu','VU','VUT',0),(228,'Vatican City State (Holy See)','VA','VAT',0),(229,'Venezuela','VE','VEN',0),(230,'Viet Nam','VN','VNM',0),(231,'Virgin Islands (British)','VG','VGB',0),(232,'Virgin Islands (U.S.)','VI','VIR',0),(233,'Wallis and Futuna Islands','WF','WLF',0),(234,'Western Sahara','EH','ESH',0),(235,'Yemen','YE','YEM',0),(236,'Yugoslavia','YU','YUG',0),(237,'Zaire','ZR','ZAR',0),(238,'Zambia','ZM','ZMB',0),(239,'Zimbabwe','ZW','ZWE',0);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emailsignupcontrol`
--

DROP TABLE IF EXISTS `emailsignupcontrol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emailsignupcontrol` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `emaildomain` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emailsignupcontrol`
--

LOCK TABLES `emailsignupcontrol` WRITE;
/*!40000 ALTER TABLE `emailsignupcontrol` DISABLE KEYS */;
/*!40000 ALTER TABLE `emailsignupcontrol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membernavigation`
--

DROP TABLE IF EXISTS `membernavigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membernavigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membernavtitle` varchar(255) NOT NULL,
  `membernavurl` varchar(255) NOT NULL,
  `membernavwindow` varchar(255) NOT NULL DEFAULT '_top',
  `membernavenabled` varchar(4) NOT NULL DEFAULT 'yes',
  `membernavsequence` int(10) unsigned NOT NULL,
  `membernavallowedlevels` varchar(12) NOT NULL DEFAULT 'ALL',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membernavigation`
--

LOCK TABLES `membernavigation` WRITE;
/*!40000 ALTER TABLE `membernavigation` DISABLE KEYS */;
INSERT INTO `membernavigation` (`id`, `membernavtitle`, `membernavurl`, `membernavwindow`, `membernavenabled`, `membernavsequence`, `membernavallowedlevels`) VALUES (16,'SUPPORT','Admin Helpdesk URL','_blank','yes',7,'ALL'),(15,'REQUEST CASH OUT','requestcashout.php','_top','yes',6,'PAID'),(14,'PROMOTE','promote.php','_top','yes',5,'ALL'),(13,'PROFILE','profile.php','_top','yes',4,'ALL'),(12,'AUTORESPONDER SYSTEM','your_autoresponder_system.php','_top','yes',3,'ALL'),(10,'MAIN','members.php','_top','yes',1,'ALL'),(11,'UPGRADE','upgrade.php','_top','yes',2,'FREE'),(17,'DELETE ACCOUNT','delete.php','_top','yes',8,'ALL'),(18,'LOG OUT','logout.php','_top','yes',9,'ALL'),(19,'GET A SITE LIKE THIS','http://demoautorespondermm.phpsitescripts.com','_blank','yes',10,'ALL');
/*!40000 ALTER TABLE `membernavigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `accounttype` varchar(255) NOT NULL DEFAULT 'FREE',
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `egopay` varchar(255) NOT NULL,
  `payza` varchar(255) NOT NULL,
  `perfectmoney` varchar(255) NOT NULL DEFAULT '',
  `okpay` varchar(255) NOT NULL DEFAULT '',
  `solidtrustpay` varchar(255) NOT NULL DEFAULT '',
  `paypal` varchar(255) NOT NULL DEFAULT '',
  `transaction` varchar(255) NOT NULL DEFAULT '',
  `paychoice` varchar(255) NOT NULL DEFAULT '',
  `signupdate` datetime NOT NULL,
  `signupip` varchar(255) NOT NULL,
  `verified` varchar(4) NOT NULL DEFAULT 'no',
  `verifieddate` datetime NOT NULL,
  `verifycode` varchar(255) NOT NULL,
  `referid` varchar(255) NOT NULL,
  `lastlogin` datetime NOT NULL,
  `commission` decimal(9,2) NOT NULL DEFAULT '0.00',
  `commissionlastpaid` datetime NOT NULL,
  `membershiplastpaid` varchar(255) NOT NULL,
  `membershipnextpaid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` (`id`, `userid`, `password`, `accounttype`, `firstname`, `lastname`, `country`, `email`, `egopay`, `payza`, `perfectmoney`, `okpay`, `solidtrustpay`, `paypal`, `transaction`, `paychoice`, `signupdate`, `signupip`, `verified`, `verifieddate`, `verifycode`, `referid`, `lastlogin`, `commission`, `commissionlastpaid`, `membershiplastpaid`, `membershipnextpaid`) VALUES (1,'demomember','demopass','FREE','Demo','Member','Canada','webmaster@pearlsofwealth.com','','','','','','','','','2014-09-23 01:14:03','68.146.236.220','yes','2014-09-23 01:14:30','1411456443','programmer_account','2015-02-24 09:26:27',0.00,'0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `htmlcode` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `name`, `htmlcode`) VALUES (1,'Home Page','testing editor'),(2,'Login Page',''),(3,'Registration Page',''),(4,'Terms and Conditions',''),(5,'Members Area Main Page',''),(6,'Members Area Profile Page',''),(7,'Members Area Promotion Page',''),(8,'Members Area Upgrade Page',''),(9,'Request Cash Out Page',''),(10,'Thank You Page - New Member Signup',''),(11,'Thank You Page - Member Upgraded',''),(12,'Thank You Page - Member Upgrade Renewed',''),(13,'Members Area - Autoresponder Introductory Page',''),(14,'Members Area - Autoresponder Create Mailing Lists Page',''),(15,'Members Area - Autoresponder Mailing Lists Page',''),(16,'Members Area - Autoresponder Create Campaigns Page',''),(17,'Members Area - Autoresponder Campaigns Page',''),(18,'Members Area - Autoresponder Prospects Page',''),(19,'Members Area - Autoresponder Direct Mailout Page',''),(20,'Members Area - Autoresponder Reminders Page',''),(21,'Members Area - Autoresponder Bounced Email Viewer Page',''),(22,'Members Area - Autoresponder Mail Merge Substitution Page',''),(23,'Members Area - Autoresponder Unsubscribed Propects Page','');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagesdynamic`
--

DROP TABLE IF EXISTS `pagesdynamic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagesdynamic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `htmlcode` longtext NOT NULL,
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagesdynamic`
--

LOCK TABLES `pagesdynamic` WRITE;
/*!40000 ALTER TABLE `pagesdynamic` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagesdynamic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payouts`
--

DROP TABLE IF EXISTS `payouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `paid` decimal(9,2) NOT NULL,
  `datepaid` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payouts`
--

LOCK TABLES `payouts` WRITE;
/*!40000 ALTER TABLE `payouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `payouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `transaction` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `paymentdate` datetime NOT NULL,
  `amountreceived` decimal(9,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'phpsites_demoautorespondermm'
--

--
-- Dumping routines for database 'phpsites_demoautorespondermm'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-30  9:49:23

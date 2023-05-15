-- MariaDB dump 10.19  Distrib 10.4.20-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: yaemkvbzpa
-- ------------------------------------------------------
-- Server version	10.4.20-MariaDB-1:10.4.20+maria~buster-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `balancesheet`
--

DROP TABLE IF EXISTS `balancesheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balancesheet` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balancesheet`
--

LOCK TABLES `balancesheet` WRITE;
/*!40000 ALTER TABLE `balancesheet` DISABLE KEYS */;
INSERT INTO `balancesheet` VALUES (1,1,'{\"result\":{\"code\":\"CF-12805\",\"extraMessage\":\"\",\"message\":\"미등록+인증서입니다.+확인+후+거래하시기+바랍니다.\",\"transactionId\":\"642e367728e600dbc0438229\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-12041\",\"extraMessage\":\"\",\"message\":\"이용+가능+시간이+아닙니다.\",\"transactionId\":\"6432eac9ec827e122b13b56d\"},\"data\":{}}'),(3,2,'{\"result\":{\"code\":\"CF-00001\",\"extraMessage\":\"certFile\",\"message\":\"필수+입력+파라미터가+누락되었습니다.\",\"transactionId\":\"6432fd37ec82c3bec4e148a0\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-04023\",\"extraMessage\":\"\",\"message\":\"인증서+파일(der)+변환에+실패했습니다.+인증서와+비밀번호+정보가+올바른지+확인하세요.\",\"transactionId\":\"643438faec827e122b13b87f\"},\"data\":{}}');
/*!40000 ALTER TABLE `balancesheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `businessincome`
--

DROP TABLE IF EXISTS `businessincome`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `businessincome` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `businessincome`
--

LOCK TABLES `businessincome` WRITE;
/*!40000 ALTER TABLE `businessincome` DISABLE KEYS */;
INSERT INTO `businessincome` VALUES (1,1,'{\"result\":{\"code\":\"CF-12805\",\"extraMessage\":\"\",\"message\":\"미등록+인증서입니다.+확인+후+거래하시기+바랍니다.\",\"transactionId\":\"642e367eec82c3bec4e140e2\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-12041\",\"extraMessage\":\"\",\"message\":\"이용+가능+시간이+아닙니다.\",\"transactionId\":\"6432ead4ec82c3bec4e1488f\"},\"data\":{}}'),(3,2,'{\"result\":{\"code\":\"CF-04022\",\"extraMessage\":\"\",\"message\":\"인증서+파일(pfx)+생성에+실패했습니다.+요청+파라미터+중+certFile항목이+올바른지+확인하세요.\",\"transactionId\":\"6432fd37ec827e122b13b590\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-00001\",\"extraMessage\":\"inquiryType\",\"message\":\"필수+입력+파라미터가+누락되었습니다.\",\"transactionId\":\"643438fb28e600dbc0438d15\"},\"data\":{}}');
/*!40000 ALTER TABLE `businessincome` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `corporate`
--

DROP TABLE IF EXISTS `corporate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `corporate` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `corporate`
--

LOCK TABLES `corporate` WRITE;
/*!40000 ALTER TABLE `corporate` DISABLE KEYS */;
INSERT INTO `corporate` VALUES (1,1,'{\"result\":{\"code\":\"CF-12100\",\"extraMessage\":\"개인납세자는+신청불가능한+민원입니다.\",\"message\":\"해당+기관+오류+메시지가+있습니다.\",\"transactionId\":\"642e3683ec82c3bec4e140e4\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-00000\",\"extraMessage\":\"\",\"message\":\"성공\",\"transactionId\":\"6432eadbec827e122b13b570\"},\"data\":{\"resIssueNo\":\"4853-726-9431-002\",\"resBusinessmanType\":\"법인사업자\",\"resCompanyNm\":\"주식회사+주능\",\"resCompanyIdentityNo\":\"125-86-12167\",\"resUserNm\":\"조종영\",\"resJointRepresentativeNm\":\"\",\"resJointIdentityNo\":\"\",\"resUserAddr\":\"경기도+평택시+청북읍+백봉길+133-7\",\"resUserIdentiyNo\":\"134611-0061105\",\"resOpenDate\":\"20130424\",\"resRegisterDate\":\"20130430\",\"resBusinessTypes\":\"제조업|운수+및+창고업|부동산업\",\"resBusinessItems\":\"액체펌프|보관및창고업|임대\",\"resIssueOgzNm\":\"평택세무서\",\"resIssueDate\":\"20230410\",\"resOriGinalData\":\"\",\"resBusinessTypeCode\":\"291201\",\"resReceiptNo\":\"503339833612\",\"resDepartmentName\":\"민원봉사실\",\"resPhoneNo\":\"031-650-0227\",\"resUserNm1\":\"\"}}'),(3,2,'{\"result\":{\"code\":\"CF-04022\",\"extraMessage\":\"\",\"message\":\"인증서+파일(pfx)+생성에+실패했습니다.+요청+파라미터+중+certFile항목이+올바른지+확인하세요.\",\"transactionId\":\"6432fd37ec82c3bec4e148a3\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-04023\",\"extraMessage\":\"\",\"message\":\"인증서+파일(der)+변환에+실패했습니다.+인증서와+비밀번호+정보가+올바른지+확인하세요.\",\"transactionId\":\"643438fbec827e122b13b881\"},\"data\":{}}');
/*!40000 ALTER TABLE `corporate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employment`
--

DROP TABLE IF EXISTS `employment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employment` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  `der` text DEFAULT NULL,
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employment`
--

LOCK TABLES `employment` WRITE;
/*!40000 ALTER TABLE `employment` DISABLE KEYS */;
INSERT INTO `employment` VALUES (1,1,'{\"result\":{\"code\":\"CF-13000\",\"extraMessage\":\"\",\"message\":\"사업자번호(주민등록번호)가+잘못되었습니다.+확인+후+거래하시기+바랍니다.+\",\"transactionId\":\"642e3671ec82c3bec4e140e0\"},\"data\":{}}',NULL),(2,3,'{\"result\":{\"code\":\"CF-13000\",\"extraMessage\":\"\",\"message\":\"사업자번호(주민등록번호)가+잘못되었습니다.+확인+후+거래하시기+바랍니다.+\",\"transactionId\":\"6432eac228e600dbc04389e5\"},\"data\":{}}',NULL),(3,2,'{\"result\":{\"code\":\"CF-13000\",\"extraMessage\":\"\",\"message\":\"사업자번호(주민등록번호)가+잘못되었습니다.+확인+후+거래하시기+바랍니다.+\",\"transactionId\":\"6432fd36ec82c3bec4e1489f\"},\"data\":{}}',NULL),(4,5,'{\"result\":{\"code\":\"CF-00001\",\"extraMessage\":\"insuranceType\",\"message\":\"필수+입력+파라미터가+누락되었습니다.\",\"transactionId\":\"643438faec82c3bec4e14b67\"},\"data\":{}}',NULL);
/*!40000 ALTER TABLE `employment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `income`
--

DROP TABLE IF EXISTS `income`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `income` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `income`
--

LOCK TABLES `income` WRITE;
/*!40000 ALTER TABLE `income` DISABLE KEYS */;
INSERT INTO `income` VALUES (1,1,'{\"result\":{\"code\":\"CF-12805\",\"extraMessage\":\"\",\"message\":\"미등록+인증서입니다.+확인+후+거래하시기+바랍니다.\",\"transactionId\":\"642e367928e600dbc043822a\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-12041\",\"extraMessage\":\"\",\"message\":\"이용+가능+시간이+아닙니다.\",\"transactionId\":\"6432eacc28e600dbc04389e6\"},\"data\":{}}'),(3,2,'{\"result\":{\"code\":\"CF-00001\",\"extraMessage\":\"certFile\",\"message\":\"필수+입력+파라미터가+누락되었습니다.\",\"transactionId\":\"6432fd37ec82c3bec4e148a1\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-04023\",\"extraMessage\":\"\",\"message\":\"인증서+파일(der)+변환에+실패했습니다.+인증서와+비밀번호+정보가+올바른지+확인하세요.\",\"transactionId\":\"643438faec82c3bec4e14b69\"},\"data\":{}}');
/*!40000 ALTER TABLE `income` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `remunerationlist`
--

DROP TABLE IF EXISTS `remunerationlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `remunerationlist` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remunerationlist`
--

LOCK TABLES `remunerationlist` WRITE;
/*!40000 ALTER TABLE `remunerationlist` DISABLE KEYS */;
INSERT INTO `remunerationlist` VALUES (1,1,'{\"result\":{\"code\":\"CF-13000\",\"extraMessage\":\"\",\"message\":\"사업자번호(주민등록번호)가+잘못되었습니다.+확인+후+거래하시기+바랍니다.+\",\"transactionId\":\"642e367228e600dbc0438228\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-00000\",\"extraMessage\":\"\",\"message\":\"성공\",\"transactionId\":\"6432eac3ec827e122b13b56b\"},\"data\":{\"resTotalRemunerationList\":[{\"resNumber\":\"1\",\"resUserIdentiyNo\":\"7412202226156\",\"resUserNm\":\"최윤숙\",\"resAcquisitionDate\":\"20200324\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"24981800\",\"resAverageAmt\":\"2081816\",\"resAcquisitionDate1\":\"20200324\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"24981800\",\"resAverageAmt1\":\"2081816\",\"resType\":\"00\",\"resZipCode\":\"\"},{\"resNumber\":\"2\",\"resUserIdentiyNo\":\"7703081397311\",\"resUserNm\":\"김경일\",\"resAcquisitionDate\":\"20140524\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"62049290\",\"resAverageAmt\":\"5170774\",\"resAcquisitionDate1\":\"20140524\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"62049290\",\"resAverageAmt1\":\"5170774\",\"resType\":\"\",\"resZipCode\":\"\"},{\"resNumber\":\"3\",\"resUserIdentiyNo\":\"7805111030911\",\"resUserNm\":\"윤상열\",\"resAcquisitionDate\":\"20200624\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"47013970\",\"resAverageAmt\":\"3917830\",\"resAcquisitionDate1\":\"20200624\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"47013970\",\"resAverageAmt1\":\"3917830\",\"resType\":\"00\",\"resZipCode\":\"\"},{\"resNumber\":\"4\",\"resUserIdentiyNo\":\"8611065100016\",\"resUserNm\":\"조대성\",\"resAcquisitionDate\":\"20180312\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"48186490\",\"resAverageAmt\":\"4015540\",\"resAcquisitionDate1\":\"\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"0\",\"resAverageAmt1\":\"\",\"resType\":\"00\",\"resZipCode\":\"\"},{\"resNumber\":\"5\",\"resUserIdentiyNo\":\"8710055760105\",\"resUserNm\":\"판반화\",\"resAcquisitionDate\":\"20220319\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"23783350\",\"resAverageAmt\":\"2523310\",\"resAcquisitionDate1\":\"\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"0\",\"resAverageAmt1\":\"\",\"resType\":\"00\",\"resZipCode\":\"\"},{\"resNumber\":\"6\",\"resUserIdentiyNo\":\"8806115760893\",\"resUserNm\":\"트란쿠안틴\",\"resAcquisitionDate\":\"20160719\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"38953950\",\"resAverageAmt\":\"3246162\",\"resAcquisitionDate1\":\"\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"0\",\"resAverageAmt1\":\"\",\"resType\":\"51\",\"resZipCode\":\"\"},{\"resNumber\":\"7\",\"resUserIdentiyNo\":\"8809095760066\",\"resUserNm\":\"DUONG+VAN+HANH\",\"resAcquisitionDate\":\"20190920\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"43945000\",\"resAverageAmt\":\"3662083\",\"resAcquisitionDate1\":\"\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"0\",\"resAverageAmt1\":\"\",\"resType\":\"00\",\"resZipCode\":\"\"},{\"resNumber\":\"8\",\"resUserIdentiyNo\":\"9002135760152\",\"resUserNm\":\"누엔순뚜엔\",\"resAcquisitionDate\":\"20220526\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"23007410\",\"resAverageAmt\":\"3197133\",\"resAcquisitionDate1\":\"\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"0\",\"resAverageAmt1\":\"\",\"resType\":\"00\",\"resZipCode\":\"\"},{\"resNumber\":\"9\",\"resUserIdentiyNo\":\"9109191164411\",\"resUserNm\":\"이준수\",\"resAcquisitionDate\":\"20140915\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"40796550\",\"resAverageAmt\":\"3399712\",\"resAcquisitionDate1\":\"20140915\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"40796550\",\"resAverageAmt1\":\"3399712\",\"resType\":\"\",\"resZipCode\":\"\"},{\"resNumber\":\"10\",\"resUserIdentiyNo\":\"0005123680010\",\"resUserNm\":\"이진규\",\"resAcquisitionDate\":\"20220721\",\"resLossDate\":\"\",\"resTotalRemuneration\":\"10259200\",\"resAverageAmt\":\"1914216\",\"resAcquisitionDate1\":\"20220721\",\"resLossDate1\":\"\",\"resTotalRemuneration1\":\"10259200\",\"resAverageAmt1\":\"1914216\",\"resType\":\"00\",\"resZipCode\":\"\"}],\"resTotalRemunerationList1\":[{\"resTotalRemuneration\":\"\",\"resTotalRemuneration1\":\"\",\"resTotalRemuneration2\":\"\"}],\"resTotalRemunerationList2\":[{\"resTotalRemuneration\":\"\",\"resTotalRemuneration1\":\"\"}],\"resTotalRemunerationList3\":[]}}'),(3,2,'{\"result\":{\"code\":\"CF-04022\",\"extraMessage\":\"\",\"message\":\"인증서+파일(pfx)+생성에+실패했습니다.+요청+파라미터+중+certFile항목이+올바른지+확인하세요.\",\"transactionId\":\"6432fd3728e600dbc04389fc\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-04023\",\"extraMessage\":\"\",\"message\":\"인증서+파일(der)+변환에+실패했습니다.+인증서와+비밀번호+정보가+올바른지+확인하세요.\",\"transactionId\":\"643438faec82c3bec4e14b68\"},\"data\":{}}');
/*!40000 ALTER TABLE `remunerationlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxadjust`
--

DROP TABLE IF EXISTS `taxadjust`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxadjust` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxadjust`
--

LOCK TABLES `taxadjust` WRITE;
/*!40000 ALTER TABLE `taxadjust` DISABLE KEYS */;
INSERT INTO `taxadjust` VALUES (1,1,'{\"result\":{\"code\":\"CF-12805\",\"extraMessage\":\"\",\"message\":\"미등록+인증서입니다.+확인+후+거래하시기+바랍니다.\",\"transactionId\":\"642e367aec827e122b13ad7f\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-12041\",\"extraMessage\":\"\",\"message\":\"이용+가능+시간이+아닙니다.\",\"transactionId\":\"6432eacfec82c3bec4e1488e\"},\"data\":{}}'),(3,2,'{\"result\":{\"code\":\"CF-04022\",\"extraMessage\":\"\",\"message\":\"인증서+파일(pfx)+생성에+실패했습니다.+요청+파라미터+중+certFile항목이+올바른지+확인하세요.\",\"transactionId\":\"6432fd3728e600dbc04389fd\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-04023\",\"extraMessage\":\"\",\"message\":\"인증서+파일(der)+변환에+실패했습니다.+인증서와+비밀번호+정보가+올바른지+확인하세요.\",\"transactionId\":\"643438faec82c3bec4e14b6a\"},\"data\":{}}');
/*!40000 ALTER TABLE `taxadjust` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxcredit`
--

DROP TABLE IF EXISTS `taxcredit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxcredit` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxcredit`
--

LOCK TABLES `taxcredit` WRITE;
/*!40000 ALTER TABLE `taxcredit` DISABLE KEYS */;
INSERT INTO `taxcredit` VALUES (1,1,'{\"result\":{\"code\":\"CF-12805\",\"extraMessage\":\"\",\"message\":\"미등록+인증서입니다.+확인+후+거래하시기+바랍니다.\",\"transactionId\":\"642e368528e600dbc043822c\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-12041\",\"extraMessage\":\"\",\"message\":\"이용+가능+시간이+아닙니다.\",\"transactionId\":\"6432eadfec827e122b13b571\"},\"data\":{}}'),(3,2,'{\"result\":{\"code\":\"CF-00001\",\"extraMessage\":\"certFile\",\"message\":\"필수+입력+파라미터가+누락되었습니다.\",\"transactionId\":\"6432fd3828e600dbc04389ff\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-00001\",\"extraMessage\":\"inquiryType\",\"message\":\"필수+입력+파라미터가+누락되었습니다.\",\"transactionId\":\"643438fbec82c3bec4e14b6b\"},\"data\":{}}');
/*!40000 ALTER TABLE `taxcredit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxdeducation`
--

DROP TABLE IF EXISTS `taxdeducation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxdeducation` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxdeducation`
--

LOCK TABLES `taxdeducation` WRITE;
/*!40000 ALTER TABLE `taxdeducation` DISABLE KEYS */;
INSERT INTO `taxdeducation` VALUES (1,1,'{\"result\":{\"code\":\"CF-12805\",\"extraMessage\":\"\",\"message\":\"미등록+인증서입니다.+확인+후+거래하시기+바랍니다.\",\"transactionId\":\"642e367c28e600dbc043822b\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-12041\",\"extraMessage\":\"\",\"message\":\"이용+가능+시간이+아닙니다.\",\"transactionId\":\"6432ead1ec827e122b13b56e\"},\"data\":{}}'),(3,2,'{\"result\":{\"code\":\"CF-04022\",\"extraMessage\":\"\",\"message\":\"인증서+파일(pfx)+생성에+실패했습니다.+요청+파라미터+중+certFile항목이+올바른지+확인하세요.\",\"transactionId\":\"6432fd3728e600dbc04389fe\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-00001\",\"extraMessage\":\"inquiryType\",\"message\":\"필수+입력+파라미터가+누락되었습니다.\",\"transactionId\":\"643438fb28e600dbc0438d14\"},\"data\":{}}');
/*!40000 ALTER TABLE `taxdeducation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxexemption`
--

DROP TABLE IF EXISTS `taxexemption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxexemption` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxexemption`
--

LOCK TABLES `taxexemption` WRITE;
/*!40000 ALTER TABLE `taxexemption` DISABLE KEYS */;
INSERT INTO `taxexemption` VALUES (1,1,'{\"result\":{\"code\":\"CF-12805\",\"extraMessage\":\"\",\"message\":\"미등록+인증서입니다.+확인+후+거래하시기+바랍니다.\",\"transactionId\":\"642e3681ec82c3bec4e140e3\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-12041\",\"extraMessage\":\"\",\"message\":\"이용+가능+시간이+아닙니다.\",\"transactionId\":\"6432ead7ec827e122b13b56f\"},\"data\":{}}'),(3,2,'{\"result\":{\"code\":\"CF-04022\",\"extraMessage\":\"\",\"message\":\"인증서+파일(pfx)+생성에+실패했습니다.+요청+파라미터+중+certFile항목이+올바른지+확인하세요.\",\"transactionId\":\"6432fd37ec82c3bec4e148a2\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-00001\",\"extraMessage\":\"inquiryType\",\"message\":\"필수+입력+파라미터가+누락되었습니다.\",\"transactionId\":\"643438fbec827e122b13b880\"},\"data\":{}}');
/*!40000 ALTER TABLE `taxexemption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxpayment`
--

DROP TABLE IF EXISTS `taxpayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxpayment` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxpayment`
--

LOCK TABLES `taxpayment` WRITE;
/*!40000 ALTER TABLE `taxpayment` DISABLE KEYS */;
INSERT INTO `taxpayment` VALUES (1,1,'{\"result\":{\"code\":\"CF-12805\",\"extraMessage\":\"\",\"message\":\"미등록+인증서입니다.+확인+후+거래하시기+바랍니다.\",\"transactionId\":\"642e3675ec827e122b13ad7e\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-12041\",\"extraMessage\":\"\",\"message\":\"이용+가능+시간이+아닙니다.\",\"transactionId\":\"6432eac7ec827e122b13b56c\"},\"data\":{}}'),(3,2,'{\"result\":{\"code\":\"CF-04022\",\"extraMessage\":\"\",\"message\":\"인증서+파일(pfx)+생성에+실패했습니다.+요청+파라미터+중+certFile항목이+올바른지+확인하세요.\",\"transactionId\":\"6432fd37ec827e122b13b58f\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-04023\",\"extraMessage\":\"\",\"message\":\"인증서+파일(der)+변환에+실패했습니다.+인증서와+비밀번호+정보가+올바른지+확인하세요.\",\"transactionId\":\"643438fa28e600dbc0438d13\"},\"data\":{}}');
/*!40000 ALTER TABLE `taxpayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxreport`
--

DROP TABLE IF EXISTS `taxreport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxreport` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxreport`
--

LOCK TABLES `taxreport` WRITE;
/*!40000 ALTER TABLE `taxreport` DISABLE KEYS */;
INSERT INTO `taxreport` VALUES (1,1,'{\"result\":{\"code\":\"CF-12805\",\"extraMessage\":\"\",\"message\":\"미등록+인증서입니다.+확인+후+거래하시기+바랍니다.\",\"transactionId\":\"642e3672ec82c3bec4e140e1\"},\"data\":{}}'),(2,3,'{\"result\":{\"code\":\"CF-12041\",\"extraMessage\":\"\",\"message\":\"이용+가능+시간이+아닙니다.\",\"transactionId\":\"6432eac4ec82c3bec4e1488d\"},\"data\":{}}'),(3,2,'{\"result\":{\"code\":\"CF-04022\",\"extraMessage\":\"\",\"message\":\"인증서+파일(pfx)+생성에+실패했습니다.+요청+파라미터+중+certFile항목이+올바른지+확인하세요.\",\"transactionId\":\"6432fd37ec827e122b13b58e\"},\"data\":{}}'),(4,5,'{\"result\":{\"code\":\"CF-04023\",\"extraMessage\":\"\",\"message\":\"인증서+파일(der)+변환에+실패했습니다.+인증서와+비밀번호+정보가+올바른지+확인하세요.\",\"transactionId\":\"643438fa28e600dbc0438d12\"},\"data\":{}}');
/*!40000 ALTER TABLE `taxreport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_account`
--

DROP TABLE IF EXISTS `user_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_account` (
  `user_key` int(11) NOT NULL AUTO_INCREMENT,
  `kakao_id` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `user_birth` varchar(50) DEFAULT NULL,
  `user_bisnum` varchar(50) DEFAULT NULL,
  `access_token` text DEFAULT NULL,
  `token_expiration` varchar(50) DEFAULT NULL,
  `userType` varchar(50) DEFAULT NULL,
  `manageNo` varchar(50) DEFAULT NULL,
  `insuranceType` varchar(50) DEFAULT NULL,
  `insuranceDate` varchar(50) DEFAULT NULL,
  `phoneNo` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `der` text DEFAULT NULL,
  PRIMARY KEY (`user_key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_account`
--

LOCK TABLES `user_account` WRITE;
/*!40000 ALTER TABLE `user_account` DISABLE KEYS */;
INSERT INTO `user_account` VALUES (1,'2699977798','김우일','0104133199511','030303','eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzZXJ2aWNlX3R5cGUiOiIxIiwic2NvcGUiOlsicmVhZCJdLCJzZXJ2aWNlX25vIjoiMDAwMDAyMTkwMDAyIiwiZXhwIjoxNjgxMjc2Mzk0LCJhdXRob3JpdGllcyI6WyJJTlNVUkFOQ0UiLCJQVUJMSUMiLCJCQU5LIiwiRVRDIiwiU1RPQ0siLCJDQVJEIl0sImp0aSI6IjFlMjkxMzQwLWYzNjctNDk0Ni04MGM0LTBlNGE2OThiYjRhMyIsImNsaWVudF9pZCI6IjljMjdlZWIxLWQ0MTEtNDE5YS1iODIyLTYyMzA1NmZjMTU4OSJ9.myO1WkXARUvMTsfldkSRfTrO2IC-5VJM4M3Phxuz6Kyzi2_KrLogMPO0T80XCPiY2kDl6A-pSfprvDnQqcXCg_nQdLLkvgKTppcCynlr4XsDfyqWaCJlL8iv7CqghFSX8GLnUkKXcexHveSrA3mbFFGS8EecLZVXVD8gc7DEvhPKKwVpnkV42W3c_ylg3-2WzpYMSwpcIu3fc6e0VE3KFnpt_4zgi6nZk8_ydYaU0t3SQx7jvjhNRcVhsMAgxuYkcdHfqLUQr79K2ood_23zLFJxrGOF1jeUwEv3fJFBqgeN4e4x8q5TybH-2mIAkOCtENQAQoDpkgBBd5POYdrZYw','2023-04-12 05:13:14','1','00000','0',NULL,'01039061607','chami0205@gmail.com',NULL),(2,'2700496327','최진성','9612031709514','2548101565','eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzZXJ2aWNlX3R5cGUiOiIxIiwic2NvcGUiOlsicmVhZCJdLCJzZXJ2aWNlX25vIjoiMDAwMDAyMTkwMDAyIiwiZXhwIjoxNjgxMTAxNjY3LCJhdXRob3JpdGllcyI6WyJJTlNVUkFOQ0UiLCJQVUJMSUMiLCJCQU5LIiwiRVRDIiwiU1RPQ0siLCJDQVJEIl0sImp0aSI6IjNkMGI3NTA4LTdlNjEtNDI1ZC04MGI5LWM3Y2U0ZGZlYWU4OCIsImNsaWVudF9pZCI6IjljMjdlZWIxLWQ0MTEtNDE5YS1iODIyLTYyMzA1NmZjMTU4OSJ9.LmXr6CeNDene92ikCEHeDTf5wVIryTeYQHvJadqICP9XqchY6Kdm9NmXC-bee0nYkZo7Mn4JE_RHDvqizlwOND9gyeoU3_STWZ6Uq-Xpc7GdiYvtqaYuXZqlMrn1LskgAWn1s250PAka9UUWfUQnEdmEpr-gcXr5u4DciCLCN6-P4yMZ6MphhRHDry-Wgo8Z3glGGlQV2M2r4FV0XQElxsynp2F7DmwgZBD1TSHHG-_dy27s3ulDNNqG8ATW8vx90drbb95WNLnvGancbiG4k3AE55Y9TxpiStjwpyuZeOmq64m4A_6rjzmhAIjBhE_odcWHPt34jqbHOQmavbyRTA','2023-04-10 04:41:07','0','123456789','0',NULL,'01041529409','asdas@naver.com',NULL),(3,NULL,'조종영','61111211058019','1258612167','eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzZXJ2aWNlX3R5cGUiOiIxIiwic2NvcGUiOlsicmVhZCJdLCJzZXJ2aWNlX25vIjoiMDAwMDAyMTkwMDAyIiwiZXhwIjoxNjgxNjYyNjc3LCJhdXRob3JpdGllcyI6WyJJTlNVUkFOQ0UiLCJQVUJMSUMiLCJCQU5LIiwiRVRDIiwiU1RPQ0siLCJDQVJEIl0sImp0aSI6Ijc4MWZmMTgwLTljOGUtNGMzNy1hN2E3LTM2MGZjNzg4OWI1OCIsImNsaWVudF9pZCI6IjljMjdlZWIxLWQ0MTEtNDE5YS1iODIyLTYyMzA1NmZjMTU4OSJ9.bRjgvsP14BX-z8U10X_mDZW8TT8EfZhDrJp924KVOFSjPCL6tYWlA-ZOap1SkXEubFCPvv4X7f0dFVyINFKGk9mb3g9qNhNdRTkYzqRCIM01vWzCZlzpy1gCDpFJDMUbtq82pD4uDDwX_f1_3LWVGEUhzpcOjaMOcwo3hRGOzYAiHqpx48_xrRA_kM-xJPcP7-O-dGypHUH0Ixai6Q29HhwObHLJBq46pB5CjCBLq1TuxjdLjikxgL5w311NPtFIrFVVA8nY3oEOMJrALQh9oTeSGVfPj_TkR8rrVC86V3txepkDuSxBpIBpRO6f05mVkSAfl1NojtsWRsNqZNxTUg','2023-04-16 16:31:17','1','12586121670','0',NULL,'01041519409','jaco4368@naver.com','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'),(4,'2742377151','박창욱',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,NULL,'강','alivia_bartell93@moneysquad.org','well-modulated',NULL,NULL,'1','incentivize','',NULL,'+447575960046','alivia_bartell93@moneysquad.org','lavender');
/*!40000 ALTER TABLE `user_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yourtablename`
--

DROP TABLE IF EXISTS `yourtablename`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yourtablename` (
  `id_num` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`)),
  PRIMARY KEY (`id_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yourtablename`
--

LOCK TABLES `yourtablename` WRITE;
/*!40000 ALTER TABLE `yourtablename` DISABLE KEYS */;
/*!40000 ALTER TABLE `yourtablename` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-16 13:07:03

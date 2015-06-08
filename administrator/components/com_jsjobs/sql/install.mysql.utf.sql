DROP TABLE IF EXISTS `#__js_job_ages`;
CREATE TABLE `#__js_job_ages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11;
INSERT INTO `#__js_job_ages` (`id`, `title`, `status`, `isdefault`, `ordering`, `serverid`) VALUES(1, '10 Years', 1, 0, 1, 0),(2, '15 Years', 1, 0, 2, 0),(3, '20 Years', 1, 0, 3, 0),(4, '25 Years', 1, 1, 4, 0),(5, '30 Years', 1, 0, 5, 0),(6, '35 Years', 1, 0, 6, 0),(7, '40 Years', 1, 0, 7, 0),(8, '45 Years', 1, 0, 8, 0),(9, '50 Years', 1, 0, 9, 0),(10, '55 Years', 1, 0, 10, 0);

DROP TABLE IF EXISTS `#__js_job_careerlevels`;
CREATE TABLE `#__js_job_careerlevels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8;
INSERT INTO `#__js_job_careerlevels` (`id`, `title`, `status`, `isdefault`, `ordering`, `serverid`) VALUES(1, 'Student (Undergraduate)', 1, 0, 1, 0),(2, 'Student (Graduate)', 1, 0, 2, 0),(3, 'Entry Level', 1, 1, 3, 0),(4, 'Experienced (Non-Manager)', 1, 0, 4, 0),(5, 'Manager', 1, 0, 5, 0),(6, 'Executive (Department Head, SVP, VP etc)', 1, 0, 6, 0),(7, 'Senior Executive (President, CEO, etc)', 1, 0, 7, 0);

DROP TABLE IF EXISTS `#__js_job_categories`;
CREATE TABLE `#__js_job_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_value` varchar(255) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `alias` varchar(225) NOT NULL,
  `isactive` smallint(1) DEFAULT '1',
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cat_title_key` (`cat_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;
INSERT INTO `#__js_job_categories` (`id`, `cat_value`, `cat_title`, `alias`, `isactive`, `isdefault`, `ordering`, `serverid`) VALUES(1, NULL, 'Accounting/Finance', 'accounting-finance', 1, 0, 1, 0),(2, NULL, 'Administrative', 'administrative', 1, 0, 2, 0),(3, NULL, 'Advertising', 'advertising', 1, 0, 3, 0),(4, NULL, 'Airlines/Avionics/Aerospace', 'airlines-avionics-aerospace', 1, 0, 4, 0),(5, NULL, 'Architectural', 'architectural', 1, 0, 5, 0),(6, NULL, 'Automotive', 'automotive', 1, 0, 6, 0),(7, NULL, 'Banking/Finance', 'banking-finance', 1, 0, 7, 0),(8, NULL, 'Biotechnology', 'biotechnology', 1, 0, 8, 0),(9, NULL, 'Civil/Construction', 'civil-construction', 1, 0, 9, 0),(10, NULL, 'Engineering', 'engineering', 1, 0, 10, 0),(11, NULL, 'Cleared Jobs', 'cleared-jobs', 1, 0, 11, 0),(12, NULL, 'Communications', 'communications', 1, 0, 12, 0),(13, NULL, 'Computer/IT', 'computer-it', 1, 1, 13, 0),(14, NULL, 'Construction', 'construction', 1, 0, 14, 0),(15, NULL, 'Consultant/Contractual', 'consultant-contractual', 1, 0, 15, 0),(16, NULL, 'Customer Service', 'customer-service', 1, 0, 16, 0),(17, NULL, 'Defense', 'defense', 1, 0, 17, 0),(18, NULL, 'Design', 'design', 1, 0, 18, 0),(19, NULL, 'Education', 'education', 1, 0, 19, 0),(20, NULL, 'Electrical Engineering', 'electrical-engineering', 1, 0, 20, 0),(21, NULL, 'Electronics Engineering', 'electronics-engineering', 1, 0, 21, 0),(22, NULL, 'Energy', 'energy', 1, 0, 22, 0),(24, NULL, 'Environmental/Safety', 'environmental-safety', 1, 0, 24, 0),(25, NULL, 'Fundraising', 'fundraising', 1, 0, 25, 0),(26, NULL, 'Health/Medicine', 'health-medicine', 1, 0, 26, 0),(27, NULL, 'Homeland Security', 'homeland-security', 1, 0, 27, 0),(28, NULL, 'Human Resources', 'human-resources', 1, 0, 28, 0),(29, NULL, 'Insurance', 'insurance', 1, 0, 29, 0),(30, NULL, 'Intelligence Jobs', 'intelligence-jobs', 1, 0, 30, 0),(31, NULL, 'Internships/Trainees', 'internships-trainees', 1, 0, 31, 0),(32, NULL, 'Legal', 'legal', 1, 0, 32, 0),(33, NULL, 'Logistics/Transportation', 'logistics-transportation', 1, 0, 33, 0),(34, NULL, 'Maintenance', 'maintenance', 1, 0, 34, 0),(35, NULL, 'Management', 'management', 1, 0, 35, 0),(36, NULL, 'Manufacturing/Warehouse', 'manufacturing-warehouse', 1, 0, 36, 0),(37, NULL, 'Marketing', 'marketing', 1, 0, 37, 0),(38, NULL, 'Materials Management', 'materials-management', 1, 0, 38, 0),(39, NULL, 'Mechanical Engineering', 'mechanical-engineering', 1, 0, 39, 0),(40, NULL, 'Mortgage/Real Estate', 'mortgage-real estate', 1, 0, 40, 0),(41, NULL, 'National Security', 'national-security', 1, 0, 41, 0),(42, NULL, 'Part-time/Freelance', 'part-time-freelance', 1, 0, 42, 0),(43, NULL, 'Printing', 'printing', 1, 0, 43, 0),(44, NULL, 'Product Design', 'product-design', 1, 0, 44, 0),(45, NULL, 'Public Relations', 'public-relations', 1, 0, 45, 0),(46, NULL, 'Public Safety', 'public-safety', 1, 0, 46, 0),(47, NULL, 'Research', 'research', 1, 0, 47, 0),(48, NULL, 'Retail', 'retail', 1, 0, 48, 0),(49, NULL, 'Sales', 'sales', 1, 0, 49, 0),(50, NULL, 'Scientific', 'scientific', 1, 0, 50, 0),(51, NULL, 'Shipping/Distribution', 'shipping-distribution', 1, 0, 51, 0),(52, NULL, 'Technicians', 'technicians', 1, 0, 52, 0),(53, NULL, 'Trades', 'trades', 1, 0, 53, 0),(54, NULL, 'Transportation', 'transportation', 1, 0, 54, 0),(55, NULL, 'Transportation Engineering', 'transportation-engineering', 1, 0, 55, 0),(56, NULL, 'Web Site Development', 'web-site-development', 1, 0, 56, 0);

DROP TABLE IF EXISTS `#__js_job_cities`;
CREATE TABLE `#__js_job_cities` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `cityName` varchar(70) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `stateid` smallint(8) DEFAULT NULL,
  `countryid` smallint(9) DEFAULT NULL,
  `isedit` tinyint(1) DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryid` (`countryid`),
  KEY `stateid` (`stateid`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76869 ;
INSERT INTO `#__js_job_cities` (`id`, `cityName`, `name`, `stateid`, `countryid`, `isedit`, `enabled`, `serverid`) VALUES(69785, '*Karachi', 'Karachi', NULL, 126, 0, 1, 69788),(70143, 'Adilpur', 'Adilpur', 0, 126, 1, 1, 70146),(70015, 'Ahmadpur Sil', 'AhmadpurSial', NULL, 126, 0, 1, 70018),(69836, 'AhmadpurEast', 'AhmadpurEast', 0, 126, 1, 1, 76866),(70025, 'Akora', 'Akora', 0, 126, 1, 1, 70028),(70147, 'Alik Ghund', 'AlikGhund', NULL, 126, 0, 1, 70150),(69963, 'Alpur', 'Alipur', NULL, 126, 0, 1, 69966),(70159, 'Alzai', 'Alizai', NULL, 126, 0, 1, 70162),(70009, 'Amangarh', 'Amangarh', NULL, 126, 0, 1, 70012),(69855, 'Attock City', 'AttockCity', NULL, 126, 0, 1, 69858),(70054, 'Baddomalhi', 'Baddomalhi', 0, 126, 1, 1, 70057),(69867, 'Badn', 'Badin', NULL, 126, 0, 1, 69870),(70100, 'Baffa', 'Baffa', NULL, 126, 0, 1, 70103),(69831, 'Bahwalnagar', 'Bahawalnagar', NULL, 126, 0, 1, 69834),(69796, 'Bahwalpur', 'Bahawalpur', NULL, 126, 0, 1, 69799),(70169, 'Bakhri Ahmad Khan', 'BakhriAhmadKhan', NULL, 126, 0, 1, 70172),(69908, 'Bannu', 'Bannu', NULL, 126, 0, 1, 69911),(69926, 'Basrpur', 'Basirpur', NULL, 126, 0, 1, 69929),(70176, 'Basti Aukharvand', 'BastiAukharvand', NULL, 126, 0, 1, 70179),(70167, 'Basti Dosa', 'BastiDosa', NULL, 126, 0, 1, 70170),(69914, 'Bat Khela', 'BatKhela', NULL, 126, 0, 1, 69917),(70128, 'Begowla', 'Begowala', NULL, 126, 0, 1, 70131),(70043, 'Bela', 'Bela', NULL, 126, 0, 1, 70046),(70126, 'Berni', 'Berani', NULL, 126, 0, 1, 70129),(70144, 'Bgarji', 'Bagarji', NULL, 126, 0, 1, 70147),(69857, 'Bhakkar', 'Bhakkar', NULL, 126, 0, 1, 69860),(69865, 'Bhalwl', 'Bhalwal', NULL, 126, 0, 1, 69868),(70074, 'Bhawna', 'Bhawana', NULL, 126, 0, 1, 70077),(69972, 'Bhera', 'Bhera', NULL, 126, 0, 1, 69975),(70095, 'Bhg', 'Bhag', NULL, 126, 0, 1, 70098),(69854, 'Bhi Pheru', 'BhaiPheru', NULL, 126, 0, 1, 69857),(69802, 'Bhimbar', 'Bhimbar', NULL, 126, 0, 1, 69805),(70112, 'Bhiria', 'Bhiria', NULL, 126, 0, 1, 70115),(70049, 'Bhit Shh', 'BhitShah', NULL, 126, 0, 1, 70052),(70064, 'Bhn', 'Bhan', NULL, 126, 0, 1, 70067),(70062, 'Bhoplwla', 'Bhopalwala', NULL, 126, 0, 1, 70065),(70140, 'Bndhi', 'Bandhi', NULL, 126, 0, 1, 70143),(70130, 'Bozdar', 'Bozdar', NULL, 126, 0, 1, 70133),(69816, 'Brewla', 'Burewala', NULL, 126, 0, 1, 69819),(70139, 'Brkhn', 'Barkhan', NULL, 126, 0, 1, 70142),(70158, 'Bulri', 'Bulri', NULL, 126, 0, 1, 70161),(70097, 'Chak', 'Chak', NULL, 126, 0, 1, 70100),(70056, 'Chak Two Hundred Forty-Nine TDA', 'ChakTwoHundredForty-NineTDA', NULL, 126, 0, 1, 70059),(69938, 'Chak zam Saffo', 'ChakAzamSaffo', NULL, 126, 0, 1, 69941),(69843, 'Chakwl', 'Chakwal', NULL, 126, 0, 1, 69846),(69850, 'Chaman', 'Chaman', NULL, 126, 0, 1, 69853),(70108, 'Chambar', 'Chambar', NULL, 126, 0, 1, 70111),(70022, 'Chawinda', 'Chawinda', NULL, 126, 0, 1, 70025),(69856, 'Chchwatni', 'Chichawatni', NULL, 126, 0, 1, 69859),(76865, 'check synchronize 1', 'check synchronize 1', 0, 126, 1, 1, 76871),(76866, 'check synchronize 2', 'check synchronize 2', 0, 126, 1, 1, 76872),(76867, 'check synchronize 3', 'check synchronize 3', 0, 126, 1, 1, 76873),(76868, 'check synchronize 4', 'check synchronize 4', 0, 126, 1, 1, 76874),(70161, 'Chert', 'Cherat', NULL, 126, 0, 1, 70164),(69876, 'Chhar Kna', 'ChuharKana', NULL, 126, 0, 1, 69879),(69813, 'Chiniot', 'Chiniot', NULL, 126, 0, 1, 69816),(69834, 'Chishtin Mandi', 'ChishtianMandi', NULL, 126, 0, 1, 69837),(76854, 'Chitral', 'Chitral', 86, 126, 0, 1, 76857),(69895, 'Chnin', 'Chunian', NULL, 126, 0, 1, 69898),(70085, 'Choa Saidn Shh', 'ChoaSaidanShah', NULL, 126, 0, 1, 70088),(70071, 'Chor', 'Chor', NULL, 126, 0, 1, 70074),(70168, 'Chowki Jamali', 'ChowkiJamali', NULL, 126, 0, 1, 70171),(69847, 'Chrsadda', 'Charsadda', NULL, 126, 0, 1, 69850),(70082, 'Chuhar Jamli', 'ChuharJamali', NULL, 126, 0, 1, 70085),(70174, 'Dajjal wala', 'Dajjalwala', NULL, 126, 0, 1, 70177),(70087, 'Darya Khn', 'DaryaKhan', NULL, 126, 0, 1, 70090),(70133, 'Darya Khn Marri', 'DaryaKhanMarri', NULL, 126, 0, 1, 70136),(69829, 'Daska', 'Daska', NULL, 126, 0, 1, 69832),(70094, 'Daulatpur', 'Daulatpur', NULL, 126, 0, 1, 70097),(70115, 'Daultla', 'Daultala', NULL, 126, 0, 1, 70118),(70061, 'Daur', 'Daur', NULL, 126, 0, 1, 70064),(70005, 'Dd Khel', 'DaudKhel', NULL, 126, 0, 1, 70008),(70086, 'Ddhar', 'Dadhar', NULL, 126, 0, 1, 70089),(69825, 'Ddu', 'Dadu', NULL, 126, 0, 1, 69828),(70057, 'Dera Bugti', 'DeraBugti', NULL, 126, 0, 1, 70060),(69807, 'Dera Ghzi Khn', 'DeraGhaziKhan', NULL, 126, 0, 1, 69810),(69842, 'Dera Isml Khn', 'DeraIsmailKhan', NULL, 126, 0, 1, 69845),(70051, 'Dhanot', 'Dhanot', NULL, 126, 0, 1, 70054),(70114, 'Dhaunkal', 'Dhaunkal', NULL, 126, 0, 1, 70117),(70044, 'Dhoro Nro', 'DhoroNaro', NULL, 126, 0, 1, 70047),(69971, 'Digri', 'Digri', NULL, 126, 0, 1, 69974),(69999, 'Dijkot', 'Dijkot', NULL, 126, 0, 1, 70002),(69931, 'Dinga', 'Dinga', NULL, 126, 0, 1, 69934),(70116, 'Diplo', 'Diplo', NULL, 126, 0, 1, 70119),(70088, 'Dira Dn Panh', 'DairaDinPanah', NULL, 126, 0, 1, 70091),(70060, 'Djal', 'Dajal', NULL, 126, 0, 1, 70063),(70093, 'Dlbandn', 'Dalbandin', NULL, 126, 0, 1, 70096),(70135, 'Doba', 'Doaba', NULL, 126, 0, 1, 70138),(70091, 'Dokri', 'Dokri', NULL, 126, 0, 1, 70094),(69866, 'Dplpur', 'Dipalpur', NULL, 126, 0, 1, 69869),(69981, 'Dr', 'Dir', NULL, 126, 0, 1, 69984),(70120, 'Dro Mehar', 'DaroMehar', NULL, 126, 0, 1, 70123),(70154, 'Duki', 'Duki', NULL, 126, 0, 1, 70157),(69909, 'Dullewla', 'Dullewala', NULL, 126, 0, 1, 69912),(70008, 'Dunga Bunga', 'DungaBunga', NULL, 126, 0, 1, 70011),(69960, 'Dunypur', 'Dunyapur', NULL, 126, 0, 1, 69963),(70028, 'Eminbd', 'Eminabad', NULL, 126, 0, 1, 70031),(69787, 'Faisalbd', 'Faisalabad', NULL, 126, 0, 1, 69790),(70014, 'Faqrwli', 'Faqirwali', NULL, 126, 0, 1, 70017),(70036, 'Faruka', 'Faruka', NULL, 126, 0, 1, 70039),(69992, 'Fazalpur', 'Fazalpur', NULL, 126, 0, 1, 69995),(69929, 'Fort Abbs', 'FortAbbas', NULL, 126, 0, 1, 69932),(70104, 'Gadni', 'Gadani', NULL, 126, 0, 1, 70107),(69961, 'Gambat', 'Gambat', NULL, 126, 0, 1, 69964),(69987, 'Garh Mahrja', 'GarhMaharaja', NULL, 126, 0, 1, 69990),(70102, 'Garhi Khairo', 'GarhiKhairo', NULL, 126, 0, 1, 70105),(70089, 'Garhi Ysn', 'GarhiYasin', NULL, 126, 0, 1, 70092),(69982, 'Ghauspur', 'Ghauspur', NULL, 126, 0, 1, 69985),(69888, 'Ghotki', 'Ghotki', NULL, 126, 0, 1, 69891),(70048, 'Ghro', 'Gharo', NULL, 126, 0, 1, 70051),(70127, 'Gilgit', 'Gilgit', NULL, 126, 0, 1, 70130),(69874, 'Gjar Khn', 'GujarKhan', NULL, 126, 0, 1, 69877),(69826, 'Gojra', 'Gojra', NULL, 126, 0, 1, 69829),(70151, 'Goth Garelo', 'GothGarelo', NULL, 126, 0, 1, 70154),(69791, 'Gujrnwla', 'Gujranwala', NULL, 126, 0, 1, 69794),(69804, 'Gujrt', 'Gujrat', NULL, 126, 0, 1, 69807),(70170, 'Gulishh Kach', 'GulishahKach', NULL, 126, 0, 1, 70173),(69900, 'Gwdar', 'Gwadar', NULL, 126, 0, 1, 69903),(69906, 'Hadli', 'Hadali', NULL, 126, 0, 1, 69909),(69947, 'Hangu', 'Hangu', NULL, 126, 0, 1, 69950),(70118, 'Harnai', 'Harnai', NULL, 126, 0, 1, 70121),(70083, 'Harnoli', 'Harnoli', NULL, 126, 0, 1, 70086),(69897, 'Harpur', 'Haripur', NULL, 126, 0, 1, 69900),(69918, 'Hasan Abdl', 'HasanAbdal', NULL, 126, 0, 1, 69921),(69884, 'Haveli', 'Haveli', NULL, 126, 0, 1, 69887),(69930, 'Havelin', 'Havelian', NULL, 126, 0, 1, 69933),(70007, 'Hazro', 'Hazro', NULL, 126, 0, 1, 70010),(69822, 'Hfizbd', 'Hafizabad', NULL, 126, 0, 1, 69825),(70032, 'Hingorja', 'Hingorja', NULL, 126, 0, 1, 70035),(69910, 'Hla', 'Hala', NULL, 126, 0, 1, 69913),(69871, 'Hrnbd', 'Harunabad', NULL, 126, 0, 1, 69874),(69852, 'Hsilpur', 'Hasilpur', NULL, 126, 0, 1, 69855),(69893, 'Hujra', 'Hujra', NULL, 126, 0, 1, 69896),(69790, 'Hyderbd', 'Hyderabad', NULL, 126, 0, 1, 69793),(76864, 'isedit city', 'isedit city', 0, 126, 1, 1, 76870),(69795, 'Islmbd', 'Islamabad', NULL, 126, 0, 1, 69798),(70110, 'Islmkot', 'Islamkot', NULL, 126, 0, 1, 70113),(69817, 'Jacobbd', 'Jacobabad', NULL, 126, 0, 1, 69820),(69988, 'Jahnin Shh', 'JahanianShah', NULL, 126, 0, 1, 69991),(69848, 'Jallpur', 'Jalalpur', NULL, 126, 0, 1, 69851),(69940, 'Jallpur Prwla', 'JalalpurPirwala', NULL, 126, 0, 1, 69943),(70055, 'Jand', 'Jand', NULL, 126, 0, 1, 70058),(69835, 'Jaranwala', 'Jaranwala', 0, 126, 0, 1, 69838),(69912, 'Jatoi Shimli', 'JatoiShimali', NULL, 126, 0, 1, 69915),(69913, 'Jauharbd', 'Jauharabad', NULL, 126, 0, 1, 69916),(69803, 'Jhang Sadr', 'JhangSadr', NULL, 126, 0, 1, 69806),(69995, 'Jhawrin', 'Jhawarian', NULL, 126, 0, 1, 69998),(69820, 'Jhelum', 'Jhelum', NULL, 126, 0, 1, 69823),(70076, 'Jhol', 'Jhol', NULL, 126, 0, 1, 70079),(69942, 'Jhumra', 'Jhumra', NULL, 126, 0, 1, 69945),(70148, 'Jm Shib', 'JamSahib', NULL, 126, 0, 1, 70151),(69890, 'Jmpur', 'Jampur', NULL, 126, 0, 1, 69893),(70119, 'Jndila Sher Khn', 'JandialaSherKhan', NULL, 126, 0, 1, 70122),(70070, 'Johi', 'Johi', NULL, 126, 0, 1, 70073),(70131, 'Jti', 'Jati', NULL, 126, 0, 1, 70134),(70069, 'Jwani', 'Jiwani', NULL, 126, 0, 1, 70072),(69894, 'Kabrwla', 'Kabirwala', NULL, 126, 0, 1, 69897),(70150, 'Kadhan', 'Kadhan', NULL, 126, 0, 1, 70153),(70029, 'Kahta', 'Kahuta', NULL, 126, 0, 1, 70032),(70081, 'Kallar Kahr', 'KallarKahar', NULL, 126, 0, 1, 70084),(70012, 'Kalr Kot', 'KalurKot', NULL, 126, 0, 1, 70015),(70109, 'Kalswla', 'Kalaswala', NULL, 126, 0, 1, 70112),(70004, 'Kalt', 'Kalat', NULL, 126, 0, 1, 70007),(70080, 'Kamar Mushni', 'KamarMushani', NULL, 126, 0, 1, 70083),(69860, 'Kambar', 'Kambar', NULL, 126, 0, 1, 69863),(69838, 'Kamlia', 'Kamalia', NULL, 126, 0, 1, 69841),(69814, 'Kamoke', 'Kamoke', NULL, 126, 0, 1, 69817),(70021, 'Kamr', 'Kamir', NULL, 126, 0, 1, 70024),(69851, 'Kandhkot', 'Kandhkot', NULL, 126, 0, 1, 69854),(70149, 'Kandiri', 'Kandiari', NULL, 126, 0, 1, 70152),(70001, 'Kandiro', 'Kandiaro', NULL, 126, 0, 1, 70004),(70035, 'Kanganpur', 'Kanganpur', NULL, 126, 0, 1, 70038),(70101, 'Karak', 'Karak', NULL, 126, 0, 1, 70104),(70141, 'Karaundi', 'Karaundi', NULL, 126, 0, 1, 70144),(70156, 'Kario', 'Kario', NULL, 126, 0, 1, 70159),(70010, 'Karor', 'Karor', NULL, 126, 0, 1, 70013),(69962, 'Kashmor', 'Kashmor', NULL, 126, 0, 1, 69965),(69806, 'Kasr', 'Kasur', NULL, 126, 0, 1, 69809),(70162, 'Keti Bandar', 'KetiBandar', NULL, 126, 0, 1, 70165),(70152, 'Khadan Khk', 'KhadanKhak', NULL, 126, 0, 1, 70155),(70125, 'Khadro', 'Khadro', NULL, 126, 0, 1, 70128),(69833, 'Khairpur', 'Khairpur', NULL, 126, 0, 1, 69836),(69980, 'Khairpur Nathan Shh', 'KhairpurNathanShah', NULL, 126, 0, 1, 69983),(69933, 'Khalbat', 'Khalabat', NULL, 126, 0, 1, 69936),(69968, 'Khewra', 'Khewra', NULL, 126, 0, 1, 69971),(69990, 'Khipro', 'Khipro', NULL, 126, 0, 1, 69993),(69916, 'Khna', 'Kahna', NULL, 126, 0, 1, 69919),(70046, 'Khngarh', 'Khangarh', NULL, 126, 0, 1, 70049),(69979, 'Khngh Dogrn', 'KhangahDogran', NULL, 126, 0, 1, 69982),(69824, 'Khnpur', 'Khanpur', NULL, 126, 0, 1, 69827),(69858, 'Khrin', 'Kharian', NULL, 126, 0, 1, 69861),(69977, 'Khrn', 'Kharan', NULL, 126, 0, 1, 69980),(69951, 'Khurrinwla', 'Khurrianwala', NULL, 126, 0, 1, 69954),(69840, 'Khushb', 'Khushab', NULL, 126, 0, 1, 69843),(70078, 'Klbgh', 'Kalabagh', NULL, 126, 0, 1, 70081),(70068, 'Kleke Mandi', 'KalekeMandi', NULL, 126, 0, 1, 70071),(69924, 'Kmra', 'Kamra', NULL, 126, 0, 1, 69927),(70117, 'Kohlu', 'Kohlu', NULL, 126, 0, 1, 70120),(69873, 'Kohror Pakka', 'KohrorPakka', NULL, 126, 0, 1, 69876),(69823, 'Koht', 'Kohat', NULL, 126, 0, 1, 69826),(69839, 'Kot Addu', 'KotAddu', NULL, 126, 0, 1, 69842),(70011, 'Kot Diji', 'KotDiji', NULL, 126, 0, 1, 70014),(70041, 'Kot Ghulm Muhammad', 'KotGhulamMuhammad', NULL, 126, 0, 1, 70044),(69875, 'Kot Malik', 'KotMalik', NULL, 126, 0, 1, 69878),(69936, 'Kot Mmin', 'KotMumin', NULL, 126, 0, 1, 69939),(69915, 'Kot Rdha Kishan', 'KotRadhaKishan', NULL, 126, 0, 1, 69918),(70027, 'Kot Samba', 'KotSamaba', NULL, 126, 0, 1, 70030),(70124, 'Kot Sultan', 'KotSultan', NULL, 126, 0, 1, 70127),(69794, 'Kotli', 'Kotli', NULL, 126, 0, 1, 69797),(70037, 'Kotli Lohrn', 'KotliLoharan', NULL, 126, 0, 1, 70040),(69869, 'Kotri', 'Kotri', NULL, 126, 0, 1, 69872),(70031, 'Kulchi', 'Kulachi', NULL, 126, 0, 1, 70034),(69949, 'Kundin', 'Kundian', NULL, 126, 0, 1, 69952),(69994, 'Kunjh', 'Kunjah', NULL, 126, 0, 1, 69997),(70003, 'Kunri', 'Kunri', NULL, 126, 0, 1, 70006),(69932, 'Ladhewla Warich', 'LadhewalaWaraich', NULL, 126, 0, 1, 69935),(69786, 'Lahore', 'Lahore', NULL, 126, 0, 1, 69789),(70103, 'Lakhi', 'Lakhi', NULL, 126, 0, 1, 70106),(69945, 'Lakki Marwat', 'LakkiMarwat', NULL, 126, 0, 1, 69948),(70164, 'Landi Kotal', 'LandiKotal', NULL, 126, 0, 1, 70167),(70053, 'Lchi', 'Lachi', NULL, 126, 0, 1, 70056),(69859, 'Leiah', 'Leiah', NULL, 126, 0, 1, 69862),(70111, 'Lilini', 'Liliani', NULL, 126, 0, 1, 70114),(69885, 'Lla Msa', 'LalaMusa', NULL, 126, 0, 1, 69888),(69976, 'Llin', 'Lalian', NULL, 126, 0, 1, 69979),(69845, 'Lodhrn', 'Lodhran', NULL, 126, 0, 1, 69848),(69939, 'Loralai', 'Loralai', NULL, 126, 0, 1, 69942),(69800, 'Lrkna', 'Larkana', NULL, 126, 0, 1, 69803),(70065, 'Mach', 'Mach', NULL, 126, 0, 1, 70068),(70090, 'Madeji', 'Madeji', NULL, 126, 0, 1, 70093),(69886, 'Mailsi', 'Mailsi', NULL, 126, 0, 1, 69889),(69954, 'Malakwal City', 'MalakwalCity', NULL, 126, 0, 1, 69957),(69956, 'Malakwl', 'Malakwal', NULL, 126, 0, 1, 69959),(69827, 'Mandi Bahuddn', 'MandiBahauddin', NULL, 126, 0, 1, 69830),(70073, 'Mangla', 'Mangla', NULL, 126, 0, 1, 70076),(70121, 'Mankera', 'Mankera', NULL, 126, 0, 1, 70124),(69805, 'Mardn', 'Mardan', NULL, 126, 0, 1, 69808),(69989, 'Mastung', 'Mastung', NULL, 126, 0, 1, 69992),(70050, 'Matiri', 'Matiari', NULL, 126, 0, 1, 70053),(69978, 'Mehar', 'Mehar', NULL, 126, 0, 1, 69981),(70157, 'Mehmand Chak', 'MehmandChak', NULL, 126, 0, 1, 70160),(69952, 'Mehrbpur', 'Mehrabpur', NULL, 126, 0, 1, 69955),(69862, 'Min Channn', 'MianChannun', NULL, 126, 0, 1, 69865),(69986, 'Minchinbd', 'Minchinabad', NULL, 126, 0, 1, 69989),(69810, 'Mingora', 'Mingaora', NULL, 126, 0, 1, 69813),(69849, 'Minwli', 'Mianwali', NULL, 126, 0, 1, 69852),(70006, 'Mitha Tiwna', 'MithaTiwana', NULL, 126, 0, 1, 70009),(70024, 'Mithi', 'Mithi', NULL, 126, 0, 1, 70027),(69969, 'Mmu Knjan', 'MamuKanjan', NULL, 126, 0, 1, 69972),(69991, 'Mnnwla', 'Mananwala', NULL, 126, 0, 1, 69994),(69882, 'Mnsehra', 'Mansehra', NULL, 126, 0, 1, 69885),(69861, 'Moro', 'Moro', NULL, 126, 0, 1, 69864),(70171, 'Moza Shahwala', 'MozaShahwala', NULL, 126, 0, 1, 70174),(70160, 'Mram Shh', 'MiramShah', NULL, 126, 0, 1, 70163),(70123, 'Mro Khn', 'MiroKhan', NULL, 126, 0, 1, 70126),(70136, 'Mrpur Batoro', 'MirpurBatoro', NULL, 126, 0, 1, 70139),(69812, 'Mrpur Khs', 'MirpurKhas', NULL, 126, 0, 1, 69815),(69907, 'Mrpur Mthelo', 'MirpurMathelo', NULL, 126, 0, 1, 69910),(70142, 'Mrpur Sakro', 'MirpurSakro', NULL, 126, 0, 1, 70145),(70113, 'Mrwh Gorchani', 'MirwahGorchani', NULL, 126, 0, 1, 70116),(69904, 'Mtli', 'Matli', NULL, 126, 0, 1, 69907),(69789, 'Multn', 'Multan', NULL, 126, 0, 1, 69792),(69819, 'Murdke', 'Muridke', NULL, 126, 0, 1, 69822),(70013, 'Murree', 'Murree', NULL, 126, 0, 1, 70016),(69917, 'Mustafbd', 'Mustafabad', NULL, 126, 0, 1, 69920),(70045, 'Muzaffarbd', 'Muzaffarabad', NULL, 126, 0, 1, 70048),(69818, 'Muzaffargarh', 'Muzaffargarh', NULL, 126, 0, 1, 69821),(70155, 'Nabsar', 'Nabisar', NULL, 126, 0, 1, 70158),(69898, 'Nankna Shib', 'NankanaSahib', NULL, 126, 0, 1, 69901),(69996, 'Nasrbd', 'Nasirabad', NULL, 126, 0, 1, 69999),(69964, 'Naudero', 'Naudero', NULL, 126, 0, 1, 69967),(70033, 'Naukot', 'Naukot', NULL, 126, 0, 1, 70036),(69928, 'Naushahra Virkn', 'NaushahraVirkan', NULL, 126, 0, 1, 69931),(70059, 'Naushahro Froz', 'NaushahroFiroz', NULL, 126, 0, 1, 70062),(69809, 'Nawbshh', 'Nawabshah', NULL, 126, 0, 1, 69812),(69934, 'New Bdh', 'NewBadah', NULL, 126, 0, 1, 69937),(70173, 'Noorbd', 'Noorabad', NULL, 126, 0, 1, 70176),(70175, 'Nooriabad', 'Nooriabad', NULL, 126, 0, 1, 70178),(69846, 'Nowshera Cantonment', 'NowsheraCantonment', NULL, 126, 0, 1, 69849),(69955, 'Nrang', 'Narang', NULL, 126, 0, 1, 69958),(69878, 'Nrowl', 'Narowal', NULL, 126, 0, 1, 69881),(69997, 'Nushki', 'Nushki', NULL, 126, 0, 1, 70000),(69811, 'Okra', 'Okara', NULL, 126, 0, 1, 69814),(70107, 'Ormra', 'Ormara', NULL, 126, 0, 1, 70110),(69941, 'Pabbi', 'Pabbi', NULL, 126, 0, 1, 69944),(70040, 'Pad dan', 'PadIdan', NULL, 126, 0, 1, 70043),(70063, 'Pahrpur', 'Paharpur', NULL, 126, 0, 1, 70066),(76858, 'Panjpai', 'Panjpai', 88, 126, 0, 1, 76861),(69965, 'Pasni', 'Pasni', NULL, 126, 0, 1, 69968),(69899, 'Pasrr', 'Pasrur', NULL, 126, 0, 1, 69902),(69872, 'Pattoki', 'Pattoki', NULL, 126, 0, 1, 69875),(69792, 'Peshwar', 'Peshawar', NULL, 126, 0, 1, 69795),(70016, 'Phlia', 'Phalia', NULL, 126, 0, 1, 70019),(70145, 'Phlji', 'Phulji', NULL, 126, 0, 1, 70148),(70034, 'Pind Ddan Khn', 'PindDadanKhan', NULL, 126, 0, 1, 70037),(69953, 'Pindi Bhattin', 'PindiBhattian', NULL, 126, 0, 1, 69956),(76856, 'Pindi Gheb', 'Pindi Gheb', 89, 126, 0, 1, 76859),(69958, 'Pindi Gheb', 'PindiGheb', NULL, 126, 0, 1, 69961),(70020, 'Pishin', 'Pishin', NULL, 126, 0, 1, 70023),(70153, 'Pithoro', 'Pithoro', NULL, 126, 0, 1, 70156),(69830, 'Pkpattan', 'Pakpattan', NULL, 126, 0, 1, 69833),(69868, 'Pno qil', 'PanoAqil', NULL, 126, 0, 1, 69871),(69948, 'Pr jo Goth', 'PirjoGoth', NULL, 126, 0, 1, 69951),(69950, 'Pr Mahal', 'PirMahal', NULL, 126, 0, 1, 69953),(70042, 'Qdirpur Rn', 'QadirpurRan', NULL, 126, 0, 1, 70045),(69793, 'Quetta', 'Quetta', NULL, 126, 0, 1, 69796),(70096, 'Raslnagar', 'Rasulnagar', NULL, 126, 0, 1, 70099),(69911, 'Ratodero', 'Ratodero', NULL, 126, 0, 1, 69914),(70066, 'Rdhan', 'Radhan', NULL, 126, 0, 1, 70069),(69943, 'Renla Khurd', 'RenalaKhurd', NULL, 126, 0, 1, 69946),(69853, 'rifwla', 'Arifwala', NULL, 126, 0, 1, 69856),(69944, 'Rislpur', 'Risalpur', NULL, 126, 0, 1, 69947),(69975, 'Riwind', 'Raiwind', NULL, 126, 0, 1, 69978),(70018, 'Rja Jang', 'RajaJang', NULL, 126, 0, 1, 70021),(69901, 'Rjanpur', 'Rajanpur', NULL, 126, 0, 1, 69904),(70146, 'Rjo Khanni', 'RajoKhanani', NULL, 126, 0, 1, 70149),(70030, 'Rnpur', 'Ranipur', NULL, 126, 0, 1, 70033),(69902, 'Rohri', 'Rohri', NULL, 126, 0, 1, 69905),(70106, 'Rojhn', 'Rojhan', NULL, 126, 0, 1, 70109),(70132, 'Rustam jo Goth', 'RustamjoGoth', NULL, 126, 0, 1, 70135),(69905, 'Rwala Kot', 'RawalaKot', NULL, 126, 0, 1, 69908),(69788, 'Rwalpindi', 'Rawalpindi', NULL, 126, 0, 1, 69791),(69973, 'Sakrand', 'Sakrand', NULL, 126, 0, 1, 69976),(70138, 'Samaro', 'Samaro', NULL, 126, 0, 1, 70141),(69891, 'Sambril', 'Sambrial', NULL, 126, 0, 1, 69894),(70122, 'Sanjwl', 'Sanjwal', NULL, 126, 0, 1, 70125),(70137, 'Sann', 'Sann', NULL, 126, 0, 1, 70140),(76859, 'Sararogha', 'Sararogha', 87, 126, 0, 1, 76862),(69797, 'Sargodha', 'Sargodha', NULL, 126, 0, 1, 69800),(69922, 'Sari lamgr', 'SaraiAlamgir', NULL, 126, 0, 1, 69925),(70047, 'Sari Naurang', 'SaraiNaurang', NULL, 126, 0, 1, 70050),(70084, 'Sari Sidhu', 'SaraiSidhu', NULL, 126, 0, 1, 70087),(69815, 'Sdiqbd', 'Sadiqabad', NULL, 126, 0, 1, 69818),(69927, 'Sehwn', 'Sehwan', NULL, 126, 0, 1, 69930),(69967, 'Sethrja Old', 'SetharjaOld', NULL, 126, 0, 1, 69970),(69881, 'Shabqadar', 'Shabqadar', NULL, 126, 0, 1, 69884),(70075, 'Shahr Sultn', 'ShahrSultan', NULL, 126, 0, 1, 70078),(69887, 'Shakargarr', 'Shakargarr', NULL, 126, 0, 1, 69890),(69970, 'Sharqpur', 'Sharqpur', NULL, 126, 0, 1, 69973),(69801, 'Sheikhupura', 'Sheikhupura', NULL, 126, 0, 1, 69804),(76860, 'Shewa', 'Shewa', 87, 126, 0, 1, 76863),(69864, 'Shhddkot', 'Shahdadkot', NULL, 126, 0, 1, 69867),(69880, 'Shhddpur', 'Shahdadpur', NULL, 126, 0, 1, 69883),(70098, 'Shhpur', 'Shahpur', NULL, 126, 0, 1, 70101),(70038, 'Shhpur Chkar', 'ShahpurChakar', NULL, 126, 0, 1, 70041),(69821, 'Shikrpur', 'Shikarpur', NULL, 126, 0, 1, 69824),(70172, 'Shnpokh', 'Shinpokh', NULL, 126, 0, 1, 70175),(69879, 'Shorko', 'Shorko', NULL, 126, 0, 1, 69882),(69883, 'Shujbd', 'Shujaabad', NULL, 126, 0, 1, 69886),(69808, 'Shwl', 'Sahiwal', NULL, 126, 0, 1, 69811),(69889, 'Sibi', 'Sibi', NULL, 126, 0, 1, 69892),(69798, 'Silkot', 'Sialkot', NULL, 126, 0, 1, 69801),(70000, 'Sillnwli', 'Sillanwali', NULL, 126, 0, 1, 70003),(70079, 'Sinjhoro', 'Sinjhoro', NULL, 126, 0, 1, 70082),(70166, 'Skrdu', 'Skardu', NULL, 126, 0, 1, 70169),(69892, 'Snghar', 'Sanghar', NULL, 126, 0, 1, 69895),(69896, 'Sngla', 'Sangla', NULL, 126, 0, 1, 69899),(70092, 'Sobhdero', 'Sobhadero', NULL, 126, 0, 1, 70095),(70077, 'Sodhra', 'Sodhra', NULL, 126, 0, 1, 70080),(70134, 'Sohbatpur', 'Sohbatpur', NULL, 126, 0, 1, 70137),(76855, 'Spinwam', 'Spinwam', 87, 126, 0, 1, 76858),(70105, 'Srb', 'Surab', NULL, 126, 0, 1, 70108),(69998, 'Sta Road', 'SitaRoad', NULL, 126, 0, 1, 70001),(69966, 'Sukheke Mandi', 'SukhekeMandi', NULL, 126, 0, 1, 69969),(69799, 'Sukkur', 'Sukkur', NULL, 126, 0, 1, 69802),(76857, 'Swat', 'Swat', 86, 126, 0, 1, 76860),(69844, 'Swbi', 'Swabi', NULL, 126, 0, 1, 69847),(69919, 'Talagang', 'Talagang', NULL, 126, 0, 1, 69922),(69993, 'Talamba', 'Talamba', NULL, 126, 0, 1, 69996),(70039, 'Talhr', 'Talhar', NULL, 126, 0, 1, 70042),(69828, 'Tando Allhyr', 'TandoAllahyar', NULL, 126, 0, 1, 69831),(70099, 'Tando Bgo', 'TandoBago', NULL, 126, 0, 1, 70102),(69832, 'Tando dam', 'TandoAdam', NULL, 126, 0, 1, 69835),(70072, 'Tando Ghulm Ali', 'TandoGhulamAli', NULL, 126, 0, 1, 70075),(69974, 'Tando Jm', 'TandoJam', NULL, 126, 0, 1, 69977),(69870, 'Tando Muhammad Khn', 'TandoMuhammadKhan', NULL, 126, 0, 1, 69873),(69983, 'Tangi', 'Tangi', NULL, 126, 0, 1, 69986),(70129, 'Tangwni', 'Tangwani', NULL, 126, 0, 1, 70132),(69920, 'Taunsa', 'Taunsa', NULL, 126, 0, 1, 69923),(69921, 'Thatta', 'Thatta', NULL, 126, 0, 1, 69924),(70058, 'Thru Shh', 'TharuShah', NULL, 126, 0, 1, 70061),(69957, 'Thul', 'Thul', NULL, 126, 0, 1, 69960),(69985, 'Tl', 'Tal', NULL, 126, 0, 1, 69988),(69937, 'Tndlinwla', 'Tandlianwala', NULL, 126, 0, 1, 69940),(70163, 'Tndo Mittha Khn', 'TandoMitthaKhan', NULL, 126, 0, 1, 70166),(69935, 'Tnk', 'Tank', NULL, 126, 0, 1, 69938),(69877, 'Toba Tek Singh', 'TobaTekSingh', NULL, 126, 0, 1, 69880),(69946, 'Topi', 'Topi', NULL, 126, 0, 1, 69949),(69863, 'Turbat', 'Turbat', NULL, 126, 0, 1, 69866),(70023, 'Ubauro', 'Ubauro', NULL, 126, 0, 1, 70026),(69925, 'Umarkot', 'Umarkot', NULL, 126, 0, 1, 69928),(69923, 'Usta Muhammad', 'UstaMuhammad', NULL, 126, 0, 1, 69926),(70067, 'Uthal', 'Uthal', NULL, 126, 0, 1, 70070),(69984, 'Utmnzai', 'Utmanzai', NULL, 126, 0, 1, 69987),(69837, 'Vihri', 'Vihari', NULL, 126, 0, 1, 69840),(70019, 'Warburton', 'Warburton', NULL, 126, 0, 1, 70022),(69841, 'Wazrbd', 'Wazirabad', NULL, 126, 0, 1, 69844),(70165, 'Wna', 'Wana', NULL, 126, 0, 1, 70168),(70052, 'Wrh', 'Warah', NULL, 126, 0, 1, 70055),(70017, 'Yazmn Mandi', 'YazmanMandi', NULL, 126, 0, 1, 70020),(70026, 'Zafarwl', 'Zafarwal', NULL, 126, 0, 1, 70029),(70002, 'Zaida', 'Zaida', NULL, 126, 0, 1, 70005),(69959, 'Zhir Pr', 'ZahirPir', NULL, 126, 0, 1, 69962),(69903, 'Zhob', 'Zhob', NULL, 126, 0, 1, 69906),(76861, 'Ziarat', 'Ziarat', 88, 126, 0, 1, 76864);

DROP TABLE IF EXISTS `#__js_job_companies`;
CREATE TABLE `#__js_job_companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(225) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `logofilename` varchar(100) DEFAULT NULL,
  `logoisfile` tinyint(1) DEFAULT '-1',
  `logo` blob,
  `smalllogofilename` varchar(100) DEFAULT NULL,
  `smalllogoisfile` tinyint(1) DEFAULT '-1',
  `smalllogo` tinyblob,
  `aboutcompanyfilename` varchar(100) DEFAULT NULL,
  `aboutcompanyisfile` tinyint(1) DEFAULT '-1',
  `aboutcompanyfilesize` varchar(100) DEFAULT NULL,
  `aboutcompany` mediumblob,
  `contactname` varchar(255) NOT NULL DEFAULT '',
  `contactphone` varchar(255) DEFAULT NULL,
  `companyfax` varchar(250) DEFAULT NULL,
  `contactemail` varchar(255) NOT NULL DEFAULT '',
  `since` datetime DEFAULT NULL,
  `companysize` varchar(255) DEFAULT NULL,
  `income` varchar(255) DEFAULT NULL,
  `description` text,
  `country` varchar(255) NOT NULL DEFAULT '0',
  `state` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zipcode` varchar(15) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `metadescription` text,
  `metakeywords` text,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `packageid` int(11) DEFAULT NULL,
  `paymenthistoryid` int(11) DEFAULT NULL,
  `isgoldcompany` tinyint(1) DEFAULT '0',
  `startgolddate` datetime DEFAULT NULL,
  `isfeaturedcompany` tinyint(1) DEFAULT '0',
  `startfeatureddate` datetime DEFAULT NULL,
  `serverstatus` varchar(255) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `companies_uid` (`uid`),
  KEY `companies_category` (`category`),
  KEY `companies_packageid` (`packageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_companycities`;
CREATE TABLE `#__js_job_companycities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `companyid` (`companyid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_config`;
CREATE TABLE `#__js_job_config` (
  `configname` varchar(100) NOT NULL DEFAULT '',
  `configvalue` varchar(255) NOT NULL DEFAULT '',
  `configfor` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`configname`),
  FULLTEXT KEY `config_name` (`configname`),
  FULLTEXT KEY `config_for` (`configfor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `#__js_job_config` (`configname`, `configvalue`, `configfor`) VALUES('companyautoapprove', '1', 'default'),('comp_city', '1', 'default'),('comp_county', '1', 'default'),('comp_editor', '1', 'default'),('comp_state', '1', 'default'),('comp_zipcode', '1', 'default'),('cur_location', '1', 'default'),('defaultempallow', '1', 'defaultallow'),('defaultjoballow', '0', 'defaultallow'),('empautoapprove', '1', 'default'),('employerdefaultrole', '1', 'notuse'),('jobautoapprove', '1', 'default'),('jobseekerdefaultrole', '2', 'notuse'),('job_editor', '1', 'default'),('mailfromaddress', 'sender@joomshark.com', 'email'),('mailfromname', 'JS Jobs', 'email'),('newdays', '7', 'default'),('resumeaddress', '1', 'resume'),('resumeeducation', '1', 'resume'),('resumeedu_gradeschool', '1', 'resume'),('resumeedu_highschool', '1', 'resume'),('resumeedu_otherchool', '1', 'resume'),('resumeedu_university', '1', 'resume'),('resumeemployer', '1', 'resume'),('resumeem_1', '1', 'resume'),('resumeem_2', '1', 'resume'),('resumeem_3', '1', 'resume'),('resumeem_recent', '1', 'resume'),('resumereference', '1', 'resume'),('resumereference1', '1', 'resume'),('resumereference2', '1', 'resume'),('resumereference3', '1', 'resume'),('resumeskill', '1', 'resume'),('search_job_durration', '1', 'searchjob'),('search_job_experience', '1', 'searchjob'),('search_job_heighesteducation', '1', 'searchjob'),('search_job_salaryrange', '1', 'searchjob'),('search_job_shift', '1', 'searchjob'),('search_job_showsave', '1', 'searchjob'),('search_job_startpublishing', '1', 'searchjob'),('search_job_stoppublishing', '1', 'searchjob'),('search_job_companysite', '1', 'searchjob'),('search_resume_available', '1', 'searchresume'),('search_resume_experience', '1', 'searchresume'),('actk', '0', 'default'),('search_resume_gender', '1', 'searchresume'),('search_resume_heighesteducation', '1', 'searchresume'),('search_resume_name', '1', 'searchresume'),('search_resume_nationality', '1', 'searchresume'),('search_resume_salaryrange', '1', 'searchresume'),('search_resume_showsave', '1', 'searchresume'),('search_resume_title', '1', 'searchresume'),('search_resume_keywords', '1', 'searchresume'),('showemployerlink', '1', 'default'),('theme', 'graywhite/css/jsjobsgraywhite.css', 'default'),('title', 'JS JOBS', 'default'),('data_directory', 'jsjobsdata', 'default'),('version', '1.1.0.0', 'default'),('versioncode','1100','default'),('versiontype', 'free', NULL),('filter_address', '1', 'default'),('refercode', '207e16fc9c4d2881fc', 'default'),('filter_address_fields_width', '330', 'default'),('filter_category', '1', 'default'),('filter_jobtype', '1', 'default'),('filter_heighesteducation', '1', 'default'),('filter_salaryrange', '1', 'default'),('filter', '1', 'default'),('fr_cr_txa', '<img src="components/com_jsjobs/images/jsjobs_logo_small.png" width="65">&nbsp;&nbsp;&nbsp;Powered by <a href="http://www.joomsky.com" target="_blank">Joom Sky</a>', 'default'),('fr_cr_txsh', '0', 'default'),('fr_cr_txb', '<br>&copy;Copyright 2008 - 2011, <a href="http://www.burujsolutions.com" target="_blank">Buruj Solutions </a> ', 'default'),('backuponuninstall', '1', NULL),('company_logofilezize', '50', 'default'),('resume_photofilesize', '50', 'default'),('offline', '0', 'default'),('offline_text', 'JS Jobs is down for maintenance. Please check back again soon.', 'default'),('payment_multicompanies', '0', 'payment'),('lj_title', '1', 'listjob'),('lj_category', '1', 'listjob'),('lj_jobtype', '1', 'listjob'),('lj_jobstatus', '1', 'listjob'),('lj_company', '1', 'listjob'),('lj_companysite', '1', 'listjob'),('lj_country', '1', 'listjob'),('lj_state', '1', 'listjob'),('lj_county', '1', 'listjob'),('lj_city', '1', 'listjob'),('lj_salary', '1', 'listjob'),('lj_created', '1', 'listjob'),('lj_noofjobs', '1', 'listjob'),('visitor_lj_title', '1', 'listjob'),('visitor_lj_category', '1', 'listjob'),('visitor_lj_jobtype', '1', 'listjob'),('visitor_lj_jobstatus', '1', 'listjob'),('visitor_lj_company', '1', 'listjob'),('visitor_lj_companysite', '0', 'listjob'),('visitor_lj_country', '1', 'listjob'),('visitor_lj_state', '1', 'listjob'),('visitor_lj_county', '1', 'listjob'),('visitor_lj_city', '1', 'listjob'),('visitor_lj_salary', '1', 'listjob'),('visitor_lj_created', '1', 'listjob'),('visitor_lj_noofjobs', '1', 'listjob'),('visitorview_js_controlpanel', '1', 'default'),('visitorview_js_packages', '1', 'default'),('visitorview_js_viewpackage', '1', 'default'),('visitorview_js_jobcat', '1', 'default'),('visitorview_js_listjob', '1', 'default'),('visitorview_js_newestjobs', '1', 'default'),('visitorview_js_jobsearch', '1', 'default'),('visitorview_js_jobsearchresult', '1', 'default'),('visitorview_js_viewresume', '1', 'default'),('visitorview_emp_conrolpanel', '1', 'default'),('visitorview_emp_packages', '1', 'default'),('visitorview_emp_viewpackage', '1', 'default'),('visitorview_emp_resumesearch', '1', 'default'),('visitorview_emp_resumesearchresult', '1', 'default'),('visitorview_emp_viewcompany', '1', 'default'),('visitorview_emp_viewjob', '1', 'default'),('search_job_title', '1', 'searchjob'),('search_job_category', '1', 'searchjob'),('search_job_type', '1', 'searchjob'),('search_job_status', '1', 'searchjob'),('search_job_company', '1', 'searchjob'),('search_job_country', '1', 'searchjob'),('search_job_state', '1', 'searchjob'),('search_job_county', '1', 'searchjob'),('search_job_city', '1', 'searchjob'),('search_job_zipcode', '0', 'searchjob'),('search_resume_category', '1', 'searchresume'),('search_resume_type', '1', 'searchresume'),('featuredjob_autoapprove', '1', 'featuredjob'),('goldjob_autoapprove', '1', 'goldjob'),('featuredcompany_autoapprove', '1', 'featuredcompany'),('goldcompany_autoapprove', '1', 'goldcompany'),('featuredresume_autoapprove', '1', 'featuredresume'),('goldresume_autoapprove', '1', 'goldresume'),('payment_method', 'paypal', 'payment'),('payment_shopingurl', '', 'payment'),('payment_successefulurl', '', 'payment'),('payment_cancelurl', '', 'payment'),('payment_paypalaccount', '', 'payment'),('payment_showdescription', '1', 'payment'),('payment_description', 'Description', 'payment'),('payment_showfooter', '1', 'payment'),('payment_currency', 'USD', 'payment'),('payment_authtoken', '', 'payment'),('payment_test_mode', '0', 'payment'),('employer_defaultpackage', '', 'package'),('jobseeker_defaultpackage', '', 'package'),('date_format', 'm/d/Y', 'default'),('adminemailaddress', 'admin@yahoo.com', 'email'),('email_admin_new_company', '1', 'email'),('email_admin_new_job', '1', 'email'),('email_admin_new_resume', '1', 'email'),('email_admin_job_apply', '1', 'email'),('email_admin_new_department', '1', 'email'),('email_admin_employer_package_purchase', '1', 'email'),('email_admin_jobseeker_package_purchase', '1', 'email'),('onlyonce_employer_getfreepackage', '1', 'package'),('onlyonce_jobseeker_getfreepackage', '1', 'package'),('employer_freepackage_autoapprove', '1', 'package'),('jobseeker_freepackage_autoapprove', '1', 'package'),('subcategories', '1', 'listjob'),('subcategories_all', '1', 'listjob'),('subcategories_colsperrow', '3', 'listjob'),('subcategoeis_max_hight', '250', 'listjob'),('categories_colsperrow', '3', 'default'),('message_auto_approve', '1', 'messages'),('conflict_message_auto_approve', '0', 'messages'),('overwrite_jobalert_settings', '1', 'default'),('visitor_can_apply_to_job', '0', 'default'),('visitor_show_login_message', '1', 'default'),('folder_auto_approve', '1', 'folder'),('department_auto_approve', '1', 'department'),('formcompany', '1', 'emcontrolpanel'),('mycompanies', '1', 'emcontrolpanel'),('formjob', '1', 'emcontrolpanel'),('myjobs', '1', 'emcontrolpanel'),('formdepartment', '1', 'emcontrolpanel'),('mydepartment', '1', 'emcontrolpanel'),('empmessages', '1', 'emcontrolpanel'),('alljobsappliedapplications', '1', 'emcontrolpanel'),('resumesearch', '1', 'emcontrolpanel'),('my_resumesearches', '1', 'emcontrolpanel'),('packages', '1', 'emcontrolpanel'),('purchasehistory', '1', 'emcontrolpanel'),('my_stats', '1', 'emcontrolpanel'),('myfolders', '1', 'emcontrolpanel'),('formresume', '1', 'jscontrolpanel'),('myresumes', '1', 'jscontrolpanel'),('formcoverletter', '1', 'jscontrolpanel'),('mycoverletters', '1', 'jscontrolpanel'),('jspackages', '1', 'jscontrolpanel'),('jspurchasehistory', '1', 'jscontrolpanel'),('jobalertsetting', '1', 'jscontrolpanel'),('jobcat', '1', 'jscontrolpanel'),('listnewestjobs', '1', 'jscontrolpanel'),('myappliedjobs', '1', 'jscontrolpanel'),('jobsearch', '1', 'jscontrolpanel'),('my_jobsearches', '1', 'jscontrolpanel'),('jsmy_stats', '1', 'jscontrolpanel'),('jsmessages', '1', 'jscontrolpanel'),('tmenu_emcontrolpanel', '1', 'default'),('tmenu_emnewcompany', '1', 'default'),('tmenu_emnewjob', '1', 'default'),('tmenu_emmyjobs', '1', 'default'),('tmenu_emmycompanies', '1', 'default'),('tmenu_emsearchresume', '1', 'default'),('tmenu_emnewdepartment', '1', 'default'),('tmenu_emnewfolder', '1', 'default'),('tmenu_jscontrolpanel', '1', 'default'),('tmenu_jsjobcategory', '1', 'default'),('tmenu_jssearchjob', '1', 'default'),('tmenu_jsnewestjob', '1', 'default'),('tmenu_jsmyresume', '1', 'default'),('tmenu_jsaddresume', '1', 'default'),('show_applied_resume_status', '1', 'default'),('tmenu_jsaddcoverletter', '1', 'default'),('jobalert_auto_approve', '1', 'jobalert'),('pagseguro_email', '1', 'payment'),('lj_description', '1', 'listjob'),('visitor_lj_description', '1', 'listjob'),('lj_shortdescriptionlenght', '200', 'listjob'),('lj_joblistingstyle', 'july2011', 'listjob'),('search_resume_style', 'july2011', 'searchresume'),('filter_address_country', '1', 'default'),('filter_address_state', '1', 'default'),('filter_address_county', '1', 'default'),('filter_address_city', '1', 'default'),('testing_mode', '1', 'default'),('resume_style', 'tabular', 'default'),('api_primary', 'a2d09c7d76fced01f8be4b1f4cce8bec', 'api'),('api_secondary', '', 'api'),('search_job_subcategory', '1', 'searchjob'),('search_resume_subcategory', '1', 'searchresume'),('comp_show_url', '1', 'default'),('employerview_js_controlpanel', '1', 'default'),('search_job_keywords', '1', 'searchjob'),('vis_emformjob', '1', 'default'),('vis_emresumesearch', '1', 'default'),('vis_emmycompanies', '1', 'default'),('vis_emalljobsappliedapplications', '1', 'default'),('vis_emformcompany', '1', 'default'),('tmenu_vis_emsearchresume', '1', 'default'),('tmenu_vis_emmycompanies', '1', 'default'),('tmenu_vis_emmyjobs', '1', 'default'),('tmenu_vis_emnewjob', '1', 'default'),('tmenu_vis_emcontrolpanel', '1', 'default'),('vis_emmy_resumesearches', '1', 'default'),('vis_emmyjobs', '1', 'default'),('vis_empackages', '1', 'default'),('vis_emformdepartment', '1', 'default'),('vis_empurchasehistory', '1', 'default'),('vis_emmydepartment', '1', 'default'),('vis_emmy_stats', '1', 'default'),('vis_emmessages', '1', 'default'),('vis_emmyfolders', '1', 'default'),('tmenu_vis_jscontrolpanel', '1', 'default'),('tmenu_vis_jsjobcategory', '1', 'default'),('tmenu_vis_jsnewestjob', '1', 'default'),('tmenu_vis_jsmyresume', '1', 'default'),('vis_jsformresume', '1', 'default'),('vis_jsjobcat', '1', 'default'),('vis_jsmyresumes', '1', 'default'),('vis_jslistnewestjobs', '1', 'default'),('vis_jsformcoverletter', '1', 'default'),('vis_jsmyappliedjobs', '1', 'default'),('vis_jsmycoverletters', '1', 'default'),('vis_jspackages', '1', 'default'),('vis_jsmy_jobsearches', '1', 'default'),('vis_jspurchasehistory', '1', 'default'),('vis_jsjobsearch', '1', 'default'),('vis_jsmy_stats', '1', 'default'),('vis_jsjobalertsetting', '1', 'default'),('vis_jsmessages', '1', 'default'),('tmenu_vis_jssearchjob', '1', 'default'),('rss_job_title', 'Jobs RSS', 'rss'),('rss_job_description', 'Job RSS Show the Latest Jobs On Our Sites', 'rss'),('rss_job_categories', '1', 'rss'),('rss_job_image', '1', 'rss'),('rss_resume_categories', '1', 'rss'),('rss_resume_image', '1', 'rss'),('rss_resume_title', 'Resume RSS', 'rss'),('rss_resume_description', 'Resume RSS Show the Latest Resume On Our Sites', 'rss'),('rss_job_ttl', '12', 'rss'),('rss_job_copyright', 'Copyright 2009-2012', 'rss'),('rss_job_webmaster', 'admin@domain.com', 'rss'),('rss_job_editor', 'admin@domain.com', 'rss'),('rss_resume_copyright', '', 'rss'),('rss_resume_webmaster', '', 'rss'),('rss_resume_editor', '', 'rss'),('rss_resume_ttl', '', 'rss'),('rss_resume_file', '1', 'rss'),('visitor_can_post_job', '0', 'default'),('visitor_can_edit_job', '0', 'default'),('job_captcha', '1', 'default'),('resume_captcha', '1', 'default'),('job_rss', '1', 'default'),('resume_rss', '1', 'default'),('empresume_rss', '1', 'default'),('jsjob_rss', '1', 'default'),('vis_resume_rss', '1', 'default'),('vis_job_rss', '1', 'default'),('default_longitude', '74.3833333', 'default'),('default_latitude', '31.5166667', 'default'),('search_job_coordinates', '1', 'searchjob'),('vis_emresumebycategory', '1', 'default'),('noofgoldjobsinlisting', '3', 'default'),('nooffeaturedjobsinlisting', '2', 'default'),('showgoldjobsinnewestjobs', '1', 'default'),('showfeaturedjobsinnewestjobs', '1', 'default'),('showgoldjobsinlistjobs', '1', 'default'),('showfeaturedjobsinlistjobs', '1', 'default'),('googleadsenseclient', 'ca-pub-8827762976015158', 'default'),('googleadsenseslot', '9560237528', 'default'),('googleadsensewidth', '717', 'default'),('googleadsenseheight', '90', 'default'),('googleadsensecustomcss', '', 'default'),('googleadsenseshowafter', '4', 'default'),('googleadsenseshowinnewestjobs', '0', 'default'),('googleadsenseshowinlistjobs', '0', 'default'),('cron_job_alert_key', 'f1877c1756a68271d12db39ddc87dad7', 'default'),('empexpire_package_message', '1', 'emcontrolpanel'),('jsexpire_package_message', '1', 'jscontrolpanel'),('filter_map', '1', 'default'),('defaultradius', '2', 'default'),('filter_map_fields_width', '190', 'default'),('filter_cat_jobtype_fields_width', '200', 'default'),('mapwidth', '500', 'default'),('mapheight', '200', 'default'),('comp_name', '1', 'default'),('comp_email_address', '1', 'default'),('filter_sub_category', '1', 'default'),('labelinlisting', '1', 'default'),('jsregister', '1', 'jscontrolpanel'),('vis_jsregister', '1', 'default'),('empregister', '1', 'emcontrolpanel'),('vis_emempregister', '1', 'default'),('authentication_client_key', '', 'jobsharing'),('search_resume_zipcode', '1', 'searchresume'),('newlisting_requiredpackage', '0', 'default'),('user_registration_captcha', '1', 'default'),('js_newlisting_requiredpackage', '0', 'default'),('employer_share_fb_like', '1', 'social'),('jobseeker_share_fb_like', '1', 'social'),('employer_share_fb_share', '1', 'social'),('jobseeker_share_fb_share', '1', 'social'),('employer_share_fb_comments', '1', 'social'),('jobseeker_share_fb_comments', '1', 'social'),('employer_share_google_like', '1', 'social'),('jobseeker_share_google_like', '1', 'social'),('employer_share_google_share', '1', 'social'),('jobseeker_share_google_share', '1', 'social'),('employer_share_blog_share', '1', 'social'),('jobseeker_share_blog_share', '1', 'social'),('employer_share_friendfeed_share', '1', 'social'),('jobseeker_share_friendfeed_share', '1', 'social'),('employer_share_linkedin_share', '1', 'social'),('jobseeker_share_linkedin_share', '1', 'social'),('employer_share_digg_share', '1', 'social'),('employer_share_twitter_share', '1', 'social'),('jobseeker_share_twiiter_share', '1', 'social'),('employer_share_myspace_share', '1', 'social'),('jobseeker_share_myspace_share', '1', 'social'),('employer_share_yahoo_share', '1', 'social'),('jobseeker_share_yahoo_share', '1', 'social'),('jobseeker_share_digg_share', '1', 'social'),('newfolders', '1', 'emcontrolpanel'),('vis_emnewfolders', '0', 'default'),('resume_subcategories', '1', 'searchresume'),('resume_subcategories_all', '1', 'searchresume'),('resume_subcategories_colsperrow', '3', 'searchresume'),('resume_subcategoeis_max_hight', '250', 'searchresume'),('employer_resume_alert_fields', '1', 'email'),('defaultaddressdisplaytype', 'csc', 'default'),('jobseeker_defaultgroup', '', 'default'),('employer_defaultgroup', '', 'default'),('default_sharing_city', '', 'jobsharing'),('default_sharing_state', '', 'jobsharing'),('default_sharing_country', '', 'jobsharing'),('job_alert_captcha', '1', 'default'),('jobseeker_resume_applied_status', '1', 'email'),('server_serial_number', '', 'jobsharing'),('jsjobupdatecount', '32', 'default'),('serialnumber', '96407', 'hostdata'),('hostdata', '22b937a7fcde0d155c4b279d26c42d03', 'hostdata'),('zvdk', '895bbcffc42006a', 'hostdata'),('showgoldjobsinsearchjobs', '', 'default'),('showfeaturedjobsinsearchjobs', '', 'default'),('noofgoldjobsinsearch', '', 'default'),('nooffeaturedjobsinsearch', '', 'default'),('showapplybutton', '1', 'default'),('applybuttonredirecturl', 'index.php', 'default'),('system_timeout', '', 'default'),('image_file_type', 'gif,jpg,jpeg,png', 'default'),('document_file_type', 'txt,doc,docx,Pdf,opt,rtf', 'default'),('captchause', '1', 'default'),('jobsloginlogout', '1', 'jscontrolpanel'),('emploginlogout', '1', 'emcontrolpanel'),('number_of_cities_for_autocomplete', '15', 'default');

DROP TABLE IF EXISTS `#__js_job_countries`;
CREATE TABLE `#__js_job_countries` (
  `id` smallint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `shortCountry` varchar(30) DEFAULT NULL,
  `continentID` tinyint(11) DEFAULT NULL,
  `dialCode` smallint(8) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=215 ;
INSERT INTO `#__js_job_countries` (`id`, `name`, `shortCountry`, `continentID`, `dialCode`, `enabled`, `serverid`) VALUES(1, 'United States', 'US', 1, 1, 1, 0),(2, 'Canada', 'Canada', 1, 1, 1, 0),(3, 'Bahamas', 'Bahamas', 1, 242, 1, 0),(4, 'Barbados', 'Barbados', 1, 246, 1, 0),(5, 'Belize', 'Belize', 1, 501, 1, 0),(6, 'Bermuda', 'Bermuda', 1, 441, 1, 0),(7, 'British Virgin Islands', 'BVI', 1, 284, 1, 0),(8, 'Cayman Islands', 'CaymanIsl', 1, 345, 1, 0),(9, 'Costa Rica', 'CostaRica', 1, 506, 1, 0),(10, 'Cuba', 'Cuba', 1, 53, 1, 0),(11, 'Dominica', 'Dominica', 1, 767, 1, 0),(12, 'Dominican Republic', 'DominicanRep', 1, 809, 1, 0),(13, 'El Salvador', 'ElSalvador', 1, 503, 1, 0),(14, 'Greenland', 'Greenland', 1, 299, 1, 0),(15, 'Grenada', 'Grenada', 1, 473, 1, 0),(16, 'Guadeloupe', 'Guadeloupe', 1, 590, 1, 0),(17, 'Guatemala', 'Guatemala', 1, 502, 1, 0),(18, 'Haiti', 'Haiti', 1, 509, 1, 0),(19, 'Honduras', 'Honduras', 1, 503, 1, 0),(20, 'Jamaica', 'Jamaica', 1, 876, 1, 0),(21, 'Martinique', 'Martinique', 1, 596, 1, 0),(22, 'Mexico', 'Mexico', 1, 52, 1, 0),(23, 'Montserrat', 'Montserrat', 1, 664, 1, 0),(24, 'Nicaragua', 'Nicaragua', 1, 505, 1, 0),(25, 'Panama', 'Panama', 1, 507, 1, 0),(26, 'Puerto Rico', 'PuertoRico', 1, 787, 1, 0),(27, 'Trinidad and Tobago', 'Trinidad-Tobago', 1, 868, 1, 0),(28, 'United States Virgin Islands', 'USVI', 1, 340, 1, 0),(29, 'Argentina', 'Argentina', 2, 54, 1, 0),(30, 'Bolivia', 'Bolivia', 2, 591, 1, 0),(31, 'Brazil', 'Brazil', 2, 55, 1, 0),(32, 'Chile', 'Chile', 2, 56, 1, 0),(33, 'Colombia', 'Colombia', 2, 57, 1, 0),(34, 'Ecuador', 'Ecuador', 2, 593, 1, 0),(35, 'Falkland Islands', 'FalklandIsl', 2, 500, 1, 0),(36, 'French Guiana', 'FrenchGuiana', 2, 594, 1, 0),(37, 'Guyana', 'Guyana', 2, 592, 1, 0),(38, 'Paraguay', 'Paraguay', 2, 595, 1, 0),(39, 'Peru', 'Peru', 2, 51, 1, 0),(40, 'Suriname', 'Suriname', 2, 597, 1, 0),(41, 'Uruguay', 'Uruguay', 2, 598, 1, 0),(42, 'Venezuela', 'Venezuela', 2, 58, 1, 0),(43, 'Albania', 'Albania', 3, 355, 1, 0),(44, 'Andorra', 'Andorra', 3, 376, 1, 0),(45, 'Armenia', 'Armenia', 3, 374, 1, 0),(46, 'Austria', 'Austria', 3, 43, 1, 0),(47, 'Azerbaijan', 'Azerbaijan', 3, 994, 1, 0),(48, 'Belarus', 'Belarus', 3, 375, 1, 0),(49, 'Belgium', 'Belgium', 3, 32, 1, 0),(50, 'Bosnia and Herzegovina', 'Bosnia-Herzegovina', 3, 387, 1, 0),(51, 'Bulgaria', 'Bulgaria', 3, 359, 1, 0),(52, 'Croatia', 'Croatia', 3, 385, 1, 0),(53, 'Cyprus', 'Cyprus', 3, 357, 1, 0),(54, 'Czech Republic', 'CzechRep', 3, 420, 1, 0),(55, 'Denmark', 'Denmark', 3, 45, 1, 0),(56, 'Estonia', 'Estonia', 3, 372, 1, 0),(57, 'Finland', 'Finland', 3, 358, 1, 0),(58, 'France', 'France', 3, 33, 1, 0),(59, 'Georgia', 'Georgia', 3, 995, 1, 0),(60, 'Germany', 'Germany', 3, 49, 1, 0),(61, 'Gibraltar', 'Gibraltar', 3, 350, 1, 0),(62, 'Greece', 'Greece', 3, 30, 1, 0),(63, 'Guernsey', 'Guernsey', 3, 44, 1, 0),(64, 'Hungary', 'Hungary', 3, 36, 1, 0),(65, 'Iceland', 'Iceland', 3, 354, 1, 0),(66, 'Ireland', 'Ireland', 3, 353, 1, 0),(67, 'Isle of Man', 'IsleofMan', 3, 44, 1, 0),(68, 'Italy', 'Italy', 3, 39, 1, 0),(69, 'Jersey', 'Jersey', 3, 44, 1, 0),(70, 'Kosovo', 'Kosovo', 3, 381, 1, 0),(71, 'Latvia', 'Latvia', 3, 371, 1, 0),(72, 'Liechtenstein', 'Liechtenstein', 3, 423, 1, 0),(73, 'Lithuania', 'Lithuania', 3, 370, 1, 0),(74, 'Luxembourg', 'Luxembourg', 3, 352, 1, 0),(75, 'Macedonia', 'Macedonia', 3, 389, 1, 0),(76, 'Malta', 'Malta', 3, 356, 1, 0),(77, 'Moldova', 'Moldova', 3, 373, 1, 0),(78, 'Monaco', 'Monaco', 3, 377, 1, 0),(79, 'Montenegro', 'Montenegro', 3, 381, 1, 0),(80, 'Netherlands', 'Netherlands', 3, 31, 1, 0),(81, 'Norway', 'Norway', 3, 47, 1, 0),(82, 'Poland', 'Poland', 3, 48, 1, 0),(83, 'Portugal', 'Portugal', 3, 351, 1, 0),(84, 'Romania', 'Romania', 3, 40, 1, 0),(85, 'Russia', 'Russia', 3, 7, 1, 0),(86, 'San Marino', 'SanMarino', 3, 378, 1, 0),(87, 'Serbia', 'Serbia', 3, 381, 1, 0),(88, 'Slovakia', 'Slovakia', 3, 421, 1, 0),(89, 'Slovenia', 'Slovenia', 3, 386, 1, 0),(90, 'Spain', 'Spain', 3, 34, 1, 0),(91, 'Sweden', 'Sweden', 3, 46, 1, 0),(92, 'Switzerland', 'Switzerland', 3, 41, 1, 0),(93, 'Turkey', 'Turkey', 3, 90, 1, 0),(94, 'Ukraine', 'Ukraine', 3, 380, 1, 0),(95, 'United Kingdom', 'UK', 3, 44, 1, 0),(96, 'Vatican City', 'Vatican', 3, 39, 1, 0),(97, 'Afghanistan', 'Afghanistan', 4, 93, 1, 0),(98, 'Bahrain', 'Bahrain', 4, 973, 1, 0),(99, 'Bangladesh', 'Bangladesh', 4, 880, 1, 0),(100, 'Bhutan', 'Bhutan', 4, 975, 1, 0),(101, 'Brunei', 'Brunei', 4, 673, 1, 0),(102, 'Cambodia', 'Cambodia', 4, 855, 1, 0),(103, 'China', 'China', 4, 86, 1, 0),(104, 'East Timor', 'EastTimor', 4, 670, 1, 0),(105, 'Hong Kong', 'HongKong', 4, 852, 1, 0),(106, 'India', 'India', 4, 91, 1, 0),(107, 'Indonesia', 'Indonesia', 4, 62, 1, 0),(108, 'Iran', 'Iran', 4, 98, 1, 0),(109, 'Iraq', 'Iraq', 4, 964, 1, 0),(110, 'Israel', 'Israel', 4, 972, 1, 0),(111, 'Japan', 'Japan', 4, 81, 1, 0),(112, 'Jordan', 'Jordan', 4, 962, 1, 0),(113, 'Kazakhstan', 'Kazakhstan', 4, 7, 1, 0),(114, 'Kuwait', 'Kuwait', 4, 965, 1, 0),(115, 'Kyrgyzstan', 'Kyrgyzstan', 4, 996, 1, 0),(116, 'Laos', 'Laos', 4, 856, 1, 0),(117, 'Lebanon', 'Lebanon', 4, 961, 1, 0),(118, 'Macau', 'Macau', 4, 853, 1, 0),(119, 'Malaysia', 'Malaysia', 4, 60, 1, 0),(120, 'Maldives', 'Maldives', 4, 960, 1, 0),(121, 'Mongolia', 'Mongolia', 4, 976, 1, 0),(122, 'Myanmar (Burma)', 'Myanmar(Burma)', 4, 95, 1, 0),(123, 'Nepal', 'Nepal', 4, 977, 1, 0),(124, 'North Korea', 'NorthKorea', 4, 850, 1, 0),(125, 'Oman', 'Oman', 4, 968, 1, 0),(126, 'Pakistan', 'Pakistan', 4, 92, 1, 0),(127, 'Philippines', 'Philippines', 4, 63, 1, 0),(128, 'Qatar', 'Qatar', 4, 974, 1, 0),(129, 'Saudi Arabia', 'SaudiArabia', 4, 966, 1, 0),(130, 'Singapore', 'Singapore', 4, 65, 1, 0),(131, 'South Korea', 'SouthKorea', 4, 82, 1, 0),(132, 'Sri Lanka', 'SriLanka', 4, 94, 1, 0),(133, 'Syria', 'Syria', 4, 963, 1, 0),(134, 'Taiwan', 'Taiwan', 4, 886, 1, 0),(135, 'Tajikistan', 'Tajikistan', 4, 992, 1, 0),(136, 'Thailand', 'Thailand', 4, 66, 1, 0),(137, 'Turkmenistan', 'Turkmenistan', 4, 993, 1, 0),(138, 'United Arab Emirates', 'UAE', 4, 971, 1, 0),(139, 'Uzbekistan', 'Uzbekistan', 4, 998, 1, 0),(140, 'Vietnam', 'Vietnam', 4, 84, 1, 0),(141, 'Yemen', 'Yemen', 4, 967, 1, 0),(142, 'Algeria', 'Algeria', 5, 213, 1, 0),(143, 'Angola', 'Angola', 5, 244, 1, 0),(144, 'Benin', 'Benin', 5, 229, 1, 0),(145, 'Botswana', 'Botswana', 5, 267, 1, 0),(146, 'Burkina Faso', 'BurkinaFaso', 5, 226, 1, 0),(147, 'Burundi', 'Burundi', 5, 257, 1, 0),(148, 'Cameroon', 'Cameroon', 5, 237, 1, 0),(149, 'Cape Verde', 'CapeVerde', 5, 238, 1, 0),(150, 'Central African Republic', 'CentralAfricanRep', 5, 236, 1, 0),(151, 'Chad', 'Chad', 5, 235, 1, 0),(152, 'Congo', 'Congo', 5, 242, 1, 0),(153, 'Democoratic Republic of Congo', 'D.R Congo', 5, 242, 1, 0),(154, 'Djibouti', 'Djibouti', 5, 253, 1, 0),(155, 'Egypt', 'Egypt', 5, 20, 1, 0),(156, 'Equatorial Guinea', 'EquatorialGuinea', 5, 240, 1, 0),(157, 'Eritrea', 'Eritrea', 5, 291, 1, 0),(158, 'Ethiopia', 'Ethiopia', 5, 251, 1, 0),(159, 'Gabon', 'Gabon', 5, 241, 1, 0),(160, 'Gambia', 'Gambia', 5, 220, 1, 0),(161, 'Ghana', 'Ghana', 5, 233, 1, 0),(162, 'Guinea', 'Guinea', 5, 224, 1, 0),(163, 'Guinea-Bissau', 'Guinea-Bissau', 5, 245, 1, 0),(164, 'Cote DIvory', 'IvoryCoast', 5, 225, 1, 0),(165, 'Kenya', 'Kenya', 5, 254, 1, 0),(166, 'Lesotho', 'Lesotho', 5, 266, 1, 0),(167, 'Liberia', 'Liberia', 5, 231, 1, 0),(168, 'Libya', 'Libya', 5, 218, 1, 0),(169, 'Madagascar', 'Madagascar', 5, 261, 1, 0),(170, 'Malawi', 'Malawi', 5, 265, 1, 0),(171, 'Mali', 'Mali', 5, 223, 1, 0),(172, 'Mauritania', 'Mauritania', 5, 222, 1, 0),(173, 'Mauritius', 'Mauritius', 5, 230, 1, 0),(174, 'Morocco', 'Morocco', 5, 212, 1, 0),(175, 'Mozambique', 'Mozambique', 5, 258, 1, 0),(176, 'Namibia', 'Namibia', 5, 264, 1, 0),(177, 'Niger', 'Niger', 5, 227, 1, 0),(178, 'Nigeria', 'Nigeria', 5, 234, 1, 0),(179, 'Reunion', 'Reunion', 5, 262, 1, 0),(180, 'Rwanda', 'Rwanda', 5, 250, 1, 0),(181, 'Sao Tome and Principe', 'SaoTome-Principe', 5, 239, 1, 0),(182, 'Senegal', 'Senegal', 5, 221, 1, 0),(183, 'Seychelles', 'Seychelles', 5, 248, 1, 0),(184, 'Sierra Leone', 'SierraLeone', 5, 232, 1, 0),(185, 'Somalia', 'Somalia', 5, 252, 1, 0),(186, 'South Africa', 'SouthAfrica', 5, 27, 1, 0),(187, 'Sudan', 'Sudan', 5, 249, 1, 0),(188, 'Swaziland', 'Swaziland', 5, 268, 1, 0),(189, 'Tanzania', 'Tanzania', 5, 255, 1, 0),(190, 'Togo', 'Togo', 5, 228, 1, 0),(191, 'Tunisia', 'Tunisia', 5, 216, 1, 0),(192, 'Uganda', 'Uganda', 5, 256, 1, 0),(193, 'Western Sahara', 'WesternSahara', 5, 212, 1, 0),(194, 'Zambia', 'Zambia', 5, 260, 1, 0),(195, 'Zimbabwe', 'Zimbabwe', 5, 263, 1, 0),(196, 'Australia', 'Australia', 6, 61, 1, 0),(197, 'New Zealand', 'NewZealand', 6, 64, 1, 0),(198, 'Fiji', 'Fiji', 6, 679, 1, 0),(199, 'French Polynesia', 'FrenchPolynesia', 6, 689, 1, 0),(200, 'Guam', 'Guam', 6, 671, 1, 0),(201, 'Kiribati', 'Kiribati', 6, 686, 1, 0),(202, 'Marshall Islands', 'MarshallIsl', 6, 692, 1, 0),(203, 'Micronesia', 'Micronesia', 6, 691, 1, 0),(204, 'Nauru', 'Nauru', 6, 674, 1, 0),(205, 'New Caledonia', 'NewCaledonia', 6, 687, 1, 0),(206, 'Papua New Guinea', 'PapuaNewGuinea', 6, 675, 1, 0),(207, 'Samoa', 'Samoa', 6, 684, 1, 0),(208, 'Solomon Islands', 'SolomonIsl', 6, 677, 1, 0),(209, 'Tonga', 'Tonga', 6, 676, 1, 0),(210, 'Tuvalu', 'Tuvalu', 6, 688, 1, 0),(211, 'Vanuatu', 'Vanuatu', 6, 678, 1, 0),(212, 'Wallis and Futuna', 'Wallis-Futuna', 6, 681, 1, 0),(213, 'Comoros', 'Comoros', 0, 0, 1, 0),(214, 'Cote DIvorie', 'Cote-DIvorie', NULL, NULL, 1, 0);

DROP TABLE IF EXISTS `#__js_job_coverletters`;
CREATE TABLE `#__js_job_coverletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `alias` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `hits` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `searchable` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `packageid` int(11) DEFAULT NULL,
  `paymenthistoryid` int(11) DEFAULT NULL,
  `serverstatus` varchar(255) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `coverletter_uid` (`uid`),
  KEY `coverletter_packgeid` (`packageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_currencies`;
CREATE TABLE `#__js_job_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) DEFAULT NULL,
  `symbol` varchar(60) DEFAULT NULL,
  `code` varchar(10) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `default` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
INSERT INTO `#__js_job_currencies` (`id`, `title`, `symbol`, `code`, `status`, `default`, `ordering`, `serverid`) VALUES(1, 'US Doller', '$', 'USD', 1, 1, 1, 0),(2, 'Pakistani Rupee', 'Rs.', 'PKR', 1, 0, 2, 0),(3, 'Pound', '£', 'GBP', 1, 0, 3, 0),(4, 'Euro', ' €', 'EUR', 1, 0, 4, 0);

DROP TABLE IF EXISTS `#__js_job_departments`;
CREATE TABLE `#__js_job_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `companyid` int(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `alias` varchar(225) NOT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `serverstatus` varchar(255) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`,`companyid`),
  KEY `departments` (`companyid`),
  KEY `departments_uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_emailtemplates`;
CREATE TABLE `#__js_job_emailtemplates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `templatefor` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;
INSERT INTO `#__js_job_emailtemplates` (`id`, `uid`, `templatefor`, `title`, `subject`, `body`, `status`, `created`) VALUES(1, 0, 'company-approval', NULL, 'Company {COMPANY_NAME} has been approved', '<div style="background: #6DC6DD; height: 20px;"> </div>\n<p style="color: #2191ad;">Dear {EMPLOYER_NAME} ,</p>\n<p style="color: #4f4f4f;">Your company <strong>{COMPANY_NAME}</strong> has been approved.</p>\n<p style="color: #4f4f4f;">Click here to view {COMPANY_LINK}.</p>\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\n</div>', 1, '2009-08-17 18:08:41'),(2, 0, 'company-rejecting', NULL, 'Your Company {COMPANY_NAME} has been rejected', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear {EMPLOYER_NAME} ,</p>\r\n<p style="color: #4f4f4f;">Your company <strong>{COMPANY_NAME}</strong> has been rejected.</p>\r\n<p style="color: #4f4f4f;">Click here to view {COMPANY_LINK}.</p>\r\n<p style="color: #4f4f4f;">Login and view detail at</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2009-08-17 17:54:48'),(4, 0, 'job-approval', NULL, 'Your job {JOB_TITLE} has been approved.', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear {EMPLOYER_NAME} ,</p>\r\n<p style="color: #4f4f4f;">Your job <strong>{JOB_TITLE}</strong> has been approved.</p>\r\n<p style="color: #4f4f4f;">Click here to view {JOB_LINK}.</p>\r\n<p style="color: #4f4f4f;">Login and view detail at</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2009-08-17 22:10:27'),(5, 0, 'job-rejecting', NULL, 'Your job {JOB_TITLE} has been rejected.', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear {EMPLOYER_NAME} ,</p>\r\n<p style="color: #4f4f4f;">Your job <strong>{JOB_TITLE}</strong> has been rejected.</p>\r\n<p style="color: #4f4f4f;">Click here to view {JOB_LINK}.</p>\r\n<p style="color: #4f4f4f;">Login and view detail at</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2009-08-17 22:12:43'),(6, 0, 'resume-approval', NULL, 'Your resume {RESUME_TITLE} has been approval.', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear {JOBSEEKER_NAME} ,</p>\r\n<p style="color: #4f4f4f;">Your resume <strong>{RESUME_TITLE}</strong> has been approval.</p>\r\n<p style="color: #4f4f4f;">Click here to view {RESUME_LINK}.</p>\r\n<p style="color: #4f4f4f;">Login and view detail at</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2009-08-17 22:15:12'),(7, 0, 'resume-rejecting', NULL, 'Your resume {RESUME_TITLE} has been rejected. ', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear {JOBSEEKER_NAME} ,</p>\r\n<p style="color: #4f4f4f;">Your resume <strong>{RESUME_TITLE}</strong> has been rejected.</p>\r\n<p style="color: #4f4f4f;">Click here to view {RESUME_LINK}.</p>\r\n<p style="color: #4f4f4f;">Login and view detail at</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2009-08-17 22:14:52'),(8, 0, 'jobapply-jobapply', NULL, 'JS Jobs :  {JOBSEEKER_NAME} apply for {JOB_TITLE}', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Hello {EMPLOYER_NAME} ,</p>\r\n<p style="color: #4f4f4f;">Mr/Mrs {JOBSEEKER_NAME} apply for {JOB_TITLE}.</p>\r\n<p style="color: #4f4f4f;">Click here to view {RESUME_LINK} .</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2009-08-18 16:46:16'),(9, 0, 'company-new', NULL, 'JS Jobs : New Company {COMPANY_NAME} has beed received', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Hello Admin ,</p>\r\n<p style="color: #4f4f4f;">We receive new company.</p>\r\n<p style="color: #4f4f4f;">Click here to view {COMPANY_LINK}.</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\r\n</div>', NULL, '2009-08-18 16:46:16'),(10, 0, 'job-new', NULL, 'JS Jobs : New Job {JOB_TITLE} has beed received', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Hello Admin ,</p>\r\n<p style="color: #4f4f4f;">We receive new job.</p>\r\n<p style="color: #4f4f4f;">Click here to view  {JOB_LINK}.</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\r\n</div>', NULL, '2009-08-18 16:46:16'),(11, 0, 'resume-new', NULL, 'JS Jobs :  New resume {RESUME_TITLE} has beed received', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Hello Admin ,</p>\r\n<p style="color: #4f4f4f;">We receive new resume.</p>\r\n<p style="color: #4f4f4f;">Click here to view {RESUME_LINK}.</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\r\n</div>', NULL, '2009-08-18 16:46:16'),(12, 0, 'department-new', NULL, 'JS Jobs : New Department {DEPARTMENT_NAME} {COMPANY_NAME} has beed received', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Hello Admin ,</p>\r\n<p style="color: #4f4f4f;">We receive new department.</p>\r\n<p style="color: #4f4f4f;">Login and view detail at</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2009-08-18 16:46:16'),(13, 0, 'employer-buypackage', NULL, 'JS Jobs : Employer Buy Package {PACKAGE_NAME}', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Hello Admin ,</p>\r\n<p style="color: #4f4f4f;">Employer buy a package.</p>\r\n<p style="color: #4f4f4f;">Click here to view {PACKAGE_LINK}.</p>\r\n<p style="color: #4f4f4f;">Login and view detail.</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2009-08-18 16:46:16'),(14, 0, 'jobseeker-buypackage', NULL, 'JS Jobs : Jobseeker Buy Package {PACKAGE_NAME}', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Hello Admin ,</p>\r\n<p style="color: #4f4f4f;">Job Seeker buy package.</p>\r\n<p style="color: #4f4f4f;">Click here to view {PACKAGE_LINK}.</p>\r\n<p style="color: #4f4f4f;">Login and view detail at</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2009-08-18 16:46:16'),(15, 0, 'message-email', NULL, 'JS Jobs: New Message Alert', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear {NAME},</p>\r\n<p style="color: #4f4f4f;">{SENDER_NAME}: send you new message.</p>\r\n<div style="display: block; padding: 20px; color: #4f4f4f; background: #F5FEFF; border: 1px solid #B7EAF7;">\r\n<p><strong><span style="text-decoration: underline;">Summary</span></strong></p>\r\n<p>Company Name: {COMPANY_NAME}</p>\r\n<p>Job Title: {JOB_TITLE}</p>\r\n<p>Resume Title: {RESUME_TITLE}</p>\r\n<p>Subject: {SUBJECT}</p>\r\n<p>Message: {MESSAGE}</p>\r\n</div>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\r\n</div>', 1, '2009-08-18 16:46:16'),(16, 0, 'job-alert', NULL, 'JS Jobs: New Job', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear {JOBSEEKER_NAME} ,</p>\r\n<p style="color: #4f4f4f;">We receive new job.</p>\r\n<p>{JOBS_INFO}</p>\r\n<p style="color: #4f4f4f;">Login and view detail at</p>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br /> It is automatically generated and is for information purposes only.</p>\r\n</div>', NULL, '2011-03-31 16:46:16'),(17, 0, 'job-alert-visitor', NULL, 'JS Jobs: New Job By Visitor', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear {CONTACT_NAME} ,</p>\r\n<p style="color: #4f4f4f;">We receive new job</p>\r\n<div style="display: block; padding: 20px; color: #4f4f4f; background: #F5FEFF; border: 1px solid #B7EAF7;">\r\n<p><strong><span style="text-decoration: underline;">Summary</span></strong></p>\r\n<p>Title: {JOB_TITLE}</p>\r\n<p>Job Category: {JOB_CATEGORY}</p>\r\n<p>Company Name: {COMPANY_NAME}</p>\r\n<p>Status: {JOB_STATUS}</p>\r\n</div>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\r\n</div>', NULL, '2011-03-31 16:46:16'),(18, 0, 'job-to-friend', NULL, 'JS Jobs : Your friend find a job', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear</p>\r\n<p style="color: #4f4f4f;">Your Friend {SENDER_NAME} will send you this mail through our site {SITE_NAME} to inform you for a job.</p>\r\n<div style="display: block; padding: 20px; color: #4f4f4f; background: #F5FEFF; border: 1px solid #B7EAF7;">\r\n<p><strong><span style="text-decoration: underline;">Summary</span></strong></p>\r\n<p>Title: {JOB_TITLE}</p>\r\n<p>Category {JOB_CATEGORY}</p>\r\n<p>Company : {COMPANY_NAME}</p>\r\n<p>{CLICK_HERE_TO_VISIT} the job detail.</p>\r\n<p>{SENDER_MESSAGE}</p>\r\n<p>Thank you.</p>\r\n</div>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\r\n</div>', 1, '2011-03-31 16:46:16'),(19, 0, 'applied-resume_status', NULL, 'JS Jobs : Your applied resume status update', '<div style="background: #6DC6DD; height: 20px;"> </div>\r\n<p style="color: #2191ad;">Dear{JOBSEEKER_NAME}</p>\r\n<p style="color: #4f4f4f;">You are applied for job  {JOB_TITLE}.</p>\r\n<p style="color: #4f4f4f;">Your resume has been mark as {RESUME_STATUS}.</p>\r\n<div>Click here to view {STATUS} .<br />\r\n<p>Thank you.</p>\r\n</div>\r\n<div style="margin-top: 10px; padding: 10px 20px; color: #000000; background: #FAF2F2; border: 1px solid #F7C1C1;">\r\n<p><span style="color: red;"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we can''"t receive your reply!</p>\r\n</div>', 1, '2011-03-31 16:46:16');

DROP TABLE IF EXISTS `#__js_job_employerpackages`;
CREATE TABLE `#__js_job_employerpackages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `currencyid` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `discounttype` tinyint(4) DEFAULT NULL,
  `discountmessage` varchar(500) DEFAULT NULL,
  `discountstartdate` datetime DEFAULT NULL,
  `discountenddate` datetime DEFAULT NULL,
  `companiesallow` int(11) NOT NULL,
  `jobsallow` int(11) NOT NULL,
  `viewresumeindetails` int(11) NOT NULL,
  `resumesearch` int(11) NOT NULL,
  `saveresumesearch` int(11) NOT NULL,
  `featuredcompaines` int(11) NOT NULL,
  `goldcompanies` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `featuredjobs` int(11) NOT NULL,
  `goldjobs` int(11) NOT NULL,
  `jobseekershortlist` tinyint(4) DEFAULT NULL,
  `shortdetails` varchar(1000) DEFAULT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL,
  `video` tinyint(4) DEFAULT NULL,
  `map` tinyint(4) DEFAULT NULL,
  `packageexpireindays` int(11) NOT NULL,
  `featuredcompaniesexpireindays` int(11) DEFAULT NULL,
  `goldcompaniesexpireindays` int(11) DEFAULT NULL,
  `featuredjobsexpireindays` int(11) DEFAULT NULL,
  `goldjobsexpireindays` int(11) DEFAULT NULL,
  `enforcestoppublishjob` tinyint(1) DEFAULT '0',
  `enforcestoppublishjobvalue` int(11) DEFAULT NULL,
  `enforcestoppublishjobtype` tinyint(4) DEFAULT NULL,
  `fastspringlink` varchar(1000) DEFAULT NULL,
  `otherpaymentlink` varchar(1000) DEFAULT NULL,
  `messageallow` tinyint(1) DEFAULT NULL,
  `folders` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
INSERT INTO `#__js_job_employerpackages` (`id`, `title`, `currencyid`, `price`, `discount`, `discounttype`, `discountmessage`, `discountstartdate`, `discountenddate`, `companiesallow`, `jobsallow`, `viewresumeindetails`, `resumesearch`, `saveresumesearch`, `featuredcompaines`, `goldcompanies`, `created`, `featuredjobs`, `goldjobs`, `jobseekershortlist`, `shortdetails`, `description`, `status`, `video`, `map`, `packageexpireindays`, `featuredcompaniesexpireindays`, `goldcompaniesexpireindays`, `featuredjobsexpireindays`, `goldjobsexpireindays`, `enforcestoppublishjob`, `enforcestoppublishjobvalue`, `enforcestoppublishjobtype`, `fastspringlink`, `otherpaymentlink`, `messageallow`, `folders`) 
VALUES(1, 'Free Package', 1, 0, 0, 1, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 100, -1, 1, 1, 10, 10, '2012-11-08 00:00:00', 10, 10, 1, 'Free Package for five companies', 'Free Package for five companies', 1, 1, 1, 365, 30, 30, 30, 30, 1, 30, 1, '', '', 1, 10);

DROP TABLE IF EXISTS `#__js_job_experiences`;
CREATE TABLE `#__js_job_experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;
INSERT INTO `#__js_job_experiences` (`id`, `title`, `status`, `isdefault`, `ordering`, `serverid`) VALUES(1, 'Fresh', 1, 0, 1, 0),(2, 'Less then 1 Year', 1, 0, 2, 0),(3, '1 Year', 1, 0, 3, 0),(4, '2 Year', 1, 0, 4, 0),(5, '3 Year', 1, 1, 5, 0),(6, '4 Year', 1, 0, 6, 0),(7, '5 Year', 1, 0, 7, 0),(8, '6 Year', 1, 0, 8, 0),(9, '7 Year', 1, 0, 9, 0),(10, '8 Year', 1, 0, 10, 0),(11, '9 Year', 1, 0, 11, 0),(12, '10 Year', 1, 0, 12, 0),(13, '11 Year', 1, 0, 13, 0),(14, '12 Year', 1, 0, 14, 0),(15, '13 Year', 1, 0, 15, 0),(16, '14 Year', 1, 0, 16, 0),(17, '15 Year', 1, 0, 17, 0),(18, '16 Year', 1, 0, 18, 0),(19, '17 Year', 1, 0, 19, 0),(20, '18 Year', 1, 0, 20, 0),(21, '19 Year', 1, 0, 21, 0),(22, '20 Year', 1, 0, 22, 0),(23, '21 Year', 1, 0, 23, 0),(24, '22 Year', 1, 0, 24, 0),(25, '23 Year', 1, 0, 25, 0),(26, '24 Year', 1, 0, 26, 0),(27, '25 Year', 1, 0, 27, 0);

DROP TABLE IF EXISTS `#__js_job_fieldsordering`;
CREATE TABLE `#__js_job_fieldsordering` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` varchar(50) NOT NULL,
  `fieldtitle` varchar(50) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `section` varchar(20) DEFAULT NULL,
  `fieldfor` tinyint(2) DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `isvisitorpublished` tinyint(1) DEFAULT NULL,
  `sys` tinyint(1) NOT NULL,
  `cannotunpublish` tinyint(1) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fieldordering_filedfor` (`fieldfor`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=865 ;
INSERT INTO `#__js_job_fieldsordering` (`id`, `field`, `fieldtitle`, `ordering`, `section`, `fieldfor`, `published`, `isvisitorpublished`, `sys`, `cannotunpublish`, `required`) VALUES(1, 'jobcategory', 'Job Category', 2, NULL, 1, 1, 1, 1, 1, 1),(2, 'name', 'Name', 1, NULL, 1, 1, 1, 1, 1, 1),(3, 'url', 'URL', 3, NULL, 1, 1, 1, 0, 0, 0),(4, 'contactname', 'Contact Name', 4, NULL, 1, 1, 1, 0, 1, 0),(5, 'contactphone', 'Contact Phone', 5, NULL, 1, 1, 1, 0, 0, 0),(6, 'contactemail', 'Contact Email', 6, NULL, 1, 1, 1, 0, 1, 0),(7, 'since', 'Since', 8, NULL, 1, 1, 1, 0, 0, 0),(8, 'companysize', 'Company Size', 9, NULL, 1, 1, 1, 0, 0, 0),(9, 'income', 'Income', 10, NULL, 1, 1, 1, 0, 0, 0),(10, 'description', 'Description', 11, NULL, 1, 1, 1, 0, 0, 0),(11, 'address1', 'Address1', 17, NULL, 1, 1, 1, 0, 0, 0),(12, 'logo', 'Logo', 19, NULL, 1, 1, 1, 0, 0, 0),(20, 'contactfax', 'Contact Fax', 7, NULL, 1, 0, 1, 0, 0, 0),(23, 'city', 'City', 14, '', 1, 1, 1, 0, 0, 0),(25, 'zipcode', 'Zipcode', 16, NULL, 1, 1, 1, 0, 0, 0),(26, 'address2', 'Address2', 18, NULL, 1, 1, 1, 0, 0, 0),(101, 'jobtitle', 'Job Title', 1, NULL, 2, 1, 1, 1, 1, 1),(102, 'company', 'Company', 2, NULL, 2, 1, 1, 1, 1, 1),(103, 'department', 'Department', 3, NULL, 2, 1, 1, 0, 0, 0),(104, 'jobcategory', 'Job Category', 4, NULL, 2, 1, 1, 1, 1, 1),(105, 'subcategory', 'Sub Category', 5, NULL, 2, 1, 1, 0, 0, 0),(106, 'jobtype', 'Job Type', 6, NULL, 2, 1, 1, 1, 1, 1),(107, 'jobstatus', 'Job Status', 7, NULL, 2, 1, 1, 0, 0, 0),(108, 'gender', 'Gender', 8, NULL, 2, 1, 1, 0, 0, 0),(109, 'age', 'Age', 9, NULL, 2, 1, 1, 0, 0, 0),(110, 'jobsalaryrange', 'Job Salary Range', 10, NULL, 2, 1, 1, 0, 0, 0),(111, 'jobshift', 'Job Shift', 11, NULL, 2, 1, 1, 0, 0, 0),(112, 'heighesteducation', 'Heighest Education', 12, NULL, 2, 1, 1, 0, 0, 0),(113, 'experience', 'Experience', 13, NULL, 2, 1, 1, 0, 0, 0),(114, 'noofjobs', 'No of Jobs', 14, NULL, 2, 1, 1, 0, 0, 0),(115, 'duration', 'Duration', 15, NULL, 2, 1, 1, 0, 0, 0),(116, 'careerlevel', 'Career Level', 16, NULL, 2, 1, 1, 0, 0, 0),(117, 'workpermit', 'Work Permit', 17, NULL, 2, 1, 1, 0, 0, 0),(118, 'requiredtravel', 'Required Travel', 18, NULL, 2, 1, 1, 0, 0, 0),(119, 'video', 'Video', 19, NULL, 2, 1, 1, 0, 0, 0),(120, 'map', 'Map', 20, NULL, 2, 1, 1, 0, 0, 0),(121, 'startpublishing', 'Start Publishing', 21, NULL, 2, 1, 1, 1, 1, 1),(122, 'stoppublishing', 'Stop Publishing', 22, NULL, 2, 1, 1, 1, 1, 1),(125, 'city', 'City', 25, NULL, 2, 1, 1, 0, 0, 0),(130, 'sendemail', 'Send Email', 27, NULL, 2, 1, 1, 0, 0, 0),(131, 'sendmeresume', 'Send me Resume', 28, NULL, 2, 1, 1, 0, 0, 0),(132, 'description', 'Description', 29, NULL, 2, 1, 1, 1, 1, 1),(133, 'qualifications', 'Qualifications', 30, NULL, 2, 1, 1, 0, 0, 0),(134, 'prefferdskills', 'Prefered Skills', 31, NULL, 2, 1, 1, 0, 0, 0),(135, 'agreement', 'Agreement', 32, NULL, 2, 1, 1, 0, 0, 0),(136, 'metadescription', 'Meta Description', 33, NULL, 2, 1, 1, 0, 0, 0),(137, 'metakeywords', 'Meta Keywords', 34, NULL, 2, 1, 1, 0, 0, 0),(127, 'zipcode', 'Zipcode', 26, NULL, 2, 1, 1, 0, 0, 0),(301, 'section_personal', 'Personal Information', 0, '10', 3, 1, 1, 1, 1, 1),(302, 'applicationtitle', 'Application Title', 1, '10', 3, 1, 1, 1, 1, 1),(303, 'firstname', 'First Name', 5, '10', 3, 1, 1, 1, 1, 1),(304, 'middlename', 'Middle Name', 3, '10', 3, 1, 1, 0, 0, 0),(305, 'lastname', 'Last Name', 4, '10', 3, 1, 1, 1, 1, 1),(306, 'emailaddress', 'Email Address', 2, '10', 3, 1, 1, 1, 1, 1),(307, 'homephone', 'Home Phone', 7, '10', 3, 1, 1, 0, 0, 0),(308, 'workphone', 'Work Phone', 8, '10', 3, 1, 1, 0, 0, 0),(309, 'cell', 'Cell', 9, '10', 3, 1, 1, 0, 0, 0),(310, 'nationality', 'Nationality', 10, '10', 3, 1, 1, 0, 0, 0),(311, 'gender', 'Gender', 12, '10', 3, 1, 1, 0, 0, 0),(312, 'photo', 'Photo', 6, '10', 3, 1, 1, 0, 0, 0),(453, 'fileupload', 'File Upload', 14, '10', 3, 1, 1, 0, 0, 0),(313, 'section_basic', 'Basic Information', 15, '20', 3, 1, 1, 1, 1, 1),(314, 'category', 'Category', 16, '20', 3, 1, 1, 0, 0, 0),(315, 'salary', 'Salary ', 18, '20', 3, 1, 1, 0, 0, 0),(316, 'jobtype', 'Job Type', 18, '20', 3, 1, 1, 0, 0, 0),(317, 'heighesteducation', 'Heighest Education', 19, '20', 3, 1, 1, 0, 0, 0),(318, 'totalexperience', 'Total Experience', 20, '20', 3, 1, 1, 0, 0, 0),(319, 'startdate', 'Date you can start', 19, '20', 3, 1, 1, 0, 0, 0),(320, 'section_addresses', 'Addresses', 42, '30', 3, 1, 1, 0, 0, 0),(321, 'section_sub_address', 'Current Address', 43, '31', 3, 1, 1, 0, 0, 0),(325, 'address_city', 'City', 47, '31', 3, 1, 1, 0, 0, 0),(326, 'address_zipcode', 'Zip Code', 48, '31', 3, 1, 1, 0, 0, 0),(327, 'address_address', 'Address', 49, '31', 3, 1, 1, 0, 0, 0),(328, 'section_sub_address1', 'Address1', 51, '32', 3, 1, 1, 0, 0, 0),(332, 'address1_city', 'City', 55, '32', 3, 1, 1, 0, 0, 0),(333, 'address1_zipcode', 'Zip Code', 56, '32', 3, 1, 1, 0, 0, 0),(334, 'address1_address', 'Address', 57, '32', 3, 1, 1, 0, 0, 0),(335, 'section_sub_address2', 'Address1', 61, '33', 3, 1, 1, 0, 0, 0),(339, 'address2_city', 'City', 65, '33', 3, 1, 1, 0, 0, 0),(340, 'address2_zipcode', 'Zip Code', 66, '33', 3, 1, 1, 0, 0, 0),(341, 'address2_address', 'Address', 67, '33', 3, 1, 1, 0, 0, 0),(342, 'section_education', 'Education', 71, '40', 3, 1, 1, 0, 0, 0),(343, 'section_sub_institute', 'High School', 72, '41', 3, 1, 1, 0, 0, 0),(344, 'institute_institute', 'Institute', 73, '41', 3, 1, 1, 0, 0, 0),(348, 'institute_city', 'City', 77, '41', 3, 1, 1, 0, 0, 0),(349, 'institute_address', 'Address', 78, '41', 3, 1, 1, 0, 0, 0),(350, 'institute_certificate', 'Certificate Name', 79, '41', 3, 1, 1, 0, 0, 0),(351, 'institute_study_area', 'Study Area', 80, '41', 3, 1, 1, 0, 0, 0),(352, 'section_sub_institute1', 'University', 82, '42', 3, 1, 1, 0, 0, 0),(353, 'institute1_institute', 'Institute', 83, '42', 3, 1, 1, 0, 0, 0),(357, 'institute1_city', 'City', 87, '42', 3, 1, 1, 0, 0, 0),(358, 'institute1_address', 'Address', 88, '42', 3, 1, 1, 0, 0, 0),(359, 'institute1_certificate', 'Certificate Name', 89, '42', 3, 1, 1, 0, 0, 0),(360, 'institute1_study_area', 'Study Area', 90, '42', 3, 1, 1, 0, 0, 0),(361, 'section_sub_institute2', 'Grade School', 92, '43', 3, 1, 1, 0, 0, 0),(362, 'institute2_institute', 'Institute', 93, '43', 3, 1, 1, 0, 0, 0),(366, 'institute2_city', 'City', 97, '43', 3, 1, 1, 0, 0, 0),(367, 'institute2_address', 'Address', 98, '43', 3, 1, 1, 0, 0, 0),(368, 'institute2_certificate', 'Certificate Name', 99, '43', 3, 1, 1, 0, 0, 0),(369, 'institute2_study_area', 'Study Area', 100, '43', 3, 1, 1, 0, 0, 0),(370, 'section_sub_institute3', 'Other School', 102, '44', 3, 1, 1, 0, 0, 0),(371, 'institute3_institute', 'Institute', 103, '44', 3, 1, 1, 0, 0, 0),(375, 'institute3_city', 'City', 107, '44', 3, 1, 1, 0, 0, 0),(376, 'institute3_address', 'Address', 108, '44', 3, 1, 1, 0, 0, 0),(377, 'institute3_certificate', 'Certificate Name', 109, '44', 3, 1, 1, 0, 0, 0),(378, 'institute3_study_area', 'Study Area', 110, '44', 3, 1, 1, 0, 0, 0),(379, 'section_employer', 'Employer', 112, '50', 3, 1, 1, 0, 0, 0),(380, 'section_sub_employer', 'Recent Employer', 113, '51', 3, 1, 1, 0, 0, 0),(381, 'employer_employer', 'Employer', 114, '51', 3, 1, 1, 0, 0, 0),(382, 'employer_position', 'Position', 114, '51', 3, 1, 1, 0, 0, 0),(383, 'employer_resp', 'Responsibilities', 115, '51', 3, 1, 1, 0, 0, 0),(384, 'employer_pay_upon_leaving', 'Pay Upon Leaving', 116, '51', 3, 1, 1, 0, 0, 0),(385, 'employer_supervisor', 'Supervisor', 117, '51', 3, 1, 1, 0, 0, 0),(386, 'employer_from_date', 'From Date', 118, '51', 3, 1, 1, 0, 0, 0),(387, 'employer_to_date', 'To Date', 119, '51', 3, 1, 1, 0, 0, 0),(388, 'employer_leave_reason', 'Leave Reason', 120, '51', 3, 1, 1, 0, 0, 0),(392, 'employer_city', 'City', 124, '51', 3, 1, 1, 0, 0, 0),(393, 'employer_zip', 'Zip Code', 125, '51', 3, 1, 1, 0, 0, 0),(394, 'employer_phone', 'Phone', 126, '51', 3, 1, 1, 0, 0, 0),(395, 'employer_address', 'Address', 127, '51', 3, 1, 1, 0, 0, 0),(396, 'section_sub_employer1', 'Prior Employer 1', 128, '52', 3, 1, 1, 0, 0, 0),(397, 'employer1_employer', 'Employer', 129, '52', 3, 1, 1, 0, 0, 0),(398, 'employer1_position', 'Position', 130, '52', 3, 1, 1, 0, 0, 0),(399, 'employer1_resp', 'Responsibilities', 131, '52', 3, 1, 1, 0, 0, 0),(400, 'employer1_pay_upon_leaving', 'Pay Upon Leaving', 132, '52', 3, 1, 1, 0, 0, 0),(401, 'employer1_supervisor', 'Supervisor', 133, '52', 3, 1, 1, 0, 0, 0),(402, 'employer1_from_date', 'From Date', 134, '52', 3, 1, 1, 0, 0, 0),(403, 'employer1_to_date', 'To Date', 135, '52', 3, 1, 1, 0, 0, 0),(404, 'employer1_leave_reason', 'Leave Reason', 136, '52', 3, 1, 1, 0, 0, 0),(408, 'employer1_city', 'City', 140, '52', 3, 1, 1, 0, 0, 0),(409, 'employer1_zip', 'Zip Code', 141, '52', 3, 1, 1, 0, 0, 0),(410, 'employer1_phone', 'Phone', 142, '52', 3, 1, 1, 0, 0, 0),(412, 'employer1_address', 'Address', 143, '52', 3, 1, 1, 0, 0, 0),(413, 'section_sub_employer2', 'Prior Employer 2', 146, '53', 3, 1, 1, 0, 0, 0),(414, 'employer2_employer', 'Employer', 147, '53', 3, 1, 1, 0, 0, 0),(415, 'employer2_position', 'Position', 148, '53', 3, 1, 1, 0, 0, 0),(416, 'employer2_resp', 'Responsibilities', 149, '53', 3, 1, 1, 0, 0, 0),(417, 'employer2_pay_upon_leaving', 'Pay Upon Leaving', 150, '53', 3, 1, 1, 0, 0, 0),(418, 'employer2_supervisor', 'Supervisor', 151, '53', 3, 1, 1, 0, 0, 0),(419, 'employer2_from_date', 'From Date', 152, '53', 3, 1, 1, 0, 0, 0),(420, 'employer2_to_date', 'To Date', 153, '53', 3, 1, 1, 0, 0, 0),(421, 'employer2_leave_reason', 'Leave Reason', 154, '53', 3, 1, 1, 0, 0, 0),(426, 'employer2_city', 'City', 158, '53', 3, 1, 1, 0, 0, 0),(427, 'employer2_zip', 'Zip Code', 159, '53', 3, 1, 1, 0, 0, 0),(428, 'employer2_phone', 'Phone', 160, '53', 3, 1, 1, 0, 0, 0),(429, 'employer2_address', 'Address', 161, '53', 3, 1, 1, 0, 0, 0),(430, 'section_sub_employer3', 'Prior Employer 3', 166, '54', 3, 1, 1, 0, 0, 0),(431, 'employer3_employer', 'Employer', 167, '54', 3, 1, 1, 0, 0, 0),(432, 'employer3_position', 'Position', 168, '54', 3, 1, 1, 0, 0, 0),(433, 'employer3_resp', 'Responsibilities', 169, '54', 3, 1, 1, 0, 0, 0),(434, 'employer3_pay_upon_leaving', 'Pay Upon Leaving', 170, '54', 3, 1, 1, 0, 0, 0),(435, 'employer3_supervisor', 'Supervisor', 171, '54', 3, 1, 1, 0, 0, 0),(436, 'employer3_from_date', 'From Date', 172, '54', 3, 1, 1, 0, 0, 0),(437, 'employer3_to_date', 'To Date', 173, '54', 3, 1, 1, 0, 0, 0),(438, 'employer3_leave_reason', 'Leave Reason', 174, '54', 3, 1, 1, 0, 0, 0),(442, 'employer3_city', 'City', 178, '54', 3, 1, 1, 0, 0, 0),(443, 'employer3_zip', 'Zip Code', 179, '54', 3, 1, 1, 0, 0, 0),(444, 'employer3_phone', 'Phone', 180, '54', 3, 1, 1, 0, 0, 0),(445, 'employer3_address', 'Address', 181, '54', 3, 1, 1, 0, 0, 0),(446, 'section_skills', 'Skills', 186, '60', 3, 1, 1, 0, 0, 0),(447, 'driving_license', 'Driving License', 187, '60', 3, 1, 1, 0, 0, 0),(448, 'license_no', 'License No', 188, '60', 3, 1, 1, 0, 0, 0),(449, 'license_country', 'License Country', 189, '60', 3, 1, 1, 0, 0, 0),(450, 'skills', 'Skills', 190, '60', 3, 1, 1, 0, 0, 0),(451, 'section_resumeeditor', 'Resume Editor', 196, '70', 3, 1, 1, 0, 0, 0),(452, 'editor', 'Editor', 197, '70', 3, 1, 1, 0, 0, 0),(454, 'section_references', 'References', 206, '80', 3, 1, 1, 0, 0, 0),(455, 'section_sub_reference', 'Reference 1', 207, '81', 3, 1, 1, 0, 0, 0),(456, 'reference_reference', 'Reference', 208, '81', 3, 1, 1, 0, 0, 0),(457, 'reference_name', 'Name', 209, '81', 3, 1, 1, 0, 0, 0),(471, 'reference_city', 'City', 213, '81', 3, 1, 1, 0, 0, 0),(472, 'reference_zipcode', 'Zip Code', 214, '81', 3, 1, 1, 0, 0, 0),(473, 'reference_phone', 'Phone', 215, '81', 3, 1, 1, 0, 0, 0),(474, 'reference_relation', 'Relation', 216, '81', 3, 1, 1, 0, 0, 0),(475, 'reference_years', 'Years', 217, '81', 3, 1, 1, 0, 0, 0),(476, 'section_sub_reference1', 'Reference 2', 221, '82', 3, 1, 1, 0, 0, 0),(477, 'reference1_reference', 'Reference', 222, '82', 3, 1, 1, 0, 0, 0),(478, 'reference1_name', 'Name', 223, '82', 3, 1, 1, 0, 0, 0),(482, 'reference1_city', 'City', 227, '82', 3, 1, 1, 0, 0, 0),(483, 'reference1_zipcode', 'Zip Code', 228, '82', 3, 1, 1, 0, 0, 0),(484, 'reference1_phone', 'Phone', 229, '82', 3, 1, 1, 0, 0, 0),(485, 'reference1_relation', 'Relation', 230, '82', 3, 1, 1, 0, 0, 0),(486, 'reference1_years', 'Years', 231, '82', 3, 1, 1, 0, 0, 0),(487, 'section_sub_reference2', 'Reference 3', 232, '83', 3, 1, 1, 0, 0, 0),(488, 'reference2_reference', 'Reference', 233, '83', 3, 1, 1, 0, 0, 0),(489, 'reference2_name', 'Name', 234, '83', 3, 1, 1, 0, 0, 0),(493, 'reference2_city', 'City', 238, '83', 3, 1, 1, 0, 0, 0),(494, 'reference2_zipcode', 'Zip Code', 239, '83', 3, 1, 1, 0, 0, 0),(495, 'reference2_phone', 'Phone', 240, '83', 3, 1, 1, 0, 0, 0),(496, 'reference2_relation', 'Relation', 241, '83', 3, 1, 1, 0, 0, 0),(497, 'reference2_years', 'Years', 242, '83', 3, 1, 1, 0, 0, 0),(498, 'section_sub_reference3', 'Reference 4', 243, '84', 3, 1, 1, 0, 0, 0),(499, 'reference3_reference', 'Reference', 244, '84', 3, 1, 1, 0, 0, 0),(500, 'reference3_name', 'Name', 245, '84', 3, 1, 1, 0, 0, 0),(504, 'reference3_city', 'City', 249, '84', 3, 1, 1, 0, 0, 0),(505, 'reference3_zipcode', 'Zip Code', 250, '84', 3, 1, 1, 0, 0, 0),(506, 'reference3_phone', 'Phone', 251, '84', 3, 1, 1, 0, 0, 0),(507, 'reference3_relation', 'Relation', 252, '84', 3, 1, 1, 0, 0, 0),(508, 'reference3_years', 'Years', 253, '84', 3, 1, 1, 0, 0, 0),(510, 'Iamavailable', 'I am Available', 13, '10', 3, 1, 1, 0, 0, 0),(511, 'searchable', 'Searchable', 13, '10', 3, 1, 1, 0, 0, 0),(512, 'section_userfields', 'User Fields', 21, '1000', 3, 1, 1, 0, 0, 0),(513, 'userfield1', 'User Field 1', 22, '1000', 3, 0, 0, 0, 0, 0),(514, 'userfield2', 'User Field 2', 23, '1000', 3, 0, 0, 0, 0, 0),(515, 'userfield3', 'User Field 3', 24, '1000', 3, 0, 0, 0, 0, 0),(516, 'userfield4', 'User Field 4', 25, '1000', 3, 0, 0, 0, 0, 0),(517, 'userfield5', 'User Field 5', 26, '1000', 3, 0, 0, 0, 0, 0),(518, 'userfield6', 'User Field 6', 27, '1000', 3, 0, 0, 0, 0, 0),(519, 'userfield7', 'User Field 7', 28, '1000', 3, 0, 0, 0, 0, 0),(520, 'userfield8', 'User Field 8', 29, '1000', 3, 0, 0, 0, 0, 0),(521, 'userfield9', 'User Field 9', 30, '1000', 3, 0, 0, 0, 0, 0),(522, 'userfield10', 'User Field 10', 32, '1000', 3, 0, 0, 0, 0, 0),(523, 'jobcategory', 'Job Category', 1, NULL, 11, 1, NULL, 0, 1, 1),(524, 'name', 'Name', 2, NULL, 11, 1, NULL, 0, 1, 0),(525, 'url', 'URL', 3, NULL, 11, 0, NULL, 0, 0, 0),(526, 'contactname', 'Contact Name', 4, NULL, 11, 1, NULL, 0, 1, 0),(527, 'contactphone', 'Contact Phone', 5, NULL, 11, 0, NULL, 0, 0, 0),(528, 'contactemail', 'Contact Email', 6, NULL, 11, 1, NULL, 0, 1, 0),(529, 'since', 'Since', 8, NULL, 11, 0, NULL, 0, 0, 0),(530, 'companysize', 'Company Size', 9, NULL, 11, 0, NULL, 0, 0, 0),(531, 'income', 'Income', 10, NULL, 11, 1, NULL, 0, 0, 0),(532, 'description', 'Description', 11, NULL, 11, 1, NULL, 0, 0, 0),(533, 'address1', 'Address1', 17, NULL, 11, 1, NULL, 0, 0, 0),(534, 'logo', 'Logo', 19, NULL, 11, 1, NULL, 0, 0, 0),(535, 'contactfax', 'Contact Fax', 7, NULL, 11, 0, NULL, 0, 0, 0),(538, 'city', 'City', 14, '', 11, 1, NULL, 0, 0, 0),(540, 'zipcode', 'Zipcode', 16, NULL, 11, 1, NULL, 0, 0, 0),(541, 'address2', 'Address2', 18, NULL, 11, 1, NULL, 0, 0, 0),(542, 'jobtitle', 'Job Title', 1, NULL, 12, 1, NULL, 0, 1, 1),(543, 'company', 'Company', 2, NULL, 12, 1, NULL, 0, 1, 1),(544, 'department', 'Department', 3, NULL, 12, 1, NULL, 0, 0, 1),(545, 'jobcategory', 'Job Category', 4, NULL, 12, 1, NULL, 0, 1, 1),(546, 'subcategory', 'Sub Category', 5, NULL, 12, 1, NULL, 0, 0, 0),(547, 'jobtype', 'Job Type', 6, NULL, 12, 1, NULL, 0, 1, 1),(548, 'jobstatus', 'Job Status', 7, NULL, 12, 1, NULL, 0, 1, 1),(549, 'gender', 'Gender', 8, NULL, 12, 1, NULL, 0, 0, 0),(550, 'age', 'Age', 9, NULL, 12, 1, NULL, 0, 0, 0),(551, 'jobsalaryrange', 'Job Salary Range', 10, NULL, 12, 1, NULL, 0, 0, 0),(552, 'jobshift', 'Job Shift', 11, NULL, 12, 1, NULL, 0, 0, 0),(553, 'heighesteducation', 'Heighest Education', 12, NULL, 12, 1, NULL, 0, 1, 0),(554, 'experience', 'Experience', 13, NULL, 12, 1, NULL, 0, 1, 0),(555, 'noofjobs', 'No of Jobs', 14, NULL, 12, 1, NULL, 0, 0, 0),(556, 'duration', 'Duration', 15, NULL, 12, 1, NULL, 0, 0, 0),(557, 'careerlevel', 'Career Level', 16, NULL, 12, 1, NULL, 0, 0, 0),(558, 'workpermit', 'Work Permit', 17, NULL, 12, 1, NULL, 0, 0, 0),(559, 'requiredtravel', 'Required Travel', 18, NULL, 12, 1, NULL, 0, 0, 0),(560, 'video', 'Video', 19, NULL, 12, 1, NULL, 0, 0, 0),(561, 'map', 'Map', 20, NULL, 12, 1, NULL, 0, 0, 1),(562, 'startpublishing', 'Start Publishing', 21, NULL, 12, 1, NULL, 0, 1, 1),(563, 'stoppublishing', 'Stop Publishing', 22, NULL, 12, 1, NULL, 0, 1, 1),(566, 'city', 'City', 25, NULL, 12, 1, NULL, 0, 0, 0),(568, 'sendemail', 'Send Email', 27, NULL, 12, 1, NULL, 0, 0, 0),(569, 'sendmeresume', 'Send me Resume', 28, NULL, 12, 1, NULL, 0, 0, 0),(570, 'description', 'Description', 29, NULL, 12, 1, NULL, 0, 0, 0),(571, 'qualifications', 'Qualifications', 30, NULL, 12, 1, NULL, 0, 0, 0),(572, 'prefferdskills', 'Prefered Skills', 31, NULL, 12, 1, NULL, 0, 0, 0),(573, 'agreement', 'Agreement', 32, NULL, 12, 1, NULL, 0, 0, 1),(574, 'metadescription', 'Meta Description', 33, NULL, 12, 1, NULL, 0, 0, 1),(575, 'metakeywords', 'Meta Keywords', 34, NULL, 12, 1, NULL, 0, 0, 1),(576, 'zipcode', 'Zipcode', 26, NULL, 12, 1, NULL, 0, 0, 0),(577, 'section_personal', 'Personal Information', 0, '10', 13, 1, NULL, 0, 1, 0),(578, 'applicationtitle', 'Application Title', 1, '10', 13, 1, NULL, 0, 1, 0),(579, 'firstname', 'First Name', 2, '10', 13, 1, NULL, 0, 1, 0),(580, 'middlename', 'Middle Name', 3, '10', 13, 0, NULL, 0, 0, 0),(581, 'lastname', 'Last Name', 4, '10', 13, 1, NULL, 0, 1, 0),(582, 'emailaddress', 'Email Address', 5, '10', 13, 1, NULL, 0, 1, 0),(583, 'homephone', 'Home Phone', 6, '10', 13, 1, NULL, 0, 0, 0),(584, 'workphone', 'Work Phone', 7, '10', 13, 1, NULL, 0, 0, 0),(585, 'cell', 'Cell', 8, '10', 13, 1, NULL, 0, 0, 0),(586, 'nationality', 'Nationality', 9, '10', 13, 1, NULL, 0, 0, 0),(587, 'gender', 'Gender', 10, '10', 13, 1, NULL, 0, 0, 0),(588, 'photo', 'Photo', 12, '10', 13, 1, NULL, 0, 0, 0),(589, 'fileupload', 'File Upload', 13, '10', 13, 1, NULL, 0, 0, 0),(590, 'section_basic', 'Basic Information', 15, '20', 13, 1, NULL, 0, 1, 0),(591, 'category', 'Category', 16, '20', 13, 1, NULL, 0, 1, 0),(592, 'salary', 'Salary ', 17, '20', 13, 1, NULL, 0, 1, 0),(593, 'jobtype', 'Job Type', 18, '20', 13, 1, NULL, 0, 1, 0),(594, 'heighesteducation', 'Heighest Education', 19, '20', 13, 1, NULL, 0, 1, 0),(595, 'totalexperience', 'Total Experience', 20, '20', 13, 1, NULL, 0, 1, 0),(596, 'startdate', 'Date you can start', 21, '20', 13, 1, NULL, 0, 1, 0),(597, 'section_addresses', 'Addresses', 42, '30', 13, 1, NULL, 0, 0, 0),(598, 'section_sub_address', 'Current Address', 43, '31', 13, 1, NULL, 0, 0, 0),(602, 'address_city', 'City', 47, '31', 13, 1, NULL, 0, 0, 0),(603, 'address_zipcode', 'Zip Code', 48, '31', 13, 1, NULL, 0, 0, 0),(604, 'address_address', 'Address', 49, '31', 13, 1, NULL, 0, 0, 0),(605, 'section_sub_address1', 'Address1', 51, '32', 13, 1, NULL, 0, 0, 0),(609, 'address1_city', 'City', 55, '32', 13, 1, NULL, 0, 0, 0),(610, 'address1_zipcode', 'Zip Code', 56, '32', 13, 1, NULL, 0, 0, 0),(611, 'address1_address', 'Address', 57, '32', 13, 1, NULL, 0, 0, 0),(612, 'section_sub_address2', 'Address1', 61, '33', 13, 1, NULL, 0, 0, 0),(616, 'address2_city', 'City', 65, '33', 13, 1, NULL, 0, 0, 0),(617, 'address2_zipcode', 'Zip Code', 66, '33', 13, 1, NULL, 0, 0, 0),(618, 'address2_address', 'Address', 67, '33', 13, 1, NULL, 0, 0, 0),(619, 'section_education', 'Education', 71, '40', 13, 1, NULL, 0, 0, 0),(620, 'section_sub_institute', 'High School', 72, '41', 13, 1, NULL, 0, 0, 0),(621, 'institute_institute', 'Institute', 73, '41', 13, 1, NULL, 0, 0, 0),(625, 'institute_city', 'City', 77, '41', 13, 1, NULL, 0, 0, 0),(626, 'institute_address', 'Address', 78, '41', 13, 1, NULL, 0, 0, 0),(627, 'institute_certificate', 'Certificate Name', 79, '41', 13, 1, NULL, 0, 0, 0),(628, 'institute_study_area', 'Study Area', 80, '41', 13, 1, NULL, 0, 0, 0),(629, 'section_sub_institute1', 'University', 82, '42', 13, 1, NULL, 0, 0, 0),(630, 'institute1_institute', 'Institute', 83, '42', 13, 1, NULL, 0, 0, 0),(634, 'institute1_city', 'City', 87, '42', 13, 1, NULL, 0, 0, 0),(635, 'institute1_address', 'Address', 88, '42', 13, 1, NULL, 0, 0, 0),(636, 'institute1_certificate', 'Certificate Name', 89, '42', 13, 1, NULL, 0, 0, 0),(637, 'institute1_study_area', 'Study Area', 90, '42', 13, 1, NULL, 0, 0, 0),(638, 'section_sub_institute2', 'Grade School', 92, '43', 13, 1, NULL, 0, 0, 0),(639, 'institute2_institute', 'Institute', 93, '43', 13, 1, NULL, 0, 0, 0),(643, 'institute2_city', 'City', 97, '43', 13, 1, NULL, 0, 0, 0),(644, 'institute2_address', 'Address', 98, '43', 13, 1, NULL, 0, 0, 0),(645, 'institute2_certificate', 'Certificate Name', 99, '43', 13, 1, NULL, 0, 0, 0),(646, 'institute2_study_area', 'Study Area', 100, '43', 13, 1, NULL, 0, 0, 0),(647, 'section_sub_institute3', 'Other School', 102, '44', 13, 1, NULL, 0, 0, 0),(648, 'institute3_institute', 'Institute', 103, '44', 13, 1, NULL, 0, 0, 0),(652, 'institute3_city', 'City', 107, '44', 13, 1, NULL, 0, 0, 0),(653, 'institute3_address', 'Address', 108, '44', 13, 1, NULL, 0, 0, 0),(654, 'institute3_certificate', 'Certificate Name', 109, '44', 13, 1, NULL, 0, 0, 0),(655, 'institute3_study_area', 'Study Area', 110, '44', 13, 1, NULL, 0, 0, 0),(656, 'section_employer', 'Employer', 112, '50', 13, 1, NULL, 0, 0, 0),(657, 'section_sub_employer', 'Recent Employer', 113, '51', 13, 1, NULL, 0, 0, 0),(658, 'employer_employer', 'Employer', 114, '51', 13, 1, NULL, 0, 0, 0),(659, 'employer_position', 'Position', 114, '51', 13, 1, NULL, 0, 0, 0),(660, 'employer_resp', 'Responsibilities', 115, '51', 13, 1, NULL, 0, 0, 0),(661, 'employer_pay_upon_leaving', 'Pay Upon Leaving', 116, '51', 13, 1, NULL, 0, 0, 0),(662, 'employer_supervisor', 'Supervisor', 117, '51', 13, 1, NULL, 0, 0, 0),(663, 'employer_from_date', 'From Date', 118, '51', 13, 1, NULL, 0, 0, 0),(664, 'employer_to_date', 'To Date', 119, '51', 13, 1, NULL, 0, 0, 0),(665, 'employer_leave_reason', 'Leave Reason', 120, '51', 13, 1, NULL, 0, 0, 0),(669, 'employer_city', 'City', 124, '51', 13, 1, NULL, 0, 0, 0),(670, 'employer_zip', 'Zip Code', 125, '51', 13, 1, NULL, 0, 0, 0),(671, 'employer_phone', 'Phone', 126, '51', 13, 1, NULL, 0, 0, 0),(672, 'employer_address', 'Address', 127, '51', 13, 1, NULL, 0, 0, 0),(673, 'section_sub_employer1', 'Prior Employer 1', 128, '52', 13, 1, NULL, 0, 0, 0),(674, 'employer1_employer', 'Employer', 129, '52', 13, 1, NULL, 0, 0, 0),(675, 'employer1_position', 'Position', 130, '52', 13, 1, NULL, 0, 0, 0),(676, 'employer1_resp', 'Responsibilities', 131, '52', 13, 1, NULL, 0, 0, 0),(677, 'employer1_pay_upon_leaving', 'Pay Upon Leaving', 132, '52', 13, 1, NULL, 0, 0, 0),(678, 'employer1_supervisor', 'Supervisor', 133, '52', 13, 1, NULL, 0, 0, 0),(679, 'employer1_from_date', 'From Date', 134, '52', 13, 1, NULL, 0, 0, 0),(680, 'employer1_to_date', 'To Date', 135, '52', 13, 1, NULL, 0, 0, 0),(681, 'employer1_leave_reason', 'Leave Reason', 136, '52', 13, 1, NULL, 0, 0, 0),(685, 'employer1_city', 'City', 140, '52', 13, 1, NULL, 0, 0, 0),(686, 'employer1_zip', 'Zip Code', 141, '52', 13, 1, NULL, 0, 0, 0),(687, 'employer1_phone', 'Phone', 142, '52', 13, 1, NULL, 0, 0, 0),(688, 'employer1_address', 'Address', 143, '52', 13, 1, NULL, 0, 0, 0),(689, 'section_sub_employer2', 'Prior Employer 2', 146, '53', 13, 1, NULL, 0, 0, 0),(690, 'employer2_employer', 'Employer', 147, '53', 13, 1, NULL, 0, 0, 0),(691, 'employer2_position', 'Position', 148, '53', 13, 1, NULL, 0, 0, 0),(692, 'employer2_resp', 'Responsibilities', 149, '53', 13, 1, NULL, 0, 0, 0),(693, 'employer2_pay_upon_leaving', 'Pay Upon Leaving', 150, '53', 13, 1, NULL, 0, 0, 0),(694, 'employer2_supervisor', 'Supervisor', 151, '53', 13, 1, NULL, 0, 0, 0),(695, 'employer2_from_date', 'From Date', 152, '53', 13, 1, NULL, 0, 0, 0),(696, 'employer2_to_date', 'To Date', 153, '53', 13, 1, NULL, 0, 0, 0),(697, 'employer2_leave_reason', 'Leave Reason', 154, '53', 13, 1, NULL, 0, 0, 0),(701, 'employer2_city', 'City', 158, '53', 13, 1, NULL, 0, 0, 0),(702, 'employer2_zip', 'Zip Code', 159, '53', 13, 1, NULL, 0, 0, 0),(703, 'employer2_phone', 'Phone', 160, '53', 13, 1, NULL, 0, 0, 0),(704, 'employer2_address', 'Address', 161, '53', 13, 1, NULL, 0, 0, 0),(705, 'section_sub_employer3', 'Prior Employer 3', 166, '54', 13, 1, NULL, 0, 0, 0),(706, 'employer3_employer', 'Employer', 167, '54', 13, 1, NULL, 0, 0, 0),(707, 'employer3_position', 'Position', 168, '54', 13, 1, NULL, 0, 0, 0),(708, 'employer3_resp', 'Responsibilities', 169, '54', 13, 1, NULL, 0, 0, 0),(709, 'employer3_pay_upon_leaving', 'Pay Upon Leaving', 170, '54', 13, 1, NULL, 0, 0, 0),(710, 'employer3_supervisor', 'Supervisor', 171, '54', 13, 1, NULL, 0, 0, 0),(711, 'employer3_from_date', 'From Date', 172, '54', 13, 1, NULL, 0, 0, 0),(712, 'employer3_to_date', 'To Date', 173, '54', 13, 1, NULL, 0, 0, 0),(713, 'employer3_leave_reason', 'Leave Reason', 174, '54', 13, 1, NULL, 0, 0, 0),(717, 'employer3_city', 'City', 178, '54', 13, 1, NULL, 0, 0, 0),(718, 'employer3_zip', 'Zip Code', 179, '54', 13, 1, NULL, 0, 0, 0),(719, 'employer3_phone', 'Phone', 180, '54', 13, 1, NULL, 0, 0, 0),(720, 'employer3_address', 'Address', 181, '54', 13, 1, NULL, 0, 0, 0),(721, 'section_skills', 'Skills', 186, '60', 13, 1, NULL, 0, 0, 0),(722, 'driving_license', 'Driving License', 187, '60', 13, 1, NULL, 0, 0, 0),(723, 'license_no', 'License No', 188, '60', 13, 1, NULL, 0, 0, 0),(724, 'license_country', 'License Country', 189, '60', 13, 1, NULL, 0, 0, 0),(725, 'skills', 'Skills', 190, '60', 13, 1, NULL, 0, 0, 0),(726, 'section_resumeeditor', 'Resume Editor', 196, '70', 13, 1, NULL, 0, 0, 0),(727, 'editor', 'Editor', 197, '70', 13, 1, NULL, 0, 0, 0),(728, 'section_references', 'References', 206, '80', 13, 1, NULL, 0, 0, 0),(729, 'section_sub_reference', 'Reference 1', 207, '81', 13, 1, NULL, 0, 0, 0),(730, 'reference_reference', 'Reference', 208, '81', 13, 1, NULL, 0, 0, 0),(731, 'reference_name', 'Name', 209, '81', 13, 1, NULL, 0, 0, 0),(735, 'reference_city', 'City', 213, '81', 13, 1, NULL, 0, 0, 0),(736, 'reference_zipcode', 'Zip Code', 214, '81', 13, 1, NULL, 0, 0, 0),(737, 'reference_phone', 'Phone', 215, '81', 13, 1, NULL, 0, 0, 0),(738, 'reference_relation', 'Relation', 216, '81', 13, 1, NULL, 0, 0, 0),(739, 'reference_years', 'Years', 217, '81', 13, 1, NULL, 0, 0, 0),(740, 'section_sub_reference1', 'Reference 2', 221, '82', 13, 1, NULL, 0, 0, 0),(741, 'reference1_reference', 'Reference', 222, '82', 13, 1, NULL, 0, 0, 0),(742, 'reference1_name', 'Name', 223, '82', 13, 1, NULL, 0, 0, 0),(746, 'reference1_city', 'City', 227, '82', 13, 1, NULL, 0, 0, 0),(747, 'reference1_zipcode', 'Zip Code', 228, '82', 13, 1, NULL, 0, 0, 0),(748, 'reference1_phone', 'Phone', 229, '82', 13, 1, NULL, 0, 0, 0),(749, 'reference1_relation', 'Relation', 230, '82', 13, 1, NULL, 0, 0, 0),(750, 'reference1_years', 'Years', 231, '82', 13, 1, NULL, 0, 0, 0),(751, 'section_sub_reference2', 'Reference 3', 232, '83', 13, 1, NULL, 0, 0, 0),(752, 'reference2_reference', 'Reference', 233, '83', 13, 1, NULL, 0, 0, 0),(753, 'reference2_name', 'Name', 234, '83', 13, 1, NULL, 0, 0, 0),(757, 'reference2_city', 'City', 238, '83', 13, 1, NULL, 0, 0, 0),(758, 'reference2_zipcode', 'Zip Code', 239, '83', 13, 1, NULL, 0, 0, 0),(759, 'reference2_phone', 'Phone', 240, '83', 13, 1, NULL, 0, 0, 0),(760, 'reference2_relation', 'Relation', 241, '83', 13, 1, NULL, 0, 0, 0),(761, 'reference2_years', 'Years', 242, '83', 13, 1, NULL, 0, 0, 0),(762, 'section_sub_reference3', 'Reference 4', 243, '84', 13, 1, NULL, 0, 0, 0),(763, 'reference3_reference', 'Reference', 244, '84', 13, 1, NULL, 0, 0, 0),(764, 'reference3_name', 'Name', 245, '84', 13, 1, NULL, 0, 0, 0),(768, 'reference3_city', 'City', 249, '84', 13, 1, NULL, 0, 0, 0),(769, 'reference3_zipcode', 'Zip Code', 250, '84', 13, 1, NULL, 0, 0, 0),(770, 'reference3_phone', 'Phone', 251, '84', 13, 1, NULL, 0, 0, 0),(771, 'reference3_relation', 'Relation', 252, '84', 13, 1, NULL, 0, 0, 0),(772, 'reference3_years', 'Years', 253, '84', 13, 1, NULL, 0, 0, 0),(773, 'Iamavailable', 'I am Available', 11, '10', 13, 1, NULL, 0, 0, 0),(774, 'searchable', 'Searchable', 12, '10', 13, 1, NULL, 0, 0, 0),(775, 'section_userfields', 'Visitor User Fields', 21, '1000', 13, 0, NULL, 0, 0, 1),(776, 'userfield1', 'User Field 1', 22, '1000', 13, 0, NULL, 0, 0, 0),(777, 'userfield2', 'User Field 2', 23, '1000', 13, 0, NULL, 0, 0, 0),(778, 'userfield3', 'User Field 3', 24, '1000', 13, 0, NULL, 0, 0, 0),(779, 'userfield4', 'User Field 4', 25, '1000', 13, 0, NULL, 0, 0, 0),(780, 'userfield5', 'User Field 5', 26, '1000', 13, 0, NULL, 0, 0, 0),(781, 'userfield6', 'User Field 6', 27, '1000', 13, 0, NULL, 0, 0, 0),(782, 'userfield7', 'User Field 7', 28, '1000', 13, 0, NULL, 0, 0, 0),(783, 'userfield8', 'User Field 8', 29, '1000', 13, 0, NULL, 0, 0, 0),(784, 'userfield9', 'User Field 9', 30, '1000', 13, 0, NULL, 0, 0, 0),(785, 'userfield10', 'User Field 10', 32, '1000', 13, 0, NULL, 0, 0, 0),(786, 'date_of_birth', 'Date of Birth', 11, '10', 3, 1, 1, 0, 0, 0),(787, 'date_of_birth', 'Date of Birth', 14, '10', 13, 1, NULL, 0, 0, 0),(788, 'video', 'Youtube Video Id', 19, '20', 3, 1, 1, 0, 0, 0),(789, 'video', 'Youtube Video Id', 22, '20', 13, 1, NULL, 0, 0, 0),(790, 'address_location', 'Longitude And Latitude', 50, '31', 3, 1, 1, 0, 0, 0),(791, 'address_location', 'Longitude And Latitude', 50, '31', 13, 1, NULL, 0, 0, 0),(859, 'desiredsalary', 'Desire Salary ', 19, '20', 3, 1, 1, 1, 1, 1),(858, 'subcategory', 'Subcategory', 17, '20', 3, 1, 1, 0, 0, 0),(833, 'section_languages', 'Languages', 254, '85', 3, 1, 1, 0, 0, 0),(834, 'section_sub_language', 'Language 1', 255, '85', 3, 1, 1, 0, 0, 0),(835, 'language_name', 'Language Name', 256, '85', 3, 1, 1, 0, 0, 0),(836, 'language_reading', 'Language Reading', 257, '85', 3, 1, 1, 0, 0, 0),(837, 'language_writing', 'Language Writing', 258, '85', 3, 1, 1, 0, 0, 0),(838, 'language_understading', 'Language Understanding', 259, '85', 3, 1, 1, 0, 0, 0),(839, 'language_where_learned', 'Language Learn', 260, '85', 3, 1, 1, 0, 0, 0),(840, 'section_sub_language1', 'Language 2', 261, '85', 3, 1, 1, 0, 0, 0),(841, 'language1_name', 'Language Name', 262, '85', 3, 1, 1, 0, 0, 0),(842, 'language1_reading', 'Language Reading', 263, '85', 3, 1, 1, 0, 0, 0),(843, 'language1_writing', 'Language Writing', 264, '85', 3, 1, 1, 0, 0, 0),(844, 'language1_understading', 'Language Understanding', 265, '85', 3, 1, 1, 0, 0, 0),(845, 'language1_where_learned', 'Language Learn', 266, '85', 3, 1, 1, 0, 0, 0),(846, 'section_sub_language2', 'Language 3', 267, '85', 3, 1, 1, 0, 0, 0),(847, 'language2_name', 'Language Name', 268, '85', 3, 1, 1, 0, 0, 0),(848, 'language2_reading', 'Language Reading', 269, '85', 3, 1, 1, 0, 0, 0),(849, 'language2_writing', 'Language Writing', 270, '85', 3, 1, 1, 0, 0, 0),(850, 'language2_understading', 'Language Understanding', 271, '85', 3, 1, 1, 0, 0, 0),(851, 'language2_where_learned', 'Language Learn', 272, '85', 3, 1, 1, 0, 0, 0),(852, 'section_sub_language3', 'Language 4', 273, '85', 3, 1, 1, 0, 0, 0),(853, 'language3_name', 'Language Name', 274, '85', 3, 1, 1, 0, 0, 0),(854, 'language3_reading', 'Language Reading', 275, '85', 3, 1, 1, 0, 0, 0),(855, 'language3_writing', 'Language Writing', 276, '85', 3, 1, 1, 0, 0, 0),(856, 'language3_understading', 'Language Understanding', 277, '85', 3, 1, 1, 0, 0, 0),(857, 'language3_where_learned', 'Language Learn', 278, '85', 3, 1, 1, 0, 0, 0),(862, 'keywords', 'Key Words', 21, '20', 3, 1, 1, 1, 1, 1),(863, 'filter', 'Filter', 33, NULL, 2, 1, 1, 0, 0, 0),(864, 'emailsetting', 'Email Setting', 34, NULL, 2, 1, 1, 0, 0, 0);

DROP TABLE IF EXISTS `#__js_job_filters`;
CREATE TABLE `#__js_job_filters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `country_istext` tinyint(1) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `state_istext` tinyint(1) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `county_istext` tinyint(1) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `city_istext` tinyint(1) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `jobtype` int(11) DEFAULT NULL,
  `jobstatus` int(11) DEFAULT NULL,
  `heighesteducation` int(11) DEFAULT NULL,
  `salaryrange` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_heighesteducation`;
CREATE TABLE `#__js_job_heighesteducation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `isactive` tinyint(1) DEFAULT '1',
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
INSERT INTO `#__js_job_heighesteducation` (`id`, `title`, `isactive`, `isdefault`, `ordering`, `serverid`) VALUES(1, 'University', 1, 1, 1, 0),(2, 'College', 1, 0, 2, 0),(3, 'High School', 1, 0, 3, 0),(4, 'No School', 1, 0, 4, 0);

DROP TABLE IF EXISTS `#__js_job_jobapply`;
CREATE TABLE `#__js_job_jobapply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `cvid` int(11) DEFAULT NULL,
  `apply_date` datetime DEFAULT NULL,
  `resumeview` tinyint(1) NOT NULL DEFAULT '0',
  `comments` varchar(1000) DEFAULT NULL,
  `coverletterid` int(11) DEFAULT NULL,
  `action_status` int(11) DEFAULT NULL,
  `serverstatus` varchar(255) DEFAULT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jobapply_uid` (`uid`),
  KEY `jobapply_jobid` (`jobid`),
  KEY `jobapply_cvid` (`cvid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_jobcities`;
CREATE TABLE `#__js_job_jobcities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobid` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jobid` (`jobid`),
  KEY `cityid` (`cityid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_jobs`;
CREATE TABLE `#__js_job_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `companyid` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(225) NOT NULL,
  `jobcategory` varchar(255) NOT NULL DEFAULT '',
  `jobtype` tinyint(1) unsigned DEFAULT '0',
  `jobstatus` tinyint(3) NOT NULL DEFAULT '1',
  `jobsalaryrange` varchar(255) DEFAULT '',
  `salaryrangetype` varchar(20) DEFAULT NULL,
  `hidesalaryrange` tinyint(1) DEFAULT '1',
  `description` text,
  `qualifications` text,
  `prefferdskills` text,
  `applyinfo` text,
  `company` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(255) DEFAULT '',
  `state` varchar(255) DEFAULT '',
  `county` varchar(255) DEFAULT '',
  `city` varchar(255) DEFAULT '',
  `zipcode` varchar(10) DEFAULT '',
  `address1` varchar(255) DEFAULT '',
  `address2` varchar(255) DEFAULT '',
  `companyurl` varchar(255) DEFAULT '',
  `contactname` varchar(255) DEFAULT '',
  `contactphone` varchar(255) DEFAULT '',
  `contactemail` varchar(255) DEFAULT '',
  `showcontact` tinyint(1) unsigned DEFAULT '0',
  `noofjobs` int(11) unsigned NOT NULL DEFAULT '1',
  `reference` varchar(255) NOT NULL DEFAULT '',
  `duration` varchar(255) NOT NULL DEFAULT '',
  `heighestfinisheducation` varchar(255) DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `experience` int(11) DEFAULT '0',
  `startpublishing` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stoppublishing` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `departmentid` varchar(255) DEFAULT NULL,
  `shift` varchar(255) DEFAULT NULL,
  `sendemail` tinyint(1) NOT NULL DEFAULT '0',
  `metadescription` text,
  `metakeywords` text,
  `agreement` text,
  `ordering` tinyint(3) NOT NULL DEFAULT '0',
  `aboutjobfile` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `educationminimax` tinyint(1) DEFAULT NULL,
  `educationid` int(11) DEFAULT NULL,
  `mineducationrange` int(11) DEFAULT NULL,
  `maxeducationrange` int(11) DEFAULT NULL,
  `iseducationminimax` tinyint(1) DEFAULT NULL,
  `degreetitle` varchar(255) DEFAULT NULL,
  `careerlevel` int(11) DEFAULT NULL,
  `experienceminimax` tinyint(1) DEFAULT NULL,
  `experienceid` int(11) DEFAULT NULL,
  `minexperiencerange` int(11) DEFAULT NULL,
  `maxexperiencerange` int(11) DEFAULT NULL,
  `isexperienceminimax` tinyint(1) DEFAULT NULL,
  `experiencetext` varchar(255) DEFAULT NULL,
  `workpermit` varchar(20) DEFAULT NULL,
  `requiredtravel` int(11) DEFAULT NULL,
  `agefrom` int(11) DEFAULT NULL,
  `ageto` int(11) DEFAULT NULL,
  `salaryrangefrom` int(11) DEFAULT NULL,
  `salaryrangeto` int(11) DEFAULT NULL,
  `gender` int(5) DEFAULT NULL,
  `video` varchar(150) DEFAULT NULL,
  `map` varchar(1000) DEFAULT NULL,
  `packageid` int(11) DEFAULT NULL,
  `paymenthistoryid` int(11) DEFAULT NULL,
  `subcategoryid` int(11) DEFAULT NULL,
  `currencyid` int(11) DEFAULT NULL,
  `jobid` varchar(25) DEFAULT '',
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `isgoldjob` tinyint(1) DEFAULT '0',
  `isfeaturedjob` tinyint(1) DEFAULT '0',
  `raf_gender` tinyint(1) DEFAULT NULL,
  `raf_degreelevel` tinyint(1) DEFAULT NULL,
  `raf_experience` tinyint(1) DEFAULT NULL,
  `raf_age` tinyint(1) DEFAULT NULL,
  `raf_education` tinyint(1) DEFAULT NULL,
  `raf_category` tinyint(1) DEFAULT NULL,
  `raf_subcategory` tinyint(1) DEFAULT NULL,
  `raf_location` tinyint(1) DEFAULT NULL,
  `serverstatus` varchar(255) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `jobcategory` (`jobcategory`),
  KEY `jobs_companyid` (`companyid`),
  KEY `jobsalaryrange` (`jobsalaryrange`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_jobsearches`;
CREATE TABLE `#__js_job_jobsearches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `searchname` varchar(50) NOT NULL,
  `jobtitle` varchar(255) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `jobtype` int(11) DEFAULT NULL,
  `jobstatus` int(11) DEFAULT NULL,
  `salaryrange` int(11) DEFAULT NULL,
  `heighesteducation` int(11) DEFAULT NULL,
  `shift` int(11) DEFAULT NULL,
  `experience` varchar(30) DEFAULT NULL,
  `durration` varchar(30) DEFAULT NULL,
  `startpublishing` datetime DEFAULT NULL,
  `stoppublishing` datetime DEFAULT NULL,
  `company` int(11) DEFAULT NULL,
  `country_istext` tinyint(1) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `state_istext` tinyint(1) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `county_istext` tinyint(1) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `city_istext` tinyint(1) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zipcode_istext` tinyint(1) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jobsearches_uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_jobseekerpackages`;
CREATE TABLE `#__js_job_jobseekerpackages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `currencyid` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `discounttype` tinyint(4) DEFAULT NULL,
  `discountmessage` varchar(500) DEFAULT NULL,
  `discountstartdate` datetime DEFAULT NULL,
  `discountenddate` datetime DEFAULT NULL,
  `resumeallow` int(11) NOT NULL,
  `coverlettersallow` int(11) NOT NULL,
  `applyjobs` int(11) NOT NULL,
  `jobsearch` int(11) NOT NULL,
  `savejobsearch` int(11) NOT NULL,
  `featuredresume` int(11) NOT NULL,
  `goldresume` int(11) NOT NULL,
  `video` tinyint(4) DEFAULT NULL,
  `packageexpireindays` int(11) DEFAULT NULL,
  `shortdetails` varchar(1000) DEFAULT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `freaturedresumeexpireindays` int(11) DEFAULT NULL,
  `goldresumeexpireindays` int(11) DEFAULT NULL,
  `fastspringlink` varchar(1000) DEFAULT NULL,
  `otherpaymentlink` varchar(1000) DEFAULT NULL,
  `jobalertsetting` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `#__js_job_jobseekerpackages` (`id`, `title`, `currencyid`, `price`, `discount`, `discounttype`, `discountmessage`, `discountstartdate`, `discountenddate`, `resumeallow`, `coverlettersallow`, `applyjobs`, `jobsearch`, `savejobsearch`, `featuredresume`, `goldresume`, `video`, `packageexpireindays`, `shortdetails`, `description`, `status`, `created`, `freaturedresumeexpireindays`, `goldresumeexpireindays`, `fastspringlink`, `otherpaymentlink`, `jobalertsetting`) VALUES(1, 'Free Package', 1, 0, 0, 1, '', '2010-06-01 00:00:00', '2010-08-24 00:00:00', 1, 3, -1, 1, 1, 1, 1, 0, 365, 'Free Package', 'Free Package', 1, '2012-11-08 00:00:00', 30, 30, '', '', 1);

DROP TABLE IF EXISTS `#__js_job_jobstatus`;
CREATE TABLE `#__js_job_jobstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `isactive` tinyint(1) DEFAULT '1',
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;
INSERT INTO `#__js_job_jobstatus` (`id`, `title`, `isactive`, `isdefault`, `ordering`, `serverid`) VALUES(1, 'Sourcing', 1, 0, 2, 0),(2, 'Interviewing', 1, 1, 1, 0),(3, 'Closed to New Applicants', 1, 0, 3, 0),(4, 'Finalists Identified', 1, 0, 5, 0),(5, 'Pending Approval', 1, 0, 6, 0),(6, 'Hold', 1, 0, 4, 0);

DROP TABLE IF EXISTS `#__js_job_jobs_temp`;
CREATE TABLE `#__js_job_jobs_temp` (
  `localid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `aliasid` varchar(255) DEFAULT NULL,
  `companyaliasid` varchar(255) DEFAULT NULL,
  `companylogo` varchar(100) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `jobdays` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `companyname` varchar(255) DEFAULT NULL,
  `jobcategory` varchar(255) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `symbol` varchar(60) DEFAULT NULL,
  `salaryfrom` varchar(255) DEFAULT NULL,
  `salaryto` varchar(255) DEFAULT NULL,
  `salaytype` varchar(255) DEFAULT NULL,
  `jobtype` varchar(100) DEFAULT NULL,
  `jobstatus` varchar(100) DEFAULT NULL,
  `cityname` varchar(100) DEFAULT NULL,
  `statename` varchar(100) DEFAULT NULL,
  `countryname` varchar(100) DEFAULT NULL,
  `noofjobs` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`localid`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_jobs_temp_time`;
CREATE TABLE `#__js_job_jobs_temp_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastcalltime` datetime DEFAULT NULL,
  `expiretime` datetime DEFAULT NULL,
  `is_request` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_jobtypes`;
CREATE TABLE `#__js_job_jobtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `isactive` tinyint(1) DEFAULT '1',
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
INSERT INTO `#__js_job_jobtypes` (`id`, `title`, `isactive`, `isdefault`, `ordering`, `status`, `serverid`) VALUES(1, 'Full-Time', 1, 1, 1, 1, 1),(2, 'Part-Time', 1, 0, 2, 0, 0),(3, 'Internship', 1, 0, 3, 0, 0);

DROP TABLE IF EXISTS `#__js_job_paymenthistory`;
CREATE TABLE `#__js_job_paymenthistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `packageid` int(11) NOT NULL,
  `packagetitle` varchar(255) NOT NULL,
  `packageprice` float DEFAULT NULL,
  `discountamount` int(11) DEFAULT NULL,
  `paidamount` int(11) DEFAULT NULL,
  `discountmessage` varchar(500) DEFAULT NULL,
  `packagediscountstartdate` datetime DEFAULT NULL,
  `packagediscountenddate` datetime DEFAULT NULL,
  `packageexpireindays` int(11) NOT NULL,
  `packageshortdetails` varchar(255) DEFAULT NULL,
  `packagedescription` text,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `transactionverified` tinyint(4) DEFAULT NULL,
  `transactionautoverified` tinyint(4) DEFAULT NULL,
  `verifieddate` datetime DEFAULT NULL,
  `referenceid` varchar(150) DEFAULT NULL,
  `payer_firstname` varchar(150) DEFAULT NULL,
  `payer_lastname` varchar(150) DEFAULT NULL,
  `payer_email` varchar(255) DEFAULT NULL,
  `payer_amount` float DEFAULT NULL,
  `payer_itemname` varchar(255) DEFAULT NULL,
  `payer_itemname2` varchar(255) DEFAULT NULL,
  `payer_status` varchar(255) DEFAULT NULL,
  `payer_tx_token` varchar(255) DEFAULT NULL,
  `packagefor` tinyint(1) DEFAULT NULL,
  `currencyid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_uid` (`uid`),
  KEY `payment_packageid` (`packageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_resume`;
CREATE TABLE `#__js_job_resume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime DEFAULT NULL,
  `published` tinyint(1) DEFAULT '1',
  `hits` int(11) DEFAULT NULL,
  `application_title` varchar(150) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `alias` varchar(225) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `middle_name` varchar(150) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email_address` varchar(200) DEFAULT NULL,
  `home_phone` varchar(60) NOT NULL,
  `work_phone` varchar(60) DEFAULT NULL,
  `cell` varchar(60) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `iamavailable` tinyint(1) DEFAULT NULL,
  `searchable` tinyint(1) DEFAULT '1',
  `photo` varchar(150) DEFAULT NULL,
  `job_category` int(11) DEFAULT NULL,
  `jobsalaryrange` int(11) DEFAULT NULL,
  `jobsalaryrangetype` int(11) DEFAULT NULL,
  `jobtype` int(11) DEFAULT NULL,
  `heighestfinisheducation` varchar(60) DEFAULT NULL,
  `address_country` varchar(100) DEFAULT NULL,
  `address_state` varchar(60) DEFAULT NULL,
  `address_county` varchar(100) DEFAULT NULL,
  `address_city` varchar(100) DEFAULT NULL,
  `address_zipcode` varchar(60) DEFAULT NULL,
  `address` text,
  `institute` varchar(100) DEFAULT NULL,
  `institute_country` varchar(100) DEFAULT NULL,
  `institute_state` varchar(100) DEFAULT NULL,
  `institute_county` varchar(100) DEFAULT NULL,
  `institute_city` varchar(100) DEFAULT NULL,
  `institute_address` varchar(150) DEFAULT NULL,
  `institute_certificate_name` varchar(100) DEFAULT NULL,
  `institute_study_area` text,
  `employer` varchar(250) DEFAULT NULL,
  `employer_position` varchar(150) DEFAULT NULL,
  `employer_resp` text,
  `employer_pay_upon_leaving` varchar(250) DEFAULT NULL,
  `employer_supervisor` varchar(100) DEFAULT NULL,
  `employer_from_date` varchar(60) DEFAULT NULL,
  `employer_to_date` varchar(60) DEFAULT NULL,
  `employer_leave_reason` text,
  `employer_country` varchar(100) DEFAULT NULL,
  `employer_state` varchar(100) DEFAULT NULL,
  `employer_county` varchar(100) DEFAULT NULL,
  `employer_city` varchar(100) DEFAULT NULL,
  `employer_zip` varchar(60) DEFAULT NULL,
  `employer_phone` varchar(60) DEFAULT NULL,
  `employer_address` varchar(150) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `filecontent` mediumblob,
  `field1` text,
  `field2` text,
  `field3` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `resume` text,
  `institute1` varchar(100) DEFAULT NULL,
  `institute1_country` varchar(100) DEFAULT NULL,
  `institute1_state` varchar(100) DEFAULT NULL,
  `institute1_county` varchar(100) DEFAULT NULL,
  `institute1_city` varchar(100) DEFAULT NULL,
  `institute1_address` varchar(150) DEFAULT NULL,
  `institute1_study_area` text,
  `institute1_certificate_name` varchar(100) DEFAULT NULL,
  `institute2` varchar(100) DEFAULT NULL,
  `institute2_country` varchar(100) DEFAULT NULL,
  `institute2_state` varchar(100) DEFAULT NULL,
  `institute2_county` varchar(100) DEFAULT NULL,
  `institute2_city` varchar(100) DEFAULT NULL,
  `institute2_address` varchar(150) DEFAULT NULL,
  `institute2_certificate_name` varchar(100) DEFAULT NULL,
  `institute2_study_area` text,
  `institute3` varchar(100) DEFAULT NULL,
  `institute3_country` varchar(100) DEFAULT NULL,
  `institute3_state` varchar(100) DEFAULT NULL,
  `institute3_county` varchar(100) DEFAULT NULL,
  `institute3_city` varchar(100) DEFAULT NULL,
  `institute3_address` varchar(150) DEFAULT NULL,
  `institute3_study_area` text,
  `institute3_certificate_name` varchar(100) DEFAULT NULL,
  `employer1` varchar(250) DEFAULT NULL,
  `employer1_position` varchar(150) DEFAULT NULL,
  `employer1_resp` text,
  `employer1_pay_upon_leaving` varchar(250) DEFAULT NULL,
  `employer1_supervisor` varchar(100) DEFAULT NULL,
  `employer1_from_date` varchar(60) DEFAULT NULL,
  `employer1_to_date` varchar(60) DEFAULT NULL,
  `employer1_leave_reason` text,
  `employer1_country` varchar(100) DEFAULT NULL,
  `employer1_state` varchar(100) DEFAULT NULL,
  `employer1_county` varchar(100) DEFAULT NULL,
  `employer1_city` varchar(100) DEFAULT NULL,
  `employer1_zip` varchar(60) DEFAULT NULL,
  `employer1_phone` varchar(60) DEFAULT NULL,
  `employer1_address` varchar(150) DEFAULT NULL,
  `employer2` varchar(250) DEFAULT NULL,
  `employer2_position` varchar(150) DEFAULT NULL,
  `employer2_resp` text,
  `employer2_pay_upon_leaving` varchar(250) DEFAULT NULL,
  `employer2_supervisor` varchar(100) DEFAULT NULL,
  `employer2_from_date` varchar(60) DEFAULT NULL,
  `employer2_to_date` varchar(60) DEFAULT NULL,
  `employer2_leave_reason` text,
  `employer2_country` varchar(100) DEFAULT NULL,
  `employer2_state` varchar(100) DEFAULT NULL,
  `employer2_county` varchar(100) DEFAULT NULL,
  `employer2_city` varchar(100) DEFAULT NULL,
  `employer2_zip` varchar(60) DEFAULT NULL,
  `employer2_address` varchar(150) DEFAULT NULL,
  `employer2_phone` varchar(60) DEFAULT NULL,
  `employer3` varchar(250) DEFAULT NULL,
  `employer3_position` varchar(150) DEFAULT NULL,
  `employer3_resp` text,
  `employer3_pay_upon_leaving` varchar(250) DEFAULT NULL,
  `employer3_supervisor` varchar(100) DEFAULT NULL,
  `employer3_from_date` varchar(60) DEFAULT NULL,
  `employer3_to_date` varchar(60) DEFAULT NULL,
  `employer3_leave_reason` text,
  `employer3_country` varchar(100) DEFAULT NULL,
  `employer3_state` varchar(100) DEFAULT NULL,
  `employer3_county` varchar(100) DEFAULT NULL,
  `employer3_city` varchar(100) DEFAULT NULL,
  `employer3_zip` varchar(60) DEFAULT NULL,
  `employer3_address` varchar(150) DEFAULT NULL,
  `employer3_phone` varchar(60) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `language_reading` varchar(20) DEFAULT NULL,
  `language_writing` varchar(20) DEFAULT NULL,
  `language_understanding` varchar(20) DEFAULT NULL,
  `language_where_learned` varchar(20) DEFAULT NULL,
  `language1` varchar(50) DEFAULT NULL,
  `language1_reading` varchar(20) DEFAULT NULL,
  `language1_writing` varchar(20) DEFAULT NULL,
  `language1_understanding` varchar(20) DEFAULT NULL,
  `language1_where_learned` varchar(100) DEFAULT NULL,
  `language2` varchar(50) DEFAULT NULL,
  `language2_reading` varchar(20) DEFAULT NULL,
  `language2_writing` varchar(20) DEFAULT NULL,
  `language2_understanding` varchar(20) DEFAULT NULL,
  `language2_where_learned` varchar(100) DEFAULT NULL,
  `language3` varchar(50) DEFAULT NULL,
  `language3_reading` varchar(20) DEFAULT NULL,
  `language3_writing` varchar(20) DEFAULT NULL,
  `language3_understanding` varchar(20) DEFAULT NULL,
  `language3_where_learned` varchar(100) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `desired_salary` int(11) DEFAULT NULL,
  `djobsalaryrangetype` int(11) DEFAULT NULL,
  `dcurrencyid` int(11) DEFAULT NULL,
  `can_work` varchar(250) DEFAULT NULL,
  `available` varchar(250) DEFAULT NULL,
  `unalailable` varchar(250) DEFAULT NULL,
  `total_experience` varchar(50) DEFAULT NULL,
  `skills` text,
  `driving_license` tinyint(1) DEFAULT NULL,
  `license_no` varchar(100) DEFAULT NULL,
  `license_country` varchar(50) DEFAULT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `reference_name` varchar(50) DEFAULT NULL,
  `reference_country` varchar(50) DEFAULT NULL,
  `reference_state` varchar(50) DEFAULT NULL,
  `reference_county` varchar(50) DEFAULT NULL,
  `reference_city` varchar(50) DEFAULT NULL,
  `reference_zipcode` varchar(20) DEFAULT NULL,
  `reference_address` varchar(150) DEFAULT NULL,
  `reference_phone` varchar(50) DEFAULT NULL,
  `reference_relation` varchar(50) DEFAULT NULL,
  `reference_years` varchar(10) DEFAULT NULL,
  `reference1` varchar(50) DEFAULT NULL,
  `reference1_name` varchar(50) DEFAULT NULL,
  `reference1_country` varchar(50) DEFAULT NULL,
  `reference1_state` varchar(50) DEFAULT NULL,
  `reference1_county` varchar(50) DEFAULT NULL,
  `reference1_city` varchar(50) DEFAULT NULL,
  `reference1_address` varchar(150) DEFAULT NULL,
  `reference1_phone` varchar(50) DEFAULT NULL,
  `reference1_relation` varchar(50) DEFAULT NULL,
  `reference1_years` varchar(10) DEFAULT NULL,
  `reference2` varchar(50) DEFAULT NULL,
  `reference2_name` varchar(50) DEFAULT NULL,
  `reference2_country` varchar(50) DEFAULT NULL,
  `reference2_state` varchar(50) DEFAULT NULL,
  `reference2_county` varchar(50) DEFAULT NULL,
  `reference2_city` varchar(50) DEFAULT NULL,
  `reference2_address` varchar(150) DEFAULT NULL,
  `reference2_phone` varchar(50) DEFAULT NULL,
  `reference2_relation` varchar(50) DEFAULT NULL,
  `reference2_years` varchar(10) DEFAULT NULL,
  `reference3` varchar(50) DEFAULT NULL,
  `reference3_name` varchar(50) DEFAULT NULL,
  `reference3_country` varchar(50) DEFAULT NULL,
  `reference3_state` varchar(50) DEFAULT NULL,
  `reference3_county` varchar(50) DEFAULT NULL,
  `reference3_city` varchar(50) DEFAULT NULL,
  `reference3_address` varchar(150) DEFAULT NULL,
  `reference3_phone` varchar(50) DEFAULT NULL,
  `reference3_relation` varchar(50) DEFAULT NULL,
  `reference3_years` varchar(10) DEFAULT NULL,
  `address1_country` varchar(100) DEFAULT NULL,
  `address1_state` varchar(60) DEFAULT NULL,
  `address1_county` varchar(100) DEFAULT NULL,
  `address1_city` varchar(100) DEFAULT NULL,
  `address1_zipcode` varchar(60) DEFAULT NULL,
  `address1` text,
  `address2_country` varchar(100) DEFAULT NULL,
  `address2_state` varchar(60) DEFAULT NULL,
  `address2_county` varchar(100) DEFAULT NULL,
  `address2_city` varchar(100) DEFAULT NULL,
  `address2_zipcode` varchar(60) DEFAULT NULL,
  `address2` text,
  `reference1_zipcode` varchar(20) DEFAULT NULL,
  `reference2_zipcode` varchar(20) DEFAULT NULL,
  `reference3_zipcode` varchar(20) DEFAULT NULL,
  `packageid` int(11) DEFAULT NULL,
  `paymenthistoryid` int(11) DEFAULT NULL,
  `userfield1` varchar(255) DEFAULT NULL,
  `userfield2` varchar(255) DEFAULT NULL,
  `userfield3` varchar(255) DEFAULT NULL,
  `userfield4` varchar(255) DEFAULT NULL,
  `userfield5` varchar(255) DEFAULT NULL,
  `userfield6` varchar(255) DEFAULT NULL,
  `userfield7` varchar(255) DEFAULT NULL,
  `userfield8` varchar(255) DEFAULT NULL,
  `userfield9` varchar(255) DEFAULT NULL,
  `userfield10` varchar(255) DEFAULT NULL,
  `currencyid` int(11) DEFAULT NULL,
  `job_subcategory` int(11) DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `video` varchar(50) DEFAULT NULL,
  `isgoldresume` tinyint(1) DEFAULT '0',
  `isfeaturedresume` tinyint(1) DEFAULT '0',
  `serverstatus` varchar(255) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `resume_uid` (`uid`),
  KEY `resume_packageid` (`packageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_resumesearches`;
CREATE TABLE `#__js_job_resumesearches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `searchname` varchar(50) NOT NULL,
  `application_title` varchar(255) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `gender` tinyint(2) DEFAULT NULL,
  `iamavailable` tinyint(1) DEFAULT '0',
  `category` int(11) DEFAULT NULL,
  `jobtype` int(11) DEFAULT NULL,
  `salaryrange` int(11) DEFAULT NULL,
  `education` int(11) DEFAULT NULL,
  `experience` varchar(30) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_roles`;
CREATE TABLE `#__js_job_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `rolefor` tinyint(4) DEFAULT NULL,
  `companies` int(11) DEFAULT NULL,
  `jobs` int(11) DEFAULT NULL,
  `resumes` int(11) DEFAULT NULL,
  `coverletters` int(11) DEFAULT NULL,
  `searchjob` int(11) DEFAULT NULL,
  `searchresume` int(11) DEFAULT NULL,
  `savesearchresume` int(11) DEFAULT NULL,
  `savesearchjob` int(11) DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
INSERT INTO `#__js_job_roles` (`id`, `title`, `rolefor`, `companies`, `jobs`, `resumes`, `coverletters`, `searchjob`, `searchresume`, `savesearchresume`, `savesearchjob`, `published`) VALUES(1, 'employer', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),(2, 'jobseeker', 2, 1, 1, 1, 1, 1, 1, 1, 1, 1);

DROP TABLE IF EXISTS `#__js_job_salaryrange`;
CREATE TABLE `#__js_job_salaryrange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rangevalue` varchar(255) DEFAULT NULL,
  `rangestart` varchar(255) DEFAULT NULL,
  `rangeend` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;
INSERT INTO `#__js_job_salaryrange` (`id`, `rangevalue`, `rangestart`, `rangeend`, `status`, `isdefault`, `ordering`, `serverid`) VALUES(1, NULL, '1000', '1500', 1, 1, 1, 0),(2, NULL, '1500', '2000', 1, 0, 2, 0),(3, NULL, '2000', '2500', 1, 0, 3, 0),(4, NULL, '2500', '3000', 1, 0, 4, 0),(5, NULL, '3000', '3500', 1, 0, 5, 0),(6, NULL, '3500', '4000', 1, 0, 6, 0),(7, NULL, '4000', '4500', 1, 0, 7, 0),(8, NULL, '4500', '5000', 1, 0, 8, 0),(9, NULL, '5000', '5500', 1, 0, 9, 0),(10, NULL, '5500', '6000', 1, 0, 10, 0),(11, NULL, '6000', '7000', 1, 0, 11, 0),(12, NULL, '7000', '8000', 1, 0, 12, 0),(13, NULL, '8000', '9000', 1, 0, 13, 0),(14, NULL, '9000', '10000', 1, 0, 14, 0),(15, NULL, '10000', '10000', 1, 0, 15, 0);

DROP TABLE IF EXISTS `#__js_job_salaryrangetypes`;
CREATE TABLE `#__js_job_salaryrangetypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
INSERT INTO `#__js_job_salaryrangetypes` (`id`, `title`, `status`, `isdefault`, `ordering`, `serverid`) VALUES(1, 'Per Year', 1, 0, 1, 0),(2, 'Per Month', 1, 1, 2, 0),(3, 'Per Week', 1, 0, 3, 0),(4, 'Per Day', 1, 0, 4, 0);

DROP TABLE IF EXISTS `#__js_job_sharing_service_log`;
CREATE TABLE `#__js_job_sharing_service_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `referenceid` int(11) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `eventtype` varchar(255) DEFAULT NULL,
  `message` text,
  `messagetype` varchar(255) DEFAULT NULL,
  `datetime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_shifts`;
CREATE TABLE `#__js_job_shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `isactive` tinyint(1) DEFAULT '1',
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `serverid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
INSERT INTO `#__js_job_shifts` (`id`, `title`, `isactive`, `isdefault`, `ordering`, `status`, `serverid`) VALUES(1, 'Morning', 1, 1, 1, 0, 0),(2, 'Evening', 1, 0, 2, 0, 0),(3, '8 PM to 4 AM', 1, 0, 3, 0, 0);

DROP TABLE IF EXISTS `#__js_job_states`;
CREATE TABLE `#__js_job_states` (
  `id` smallint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) DEFAULT NULL,
  `shortRegion` varchar(25) DEFAULT NULL,
  `countryid` smallint(9) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryid` (`countryid`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;
INSERT INTO `#__js_job_states` (`id`, `name`, `shortRegion`, `countryid`, `enabled`, `serverid`) VALUES(1, 'Alabama', 'AL', 1, 1, 0),(2, 'Alaska', 'AK', 1, 1, 0),(3, 'Arizona', 'AZ', 1, 1, 0),(4, 'Arkansas', 'AR', 1, 1, 0),(5, 'California', 'CA', 1, 1, 0),(6, 'Colorado', 'CO', 1, 1, 0),(7, 'Connecticut', 'CT', 1, 1, 0),(8, 'Delaware', 'DE', 1, 1, 0),(9, 'District of Columbia', 'DC', 1, 1, 0),(10, 'Florida', 'FL', 1, 1, 0),(11, 'Georgia', 'GA', 1, 1, 0),(12, 'Hawaii', 'HI', 1, 1, 0),(13, 'Idaho', 'ID', 1, 1, 0),(14, 'Illinois', 'IL', 1, 1, 0),(15, 'Indiana', 'IN', 1, 1, 0),(16, 'Iowa', 'IA', 1, 1, 0),(17, 'Kansas', 'KS', 1, 1, 0),(18, 'Kentucky', 'KY', 1, 1, 0),(19, 'Louisiana', 'LA', 1, 1, 0),(20, 'Maine', 'ME', 1, 1, 0),(21, 'Maryland', 'MD', 1, 1, 0),(22, 'Massachusetts', 'MA', 1, 1, 0),(23, 'Michigan', 'MI', 1, 1, 0),(24, 'Minnesota', 'MN', 1, 1, 0),(25, 'Mississippi', 'MS', 1, 1, 0),(26, 'Missouri', 'MO', 1, 1, 0),(27, 'Montana', 'MT', 1, 1, 0),(28, 'Nebraska', 'NE', 1, 1, 0),(29, 'Nevada', 'NV', 1, 1, 0),(30, 'New Hampshire', 'NH', 1, 1, 0),(31, 'New Jersey', 'NJ', 1, 1, 0),(32, 'New Mexico', 'NM', 1, 1, 0),(33, 'New York', 'NY', 1, 1, 0),(34, 'North Carolina', 'NC', 1, 1, 0),(35, 'North Dakota', 'ND', 1, 1, 0),(36, 'Ohio', 'OH', 1, 1, 0),(37, 'Oklahoma', 'OK', 1, 1, 0),(38, 'Oregon', 'OR', 1, 1, 0),(39, 'Pennsylvania', 'PA', 1, 1, 0),(40, 'Rhode Island', 'RI', 1, 1, 0),(41, 'South Carolina', 'SC', 1, 1, 0),(42, 'South Dakota', 'SD', 1, 1, 0),(43, 'Tennessee', 'TN', 1, 1, 0),(44, 'Texas', 'TX', 1, 1, 0),(45, 'Utah', 'UT', 1, 1, 0),(46, 'Vermont', 'VT', 1, 1, 0),(47, 'Virginia', 'VA', 1, 1, 0),(48, 'Washington', 'WA', 1, 1, 0),(49, 'West Virginia', 'WV', 1, 1, 0),(50, 'Wisconsin', 'WI', 1, 1, 0),(51, 'Wyoming', 'WY', 1, 1, 0),(52, 'Alberta', 'AB', 2, 1, 0),(53, 'British Columbia', 'BC', 2, 1, 0),(54, 'Manitoba', 'MB', 2, 1, 0),(55, 'New Brunswick', 'NB', 2, 1, 0),(56, 'Newfoundland and Labrador', 'NL', 2, 1, 0),(57, 'Northwest Territories', 'NT', 2, 1, 0),(58, 'Nova Scotia', 'NS', 2, 1, 0),(59, 'Nunavut', 'NU', 2, 1, 0),(60, 'Ontario', 'ON', 2, 1, 0),(61, 'Prince Edward Island', 'PE', 2, 1, 0),(62, 'Quebec', 'QC', 2, 1, 0),(63, 'Saskatchewan', 'SK', 2, 1, 0),(64, 'Yukon', 'YT', 2, 1, 0),(65, 'England', 'England', 95, 1, 0),(66, 'Northern Ireland', 'NorthernIreland', 95, 1, 0),(67, 'Scotland', 'Scottland', 95, 1, 0),(68, 'Wales', 'Wales', 95, 1, 0),(86, 'NWFP', 'NWFP', 126, 1, 0),(87, 'FATA', 'FATA', 126, 1, 0),(88, 'Balochistan', 'Balochistan', 126, 1, 0),(89, 'Punjab', 'Punjab', 126, 1, 0),(90, 'Capital', 'Capital', 126, 1, 0);

DROP TABLE IF EXISTS `#__js_job_subcategories`;
CREATE TABLE `#__js_job_subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `alias` varchar(225) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `isdefault` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `serverid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_category_id` (`categoryid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=189 ;
INSERT INTO `#__js_job_subcategories` (`id`, `categoryid`, `title`, `alias`, `status`, `isdefault`, `ordering`, `serverid`) VALUES(1, 1, 'Cast Accounting ', 'cast-accounting-', 1, 0, 1, 0),(2, 1, 'Controllership & Accounting Managment', 'controllership-&-accounting-managment', 1, 0, 2, 0),(3, 1, 'Payroll ', 'payroll-', 1, 0, 3, 0),(4, 1, 'Corporate Finance', 'corporate-finance', 1, 0, 3, 0),(5, 2, 'Administrative Division', 'administrative-division', 1, 0, 1, 0),(6, 2, 'Autonomous Territories', 'autonomous-territories', 1, 0, 2, 0),(7, 2, 'Administrative County', 'administrative-county', 1, 0, 3, 0),(8, 2, 'Administrative Communes', 'administrative-communes', 1, 0, 3, 0),(9, 3, 'Finance Advertising ', 'finance-advertising-', 1, 0, 1, 0),(10, 3, 'Advertising-Tourism', 'advertising-tourism', 1, 0, 2, 0),(11, 3, 'Advertising Social Net', 'advertising-social-net', 1, 0, 3, 0),(12, 3, 'Distributor Marketing', 'distributor-marketing', 1, 0, 3, 0),(13, 3, 'Facebook Advertising', 'facebook-advertising', 1, 0, 5, 0),(14, 4, 'Quality Engineer ', 'quality-engineer-', 1, 0, 1, 0),(15, 4, 'Office Assistant ', 'office-assistant-', 1, 0, 2, 0),(16, 4, 'Air Host/hostess', 'air host-hostess', 1, 0, 3, 0),(17, 4, 'Ticketing/reservation', 'ticketing-reservation', 1, 0, 3, 0),(18, 5, 'Architectural Drafting', 'architectural-drafting', 1, 0, 1, 0),(19, 5, 'Enterprize Architecture', 'enterprize-architecture', 1, 0, 2, 0),(20, 5, 'Architecture Frameworks', 'architecture-frameworks', 1, 0, 3, 0),(21, 6, 'Automotive Design', 'automotive-design', 1, 0, 1, 0),(22, 6, 'Autmotive Paints', 'autmotive-paints', 1, 0, 2, 0),(23, 6, 'Automotive Equipment/Parts', 'automotive equipment-parts', 1, 0, 3, 0),(24, 6, 'Automotive Search Engine', 'automotive-search-engine', 1, 0, 3, 0),(25, 7, 'Private Banking', 'private-banking', 1, 0, 1, 0),(26, 7, 'Stock Brocker', 'stock-brocker', 1, 0, 2, 0),(27, 7, 'Fractional-reserve Banking', 'fractional-reserve-banking', 1, 0, 3, 0),(28, 7, 'Mobile Banking', 'mobile-banking', 1, 0, 4, 0),(29, 8, 'Plant Biotechnology', 'plant-biotechnology', 1, 0, 29, 0),(30, 8, 'Animal Biotechnology', 'animal-biotechnology', 1, 0, 30, 0),(31, 8, 'Biotechnology & Medicine', 'biotechnology-&-medicine', 1, 0, 31, 0),(32, 8, 'Biotechnology & Society', 'biotechnology-&-society', 1, 0, 32, 0),(33, 8, 'Industrail & Microbial Biotechnonogy', 'industrail-&-microbial-biotechnonogy', 1, 0, 33, 0),(34, 9, 'Construction (Design & Managment)', 'construction-(design-&-managment)', 1, 0, 34, 0),(35, 9, 'Construction Engineering ', 'construction-engineering-', 1, 0, 35, 0),(36, 9, 'Composite Construction', 'composite-construction', 1, 0, 36, 0),(37, 10, 'Civil Engineering', 'civil-engineering', 1, 0, 37, 0),(38, 10, 'Software Engineering', 'software-engineering', 1, 0, 38, 0),(39, 10, 'Nuclear Engineering', 'nuclear-engineering', 1, 0, 39, 0),(40, 10, 'Ocean Engingeering', 'ocean-engingeering', 1, 0, 40, 0),(41, 10, 'Transpotation Engineering', 'transpotation-engineering', 1, 0, 41, 0),(42, 11, 'Security Cleared Jobs', 'security-cleared-jobs', 1, 0, 42, 0),(43, 11, 'Security Cleared IT Jobs', 'security-cleared-it-jobs', 1, 0, 43, 0),(44, 11, 'Confidential & Secret Security Clearance Job', 'confidential-&-secret-security-clearance-job', 1, 0, 44, 0),(45, 12, 'Verbal', 'verbal', 1, 0, 1, 0),(46, 12, 'E-mail', 'e-mail', 1, 0, 2, 0),(47, 12, 'Non-verbal', 'non-verbal', 1, 0, 3, 0),(48, 13, 'Computer Consulting Services ', 'computer-consulting-services-', 1, 0, 1, 0),(49, 13, 'Computer Installations Services', 'computer-installations-services', 1, 0, 2, 0),(50, 13, 'Software Vendors', 'software-vendors', 1, 1, 3, 0),(51, 14, 'Renovaiton', 'renovaiton', 1, 0, 51, 0),(52, 14, 'Addition', 'addition', 1, 0, 52, 0),(53, 14, 'New Construction', 'new-construction', 1, 0, 53, 0),(54, 15, 'Organization Development', 'organization-development', 1, 0, 54, 0),(55, 15, 'Construction Management', 'construction-management', 1, 0, 55, 0),(56, 15, 'Managment Consulting ', 'managment-consulting-', 1, 0, 56, 0),(57, 16, 'High Touch Customer Service ', 'high-touch-customer-service-', 1, 0, 57, 0),(58, 16, 'Low Touch Customer Service', 'low-touch-customer-service', 1, 0, 58, 0),(59, 16, 'Bad Touch Customer Service', 'bad-touch-customer-service', 1, 0, 59, 0),(60, 17, 'By Using legal services for the poor', 'by-using-legal-services-for-the-poor', 1, 0, 60, 0),(61, 17, 'By Using Retained Counsel', 'by-using-retained-counsel', 1, 0, 61, 0),(62, 17, 'By Self-representation', 'by-self-representation', 1, 0, 62, 0),(63, 18, 'Project Subtype Design', 'project-subtype-design', 1, 0, 63, 0),(64, 18, 'Graphic Design', 'graphic-design', 1, 0, 64, 0),(65, 18, 'Interior Desing', 'interior-desing', 1, 0, 65, 0),(66, 19, 'IT or Engineering Education', 'it-or-engineering-education', 1, 0, 66, 0),(67, 19, 'Commerce & Managment', 'commerce-&-managment', 1, 0, 67, 0),(68, 19, 'Medical Education', 'medical-education', 1, 0, 68, 0),(69, 20, 'Power Engineering', 'power-engineering', 1, 0, 1, 0),(70, 20, 'Instrumentation', 'instrumentation', 1, 0, 2, 0),(71, 20, 'Telecommunication', 'telecommunication', 1, 0, 3, 0),(72, 20, 'Signal Processing', 'signal-processing', 1, 0, 4, 0),(73, 21, 'Electromagnetics', 'electromagnetics', 1, 0, 73, 0),(74, 21, 'Network Analysis', 'network-analysis', 1, 0, 74, 0),(75, 21, 'Control Systems', 'control-systems', 1, 0, 75, 0),(76, 22, 'Thermal Energy', 'thermal-energy', 1, 0, 76, 0),(77, 22, 'Chemical Energy', 'chemical-energy', 1, 0, 77, 0),(78, 22, 'Electrical Energy', 'electrical-energy', 1, 0, 78, 0),(79, 22, 'Nuclear Energy', 'nuclear-energy', 1, 0, 79, 0),(80, 23, 'Software Engineering ', 'software-engineering-', 1, 0, 80, 0),(81, 23, 'Civil Engineering ', 'civil-engineering-', 1, 0, 81, 0),(82, 23, 'Nuclear Engineering', 'nuclear-engineering', 1, 0, 82, 0),(83, 24, 'Nuclear Safety', 'nuclear-safety', 1, 0, 83, 0),(84, 24, 'Agriculture Safety', 'agriculture-safety', 1, 0, 84, 0),(85, 24, 'Occupational Health Safety', 'occupational-health-safety', 1, 0, 85, 0),(86, 25, 'Unique Fundraisers', 'unique-fundraisers', 1, 0, 86, 0),(87, 25, 'Sports Fundraiserse', 'sports-fundraiserse', 1, 0, 87, 0),(88, 25, 'Fundraisers', 'fundraisers', 1, 0, 88, 0),(89, 26, 'Staying Informed', 'staying-informed', 1, 0, 89, 0),(90, 26, 'Medical Edcuation ', 'medical-edcuation-', 1, 0, 90, 0),(91, 26, 'Managing a partucular disease', 'managing-a-partucular-disease', 1, 0, 91, 0),(92, 27, 'Customs & Border Protection', 'customs-&-border-protection', 1, 0, 92, 0),(93, 27, 'Federal Law & Enforcement', 'federal-law-&-enforcement', 1, 0, 93, 0),(94, 27, 'Nation Protection', 'nation-protection', 1, 0, 94, 0),(95, 28, 'Benefits Administrators', 'benefits-administrators', 1, 0, 95, 0),(96, 28, 'Executive Compensation Analysts', 'executive-compensation-analysts', 1, 0, 96, 0),(97, 28, 'Managment Analysts', 'managment-analysts', 1, 0, 97, 0),(98, 29, 'Health Insurance ', 'health-insurance-', 1, 0, 98, 0),(99, 29, 'Life Insurance', 'life-insurance', 1, 0, 99, 0),(100, 29, 'Vehicle Insurance', 'vehicle-insurance', 1, 0, 100, 0),(101, 30, 'Artificial Intelligence ', 'artificial-intelligence-', 1, 0, 101, 0),(102, 30, 'Predictive Analytics ', 'predictive-analytics-', 1, 0, 102, 0),(103, 30, 'Science & Technology', 'science-&-technology', 1, 0, 103, 0),(104, 31, 'Work Experience internship', 'work-experience-internship', 1, 0, 104, 0),(105, 31, 'Research internship', 'research-internship', 1, 0, 105, 0),(106, 31, 'Sales & Marketing Intern', 'sales-&-marketing-intern', 1, 0, 106, 0),(107, 32, 'According To Law', 'according-to-law', 1, 0, 107, 0),(108, 32, 'Defined Rule', 'defined-rule', 1, 0, 108, 0),(109, 33, 'Shipping ', 'shipping-', 1, 0, 109, 0),(110, 33, 'Transpotation Managment', 'transpotation-managment', 1, 0, 110, 0),(111, 33, 'Third-party Logistics Provider', 'third-party-logistics-provider', 1, 0, 111, 0),(112, 34, 'General Maintenance', 'general-maintenance', 1, 0, 112, 0),(113, 34, 'Automobile Maintenance ', 'automobile-maintenance-', 1, 0, 113, 0),(114, 34, 'Equipment Manitenance', 'equipment-manitenance', 1, 0, 114, 0),(115, 35, 'Project Managment', 'project-managment', 1, 0, 115, 0),(116, 35, 'Planning ', 'planning-', 1, 0, 116, 0),(117, 35, 'Risk Managment', 'risk-managment', 1, 0, 117, 0),(118, 36, 'Quality Assurance ', 'quality-assurance-', 1, 0, 118, 0),(119, 36, 'Product Manager', 'product-manager', 1, 0, 119, 0),(120, 36, 'Planning Supervisor ', 'planning-supervisor-', 1, 0, 120, 0),(121, 37, 'Networking ', 'networking-', 1, 0, 121, 0),(122, 37, 'Direct Mail Marketing', 'direct-mail-marketing', 1, 0, 122, 0),(123, 37, 'Media Advertising ', 'media-advertising-', 1, 0, 123, 0),(124, 38, 'Supply Chain ', 'supply-chain-', 1, 0, 124, 0),(125, 38, 'Hazardous Materials Management', 'hazardous-materials-management', 1, 0, 125, 0),(126, 38, 'Materials Inventory Managment', 'materials-inventory-managment', 1, 0, 126, 0),(127, 39, 'Aerospace ', 'aerospace-', 1, 0, 127, 0),(128, 39, 'Automotive ', 'automotive-', 1, 0, 128, 0),(129, 39, 'Biomedical', 'biomedical', 1, 0, 129, 0),(130, 39, 'Mechanical', 'mechanical', 1, 0, 130, 0),(131, 39, 'Naval', 'naval', 1, 0, 131, 0),(132, 40, 'Conventional Mortgage', 'conventional-mortgage', 1, 0, 132, 0),(133, 40, 'Adjustable Rate Mortgage', 'adjustable-rate-mortgage', 1, 0, 133, 0),(134, 40, 'Commercial Mortgages', 'commercial-mortgages', 1, 0, 134, 0),(135, 41, 'Economic Security', 'economic-security', 1, 0, 135, 0),(136, 41, 'Environmental Security', 'environmental-security', 1, 0, 136, 0),(137, 41, 'Military Security', 'military-security', 1, 0, 137, 0),(138, 42, 'Freelance Portfolios', 'freelance-portfolios', 1, 0, 138, 0),(139, 42, 'Freelance Freedom ', 'freelance-freedom-', 1, 0, 139, 0),(140, 42, 'Freelance Jobs', 'freelance-jobs', 1, 0, 140, 0),(141, 43, 'Offset Lithographp ', 'offset-lithographp-', 1, 0, 141, 0),(142, 43, 'Themography Raised Printing', 'themography-raised-printing', 1, 0, 142, 0),(143, 43, 'Digital Printing ', 'digital-printing-', 1, 0, 143, 0),(144, 44, 'idea Generation', 'idea-generation', 1, 0, 144, 0),(145, 44, 'Need Based Generation', 'need-based-generation', 1, 0, 145, 0),(146, 44, 'Design Solution', 'design-solution', 1, 0, 146, 0),(147, 45, 'Media Relations', 'media-relations', 1, 0, 147, 0),(148, 45, 'Media Tours ', 'media-tours-', 1, 0, 148, 0),(149, 45, 'Newsletters ', 'newsletters-', 1, 0, 149, 0),(150, 46, 'Automised Security', 'automised-security', 1, 0, 150, 0),(151, 46, 'Environmental & Social Safety', 'environmental-&-social-safety', 1, 0, 151, 0),(152, 47, 'Basic Research', 'basic-research', 1, 0, 152, 0),(153, 47, 'Applied Research', 'applied-research', 1, 0, 153, 0),(154, 47, 'Methods & Appraches ', 'methods-&-appraches-', 1, 0, 154, 0),(155, 48, 'Department Stores', 'department-stores', 1, 0, 155, 0),(156, 48, 'Discount Stores', 'discount-stores', 1, 0, 156, 0),(157, 48, 'Supermarkets', 'supermarkets', 1, 0, 157, 0),(158, 49, 'Sales Contracts ', 'sales-contracts-', 1, 0, 158, 0),(159, 49, 'Sales Forecasts ', 'sales-forecasts-', 1, 0, 159, 0),(160, 49, 'Sales Managment', 'sales-managment', 1, 0, 160, 0),(161, 50, 'Scientific Managment', 'scientific-managment', 1, 0, 161, 0),(162, 50, 'Scientific Research', 'scientific-research', 1, 0, 162, 0),(163, 50, 'Scientific invenctions ', 'scientific-invenctions-', 1, 0, 163, 0),(164, 51, 'Shppping/Distrubution Companies', 'shppping-distrubution companies', 1, 0, 164, 0),(165, 51, 'Services ', 'services-', 1, 0, 165, 0),(166, 51, 'Channels & Softwares', 'channels-&-softwares', 1, 0, 166, 0),(167, 52, 'Medical Technicians ', 'medical-technicians-', 1, 0, 167, 0),(168, 52, 'Electrical Technicians', 'electrical-technicians', 1, 0, 168, 0),(169, 52, 'Accounting Technicians ', 'accounting-technicians-', 1, 0, 169, 0),(170, 53, 'Construction Trade ', 'construction-trade-', 1, 0, 170, 0),(171, 53, 'Stock Trade', 'stock-trade', 1, 0, 171, 0),(172, 53, 'skilled Trade ', 'skilled-trade-', 1, 0, 172, 0),(173, 53, 'Option Trade ', 'option-trade-', 1, 0, 173, 0),(174, 54, 'Transpotation System', 'transpotation-system', 1, 0, 174, 0),(175, 54, 'Human-Powered ', 'human-powered-', 1, 0, 175, 0),(176, 54, 'Airline,Train,bus,car', 'airline,train,bus,car', 1, 0, 176, 0),(177, 55, 'Subway & Civil', 'subway-&-civil', 1, 0, 177, 0),(178, 55, 'Traffic Highway Transpotation', 'traffic-highway-transpotation', 1, 0, 178, 0),(179, 56, 'Small Business ', 'small-business-', 1, 0, 179, 0),(180, 56, 'E-Commerce Sites ', 'e-commerce-sites-', 1, 0, 180, 0),(181, 56, 'Portals ', 'portals-', 1, 0, 181, 0),(182, 56, 'Search Engines ', 'search-engines-', 1, 0, 182, 0),(183, 56, 'Personal,Commercial,Govt', 'personal,commercial,govt', 1, 0, 183, 0);

DROP TABLE IF EXISTS `#__js_job_userfields`;
CREATE TABLE `#__js_job_userfields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `description` mediumtext,
  `type` varchar(50) NOT NULL DEFAULT '',
  `maxlength` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `required` tinyint(4) DEFAULT '0',
  `ordering` int(11) DEFAULT NULL,
  `cols` int(11) DEFAULT NULL,
  `rows` int(11) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `default` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `fieldfor` tinyint(2) NOT NULL DEFAULT '0',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `calculated` tinyint(1) NOT NULL DEFAULT '0',
  `sys` tinyint(4) NOT NULL DEFAULT '0',
  `params` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_userfieldvalues`;
CREATE TABLE `#__js_job_userfieldvalues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` int(11) NOT NULL DEFAULT '0',
  `fieldtitle` varchar(255) NOT NULL DEFAULT '',
  `fieldvalue` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `sys` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_userfield_data`;
CREATE TABLE `#__js_job_userfield_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referenceid` int(11) NOT NULL,
  `field` int(10) unsigned DEFAULT NULL,
  `data` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_userroles`;
CREATE TABLE `#__js_job_userroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `dated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__js_job_zips`;
CREATE TABLE `#__js_job_zips` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) DEFAULT NULL,
  `enabled` char(1) DEFAULT 'Y',
  `countrycode` varchar(5) NOT NULL DEFAULT 'US',
  `statecode` varchar(50) DEFAULT NULL,
  `countycode` varchar(50) DEFAULT NULL,
  `citycode` varchar(50) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `countrystatecountycity` (`countrycode`,`statecode`,`countycode`,`citycode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

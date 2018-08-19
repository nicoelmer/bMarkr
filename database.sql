-- phpMyAdmin SQL Dump
-- version 4.7.8
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 20. Aug 2018 um 01:07
-- Server-Version: 5.7.23-0ubuntu0.16.04.1
-- PHP-Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bmark`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `url` text,
  `title` text,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `rating` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `url`, `title`, `description`, `created_at`, `rating`) VALUES
(57, 'https://www.rosemood.de/', 'Hochzeitseinladungen, Geburtskarten, Weihnachtskarten und Einladungen bei Rosemood selbst gestalten', '', '2018-08-02 20:06:41', 0),
(58, 'http://www.ianww.com/blog/2013/12/29/instantly-refresh-the-page-as-you-code/', 'autoreload.js: Instantly refresh the page as you code', '', '2018-06-19 12:58:05', 0),
(59, 'https://kramdown.gettalong.org/index.html', 'Home | kramdown', '', '2018-06-16 14:49:14', 0),
(60, 'http://blog.hehejo.de/2015/04/20/footnotes.html', 'Fußnoten mit Markdown', '', '2018-06-16 14:48:55', 0),
(61, 'https://michelf.ca/projects/php-markdown/', 'PHP Markdown', '', '2018-06-16 14:48:41', 0),
(62, 'https://github.com/wahidulislamriyad/Login-System-With-Sqlite-Database/blob/master/login-page.php', 'Login-System-With-Sqlite-Database/login-page.php at master · wahidulislamriyad/Login-System-With-Sqlite-Database · GitHub', '', '2018-06-08 21:41:47', 0),
(63, 'https://r-server.000webhostapp.com/login-sqlite/', 'Day 001 Login Form', '', '2018-06-08 21:41:33', 0),
(64, 'https://kerzol.github.io/markdown-mathjax/editor.html', 'Live markdown editor based on MathJax and Marked', '', '2018-06-04 21:53:02', 0),
(65, 'https://stackoverflow.com/questions/22542248/javascript-variable-in-src', 'html - Javascript variable in src - Stack Overflow', '', '2018-05-25 07:35:03', 0),
(66, 'https://www.afasterweb.com/2016/03/15/serving-up-brotli-with-nginx-and-jekyll/', 'Serving up Brotli with Nginx (and Automating it with Jekyll) | A Faster Web', '', '2018-05-22 09:55:33', 0),
(67, 'https://w3layouts.com/download-template/?l=6619&t=pack', 'Download Template - w3layouts.com', '', '2018-05-15 19:36:11', 0),
(68, 'https://stackoverflow.com/questions/43533079/how-to-display-pdf-file-in-html-div', 'javascript - How to display pdf file in html div - Stack Overflow', '', '2018-05-09 15:26:33', 0),
(69, 'https://web-preview.pspdfkit.com/showcase/gpewkxo', 'PSPDFKit for Web Showcase', '', '2018-05-05 14:36:23', 0),
(70, 'https://github.com/legalthings/angular-pdfjs-viewer', 'GitHub - legalthings/angular-pdfjs-viewer: PDF.js viewer directive for AngularJS', '', '2018-05-02 13:50:01', 0),
(71, 'https://docverter.com/learn/', 'Docverter', '', '2018-04-25 15:36:03', 0),
(72, 'https://github.com/kennethreitz/pyandoc', 'GitHub - kennethreitz/pyandoc: Python wrapper for Pandoc—the universal document converter.', '', '2018-04-25 15:20:42', 0),
(73, 'http://little-docus.de/python-skripte-ueber-php-ausfuehren/', 'Python-Skripte über PHP ausführen – little docus', '', '2018-04-25 15:12:35', 0),
(74, 'https://danieljhocking.wordpress.com/2014/12/09/writing-scientific-papers-using-markdown/', 'Writing Scientific Papers Using Markdown | Daniel J. Hocking', '', '2018-04-25 14:36:15', 0),
(75, 'https://www.digitalocean.com/community/tutorials/how-to-install-r-on-ubuntu-16-04-2', 'How To Install R on Ubuntu 16.04 | DigitalOcean', '', '2018-04-21 23:12:55', 0),
(76, 'https://www.digitalocean.com/community/tutorials/how-to-set-up-shiny-server-on-ubuntu-16-04', 'How to Set Up Shiny Server on Ubuntu 16.04 | DigitalOcean', '', '2018-04-21 23:12:31', 0),
(77, 'https://eeholmes.github.io/', 'Eli E. Holmes', '', '2018-04-19 18:33:16', 0),
(78, 'https://groups.google.com/forum/#!topic/prosody-users/SNW9jgbpgzY', 'Google Groups', '', '2018-04-13 08:08:09', 0),
(79, 'https://github.com/fastmailops/prosody', 'GitHub - fastmailops/prosody: Prosody XMPP server', '', '2018-03-27 21:22:11', 0),
(80, 'https://wiki.xmpp.org/web/SRV_Records', 'SRV Records - XMPP  WIKI', '', '2018-03-27 21:21:19', 0),
(81, 'http://prosody.im/doc/setting_up_bosh', 'Setting up a BOSH server    - Prosody.im', '', '2018-03-27 21:20:41', 0),
(82, 'https://git.chaostreffbern.ch/chaostreffbern/prosody-config', 'chaostreffbern / prosody-config · GitLab', '', '2018-03-27 19:07:39', 0),
(83, 'https://thomas-leister.de/prosody-xmpp-server-ubuntu/', 'Prosody XMPP Server unter Ubuntu Server installieren', '', '2018-03-27 11:26:49', 0),
(84, 'https://groups.google.com/forum/#!topic/prosody-users/lPjWXYbYfeI', 'Google Groups', '', '2018-03-26 20:38:37', 0),
(85, 'https://peterkieser.com/2016/03/09/prosody-websocket-behind-nginx-reverse-proxy/', 'prosody websocket behind nginx reverse proxy – Peter Kieser', '', '2018-03-26 20:38:09', 0),
(86, 'https://www.repairwin.com/download-office-2016-language-packs/', 'Download Office 2016 Language Packs & Change Office 2016 Display Language • Repair Windows™', '', '2018-03-06 12:00:54', 0),
(87, 'https://www.edx.org/course/subject/computer-science/python', 'Python Courses | edX', '', '2018-01-26 15:55:55', 0),
(88, 'https://developers.google.com/edu/python/', 'Google\'s Python Class  |  Python Education       |  Google Developers', '', '2018-01-26 15:55:25', 0),
(89, 'https://www.datacamp.com/courses/intro-to-python-for-data-science', 'Learn Python for Data Science - Online Course', '', '2018-01-26 15:39:51', 0),
(90, 'https://hackr.io/tutorials/learn-python', 'Learn Python - Best Python Tutorials | Hackr.io', '', '2018-01-26 15:39:18', 0),
(91, 'http://pythonforengineers.com/articles/', 'Articles – Python For Engineers', '', '2018-01-08 21:16:07', 0),
(92, 'https://www.grund-wissen.de/physik/_downloads/grundwissen-physik.pdf', 'Gurndwissen zu Physik', '', '2017-12-28 12:53:22', 0),
(93, 'https://www.frustfrei-lernen.de/deutsch/woyzeck-buechner-uebersicht.html', 'Georg Büchner - Woyzeck Übersicht', 'akad,literatur,georg,büchner', '2017-12-05 23:49:07', 0),
(94, 'https://lyrik.antikoerperchen.de/andreas-gryphius-traenen-des-vaterlandes,textbearbeitung,121.html', 'Tränen des Vaterlandes - Andreas Gryphius (Interpretation #121) (Barock)', 'gedicht,akad,Andreas,Gryphius', '2017-12-05 23:44:53', 0),
(95, 'http://www.lyrikmond.de/gedichte-thema-11-189.php#176', 'Gedicht - Tränen des Vaterlands', 'gedicht,akad,Andreas,Gryphius', '2017-12-05 23:42:44', 0),
(96, 'http://www.lyrikmond.de/gedicht-330.php', 'Interpretation Es ist alles eitel von Andreas Gryphius', 'gedicht,akad', '2017-12-05 23:38:43', 0),
(97, 'https://lyrik.antikoerperchen.de/andreas-gryphius-es-ist-alles-eitel,textbearbeitung,106.html', 'Es ist alles eitel - Andreas Gryphius (Interpretation #106) (Barock)', 'gedicht,akad', '2017-12-05 23:30:42', 0),
(98, 'https://lyrik.antikoerperchen.de/andreas-gryphius-es-ist-alles-eitel,textbearbeitung,36.html', 'Es ist alles eitel - Andreas Gryphius (Interpretation #36) (Barock)', 'gedicht,akad', '2017-12-05 23:30:21', 0),
(99, 'http://media.kswillisau.ch/', 'KSW Media - Lernraum', 'lernen', '2017-12-05 19:32:41', 0),
(100, 'https://repl.it', 'repl.it - Online REPL, Compiler & IDE', 'programmieren', '2017-12-05 19:32:20', 0),
(101, 'https://thomas-leister.de/prosody-xmpp-server-ubuntu/', 'Prosody XMPP Server unter Ubuntu Server installieren', 'Das persönliche Weblog zu den Themen Linux, Server und freier / offener Software', '2018-08-19 21:54:03', 0),
(102, 'https://thomas-leister.de/nginx-reverse-proxy-dynamischer-zielhost/', 'Nginx Reverse Proxy mit dynamischem Zielhost', 'Mithilfe eines Tricks kann Nginx auch mit dynamischen Ziel-Hosts (dynamische IP-Adresse) umgehen.', '2018-08-19 21:55:14', 0),
(104, 'https://blog.patricktriest.com/', 'Break | Better', 'Tutorials, Side-Projects, and Data-Driven Storytelling.', '2018-08-19 21:56:18', 0),
(106, 'https://niel.site/', 'Niel', 'secure end-to-end RSA-2048 encrypted messaging app and mutch more..', '2018-08-19 22:02:17', 0),
(107, 'https://www.digitalocean.com/community/tutorials/how-to-set-up-automatic-deployment-with-git-with-a-vps', 'How To Set Up Automatic Deployment with Git with a VPS | DigitalOcean', 'This article will teach you how to use Git when you want to deploy your application. While there are many ways to use Git to deploy our application, we\'ll focus on the one that is most straightforward.', '2018-08-19 23:04:28', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`uid`, `user`, `pass`, `email`, `profile_photo`) VALUES
(1, 'nelmer', 'OcinremlE69?', 'nico_elmer@niel.site', NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

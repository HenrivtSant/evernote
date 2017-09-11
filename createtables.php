<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11-9-2017
 * Time: 14:42
 */

$sql = <<<EOF

    CREATE DATABASE Evernote;
    
    USE Evernote;
    
    CREATE TABLE `category` (
        `cat_id` int(11) NOT NULL,
          `category` varchar(100) NOT NULL,
          `user_id` int(25) NOT NULL
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
        
        --
        -- Gegevens worden geëxporteerd voor tabel `category`
        --
        
        INSERT INTO `category` (`cat_id`, `category`, `user_id`) VALUES
        (1, 'casual', 6),
        (2, 'business', 6),
        (7, 'fun', 6);
        
        -- --------------------------------------------------------
        
        --
        -- Tabelstructuur voor tabel `notes`
        --
        
        CREATE TABLE `notes` (
        `note_id` int(11) NOT NULL,
          `user_id` int(25) NOT NULL,
          `cat_id` int(25) NOT NULL,
          `note_name` varchar(25) NOT NULL,
          `text` text NOT NULL,
          `image` varchar(100) DEFAULT NULL,
          `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
        
        --
        -- Gegevens worden geëxporteerd voor tabel `notes`
        --
        
        INSERT INTO `notes` (`note_id`, `user_id`, `cat_id`, `note_name`, `text`, `image`, `date`) VALUES
        (1, 6, 1, 'noteabc', 'Testje -\r\nblablablablablablablanlaladabhabablablabla', 'uploaded/image.jpg', '2017-08-30 09:12:34'),
        (2, 6, 1, 'testevernoteA', 'adadfasdfasdfasfasfasdfdas', 'uploaded/image.jpg', '2017-08-30 13:32:49'),
        (17, 6, 1, 'Testje', 'lalalalla', '', '2017-09-07 07:26:02'),
        (5, 6, 1, 'notetest', 'kdjflkajdfl;jal;dfjal;fjla;sjflaskjdfl;akjsdfl;as', 'uploaded/image.jpg', '2017-08-30 13:46:26'),
        (6, 2, 2, 'noteuserid2', 'blablablablablablablabla', NULL, '2017-09-01 08:37:39'),
        (13, 6, 2, 'Note', 'Hoi, dit is een test van de add note functie.\r\nDeze test is nu aangepast met de edit functie.', 'uploaded/image.jpg', '2017-09-01 09:50:17'),
        (14, 6, 2, 'Kladje', 'Dit is een test kladje', 'uploaded/image.jpg', '2017-09-01 10:41:35'),
        (15, 6, 1, 'Notitie', 'Dit is een test notitie', 'uploaded/image.jpg', '2017-09-01 10:41:59'),
        (16, 6, 1, 'Boodschappen', '1. Boodschap\r\n2. Boodschap\r\n3. Boodschap', 'uploaded/image.jpg', '2017-09-01 10:43:59'),
        (35, 6, 1, 'Uploadtest', 'testtesttest', 'uploads/', '2017-09-07 08:10:02'),
        (40, 6, 1, 'test', 'sgsdgs', 'uploads/Grappig-Plaatje-beheerder-team-aan-het-werk5.jpg', '2017-09-07 09:02:58'),
        (39, 6, 1, 'Image', 'Dit is een image', 'uploads/Grappig-Plaatje-beheerder-team-aan-het-werk4.jpg', '2017-09-07 08:28:00');
        
        -- --------------------------------------------------------
        
        --
        -- Tabelstructuur voor tabel `users`
        --
        
        CREATE TABLE `users` (
        `user_id` int(25) NOT NULL,
          `username` varchar(25) NOT NULL,
          `password` varchar(255) NOT NULL
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
        
        --
        -- Gegevens worden geëxporteerd voor tabel `users`
        --
        
        INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
        (1, 'piet', 'abcdABCD1234'),
        (2, 'jan', 'testABCD1234'),
        (3, 'kees', 'abcdABCD1234'),
        (4, 'jaap', 'abcdABCD1234'),
        (5, 'jip', 'abcdABCD1234'),
        (6, 'tester', 'abcdABCD1234'),
        (8, 'hashpassword', 'abcdABCD1234'),
        (9, 'hashpassworda', '$2y$10$UOgeznQdL/5vUtrGjUxp1e71XyLUiGDNzh2klj6qLz7JlYga98zEe'),
        (10, 'hash', '$2y$10$lZL8Y2qxStaNKjWX.xCS6.zTF2D8upTiCF1h7YOlp.OOEY7uSUiFi');
        
        --
        -- Indexen voor geëxporteerde tabellen
        --
        
        --
        -- Indexen voor tabel `category`
        --
        ALTER TABLE `category`
          ADD PRIMARY KEY (`cat_id`);
        
        --
        -- Indexen voor tabel `notes`
        --
        ALTER TABLE `notes`
          ADD PRIMARY KEY (`note_id`);
        
        --
        -- Indexen voor tabel `users`
        --
        ALTER TABLE `users`
          ADD PRIMARY KEY (`user_id`);
        
        --
        -- AUTO_INCREMENT voor geëxporteerde tabellen
        --
        
        --
        -- AUTO_INCREMENT voor een tabel `category`
        --
        ALTER TABLE `category`
          MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
        --
        -- AUTO_INCREMENT voor een tabel `notes`
        --
        ALTER TABLE `notes`
          MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
        --
        -- AUTO_INCREMENT voor een tabel `users`
        --
        ALTER TABLE `users`
          MODIFY `user_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
        /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
        /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

    

EOF;

$connection = new mysqli("10.130.18.90", "root", "rootroot");

if ($connection->connect_error) {
    die("connection failed: " . $conn->connect_error);
}

if ($connection->query($sql)) {
    echo "Database and stuff created succesfully!";
}


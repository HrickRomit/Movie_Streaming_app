-- SQL file for creating all tables

-- Watch history per user per movie
CREATE TABLE IF NOT EXISTS `watch_history` (
	`UserID` INT NOT NULL,
	`MovieID` INT NOT NULL,
	`watched_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`times_watched` INT NOT NULL DEFAULT 1,
	`last_position_seconds` INT NOT NULL DEFAULT 0,
	PRIMARY KEY (`UserID`, `MovieID`),
	KEY `idx_wh_user_time` (`UserID`, `watched_at`),
	CONSTRAINT `fk_wh_user` FOREIGN KEY (`UserID`) REFERENCES `User`(`UserID`) ON DELETE CASCADE,
	CONSTRAINT `fk_wh_movie` FOREIGN KEY (`MovieID`) REFERENCES `movies`(`MovieID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- -- phpMyAdmin SQL Dump
-- -- version 5.2.1
-- -- https://www.phpmyadmin.net/
-- --
-- -- Host: 127.0.0.1
-- -- Generation Time: Aug 19, 2025 at 03:58 PM
-- -- Server version: 10.4.32-MariaDB
-- -- PHP Version: 8.2.12

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";


-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!40101 SET NAMES utf8mb4 */;

-- --
-- -- Database: `dbms_movie_project`
-- --

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `admin`
-- --

-- CREATE TABLE `admin` (
--   `id` int(11) NOT NULL,
--   `admin_username` varchar(100) NOT NULL,
--   `admin_password` varchar(100) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Dumping data for table `admin`
-- --

-- INSERT INTO `admin` (`id`, `admin_username`, `admin_password`) VALUES
-- (1, 'admin1', 'admin123'),
-- (2, 'superadmin', 'superpass');

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `favourites`
-- --

-- CREATE TABLE `favourites` (
--   `id` int(11) NOT NULL,
--   `user_id` int(11) NOT NULL,
--   `movie_id` int(11) NOT NULL,
--   `created_at` timestamp NOT NULL DEFAULT current_timestamp()
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Dumping data for table `favourites`
-- --

-- INSERT INTO `favourites` (`id`, `user_id`, `movie_id`, `created_at`) VALUES
-- (1, 1, 2, '2025-08-17 17:17:03');

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `genre`
-- --

-- CREATE TABLE `genre` (
--   `GenreID` int(11) NOT NULL,
--   `GenreName` varchar(20) DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Dumping data for table `genre`
-- --

-- INSERT INTO `genre` (`GenreID`, `GenreName`) VALUES
-- (1, 'Action'),
-- (2, 'Comedy'),
-- (3, 'Drama'),
-- (4, 'Sci-Fi'),
-- (5, 'Horror'),
-- (6, 'Romance'),
-- (7, 'Thriller'),
-- (8, 'Fantasy'),
-- (9, 'Animation'),
-- (10, 'Adventure');

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `movies`
-- --

-- CREATE TABLE `movies` (
--   `MovieID` int(11) NOT NULL,
--   `MovieName` varchar(100) DEFAULT NULL,
--   `MovieLanguage` varchar(20) DEFAULT NULL,
--   `ReleaseYear` int(11) DEFAULT NULL,
--   `Description` varchar(500) DEFAULT NULL,
--   `Thumbnail` varchar(100) DEFAULT NULL,
--   `GenreID` int(11) DEFAULT NULL,
--   `MovieVideo` varchar(255) DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Dumping data for table `movies`
-- --

-- INSERT INTO `movies` (`MovieID`, `MovieName`, `MovieLanguage`, `ReleaseYear`, `Description`, `Thumbnail`, `GenreID`, `MovieVideo`) VALUES
-- (1, 'Inception', 'English', 2010, 'Inception is a slick, mind‑bending heist set inside layered dreams. Master extractor Dom Cobb is offered redemption if he can do the impossible: plant an idea instead of stealing one. He assembles a specialist crew, navigates shifting architectures, and battles projections fueled by guilt for his late wife. As time dilates and realities stack, the mission risks collapse. Cobb must choose between a haunted past and a fragile hope of reunion with his children.', 'inception.jpg', 4, '../uploads/videos/inception.mp4'),
-- (2, 'The Godfather', 'English', 1972, 'The Godfather chronicles the rise of Michael Corleone as he inherits the mantle of power from his father, Vito, patriarch of the Corleone crime family. Amid rival families, shifting alliances, and the old world’s code of honor, Michael’s transformation from reluctant outsider to calculating boss is both inevitable and tragic. Loyalty is rewarded, betrayal is punished, and the price of protection is measured in blood, silence, and sacrifice.', 'godfather.jpg', 3, '../uploads/videos/the_godfather.mp4'),
-- (3, 'Spirited Away', 'Japanese', 2001, 'Spirited Away follows Chihiro, a timid girl who stumbles into a spirit realm where her parents become pigs and her name is stolen. To survive, she works in a fantastical bathhouse run by the witch Yubaba, befriends the mysterious Haku, and learns courage through kindness and grit. Among soot sprites, river spirits, and greedy specters, Chihiro discovers her voice, her compassion, and a path home that honors memory, humility, and love.', 'spirited_away.jpg', 9, '../uploads/videos/spirited_away.mp4'),
-- (4, 'Parasite', 'Korean', 2019, 'Parasite is a razor‑sharp class satire where the poor Kim family schemes their way into the wealthy Park household. What begins as clever infiltration turns into a tense dance of deceit as hidden basements, storm‑soaked nights, and mounting desperation reveal the rot beneath privilege. With humor, dread, and sudden violence, the film exposes the fragile barriers between aspiration and survival—and the costs of climbing a rigged ladder.', 'parasite.jpg', 3, '../uploads/videos/parasite.mp4'),
-- (5, 'Avengers: Endgame', 'English', 2019, 'Avengers: Endgame finds Earth’s mightiest heroes shattered after Thanos erased half of life. When a risky time‑heist offers one last chance, the team revisits their past, faces grief, and redefines sacrifice. Old rivalries soften into trust, unexpected partnerships bloom, and legends take their bows. The final battle thunders with hope and heartbreak, honoring fallen friends while proving that even in defeat, unity can bend destiny back toward light.', 'endgame.jpg', 1, '../uploads/videos/avengers_endgame.mp4'),
-- (6, 'Interstellar', 'English', 2014, 'Interstellar sends a ragtag crew through a wormhole to find a new home as Earth withers. Pilot Cooper leaves his daughter, Murph, to chase a sliver of survival among distant worlds where time itself is treacherous. From frozen clouds to tidal giants, science and love collide. Messages cross decades, black holes guard secrets, and a bookshelf becomes a bridge. Humanity’s future hinges on courage, equation, and the stubborn gravity of family.', 'interstellar.jpg', 4, '../uploads/videos/interstellar.mp4'),
-- (7, 'Get Out', 'English', 2017, 'Get Out blends social horror and sharp satire as Chris visits his white girlfriend’s affluent family for a weekend that curdles into nightmare. Microaggressions mask something predatory; smiles feel staged; hypnosis opens a sunken place of voiceless dread. Beneath the polite veneer lies a grotesque scheme of appropriation. Chris must outwit charm and menace alike, reclaiming agency in a finale that jolts with catharsis and cutting insight.', 'getout.jpg', 5, '../uploads/videos/get_out.mp4'),
-- (8, 'The Notebook', 'English', 2004, 'The Notebook is a sweeping romance that spans decades, tracing Noah and Allie from summer infatuation to love tested by class, war, and time. Read aloud from a faded journal in a nursing home, their story flickers between youth’s wildfire and the gentle embers of devotion. Parents disapprove, fate intervenes, and choices echo. In storms, porches, and letters unsent, they learn that true love is stubborn, imperfect, and worth remembering.', 'notebook.jpg', 6, '../uploads/videos/the_notebook.mp4'),
-- (9, 'The Dark Knight', 'English', 2008, 'The Dark Knight pits Batman against the Joker, an agent of chaos who weaponizes fear, ethics, and Gotham’s fragile hope. As Harvey Dent’s crusade falters, lines blur between heroism and vigilantism. The Joker’s games force impossible choices—ferries, hostages, and the soul of a city. Bruce Wayne risks reputation for a greater good, proving that sometimes a hero is the one willing to be misunderstood to keep others believing.', 'dark_knight.jpg', 7, '../uploads/videos/the_dark_knight.mp4'),
-- (10, 'Harry Potter and the Philosophers Stone', 'English', 2001, 'Harry Potter and the Philosopher’s Stone begins a wizard’s journey for an orphan who discovers he belongs to a hidden world of owls, spells, and friendship. At Hogwarts, Harry finds allies in Ron and Hermione, faces a troll, learns Quidditch, and unravels a mystery linked to a dark sorcerer. Tests of courage and loyalty set the tone for adventures ahead, reminding us that love leaves a protection no curse can easily break.', 'harry_potter.jpg', 8, '../uploads/videos/harry_potter.mp4'),
-- (29, 'Avatar', 'English', 2009, 'Avatar immerses us in Pandora, a lush moon where human greed clashes with the Na’vi’s sacred bond to nature. Disabled Marine Jake Sully pilots an avatar body, learning the people’s ways through Neytiri and discovering a cause worth more than corporate orders. As bioluminescent forests glow and banshees soar, Jake must choose identity and home. The battle to protect the Tree of Souls becomes a fight for balance between progress and life itself.', 'avatar.jpg', 4, '../uploads/videos/avatar.mp4'),
-- (30, 'La La Land', 'English', 2016, 'La La Land is a bittersweet musical about ambition and love in Los Angeles. Jazz pianist Sebastian and actress Mia orbit each other through auditions, near‑misses, and starry night dances, pushing one another to dream bigger. Success demands compromise; timing becomes the cruelest collaborator. With radiant colors and aching melodies, the film asks whether love must yield to purpose—and whether the memory of a perfect season can be enough.', 'la_la_land.jpg', 6, '../uploads/videos/la_la_land.mp4'),
-- (31, 'Mad Max: Fury Road', 'English', 2015, 'Mad Max: Fury Road roars across a blasted desert where water and freedom are hoarded by tyrants. Imperator Furiosa rebels, smuggling enslaved wives toward redemption, and the drifter Max becomes reluctant ally. Thunderous chases, sandstorms, and roaring engines blur into a ballet of survival. In the war rig’s steel spine, trust is welded from necessity. The road to hope runs through fury, grit, and the will to break the wheel.', 'mad_max_fury_road.jpg', 1, '../uploads/videos/mad_max.mp4'),
-- (32, 'Frozen', 'English', 2013, 'Frozen follows sisters Elsa and Anna after a burst of uncontrolled magic shrouds Arendelle in winter. Elsa, fearing the harm she might cause, hides; Anna, propelled by loyalty, ventures across ice and mountain with a gruff ice cutter and a sunny snowman. Misjudged love, buried truths, and sisterly sacrifice reshape the kingdom. The film melts the idea that true love must be romantic, revealing a warmer core: acceptance and self‑belief.', 'frozen.jpg', 9, '../uploads/videos/frozen.mp4'),
-- (33, 'Joker', 'English', 2019, 'Joker charts Arthur Fleck’s spiral from marginalized clown to symbol of unrest in a city that refuses to see him. Laughter becomes a mask for isolation, medication dulls and then deserts him, and every slight compounds. As society’s safety nets fray, Arthur crafts a persona that feels powerful, terrifying, and contagious. The film is an unsettling mirror that asks what happens when neglect, cruelty, and myth collide in one fragile mind.', 'joker.jpg', 3, '../uploads/videos/joker.mp4'),
-- (34, 'Black Panther', 'English', 2018, 'Black Panther crowns T’Challa as king of Wakanda, a hidden nation rich in vibranium and tradition. Challenged by Killmonger, a rival born of pain and diaspora, T’Challa must balance heritage with responsibility to the world beyond closed borders. Ritual combat, genius tech, and fierce sisterhood define the struggle. In victory, Wakanda reimagines power as stewardship, extending knowledge and aid while honoring the roots that sustain it.', 'black_panther.jpg', 1, '../uploads/videos/black_panther.mp4'),
-- (35, 'Everything Everywhere All at Once', 'Mandarin ', 2022, 'Everything Everywhere All at Once hurls Evelyn, a weary laundromat owner, across absurd multiverses where hot‑dog hands, googly eyes, and martial mayhem collide. To stop a nihilistic force, she must connect with versions of herself and her family, reclaiming tenderness in chaos. Love becomes the radical act; empathy, the weapon. In bagels and blades, taxes and cosmic dread, the film insists that small kindnesses can anchor infinite possibility.', 'everything_everywhere.jpg', 4, '../uploads/videos/everything_everywhere.mp4'),
-- (36, 'The Social Network', 'English', 2010, 'The Social Network traces Facebook’s audacious birth in dorm rooms and depositions. Mark Zuckerberg’s code, Eduardo Saverin’s funds, and the Winklevoss twins’ grievances collide with Sean Parker’s swagger. Lawsuits and broken friendships expose the cost of velocity in the digital gold rush. Ambition, insecurity, and belonging mingle in late‑night sprints, revealing how a platform promising connection began with a series of calculated exclusions.', 'social_network.jpg', 3, '../uploads/videos/the_social_network.mp4'),
-- (37, 'Coco', 'English', 2017, 'Coco celebrates family, music, and memory as young Miguel crosses into the Land of the Dead to pursue his dream. With a stray dog and a charming trickster as guides, he uncovers the truth behind a stolen song and a forgotten father. Marigold bridges glow, skeletons waltz, and photos on an ofrenda hold love’s lifeline. The film honors ancestors and warns: oblivion comes when we are no longer remembered—or when the truth is silenced.', 'coco.jpg', 9, '../uploads/videos/coco.mp4'),
-- (38, 'The Revenant', 'English', 2015, 'The Revenant follows Hugh Glass, mauled by a bear and left for dead, clawing through frozen wilderness to survive and seek justice. Rivers rage, breath steams, and every step hurts. Betrayal burns hotter than campfire embers as Glass tracks his quarry across brutal landscapes. The film is a meditation on endurance and vengeance, where nature is both cathedral and executioner, and survival requires a ferocity that eclipses outrage.', 'revenant.jpg', 2, '../uploads/videos/revenant.mp4'),
-- (39, 'Inside Out', 'English', 2015, 'Inside Out journeys through the mind of eleven‑year‑old Riley, where Joy, Sadness, Anger, Fear, and Disgust steer her through a family move. When core memories scatter, Joy learns that Sadness is not an enemy but a bridge. Long‑forgotten friends, collapsing islands of personality, and a train of thought all shape Riley’s growth. The film gently teaches that feeling deeply—even the hard feelings—is how we heal, connect, and grow resilient.', 'inside_out.jpg', 9, '../uploads/videos/inside_out.mp4'),
-- (40, 'Her', 'English', 2013, 'Her explores an aching near‑future where Theodore, a lonely writer, falls for Samantha, an advanced operating system. Their intimacy blooms beyond screens, challenging the boundaries of embodiment, jealousy, and selfhood. As Samantha evolves past human pace, Theodore confronts the limits of connection and the courage to love again. The film hums with quiet longing, suggesting that technology can mirror us—but cannot carry our growing for us.', 'her.jpg', 6, '../uploads/videos/her.mp4'),
-- (41, 'Gravity', 'English', 2013, 'Gravity strands two astronauts in orbit after debris shreds their shuttle. With oxygen dwindling and silence pressing in, Dr. Ryan Stone must improvise her way across the void, tethered to wits, training, and a fragile will to live. Spinning vistas and weightless tumbles blur terror into grace. Grief becomes ballast; fire reenters the story. In the end, survival is a series of steady breaths and stubborn steps back toward Earth.', 'gravity.jpg', 4, '../uploads/videos/gravity.mp4'),
-- (42, 'Whiplash', 'English', 2014, 'Whiplash hammers a young drummer against the impossible standards of a ruthless jazz instructor. Practice rooms become arenas; tempo is weaponized; approval is withheld like oxygen. Andrew bleeds for greatness, unsure whether obsession sharpens excellence or corrodes the soul. In a blistering final duet, teacher and student battle for control, revealing a brutal truth: sometimes the line between mentorship and abuse is drawn in sweat and cymbals.', 'whiplash.jpg', 3, '../uploads/videos/whiplash.mp4'),
-- (43, 'Shutter Island', 'English', 2010, 'Shutter Island follows U.S. Marshal Teddy Daniels to an isolated asylum to investigate a vanished patient. Storms trap the island; whispers of unethical experiments stir paranoia. Teddy’s visions blur case and trauma, hinting that the prison walls might be inside his own mind. As clues twist upon themselves, the question shifts from who committed a crime to who gets to define reality—and what mercy might look like for the broken.', 'shutter_island.jpg', 5, '../uploads/videos/shutter_island.mp4'),
-- (44, 'The Martian', 'English', 2015, 'The Martian strands botanist Mark Watney on Mars, presumed dead by his crew. With humor, ingenuity, and duct‑taped science, he grows potatoes, hacks gear, and turns a habitat into a lifeboat while Earth scrambles a rescue. Calculations become lifelines; disco becomes company. The story champions problem‑solving optimism—the idea that knowledge, teamwork, and stubborn hope can make even a hostile planet just survivable enough for a comeback.', 'martian.jpg', 4, '../uploads/videos/martian.mp4'),
-- (45, 'Zootopia', 'English', 2016, 'Zootopia pairs an idealistic bunny cop with a sly fox in a sprawling city where prey and predator share uneasy peace. A conspiracy preys on fear, turning difference into suspicion. Judy and Nick track clues through DMV sloths, tiny mob bosses, and glittery pop shows, learning to check bias and see nuance. The film’s bright comedy wraps a thoughtful plea: communities thrive when empathy outpaces stereotype and institutions serve everyone.', 'zootopia.jpg', 9, '../uploads/videos/zootopia.mp4'),
-- (46, 'Slumdog Millionaire', 'Hindi', 2008, 'Slumdog Millionaire follows Jamal Malik from Mumbai’s slums to the hot lights of a game show, where each question unlocks a memory of hardship, love, and luck. Accused of cheating, he recounts a life stitched with survival and devotion to Latika. The city is merciless and luminous at once. Fate, chance, and choice dance together until answers align—not for wealth alone, but for reunion and the belief that destiny can be earned.', 'slumdog_millionaire.jpg', 3, '../uploads/videos/slumdog_millionaire.mp4'),
-- (47, 'Dune', 'English', 2021, 'Dune charts Paul Atreides’ awakening on the desert planet Arrakis, where spice fuels empires and sand conceals leviathans. Betrayal scatters his family, forcing him into the dunes among the Fremen, whose ways teach survival, rhythm, and prophecy. Political intrigue, mystic visions, and martial training converge as Paul confronts the weight of a destiny that could liberate or doom. The wind sings of power tempered by humility and purpose.', 'dune.jpg', 4, '../uploads/videos/dune.mp4'),
-- (48, 'The Batman', 'English', 2022, 'The Batman casts a younger Bruce Wayne as a relentless, nocturnal detective stalking corruption that festers beneath Gotham’s rain. The Riddler’s cryptic killings expose rot in institutions and family legacies alike. With Selina Kyle, Batman learns that justice requires compassion, not just fear. In murky alleys and monochrome neon, he pivots from vengeance toward hope, becoming a symbol willing to wade through darkness to light the way.', 'the_batman.jpg', 7, '../uploads/videos/the_batman.mp4'),
-- (49, 'The Wolf of Wall Street', 'English', 2013, 'The Wolf of Wall Street rockets through the obscene highs and skid‑out lows of Jordan Belfort’s brokerage empire. Fueled by greed, drugs, and genius for persuasion, he builds a carnival of excess where consequences feel theoretical—until the cuffs click. The film’s manic energy indicts and seduces, asking whether the American dream has mutated into a pyramid built on appetite, and what remains when the party money finally sobers up.', 'wolf_of_wall_street.jpg', 2, '../uploads/videos/wolf_of_wall_street.mp4'),
-- (50, 'Top Gun: Maverick', 'English', 2022, 'Top Gun: Maverick sends ace pilot Pete “Maverick” Mitchell back to teach a daring strike mission to a new generation, including the son of his fallen friend. Haunted by guilt yet addicted to the sky, he pushes limits in roaring jets and fragile classrooms. Leadership becomes an act of trust; death is a constant wingman. In a climactic run, skill meets sacrifice, proving that experience, humility, and belief can outfly fear.', 'top_gun_maverick.jpg', 1, '../uploads/videos/top_gun_maverick.mp4'),
-- (51, 'The Shape of Water', 'English', 2017, 'The Shape of Water tells of Elisa, a mute custodian who forms a tender bond with an amphibious being held captive in a Cold War lab. In stolen moments of music and saltwater, their connection blooms despite cruelty around them. Friends risk everything, villains sharpen their edges, and love defies taxonomy. The film asks us to see monsters in the mirrors we avoid—and grace in places the powerful overlook or discard.', 'shape_of_water.jpg', 6, '../uploads/videos/shape_of_water.mp4'),
-- (52, 'Oppenheimer', 'English', 2023, 'Oppenheimer traces the volatile life of J. Robert Oppenheimer as he shepherds the Manhattan Project and then faces the moral blast radius of success. Scientific brilliance collides with politics, paranoia, and conscience. In hearings and deserts, equations become fire; victory curdles into dread. The film wrestles with genius as burden, asking whether those who ignite new suns can ever again stand comfortably in their light.', 'oppenheimer.jpg', 3, '../uploads/videos/oppenheimer.mp4'),
-- (53, 'Guardians of the Galaxy', 'English', 2014, 'Guardians of the Galaxy assembles a misfit crew—thief, assassin, outlaw, tree, and raccoon—who bicker, boogie, and somehow save the cosmos. What begins as a squabble over a mysterious orb becomes a chosen‑family story powered by mixtapes and sarcasm. Under neon skies and prison breaks, they learn that found friends can rewrite fate. The galaxy doesn’t need perfect heroes; it needs people who show up, laugh, and refuse to let go.', 'guardians_of_the_galaxy.jpg', 1, '../uploads/videos/guardians_of_the_galaxy.mp4'),
-- (54, 'The Hunger Games', 'English', 2012, 'The Hunger Games follows Katniss Everdeen, who volunteers in place of her sister to fight in a televised death match designed to terrorize the districts. Armed with grit, a bow, and defiance, she navigates alliances, spectacle, and a blooming symbol of rebellion. Cameras hunger for a story; the Capitol hungers for control. Katniss learns to weaponize empathy, turning survival into a spark that threatens to set the empire ablaze.', 'hunger_games.jpg', 1, '../uploads/videos/hunger_games.mp4'),
-- (55, 'The Lion King', 'English', 2019, 'The Lion King retells a timeless myth as Simba, a guilt‑haunted prince, flees his kingdom after betrayal and must reclaim his place in the circle of life. Guided by memory, friends, and the wisdom of ancestors, he confronts the usurper who twisted love into power. From sun‑lit plains to ghostly skies, the journey affirms that identity is not escaped but embraced—and that courage is remembering who you are when it matters most.', 'lion_king.jpg', 9, '../uploads/videos/lion_king.mp4'),
-- (56, 'Frozen II', 'English', 2019, 'Frozen II sends Elsa and Anna into an enchanted forest to uncover the origin of Elsa’s powers and heal a rift between peoples. Ancient songs, living elements, and buried truths pull them beyond maps. Anna learns that leadership can mean doing the next right thing when hope is thin; Elsa discovers a calling that honors both self and home. Together they prove that growth demands change—and that love can weather even shifting seasons.', 'frozen_ii.jpg', 9, '../uploads/videos/frozen_ii.mp4'),
-- (57, 'Tenet', 'English', 2020, 'Tenet is a high‑concept spy puzzle where time inversion lets effects precede causes. A nameless Protagonist teams with the enigmatic Neil to stop a future war rippling backward through the present. Bullets un‑fire, fights un‑happen, and trust loops upon itself. As timelines braid into a temporal pincer, the mission becomes a paradox of friendship and fate, asking whether knowledge of tomorrow frees us—or fixes our path.', 'tenet.jpg', 4, '../uploads/videos/tenet.mp4'),
-- (58, 'Soul', 'English', 2020, 'Soul follows Joe Gardner, a middle‑school music teacher whose big break is interrupted by an untimely mishap that sends his soul to the Great Before. Paired with cynical 22, he learns that purpose isn’t a single destiny but the texture of living—pizza slices, breezes, and songs that find us. Mentorship becomes mutual; bodies and hearts re‑align. The film invites us to savor ordinary sparks as the meaning we keep searching to name.', 'soul.jpg', 9, '../uploads/videos/soul.mp4'),
-- (59, 'Doctor Strange', 'English', 2016, 'Doctor Strange charts surgeon Stephen Strange’s fall from arrogant certainty to mystic defender after a crash ruins his hands. Seeking healing, he finds the Ancient One and a hidden world of sorcery where reality folds like origami. Pride gives way to curiosity, then responsibility, as Strange learns to bargain time itself for others. Portals bloom, capes sass, and a looping sacrifice reframes victory as a clever refusal to kill.', 'doctor_strange.jpg', 1, '../uploads/videos/doctor_strange.mp4'),
-- (60, 'Minari', 'Korean', 2020, 'Minari tenderly portrays a Korean family chasing hope on an Arkansas farm in the 1980s. Jacob dreams of independence; Monica yearns for stability; their children navigate identity between languages and fields. Grandma Soon‑ja arrives with seeds and stubborn humor, planting resilience that blooms amid setbacks. The film’s quiet power lies in small labors, creek water, and the taste of minari—humble greens that thrive where others fail.', 'minari.jpg', 3, '../uploads/videos/minari.mp4'),
-- (61, 'No Time to Die', 'English', 2021, 'No Time to Die returns James Bond from retirement to confront ghosts of love and bioweapon peril. A new 00 shares the field, alliances shift, and trust costs dearly. Gadgets hum, Aston Martins roar, and a villain’s island hides a lethal nursery. Bond’s choices weigh legacy against a future he may never see. In farewells and firefights, he proves that duty and tenderness can share a single, explosive heartbeat.', 'no_time_to_die.jpg', 1, '../uploads/videos/no_time_to_die.mp4'),
-- (62, 'Encanto', 'English', 2021, 'Encanto centers on the Madrigals, a Colombian family blessed with magical gifts—everyone except Mirabel. When the miracle that powers their enchanted casita begins to crack, Mirabel’s empathy becomes the key to healing rifts and secrets. Through color, rhythm, and interwoven stories, the film reframes heroism as care, showing that families thrive when pressure lifts and each person is embraced for who they are, not what they perform.', 'encanto.jpg', 9, '../uploads/videos/encanto.mp4'),
-- (63, 'Barbie', 'English', 2023, 'Barbie leaves a perfect pink utopia to face the chaotic reality of the human world, confronting insecurity, patriarchy, and messy wonder. Alongside a newly self‑aware Ken, she questions purpose and identity, discovering that being “real” means accepting contradictions. The film leans into humor and meta‑play while honoring the power of imagination. It’s a sparkling fable about agency, inclusivity, and rewriting what a doll—and a person—can be.', 'barbie.jpg', 2, '../uploads/videos/barbie.mp4'),
-- (64, 'Logan', 'English', 2017, 'Logan finds an aging Wolverine hiding at the margins, caring for a frail Professor X while his own healing falters. When a young mutant with familiar claws needs protection, Logan is pulled into a brutal road odyssey toward a lost Eden. Violence scars, tenderness flickers, and legacy weighs heavy. In dust, motels, and quiet fields, the film gives a weary hero the grace of truth: that love can be fierce without surviving the fight.', 'logan.jpg', 1, '../uploads/videos/logan.mp4'),
-- (65, 'Crawl', 'English', 2019, 'Crawl traps a college swimmer and her estranged father in a flooding Florida house during a hurricane, with hungry alligators circling. As water rises, hallways become rivers, and basement pipes turn into lifelines. Survival demands grit, speed, and smart use of the home’s crumbling geometry. The film’s lean thrills never waste a minute, reminding us that nature’s fury and family fractures can be battled—one breath, crawl space, and heartbeat at a time.', 'crawl.jpg', 5, '../uploads/videos/crawl.mp4'),
-- (66, '1917', 'English', 2019, '1917 tracks two young British soldiers sent across enemy lines to deliver a message that could save thousands. The film unfolds as a relentless, continuous march through trenches, orchards, and ruins, where time and terrain are adversaries as deadly as bullets. Courage is measured in footsteps and small mercies; friendship steadies shaking hands. In the race against dusk, duty becomes a candle carried through a storm and kept alive.', '1917.jpg', 2, '../uploads/videos/1917.mp4'),
-- (67, 'The Greatest Showman', 'English', 2017, 'The Greatest Showman turns the life of P.T. Barnum into a burst of song about reinvention, spectacle, and belonging. Outsiders find a stage; audiences find wonder; ambition finds both triumph and blind spots. Barnum must learn that true applause comes from family and integrity, not just headlines. With choreography that dazzles and an anthem for every misfit, the film celebrates audacity while nudging its dreamers toward grace.', 'greatest_showman.jpg', 6, '../uploads/videos/greatest_showman.mp4');

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `user`
-- --

-- CREATE TABLE `user` (
--   `UserID` int(11) NOT NULL,
--   `Username` varchar(100) NOT NULL,
--   `Email` varchar(100) NOT NULL,
--   `Password` varchar(255) NOT NULL,
--   `otp_code` varchar(6) DEFAULT NULL,
--   `otp_expires_at` datetime DEFAULT NULL,
--   `is_verified` tinyint(1) DEFAULT 0,
--   `last_login_date` date DEFAULT NULL,
--   `last_login_time` time DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Dumping data for table `user`
-- --

-- INSERT INTO `user` (`UserID`, `Username`, `Email`, `Password`, `otp_code`, `otp_expires_at`, `is_verified`, `last_login_date`, `last_login_time`) VALUES
-- (1, 'Hrick', 'hrickromit@gmail.com', '123', NULL, NULL, 0, '2025-08-17', '23:16:57'),
-- (3, 'zoshik', 'yoshikizbd15@gmail.com', '123', NULL, NULL, 0, NULL, NULL);

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `watch_history`
-- --

-- CREATE TABLE `watch_history` (
--   `UserID` int(11) NOT NULL,
--   `MovieID` int(11) NOT NULL,
--   `watched_at` datetime NOT NULL DEFAULT current_timestamp(),
--   `times_watched` int(11) NOT NULL DEFAULT 1,
--   `last_position_seconds` int(11) NOT NULL DEFAULT 0
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Dumping data for table `watch_history`
-- --

-- INSERT INTO `watch_history` (`UserID`, `MovieID`, `watched_at`, `times_watched`, `last_position_seconds`) VALUES
-- (1, 2, '2025-08-17 23:17:03', 2, 0),
-- (1, 3, '2025-08-16 00:53:43', 2, 0),
-- (1, 5, '2025-08-16 00:53:45', 2, 0),
-- (1, 41, '2025-08-16 18:45:33', 1, 0),
-- (1, 42, '2025-08-16 18:45:57', 1, 0),
-- (3, 2, '2025-08-16 00:55:26', 1, 0),
-- (3, 6, '2025-08-16 00:55:37', 1, 0);

-- --
-- -- Indexes for dumped tables
-- --

-- --
-- -- Indexes for table `admin`
-- --
-- ALTER TABLE `admin`
--   ADD PRIMARY KEY (`id`),
--   ADD UNIQUE KEY `admin_username` (`admin_username`);

-- --
-- -- Indexes for table `favourites`
-- --
-- ALTER TABLE `favourites`
--   ADD PRIMARY KEY (`id`),
--   ADD UNIQUE KEY `ux_user_movie` (`user_id`,`movie_id`);

-- --
-- -- Indexes for table `genre`
-- --
-- ALTER TABLE `genre`
--   ADD PRIMARY KEY (`GenreID`);

-- --
-- -- Indexes for table `movies`
-- --
-- ALTER TABLE `movies`
--   ADD PRIMARY KEY (`MovieID`),
--   ADD KEY `fk_genre` (`GenreID`);

-- --
-- -- Indexes for table `user`
-- --
-- ALTER TABLE `user`
--   ADD PRIMARY KEY (`UserID`);

-- --
-- -- Indexes for table `watch_history`
-- --
-- ALTER TABLE `watch_history`
--   ADD PRIMARY KEY (`UserID`,`MovieID`),
--   ADD KEY `idx_wh_user_time` (`UserID`,`watched_at`),
--   ADD KEY `fk_wh_movie` (`MovieID`);

-- --
-- -- AUTO_INCREMENT for dumped tables
-- --

-- --
-- -- AUTO_INCREMENT for table `admin`
-- --
-- ALTER TABLE `admin`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- --
-- -- AUTO_INCREMENT for table `favourites`
-- --
-- ALTER TABLE `favourites`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --
-- -- AUTO_INCREMENT for table `movies`
-- --
-- ALTER TABLE `movies`
--   MODIFY `MovieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

-- --
-- -- AUTO_INCREMENT for table `user`
-- --
-- ALTER TABLE `user`
--   MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- --
-- -- Constraints for dumped tables
-- --

-- --
-- -- Constraints for table `movies`
-- --
-- ALTER TABLE `movies`
--   ADD CONSTRAINT `fk_genre` FOREIGN KEY (`GenreID`) REFERENCES `genre` (`GenreID`);

-- --
-- -- Constraints for table `watch_history`
-- --
-- ALTER TABLE `watch_history`
--   ADD CONSTRAINT `fk_wh_movie` FOREIGN KEY (`MovieID`) REFERENCES `movies` (`MovieID`) ON DELETE CASCADE,
--   ADD CONSTRAINT `fk_wh_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;
-- COMMIT;

-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
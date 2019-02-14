-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Jeu 14 Février 2019 à 15:58
-- Version du serveur: 5.5.57-0ubuntu0.14.04.1
-- Version de PHP: 7.1.24-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `beautyfen`
--
CREATE DATABASE IF NOT EXISTS `beautyfen` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `beautyfen`;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `date_order` date NOT NULL,
  `total_amount` double NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F52993986B3CA4B` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Contenu de la table `order`
--

INSERT INTO `order` (`id`, `id_user`, `date_order`, `total_amount`, `status`) VALUES
(1, 1, '2018-12-11', 12, 'danger'),
(13, 1, '2018-12-05', 451.89, 'success'),
(14, 1, '2018-12-05', 55.99, 'success'),
(29, 3, '2018-12-07', 41, 'ongoing'),
(30, 2, '2018-12-07', 60, 'success'),
(31, 2, '2018-12-07', 77, 'ongoing'),
(33, 1, '2018-12-11', 117, 'success'),
(34, 1, '2018-12-11', 103, 'success'),
(35, 1, '2018-12-30', 60, 'success'),
(36, 1, '2018-12-30', 97, 'success'),
(37, 4, '2019-01-06', 116, 'ongoing');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `new_product` tinyint(1) NOT NULL DEFAULT '0',
  `sale` tinyint(1) NOT NULL DEFAULT '0',
  `sale_price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=48 ;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `type`, `name`, `brand`, `price`, `description`, `new_product`, `sale`, `sale_price`) VALUES
(1, 'Highlighter', 'Blossom', 'Lime Crime', 42, 'Palette illuminatrice par Lime Crime\nFini lumineux et scintillant\nTexture poudre\nLivr&eacute; avec trois nuances\nVise &agrave; illuminer et &agrave; redonner de l''&eacute;clat au visage\nAppliquer comme base de maquillage ou sur les pommettes, le haut de la l&egrave;vre sup&eacute;rieure et le front', 0, 1, 29),
(2, 'Highlighter', 'iluvsarahii', 'Dose of Colors', 28, 'A six-colour eyeshadow palette.\nDesigned by YouTube and Instagram influencer iluvsarahii to inspire creativity, Iluvsarahii Eyeshadow Palette contains six stunning shades in a variety of matte and metallic finishes. From neutral every day to ultimate glam, this versatile palette is ideal for crafting a multitude of looks that are suitable for all skin tones.', 0, 0, 0),
(3, 'Highlighter', 'Liquid Frost', 'Jeffree Star Cosmetics', 35, 'Our liquid highlighter is extremely pigmented, so get ready to glow like a lighthouse! (Beauty tip: This product can be used on the face, eyes & body!  A little goes a long way. This product can be used wet or dry, depending on your desired intensity.)', 1, 0, 0),
(4, 'Highlighter', 'Face Quad Ignite', 'Makeup revolution', 12, 'Light up your complexion and enhance your best features with this all in one palette. Sweep a little highlight over the top of your cheekbones for a healthy-looking glow. Add a touch of highlight to your cupid’s bow, brow bone, nose and collarbone to achieve an all over dewy glow. Why not go further and create three dimensional lips by adding a little highlight to the centre of your lips or accentuate your eyes by applying product on the lid and inner corners.', 0, 0, 0),
(5, 'Highlighter', 'SKIN FROST: Ice Cold', 'Jeffree Star Cosmetics', 25, 'An incredibly pigmented highlight ideal for creating an eye-catching luminous finish.\n\nCreated to stand out as much as the creator himself, the Jeffree Star Skin Frosts are perfect for producing a truly unique finish. The lightweight, super blendable powder glides effortlessly onto the face, body and eyes for a truly glowing look. Pressed into a large, pink, mirrored pan, the innovative formula is sure to become one of the Holy Grail products you can''t live without!', 0, 1, 19),
(6, 'Highlighter', 'Subtle Summer Glow', 'Makeup revolution', 9, 'If you are looking for a highlighter palette that does it all- look no further! From a natural glow from within, to a blinding highlight that can be seen from space, we got you covered. With 8 different shades (5 baked and 3 pressed), you can pick your favourites or mix and match colours to create the perfect glow for your skin tone. You know what they say... you can NEVER have enough highlighter! - Soph', 0, 0, 0),
(7, 'Highlighter', 'Revolution Pro Glow 2', 'Makeup revolution', 11, 'For our lovers of GLOW! Our newest Pro Glow palette contains 8 amazing highlighter shades that can be used for a glowing complexion. Soft and smooth formula that will leave you looking luminous every day. Apply to the areas you wish to bring dimension and light to (such as cheekbones, cupids bow, inner corners of eyes, brow bone, even your body for an all over glowing look!) \n8 shades in a mix of white, golds and peach that you can use alone or mix/layer that will suit all skin tones. For even higher intensity finish spritz your makeup brush with a couple of sprays of our Pro Fixing Spray.', 0, 0, 0),
(8, 'Highlighter', 'Dew Dreamer', 'Laura Geller', 34, 'A liquid highlighter to create a lit-from-within glow.\n\nInstantly transforming dull, lacklustre skin, Dewdreamer Illuminating Drops simultaneously blur imperfections and highlight the complexion. Available in a variety of shades to flatter all skin tones, these versatile drops can be used on the face or body to create a radiant, glowing finish.', 1, 0, 0),
(9, 'Highlighter', 'Gleam That Glow', 'Anastasia Beverlyhills', 36, 'Anastasia Beverly Hills’ all-in-one Sugar Glow Kit contains 4 shades of highlighting powder featuring pink tones and intense luminosity. With a lightweight, refined formula, each shade delivers buildable coverage with a metallic-lustre finish. ', 0, 0, 0),
(10, 'Highlighter', 'Dream Glow Kit', 'Anastasia Beverlyhills', 34, 'Intensely pigmented and effortlessly buildable, Dream Glow Kit is the perfect tool for enhancing and accentuating your favourite features. Suitable for all skin tones, these multi-dimensional shades can be worn alone or mixed together to create a dazzling, ultra-customised glow.', 0, 1, 29),
(11, 'Highlighter', 'Love You So Mochi', 'NYX', 9, 'Swap out your standard illuminator for the duo chromatic glow of your dreams! Our Love You So Mochi Highlighting Palette comes in two color-kissed palettes that reflect light for a glossy-glow look at all angles. Each lightweight shade delivers incredible color and features the same soft and pillowy texture as our favorite Japanese treat—mochi!', 0, 0, 0),
(12, 'Foundation', 'Pro Coverage Illuminating Foundation', 'L.A. Girl', 9, 'Le Pro Coverage HD est un fond de teint couvrant avec une tenue de longue dur&eacute;e, une finition impeccable. Sa texture l&eacute;g&eacute;re est confortable pour toute la journ&eacute;e. Aide &agrave; hydrater et &agrave; am&eacute;liorer l&rsquo;apparence de la peau. La formule est sans paraben. Pour obtenir votre couleur souhait&eacute; et L.A. GIRL vous propose un m&eacute;lange de fondation blanc innovateur pour ajuster et personnaliser la couleur.', 0, 0, 0),
(13, 'Foundation', 'Conceal + Perfect 2-In-1 ', 'Milani', 13, 'Combat sous les yeux, rougeurs et autres imperfections de la peau avec cette couverture compl&eacute;te, r&eacute;sistant &agrave; l&rsquo;eau, Fondation plus correcteur dans l&rsquo;un. Un aucun d&eacute;sordre, aucune pompe de goutte &agrave; goutte n&rsquo;assure juste la bonne quantit&eacute; de liquide n&eacute;cessaire pour obtenir un look impeccable et fonctionne vingt-quatre heures sur vingt-quatre pour garder la peau un aspect naturellement parfait ! ', 0, 0, 0),
(14, 'Foundation', 'PHOTO FOCUS FOUNDATION', 'Wet n Wild', 9, 'Le Fond de Teint Photo Focus Foundation WET N WILD vous offre un rendu tr&eacute;s naturel, mat et lumineux, &agrave; la couvrance modulable.\n\nTest&eacute; dans 7 conditions de lumi&eacute;re diff&eacute;rentes, le fond de teint garantit le meilleur rendu en photo avec ou sans flash, sans trace blanche.\nAide &agrave; &eacute;liminer la r&eacute;flexion sur les particules blances.\n\nCouvrance modulable.\nFini mat lumineux.\n', 1, 0, 0),
(15, 'Foundation', 'Essential High Coverage Creme Foundation', 'Jouer Cosmetics', 40, 'Supreme coverage, lightweight, and long wearing. Essential High Coverage Cr&eacute;me Foundation creates an impeccable, airbrushed matte finish instantly. Simply smooth a small amount of the concentrated formula onto the skin with Jouer’s Essential Precision Foundation Brush and buff to reveal your perfect complexion', 0, 0, 0),
(16, 'Foundation', 'SKIN BASE FOUNDATION ', 'ILLAMASQUA', 42, 'Ce fond de teint tr&eacute;s couvrant, longue tenue s&rsquo;applique facilement et cache parfaitement les imperfections, taches etc.\nCouvre en une seul application, Rich Liquid Foundation peut être utilis&eacute; sur le visage ou juste sur une zone (comme un anti-cerne ou pour r&eacute;aliser un tatoo). Il doit toujours être accompagn&eacute; d&rsquo;une poudre (press&eacute;e ou libre). \nIl convient &agrave; tout les types de peaux.', 0, 1, 25),
(17, 'Foundation', 'Filter First', 'Laura Geller', 38, 'Laura Geller New York Filter First Fond de Teint Lumineux pour un visage naturellement lumineux sous tous les angles. \n\nAliment&eacute; par la technologie illumismooth, chaque goutte pr&eacute;sente un m&eacute;lange unique de micro-perles pour cr&eacute;er un filtre respirant, &agrave; la teinte vraie, qui att&eacute;nue les imperfections et adoucit les contours. \n\nInfus&eacute; d&rsquo;huile de p&eacute;pins de raisin hydratante et d&rsquo;alo&eacute;s apaisant pour aider &agrave; maintenir une peau saine. Sans paraben. Sans huile min&eacute;rale. Sans gluten.', 0, 0, 0),
(18, 'Foundation', 'High performance lifting foundation', 'Artdeco', 23, 'Le fond de teint High Performance Lifting Foundation offre un teint naturel et radieux. Sa texture cr&eacute;meuse et l&eacute;g&eacute;re se confond &agrave; la peau, donnant un teint &eacute;clatant et lisse. Grâce &agrave; sa formule innovante avec polysilicone-11, la peau semble plus lisse et plus ferme, les ridules paraissent att&eacute;nu&eacute;es. De fines particules d&rsquo;or offrent un effet flouteur suppl&eacute;mentaire. L&rsquo;acide hyaluronique hydratant comble rides et ridules. Contient un filtre UV et de la vitamine E. Convient &agrave; tous types de peaux. Sans lanoline.', 0, 0, 0),
(19, 'Foundation', 'Aqua Glow Serum Foundation', 'Stila', 60, 'Ce fond de teint s&eacute;rum ultral&eacute;ger, &agrave; base d&rsquo;eau ionis&eacute;e, permet d&rsquo;instantan&eacute;ment voiler, hydrater et parfaire l&rsquo;aspect de la peau grace &agrave; sa couvrance allant de moyenne &agrave; totale. Une g&eacute;n&eacute;ration de pigments multi-reflets &agrave; r&eacute;fraction &eacute;lev&eacute;e se sert de la luminosit&eacute; pour optiquement lisser le teint et att&eacute;nuer l&rsquo;apparence des pores, ridules, rides et autres imperfections.\n\nAvantages:\n\nLe Syst&eacute;me d&rsquo;&eacute;quilibre &eacute;lectrolytique de Stila, un complexe savamment dos&eacute; d&rsquo;eau ionis&eacute;e, d&rsquo;acide hyaluronique de pointe et de min&eacute;raux essentiels, aide &agrave; hydrater et enrichir la peau, lui procurant un &eacute;clat sant&eacute;.\nLa texture, tout en l&eacute;g&eacute;ret&eacute;, se fond &agrave; la peau pour un fini parfait, si ind&eacute;tectable et naturel qu&rsquo;on ne saura pas que vous portez du maquillage!', 0, 0, 0),
(20, 'Foundation', 'micro silque foundation', 'elcie', 14, 'A lightweight yet build-able HD coverage liquid foundation that is made for every skin type, leaving the face to feel flawless, smooth and hydrated. This micro Silque foundation is long lasting, water-resistant and mild transfer-resistant, so you can enjoy a full days wear.', 0, 0, 0),
(21, 'Foundation', 'Custom cover drops', 'Cover FX', 50, 'Une formule r&eacute;volutionnaire de pigment pur en compte-gouttes &agrave; ajouter &agrave; vos produits de beaut&eacute; liquides favoris pour cr&eacute;er votre fond de teint ou hydratant teint&eacute; id&eacute;al.\n', 1, 0, 0),
(23, 'Lipstick', 'Wet Cherry Gloss', 'Lime Crime', 22, 'Et si vos l&eacute;vres pouvaient scintiller comme une cerise juteuse? Obtenez le reflet mouill&eacute; d&rsquo;une cerise juteuse avec Lime Crime Wet Cherry Gloss. \nLes pigments translucides laissent transparaitre la beaut&eacute; naturelle des l&eacute;vres en 2 finitions: \n- Juicy Sheer pour une explosion de couleurs translucide dans les teintes nudes, rouges, bordeaux et peches. \n- Sparkly Sheer pour illuminer vos l&eacute;vres de perles iris&eacute;es.', 0, 0, 0),
(24, 'Lipstick', 'DIAMOND CRUSHERS', 'Lime Crime', 25, 'Rouge à lèvres liquide longue tenue qui s''applique comme un gloss, effet scintillant tel un diamant.\r\n\r\nVoulez-vous scintiller comme une fée ? Obtenez l''effet de diamants concassés sur vos lèvres, les joues, et partout ailleurs.\r\n\r\nLe Diamond Crushers n''est pas un brillant, mais un produit révolutionnaire utilisant une technologie prismatique que vous pouvez porter sur les lèvres nues ou sur le rouge à lèvres. La formule brevetée à base d''eau est remplie de reflets iridescents réfléchissants qui dansent et scintillent avec vous pendant vos mouvements.\r\n\r\nTrès longue tenue, ne colle pas, et sent divinement bon !!!\r\n\r\nFacile d''application grâce à son embout mousse.\r\n', 0, 0, 0),
(25, 'Lipstick', 'MATTE VELVETINES', 'Lime Crime', 18, 'Rouge &agrave; l&egrave;vres liquide waterproof longue tenue qui s''applique comme un gloss, texture velout&eacute;e avec un fini compl&egrave;tement mat.\r\n\r\nInspir&eacute; par des p&eacute;tales de rose.\r\n\r\n\r\nFacile d''application gr&acirc;ce &agrave; son embout mousse.\r\n\r\n', 0, 1, 15),
(26, 'Lipstick', 'DEMI MATTE', 'Huda Beauty', 22, 'Huda adore promouvoir l''expression personnelle &agrave; travers le maquillage. C''est pourquoi elle a con&ccedil;u le Demi Matte, un rouge &agrave; l&egrave;vres confortable et audacieux se d&eacute;clinant dans un &eacute;ventail complet de couleurs ultra f&eacute;minines qui sauront refl&eacute;ter toutes les personnalit&eacute;s. \r\n\r\nHautement pigment&eacute;e, la texture cr&eacute;meuse glisse sur les l&egrave;vres pour y d&eacute;poser un voile de couleur intense d&egrave;s le premier passage. &Eacute;clatant de brillance, ce rouge &agrave; l&egrave;vres illumine votre bouche et met en valeur ses contours naturels.', 0, 0, 0),
(27, 'Lipstick', 'Matte lipstick', 'Anastasia Beverly Hills', 22, 'Une couleur hautement pigment&eacute;e pour vos l&egrave;vres, avec un fini lisse ultra-mat.\r\n\r\n- Formule hautement pigment&eacute;e\r\n- Fini mat tr&egrave;s confortable \r\n- 30 teintes', 0, 0, 0),
(28, 'Lipstick', 'Mini liquid matte set', 'Huda Beauty', 35, 'Alerte pour les fans des Liquid Mattes Huda Beauty! Vos rouges &agrave; l&egrave;vres pr&eacute;f&eacute;r&eacute;s sont d&eacute;sormais disponibles en version Mini! Chaque &eacute;dition rassemble 4 teintes sp&eacute;cifiquement choisies par Huda. Que vous soyez adeptes du Nude, des tons Bruns ou de beaux Rouges, il y en aura pour tous les go&ucirc;ts. Toujours aussi confortable sur les l&egrave;vres et facile &agrave; superposer, amusez-vous &agrave; combiner les teintes pour cr&eacute;er des ombr&eacute;s ou de nouvelles couleurs. La question ne sera pas combien de temps il tiendra sur vos l&egrave;vres, mais jusqu&rsquo;&agrave; quand vous r&eacute;sisterez avant d&rsquo;essayer une nouvelle couleur.', 1, 0, 0),
(29, 'Lipstick', 'Antimatter Lipstick', 'illamasqua', 24, 'Enhance your pout with the Illamasqua Antimatter Lipstick; a semi-matte lipstick that adds long-wearing, non-drying colour to your lips. Its smooth, creamy texture glides on effortlessly to soften and condition lips, whilst delivering high-pigmented, luscious colour in one effortless stroke. Housed in the brand''s signature black case.', 0, 0, 0),
(30, 'Lipstick', 'Liquid Lipstick', 'Anastasia Beverly Hills', 24, 'Cette formule liquide ultra-satur&eacute;e donne une dose intense de pigment mat d''un seul trait :\r\n- Pigment couvrance totale\r\n- Formule mate tr&egrave;s confortable\r\n- Applicateur arrondi pour dessiner les l&egrave;vres et appliquer la couleur\r\n', 1, 0, 0),
(31, 'Lipstick', 'Berries on ice', 'Jeffree Star Cosmetics', 19, 'Our liquid lipstick goes on opaque, dries completely matte and stays on for hours! This product is 100% vegan & cruelty-free! (tips before use: exfoliate with lip scrub then apply to bare lips! Avoid food with oil… and no making out, kisses are ok!)', 0, 0, 0),
(32, 'Lipstick', 'long lasting liquid lipstick', 'ofra', 12, 'A long-lasting liquid lipstick.\r\n\r\nWith a matte finish and incomparable pigmentation, Ofra Long Lasting Liquid Lipstick offers a budge-proof, on-trend finish that refuses to flake or fade. Utilising a doe-foot applicator, the creamy formula sweeps effortlessly across the lips for a seamless full-coverage finish.', 0, 0, 0),
(33, 'Lipstick', 'Classic Horror', 'lasplash', 16, 'Inspired by The Golden Age of Horror! We have brought you a collection like no other. 8 unique never before seen colors conjured up to fit every shade of you. Ultra-Matte finish you are sure to SCREAM of delight.\r\n\r\n#LasplashMonsters', 0, 0, 0),
(34, 'Lipstick', 'Lip Ammunition', 'Jeffree Star Cosmetics', 18, 'Jeffree Star is back with your favourite lipstick shades in a bold satin finish.\r\n\r\nDeveloped to deliver one swipe coverage, the ultra-pigmented Lip Ammunition lip sticks are an essential for anyone who wants to rock bold colour with a moisturising finish all day long. Simply applied directly from the pink encased bullet, the super simple, intensely creamy formula glides smoothly over lips for incomparable results and a stunning finish every time.', 0, 1, 13),
(35, 'Palette', 'Imogenation', 'Makeup Revolution', 13, 'Calling all the huns! We’ve teamed up with content creator @Imogenation_ to create two pretty palettes, so you can slay all day.\r\n\r\nImogenation The Eyeshadow Palette features 20 handpicked pigmented eyeshadow shades. Including 4 neutral and warm transitional shades, plus a mixture of matte and metallic bronze, orange, burgundy, pink and gold hues.\r\n\r\nImogen said: “I wanted to create palettes that had versatility and accessibility for everyone.\r\nI wanted to create a palette with a bigger centre… so that they’re your go-to, standard shades. Everything else is added extras.”', 0, 0, 0),
(36, 'Palette', 'Venus III', 'Lime Crime', 35, 'Inspir&eacute; par les licornes et totalement digne d''&ecirc;tre l''objet de votre obsession, Lime Crime est le saint Graal du maquillage qui vous fera briller de mille feux. Du rouge &agrave; l&egrave;vres liquide aux teintes m&eacute;tallis&eacute;es vives et aux tons mats fonc&eacute;s, Lime Crime couvre tous vos besoins en mettant l''accent sur une qualit&eacute; sans compromis et des produits non test&eacute;s sur les animaux. D&eacute;couvrez les produits de maquillage tendance et 100% v&eacute;g&eacute;tal de la marque. Les grandes soir&eacute;es d&eacute;butent devant le miroir de la salle de bain.', 0, 0, 0),
(37, 'Palette', 'Modern Renaissance', 'Anastasia Berverly Hills', 50, 'Une collection indispensable d''ombres &agrave; paupi&egrave;res de 14 nuances de tons neutres et baie.\r\n\r\nQue ce soit pour l''utilisatrice n&eacute;ophyte ou l''experte en maquillage, cette palette d''ombres &agrave; paupi&egrave;res offre des possibilit&eacute;s infinies en terme de cr&eacute;ativit&eacute;.\r\nParmi les 14 nuances, les nombreux tons neutres fonctionneront parfaitement pour un maquillage de jour.\r\nPour un regard plus saisissant, incorporez quelques touches de grenade.', 1, 0, 0),
(38, 'Palette', 'Obsessions', 'Huda Beauty', 30, 'Une gamme de palettes d''ombres &agrave; paupi&egrave;res compactes, aux harmonies sp&eacute;cifiquement cr&eacute;es par Huda, pour vous offrir la panoplie essentielle de teintes &agrave; vos maquillages de jour... comme de nuit !\r\n\r\nChaque palette est compos&eacute;e d''une s&eacute;lection de 9 ombres &agrave; paupi&egrave;res mates et nacr&eacute;es, cr&eacute;meuses au toucher et faciles &agrave; appliquer.\r\n\r\nDisponibles en 6 &eacute;ditions - Coral, Gemstone, Warm Brown, Mauve, Smokey et Electric Obsessions - et dot&eacute;es d''un large miroir tout en restant ultra compactes, elles trouveront vite leur place dans votre vanity ou votre sac &agrave; main.\r\n\r\n', 0, 0, 0),
(39, 'Palette', 'Methyst', 'Huda Beauty', 30, 'Une gamme de palettes d''ombres &agrave; paupi&egrave;res compactes, aux harmonies sp&eacute;cifiquement cr&eacute;es par Huda, pour vous offrir la panoplie essentielle de teintes &agrave; vos maquillages de jour... comme de nuit !\r\n\r\nChaque palette est compos&eacute;e d''une s&eacute;lection de 9 ombres &agrave; paupi&egrave;res mates et nacr&eacute;es, cr&eacute;meuses au toucher et faciles &agrave; appliquer.\r\n\r\nDisponibles en 6 &eacute;ditions - Coral, Gemstone, Warm Brown, Mauve, Smokey et Electric Obsessions - et dot&eacute;es d''un large miroir tout en restant ultra compactes, elles trouveront vite leur place dans votre vanity ou votre sac &agrave; main.\r\n\r\n', 0, 0, 0),
(40, 'Palette', 'Origin 42', 'Beauty Bay', 28, 'A forty-two-colour eyeshadow palette with six step-by-step looks and endless mix-and-match possibilities.\r\n\r\nOrigin is your not-so-basic basics palette, containing a selection of warm and neutral shades to create wearable, casual, and daytime eye looks. Here you’ll find a combination of 42 matte, metallic and colour-changing duochrome finishes – it’s the perfect starting point to plot the direction of your beauty journey. Featuring an ultra-buttery texture and next-level pigment payoff with minimal fallout, Origin is the first palette in the Colour Theory Collection.', 0, 1, 21),
(41, 'Palette', 'Sultry', 'Anastasia Beverly Hills', 49, 'Une palette de fards &agrave; paupi&egrave;res effet &laquo; smoky eye &raquo; indispensable, comprenant quatorze teintes allant des couleurs mates dor&eacute;es aux tons m&eacute;talliques cuivr&eacute;s.\r\n\r\nUne formule hautement pigment&eacute;e, facile &agrave; m&eacute;langer. Les teintes ultra-mates affichent une texture velout&eacute;e douce comme de la cr&egrave;me, elles s''estompent facilement et procurent une pigmentation parfaite pour un r&eacute;sultat optimal. \r\nLes teintes m&eacute;talliques poss&egrave;dent un &eacute;clat polyvalent, elles fondent sur la peau et brillent avec intensit&eacute; pour une tenue impeccable. \r\nComprend un vaste &eacute;ventail de nuances froides pour cr&eacute;er une infinit&eacute; de looks. Un emballage luxueux avec miroir et pinceau &agrave; double embout.', 0, 0, 0),
(42, 'Palette', 'Extra Spice', 'Makeup Revolution x Soph', 11, 'An 18-colour eyeshadow palette.\r\n\r\nProduced in collaboration with Soph Does Nails, the Revolution X Soph Extra Spice palette contains an array of vivacious colours. Featuring a mix of matte and shimmer shades, from olive green to burgundy and cerise pink, this versatile palette is perfect for achieving bold, eye-catching looks.', 0, 0, 0),
(43, 'Palette', 'Thirsty', 'Jeffree Star Cosmetics', 50, 'A fifteen-colour eyeshadow palette.\r\n\r\nPart of Jeffree Star’s Summer 2018 Collection, Thirsty Eyeshadow Palette contains a variety of vibrant matte and metallic shades. Super soft and highly-pigmented, this colourful palette can be used to craft a multitude of eye-catching looks.', 0, 0, 0),
(44, 'Palette', 'Revolution Pressed Glitter', 'Makeup Revolution', 11, 'A nine-colour glitter eyeshadow palette.\r\n\r\nVibrant and sparkly, Revolution Pressed Glitter Palette Midas Touch is contained in a glittery gold case. Featuring a variety of wearable pressed glitters in gold, bronze and oranges hues, this on-trend palette is perfect for evening wear.', 1, 0, 0),
(45, 'Palette', 'Eyeshadow palette', 'Makeup Revolution x Soph', 12, 'The perfect mix of 14 matte and 10 shimmer eye shadows to create everything from a natural daytime look all the way up to full glam. The 24 versatile shades give you everything you need to create your look no matter what time of year, whether you''re looking for light shimmers, warm browns, rich golds, rusty oranges, dark smokey shades or even a pop of colour - this palette is for you! - Soph x', 0, 1, 9),
(46, 'Palette', 'Modern Renaissance', 'Anastasia Beverly Hills', 48, 'Housed in a mirrored suede coated compact, the Modern Renaissance Eyeshadow Palette contains fourteen thoughtfully curated shades.\r\n\r\nModern Renaissance Palette provides incredible colour pay off thanks to its intensely pigmented creamy formula. With the selection ranging from cranberry and brown toned hues in a combination of both matte and shimmer finishes the shadows are buildable and blendable for a customised finished look.', 0, 0, 0),
(47, 'Palette', 'NUDEPOP ', 'Kevyn Aucoin', 37, 'A twelve-colour eyeshadow palette.\r\n\r\nContaining twelve stunning shades in a variety of matte, shimmer and metallic finishes, NUDEPOP Eyeshadow Palette is a makeup bag must-have. The blendable formula glides over the eyelids to seamlessly deliver a smooth, professional finish. This versatile palette is perfect for both everyday and evening glam looks.', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `product_order`
--

CREATE TABLE IF NOT EXISTS `product_order` (
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id_order`,`id_product`),
  KEY `IDX_5475E8C41BACD2A8` (`id_order`),
  KEY `IDX_5475E8C4DD7ADDD` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `product_order`
--

INSERT INTO `product_order` (`id_order`, `id_product`, `quantity`) VALUES
(1, 9, 2),
(13, 1, 1),
(13, 9, 1),
(13, 10, 1),
(13, 15, 2),
(13, 19, 3),
(13, 20, 2),
(13, 21, 1),
(14, 1, 1),
(14, 13, 1),
(29, 1, 1),
(29, 4, 1),
(30, 19, 1),
(31, 1, 1),
(31, 29, 2),
(33, 19, 1),
(33, 26, 1),
(33, 31, 1),
(33, 33, 1),
(34, 19, 1),
(34, 29, 1),
(34, 31, 1),
(35, 19, 1),
(36, 1, 1),
(36, 29, 1),
(36, 42, 4),
(37, 29, 1),
(37, 31, 4),
(37, 33, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birth` date NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `name`, `email`, `birth`, `password`) VALUES
(1, 'tiphainejh', 'Tiphaine', 'RICHARD', 'tiphainejh@hotmail.fr', '1997-03-17', 'c0662e58b7c25bd587cc969087c6aa3ee1d24075'),
(2, 'tiphaine2', 'tiphainejh', 'richard', 'tiphainejh@hotmail.fr', '1997-03-17', 'c0662e58b7c25bd587cc969087c6aa3ee1d24075'),
(3, 'BeautIssam', 'Issam', 'MERIKHI', 'issammerihi@outlook.fr', '1997-01-28', '6fbf53563a42382c7e7ccb5e1c7066904220eef3'),
(4, 'prof', 'profp', 'profn', 'prof@prof.com', '1994-01-28', 'cc38ae9c01a716cc00edcf6ecbbd2cd71b0d3258');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F52993986B3CA4B` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `product_order`
--
ALTER TABLE `product_order`
  ADD CONSTRAINT `FK_5475E8C41BACD2A8` FOREIGN KEY (`id_order`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `FK_5475E8C4DD7ADDD` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

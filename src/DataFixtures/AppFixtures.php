<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Hairdresser;
use App\Entity\Pictures;
use App\Entity\Speciality;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    const SPECIALITY = [
        'Coupe courte' => [30,"Vous avez les oreilles et la nuque dégagées. Elle n’exige pas plus de soins qu’une autre mais vous oblige cependant à passer par la case coiffeur toutes les 6 à 8 semaines. Car des cheveux courts qui repoussent, exigent une bonne coupe de base ! <br>
Vos coiffures dépendent seulement de vos envies.   Partons d’un principe : vos cheveux peuvent aller dans tous les sens. Il y a donc autant de sens que de coiffures possibles. Avec votre coupe courte, vous pouvez donner du mouvement avec une raie sur le côté ou au contraire, la structurer de façon symétrique avec une raie au milieu. <br>
De nombreux effets sont également à votre portée.  Vous pouvez jouer avec votre mèche, plaquer vos cheveux façon  wet look  ou les ébouriffer dans un style faussement négligé. Pour cela, les produits coiffants sont indispensables. Choisissez un gel pour la création et une laque pour la fixation. Vous pouvez également opter pour des produits adaptés à votre texture, qu’elle soit lisse, bouclée ou frisée.<br>
Notre conseil. Si vous comptez prochainement couper vos cheveux, gardez un minimum de longueur pour une coupe modulable que vous pourrez travailler. Un test facile peut alors vérifier si vos cheveux ne sont pas trop courts : attrapez-les entre les doigts (que vous plaquez sur votre crâne). Si des mèches dépassent entre vos doigts, vous avez suffisamment de longueur pour les coiffer comme vous l’entendez.

"],
        'Coupe carrée' => [30,"Ce basique indémodable, qui se porte à tout âge, arrive le plus souvent au niveau du menton, voire un peu plus long, mais toujours au-dessus des épaules. Elle est considérée comme une coupe courte. Elle existe dans de nombreuses versions différentes. Une coupe carrée peut-être pleine, dégradée, lisse, bouclée…<br>
Mauvaise nouvelle : la forme de notre visage peut être un frein à ce carré plongeant ou effilé qui nous font tant envie. Pourquoi ? Car certaines coupes au carré accentuent des traits particuliers comme la rondeur des joues ou une mâchoire imposante. <br>
Non pas que cela soit disgracieux, mais quelques-unes d'entre nous préféreront sans doute les adoucir. Coup d'oeil sur les coupes carrées à adopter selon notre morphologie."],
        'coloration' => [90,"La coloration est littéralement une teinture, c’est-à-dire que la couleur des cheveux est enrobée afin qu’on modifie leur pigmentation naturelle.<br>
On retrouve deux types de coloration :<br>
La coloration naturelle ou végétale : mélange d’eau chaude et de plantes ou algues ;<br>
La coloration chimique : réalisée avec ou sans ammoniaque selon le rendu souhaité.<br>
Ici, les cheveux perdent leur pigmentation naturelle en utilisant le processus d’oxydation.<br>
Plusieurs techniques de coiffure utilisent la décoloration comme le « flash » qui s’applique en frictionnant les cheveux entre les doigts pour gagner en éclat et lumière.<br>
De même, le glaçage accentue les volumes et le relief. Il est appliqué localement sur la longueur et vers la pointe des cheveux.
",'hair64a479e36ae87.jpg'],
        'balayage' => [90,"Mèches travaillées plus finement. Un balayage blond est souvent réalisé à la palette.<br>
Technique de coloration partielle, le balayage consiste à éclaircir ou foncer quelques mèches de vos cheveux. Sans réaliser un changement radical, cette technique vous permettra de donner un coup d'éclat à vos cheveux. Un balayage, c'est apporter un effet retour de vacances, pour plus de lumière dans votre chevelure.<br>
La différence entre le balayage et les mèches se situe au niveau du contraste plus marqué dans le cas des mèches. Elles ont pour but de donner de la lumière à vos cheveux, et sont ainsi bien visibles et plus prononcées qu'un balayage, qui reste discret et naturel.<br>
",'hair64a479e3613f8.jpg'],
        'permanente' => [120,"Technologie – Produit et action destiné à friser la chevelure de manière durable. Le résultat est obtenu par un procédé physique et chimique à l’aide de bigoudis de différents diamètres selon le degré de frisure recherché, 
        un agent réducteur soufré qui permet de rompre les ponts disulfures du cheveu, puis l’application finale d’un fixateur pour neutraliser la nouvelle forme frisée. La dernière étape consiste à dérouler les bigoudis et à rincer les cheveux.",'hair64a479698d5bf.jpg'],
        'lissage' => [50,"–Défrisage: ce n’est plus au goût du jour chez les coiffeurs même si on en trouve en vente partout, car cela a été remplacé par les lissages. Les défrisages lissent les cheveux très agressivement en les abîmant énormément. En général les personnes faisant des défrisages ont les cheveux cassants et très affinés. <br>
–Lissage brésilien: c’est un énorme soin avant tout. Il lisse les cheveux en les détendant de manière naturelle, en même temps de les soigner. Il dure de 3 à 6 mois selon plusieurs facteurs et peut se faire sur TOUS types de cheveux même décolorés, abîmés et sensibilisés. Pour tout savoir en détail sur ce fabuleux lissage je vous laisse découvrir cet article. <br>
–Lissage japonais: c’est un lissage permanent, donc ce qui est lissé le reste jusqu’à ce qu’on coupe les cheveux et uniquement les racines sont à refaire. Il lisse les cheveux de manière raide comme des baguettes. Ce lissage ne fonctionne pas sur cheveux afro et est complètement déconseillé sur cheveux décolorés, sensibilisés et abîmés sous peine de casse. <br>
–Lissage coréen ou français (…etc): c’est un lissage permanent comme le japonais mais plus doux car il peut être fait sur cheveux décolorés (sous conditions selon les cheveux) et sur cheveux afro. Le résultat ne sera pas raide comme des baguettes mais plutôt lisse « naturel ». On peut le combiner à un lissage brésilien afin d’optimiser le résultat lisse et brillant avec le soin qu’apporte le lissage brésilien."],
        'soins' => [30,"Fourchus, abîmés, cassants, ternes : les cheveux accumulent des toxines et s'épuisent au quotidien. C'est pourquoi il est important de les nourrir en kératine, molécule présente dans la fibre capillaire, afin de leur redonner vie.
Les salons de coiffure proposent de plus en plus de rituels de soins cheveux enrichis en kératine afin de détoxifier et de reconstruire les cheveux sensibilisés en profondeur.
Voici le top 5 des différents soins disponibles en salons.",'hair64a4797fca836.jpg']];
    const PICTURES = ['choiffeuse-gloria.jpg','barber-shop.jpg','choiffeuse-annette.jpg',
        'hair64a479cfbc3d9.jpg', 'hair64a479cfc53c4.jpg','hair64a479e36ae87.jpg','hair64a479e3613f8.jpg','hair64a4797fca836.jpg',
        'hair64a356579e1f4.jpg','hair64a479697969a.jpg'];
    const PICTURESBOOKS =['hair64a5c56c29d08.jpg','hair64a2cd2b81942.jpg','hair64a479698d5bf.jpg',
        'hair64a4797fca836.jpg','hair64a479698412e.jpg','hair64a479697969a.jpg','hair64a4797fc15a4.jpg',
        'hair64a4797fb8c71.jpg','hair64a4797fafad1.jpg','hair64a479cfc53c4.jpg','hair64a479a50e0ea.jpg',
        'hair64a355f211cc4.jpg', 'hair64a34f33b96f1.jpg', 'hair64a5c5436bd0d.jpg','hair64a2cd2b17071.jpg','hair64a2cd2b17071.jpg','hair64a479cfb306f.jpg'];
    const BOOKS = ['Coiffures de mariage enchantées'=>"Laissez-nous vous aider à réaliser le look de mariage de vos rêves. Nos coiffeurs experts sont spécialisés dans les coiffures de mariage élégantes et romantiques. Faites de votre jour spécial un moment inoubliable avec une coiffure qui vous fera briller.",
        "Styles pour hommes modernes"=>"Nous sommes fiers de fournir des services de coiffure de qualité supérieure pour hommes. Nos stylistes sont formés pour créer des coupes de cheveux modernes et classiques, des coupes de cheveux pour hommes, des coupes de cheveux pour enfants et des coupes de cheveux pour adolescents.",
        "Extensions capillaires sensationnelles"=>"Obtenez une chevelure luxuriante et volumineuse grâce à nos extensions capillaires de qualité supérieure. Que vous souhaitiez une longueur époustouflante ou un volume ajouté, nos experts en extensions vous offriront une transformation incroyable.",
        "Coiffures express pour les journées chargées"=>"Vous manquez de temps mais voulez toujours avoir fière allure ? Découvrez nos coiffures express qui vous permettent d'être prêt(e) en un clin d'œil. Des chignons élégants aux queues de cheval sophistiquées, nous vous offrons des styles rapides et impeccables.",
        "Coiffures pour enfants adorables"=>"Offrez à vos enfants des looks adorables et amusants avec nos coiffures spécialement conçues pour les petits. Des tresses colorées aux coupes mignonnes, nos coiffeurs savent comment rendre les enfants heureux tout en les faisant se sentir spéciaux.",
        "Conseils de soins capillaires personnalisés"=>"Prenez soin de vos cheveux avec nos conseils de soins capillaires personnalisés. Nos experts vous guideront pour choisir les meilleurs produits et les routines adaptées à votre type de cheveux, afin de maintenir leur santé, leur éclat et leur beauté naturelle."];
const HAIDRESSERS = ['Gloria Leblanc','Marc Drouet','Annette Dupont'];

    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager,): void
    {$index = 0;
        /*Books*/
        foreach(self::BOOKS as $key => $bookContent) {
            $book = new Book();
            $book->setTitleBook($key);
            $book->setContent($bookContent);
            $manager->persist($book);
            $this->addReference('book_' . $index, $book);
            $index++;
        }
        /*Pictures*/
        foreach (self::PICTURES as $image)
        {
            $picture = new Pictures();
            $picture ->setName($image);
            $manager->persist( $picture);
            $this->addReference('picture_' . ($image), $picture);
        }
        $manager->flush();
        $index = 0;
        foreach (self::PICTURESBOOKS as $image)
        {
            $picture = new Pictures();
            $picture ->setName($image);
            $manager->persist( $picture);


                $picture->setBook($this->getReference('book_' . ($index % 6)));

                $manager->persist($picture);
            $index++;
        }
        $manager->flush();

        /*User role user*/
        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setFullName($this->faker->name);
            $user->setPlainPassword('123456');

            $manager->persist($user);
        }


        $index = 0;
        $userIndex=3;
        /*user role hairdresser and haidresser*/
        foreach (self::HAIDRESSERS as $key => $hairdresserName) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setFullName($hairdresserName);
            $user->setRoles(['ROLE_HAIRDRESSER']);
            $user->setPlainPassword('123456');
            $manager->persist($user);
            $this->addReference('user_' .  $key, $user);

            $hairdresser = new Hairdresser();
            $hairdresser->setUser($this->getReference('user_' . $key));
            $hairdresser->setPicture($this->getReference('picture_' . self::PICTURES[$key]));

            $manager->persist($hairdresser);

            $manager->flush();

        }

        /*user role admin*/
        $user = new User();
        $user->setEmail($this->faker->email);
        $user->setFullName($this->faker->name);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPlainPassword('123456');
        $manager->persist($user);
        $this->addReference('user_' . $i, $user);
        $manager->flush();

        /*Speciality*/
        $index = 2;
        foreach (self::SPECIALITY as $key => $spec)
        {

                $speciality = new Speciality();
                $speciality->setNameSpeciality($key);
                $speciality->setDuration($spec[0]);
                $speciality->setContent($spec[1]);
           $speciality->setPicture($this->getReference('picture_' . self::PICTURES[$index]));
$speciality->setRate(rand(17, 100));
            $manager->persist($speciality);
            $this->addReference('speciality_' . $key, $speciality);
            $index++;
        }

        $manager->flush();
    }



}

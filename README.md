# VillagePeople
Generate individuals and genealogies / Générer des individus et des généalogies

Traduction française plus bas 

## English

This script was created as part of [MedShakeEHR](https://www.logiciel-cabinet-medical.fr), free software for medical office management. Its purpose is to create a population that is relatively consistent with a country’s reference population so that it can be imported into the demo software. Thus the script generates individuals and genealogical links stopping to living people (its purpose is not to create ancestry with deceased subjects). These individuals are given some basic parameters: address, email, phones, weight, size … and therefore also coherent links of kinship.

You will find a blog post (in French) about the settings that are taken into consideration here: https://www.medshake.net/blog/a406/medshake-s-village-people/
You will also find them by browsing yaml files in the data directory.

The main flaw of the script as is is the age distribution of children in siblings. For the rest, the illusion is sufficient with, for example, ranges of first names adapted to the years of birth.

Also note that the script does not generate a modern vision of the couple and the marriage: the couples are only heterosexuals. As part of the initial development of the script and the time allotted, the challenge was already quite complicated with this traditional vision. I would be happy to see the script evolve with these more modern notions, even though I probably would not have time to devote to it.

Use :
1) Clone the github directory
2) Set the desired population in definePop.yml
3) run php generate.php on the command line.
4) open the export.csv file to view the resulting population

Limitations:
The script iteratively saves each individual in the form of a file (serialized PHP object), its memory occupation is not important and it can generate a very substantial population (our max test is a population of 500 000 individuals).

## French 

Ce script a été réalisé dans le cadre de [MedShakeEHR](https://www.logiciel-cabinet-medical.fr) , logiciel libre de gestion de cabinet médical. Son but est de créer une population relativement conforme à la population de référence d’un pays afin qu’elle soit importée dans le logiciel de démo. Ainsi le script génère des individus et des liens généalogiques s’arrêtant aux personnes vivantes (son but n’est pas de créer une ascendance avec des sujets décédés). Ces individus se voient attribuer quelques paramètres basiques : adresse, email, téléphones, poids, taille … et donc aussi des liens cohérents de  parenté.  

Vous trouverez un billet de blog (en français) sur les paramètres qui sont pris en considération ici : https://www.medshake.net/blog/a406/medshake-s-village-people/  
Vous les retrouverez également en parcourant les fichiers yaml du répertoire data.

Le principal défaut du script en l’état est la répartition des âges des enfants dans une fratrie. Pour le reste, l’illusion est suffisante avec, par exemple, des gammes de prénoms adaptées aux années de naissance.

Notez également que le script ne génère pas une vision moderne du couple et du mariage : les couples ne sont qu’hétérosexuels. Dans le cadre du développement initial du script et du temps imparti, le challenge était déjà assez compliqué avec cette vision traditionnelle. Je serais heureux de voir le script évolué avec ces notions plus modernes, même si je n’aurais moi même probablement pas rapidement de temps à consacrer à cela.  

Utilisation : 
1) cloner le répertoire github
2) paramétrer la population voulue dans definePop.yml
3) exécuter php generate.php en ligne de commande. 
4) ouvrir le fichier export.csv pour visualiser la population obtenue 

Limitations :
Le script sauvant itérativement chaque individu sous forme d’un fichier (objet PHP sérialisé), son occupation mémoire n’est pas importante et il peut générer une population très conséquente (notre essai max est une population de 500 000 individus). 

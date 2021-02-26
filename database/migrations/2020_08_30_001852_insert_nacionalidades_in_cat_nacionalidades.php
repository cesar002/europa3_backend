<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertNacionalidadesInCatNacionalidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::unprepared("
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Afganistán','AFGANA','AFG');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Albania','ALBANESA','ALB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Alemania','ALEMANA','DEU');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Andorra','ANDORRANA','AND');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Angola','ANGOLEÑA','AGO');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('AntiguayBarbuda','ANTIGUANA','ATG');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('ArabiaSaudita','SAUDÍ','SAU');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Argelia','ARGELINA','DZA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Argentina','ARGENTINA','ARG');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Armenia','ARMENIA','ARM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Aruba','ARUBEÑA','ABW');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Australia','AUSTRALIANA','AUS');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Austria','AUSTRIACA','AUT');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Azerbaiyán','AZERBAIYANA','AZE');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Bahamas','BAHAMEÑA','BHS');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Bangladés','BANGLADESÍ','BGD');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Barbados','BARBADENSE','BRB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Baréin','BAREINÍ','BHR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Bélgica','BELGA','BEL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Belice','BELICEÑA','BLZ');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Benín','BENINÉSA','BEN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Bielorrusia','BIELORRUSA','BLR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Birmania','BIRMANA','MMR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Bolivia','BOLIVIANA','BOL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('BosniayHerzegovina','BOSNIA','BIH');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Botsuana','BOTSUANA','BWA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Brasil','BRASILEÑA','BRA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Brunéi','BRUNEANA','BRN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Bulgaria','BÚLGARA','BGR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('BurkinaFaso','BURKINÉS','BFA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Burundi','BURUNDÉSA','BDI');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Bután','BUTANÉSA','BTN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('CaboVerde','CABOVERDIANA','CPV');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Camboya','CAMBOYANA','KHM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Camerún','CAMERUNESA','CMR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Canadá','CANADIENSE','CAN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Catar','CATARÍ','QAT');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Chad','CHADIANA','TCD');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Chile','CHILENA','CHL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('China','CHINA','CHN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Chipre','CHIPRIOTA','CYP');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('CiudaddelVaticano','VATICANA','VAT');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Colombia','COLOMBIANA','COL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Comoras','COMORENSE','COM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('CoreadelNorte','NORCOREANA','PRK');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('CoreadelSur','SURCOREANA','KOR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('CostadeMarfil','MARFILEÑA','CIV');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('CostaRica','COSTARRICENSE','CRI');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Croacia','CROATA','HRV');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Cuba','CUBANA','CUB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Dinamarca','DANÉSA','DNK');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Dominica','DOMINIQUÉS','DMA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Ecuador','ECUATORIANA','ECU');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Egipto','EGIPCIA','EGY');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('ElSalvador','SALVADOREÑA','SLV');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('EmiratosÁrabesUnidos','EMIRATÍ','ARE');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Eritrea','ERITREA','ERI');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Eslovaquia','ESLOVACA','SVK');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Eslovenia','ESLOVENA','SVN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('España','ESPAÑOLA','ESP');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('EstadosUnidos','ESTADOUNIDENSE','USA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Estonia','ESTONIA','EST');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Etiopía','ETÍOPE','ETH');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Filipinas','FILIPINA','PHL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Finlandia','FINLANDÉSA','FIN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Fiyi','FIYIANA','FJI');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Francia','FRANCÉSA','FRA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Gabón','GABONÉSA','GAB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Gambia','GAMBIANA','GMB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Georgia','GEORGIANA','GEO');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Gibraltar','GIBRALTAREÑA','GIB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Ghana','GHANÉSA','GHA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Granada','GRANADINA','GRD');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Grecia','GRIEGA','GRC');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Groenlandia','GROENLANDÉSA','GRL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Guatemala','GUATEMALTECA','GTM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Guineaecuatorial','ECUATOGUINEANA','GNQ');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Guinea','GUINEANA','GIN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Guinea-Bisáu','GUINEANA','GNB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Guyana','GUYANESA','GUY');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Haití','HAITIANA','HTI');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Honduras','HONDUREÑA','HND');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Hungría','HÚNGARA','HUN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('India','HINDÚ','IND');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Indonesia','INDONESIA','IDN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Irak','IRAQUÍ','IRQ');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Irán','IRANÍ','IRN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Irlanda','IRLANDÉSA','IRL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Islandia','ISLANDÉSA','ISL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('IslasCook','COOKIANA','COK');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('IslasMarshall','MARSHALÉSA','MHL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('IslasSalomón','SALOMONENSE','SLB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Israel','ISRAELÍ','ISR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Italia','ITALIANA','ITA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Jamaica','JAMAIQUINA','JAM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Japón','JAPONÉSA','JPN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Jordania','JORDANA','JOR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Kazajistán','KAZAJA','KAZ');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Kenia','KENIATA','KEN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Kirguistán','KIRGUISA','KGZ');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Kiribati','KIRIBATIANA','KIR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Kuwait','KUWAITÍ','KWT');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Laos','LAOSIANA','LAO');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Lesoto','LESOTENSE','LSO');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Letonia','LETÓNA','LVA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Líbano','LIBANÉSA','LBN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Liberia','LIBERIANA','LBR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Libia','LIBIA','LBY');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Liechtenstein','LIECHTENSTEINIANA','LIE');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Lituania','LITUANA','LTU');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Luxemburgo','LUXEMBURGUÉSA','LUX');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Madagascar','MALGACHE','MDG');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Malasia','MALASIA','MYS');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Malaui','MALAUÍ','MWI');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Maldivas','MALDIVA','MDV');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Malí','MALIENSE','MLI');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Malta','MALTÉSA','MLT');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Marruecos','MARROQUÍ','MAR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Martinica','MARTINIQUÉS','MTQ');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Mauricio','MAURICIANA','MUS');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Mauritania','MAURITANA','MRT');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('México','MEXICANA','MEX');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Micronesia','MICRONESIA','FSM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Moldavia','MOLDAVA','MDA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Mónaco','MONEGASCA','MCO');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Mongolia','MONGOLA','MNG');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Montenegro','MONTENEGRINA','MNE');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Mozambique','MOZAMBIQUEÑA','MOZ');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Namibia','NAMIBIA','NAM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Nauru','NAURUANA','NRU');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Nepal','NEPALÍ','NPL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Nicaragua','NICARAGÜENSE','NIC');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Níger','NIGERINA','NER');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Nigeria','NIGERIANA','NGA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Noruega','NORUEGA','NOR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('NuevaZelanda','NEOZELANDÉSA','NZL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Omán','OMANÍ','OMN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('PaísesBajos','NEERLANDÉSA','NLD');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Pakistán','PAKISTANÍ','PAK');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Palaos','PALAUANA','PLW');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Palestina','PALESTINA','PSE');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Panamá','PANAMEÑA','PAN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('PapúaNuevaGuinea','PAPÚ','PNG');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Paraguay','PARAGUAYA','PRY');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Perú','PERUANA','PER');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Polonia','POLACA','POL');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Portugal','PORTUGUÉSA','PRT');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('PuertoRico','PUERTORRIQUEÑA','PRI');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('ReinoUnido','BRITÁNICA','GBR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('RepúblicaCentroafricana','CENTROAFRICANA','CAF');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('RepúblicaCheca','CHECA','CZE');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('RepúblicadeMacedonia','MACEDONIA','MKD');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('RepúblicadelCongo','CONGOLEÑA','COG');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('RepúblicaDemocráticadelCongo','CONGOLEÑA','COD');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('RepúblicaDominicana','DOMINICANA','DOM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('RepúblicaSudafricana','SUDAFRICANA','ZAF');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Ruanda','RUANDÉSA','RWA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Rumanía','RUMANA','ROU');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Rusia','RUSA','RUS');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Samoa','SAMOANA','WSM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('SanCristóbalyNieves','CRISTOBALEÑA','KNA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('SanMarino','SANMARINENSE','SMR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('SanVicenteylasGranadinas','SANVICENTINA','VCT');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('SantaLucía','SANTALUCENSE','LCA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('SantoToméyPríncipe','SANTOTOMENSE','STP');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Senegal','SENEGALÉSA','SEN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Serbia','SERBIA','SRB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Seychelles','SEYCHELLENSE','SYC');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('SierraLeona','SIERRALEONÉSA','SLE');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Singapur','SINGAPURENSE','SGP');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Siria','SIRIA','SYR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Somalia','SOMALÍ','SOM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('SriLanka','CEILANÉSA','LKA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Suazilandia','SUAZI','SWZ');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('SudándelSur','SURSUDANÉSA','SSD');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Sudán','SUDANÉSA','SDN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Suecia','SUECA','SWE');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Suiza','SUIZA','CHE');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Surinam','SURINAMESA','SUR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Tailandia','TAILANDÉSA','THA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Tanzania','TANZANA','TZA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Tayikistán','TAYIKA','TJK');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('TimorOriental','TIMORENSE','TLS');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Togo','TOGOLÉSA','TGO');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Tonga','TONGANA','TON');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('TrinidadyTobago','TRINITENSE','TTO');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Túnez','TUNECINA','TUN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Turkmenistán','TURCOMANA','TKM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Turquía','TURCA','TUR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Tuvalu','TUVALUANA','TUV');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Ucrania','UCRANIANA','UKR');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Uganda','UGANDÉSA','UGA');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Uruguay','URUGUAYA','URY');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Uzbekistán','UZBEKA','UZB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Vanuatu','VANUATUENSE','VUT');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Venezuela','VENEZOLANA','VEN');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Vietnam','VIETNAMITA','VNM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Yemen','YEMENÍ','YEM');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Yibuti','YIBUTIANA','DJI');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Zambia','ZAMBIANA','ZMB');
			INSERT INTO`cat_nacionalidades`(`pais`,`gentilicio`,`iso`)VALUES('Zimbabue','ZIMBABUENSE','ZWE');
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}

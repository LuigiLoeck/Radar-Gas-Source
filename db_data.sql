-- dados usuarios

insert into usuario (nm_pessoa, email, cpf, senha, status) values ('LuigiAdm', 'luigisloeck@gmail.com', 02702706245, '$2y$10$QaIo1BbAd3KQYTdaMdvB2.Adlg.//MTfBi4/ug4TylAuJO7m30O7G', 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('LuigiUser', 'luigiloeck.pl008@academico.ifsul.edu.br', 44573465434, '$2y$10$1IkSJ.kGJIYxjaVE81s6uOaegdqgA4Q2h.RTnsyKaKjxCZj1gryE2', 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Dulcia Roselli', 'droselli0@oracle.com', 29655773200, 455634, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Giana Larimer', 'glarimer1@prweb.com', 48287621022, 597592, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Malinda Menelaws', 'mmenelaws2@goo.gl', 20810487609, 588020, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Carie McCurtain', 'cmccurtain3@ycombinator.com', 47468356554, 740196, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Debee Veryan', 'dveryan4@yolasite.com', 84532958346, 747106, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Obed Byre', 'obyre5@github.com', 50875635698, 787898, 0);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Lammond Blaksland', 'lblaksland6@jigsy.com', 76768779593, 354139, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Emera Nyland', 'enyland7@techcrunch.com', 47713539892, 652916, 0);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Remus Portch', 'rportch8@uol.com.br', 96946099620, 806092, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Gavrielle Klimmek', 'gklimmek9@geocities.com', 78797016188, 818705, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Gleda Ayars', 'gayarsa@phpbb.com', 16535358217, 696589, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Maxi Soggee', 'msoggeeb@amazonaws.com', 37491265128, 250140, 0);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Heriberto Davidi', 'hdavidic@google.ru', 63086736739, 901660, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Janessa Langridge', 'jlangridged@soundcloud.com', 26047511481, 114315, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Nadine Gallacher', 'ngallachere@wikispaces.com', 21976421484, 574652, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Ermina O''Cullinane', 'eocullinanef@slideshare.net', 54349221082, 173265, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Rudolf Herion', 'rheriong@storify.com', 35842395416, 313366, 0);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Fairleigh Hatherall', 'fhatherallh@pinterest.com', 23363638917, 574596, 0);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Hally Dailey', 'hdaileyi@wsj.com', 95230650248, 702990, 1);
insert into usuario (nm_pessoa, email, cpf, senha, status) values ('Kristo Migheli', 'kmighelij@chicagotribune.com', 17918561983, 677367, 1);

-- dados bandeiras

insert into bandeiras (nm_band, img_band) values ('Petrobras', 'petrobras.png');
insert into bandeiras (nm_band, img_band) values ('Coqueiro', 'coqueiro.png');
insert into bandeiras (nm_band, img_band) values ('Ipiranga', 'ipiranga.png');
insert into bandeiras (nm_band, img_band) values ('RodOil', 'rodoil.png');
insert into bandeiras (nm_band, img_band) values ('Azeredo', 'azeredo.png');
insert into bandeiras (nm_band, img_band) values ('Shell', 'shell.png');
insert into bandeiras (nm_band, img_band) values ('SIM', 'sim.png');


-- dados postos

insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Lifetime Brands, Inc.', 62818124369338, '319 Stephen Center', 3.3, 5);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('W.R. Grace & Co.', 28688507703697, '5 Vernon Plaza', 2.3, 5);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Innoviva, Inc.', 44731159137375, '9 Novick Parkway', 4.2, 4);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Dana Incorporated', 18757110357115, '65 Hoepker Lane', 3.0, 3);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Veritiv Corporation', 18072815477703, '807 Meadow Valley Circle', 3.2, 6);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('ProShares Ultra Nasdaq Biotechnology', 41424747594084, '971 Boyd Park', 1.2, 5);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Watts Water Technologies, Inc.', 94134569231577, '55032 Corben Parkway', 3.7, 1);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('EQT GP Holdings, LP', 29456596241079, '8445 Pankratz Drive', 0.3, 4);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Unit Corporation', 69987384052595, '425 Little Fleur Terrace', 3.1, 5);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Becton, Dickinson and Company', 78833532196133, '4 Butternut Drive', 2.5, 6);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Putnam Municipal Opportunities Trust', 27446781295246, '40 Grasskamp Parkway', 0.9, 6);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('American Electric Technologies, Inc.', 74375167858570, '397 Everett Parkway', 4.8, 7);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('General Mills, Inc.', 69834845963760, '4 Ronald Regan Avenue', 2.3, 7);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Wellesley Bancorp, Inc.', 18942857498037, '80650 Macpherson Avenue', 2.7, 1);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Cellect Biotechnology Ltd.', 41022329398619, '572 Vahlen Trail', 0.7, 2);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Gladstone Investment Corporation', 35651019616381, '0 Prentice Drive', 1.3, 5);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Landcadia Holdings, Inc.', 71894674896006, '641 Harbort Plaza', 2.9, 2);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Cheetah Mobile Inc.', 94420981271413, '308 Swallow Pass', 3.7, 3);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Saban Capital Acquisition Corp.', 10634032686979, '861 Burrows Court', 3.0, 6);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Maiden Holdings, Ltd.', 91689786293796, '348 Lukken Avenue', 0.4, 3);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('MFS Government Markets Income Trust', 60695665580837, '95 Talisman Alley', 0.1, 6);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('First Trust Dorsey Wright International Focus 5 ETF', 70875662411267, '90 Hallows Parkway', 3.3, 7);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('XG Technology, Inc', 15395099467678, '7 Reindahl Parkway', 1.7, 2);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('Itau Unibanco Banco Holding SA', 81664316329229, '530 Karstens Lane', 3.6, 2);
insert into postos (nm_posto, cnpj, endereco, nota, cod_band) values ('U.S. Bancorp', 55507061344900, '8 Hovde Crossing', 4.2, 4);

-- dados combustiveis

insert into combustiveis (nm_comb) values ('Gasolina');
insert into combustiveis (nm_comb) values ('Gasolina aditivada');
insert into combustiveis (nm_comb) values ('Gasolina premium');
insert into combustiveis (nm_comb) values ('Etanol');
insert into combustiveis (nm_comb) values ('Etanol aditivado');
insert into combustiveis (nm_comb) values ('Diesel');
insert into combustiveis (nm_comb) values ('Diesel aditivado');
insert into combustiveis (nm_comb) values ('GNV');

-- dados favoritos

insert into favoritos (cod_pessoa,cod_posto) values (2,1);
insert into favoritos (cod_pessoa,cod_posto) values (2,4);
insert into favoritos (cod_pessoa,cod_posto) values (2,7);
insert into favoritos (cod_pessoa,cod_posto) values (5,1);
insert into favoritos (cod_pessoa,cod_posto) values (5,13);
insert into favoritos (cod_pessoa,cod_posto) values (7,1);
insert into favoritos (cod_pessoa,cod_posto) values (7,5);
insert into favoritos (cod_pessoa,cod_posto) values (7,6);
insert into favoritos (cod_pessoa,cod_posto) values (7,10);
insert into favoritos (cod_pessoa,cod_posto) values (9,7);

-- dados venda

insert into vende (cod_posto,cod_comb,valor) values (1,1,5.463);
insert into vende (cod_posto,cod_comb,valor) values (1,2,4.235);
insert into vende (cod_posto,cod_comb,valor) values (1,4,4.645);
insert into vende (cod_posto,cod_comb,valor) values (1,5,5.745);
insert into vende (cod_posto,cod_comb,valor) values (1,6,4.377);
insert into vende (cod_posto,cod_comb,valor) values (2,1,5.756);
insert into vende (cod_posto,cod_comb,valor) values (2,2,4.376);
insert into vende (cod_posto,cod_comb,valor) values (2,4,4.734);
insert into vende (cod_posto,cod_comb,valor) values (2,5,5.234);
insert into vende (cod_posto,cod_comb,valor) values (2,6,4.863);
insert into vende (cod_posto,cod_comb,valor) values (3,1,5.236);
insert into vende (cod_posto,cod_comb,valor) values (3,2,4.864);
insert into vende (cod_posto,cod_comb,valor) values (3,4,5.845);
insert into vende (cod_posto,cod_comb,valor) values (3,5,4.475);
insert into vende (cod_posto,cod_comb,valor) values (3,6,4.863);
insert into vende (cod_posto,cod_comb,valor) values (4,1,5.332);
insert into vende (cod_posto,cod_comb,valor) values (4,2,5.163);
insert into vende (cod_posto,cod_comb,valor) values (4,4,5.683);
insert into vende (cod_posto,cod_comb,valor) values (4,5,4.875);
insert into vende (cod_posto,cod_comb,valor) values (4,6,5.342);
insert into vende (cod_posto,cod_comb,valor) values (5,1,5.456);
insert into vende (cod_posto,cod_comb,valor) values (5,2,4.934);
insert into vende (cod_posto,cod_comb,valor) values (5,4,5.235);
insert into vende (cod_posto,cod_comb,valor) values (5,5,5.128);
insert into vende (cod_posto,cod_comb,valor) values (5,6,4.944);

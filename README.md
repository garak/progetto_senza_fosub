Progetto senza FOSUserBundle
============================

Questo progetto mostra in modo molto semplice come si possa fare a meno di FOSUserBundle.

Nasce dal feedback ricevuto in seguito alla mia presentazione al SymfonyDay 2017, in cui sembra
che molti partecipanti, pur cogliendo l'essenza del discorso, abbiano sofferto la mancanza di
esempi pratici

[![video](https://i.vimeocdn.com/video/670922426_295x166.jpg)](https://vimeo.com/246059701)
<a href="https://www.slideshare.net/garak/disinstallare-fos-user-bundle-e-vivere-felici"><img src="https://image.slidesharecdn.com/versionesocialdisinstallarefosuserbundleeviverefelici-171022101158/95/disinstallare-fos-user-bundle-e-vivere-felici-1-638.jpg" width="295"></a>

Installazione
-------------

Nota: se si preferisce usare Docker, vedere il relativo paragrafo più avanti.

* clonare questo repository
* copiare il file nascosto `.env.dist` su `.env`
* eseguire `composer install`
* eseguire `bin/console doctrine:database:create`
* eseguire `bin/console doctrine:schema:update --force`
* eseguire `bin/console doctrine:fixtures:load -n`
* sistemare i permessi di `var/cache` e `var/log`
  ([vedi documentazione](http://symfony.com/doc/3.4/setup/file_permissions.html))

Test
----

* eseguire `bin/console doctrine:database:create -e=test`
* eseguire `bin/console doctrine:schema:update --force -e=test`
* eseguire `bin/console doctrine:fixtures:load -n -e=test`
* far girare i test con `bin/phpunit`


Docker
------

Se non si dispone del software necessario sulla macchina locale (per esempio non si ha
php 7.1), si può usare la configurazione fornita per Docker.

* eseguire `docker-compose build`
* eseguire `docker-compose up`
* per entrare nella macchina, eseguire `docker-compose exec php bash`

Per navigare l'applicazione, Occorre mappare il nome `progetto.local` su 127.0.0.1 nel proprio file hosts.
L'applicazione sarà quindi visibile all'indirizzo `http://progetto.local:8080`.

È disponibile un container per eseguire i test, con nome `phpunit`
In questo container si possono eseguire le istruzioni relative al paragrafo precedente.
Per esempio: `docker-compose exec phpunit console doctrine:database:create`.

Struttura del progetto
----------------------

Il progetto è poco più di un'installazione base di Symfony 3.4 (con la nuova struttura di
cartelle di Symfony 3.4/4.0).

Le classi dominio si trovano sotto `src/Dominio`, mentre tutto il resto riguardante
l'implementazione del progetto è nelle restanti sottocartelle di `src`.

I template si trovano sotto `templates`.

La configurazione del mapping di Doctrine si trova sotto `config/doctrine`.

La validazione si trova nel file `config/validation.xml`.

Feature implementate
--------------------

Al momento il progetto implementa solo queste feature:

* registrazione
* login

Restano da implementare:

* gestione del profilo
* cambio password
* recupero password

Ma spero comunque che il concetto espresso nella presentazione sia chiaro ugualmente.

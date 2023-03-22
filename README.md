## NBPApiSymfony
### Opis
Aplikacja dająca możliwość pobierania z Api Narodowego Banku Polskiego (http://api.nbp.pl/) danych o aktualnych kursach walut.
Dane są zapisywane do bazy danych opartej o MySql. 
### Uruchomienie aplikacji
Aby uruchomić aplikację, po jej pobraniu, należy wykonać polecenia:
``` composer install ```<br/>
``` symfony serve ```
### Działanie
Aby zaimportować dane o walutach należu skorzystać z commanda:
```
php bin/console app:import-currency-exchange-rates
```
Dane o walutach będą widoczne na stronie głównej po uruchomieniu aplikacji/

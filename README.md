

<br />
<div align="center">

  <h3 align="center">Adresy z Placematik</h3>

  <p align="center">
    Projekt rekrutacyjny dla ONX IT
    <br />
    <a href="https://www.letscode.it"><strong>Odwiedź moją stronę</strong></a>
    
  </p>
</div>

<br><br>


<!-- ABOUT THE PROJECT -->
## Krótko o projekcie

<a href="https://onx-it.letscode.it/task"><strong>Zobacz opis zlecenia</strong></a>

Aplikacja pozwalająca zarejestrowanym użytkownikom dodawać do swojej listy adresy, które wyszukujemy uzywając API Placematik.
Adresy mozemy usuwac lub ustawiać im przyjazne nazwy.
Dostęp do nich wygląda następująco: każdy uzytkownik widzi swoje adresy. Jeśli posiada rangę administratora  ( a dokładniej role dostępowe do wszystich adresów) ma dostęp do adresów wszystkich uytkowników.
`Sposób przypisania rangi administratora opisałem niezej.`


Do aplikacji mozemy sie zalogowac, zarejestorwac. W celu rejestracji stworzona jest weryfikacja czy podany email nie jest zajęty i czy hasło spełnia odpowiednie warunku.
Do rejestracji zastosowałem technologię `step by step` z uzyciem Pinia.js

Cały wygląd aplikacji opiera się `wyłącznie o PrimeVue`. Nie skupiałem się zupełnie nad estetyką testowej aplikacji.


## Instalacja
Instalacja jest typowa dla aplikacji Laravel

1. Na początek sklonujmy repozytorium
    ```sh
    git clone https://github.com/karlos1998/onx-rekrutacja.git
2. Wejdź do utworzonego katalogu
    ```sh
    cd onx-rekrutacja
3. Następnie zawartość Composer
    ```sh
    composer install
4. Stwórz plik .env uzywajac przykladowego pliku .env.example
    ```sh
    cp .env.example .env
5. Otwórz plik .env ulubionym edytorem tekstu i uzupełnij wymaganą konfigurację
    ```
    DB_DATABASE - moe zostać domyślnie, baza o podanej nazwie zostanie i tak stworzona
    
    DB_USERNAME - podaj tam proszę login swojego uzytkownika MySQL z uprawnieniami do tworzenia nowych baz danych
    
    DB_PASSWORD - Haslo uzytkownika bazy danych

    DEFAULT_USER_ADMIN_PASSWORD - UWAGA. Te pole mozesz zostawic puste, ale nie jest to zalecane! Jesli zostawisz puste, domyslny administrator aplikacji o emailu `kontakt@letscode.it` otrzyma haslo `testtest`, natomiast zalecane jest bys dla bezpieczenstwa ustawil wlasne haslo :)


    MAIL_USERNAME - adres email konta gmail, z którego będziemy wysyłac maile do administratorow, podczas dodawania adresow.
    
    MAIL_PASSWORD - uwaga! w przypadku email nie jest to haslo lecz wygenerowany klucz dla aplikacji. W celu stworzenia tekiego klucza musimy zalogować się na nasze konto gmail i w zaawansowanej konfiguracji stworzyć go dla naszej aplikacji.
    Alternatywnie mozemy uzyc innej skrzynki pocztowej :)

    MAIL_FROM_ADDRESS  - adres email konta google

    SESSION_DOMAIN - domena przez którą dostaniemy się do aplikacji. Wymagana jest dla stworzenia odpowiednich plikow cookie.

6. Upewnij się, ze uzytkownik www-data ma uprawnienia do odczytu i zapisu w folderze /storage

7. Zainstaluj pakiety node
    ```sh
    npm install
8. Zbuduj front-end aplikacji
    ```sh
    npm run build
9. Czas na stworzenie bazy danych
    ```sh
    php artisan migrate
10. Dodaj przykladowego administratora `kontakt@letscode.it` z przykladowymi adresami
    ```sh
    php artisan migrate:fresh --seed
11. Wykonaj test działania aplikacji
    ```sh
    php artisan test
12. Dodaj do crontab wpis, który będzie cyklicznie wykonywał eventy w laravel. W naszym przypadku, co 5 min usuwał zduplikowane adresy tych samych uzytkownikow
    ```sh
    * * * * * cd /sciezka/do/projektu && php artisan schedule:run >> /dev/null 2>&1
## Komendy dodatkowe

* Dodanie uprawnienia administratora dowolnemu uzytkownikowi
    ```sh
    php artisan permission:update EMAIL_UZYTKOWNIKA


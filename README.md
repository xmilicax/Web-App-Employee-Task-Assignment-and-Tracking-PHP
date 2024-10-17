# Web Application for Employee Task Assignment and Tracking

## About Application

###### [ENG]

The app is done as a university project. The goal was to make an application for employee task assignment and tracking with PHP. The app is fully written in Serbian language.

**Technologies used**: PHP, MySQL, AJAX, HTML, CSS.

There are four types of roles - Guest, Executor, Manager and Administrator.

**Guest** has the ability to:
- visit homepage
- register (with e-mail confirmation)
- login
- reset password

**Executor** has the ability to:
- view the list of their assigned tasks
- mark tasks as complete
- leave a comment and delete a comment created by them
- filter and sort tasks by date, executors and managers

**Manager** has the ability to:
- create, edit and delete tasks
- create, edit and delete task group (to which he has access)
- mark tasks as complete or cancelled
- leave a comment and delete a comment created by them or any user with an executor role in tasks from their task group
- filter and sort tasks by date, priority, executors and name

**Administrator** has the ability to:
- list, create, edit and delete users
- list, create, edit and delete types of users
- list, create, edit and delete tasks
- list, create, edit and delete task group
- list all, create, edit and delete any comment
- mark tasks as complete or cancelled

To quickly login, please see the credentials in the file **pass.txt**. 

###### [SRB]

Aplikacija je kreirana kao projekat za predmet na osnovnim studijama. Glavni cilj bio je da se kreira aplikacija za postavljanje i realizaciju radnih zadataka zaposlenih pomoću PHP-a. Aplikacija je napisana na srpskom jeziku.

**Upotrebljene tehnologije**: PHP, MySQL, AJAX, HTML, CSS.

Postoje četiri tipa korisnika: Gost, Izvršilac, Rukovodilac odeljenja i Administrator.

**Gost** ima mogućnost da:
- poseti početnu stranicu
- registruje se (uz potvrdu putem e-mail-a)
- prijavi se
- promeni lozinku

**Izvršilac** ima mogućnost da:
- pogleda listu dodeljenih zadataka
- označi zadatak kao završen
- ostavi komentar ili obriše svoj komentar
- filtrira i sortira po datumu, izvršiocima i rukovodiocima odeljenja

**Rukovodilac odeljenja** ima mogućnost da:
- pravi, izmenjuje i briše zadatke (kojima ima pristup)
- pravi, izmenjuje i briše grupe zadataka (kojima ima pristup)
- označi zadatak kao završen ili otkazan
- ostavi komentar ili izvbriše komentar koji je kreirao on ili izvršilac, unutar zadatka kojem rukvodilac ima pristup
- filtrira i sortira po datumu, prioritetu, izvršiocima i imenu

**Administrator** ima mogućnost da upravlja celom aplikacijom, odnosno da:
- izlistava, pravi, izmenjuje i briše korisnike
- izlistava, pravi, izmenjuje i briše tipove korisnika
- izlistava, pravi, izmenjuje i briše zadatke
- izlistava, pravi, izmenjuje i briše grupe zadataka 
- izlistava, pravi, izmenjuje i komentare
- označi zadatak kao završen ili otkazan

Za brzu prijavu, molimo unesite podatke iz fajla **pass.txt**.

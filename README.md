# ProjetSymfony-DebatNational
ProjetSymfony-DebatNational

##Versions :
- PHP : 7.2.14
- Symfony : 4.2
- Composer : 1.8.0
- MySQL : 5.7.24
- phpMyAdmin : 4.8.4

##Symfony sous Apache
```composer
composer require apache-pack
```

##Création des classes via :
```symfony
php bin\console make:controller
```

##Debug des routes via :
```symfony
php bin\console debug:router
```

##Création d'Entity (relation BDD) :
```symfony
php bin\console make:entity
```

##Regénérer les Getters/Setters des Entity
```symfony
php bin\console make:entity --regenerate
```

##Création de la BDD tel que configuré dans le .env :
```symfony
php bin\console doctrine:database:create
```

##Créer les tables dans la BDD (pas en prod !) :
```symfony
php bin\console doctrine:schema:update --force
```

##Dumper la BDD en cas de doute :
```symfony
php bin\console doctrine:schema:update --dump-sql
```

##Vider le cache (param env)
```symfony
php bin\console cache:clear
php bin\console cache:clear --end=dev
```

##Regénérer le cache en prod
```symfony
php bin\console cache:warmup
```

##Créer un formulaire
```symfony
php bin\console make:form
```

##Créer sa propre commande Symfony
```symfony
php bin\console make:command
```

##Et du coup l'utiliser pour les fixtures
```symfony
php bin\console app:fixtures
```
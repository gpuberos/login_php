# Authentification

Création d'un login, register et logout.

## Hashage

```php
// Hashage du mot de passe en utilisant l'algorithme ARGON2ID
// Un "sel" unique est automatiquement généré et inclus dans le hachage du mot de passe
$password = password_hash($_POST["user_password"], PASSWORD_ARGON2ID);
```

`PASSWORD_ARGON2ID` est un algorithme de hachage sécurisé qui est résistant aux attaques par force brute et aux attaques par table de hachage précalculée (tables arc-en-ciel). Il est également conçu pour être résistant aux attaques par matériel spécialisé pour le hachage de mot de passe.

### Qu'est-ce que le hashage ?

Le hashage est un processus qui prend une entrée (ou des "données") et retourne une chaîne de caractères de longueur fixe. Ce qui est unique avec le hashage, c'est qu'il est unidirectionnel. Vous pouvez transformer les données en une chaîne de hash, mais vous ne pouvez pas transformer la chaîne de hash en données d'origine.

### Pourquoi hasher les mots de passe ?

Lorsqu'un utilisateur crée un compte avec un mot de passe sur un site web, ce mot de passe doit être stocké d'une manière ou d'une autre pour que l'utilisateur puisse se connecter ultérieurement. Si les mots de passe étaient stockés en clair, toute personne ayant accès à la base de données (par exemple, un pirate informatique) pourrait lire tous les mots de passe des utilisateurs. En revanche, si les mots de passe sont hashés, même si quelqu'un obtient l'accès à la base de données, il ne pourra pas comprendre les mots de passe.

### Comment fonctionne le hashage de mot de passe ?

Lorsqu'un utilisateur crée un compte ou change son mot de passe, le nouveau mot de passe est hashé et le hash est stocké dans la base de données. Lorsque l'utilisateur tente de se connecter, le mot de passe qu'il fournit est hashé à nouveau et ce nouveau hash est comparé au hash stocké dans la base de données. Si les deux correspondent, le mot de passe est correct et l'utilisateur est authentifié.

### Sécurité supplémentaire

#### Le sel

Pour augmenter la sécurité, un "sel" est souvent ajouté au mot de passe avant le hashage. Un sel est une chaîne de caractères aléatoires qui est unique à chaque utilisateur (ce n'est pas une abréviation). Il est ajouté au mot de passe de l'utilisateur pour créer un hash de mot de passe unique, même pour les utilisateurs qui ont le même mot de passe. Cela rend beaucoup plus difficile pour un attaquant de deviner le mot de passe à l'aide de tables de hachage précalculées (appelées tables arc-en-ciel).

> [!NOTE]
> Le "sel" n'est pas une méthode de chiffrement et n'est pas destiné à être secret. Même si un attaquant connaît le "sel", il ne peut pas facilement inverser le processus de hachage pour obtenir le mot de passe original.
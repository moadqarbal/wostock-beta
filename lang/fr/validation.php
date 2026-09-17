<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'accepted' => 'Le champ :attribute doit être accepté.',
    'accepted_if' => 'Le champ :attribute doit être accepté lorsque :other est :value.',
    'active_url' => 'Le champ :attribute doit être une URL valide.',
    'after' => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal' => 'Le champ :attribute doit être une date postérieure ou égale au :date.',
    'alpha' => 'Le champ :attribute ne peut contenir que des lettres.',
    'alpha_dash' => 'Le champ :attribute ne peut contenir que des lettres, chiffres, tirets et underscores.',
    'alpha_num' => 'Le champ :attribute ne peut contenir que des lettres et des chiffres.',
    'array' => 'Le champ :attribute doit être un tableau.',
    'before' => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal' => 'Le champ :attribute doit être une date antérieure ou égale au :date.',

    'between' => [
        'numeric' => 'Le champ :attribute doit être compris entre :min et :max.',
        'file' => 'Le fichier :attribute doit être compris entre :min et :max kilo-octets.',
        'string' => 'Le champ :attribute doit contenir entre :min et :max caractères.',
        'array' => 'Le tableau :attribute doit contenir entre :min et :max éléments.',
    ],

    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation de :attribute ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => 'Le champ :attribute doit être une date valide.',
    'date_equals' => 'Le champ :attribute doit être une date égale au :date.',
    'date_format' => 'Le champ :attribute doit respecter le format :format.',
    'decimal' => 'Le champ :attribute doit comporter :decimal décimales.',
    'different' => 'Les champs :attribute et :other doivent être différents.',
    'digits' => 'Le champ :attribute doit contenir :digits chiffres.',
    'digits_between' => 'Le champ :attribute doit contenir entre :min et :max chiffres.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'ends_with' => 'Le champ :attribute doit se terminer par l’une des valeurs suivantes : :values.',
    'exists' => 'La valeur sélectionnée pour :attribute est invalide.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit être renseigné.',

    'gt' => [
        'numeric' => 'Le champ :attribute doit être supérieur à :value.',
        'file' => 'Le fichier :attribute doit être supérieur à :value kilo-octets.',
        'string' => 'Le champ :attribute doit contenir plus de :value caractères.',
        'array' => 'Le tableau :attribute doit contenir plus de :value éléments.',
    ],

    'gte' => [
        'numeric' => 'Le champ :attribute doit être supérieur ou égal à :value.',
        'file' => 'Le fichier :attribute doit être supérieur ou égal à :value kilo-octets.',
        'string' => 'Le champ :attribute doit contenir au moins :value caractères.',
        'array' => 'Le tableau :attribute doit contenir au moins :value éléments.',
    ],

    'image' => 'Le champ :attribute doit être une image.',
    'in' => 'La valeur sélectionnée pour :attribute est invalide.',
    'integer' => 'Le champ :attribute doit être un nombre entier.',
    'ip' => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4' => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6' => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json' => 'Le champ :attribute doit être une chaîne JSON valide.',

    'lt' => [
        'numeric' => 'Le champ :attribute doit être inférieur à :value.',
        'file' => 'Le fichier :attribute doit être inférieur à :value kilo-octets.',
        'string' => 'Le champ :attribute doit contenir moins de :value caractères.',
        'array' => 'Le tableau :attribute doit contenir moins de :value éléments.',
    ],

    'lte' => [
        'numeric' => 'Le champ :attribute doit être inférieur ou égal à :value.',
        'file' => 'Le fichier :attribute doit être inférieur ou égal à :value kilo-octets.',
        'string' => 'Le champ :attribute doit contenir au maximum :value caractères.',
        'array' => 'Le tableau :attribute doit contenir au maximum :value éléments.',
    ],

    'max' => [
        'numeric' => 'Le champ :attribute ne peut pas être supérieur à :max.',
        'file' => 'Le fichier :attribute ne peut pas dépasser :max kilo-octets.',
        'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
        'array' => 'Le champ :attribute ne peut pas contenir plus de :max éléments.',
    ],

    'mimes' => 'Le fichier :attribute doit être de type :values.',
    'mimetypes' => 'Le fichier :attribute doit être de type :values.',

    'min' => [
        'numeric' => 'Le champ :attribute doit être au moins égal à :min.',
        'file' => 'Le fichier :attribute doit faire au moins :min kilo-octets.',
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
        'array' => 'Le tableau :attribute doit contenir au moins :min éléments.',
    ],

    'not_in' => 'La valeur sélectionnée pour :attribute est invalide.',
    'not_regex' => 'Le format du champ :attribute est invalide.',
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'password' => 'Le mot de passe est incorrect.',
    'present' => 'Le champ :attribute doit être présent.',
    'regex' => 'Le format du champ :attribute est invalide.',
    'required' => 'Le champ :attribute est obligatoire.',
    'required_if' => 'Le champ :attribute est obligatoire lorsque :other est :value.',
    'required_unless' => 'Le champ :attribute est obligatoire sauf si :other est :values.',
    'required_with' => 'Le champ :attribute est obligatoire lorsque :values est présent.',
    'required_with_all' => 'Le champ :attribute est obligatoire lorsque :values sont présents.',
    'required_without' => 'Le champ :attribute est obligatoire lorsque :values est absent.',
    'required_without_all' => 'Le champ :attribute est obligatoire lorsque aucun des champs :values n’est présent.',
    'same' => 'Les champs :attribute et :other doivent correspondre.',

    'size' => [
        'numeric' => 'Le champ :attribute doit être égal à :size.',
        'file' => 'Le fichier :attribute doit faire :size kilo-octets.',
        'string' => 'Le champ :attribute doit contenir :size caractères.',
        'array' => 'Le tableau :attribute doit contenir :size éléments.',
    ],

    'starts_with' => 'Le champ :attribute doit commencer par l’une des valeurs suivantes : :values.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone' => 'Le champ :attribute doit être un fuseau horaire valide.',
    'unique' => 'Cette valeur pour :attribute est déjà utilisée.',
    'uploaded' => 'Le fichier :attribute n’a pas pu être téléversé.',
    'url' => 'Le champ :attribute doit être une URL valide.',
    'uuid' => 'Le champ :attribute doit être un UUID valide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'custom' => [],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [

        // General
        'name' => 'nom',
        'title' => 'titre',
        'description' => 'description',
        'email' => 'adresse e-mail',
        'phone' => 'téléphone',
        'address' => 'adresse',
        'city' => 'ville',
        'country' => 'pays',
        'postal_code' => 'code postal',
        'notes' => 'notes',
        'image' => 'image',
        'file' => 'fichier',
        'message' => 'message',
        'subject' => 'sujet',

        // User / Authentication
        'user_id' => 'utilisateur',
        'password' => 'mot de passe',
        'password_confirmation' => 'confirmation du mot de passe',
        'current_password' => 'mot de passe actuel',
        'new_password' => 'nouveau mot de passe',
        'email_verified_at' => 'date de vérification de l’adresse e-mail',
        'remember' => 'se souvenir de moi',

        // Client
        'client_id' => 'client',

        // Supplier
        'supplier_id' => 'fournisseur',
        'company_name' => 'nom de l’entreprise',

        // Category
        'category_id' => 'catégorie',

        // Product
        'product_id' => 'produit',
        'sku' => 'SKU',
        'price' => 'prix',
        'stock' => 'stock',
        'stock_quantity' => 'quantité en stock',
        'minimum_stock' => 'stock minimum',

        // Order
        'order_id' => 'commande',
        'order_number' => 'numéro de commande',
        'source' => 'source',
        'status' => 'statut',
        'subtotal' => 'sous-total',
        'shipping_cost' => 'frais de livraison',
        'total_amount' => 'montant total',

        // Order Item
        'quantity' => 'quantité',

        // Dashboard / Analytics
        'period' => 'période',
        'start_date' => 'date de début',
        'end_date' => 'date de fin',
        'date' => 'date',
        'search' => 'recherche',
        'filter' => 'filtre',

        // Feature Proposal
        'feature' => 'fonctionnalité',
        'feature_name' => 'nom de la fonctionnalité',
        'subject' => 'sujet',
        'message' => 'message',

        // Common form fields
        'type' => 'type',
        'value' => 'valeur',
        'status' => 'statut',
        'category' => 'catégorie',
        'supplier' => 'fournisseur',
        'client' => 'client',
        'product' => 'produit',
        'order' => 'commande',
        'quantity' => 'quantité',
        'amount' => 'montant',
        'total' => 'total',
        'subtotal' => 'sous-total',
        'shipping' => 'livraison',
    ],

];
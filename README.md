# Doctrine simple translation type bundle

![Latest Stable](https://img.shields.io/packagist/v/softspring/doctrine-simple-translation-type-bundle?label=stable&style=flat-square)
![Latest Unstable](https://img.shields.io/packagist/v/softspring/doctrine-simple-translation-type-bundle?label=unstable&style=flat-square&include_prereleases)
![License](https://img.shields.io/packagist/l/softspring/doctrine-simple-translation-type-bundle?style=flat-square)
![PHP Version](https://img.shields.io/packagist/dependency-v/softspring/doctrine-simple-translation-type-bundle/php?style=flat-square)
![Downloads](https://img.shields.io/packagist/dt/softspring/doctrine-simple-translation-type-bundle?style=flat-square)
[![CI](https://img.shields.io/github/actions/workflow/status/softspring/doctrine-simple-translation-type-bundle/ci.yml?branch=5.3&style=flat-square&label=CI)](https://github.com/softspring/doctrine-simple-translation-type-bundle/actions/workflows/ci.yml)

This package provides a simple translation type for Doctrine, and its Symfony integration bundle.

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require softspring/doctrine-simple-translation-type-bundle
```

## Configure

Configure the Doctrine type:

    # config/packages/doctrine.yaml
    
    doctrine:
        dbal:
            types:
                simple_translation: 'Softspring\DoctrineSimpleTranslationTypeBundle\Doctrine\Type\SimpleTranslationType'

## Usage

### Configure entity that uses the type

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @var SimpleTranslation
     * @ORM\Column(name="translated_name", type="simple_translation", nullable=false)
     */
    protected $translatedName;
    
    public function __construct()
    {
        $this->translatedName = new SimpleTranslation();
    }
                
    /**
     * @return SimpleTranslation
     */
    public function getName(): SimpleTranslation
    {
        return $this->translatedName;
    }

    /**
     * @param SimpleTranslation $translatedName
     */
    public function setName(SimpleTranslation $translatedName): void
    {
        $this->translatedName = $translatedName;
    }   
    
### Manage the model

The model class is *Softspring\DoctrineSimpleTranslationTypeBundle\Model\SimpleTranslation*.

**Set the default translation**

    $entity->getName()->setDefaultLocale('es');
    $entity->getName()->setTranslation(null, 'Nombre de la entidad'); // null means default locale
    $entity->getName()->setTranslation('es', 'Nombre de la entidad'); // it's also posible to specify the locale
    
**Add additional translations**

    $entity->getName()->setTranslation('en', 'Entity name');
    
**Get the value**
    
    $entity->getName()->translate(); // returns the default value 'Nombre de la entidad'
    $entity->getName()->translate('es'); // returns 'Nombre de la entidad'
    $entity->getName()->translate('en'); // returns 'Entity name'
    
**Use the full methods**

    $entity->getName()->getTranslations(); // returns ['es'=>'Nombre de la entidad', 'en'=>'Entity name']
    $entity->getName()->setTranslations(['es'=>'Nombre de la entidad', 'en'=>'Entity name']);
    
**Use it as array**

The model implements ArrayAccess, so it's possible to use it as an array:

    $entity->getName()['en']; // returns 'Entity name'
    $entity->getName()['es']; // returns 'Nombre de la entidad'
    
### Twig usage

    {{ entity.name|translate }} {# returns 'Nombre de la entidad' if app.request.locale is 'es' #}    
    {{ entity.name|translate('es') }} {# returns 'Nombre de la entidad' #}    
    {{ entity.name|translate('en') }} {# returns 'Entity name' #}    

### Edit values in forms

You can use the *Softspring\DoctrineSimpleTranslationTypeBundle\Form\SimpleTranslationType*

    use Symfony\Component\Form\FormBuilderInterface;
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('translatedName'); // automatically uses the SimpleTranslationType thanks to the TypeGuesser
    }
    
**Force languages**

    $builder->add('translatedName', SimpleTranslationType::class, [
        'languages' => ['es','en','de'],    
    ]);
    

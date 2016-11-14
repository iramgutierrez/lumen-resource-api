<?php

namespace IramGutierrez\API\Generators;

use Memio\Memio\Config\Build;
use Memio\Model\File;
use Memio\Model\Object;
use Memio\Model\Method;
use Memio\Model\Argument;
use Memio\Model\Phpdoc\Description;
use Memio\Model\Phpdoc\MethodPhpdoc;
use Memio\Model\FullyQualifiedName;
use Memio\Model\Phpdoc\LicensePhpdoc;

use IramGutierrez\API\Managers\BaseManager;

class ManagerGenerator extends BaseGenerator{

    protected $pathfile = 'Managers';

    protected $layer = 'Manager';

    public function generate()
    {
        $repository = File::make($this->filename)
            ->setLicensePhpdoc(new LicensePhpdoc(self::PROJECT_NAME, self::AUTHOR_NAME, self::AUTHOR_EMAIL))
            ->addFullyQualifiedName(new FullyQualifiedName(BaseManager::class))
            ->addFullyQualifiedName(new FullyQualifiedName($this->appNamespace."Entities\\".$this->entity."Entity as Entity"))
            ->addFullyQualifiedName(new FullyQualifiedName($this->appNamespace."Validators\\".$this->entity."Validator as Validator"))
            ->setStructure(
                Object::make($this->namespace.$this->entity.$this->layer)
                    ->extend(new Object(BaseManager::class))
                    ->addMethod(
                        Method::make('__construct')
                            ->setPhpdoc(MethodPhpdoc::make()
                                ->setDescription(Description::make('')
                                    ->addLine('@param Entity $Entity')
                                    ->addLine('@param Validator $Validator')
                                )
                            )
                            ->addArgument(new Argument('Entity', 'Entity'))
                            ->addArgument(new Argument('Validator', 'Validator'))
                            ->setBody('        return parent::__construct($Entity , $Validator);')
                    )
            );

        $prettyPrinter = Build::prettyPrinter();
        $generatedCode = $prettyPrinter->generateCode($repository);

        return $this->generateFile($generatedCode);
    }
}
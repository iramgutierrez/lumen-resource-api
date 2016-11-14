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

use IramGutierrez\API\Repositories\BaseRepository;

class RepositoryGenerator extends BaseGenerator{

    protected $pathfile = 'Repositories';

    protected $layer = 'Repository';

    public function generate()
    {
        $repository = File::make($this->filename)
            ->setLicensePhpdoc(new LicensePhpdoc(self::PROJECT_NAME, self::AUTHOR_NAME, self::AUTHOR_EMAIL))
            ->addFullyQualifiedName(new FullyQualifiedName(BaseRepository::class))
            ->addFullyQualifiedName(new FullyQualifiedName($this->appNamespace."Entities\\".$this->entity."Entity as Entity"))
            ->setStructure(
                Object::make($this->namespace.$this->entity.$this->layer)
                    ->extend(new Object(BaseRepository::class))
                    ->addMethod(
                        Method::make('__construct')
                            ->setPhpdoc(MethodPhpdoc::make()
                                ->setDescription(Description::make('')
                                    ->addLine('@param Entity $Entity')
                                )
                            )
                            ->addArgument(new Argument('Entity', 'Entity'))
                            ->setBody('        parent::__construct($Entity);')
                    )
            );

        $prettyPrinter = Build::prettyPrinter();
        $generatedCode = $prettyPrinter->generateCode($repository);

        return $this->generateFile($generatedCode);
    }
}
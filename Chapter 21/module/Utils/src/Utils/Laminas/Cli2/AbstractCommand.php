<?php

namespace Utils\Laminas\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;

use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\PropertyGenerator;

class AbstractCommand extends Command
{
    const MODULE_SRC = __DIR__.'/../../../../../';
    const MODULE_CONTROLLER_SRC = '/src/Controller/';
    const MODULE_MODEL_SRC = '/src/Model/';
    const MODULE_ROWSET_SRC = '/src/Model/Rowset/';
    
    protected function configure()
    {
        $this->addOption('module', null, InputOption::VALUE_OPTIONAL, 'The module name of the component.');
    }
    
    protected function getModuleName($input, $output, $componentName): string
    {
        $moduleName = $input->getOption('module');
        
        if (empty($moduleName)) {
            $helper = $this->getHelper('question');
            $question = new Question(
                'In which module you want to create a '.$componentName.'?'.PHP_EOL
            );

            $moduleName = $helper->ask($input, $output, $question);
        }
        
        return ucfirst($moduleName);
    }
    
    protected function storeControllerContents($fileName, $moduleName, $contents): void
    {
        $dir = self::MODULE_SRC.$moduleName.self::MODULE_CONTROLLER_SRC;
        
        if (!file_exists($dir)) {
            mkdir(self::MODULE_SRC.$moduleName);
            mkdir(self::MODULE_SRC.$moduleName.'/src/');
            mkdir(self::MODULE_SRC.$moduleName.'/src/Controller');
        }
        file_put_contents($dir.$fileName, $contents);
    }
    
    protected function storeModelContents($fileName, $moduleName, $contents = null, $templateFile = null): void
    {
        $dir = self::MODULE_SRC.$moduleName.self::MODULE_MODEL_SRC;

        if (!file_exists(self::MODULE_SRC.$moduleName)) {
            mkdir(self::MODULE_SRC.$moduleName);
        }
        if (!file_exists(self::MODULE_SRC.$moduleName.'/src/')) {
            mkdir(self::MODULE_SRC.$moduleName.'/src/');
        }
        if (!file_exists($dir)) {
            mkdir(self::MODULE_SRC.$moduleName.self::MODULE_MODEL_SRC);
        }
        
        if (empty($contents) && isset($templateFile)) {
            $contents = file_get_contents(__DIR__.'/Templates/'.$templateFile);
        }
        file_put_contents($dir.$fileName, $contents);
    }
    
    protected function storeRowsetContents($fileName, $moduleName, $contents): void
    {
        $dir = self::MODULE_SRC.$moduleName.self::MODULE_ROWSET_SRC;
        
        if (!file_exists(self::MODULE_SRC.$moduleName)) {
            mkdir(self::MODULE_SRC.$moduleName);
        }
        if (!file_exists(self::MODULE_SRC.$moduleName.'/src/')) {
            mkdir(self::MODULE_SRC.$moduleName.'/src/');
        }
        if (!file_exists(self::MODULE_SRC.$moduleName.'/src/Model/')) {
            mkdir(self::MODULE_SRC.$moduleName.'/src/Model/');
        }
        if (!file_exists($dir)) {
            mkdir(self::MODULE_SRC.$moduleName.self::MODULE_ROWSET_SRC);
        }
        file_put_contents($dir.$fileName, $contents);
    }
    
    protected function storeViewContents($fileName, $moduleName, $controllerName, $contents): void
    {
        $moduleName = strtolower($moduleName);
        $dir = self::MODULE_SRC.$moduleName.'/view/'.$controllerName.'/';
        
        if (!file_exists(self::MODULE_SRC)) {
            mkdir(self::MODULE_SRC);
        }
        if (!file_exists(self::MODULE_SRC.$moduleName.'/view/')) {
            mkdir(self::MODULE_SRC.$moduleName.'/view/');
        }
        if (!file_exists(self::MODULE_SRC.$moduleName.'/view/'.$controllerName.'/')) {
            mkdir(self::MODULE_SRC.$moduleName.'/view/'.$controllerName.'/');
        }
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        file_put_contents($dir.$fileName, $contents);
    }
}
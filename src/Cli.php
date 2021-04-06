<?php


namespace Ficury;


use Psr\Container\ContainerInterface;
use splitbrain\phpcli\Options;
use splitbrain\phpcli\PSR3CLI;

class Cli extends PSR3CLI
{

    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct(true);
        $this->container = $container;
    }

    protected function setup(Options $options)
    {
        $options->setHelp('Feature crawler.');
        $options->registerCommand('run', 'runs job');
        $options->registerArgument('job', 'specify job classname to run', true, 'run');

    }

    protected function main(Options $options)
    {
        if ($options->getCmd() === 'run') {
            $job = $options->getArgs()[0];
            $this->runJob($job);
        } else {
            echo $options->help();
        }
    }

    protected function runJob(string $jobName)
    {
        if ($this->container->has($jobName)) {
            $job = $this->container->get($jobName);
            if ($job instanceof Job) {
                return $job->run();
            } else {
                $this->fatal(sprintf('Job %s should be instance of Job.', $jobName));
                exit;
            }
        }
        $this->fatal(sprintf('Job %s not found.', $jobName));
        exit;
    }
}
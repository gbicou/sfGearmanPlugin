<?php

/**
 * Simple gearman worker task
 *
 * @package     sfGearmanPlugin
 * @subpackage  task
 * @author      Benjamin VIELLARD <bicou@bicou.com>
 * @license     The MIT License
 * @version     SVN: $Id$
 */
class gearmanWorkerTask extends sfGearmanWorkerBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('debug', null, sfCommandOption::PARAMETER_NONE, 'Debug environment flag'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_OPTIONAL, 'The connection name', null),

      new sfCommandOption('server', null, sfCommandOption::PARAMETER_OPTIONAL, 'Gearman job server config key'),
      new sfCommandOption('count', null, sfCommandOption::PARAMETER_REQUIRED, 'Number of jobs for worker to run before exiting', 100),
      new sfCommandOption('timeout', null, sfCommandOption::PARAMETER_REQUIRED, 'Timeout in seconds', 20),
      new sfCommandOption('verbose', null, sfCommandOption::PARAMETER_NONE, 'Log workloads and additional events'),

      new sfCommandOption('config', null, sfCommandOption::PARAMETER_REQUIRED, 'gearman.yml worker config key'),
    ));

    $this->namespace        = 'gearman';
    $this->name             = 'worker';
    $this->briefDescription = 'Gearman worker daemon';
    $this->detailedDescription = <<<EOF
The [gearman:worker|INFO] start a gearman worker.
Call it with:

  [php symfony gearman:worker|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $this->command_options = $options;

    // create context
    $configuration = ProjectConfiguration::getApplicationConfiguration($options['application'], $options['env'], $options['debug']);
    sfContext::createInstance($configuration, 'default');

    // initialize the database connection
    if($options['connection'] !== null)
    {
      $databaseManager = new sfDatabaseManager($this->configuration);
      $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    }

    // connect to gearman events
    $this->connectGearmanEvents();

    // s => ms
    $options['timeout'] *= 1000;

    // create and work a worker
    $worker = new sfGearmanWorker($options, $this->dispatcher);

    try
    {
      $worker->loop();
    }
    catch(sfGearmanTimeoutException $e)
    {
    }
  }
}



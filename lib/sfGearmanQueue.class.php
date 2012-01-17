<?php

/**
 * Gearman based queue manager
 *
 * @package   sfGearmanPlugin
 * @author    Benjamin VIELLARD <bicou@bicou.com>
 * @license   The MIT License
 * @version   SVN: $Id$
 */
class sfGearmanQueue
{
  /**
   * Prefix for gearman function name
   *
   * @var string
   */
  const PREFIX = 'queue.';

  /**
   * last element retrieved
   * 
   * @var mixed
   */
  protected static $data = null;

  /**
   * Gearman function name from queue name
   *
   * @param string $queue Queue name
   *
   * @return string gearman function name
   */
  protected static function getFunctionName($queue)
  {
    return self::PREFIX.$queue;
  }

  /**
   * Put a message in queue
   *
   * @param string $queue  Queue name
   * @param mixed  $data   Data to put in queue, optional, defaults to ''
   * @param string $server Server config key, optional, defaults to null
   *
   * @return string gearman job result
   */
  public static function put($queue, $data = '', $options = null, $server = null)
  {
    // send a background job with serialized data as workload
    return sfGearmanClient::getInstance($server)->background(
      self::getFunctionName($queue), serialize($data), $options
    );
  }

  /**
   * Get a message from queue (blocking)
   *
   * @param string  $queue   Queue name
   * @param integer $timeout Socket I/O activity timeout (in ms), optional, defaults to -1
   * @param string  $server  Server config key, optional, defaults to null
   *
   * @return mixed  Data put in queue, null in case of error
   */
  public static function get($queue, $timeout = -1, $server = null)
  {
    // we need a worker to get a message
    $worker = new sfGearmanWorker(array('server' => $server));

    // attach function callback and receive queue message as context
    $worker->addFunction(self::getFunctionName($queue), array(__CLASS__, 'work'));

    // init worker data
    self::$data = null;

    // work the worker once only
    $worker->loop(1, $timeout);

    // return worker data
    return self::$data;
  }

  /**
   * Queue worker
   *
   * @param GearmanJob $job  gearman job
   * @param mixed      $data reference to queue data
   *
   * @return boolean   always true
   */
  public static function work($job)
  {
    // just unserialize workload
    self::$data = unserialize($job->workload());
    return true;
  }
}


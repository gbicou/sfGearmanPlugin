<?php

/**
 * Interface to gearman connections (clients and workers)
 *
 * @package   sfGearmanPlugin
 * @author    Benjamin VIELLARD <bicou@bicou.com>
 * @license   The MIT License
 * @version   SVN: $Id$
 */
interface sfGearmanConnection
{
  /**
   * Add a job server
   *
   * @param string $host
   * @param string $port
   *
   * @return boolean
   */
  public function addServer($host, $port);

  /**
   * Add a list of job servers
   *
   * @param string $servers
   *
   * @return boolean
   */
  public function addServers($servers);

  /**
   * Add options
   *
   * @param integer $options
   *
   * @return boolean
   */
  public function addOptions($options);

  /**
   * Set options
   *
   * @param integer $options
   *
   * @return boolean
   */
  public function setOptions($options);

  /**
   * Remove options
   *
   * @param integer $options
   *
   * @return boolean
   */
  public function removeOptions($options);

  /**
   * Get options
   *
   * @return integer
   */
  public function options();
}


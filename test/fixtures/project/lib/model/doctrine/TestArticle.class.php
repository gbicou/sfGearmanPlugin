<?php

/**
 * TestArticle
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    ##PROJECT_NAME##
 * @subpackage model
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id$
 */
class TestArticle extends BaseTestArticle
{
  public function triggerInsert()
  {
    echo __METHOD__,"\n";
    $job = $this->getGearmanJob();
    echo $job->handle(),"\n";
    echo $job->functionName(),"\n";
    echo $job->unique(),"\n";
    echo $this->title,"\n";
    echo $this->id,"\n";
  }

  public function triggerUpdate($modified)
  {
    echo __METHOD__,"\n";
    var_dump($modified);
    $job = $this->getGearmanJob();
    echo $job->handle(),"\n";
    echo $job->functionName(),"\n";
    echo $job->unique(),"\n";
    echo $this->title,"\n";
    echo $this->id,"\n";
  }

  public function triggerDelete()
  {
    echo __METHOD__,"\n";
    $job = $this->getGearmanJob();
    echo $job->handle(),"\n";
    echo $job->functionName(),"\n";
    echo $job->unique(),"\n";
    echo $this->title,"\n";
    echo $this->id,"\n";
  }

  public function publish($arg)
  {
    echo __METHOD__,"\n";
    $job = $this->getGearmanJob();
    echo $job->handle(),"\n";
    echo $job->functionName(),"\n";
    echo $job->unique(),"\n";
    echo $arg,"\n";

    return __METHOD__.'('.$arg.')';
  }
}

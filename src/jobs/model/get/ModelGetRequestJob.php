<?php
namespace matrozov\yii2amqp\jobs\model\save;

use matrozov\yii2amqp\jobs\rpc\RpcRequestJob;

/**
 * Interface ModelGetRequestJob
 * @package matrozov\yii2amqp\jobs
 */
interface ModelGetRequestJob extends RpcRequestJob
{
    public static function get($conditions);
}
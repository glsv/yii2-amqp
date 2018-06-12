<?php
namespace matrozov\yii2amqp\jobs\model\search;

use matrozov\yii2amqp\jobs\rpc\RpcRequestJob;

/**
 * Interface ModelSearchRequestJob
 * @package matrozov\yii2amqp\jobs
 */
interface ModelSearchRequestJob extends RpcRequestJob
{
    public function validate();

    public function clearErrors($attribute = null);
    public function addErrors(array $items);
}
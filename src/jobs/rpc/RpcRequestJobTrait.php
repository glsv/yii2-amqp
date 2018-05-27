<?php
namespace matrozov\yii2amqp\jobs\rpc;

use Yii;
use yii\base\Model;
use yii\base\ErrorException;
use matrozov\yii2amqp\Connection;

/**
 * Trait RpcRequestJobTrait
 * @package matrozov\yii2amqp\traits
 */
trait RpcRequestJobTrait
{
    /**
     * @param Connection|null $connection
     *
     * @return Connection
     * @throws
     */
    protected function connection(Connection $connection = null)
    {
        if ($connection == null) {
            $connection = Yii::$app->amqp;
        }

        if (!$connection || !($connection instanceof Connection)) {
            throw new ErrorException('Can\'t get connection!');
        }

        return $connection;
    }

    /**
     * @param Connection|null $connection
     *
     * @return RpcResponseJob|bool|null
     * @throws
     */
    public function send(Connection $connection = null)
    {
        if ($this instanceof Model) {
            if (!$this->validate()) {
                return false;
            }
        }

        $connection = $this->connection($connection);

        /* @var RpcRequestJob $this */
        return $connection->send($this->exchangeName(), $this);
    }
}
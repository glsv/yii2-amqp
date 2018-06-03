<?php
namespace matrozov\yii2amqp\jobs\model;

use Yii;
use yii\base\ErrorException;
use matrozov\yii2amqp\Connection;

/**
 * Trait ModelRequestJobTrait
 * @package matrozov\yii2amqp\traits
 */
trait ModelRequestJobTrait
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
     * @var ModelResponseJob $response
     *
     * @return bool
     * @throws
     */
    public function save(Connection $connection = null)
    {
        /* @var ModelRequestJob $this */
        if (!$this->validate()) {
            return false;
        }

        $connection = $this->connection($connection);

        /* @var ModelRequestJob $this */
        $response = $connection->send($this->exchangeName(), $this);

        if (!$response) {
            return false;
        }

        /* @var ModelResponseJob $response */
        /* @var ModelRequestJob $this */
        $this->addErrors($response->errors);

        if ($response->success) {
            foreach ($response->primaryKeys as $key => $value) {
                $this->$key = $value;
            }
        }

        return $response->success;
    }
}
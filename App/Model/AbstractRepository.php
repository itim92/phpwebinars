<?php


namespace App\Model;


use App\Db\Db;
use App\Db\DbExp;
use App\DI\Container;
use App\Exception\ClassNotExistException;
use App\Model\Exceptions\ClassNotAllowedException;
use App\Utils\DocParser;

class AbstractRepository
{
    const FIND_BY_AND = 'and';
    const FIND_BY_OR = 'or';


    /**
     * @var ModelAnalyzer
     * @onInit(App\Model\ModelAnalyzer)
     */
    protected $modelAnalyzer;

    /**
     * @var DocParser
     * @onInit(App\Utils\DocParser)
     */
    protected $docParser;

    /**
     * @var Container
     * @onInit(App\DI\Container)
     */
    protected $di;

    /**
     * @var AbstractModel
     */
    protected $exampleModel;

    /**
     * @var string
     */
    protected $modelClassname;

    protected function getExampleModel() {
        if (!is_null($this->exampleModel)) {
            return $this->exampleModel;
        }

        $modelClass = $this->getModeClassname();

        /**
         * @var $exampleModel AbstractModel
         */
        $exampleModel = $this->di->get($modelClass);

        if (!($exampleModel instanceof AbstractModel)) {
            $message = 'Class ' . $modelClass . ' does not allowed there. It must be a AbstractModel class';
            throw new ClassNotAllowedException($message);
        }

        $this->exampleModel = $exampleModel;

        return $exampleModel;
    }

    protected function getTableName() {
        return $this->modelAnalyzer->getTableName(
            $this->getExampleModel()
        );
    }

    protected function getIdColumnName() {
        return $this->modelAnalyzer->getIdColumnName(
            $this->getExampleModel()
        );
    }

    protected function getModeClassname()
    {
        if (!is_null($this->modelClassname)) {
            return  $this->modelClassname;
        }

        $modelClass = $this->docParser->getClassAnnotate($this, '@Model');

        if (!class_exists($modelClass)) {
            $message = 'Class ' . $modelClass . ' does not exist';
            throw new ClassNotExistException($message);
        }

        $this->modelClassname = $modelClass;

        return $this->modelClassname;
    }

    /**
     * @return AbstractModel
     * @throws ClassNotExistException
     * @throws \ReflectionException
     */
    protected function getNewModel() {
        /**
         * @var $model AbstractModel
         */
        $model = $this->di->get(
            $this->getModeClassname()
        );

        return $model;
    }

    protected function createModelByArray(array $data) {
        $model = $this->getNewModel();

        $id = $data[$this->getIdColumnName()];
        $this->modelAnalyzer->setId($model, $id);

        $tableFields = $this->modelAnalyzer->getTableFields(
            $this->getExampleModel()
        );
        foreach ($tableFields as $propertyName => $tableField) {
            $propertyValue = $data[$tableField] ?? null;

            if (!is_null($propertyValue)) {
                $this->modelAnalyzer->setProperty($model, $propertyName, $propertyValue);
            }
        }

        $relations = $this->modelAnalyzer->getRelations(
            $this->getExampleModel()
        );

        foreach ($relations as $propertyName => $tableFieldName) {
            $this->modelAnalyzer->setRelation($model, $propertyName, $tableFieldName);
        }


        return $model;
    }

    public function find(int $id)
    {
        $tableName = $this->getTableName();
        $idColumnName = $this->getIdColumnName();


        $query = "SELECT * FROM $tableName WHERE $idColumnName = $id";
        $modelArray = Db::fetchRow($query);

        return $this->createModelByArray($modelArray);
    }

    public function findBy(array $condition)
    {
//        $condition = [
//            'field1' => 'value1'
//        ];

        $tableName = $this->getTableName();

        $where = [];

        foreach ($condition as $key => $value) {
            $key = Db::escape($key);

            if (!($value instanceof DbExp)) {
                $value = Db::escape($value);
                $value = "'$value'";
            }

            $where[] = "$key = $value";
        }

        if (!empty($where)) {
            $where = 'WHERE '. implode(' AND ', $where);
        } else {
            $where = '';
        }


        $query = "SELECT * FROM $tableName $where LIMIT 1";
        $modelArray = Db::fetchRow($query);

        return $this->createModelByArray($modelArray);
    }

    public function findAll(int $offset = 0, int $limit = 100)
    {

        $tableName = $this->getTableName();


        $query = "SELECT * FROM $tableName LIMIT $offset, $limit";
        $data = Db::fetchAll($query);

        $models = [];

        foreach ($data as $modelArray) {
            $models[] = $this->createModelByArray($modelArray);
        }

        return $models;
    }

    public function findAllBy(array $condition, int $offset = 0, int $limit = 100, string $findBy = self::FIND_BY_AND)
    {

//        $condition = [
//            'field1' => 'value1'
//        ];

        $tableName = $this->getTableName();

        $where = [];

        foreach ($condition as $key => $value) {
            $key = Db::escape($key);

            if (!($value instanceof DbExp)) {
                $value = Db::escape($value);
                $value = "'$value'";
            }

            $where[] = "$key = $value";
        }

        if (!empty($where)) {
            $where = 'WHERE '. implode(' AND ', $where);
        } else {
            $where = '';
        }


        $query = "SELECT * FROM $tableName $where LIMIT $offset, $limit";
        $data = Db::fetchAll($query);

        $models = [];

        foreach ($data as $modelArray) {
            $models[] = $this->createModelByArray($modelArray);
        }

        return $models;

    }


}
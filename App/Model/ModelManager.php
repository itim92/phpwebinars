<?php


namespace App\Model;


use App\Model\AbstractModel as Model;
use App\Db\Db;
use App\Model\Exceptions\ManyModelIdFieldException;
use App\Utils\DocParser;
use App\Utils\ReflectionUtil;
use App\Utils\StringUtil;

class ModelManager
{

    /**
     * @var DocParser
     */
    private $docParser;
    /**
     * @var StringUtil
     */
    private $stringUtil;
    /**
     * @var ReflectionUtil
     */
    private $reflectionUtil;

    public function __construct(DocParser $docParser, StringUtil $stringUtil, ReflectionUtil  $reflectionUtil)
    {

        $this->docParser = $docParser;
        $this->stringUtil = $stringUtil;
        $this->reflectionUtil = $reflectionUtil;
    }

    public function save(Model $model)
    {
        $tableName = $this->getTableName($model);
        $tableFields = $this->getTableFields($model);

        $tableData = [];

        foreach ($tableFields as $objectKey => $tableKey) {
            $objectValue = $model[$objectKey];

            $value = null;
            if (is_object($objectValue)) {
                if (method_exists($objectValue, 'getId')) {
                    $value = $objectValue->getId();
                } else if ($objectValue instanceof \DateTime) {
                    $value = $objectValue->format('Y-m-d H:i');
                }
            } else if (is_array($objectValue)) {
                $value = json_encode($objectValue);
            } else {
                $value = $objectValue;
            }

            if (!is_null($value)) {
                $tableData[$tableKey] = $value;
            }
        }

        $id = Db::insert($tableName, $tableData);
        $modelIdInfo = $this->getIdField($model);

        if (!is_null($modelIdInfo)) {
            $this->reflectionUtil->setPrivatePropertyValue($model, $modelIdInfo['objectProperty'], $id);
        }


//        if ($model instanceof )

//
//
//        dump($tableFields);
//        dump($tableData);
//        dump($model);
//        exit;


        /**
         *
         * Записать в базу данных
         *  - в какую таблицу записывать
         *  - Нужно получить список параметров, требуемых для сохранения в базе
         * Получить id записанной строки
         */
    }

    private function getTableName(Model $model)
    {
        $reflectionObject = new \ReflectionObject($model);
        $docComment = $reflectionObject->getDocComment();
        return $this->docParser->getAnnotationValue('@Model\Table', $docComment);
    }

    private function getTableFields(Model $model)
    {
        return $this->getModelFieldsByAnnotate('@Model\TableField', $model);
    }

    /**
     * @param Model $model
     * @return array|null
     * @throws ManyModelIdFieldException
     */
    private function getIdField(Model $model) {
        $fields = $this->getModelFieldsByAnnotate('@Model\Id', $model);

        if (count($fields) > 1) {
            $message = 'class ' . get_class($model) . ' can have only one Model\Id annotate';
            throw new ManyModelIdFieldException($message);
        }

        if (empty($fields)) {
            return null;
        }

        $key = array_key_first($fields);
        $value = $fields[$key];

        return [
            'objectProperty' => $key,
            'tableProperty' => $value,
        ];
    }

    private function getModelFieldsByAnnotate(string $annotate, Model $model) {
        $fields = [];

        $reflectionObject = new \ReflectionObject($model);
        foreach ($reflectionObject->getProperties() as $property) {
            $docComment = $property->getDocComment();
            $fieldAnnotate = $annotate;

            if (!$this->docParser->isHasAnnotate($fieldAnnotate, $docComment)) {
                continue;
            }

            $propertyName = $property->getName();
            $field = $this->docParser->getAnnotationValue($fieldAnnotate, $docComment);

            if (empty($field)) {
                $field = $property->getName();
            }


            $fields[$propertyName] = $this->stringUtil->camelToSnake($field);
        }

        return $fields;
    }
}
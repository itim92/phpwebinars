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
     * @var ReflectionUtil
     */
    private $reflectionUtil;

    /**
     * @var ModelAnalyzer
     */
    private $modelAnalyzer;

    public function __construct(ModelAnalyzer $modelAnalyzer, ReflectionUtil  $reflectionUtil)
    {

        $this->reflectionUtil = $reflectionUtil;
        $this->modelAnalyzer = $modelAnalyzer;
    }


    /**
     * @param AbstractModel $model
     * @return bool
     * @throws ManyModelIdFieldException
     */
    public function save(Model $model)
    {
        $tableName = $this->modelAnalyzer->getTableName($model);
        $tableFields = $this->modelAnalyzer->getTableFields($model);

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

        $id = $model->getId();
        $modelIdInfo = $this->modelAnalyzer->getIdField($model);

        if (is_null($modelIdInfo)) {
            return false;
        }

        if ($id) {
            $id = Db::insert($tableName, $tableData);
            $this->modelAnalyzer->setId($model, $id);
        } else {
            Db::update($tableName, $tableData, $modelIdInfo['tableProperty'] . " = '$id'");
        }

        return true;
    }


}
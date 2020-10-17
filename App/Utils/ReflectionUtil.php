<?php


namespace App\Utils;


class ReflectionUtil
{

    public function getClassAnnotate(object $object, string $annotation)
    {
        $docComment = $this->getClassDocBlock($object);
        return $this->getAnnotationValue($annotation, $docComment, false);
    }


    public function toArray(string $docComment)
    {
        $docComment = str_replace(['/**', '*/'], '', $docComment);
        $docComment = trim($docComment);
        $docCommentArray = explode("\n", $docComment);

        $docCommentArray = array_map(function ($item) {
            $item = trim($item);

            $position = strpos($item, '*');
            if ($position === 0) {
                $item = substr($item, 1);
            }

            return trim($item);
        }, $docCommentArray);

        return $docCommentArray;
    }

    public function getAnnotationValue(string $annotation, string $docComment, bool $replaceQuotes = true)
    {
        $docCommentArray = $this->toArray($docComment);
        $annotateValue = null;

        foreach ($docCommentArray as $docCommentItem) {
            $annotatePrefix = $annotation . '(';
            $isHasAnnotate = strpos($docCommentItem, $annotatePrefix) === 0;

            if (!$isHasAnnotate) {
                continue;
            }

            $annotateValue = str_replace($annotatePrefix, '', $docCommentItem);
            $annotateValue = substr($annotateValue, 0, -1);

            if ($replaceQuotes && !empty($annotateValue)) {
                $annotateValue = substr($annotateValue, 1, -1);
            }

            break;
        }

        return $annotateValue;
    }

    /**
     * @param string $annotation
     * @param string $docComment
     * @return bool
     */
    public function isHasAnnotate(string $annotation, string $docComment): bool
    {
        return strpos($docComment, $annotation) !== false;
    }

    public function setPrivatePropertyValue($object, string $propertyName, $propertyValue)
    {
        $reflectionModel = new \ReflectionObject($object);
        $reflectionId = $reflectionModel->getProperty($propertyName);
        $reflectionId->setAccessible(true);
        $reflectionId->setValue($object, $propertyValue);
        $reflectionId->setAccessible(false);
    }


    public function getClassDocBlock(object $object)
    {
        $reflectionObject = new \ReflectionObject($object);
        return $reflectionObject->getDocComment();
    }

    public function getUseBlock($object) {

        if (is_object($object)) {
            $reflectionObject = new \ReflectionObject($object);
        } else {
            $reflectionObject = new \ReflectionClass($object);
        }

        $startLine = $reflectionObject->getStartLine();
        $classFilename = $reflectionObject->getFileName();

        $classFile = fopen($classFilename, 'r');
        $code = "";

        for ($i = 1; $i < $startLine; $i++) {
            $code .= fgets($classFile);
        }

        fclose($classFile);
        $code = str_replace($reflectionObject->getDocComment(), '', $code);
        $code = trim($code);
        $code = explode("use", $code);

        $code = array_slice($code, 1);
        $useCode = array_map(function($item) {
            $item = trim($item);
            $item = str_replace("\n", '', $item);
            $item = str_replace(";", '', $item);

            return $item;
        }, $code);

        $useCode = implode(',', $useCode);
        $useCode = explode(',', $useCode);
        $useCollection = array_map('trim', $useCode);

//        $classCode = file_get_contents($classFilename);

        $useDictionary = [];
        foreach ($useCollection as $useString) {
            if (strpos($useString, ' as ') !== false) {
                $useData = explode(' as ', $useString);
                $useDictionary[$useData[1]] = $useData[0];

                continue;
            }

            if (strpos($useString, '\\') !== false) {
                $useChunks = explode('\\', $useString);

                $lastChunkIndex = count($useChunks) - 1;
                $key = $useChunks[$lastChunkIndex];
                $useDictionary[$key] = $useString;

                continue;
            }

            $useDictionary[$useString] = $useString;
        }

        return $useDictionary;
    }

    public function getPropertyType($object, string $propertyName)
    {
        $reflectionObject = new \ReflectionObject($object);
        $reflectionProperty = $reflectionObject->getProperty($propertyName);

        $docComment = $reflectionProperty->getDocComment();
        $type = $this->getVarDocValue($docComment);

        if (strpos($type, '\\') === 0) {
            return $type;
        }

        $firstChar = $type[0];
        $firstCharLower = strtolower($firstChar);

        if ($firstChar === $firstCharLower) {
            return $type;
        }

        $startLine = $reflectionObject->getStartLine();
        $classFilename = $reflectionObject->getFileName();

        $classFile = fopen($classFilename, 'r');
        $code = "";

        for ($i = 1; $i < $startLine; $i++) {
            $code .= fgets($classFile);
        }

        fclose($classFile);

        $code = str_replace($reflectionObject->getDocComment(), '', $code);
        $code = trim($code);
        $code = explode("use", $code);

        $code = array_slice($code, 1);
        $useCode = array_map(function($item) {
            $item = trim($item);
            $item = str_replace("\n", '', $item);
            $item = str_replace(";", '', $item);

            return $item;
        }, $code);

        $useCode = implode(',', $useCode);
        $useCode = explode(',', $useCode);
        $useCollection = array_map('trim', $useCode);

//        $classCode = file_get_contents($classFilename);

        $useDictionary = [];
        foreach ($useCollection as $useString) {
            if (strpos($useString, ' as ') !== false) {
                $useData = explode(' as ', $useString);
                $useDictionary[$useData[1]] = $useData[0];

                continue;
            }

            if (strpos($useString, '\\') !== false) {
                $useChunks = explode('\\', $useString);

                $lastChunkIndex = count($useChunks) - 1;
                $key = $useChunks[$lastChunkIndex];
                $useDictionary[$key] = $useString;

                continue;
            }

            $useDictionary[$useString] = $useString;
        }

        $isArrayType = strpos($type, '[]') !== false;

        if ($isArrayType) {
            $type = str_replace('[]', '', $type);
        }

        $fullTypeName = $useDictionary[$type] ?? null;

        if (is_null($fullTypeName)) {
            $namespace = $reflectionObject->getNamespaceName();
            $className = $namespace . '\\' . $type;

            if (class_exists($className)) {
                $fullTypeName = $className;
            }
        }

        $type = $fullTypeName ?? $type;

        if ($isArrayType) {
            $type .= '[]';
        }

        return $type;
    }

    private function getVarDocValue(string $docComment) {
        $docArray = $this->toArray($docComment);
        $varDoc = null;

        foreach ($docArray as $docString) {
            if (strpos($docString, '@var ') === 0) {
                $varDoc = $docString;
                break;
            }
        }

        if (is_null($varDoc)) {
            return null;
        }

        $value = substr($varDoc, 5);
        $value = trim($value);

//        $validTypes = [
//            'int',
//            'integer',
//            'float',
//            'string',
//            'bool',
//            'boolean',
////            'array',
//        ];

        return $value;
    }
}
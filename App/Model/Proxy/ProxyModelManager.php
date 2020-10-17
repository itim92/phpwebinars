<?php


namespace App\Model\Proxy;


use App\Model\ModelAnalyzer;
use App\Utils\ReflectionUtil;

class ProxyModelManager
{

    /**
     * @var ModelAnalyzer
     * @onInit(App\Model\ModelAnalyzer)
     */
    private $modelAnalyzer;

    /**
     * @var ReflectionUtil
     * @onInit(App\Utils\ReflectionUtil)
     */
    private $reflectionUtil;

    public function getModelProxyClassName(string $modelClassName, bool $short = true) {
        $classNameChunks = explode('\\', $modelClassName);
        $modelClassNameShort = $classNameChunks[count($classNameChunks) - 1];
        $proxyClassName =  $modelClassNameShort . 'Proxy';

        if ($short == false) {
            $classNameChunks[count($classNameChunks) - 1] = $proxyClassName;
            $proxyClassName = implode('\\', $classNameChunks);
        }

        return $proxyClassName;
    }


    public function createProxy(string $modelClassName)
    {
//        echo "<pre>"; var_dump("App\Model\Proxy\ProxyModelManager.php : 14", $modelClassName); echo "</pre>";

        $classContent = [];
        $classContent[] = "<?php";

//        $namespace = __NAMESPACE__ . '\Cache';
        $reflectionClass = new \ReflectionClass($modelClassName);
        $namespace = $reflectionClass->getNamespaceName();
        $classContent[] = "";
        $classContent[] = "namespace $namespace;";

        $classContent[] = "";
//        $classContent[] = "use $modelClassName;";
//        $classContent[] = "";
        $useBlockDictionary = $this->reflectionUtil->getUseBlock($modelClassName);
        $useBlock = [];
        foreach ($useBlockDictionary as $alias => $class) {
            $useBlock[] = "use $class as $alias;";
        }
        $classContent[] = implode("\n", $useBlock);
        $classContent[] = "";
        $proxyClassName =  $this->getModelProxyClassName($modelClassName);
        $modelClassNameShort = $reflectionClass->getShortName();
        $classContent[] = "class $proxyClassName extends $modelClassNameShort {";

        $classContent[] = "\n";
        $classContent[] = "/** \n * @var $modelClassNameShort \n */";
        $classContent[] = 'private $model;';
        $classContent[] = "\n";

        $repositoryClass = $this->modelAnalyzer->getRepositoryForModelClass($modelClassName);
        $repositoryClassName = get_class($repositoryClass);
        $classContent[] = "/** \n * @var \\$repositoryClassName \n * @onInit($repositoryClassName) \n */";
        $classContent[] = 'private $repository;';

        $classContent[] = "\n";
        $classContent[] = $this->generateProxyMethods($modelClassName);
        $classContent[] = "\n";
        $classContent[] = $this->generateProxyUtils();

        $classContent[] = "}";

        $classContent = implode("\n", $classContent);
//        echo "<pre>"; var_dump("App\Model\Proxy\ProxyModelManager.php : 21"); echo "</pre>";
//        echo "<pre>$classContent</pre>";

        $proxyDirPath = APP_DIR . '/var/cache/proxy/' . str_replace('\\', '/', $reflectionClass->getNamespaceName() );
        $proxyFilename = $proxyDirPath . '/' . $proxyClassName . '.php';

        if (!file_exists($proxyDirPath)) {
            mkdir($proxyDirPath, 0777, true);
        }

        file_put_contents($proxyFilename, $classContent);
    }


    protected function generateProxyMethods(string $modelClassName): string {
        $result = [];

//        $this->fs->

        $reflectionClass = new \ReflectionClass($modelClassName);
        $reflectionMethods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

        $classFilename= $reflectionClass->getFileName();
        $modelClassSrc = file_get_contents($classFilename);
        $modelClassSrcArray = explode("\n", $modelClassSrc);

        foreach ($reflectionMethods as $reflectionMethod) {
            $methodName = $reflectionMethod->getName();
//            $result[] = "public function $methodName()";

            $ignoreMethods = [
                'getId',
                '__constructor',
                '__construct',
            ];

            if (in_array($methodName, $ignoreMethods)) {
                continue;
            }


            $methodInitString = trim($modelClassSrcArray[$reflectionMethod->getStartLine() - 1]);

            if (strpos($methodInitString, $methodName) === false) {
                continue;
            }

            $result[] = $methodInitString;
            $result[] = "{";

            $result[] = 'if (!$this->isModelInited()) $this->initModel();';

            if ($reflectionMethod->getReturnType()) {
                $reflectionProperties = $reflectionMethod->getParameters();

                $methodProperties = [];
                foreach ($reflectionProperties as $reflectionProperty) {
                    $methodProperties[] = '$' . $reflectionProperty->getName();
                }

                $result[] = 'return $this->model->' . $methodName . '(' . implode(',', $methodProperties) . ')' .';';
            }

            $result[] = "}";
            $result[] = "\n";

        }



        return implode("\n", $result);
    }


    protected function generateProxyUtils(): string {

        return "private function isModelInited() {\nreturn !is_null(\$this->model);\n}\nprivate function initModel() {\n\$id = \$this->getId();\n\$this->model = \$this->repository->find(\$id);\n}";

//        private function isModelInited() {
//            return !is_null($this->model);
//        }
//
//        private function initModel() {
//            $id = $this->getId();
//
//            $this->model = $this->repository->find($id);
//        }
    }
}
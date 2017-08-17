<?php
 
namespace ItForFree;
 
/**
 * Загрузчик файлов
 *
 * @author qwe
 */
class FileUploader 
{
     
    /**
     * Права доступа к папкам по умолчанию
     * @var int 
     */
    public $defaultFolderPermitions = 0777;
     
    /**
     * массив с относительными 
     * 
     * @var type 
     */
    public $uploadedFileNames = []; 
 
 
    /**
     * Загрузит файлы в папку с адресом 
     * $basePath + $addtionalPath
     *  --  и вернёт массив путей к файлам, начинающийся с $addtionalPath
     * 
     * @param type $files         -- массив в файлов как в $_FILES
     * @param type $basePath      -- Базовый путь (до $addtionalPath)
     * @param type $addtionalPath -- (без слэшэй в начале и конце) путь, начиная с которого нужно вернуть путь к загруженному файлу.
     * @return array              -- вернёт массив, в каждой сторке которого будет подмассив, содержащий два поля: 1) имя файла 2) путь к нему (от базовой директории загрузки)
     * @throws \Exception
     */
    public function uploadToRelativePath($files, $basePath, $addtionalPath)
    {
        //print_r($files); die();
        $result = [];
        foreach ($files['tmp_name']['files'] as $key => $tmpFileName)
        {
             
            if (!empty($tmpFileName)) {
                 
                $fileName = $files['name']['files'][$key];
                $pathFileName = str_replace(' ', '_', microtime()) . '_' . $fileName;
                $this->uploadFile($tmpFileName, $pathFileName, 
                         $basePath . '/' . $addtionalPath);
                $result[] = [
                     'filepath' => $addtionalPath . '/' . $pathFileName,
                     'filename' => $fileName
                ];
            } else {
                break;
            }
              
        }
         
        return $result;
    }
     
    /**
     * Загрузит один файл
     * 
     * @param type $tmpFileName
     * @param type $fileName
     * @param type $uploadDirPath
     * @throws \Exception
     */
    public function uploadFile($tmpFileName, $fileName, $uploadDirPath)
    {
        $this->createDirIfNotExists($uploadDirPath);
        $filePath = $uploadDirPath . '/' . $fileName;        
        if (!move_uploaded_file($tmpFileName, $filePath)) {
            throw new \Exception("Cannot upload file: " . $filePath);
        }
    }
     
     
    /**
     * Создаст папку и все подпапки, если конечной не существует
     * 
     * @param type $path
     */
    public function createDirIfNotExists($path)
    {
        //echo $path; die();
        if (!file_exists($path)) {
            mkdir($path, $this->defaultFolderPermitions, true); 
        }
    }
     
}
 
 
/**
 * Обычно загружаемый массив FILES выглядит как-то так:
 * Array
(
    [Comment] => Array
        (
            [name] => Array
                (
                    [files] => Array
                        (
                            [0] => Selection_004.png
                            [1] => Selection_005.png
                            [2] => Selection_007.png
                        )
 
                )
 
            [type] => Array
                (
                    [files] => Array
                        (
                            [0] => image/png
                            [1] => image/png
                            [2] => image/png
                        )
 
                )
 
            [tmp_name] => Array
                (
                    [files] => Array
                        (
                            [0] => /tmp/phpIUQzTI
                            [1] => /tmp/php8dKMhE
                            [2] => /tmp/phpvpe2Fz
                        )
 
                )
 
            [error] => Array
                (
                    [files] => Array
                        (
                            [0] => 0
                            [1] => 0
                            [2] => 0
                        )
 
                )
 
            [size] => Array
                (
                    [files] => Array
                        (
                            [0] => 97396
                            [1] => 120669
                            [2] => 496772
                        )
 
                )
 
        )
 
)
 */
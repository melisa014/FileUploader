# FileUploader

Возможности:
* Загрузка файлов на сервер
*
* 


## Примеры использования

Пример вызова из Yii2 (сам класс загрузчика не зависит от какого-либо фраймворка):
```php
$additionalPath = 'uploads/' . $collectionName . '/'
	.  date("Y")  . '/' .  date("m") . '/' 
	.  date("d")  . '/' .  $reportId;
$uploader = new FileUploader();
$uploadedFiles = $uploader->uploadToRelativePath($_FILES['Comment'], 
	\Yii::getAlias('@webroot'), $additionalPath);

```

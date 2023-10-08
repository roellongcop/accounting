<?php

namespace app\widgets;

use Yii;
use app\helpers\FileHelper;
use app\helpers\Url;
use app\helpers\App;
use app\models\File;


class FileExplorer extends BaseWidget
{
    public $template = 'index';
    public $path;
    public $directories = [];
    public $files = [];
    public $reloadUrl = ['file/browse'];
    public $addFolderUrl = ['file/add-folder'];
    public $folderImage = 'default/file-explorer/folder-icon.png';
    public $addFolderImage = 'default/file-explorer/create-folder-icon.png';
    public $breadcrumbs = [
        [
            'folderName' => 'Clients',
            'folderPath' => ''
        ]
    ];
    public $tag = 'tag';
    public $webRoot = '@webroot/clients';

    public function init()
    {
        parent::init();
        $identity = App::identity();

        $this->webRoot = $identity->getClientWebroot($this->tag);
        
        if ($identity->isClient) {
            $this->breadcrumbs = [
                [
                    'folderName' => $identity->email,
                    'folderPath' => ''
                ]
            ];
        }

        $this->path = $this->path ?: (App::get('path') ?: '');

        if (! Url::isLink($this->folderImage)) {
            $this->folderImage = App::baseUrl($this->folderImage);
        }

        if (! Url::isLink($this->addFolderImage)) {
            $this->addFolderImage = App::baseUrl($this->addFolderImage);
        }

        $this->reloadUrl = Url::to($this->reloadUrl);
        $this->addFolderUrl = Url::to($this->addFolderUrl);

        $path = FileHelper::normalizePath($this->path);
        $path = FileHelper::normalizePath(implode(DIRECTORY_SEPARATOR, [
            Yii::getAlias($this->webRoot),
            $path
        ]));

       $this->generateBreadcrumbs($path);


        $directories = FileHelper::findDirectories($path, ['recursive' => false]);

        $_this = $this;
        $files = FileHelper::findFiles($path, [
            'recursive' => false,
            'filter' => function($path) use ($_this) {
                $exp = explode(DIRECTORY_SEPARATOR, $path);

                $file = File::find()
                    ->select(['*', 'SUBSTRING_INDEX(location, "/", -1) AS folderFileName'])
                    ->where(['SUBSTRING_INDEX(location, "/", -1)' => end($exp)])
                    ->one();

                if (!$file) {
                    return false;
                }

                $_this->files[] = $file;
                return true;

                $hideFiles = ['.htaccess', 'index.php'];
                return ! in_array(end($file), $hideFiles);
            }
        ]);

        $this->formatDirectories($directories);
    }

    public function generateBreadcrumbs($path)
    {
        $replace = Yii::getAlias($this->webRoot);
        $lastChar = substr($path, -1);
        if ($lastChar == DIRECTORY_SEPARATOR) {
            $replace = $replace . DIRECTORY_SEPARATOR;
        }

        $_path = str_replace(FileHelper::normalizePath($replace), '', $path);

        if ($_path) {
            $explodePath = explode(DIRECTORY_SEPARATOR, $_path);
            $breadcrumbs = $this->breadcrumbs;

            $currentPath = [];
            
            foreach ($explodePath as $xp) {
                if ($xp) {
                    $currentPath[] = $xp;
                    $breadcrumbs[] = [
                        'folderName' => $xp,
                        'folderPath' => FileHelper::normalizePath(implode(DIRECTORY_SEPARATOR, $currentPath)),
                    ];
                }
            }

            $this->breadcrumbs = $breadcrumbs;
        }
    }

    public function formatDirectories($directories)
    {
        $_directories = [];
        foreach ($directories as $directories) {
            $exp = explode(DIRECTORY_SEPARATOR, FileHelper::normalizePath($directories));
            $path = str_replace(
                FileHelper::normalizePath(Yii::getAlias($this->webRoot)) . DIRECTORY_SEPARATOR, 
                '', 
                FileHelper::normalizePath($directories)
            );

            $files = FileHelper::findFiles($directories, [
                'recursive' => false,
                'filter' => function($path) {
                    $exp = explode(DIRECTORY_SEPARATOR, $path);

                    $file = File::find()
                        ->select(['*', 'SUBSTRING_INDEX(location, "/", -1) AS folderFileName'])
                        ->where(['SUBSTRING_INDEX(location, "/", -1)' => end($exp)])
                        ->one();

                    if (!$file) {
                        return false;
                    }
                    return true;

                    $hideFiles = ['.htaccess', 'index.php'];
                    return ! in_array(end($file), $hideFiles);
                }
            ]);

            $folders = FileHelper::findDirectories($directories, ['recursive' => false]);


            $_directories[end($exp)] = [
                'fullpath' => FileHelper::normalizePath($directories),
                'path' => $path,
                'files' => $files,
                'folders' => $folders,
                'total_documents' => count($files) + count($folders)
            ];
        }
        $this->directories = $_directories;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render("file-explorer/{$this->template}", [
            'directories' => $this->directories,
            'files' => $this->files,
            'reloadUrl' => $this->reloadUrl,
            'addFolderUrl' => $this->addFolderUrl,
            'breadcrumbs' => $this->breadcrumbs,
            'path' => $this->path,
            'folderImage' => $this->folderImage,
            'addFolderImage' => $this->addFolderImage,
            'tag' => $this->tag,
        ]);
    }
}
